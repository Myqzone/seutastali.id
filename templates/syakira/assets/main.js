/**
 * Seutastali Syakira Template Main Script
 * Parallax Zoom-In-To-Out Reveal + Countdown Timer + Music
 */

let countdownInterval;

function initCountdown(targetDateString) {
  if (countdownInterval) clearInterval(countdownInterval);
  const targetDate = new Date(targetDateString).getTime();

  function updateTimer() {
    const now = new Date().getTime();
    const distance = targetDate - now;
    if (distance < 0) {
      clearInterval(countdownInterval);
      document.getElementById('days').innerText = "00";
      document.getElementById('hours').innerText = "00";
      document.getElementById('minutes').innerText = "00";
      document.getElementById('seconds').innerText = "00";
      return;
    }
    document.getElementById('days').innerText = String(Math.floor(distance / (1000*60*60*24))).padStart(2,'0');
    document.getElementById('hours').innerText = String(Math.floor((distance % (1000*60*60*24)) / (1000*60*60))).padStart(2,'0');
    document.getElementById('minutes').innerText = String(Math.floor((distance % (1000*60*60)) / (1000*60))).padStart(2,'0');
    document.getElementById('seconds').innerText = String(Math.floor((distance % (1000*60)) / 1000)).padStart(2,'0');
  }
  updateTimer();
  countdownInterval = setInterval(updateTimer, 1000);
}

/**
 * Parallax Zoom-In-To-Out Reveal Sequence
 * Each layer starts scaled up (zoomed in) and transitions to normal scale,
 * appearing one by one with staggered delays - deepest layers first.
 */
document.addEventListener('DOMContentLoaded', () => {
  // Force reset both window and invitation-shell scroll container to top immediately on refresh/reload
  if ('scrollRestoration' in history) {
    history.scrollRestoration = 'manual';
  }
  window.scrollTo(0, 0);
  const initialShell = document.querySelector('.invitation-shell');
  if (initialShell) {
    initialShell.scrollTop = 0;
  }

  // Continuously force scroll to 0 for the first second of page load to override browser auto-restoration
  let scrollCheckCount = 0;
  const scrollCheckInterval = setInterval(() => {
    window.scrollTo(0, 0);
    if (initialShell) {
      initialShell.scrollTop = 0;
    }
    scrollCheckCount++;
    if (scrollCheckCount > 20) {
      clearInterval(scrollCheckInterval);
    }
  }, 50);

  const btnOpen = document.getElementById('btnOpenInvitation');
  const coverScene = document.getElementById('coverScene');
  const bgMusic = document.getElementById('bgMusic');

  // Collect all parallax layers in reveal order (back to front)
  const layers = [
    { el: document.querySelector('.layer-sky'),     delay: 0 },
    { el: document.querySelector('.mist-top'),      delay: 150 },
    { el: document.querySelector('.mist-mid'),      delay: 250 },
    { el: document.querySelector('.mist-bottom'),   delay: 350 },
    { el: document.querySelector('.layer-altar'),    delay: 400 },
    { el: document.querySelector('.layer-stairs'),   delay: 550 },
    { el: document.querySelector('.layer-couple'),   delay: 700 },
    { el: document.querySelector('.layer-arch'),     delay: 300 },
    { el: document.querySelector('.layer-seagulls'), delay: 900 },
    // Leaves
    ...document.querySelectorAll('.layer-leaves-top').length
      ? Array.from(document.querySelectorAll('.layer-leaves-top')).map((el, i) => ({ el, delay: 500 + i * 100 }))
      : [],
    // Foreground elements
    ...document.querySelectorAll('.fg-tree').length
      ? Array.from(document.querySelectorAll('.fg-tree')).map((el, i) => ({ el, delay: 600 + i * 100 }))
      : [],
    ...document.querySelectorAll('.fg-flower').length
      ? Array.from(document.querySelectorAll('.fg-flower')).map((el, i) => ({ el, delay: 750 + i * 100 }))
      : [],
    ...document.querySelectorAll('.fg-grass').length
      ? Array.from(document.querySelectorAll('.fg-grass')).map((el, i) => ({ el, delay: 850 + i * 80 }))
      : [],
    ...document.querySelectorAll('.fg-butterfly').length
      ? Array.from(document.querySelectorAll('.fg-butterfly')).map((el, i) => ({ el, delay: 1100 + i * 150 }))
      : [],
    // Text last
    { el: document.querySelector('.cover-text'),    delay: 1300 },
  ];

  // Auto-trigger the parallax zoom-in-to-out reveal on page load
  layers.forEach(({ el, delay }) => {
    if (!el) return;
    setTimeout(() => {
      el.classList.add('reveal');
    }, delay);
  });

  // Handle "Open Invitation" button click
  if (btnOpen) {
    // Block ALL scrolling (touch + wheel) while cover is visible
    const shell = document.querySelector('.invitation-shell');
    
    function preventScroll(e) { e.preventDefault(); }
    document.addEventListener('touchmove', preventScroll, { passive: false });
    document.addEventListener('wheel', preventScroll, { passive: false });

    btnOpen.addEventListener('click', () => {
      // Hide the cover scene
      coverScene.classList.add('hide');

      // Unlock body scrolling
      document.body.classList.add('unlocked');
      if (shell) {
        // Temporarily disable smooth scrolling to force an instant, invisible jump to top
        const originalScrollBehavior = shell.style.scrollBehavior;
        shell.style.scrollBehavior = 'auto';
        shell.classList.add('scrollable');
        shell.scrollTop = 0; // Reset scroll container position to top
        
        setTimeout(() => {
          shell.style.scrollBehavior = originalScrollBehavior;
        }, 50);
      }

      // Reset main window scroll position to top
      window.scrollTo(0, 0);

      // Remove scroll blockers
      document.removeEventListener('touchmove', preventScroll);
      document.removeEventListener('wheel', preventScroll);

      // Play background music
      if (bgMusic) {
        bgMusic.volume = 0.4;
        bgMusic.play().catch(() => {});
      }

      // Show floating music control button
      const musicBtn = document.getElementById('musicControlBtn');
      if (musicBtn) {
        musicBtn.classList.remove('d-none');
      }
    });
  }

  // Music Control Button Trigger Toggle
  const musicBtn = document.getElementById('musicControlBtn');
  if (musicBtn && bgMusic) {
    musicBtn.addEventListener('click', () => {
      if (bgMusic.paused) {
        bgMusic.play().catch(() => {});
        musicBtn.innerHTML = '<i class="fa-solid fa-compact-disc fa-spin"></i>';
        musicBtn.classList.remove('muted');
      } else {
        bgMusic.pause();
        musicBtn.innerHTML = '<i class="fa-solid fa-volume-xmark"></i>';
        musicBtn.classList.add('muted');
      }
    });
  }

  // Floating Navigation Active-State Highlighting
  const navBtns = document.querySelectorAll('.floating-nav-bar .nav-btn');
  const scrollContainer = window.matchMedia('(min-width: 992px)').matches
    ? document.querySelector('.invitation-shell')
    : window;

  if (navBtns.length > 0) {
    // 1. Smooth click transitions
    navBtns.forEach(btn => {
      btn.addEventListener('click', function(e) {
        e.preventDefault();
        const targetId = this.getAttribute('href');
        
        // Remove active state
        navBtns.forEach(b => b.classList.remove('active'));
        this.classList.add('active');

        // Scroll to target element smoothly
        if (targetId === '#') {
          if (scrollContainer === window) {
            window.scrollTo({ top: 0, behavior: 'smooth' });
          } else {
            scrollContainer.scrollTo({ top: 0, behavior: 'smooth' });
          }
        } else {
          const targetEl = document.querySelector(targetId);
          if (targetEl) {
            targetEl.scrollIntoView({ behavior: 'smooth' });
          }
        }
      });
    });

    // 2. Highlighting active section based on scroll offset (IntersectionObserver style)
    const sections = [
      { id: '#', el: document.querySelector('.main-hero') },
      { id: '#acara', el: document.getElementById('acara') },
      { id: '#cerita', el: document.getElementById('cerita') },
      { id: '#galeri', el: document.getElementById('galeri') },
      { id: '#rsvp', el: document.getElementById('rsvp') }
    ];

    const handleScroll = () => {
      let currentSectionId = '#';
      const containerTop = scrollContainer === window ? 0 : scrollContainer.getBoundingClientRect().top;

      sections.forEach(sec => {
        if (!sec.el) return;
        const rect = sec.el.getBoundingClientRect();
        const topOffset = rect.top - containerTop;
        
        // If the section is scrolled past the midpoint of the viewport, count it as active
        if (topOffset <= window.innerHeight * 0.45) {
          currentSectionId = sec.id;
        }
      });

      navBtns.forEach(btn => {
        if (btn.getAttribute('href') === currentSectionId) {
          btn.classList.add('active');
        } else {
          btn.classList.remove('active');
        }
      });
    };

    // Listen to scroll events on the correct container
    if (scrollContainer === window) {
      window.addEventListener('scroll', handleScroll, { passive: true });
    } else if (scrollContainer) {
      scrollContainer.addEventListener('scroll', handleScroll, { passive: true });
    }
  }
});

