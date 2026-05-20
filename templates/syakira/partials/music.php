<?php
/**
 * Seutastali Music Player & Floating Control Button Partial
 * Reusable self-contained music module.
 */
$bg_music = $bg_music ?? 'romantic-wedding.mp3';
?>
<!-- Reusable Encapsulated Music Styles -->
<style>
.music-control-btn {
  position: fixed;
  bottom: 24px;
  right: 24px;
  width: 46px;
  height: 46px;
  border-radius: 50%;
  background-color: var(--theme-accent-dark, #5b6b53);
  color: #fff;
  border: 2px solid var(--theme-dark, #1e2d1f);
  box-shadow: 4px 4px 0 var(--theme-dark, #1e2d1f);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 9999;
  cursor: pointer;
  outline: none;
  font-size: 1.2rem;
  transition: transform 0.2s, box-shadow 0.2s;
}

.music-control-btn:active {
  transform: translate(2px, 2px);
  box-shadow: 2px 2px 0 var(--theme-dark, #1e2d1f);
}

.music-control-btn.muted i {
  animation: none !important;
}
</style>

<!-- Background Music Player -->
<audio id="bgMusic" loop preload="auto">
  <source src="<?= ASSETS_URL ?>media/music/<?= $bg_music ?>" type="audio/mpeg">
</audio>

<!-- Floating Music Control Button (Play/Pause/Mute) -->
<button class="music-control-btn d-none" id="musicControlBtn" aria-label="Mute Music">
  <i class="fa-solid fa-compact-disc fa-spin"></i>
</button>
