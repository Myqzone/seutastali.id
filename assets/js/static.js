if ("scrollRestoration" in history) {
  history.scrollRestoration = "manual";
}

const LOADER_MIN_DURATION = 200; // Snappy 200ms minimum duration
const LOADER_MAX_WAIT = 3000; // Force hide after 3s max
const loaderStartTime = Date.now();

// Set initial loading state
const pageLoaderElement = document.getElementById("pageLoader");
if (pageLoaderElement) {
  document.documentElement.classList.add("loading");
  document.body.classList.add("loading");
}

function hideLoader() {
  const loader = document.getElementById("pageLoader");
  if (!loader || loader.dataset.hidden) return;

  window.scrollTo(0, 0);
  loader.dataset.hidden = "true";
  const elapsed = Date.now() - loaderStartTime;
  const remaining = Math.max(0, LOADER_MIN_DURATION - elapsed);

  setTimeout(() => {
    loader.style.opacity = "0";
    setTimeout(() => {
      loader.remove();
      unlockScroll();
    }, 300); // 200ms transition time
  }, remaining);
}

// Fallback: Force hide if it takes too long
setTimeout(hideLoader, LOADER_MAX_WAIT);

// Hide as soon as HTML is ready rather than waiting for large external images/assets
if (document.readyState === "loading") {
  document.addEventListener("DOMContentLoaded", hideLoader);
} else {
  hideLoader();
}

function unlockScroll() {
  document.documentElement.classList.remove("loading");
  document.body.classList.remove("loading");

  // Final fallback for jQuery owlCarousel if it somehow failed
  if (typeof jQuery !== "undefined" && !jQuery.fn.owlCarousel) {
    jQuery.fn.owlCarousel = function () {
      return this;
    };
  }
}

/* =====================================================
    NAVIGATION: SCROLL & HEADER LOGIC
   ===================================================== */

document.addEventListener("DOMContentLoaded", () => {
  const header = document.querySelector("header");
  const sections = document.querySelectorAll("section[id]");
  const scrollToTopBtn = document.getElementById("scrollToTopBtn");
  const navLinks = document.querySelectorAll(
    ".nav-link.scroll-link, .mobile-nav a",
  );

  /* SMOOTH SCROLL */
  navLinks.forEach((link) => {
    link.addEventListener("click", (e) => {
      const href = link.getAttribute("href");
      if (!href || !href.startsWith("#")) return;

      e.preventDefault();
      // closeMobileMenu(); // Will be handled if mobile-menu.js is loaded

      const target = document.querySelector(href);
      if (!target) return;

      const offset = header?.offsetHeight || 100;
      window.scrollTo({
        top: target.offsetTop - offset,
        behavior: "smooth",
      });
    });
  });

  /* SCROLL HANDLER (HEADER) */
  const handleScroll = () => {
    const scrollY = window.pageYOffset || document.documentElement.scrollTop;

    header?.classList.toggle("fixed-header", scrollY >= 50);
    header?.classList.toggle("hide-topbar", scrollY >= 50);
    scrollToTopBtn?.classList.toggle("show", scrollY > 300);
  };

  window.addEventListener("scroll", handleScroll);
  handleScroll();

  /* AUTO-CLOSE MOBILE MENU ON RESIZE */
  window.addEventListener("resize", () => {
    if (window.innerWidth >= 1200) {
      const mobileMenuModal = document.getElementById("mobileMenuModal");
      if (mobileMenuModal && mobileMenuModal.classList.contains("show")) {
        const modalInstance = bootstrap.Modal.getInstance(mobileMenuModal);
        if (modalInstance) modalInstance.hide();
      }
    }
  });

  /* BACK TO TOP */
  scrollToTopBtn?.addEventListener("click", (e) => {
    e.preventDefault();
    window.scrollTo({ top: 0, behavior: "smooth" });
  });
});

/* =====================================================
    UI: COMPONENTS & INTERACTIVE LOGIC
   ===================================================== */

$(document).ready(function () {
  /* TESTIMONIAL READ MORE */
  $(document).on("click", ".read-more", function () {
    const btn = $(this);
    const text = btn.prev(".testimonial-text");
    text.toggleClass("clamp");
    btn.text(text.hasClass("clamp") ? "Read More" : "Read Less");
  });

});


/* COUNTER VALUE ANIMATION */
document.addEventListener("DOMContentLoaded", () => {
  const counterValues = document.querySelectorAll(".counter-value");
  const countUpObserver = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) return;

        const el = entry.target;
        if (el.dataset.done) return;

        const target = parseFloat(el.dataset.target);
        const decimals = parseInt(el.dataset.decimals || "0");
        const duration = 2000; // 2 seconds animation duration
        const startTime = performance.now();

        const animate = (currentTime) => {
          const elapsed = currentTime - startTime;
          const progress = Math.min(elapsed / duration, 1);

          // Easing function: easeOutQuad (starts fast, slows down smoothly)
          const easeProgress = progress * (2 - progress);
          const currentValue = easeProgress * target;

          // Format with Indonesian comma for decimal separator
          let formattedValue = currentValue.toFixed(decimals);
          formattedValue = formattedValue.replace(".", ",");

          el.innerHTML = formattedValue;

          if (progress < 1) {
            requestAnimationFrame(animate);
          } else {
            el.innerHTML = target.toString().replace(".", ",");
            el.dataset.done = "true";
          }
        };

        requestAnimationFrame(animate);
        countUpObserver.unobserve(el);
      });
    },
    { threshold: 0.5 },
  );

  counterValues.forEach((counter) => countUpObserver.observe(counter));

  /* AOS & TOOLTIPS (Snappy & Responsive Initialization) */
  if (typeof AOS !== "undefined") {
    AOS.init({
      once: true,
      mirror: false,
      duration: 500, // Snappy fade duration
    });
  }

  document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach((el) => {
    new bootstrap.Tooltip(el);
  });
});

/* BANNER SWIPE LOGIC */
function initBannerSwipe(bannerOwl) {
  const wrapper = document.querySelector(".banner-slider-wrapper");
  if (!wrapper || !bannerOwl) return;

  let startX = 0;
  let isDragging = false;
  const threshold = 50;

  const handleSwipe = (endX) => {
    const distance = endX - startX;
    if (Math.abs(distance) > threshold) {
      bannerOwl.trigger(
        distance < 0 ? "next.owl.carousel" : "prev.owl.carousel",
      );
    }
  };

  wrapper.addEventListener(
    "touchstart",
    (e) => {
      startX = e.touches[0].clientX;
      isDragging = true;
    },
    { passive: true },
  );
  wrapper.addEventListener(
    "touchend",
    (e) => {
      if (!isDragging) return;
      handleSwipe(e.changedTouches[0].clientX);
      isDragging = false;
    },
    { passive: true },
  );
}

/* =====================================================
    MOBILE MENU: LOGIC & DRAG-TO-CLOSE
   ===================================================== */

document.addEventListener("DOMContentLoaded", () => {
  const menuToggle = document.getElementById("menuToggle");
  const mobileMenuModal = document.getElementById("mobileMenuModal");
  const bsModal = mobileMenuModal ? new bootstrap.Modal(mobileMenuModal) : null;
  const hamburger = document.querySelector(".hamburger-icon");

  const toggleMenu = () => bsModal?.show();
  const closeMobileMenu = () => bsModal?.hide();

  mobileMenuModal?.addEventListener("show.bs.modal", () =>
    hamburger?.classList.add("open"),
  );
  mobileMenuModal?.addEventListener("hide.bs.modal", () =>
    hamburger?.classList.remove("open"),
  );

  menuToggle?.addEventListener("click", toggleMenu);

  mobileMenuModal?.querySelectorAll(".mobile-nav-list a").forEach((link) => {
    link.addEventListener("click", closeMobileMenu);
  });

  /* DRAG TO CLOSE LOGIC */
  const modalContent = mobileMenuModal?.querySelector(".modal-content");
  let startY = 0;
  let currentY = 0;
  let isDragging = false;

  modalContent?.addEventListener(
    "touchstart",
    (e) => {
      startY = e.touches[0].clientY;
      isDragging = true;
      modalContent.style.transition = "none";
    },
    { passive: true },
  );

  modalContent?.addEventListener(
    "touchmove",
    (e) => {
      if (!isDragging) return;
      currentY = e.touches[0].clientY;
      const diff = currentY - startY;
      if (diff > 0) modalContent.style.transform = `translateY(${diff}px)`;
    },
    { passive: true },
  );

  modalContent?.addEventListener("touchend", () => {
    if (!isDragging) return;
    isDragging = false;
    modalContent.style.transition = "transform 0.3s ease-out";

    const diff = currentY - startY;
    if (diff > 80) closeMobileMenu();
    else modalContent.style.transform = "translateY(0)";
  });

  mobileMenuModal?.addEventListener("hidden.bs.modal", () => {
    if (modalContent) {
      modalContent.style.transform = "";
      modalContent.style.transition = "";
    }
  });
});

/**
 * =====================================================
 * TESTIMONIAL SLIDER (OWL CAROUSEL)
 * =====================================================
 */
function initTestimonialOwl() {
  const $owl = $(".testimonial-slider");

  if (!$owl.length || !$.fn.owlCarousel) return;

  if ($owl.hasClass("owl-loaded")) {
    $owl.trigger("refresh.owl.carousel");
    return;
  }

  $owl.owlCarousel({
    loop: true,
    margin: 20,
    nav: false,
    dots: true,
    autoplay: true,
    autoplayTimeout: 5000,
    autoplayHoverPause: true,
    smartSpeed: 600,
    responsive: {
      0: { items: 1 },
      768: { items: 1 },
      1200: { items: 3 },
    },
  });
}

/**
 * =====================================================
 * TEAM CAROUSEL (OWL)
 * =====================================================
 */
$(document).ready(function () {
  const teamOwl = $(".team-slider");
  if (!teamOwl.length || !$.fn.owlCarousel) return; // Memastikan bahwa .team-slider ada di DOM dan plugin tersedia

  // 1. Inisialisasi Owl Carousel
  teamOwl.owlCarousel({
    loop: false,
    margin: 0,
    nav: false,
    dots: true,
    autoplay: false, // Set autoplay false pada awalnya
    autoplayTimeout: 3000,
    autoplayHoverPause: true,
    responsive: {
      0: { items: 1 },
      576: { items: 1 },
      992: { items: 2 },
      1200: { items: 4 },
    },
  });

  // 2. Logika Intersection Observer untuk autoplay
  const observerOptions = {
    threshold: 0.3, // 30% elemen harus terlihat untuk mulai autoplay
  };

  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        // Jika elemen masuk ke layar, aktifkan autoplay
        teamOwl.trigger("play.owl.autoplay", [3000]);
      } else {
        // Jika elemen keluar dari layar, hentikan autoplay
        teamOwl.trigger("stop.owl.autoplay");
      }
    });
  }, observerOptions);

  // Jalankan observer pada elemen .team-slider
  observer.observe(teamOwl[0]);

  // 3. Navigasi custom (next dan prev)
  $(".custom-next").on("click", function () {
    teamOwl.trigger("next.owl.carousel");
  });

  $(".custom-prev").on("click", function () {
    teamOwl.trigger("prev.owl.carousel");
  });
});

// =====================================================
// FACILITY SLIDER
// =====================================================
$(document).ready(function () {
  const $slider = $(".facility-slider");
  if ($slider.length && $.fn.owlCarousel) {
    $slider.owlCarousel({
      items: 1,
      loop: true,
      margin: 20,
      autoplay: true,
      autoplayTimeout: 4000,
      autoplayHoverPause: true,
      dots: true,
      nav: false,
      responsive: {
        768: {
          items: 2,
        },
        1200: {
          items: 3,
        },
      },
    });
  }
});

/**
 * =====================================================
 * BIO BANNER SLIDER (FADE)
 * =====================================================
 */

$(document).ready(function () {
  var $mainOwl = $(".bio-main-card-carousel");
  if ($mainOwl.length && $.fn.owlCarousel) {
    $mainOwl.owlCarousel({
      items: 1,
      loop: true,
      dots: true,
      dotsContainer: "#bio-carousel-dots",
      margin: 20,

      // Konfigurasi Kecepatan & Efek
      smartSpeed: 1000, // Kecepatan animasi perpindahan (1 detik)
      autoplay: true, // Langsung jalan otomatis
      autoplayTimeout: 5000, // Diam di setiap slide selama 5 detik
      autoplayHoverPause: true, // Berhenti sejenak kalau kursor di atas banner

      // Navigasi
      mouseDrag: true,
      touchDrag: true,
    });
  }
});

// $(document).ready(function () {
//   var $mainOwl = $(".bio-main-card-carousel");
//   var video = document.getElementById("bioBannerVideo");

//   // 1. Inisialisasi Carousel
//   $mainOwl.owlCarousel({
//     items: 1,
//     loop: true,
//     dots: true,
//     dotsContainer: "#bio-carousel-dots",
//     margin: 20,
//     // --- PERBAIKAN KECEPATAN ---
//     smartSpeed: 1500, // Kecepatan transisi animasi (1.5 detik)
//     autoplayTimeout: 6000, // Banner diam selama 6 detik
//     // --- TAMBAHKAN EFEK FADE AGAR TIDAK TERASA KAKU ---
//     animateOut: "fadeOut",
//     animateIn: "fadeIn",
//     autoplay: false, // Diam di awal untuk video
//     mouseDrag: true,
//     touchDrag: true,
//   });

//   // 2. Kontrol Video & Autoplay
//   if (video) {
//     // Coba putar video di awal
//     video.play().catch(function (error) {
//
//     });

//     // Saat Video Selesai: Geser ke banner selanjutnya
//     video.onended = function () {
//       $mainOwl.trigger("next.owl.carousel");
//       // Mulai autoplay dengan durasi yang lebih lambat (6 detik)
//       $mainOwl.trigger("play.owl.autoplay", [6000]);
//     };

//     // Logika Loop: Jika balik ke slide video
//     $mainOwl.on("translated.owl.carousel", function (event) {
//       var currentItem = $(event.target).find(".owl-item.active");
//       var hasVideo = currentItem.find("video").length > 0;

//       if (hasVideo) {
//         // Berhenti di video, jangan ganti slide dulu
//         $mainOwl.trigger("stop.owl.autoplay");
//         video.currentTime = 0;
//         video.play();
//       } else {
//         // Lanjut autoplay untuk gambar dengan durasi 6 detik
//         $mainOwl.trigger("play.owl.autoplay", [6000]);
//       }
//     });
//   } else {
//     // Jika video tidak ada, langsung aktifkan autoplay 6 detik
//     $mainOwl.trigger("play.owl.autoplay", [6000]);
//   }
// });
