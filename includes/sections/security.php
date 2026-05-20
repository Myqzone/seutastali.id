<?php
/**
 * Seutastali Global Template Protection & Anti-Theft Security Shield
 * Location: /includes/sections/security.php
 * Prevents: Right-Click Inspect, View Source, DevTools Shortcuts, Image Stealing, Text/Code Copypasta
 */
?>

<!-- 🛡️ SEUTASTALI SECURITY SHIELD: STYLING PROTECTIONS -->
<style>
    /* Prevent direct user selection on body and visual assets */
    body, html {
        -webkit-user-select: none !important;
        -moz-user-select: none !important;
        -ms-user-select: none !important;
        user-select: none !important;
        -webkit-touch-callout: none !important;
    }

    /* Target images, SVGs, and logos to prevent selection and dragging */
    img, svg, picture, .neubrutal-card img {
        -webkit-user-select: none !important;
        -moz-user-select: none !important;
        -ms-user-select: none !important;
        user-select: none !important;
        -webkit-user-drag: none !important;
        user-drag: none !important;
        -webkit-touch-callout: none !important;
    }

    /* EXEMPTION: Allow normal selection and typing inside actual form controls, inputs, and the editor drawer */
    input, textarea, select, option, .floating-tracker-container, .modal, [contenteditable="true"] {
        -webkit-user-select: text !important;
        -moz-user-select: text !important;
        -ms-user-select: text !important;
        user-select: text !important;
        pointer-events: auto !important;
    }
</style>

<!-- 🛡️ SEUTASTALI SECURITY SHIELD: SCRIPT PROTECTIONS -->
<script>
    (function() {
        'use strict';

        // 1. Block F12 Key (Toggle Developer Tools)
        document.addEventListener('keydown', function(e) {
            if (e.keyCode === 123 || e.key === 'F12') {
                e.preventDefault();
                return false;
            }
        }, false);

    })();
</script>
