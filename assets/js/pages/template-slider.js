/**
 * ============================================================
 * SEUTASTALI TEMPLATE SLIDER CONTROL (Splide.js Powered)
 * ============================================================
 */

$(document).ready(function () {
  const $track = $("#templateSliderTrack");
  if (!$track.length) return;

  // Clone and save all original template items for robust category filtering
  const $allItems = $track.find(".template-grid-item").clone();
  let activeCategory = "all";
  let splideInstance = null;

  // Initialize Splide with premium responsive configurations
  function initCarousel() {
    if (splideInstance) {
      splideInstance.destroy(true);
    }

    splideInstance = new Splide('#templateSliderTrack', {
      type: 'slide',
      arrows: false,      // We use our own customized transparent arrow buttons!
      pagination: false,  // We do not use dots
      drag: true,         // Allows touch/mouse swiping
      speed: 300,         // Clean, modern transition speed
      perPage: 4,         // 4 items on desktop
      perMove: 1,
      gap: '10px',        // Gap between items
      breakpoints: {
        768: {
          perPage: 2,     // 2 items on mobile
          gap: '10px'
        },
        992: {
          perPage: 3,     // 3 items on tablet
          gap: '15px'
        }
      }
    });

    // Listen to mounted and slide events to update navigation buttons
    splideInstance.on('mounted moved updated', updateNavButtons);
    splideInstance.mount();

    // Premium hover navigation buttons actions
    $("#templateSliderPrev")
      .off("click")
      .on("click", function () {
        if (splideInstance) splideInstance.go('<');
      });
    $("#templateSliderNext")
      .off("click")
      .on("click", function () {
        if (splideInstance) splideInstance.go('>');
      });
  }

  // Handle transparent arrow buttons dynamic show/hide boundaries
  function updateNavButtons() {
    if (!splideInstance) return;

    const currentIndex = splideInstance.index;
    const length = splideInstance.length;
    const perPage = splideInstance.options.perPage || 4;

    // Show/hide prev button based on start bound
    if (currentIndex <= 0) {
      $("#templateSliderPrev")
        .css("opacity", "0")
        .css("pointer-events", "none");
    } else {
      $("#templateSliderPrev")
        .css("opacity", "1")
        .css("pointer-events", "auto");
    }

    // Show/hide next button based on end bound
    if (currentIndex + perPage >= length) {
      $("#templateSliderNext")
        .css("opacity", "0")
        .css("pointer-events", "none");
    } else {
      $("#templateSliderNext")
        .css("opacity", "1")
        .css("pointer-events", "auto");
    }
  }

  // Dynamically filter templates when user clicks category tabs
  function filterTemplates() {
    // Destroy current Splide instance safely
    if (splideInstance) {
      splideInstance.destroy(true);
    }

    // Empty the list wrapper inside the track
    const $list = $track.find(".splide__list");
    $list.empty();

    // Loop through cloned originals and append matches
    $allItems.each(function () {
      const $item = $(this);
      const category = $item.data("category").toLowerCase();
      const isPopular =
        $item.data("popular") === true || $item.data("popular") === "true";

      let isMatch = false;
      if (activeCategory === "all") {
        isMatch = true;
      } else if (activeCategory === "populer") {
        isMatch = isPopular;
      } else {
        isMatch = category === activeCategory;
      }

      if (isMatch) {
        $list.append($item.clone());
      }
    });

    // Re-initialize Splide on the new DOM subset
    initCarousel();
  }

  // Category Tab Button Click Handler (Instant 0ms Switch)
  $(".category-tab-btn").on("click", function () {
    const $btn = $(this);
    if ($btn.hasClass("btn-primary")) return; // Already active

    // Update active tab styling classes
    $(".category-tab-btn")
      .removeClass("btn-primary")
      .addClass("btn-outline-primary");
    $btn.removeClass("btn-outline-primary").addClass("btn-primary");

    // Filter templates instantly
    activeCategory = $btn.data("category").toLowerCase();
    filterTemplates();
  });

  // Initial startup call
  initCarousel();
});
