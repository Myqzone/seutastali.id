<?php

/**
 * Config Management Helper Functions
 * Location: config/helpers/content/web-config.php
 */

if (!function_exists('get_config')) {
    /**
     * Get configuration value dari web_config table
     * @param string $key Config key
     * @param mixed $default Default value jika tidak ditemukan
     * @return mixed Config value atau default
     */
    function get_config($conn, $key, $default = null)
    {
        try {
            $stmt = $conn->prepare("SELECT config_value FROM web_config WHERE config_key = ? AND is_active = 1");
            $stmt->bind_param('s', $key);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                return $row['config_value'];
            }
            return $default;
        } catch (Exception $e) {
            error_log('get_config error: ' . $e->getMessage());
            return $default;
        }
    }
}

if (!function_exists('update_config')) {
    /**
     * Update atau insert configuration value
     * @param object $conn DB connection
     * @param string $key Config key
     * @param mixed $value Config value
     * @param string $type Config type (text, color, number, json, html)
     * @return bool Success status
     */
    function update_config($conn, $key, $value, $type = 'text')
    {
        try {
            // Check if exists
            $check = $conn->prepare("SELECT id FROM web_config WHERE config_key = ?");
            $check->bind_param('s', $key);
            $check->execute();
            $exists = $check->get_result()->num_rows > 0;

            if ($exists) {
                // Update
                $stmt = $conn->prepare("UPDATE web_config SET config_value = ?, config_type = ? WHERE config_key = ?");
                $stmt->bind_param('sss', $value, $type, $key);
            } else {
                // Insert
                $stmt = $conn->prepare("INSERT INTO web_config (config_key, config_value, config_type) VALUES (?, ?, ?)");
                $stmt->bind_param('sss', $key, $value, $type);
            }

            return $stmt->execute();
        } catch (Exception $e) {
            error_log('update_config error: ' . $e->getMessage());
            return false;
        }
    }
}

if (!function_exists('get_all_config')) {
    /**
     * Get semua configuration aktif
     * @param object $conn DB connection
     * @return array Array config dalam format key => value
     */
    function get_all_config($conn)
    {
        try {
            $result = $conn->query("SELECT config_key, config_value FROM web_config WHERE is_active = 1");
            $config = [];

            while ($row = $result->fetch_assoc()) {
                $config[$row['config_key']] = $row['config_value'];
            }

            return $config;
        } catch (Exception $e) {
            error_log('get_all_config error: ' . $e->getMessage());
            return [];
        }
    }
}

if (!function_exists('delete_config')) {
    /**
     * Soft delete configuration (set is_active = 0)
     * @param object $conn DB connection
     * @param string $key Config key
     * @return bool Success status
     */
    function delete_config($conn, $key)
    {
        try {
            $stmt = $conn->prepare("UPDATE web_config SET is_active = 0, updated_at = NOW() WHERE config_key = ?");
            $stmt->bind_param('s', $key);
            return $stmt->execute();
        } catch (Exception $e) {
            error_log('delete_config error: ' . $e->getMessage());
            return false;
        }
    }
}
