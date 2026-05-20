/**
 * ============================================================
 * SEUTASTALI HERO MARQUEE SLIDER CONTROL
 * ============================================================
 */

$(document).ready(function () {
  const $track = $(".hero-slider-track");
  if (!$track.length) return;

  // Premium UX Micro-interaction: Pause running marquee scroll on card hover
  $track.on("mouseenter", function () {
    $(this).css("animation-play-state", "paused");
  }).on("mouseleave", function () {
    $(this).css("animation-play-state", "running");
  });
});
