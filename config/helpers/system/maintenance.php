<?php

/**
 * Maintenance Mode Helper
 * Location: config/helpers/system/maintenance.php
 */

/**
 * Check if maintenance mode is active
 * @param string|null $page If provided, checks if a specific page is in maintenance. If null, checks global.
 */
function is_maintenance_mode($page = null, $db_conn = null)
{
  global $conn;
  $db = $db_conn ?: $conn;

  if (!$db || (isset($db->connect_error) && $db->connect_error)) {
    return false;
  }

  try {
    // 1. Check Global Maintenance First
    $queryString = "SELECT config_value FROM web_config WHERE config_key = 'maintenance_mode' LIMIT 1";
    $result = $db->query($queryString);

    $is_global = false;
    if ($result && $result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $is_global = ($row['config_value'] === '1' || $row['config_value'] === 'true');
    }

    if ($is_global) return true;

    // 2. Check Specific Page Maintenance
    if ($page !== null) {
      $pages = get_maintenance_pages($db);
      return in_array($page, $pages);
    }
  } catch (Exception $e) {
    return false;
  }

  return false;
}

/**
 * Get list of pages in maintenance
 */
function get_maintenance_pages($db_conn = null)
{
  global $conn;
  $db = $db_conn ?: $conn;

  if (!$db) return [];

  try {
    $queryString = "SELECT config_value FROM web_config WHERE config_key = 'maintenance_pages' LIMIT 1";
    $result = $db->query($queryString);

    if ($result && $result->num_rows > 0) {
      $row = $result->fetch_assoc();
      return !empty($row['config_value']) ? explode(',', $row['config_value']) : [];
    }
  } catch (Exception $e) {
    return [];
  }

  return [];
}

/**
 * Get maintenance message
 */
function get_maintenance_message($db_conn = null)
{
  global $conn;
  $db = $db_conn ?: $conn;

  if (!$db || (isset($db->connect_error) && $db->connect_error)) {
    return 'Website sedang dalam pemeliharaan. Silakan coba beberapa saat lagi.';
  }

  try {
    $queryString = "SELECT config_value FROM web_config WHERE config_key = 'maintenance_message' LIMIT 1";
    $result = $db->query($queryString);

    if ($result && $result->num_rows > 0) {
      $row = $result->fetch_assoc();
      return $row['config_value'] ?: 'Website sedang dalam pemeliharaan. Silakan coba beberapa saat lagi.';
    }
  } catch (Exception $e) {
    return 'Website sedang dalam pemeliharaan. Silakan coba beberapa saat lagi.';
  }

  return 'Website sedang dalam pemeliharaan. Silakan coba beberapa saat lagi.';
}

/**
 * Toggle maintenance mode
 */
function toggle_maintenance_mode($status, $message = '', $pages = [], $db_conn = null)
{
  global $conn;
  $db = $db_conn ?: $conn;

  if (!$db || (isset($db->connect_error) && $db->connect_error)) {
    return false;
  }

  try {
    $mode = $status ? '1' : '0';
    $pages_csv = is_array($pages) ? implode(',', $pages) : $pages;
    $safe_msg = !empty($message) ? $db->real_escape_string($message) : 'Website sedang dalam pemeliharaan. Silakan coba beberapa saat lagi.';
    $safe_pages = $db->real_escape_string($pages_csv);

    $configs = [
      'maintenance_mode' => $mode,
      'maintenance_message' => $safe_msg,
      'maintenance_pages' => $safe_pages
    ];

    foreach ($configs as $key => $value) {
      // Check if exists
      $check = $db->query("SELECT id FROM web_config WHERE config_key = '$key' LIMIT 1");
      if ($check && $check->num_rows > 0) {
        $row = $check->fetch_assoc();
        $id = $row['id'];
        $db->query("UPDATE web_config SET config_value = '$value' WHERE id = $id");
      } else {
        $db->query("INSERT INTO web_config (config_key, config_value, config_type) VALUES ('$key', '$value', 'text')");
      }
    }

    return true;
  } catch (Exception $e) {
    error_log("Maintenance toggle exception: " . $e->getMessage());
    return false;
  }
}

/**
 * Auto-checker for Maintenance Mode
 * Only runs if the file is called directly or included
 */
if (!isset($skip_maintenance_check) || !$skip_maintenance_check) {
  // Only check maintenance if not in app folder (handled by bootstrap etc) and not accessing maintenance page directly
  if (!isset($_GET['maintenance']) && !isset($_GET['api'])) {
    $currentFile = basename($_SERVER['SCRIPT_FILENAME']);
    $skipCheck = ['maintenance.php', 'error.php', 'login.php', 'logout.php', 'maintenance.php']; // Self check

    if (!in_array($currentFile, $skipCheck) && isset($conn)) {
      if (function_exists('is_maintenance_mode')) {
        $is_maint = is_maintenance_mode($currentFile, $conn);

        if ($is_maint) {
          // Bypass maintenance mode if user is a developer/admin
          $is_dev = false;

          // Start session if not already started
          if (session_status() === PHP_SESSION_NONE) {
            session_start();
          }

          if (isset($_SESSION['user_role']) && in_array($_SESSION['user_role'], ['developer', 'admin'])) {
            $is_dev = true;
          }

          if (!$is_dev) {
            // Render maintenance page directly (don't 301/302 redirect)
            http_response_code(503);
            require_once ROOT_PATH . 'errors/system-down.php';
            exit;
          }
        }
      }
    }
  }
}
