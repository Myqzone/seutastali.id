<?php
/**
 * Seutastali Watermark Partial
 * Reusable full-width bottom branding bar.
 */
?>
<!-- Reusable Encapsulated Watermark Styles -->
<style>
.invitation-watermark-bar {
  width: 100%;
  background-color: var(--theme-dark, #1e2d1f); /* Rich theme dark color matching the theme's dark accent */
  padding: 18px 0;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px; /* Standard spacing between text and logo */
  position: relative;
  z-index: 100; /* Stays above all normal section cards but below the 9999 cover-scene */
  margin-top: 40px; /* Space before the bar */
  font-family: "Manrope", sans-serif !important;
}

.invitation-watermark-powered-text {
  color: var(--theme-bg, #f5ede4);
  font-size: 12px;
  font-family: "Manrope", sans-serif !important;
  letter-spacing: 0.5px;
  line-height: 1; /* Reset line height to prevent vertical alignment offsets */
}

.invitation-watermark-bar a {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  line-height: 1;
  transition: opacity 0.2s;
}

.invitation-watermark-bar a:hover {
  opacity: 0.85;
}

.invitation-watermark-bar img {
  height: 22px;
  width: auto;
  object-fit: contain;
  display: block; /* Eliminate bottom inline spacing */
}
</style>

<div class="invitation-watermark-bar">
  <span class="invitation-watermark-powered-text">Powered by</span>
  <a href="https://seutastali.id" target="_blank" rel="noopener noreferrer">
    <img src="../../assets/media/logo/logo-full-sand.webp" alt="Seutastali logo">
  </a>
</div>
