<?php
/**
 * Alert Messages Section
 * Displays session-based flash messages (success, error, info)
 * Reusable across all pages
 */
?>

<?php if (isset($_SESSION['success'])): ?>
    <div class="position-fixed top-0 start-50 translate-middle-x mt-5 pt-5 floating-alert-container">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <?= htmlspecialchars($_SESSION['success']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="position-fixed top-0 start-50 translate-middle-x mt-5 pt-5 floating-alert-container">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <?= htmlspecialchars($_SESSION['error']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['info'])): ?>
    <div class="position-fixed top-0 start-50 translate-middle-x mt-5 pt-5 floating-alert-container">
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <i class="bi bi-info-circle-fill me-2"></i>
            <?= htmlspecialchars($_SESSION['info']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
    <?php unset($_SESSION['info']); ?>
<?php endif; ?>
