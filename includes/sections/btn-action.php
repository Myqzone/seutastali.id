<?php
/**
 * Consolidated Floating Action Stack (Scroll to Top Only)
 * Location: /includes/sections/btn-action.php
 */
?>

<!-- Unified Floating Action Stack Styles -->
<style>
    .floating-action-stack {
        position: fixed !important;
        right: 24px !important;
        bottom: 24px !important;
        z-index: 1025 !important;
        display: flex !important;
        flex-direction: column !important;
        align-items: flex-end !important;
        gap: 12px !important;
        pointer-events: none !important;
        transition: bottom 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }

    .floating-action-stack .btn {
        pointer-events: auto !important;
    }

    @media (max-width: 768px) {
        .floating-action-stack {
            bottom: 16px !important;
            right: 16px !important;
        }
    }

    /* Unified Circular Styles for Scroll-to-Top */
    .floating-action-stack .btn-scroll-totop-custom {
        background-color: var(--c-primary) !important;
        color: #ffffff !important;
        width: 60px !important;
        height: 60px !important;
        border-radius: 50% !important;
        border: none !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
        transition: all 0.2s ease-in-out !important;
        padding: 0 !important;
    }

    /* Clean, centered alignment for Scroll-To-Top icon */
    .floating-action-stack .btn-scroll-totop-custom .material-icons {
        font-size: 35px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
    }

    /* Scroll-to-Top display state managed by static.js toggle */
    .floating-action-stack .btn-scroll-totop-custom {
        display: none !important;
    }

    .floating-action-stack .btn-scroll-totop-custom.show {
        display: inline-flex !important;
        opacity: 1 !important;
        animation: scrollTopBounce 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards !important;
    }

    /* Identical hover and active feedback */
    .floating-action-stack .btn-scroll-totop-custom:hover {
        background-color: var(--c-primary-darker, #2a060a) !important;
        transform: translateY(-2px) !important;
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2) !important;
        color: #ffffff !important;
    }

    .floating-action-stack .btn-scroll-totop-custom:active {
        transform: translateY(1px) !important;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1) !important;
    }

    /* Responsive circular adjustment for mobile */
    @media (max-width: 768px) {
        .floating-action-stack .btn-scroll-totop-custom {
            width: 50px !important;
            height: 50px !important;
        }

        .floating-action-stack .btn-scroll-totop-custom .material-icons {
            font-size: 28px !important;
        }
    }
</style>

<div class="floating-action-stack">
    <!-- 1. Scroll To Top Button -->
    <button class="btn btn-scroll-totop-custom rounded-pill" id="scrollToTopBtn" aria-label="Kembali ke atas">
        <span class="material-icons">keyboard_arrow_up</span>
    </button>
</div>