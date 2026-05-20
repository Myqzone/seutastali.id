document.addEventListener('DOMContentLoaded', function() {
  // DOM nodes
  const trackerContainer = document.getElementById('floatingJourneyTracker');
  const triggerBtn = document.getElementById('trackerPillTrigger');
  const minimizeBtn = document.getElementById('btnMinimizeTracker');
  const expandedCard = document.querySelector('.tracker-expanded-card');

  const stepPaket = document.getElementById('step-paket');
  const stepDesain = document.getElementById('step-desain');
  const stepDraf = document.getElementById('step-draf');

  const descPaket = document.getElementById('step-paket-desc');
  const descDesain = document.getElementById('step-desain-desc');
  const descDraf = document.getElementById('step-draf-desc');
  const suggestionText = document.getElementById('trackerSuggestionText');

  // Retrieve base configuration from HTML dataset or document element attributes
  const staticUrl = document.documentElement.getAttribute('data-static-url') || './';
  const serverPackage = document.documentElement.getAttribute('data-server-package') || '';
  const serverToken = document.documentElement.getAttribute('data-server-token') || '';
  const initialEditMode = document.documentElement.getAttribute('data-initial-edit-mode') === '1';

  // -------------------------------------------------------------------------
  // 1. DATA DETECTION PATHWAY (URL Parameters & Location Context)
  // -------------------------------------------------------------------------
  
  let selectedPackage = serverPackage;
  let activeToken = serverToken;
  
  // Frontend query parameter checking
  const urlParams = new URLSearchParams(window.location.search);
  if (urlParams.has('package')) {
    selectedPackage = urlParams.get('package');
    localStorage.setItem('selected_package', selectedPackage);
  } else {
    selectedPackage = selectedPackage || localStorage.getItem('selected_package') || "";
  }

  if (urlParams.has('token')) {
    activeToken = urlParams.get('token');
  }

  // Determine current page status
  const pathName = window.location.pathname;
  const isTemplatesPage = pathName.includes('templates.php');
  const isPricingPage = pathName.includes('pricing.php');
  
  // Check if user is inside a specific template subdirectory or accessing via subdomain
  let templateFolder = "";
  const hostname = window.location.hostname;
  
  // Parse wildcard subdomain (e.g., syakira.seutastali.id)
  const hostParts = hostname.split('.');
  let detectedSubdomain = "";
  if (hostParts.length > 2 && hostParts[0] !== 'www' && hostParts[0] !== 'app') {
    detectedSubdomain = hostParts[0];
  }

  if (detectedSubdomain) {
    templateFolder = detectedSubdomain;
  } else if (pathName.includes('/design/') && !isTemplatesPage) {
    const parts = pathName.split('/design/');
    if (parts[1]) {
      templateFolder = parts[1].split('/')[0];
    }
  }

  // Hide completely if no package has been selected yet AND we are not inside a template page
  if (!selectedPackage && !templateFolder) {
    if (trackerContainer) {
      trackerContainer.style.setProperty('display', 'none', 'important');
    }
    return;
  }

  // Also read active token/session from localStorage if present
  if (!activeToken) {
    activeToken = localStorage.getItem('active_draft_token') || "";
  }

  // -------------------------------------------------------------------------
  // 2. RENDERING PROGRESS WIDGET STATE
  // -------------------------------------------------------------------------
  
  let isPaketDone = false;
  let isDesainDone = false;
  let isDrafDone = false;

  // STEP 1: Paket validation
  if (selectedPackage) {
    isPaketDone = true;
    if (stepPaket) stepPaket.classList.add('checked');
    if (descPaket) descPaket.innerText = `Paket: ${selectedPackage}`;
  } else {
    if (stepPaket) stepPaket.classList.add('active');
  }

  // STEP 2: Desain validation
  if (templateFolder) {
    isDesainDone = true;
    if (stepDesain) stepDesain.classList.add('checked');
    if (descDesain) descDesain.innerText = `Tema: ${templateFolder.toUpperCase()}`;
  } else if (isPaketDone) {
    if (stepDesain) stepDesain.classList.add('active');
  }

  // STEP 3: Draf validation
  if (activeToken) {
    isPaketDone = true;
    isDesainDone = true;
    isDrafDone = true;
    if (stepPaket) stepPaket.classList.add('checked');
    if (stepDesain) stepDesain.classList.add('checked');
    if (stepDraf) stepDraf.classList.add('checked');
    if (descDraf) descDraf.innerText = "Draf siap di-checkout";
  } else if (isPaketDone && isDesainDone) {
    if (stepDraf) stepDraf.classList.add('active');
  }

  // Toggle Edit Button inside Tracker based on whether we are in a template
  const trackerEditButtonWrapper = document.getElementById('trackerEditButtonWrapper');
  if (templateFolder && trackerEditButtonWrapper) {
    trackerEditButtonWrapper.classList.remove('d-none');
  }

  // -------------------------------------------------------------------------
  // 3. GENERATE ACTION SUGGESTION MESSAGE
  // -------------------------------------------------------------------------
  let actionMessage = "";
  if (!isPaketDone) {
    actionMessage = "Pilih salah satu Paket Harga untuk memulai langkah Anda.";
  } else if (isPaketDone && !isDesainDone) {
    actionMessage = `Rencana Paket: ${selectedPackage}. Pilih satu desain template impian Anda sekarang.`;
  } else if (isPaketDone && isDesainDone && !isDrafDone) {
    actionMessage = "Buka panel editor, ganti teks mempelai sesuai keinginan Anda, lalu klik 'Simpan'.";
  } else if (isDrafDone) {
    actionMessage = "Draf tersimpan! Klik tombol 'Lanjutkan Pembayaran' di tab Simpan untuk menyelesaikan pemesanan.";
  }
  if (suggestionText) suggestionText.innerText = actionMessage;

  // -------------------------------------------------------------------------
  // 4. PERSISTENT BUBBLE DISPLAY ENGINE (LocalStorage)
  // -------------------------------------------------------------------------
  
  // On first visit, default to collapsed to prevent annoyance, but open if a package is selected
  let trackerState = localStorage.getItem('journey_tracker_state');
  
  if (trackerState === null) {
    if (selectedPackage || templateFolder) {
      trackerState = 'expanded';
    } else {
      trackerState = 'collapsed';
    }
  }

  // Apply state on load
  if (trackerContainer) {
    if (trackerState === 'expanded') {
      trackerContainer.classList.remove('collapsed');
      trackerContainer.classList.add('expanded');
    } else {
      trackerContainer.classList.remove('expanded');
      trackerContainer.classList.add('collapsed');
    }
    // Make container visible after setting correct state
    trackerContainer.style.display = 'block';
  }

  // -------------------------------------------------------------------------
  // 5. BUTTON CLICK HANDLERS
  // -------------------------------------------------------------------------
  
  if (triggerBtn) {
    triggerBtn.addEventListener('click', function() {
      trackerContainer.classList.remove('collapsed');
      trackerContainer.classList.add('expanded');
      localStorage.setItem('journey_tracker_state', 'expanded');
    });
  }

  if (minimizeBtn) {
    minimizeBtn.addEventListener('click', function(e) {
      e.stopPropagation();
      trackerContainer.classList.remove('expanded');
      trackerContainer.classList.add('collapsed');
      localStorage.setItem('journey_tracker_state', 'collapsed');
    });
  }

  // Minimize button inside the Editor Slide
  const minimizeBtnEditor = document.getElementById('btnMinimizeTrackerEditor');
  if (minimizeBtnEditor) {
    minimizeBtnEditor.addEventListener('click', function(e) {
      e.stopPropagation();
      trackerContainer.classList.remove('expanded');
      trackerContainer.classList.add('collapsed');
      localStorage.setItem('journey_tracker_state', 'collapsed');
    });
  }

  // Custom Event Listeners to control the slide position and card width of the tracker
  document.addEventListener('open-dreamboard', function() {
    const slidesContainer = document.getElementById('trackerSlidesContainer');
    if (slidesContainer) {
      slidesContainer.style.transform = 'translateX(-50%)';
    }
    if (expandedCard) {
      expandedCard.classList.add('editing'); // smooth transition to 420px width
    }
  });

  document.addEventListener('close-dreamboard', function() {
    const slidesContainer = document.getElementById('trackerSlidesContainer');
    if (slidesContainer) {
      slidesContainer.style.transform = 'translateX(0)';
    }
    if (expandedCard) {
      expandedCard.classList.remove('editing'); // smooth transition back to 320px width
    }
  });


  // ==========================================================================
  // INTEGRATED DRAFT EDITOR BINDINGS
  // ==========================================================================

  const watermark = document.getElementById('dreamboardIndicator');

  // DOM Display nodes (targets inside templates)
  const groomDisplay = document.getElementById('groom-display');
  const brideDisplay = document.getElementById('bride-display');
  const dateDisplay = document.getElementById('date-display');

  // Inputs inside consolidated journey tracker
  const inputGroom = document.getElementById('dbInputGroom');
  const inputBride = document.getElementById('dbInputBride');
  const inputDate = document.getElementById('dbInputDate');
  const inputMusic = document.getElementById('dbInputMusic');
  const inputFont = document.getElementById('dbInputFont');
  const inputPhoto = document.getElementById('dbInputPhoto');
  const colorDots = document.querySelectorAll('.db-color-dot');

  let activeColor = document.documentElement.getAttribute('data-color-val') || '#f4eae1';

  // ----------------------------------------------------
  // 1. LIVE SYNCHRONIZATION BINDINGS (DIRECT DOM UPDATES)
  // ----------------------------------------------------

  if (inputGroom) {
    inputGroom.addEventListener('input', function() {
      const val = this.value || 'Pria';
      if (groomDisplay) groomDisplay.innerText = val;
      const g2 = document.getElementById('groom-display-2');
      if (g2) g2.innerText = val;
      const dg = document.getElementById('desktop-groom-display');
      if (dg) dg.innerText = val;
    });
  }

  if (inputBride) {
    inputBride.addEventListener('input', function() {
      const val = this.value || 'Wanita';
      if (brideDisplay) brideDisplay.innerText = val;
      const b2 = document.getElementById('bride-display-2');
      if (b2) b2.innerText = val;
      const db = document.getElementById('desktop-bride-display');
      if (db) db.innerText = val;
    });
  }

  if (inputDate) {
    inputDate.addEventListener('change', function() {
      if (!this.value) return;
      const weddingDate = new Date(this.value);
      if (!isNaN(weddingDate.getTime())) {
        const options = {
          weekday: 'long',
          year: 'numeric',
          month: 'long',
          day: 'numeric'
        };
        const formatter = new Intl.DateTimeFormat('id-ID', options);
        
        // Update all date display elements across mobile and desktop views
        const allDateDisplays = document.querySelectorAll('#date-display, .dl-date, #desktop-date-display, .date-display');
        allDateDisplays.forEach(el => {
          el.innerText = formatter.format(weddingDate);
        });

        if (typeof initCountdown === 'function') {
          initCountdown(this.value);
        }
      }
    });
  }

  // Color picker binding
  if (colorDots) {
    colorDots.forEach(dot => {
      dot.addEventListener('click', function() {
        colorDots.forEach(d => d.classList.remove('active'));
        this.classList.add('active');
        activeColor = this.getAttribute('data-color');
        document.documentElement.style.setProperty('--theme-bg', activeColor);
      });
    });
  }

  // Background Music options selector binding
  if (inputMusic) {
    inputMusic.addEventListener('change', function() {
      const bgMusic = document.getElementById('bgMusic');
      if (bgMusic) {
        const source = bgMusic.querySelector('source');
        if (source) {
          const assetsUrl = document.documentElement.getAttribute('data-assets-path') || 'assets/';
          source.setAttribute('src', assetsUrl + 'media/music/' + this.value);
          bgMusic.load();
          
          // Auto play if not muted
          const musicBtn = document.getElementById('musicControlBtn');
          if (musicBtn && !musicBtn.classList.contains('muted')) {
            bgMusic.play().catch(e => console.error(e));
          }
        }
      }
    });
  }

  // Font Selection Live Preview binding
  if (inputFont) {
    inputFont.addEventListener('change', function() {
      const selectedFont = this.value;
      let headingFont = "'Playfair Display', serif";
      let displayFont = "'Outfit', sans-serif";
      
      if (selectedFont === 'romantic') {
        headingFont = "'Great Vibes', cursive";
        displayFont = "'Montserrat', sans-serif";
      } else if (selectedFont === 'modern') {
        headingFont = "'Montserrat', sans-serif";
        displayFont = "'Outfit', sans-serif";
      } else if (selectedFont === 'playful') {
        headingFont = "'Playpen Sans', cursive";
        displayFont = "'Manrope', sans-serif";
      }
      
      // Update CSS custom variables on the document element
      document.documentElement.style.setProperty('--font-heading', headingFont);
      document.documentElement.style.setProperty('--font-display', displayFont);
    });
  }

  // Photo Selection Live Preview binding (local upload preview)
  if (inputPhoto) {
    inputPhoto.addEventListener('change', function() {
      const file = this.files[0];
      if (file) {
        const url = URL.createObjectURL(file);
        
        // Update first Couple Gallery photo
        const galleryImgs = document.querySelectorAll('.gallery-img');
        if (galleryImgs.length > 0) {
          galleryImgs[0].src = url;
        }

        // Also update watercolor couple illustration (bride) if it exists in layout
        const ornBride = document.querySelector('.orn-bride-img');
        if (ornBride) {
          ornBride.src = url;
          ornBride.style.objectFit = 'cover';
          ornBride.style.borderRadius = '20px';
        }
      }
    });
  }

  // ----------------------------------------------------
  // 2. SPA OPEN / CLOSE & HISTORY API ROUTING
  // ----------------------------------------------------

  function openDreamboard() {
    if (watermark) watermark.classList.remove('d-none');

    // Parse current URL and set/update only the edit parameter, preserving package, token, etc.
    const url = new URL(window.location.href);
    url.searchParams.set('edit', '1');
    
    window.history.pushState({
      path: url.toString()
    }, '', url.toString());
  }

  function closeDreamboard() {
    if (watermark) watermark.classList.add('d-none');

    // Parse current URL and remove edit and preview parameters, preserving others
    const url = new URL(window.location.href);
    url.searchParams.delete('edit');
    url.searchParams.delete('preview');
    
    window.history.pushState({
      path: url.toString()
    }, '', url.toString());

    // Dispatch event to let other components know it closed
    document.dispatchEvent(new CustomEvent('close-dreamboard-event'));
  }

  // Global listener for consolidated floating tracker triggering
  document.addEventListener('open-dreamboard', openDreamboard);
  document.addEventListener('close-dreamboard', closeDreamboard);

  // Slide to Dreamboard editor from Tracker
  const editBtn = document.getElementById('btnOpenDreamboardFromTracker');
  if (editBtn) {
    editBtn.addEventListener('click', function() {
      document.dispatchEvent(new CustomEvent('open-dreamboard'));
    });
  }

  // Slide back from Dreamboard editor to steps list
  const backBtn = document.getElementById('btnBackToSteps');
  if (backBtn) {
    backBtn.addEventListener('click', function() {
      document.dispatchEvent(new CustomEvent('close-dreamboard'));
    });
  }

  // If edit mode active initially on load, show indicator and trigger open
  if (initialEditMode) {
    if (watermark) watermark.classList.remove('d-none');
    setTimeout(() => {
      document.dispatchEvent(new CustomEvent('open-dreamboard'));
    }, 300);
  }

  // ----------------------------------------------------
  // 3. SUBMIT DRAFT REGISTRATION DIRECT FORM
  // ----------------------------------------------------

  const submitBtn = document.getElementById('dbBtnSubmitDraft');
  if (submitBtn) {
    submitBtn.addEventListener('click', function(e) {
      e.preventDefault();

      const nameInput = document.getElementById('dbClientName');
      const emailInput = document.getElementById('dbClientEmail');

      const name = nameInput ? nameInput.value.trim() : '';
      const email = emailInput ? emailInput.value.trim() : '';

      if (!name || !email) {
        alert('Mohon isi nama lengkap dan alamat email Anda pada tab Simpan untuk mendaftar.');
        // Switch to Simpan tab automatically
        const saveTabBtn = document.getElementById('tab-save-tab');
        if (saveTabBtn) {
          saveTabBtn.click();
        }
        return;
      }

      const draftPayload = {
        groom: inputGroom ? inputGroom.value : '',
        bride: inputBride ? inputBride.value : '',
        date: inputDate ? inputDate.value : '',
        color: activeColor,
        music: inputMusic ? inputMusic.value : '',
        font: inputFont ? inputFont.value : 'classic',
        template: templateFolder || 'syakira'
      };

      submitBtn.disabled = true;
      submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i> Menyimpan Draf...';

      // Save draft using Fetch API posting to our central endpoint
      fetch(staticUrl + 'api/save_draft.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            client_name: name,
            client_email: email,
            draft_payload: draftPayload
          })
        })
        .then(res => res.json())
        .then(data => {
          submitBtn.disabled = false;
          submitBtn.innerHTML = '💾 Simpan Draf Undangan';

          if (data.success) {
            // Save token locally
            localStorage.setItem('active_draft_token', data.token);
            
            // Mark step progress
            if (stepDraf) stepDraf.classList.add('checked');
            if (descDraf) descDraf.innerText = "Draf siap di-checkout";

            // Resolve redirection URLs
            const packageParam = urlParams.get('package') || localStorage.getItem('selected_package') || '';
            let redirectUrl = staticUrl;
            if (packageParam) {
              redirectUrl += 'checkout.php?token=' + encodeURIComponent(data.token) + '&package=' + encodeURIComponent(packageParam);
            } else {
              redirectUrl += 'pricing.php?token=' + encodeURIComponent(data.token);
            }

            // Replace form in Simpan tab with choice buttons
            const tabSave = document.getElementById('tab-save');
            if (tabSave) {
              tabSave.innerHTML = `
                <div class="text-center py-4">
                  <div class="mb-3" style="font-size: 2.5rem;">🎉</div>
                  <h6 class="fw-bold mb-2 text-dark text-uppercase tracking-wider">Draf Berhasil Disimpan!</h6>
                  <p class="small text-muted mb-4 px-2" style="font-size: 0.74rem; line-height: 1.4;">
                    Data draf Anda telah aman tersimpan. Silakan tentukan langkah selanjutnya:
                  </p>
                  <div class="d-flex flex-column gap-3">
                    <a href="${redirectUrl}" class="btn btn-seutasbox-primary w-100 py-2.5 fw-bold text-uppercase d-flex align-items-center justify-content-center gap-2">
                      💳 Lanjutkan Pembayaran
                    </a>
                    <a href="${staticUrl}templates.php" class="btn btn-seutasbox-secondary w-100 py-2.5 fw-bold text-uppercase d-flex align-items-center justify-content-center gap-2">
                      🔍 Lihat Template Lain
                    </a>
                  </div>
                </div>
              `;
            }
          } else {
            alert('Gagal menyimpan draf: ' + data.message);
          }
        })
        .catch(err => {
          submitBtn.disabled = false;
          submitBtn.innerHTML = '💾 Simpan Draf Undangan';
          console.error('Error saving draft:', err);
          alert('Koneksi bermasalah. Mengalihkan ke halaman pemesanan...');
          
          const packageParam = urlParams.get('package') || localStorage.getItem('selected_package') || '';
          let redirectUrl = staticUrl;
          if (packageParam) {
            redirectUrl += 'checkout.php?package=' + encodeURIComponent(packageParam);
          } else {
            redirectUrl += 'pricing.php';
          }
          window.location.href = redirectUrl;
        });
    });
  }

});
