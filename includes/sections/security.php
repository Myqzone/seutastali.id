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

    /* Target images, SVGs, and logos to block dragging and saving completely */
    img, svg, picture, .neubrutal-card img {
        -webkit-user-select: none !important;
        -moz-user-select: none !important;
        -ms-user-select: none !important;
        user-select: none !important;
        -webkit-user-drag: none !important;
        user-drag: none !important;
        -webkit-touch-callout: none !important;
        pointer-events: none !important; /* Makes images click-through to prevent right-click targets */
    }

    /* EXEMPTION: Allow normal selection and typing inside actual form controls, inputs, and the editor drawer */
    input, textarea, select, option, .dreamboard-drawer, .modal, [contenteditable="true"] {
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

        // 1. Disable Right-Click Globally (Context Menu)
        document.addEventListener('contextmenu', function(e) {
            // Allow right-click ONLY on inputs/textareas for normal clipboard actions
            const tag = e.target.tagName.toLowerCase();
            if (tag === 'input' || tag === 'textarea') {
                return;
            }
            e.preventDefault();
        }, false);

        // 2. Disable Image Dragging
        document.addEventListener('dragstart', function(e) {
            if (e.target.tagName.toLowerCase() === 'img') {
                e.preventDefault();
            }
        }, false);

        // 3. Block Inspection and Source-Viewing Keyboard Shortcuts
        document.addEventListener('keydown', function(e) {
            
            // F12 key (Toggle Developer Tools)
            if (e.keyCode === 123) {
                e.preventDefault();
                return false;
            }

            // Ctrl + Shift + I (Inspect)
            if (e.ctrlKey && e.shiftKey && e.keyCode === 73) {
                e.preventDefault();
                return false;
            }

            // Ctrl + Shift + J (Console)
            if (e.ctrlKey && e.shiftKey && e.keyCode === 74) {
                e.preventDefault();
                return false;
            }

            // Ctrl + Shift + C (Inspect element selector)
            if (e.ctrlKey && e.shiftKey && e.keyCode === 67) {
                e.preventDefault();
                return false;
            }

            // Ctrl + U (View Page Source)
            if (e.ctrlKey && e.keyCode === 85) {
                e.preventDefault();
                return false;
            }

            // Ctrl + S (Save Page Offline)
            if (e.ctrlKey && e.keyCode === 83) {
                e.preventDefault();
                return false;
            }

            // Ctrl + P (Print Page)
            if (e.ctrlKey && e.keyCode === 80) {
                e.preventDefault();
                return false;
            }
            
        }, false);

        // 4. Premium Console Guard: Clear Console continuously & freeze malicious inspector debugging
        setInterval(function() {
            if (window.console && window.console.clear) {
                window.console.clear();
            }
        }, 1000);

        // Anti-debugging loop: Trigger debugger pause only if developer tools are forced open
        setInterval(function() {
            const startTime = performance.now();
            debugger; // This pauses debugger execution if Inspector is open
            const endTime = performance.now();
            if (endTime - startTime > 100) {
                // Detected open DevTools! Instantly redirect to landing or notify
                console.warn('Developer tools detected. Unauthorized inspection is prohibited.');
            }
        }, 500);

    })();
</script>
