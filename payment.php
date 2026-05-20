<?php
// Load bootstrap
require_once __DIR__ . '/config/bootstrap.php';

// Initialize session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Fetch parameters
$draft_token = isset($_GET['token']) ? htmlspecialchars($_GET['token']) : 'mocktoken';
$packageName = isset($_GET['package']) ? htmlspecialchars($_GET['package']) : 'Dasar';
$method = isset($_GET['method']) ? htmlspecialchars($_GET['method']) : 'qris';
$discount = isset($_GET['discount']) ? intval($_GET['discount']) : 0;
$total = isset($_GET['total']) ? intval($_GET['total']) : 151500;

// Set package visual mapping
$packages = [
    'Dasar' => 'Dasar (Basic Package)',
    'Lengkap' => 'Lengkap (Complete Package)',
    'Eksklusif' => 'Eksklusif (Exclusive Package)',
    'Premium' => 'Premium (Ultra Package)'
];
$displayPackageName = isset($packages[$packageName]) ? $packages[$packageName] : $packageName;

// Generate mock transaction ID
$transactionId = "ST-" . strtoupper(substr(md5($draft_token . time()), 0, 8)) . "-" . rand(100, 999);

// Set page meta
$page_title = 'Payment Gateway - Seutastali';
$page_description = 'Complete your secure transaction to activate your premium invitation.';

ob_start();
?>

<style>
  /* Live Credit Card Visual Styling */
  .card-container {
    perspective: 1000px;
    margin: 20px auto;
    max-width: 350px;
    width: 100%;
  }
  .credit-card-mockup {
    width: 100%;
    height: 200px;
    background: linear-gradient(135deg, var(--c-primary-dark), var(--c-primary));
    color: #fff;
    border-radius: 15px;
    padding: 20px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    position: relative;
    transition: transform 0.6s;
    transform-style: preserve-3d;
  }
  .cc-chip {
    width: 45px;
    height: 35px;
    background: linear-gradient(135deg, #e5c07b, #abb2bf);
    border-radius: 5px;
    margin-bottom: 25px;
  }
  .cc-number {
    font-size: 1.25rem;
    letter-spacing: 2px;
    font-family: 'Courier New', monospace;
    font-weight: bold;
    margin-bottom: 20px;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
  }
  .cc-holder, .cc-expiry {
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 1px;
  }
  .cc-label {
    font-size: 0.6rem;
    color: rgba(255, 255, 255, 0.6);
    margin-bottom: 2px;
  }
  .cc-logo {
    position: absolute;
    top: 20px;
    right: 20px;
    font-size: 1.5rem;
    font-weight: bold;
    font-style: italic;
  }
  
  /* QRIS Visual Styling */
  .qris-box {
    border: 2px solid #000;
    border-radius: 15px;
    background-color: #fff;
    padding: 20px;
    max-width: 280px;
    margin: 0 auto;
    box-shadow: 4px 4px 0px #000;
  }

  /* Timer and Alert Style */
  .timer-badge {
    background-color: var(--c-primary-dark);
    color: #fff;
    font-weight: bold;
    font-size: 1.1rem;
    padding: 8px 16px;
    border-radius: 50px;
    border: 1px solid rgba(var(--c-primary-rgb), 0.2);
  }
</style>

<!-- Header Section -->
<section class="position-relative mt-5 mt-lg-4">
  <div class="container position-relative z-3">
    <div class="d-flex flex-column flex-md-row align-items-md-start justify-content-md-between gap-3 mb-3">
      <div class="section-header text-start mb-0 order-2 order-md-1">
        <div class="d-inline-block mb-2" style="background-color: #fff9db; color: #f59f00; border: 2px solid #000; box-shadow: 2px 2px 0px #000; padding: 4px 12px; border-radius: 8px; font-weight: bold; font-size: 0.8rem; text-transform: uppercase;">
          Menunggu Pembayaran
        </div>
        <h1 class="hero-title text-start ms-0" style="margin-left: 0 !important; margin-bottom: 0.5rem !important;">
          Invoice <span class="text-primary fw-bold">#<?= $invoiceNum ?></span>
        </h1>
        <p class="ms-0 text-start mb-0 text-muted" style="margin-left: 0 !important; max-width: 620px; font-weight: 500;">
          Lakukan pembayaran sebelum <span class="text-dark fw-bold"><?= date('d F Y', strtotime('+1 day')) ?> | <?= date('H:i') ?></span>
        </p>
      </div>

      <nav aria-label="breadcrumb" class="mb-0 order-1 order-md-2 align-self-start pt-md-2">
        <ol class="breadcrumb mb-0 text-uppercase fw-bold" style="font-size: 0.75rem; letter-spacing: 1px;">
          <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none text-muted">Home</a></li>
          <li class="breadcrumb-item"><a href="checkout.php" class="text-decoration-none text-muted">Checkout</a></li>
          <li class="breadcrumb-item active text-primary" aria-current="page">Invoice</li>
        </ol>
      </nav>
    </div>
  </div>
</section>

<!-- Payment Process Content -->
<section class="pt-3 pb-5">
  <div class="container">
    <div class="row g-4 justify-content-center">
      
      <!-- Main Payment Column -->
      <div class="col-lg-8">
        
        <!-- Transaction Summary and Timer Card -->
        <div class="card rounded-4 p-4 mb-4">
          <div class="row align-items-center g-3 text-center text-md-start">
            <div class="col-md-7">
              <span class="badge bg-primary text-white mb-2 px-3 py-1.5 rounded-pill text-uppercase fw-bold" style="font-size: 8px;">Detail Pesanan</span>
              <h5 class="fw-bold mb-1">Nomor Pesanan: <?= htmlspecialchars($transactionId) ?></h5>
              <p class="text-muted small mb-0">Pilihan Paket: <strong><?= htmlspecialchars($displayPackageName) ?></strong></p>
              <p class="text-muted small mb-0">Total Tagihan: <strong class="text-primary">Rp <?= number_format($total, 0, ',', '.') ?></strong></p>
            </div>
            <div class="col-md-5 text-md-end">
              <span class="small d-block text-muted mb-2 fw-bold">SISA WAKTU PEMBAYARAN</span>
              <div class="d-inline-flex align-items-center gap-2 timer-badge">
                <i class="fa-solid fa-clock-rotate-left"></i>
                <span id="countdownTimer">15:00</span>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Payment Gateway Portal Card -->
        <div class="card rounded-4 p-4">
          
          <!-- QRIS PAYMENT METHOD -->
          <?php if ($method === 'qris'): ?>
            <div class="text-center py-3">
              <h5 class="fw-bold text-body mb-3">Pay with QRIS E-Wallet</h5>
              <p class="text-muted small mb-4">Scan this QR Code with GoPay, ShopeePay, OVO, Dana, LinkAja, or your Banking QR app.</p>
              
              <div class="qris-box mb-4">
                <!-- QRIS LOGO -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                  <span class="fw-bold text-dark" style="font-size: 14px; letter-spacing: 1px;">QRIS</span>
                  <span class="small text-muted" style="font-size: 9px;">GPN / LINK</span>
                </div>
                <!-- Inline Mock QR SVG -->
                <svg width="200" height="200" viewBox="0 0 200 200" class="mx-auto d-block">
                  <!-- QR Frame -->
                  <rect width="200" height="200" fill="#fff" />
                  <!-- QR Markers -->
                  <rect x="10" y="10" width="45" height="45" fill="#3d0c11" />
                  <rect x="20" y="20" width="25" height="25" fill="#fff" />
                  <rect x="25" y="25" width="15" height="15" fill="#3d0c11" />
                  
                  <rect x="145" y="10" width="45" height="45" fill="#3d0c11" />
                  <rect x="155" y="20" width="25" height="25" fill="#fff" />
                  <rect x="160" y="25" width="15" height="15" fill="#3d0c11" />
                  
                  <rect x="10" y="145" width="45" height="45" fill="#3d0c11" />
                  <rect x="20" y="155" width="25" height="25" fill="#fff" />
                  <rect x="25" y="160" width="15" height="15" fill="#3d0c11" />
                  
                  <!-- QR Random mock data patterns -->
                  <rect x="70" y="15" width="15" height="15" fill="#3d0c11" />
                  <rect x="95" y="10" width="10" height="30" fill="#3d0c11" />
                  <rect x="115" y="20" width="20" height="10" fill="#3d0c11" />
                  <rect x="70" y="45" width="30" height="10" fill="#3d0c11" />
                  <rect x="15" y="70" width="25" height="15" fill="#3d0c11" />
                  <rect x="50" y="70" width="40" height="40" fill="#3d0c11" />
                  <rect x="105" y="60" width="15" height="15" fill="#3d0c11" />
                  <rect x="130" y="75" width="35" height="15" fill="#3d0c11" />
                  <rect x="175" y="70" width="15" height="40" fill="#3d0c11" />
                  <rect x="15" y="100" width="15" height="30" fill="#3d0c11" />
                  <rect x="100" y="90" width="20" height="30" fill="#3d0c11" />
                  <rect x="135" y="105" width="25" height="25" fill="#3d0c11" />
                  <rect x="70" y="130" width="30" height="15" fill="#3d0c11" />
                  <rect x="110" y="140" width="15" height="45" fill="#3d0c11" />
                  <rect x="145" y="145" width="40" height="10" fill="#3d0c11" />
                  <rect x="160" y="165" width="25" height="25" fill="#3d0c11" />
                  <rect x="75" y="175" width="20" height="15" fill="#3d0c11" />
                </svg>
                <div class="mt-3 text-center">
                  <span class="fw-bold small text-muted" style="font-size: 11px;">NMID: ID1020084729183</span>
                </div>
              </div>
              
              <button type="button" id="btnConfirmQris" class="btn btn-primary rounded-pill px-5 py-2.5 fw-bold">
                I Have Scanned and Paid <i class="fa-solid fa-circle-check ms-2"></i>
              </button>
            </div>
            
          <!-- CREDIT CARD PAYMENT METHOD -->
          <?php elseif ($method === 'card'): ?>
            <div>
              <h5 class="fw-bold text-body text-center mb-3">Pay with Credit / Debit Card</h5>
              
              <!-- Live Credit Card Mockup Display -->
              <div class="card-container">
                <div class="credit-card-mockup">
                  <div class="cc-logo" id="ccLogo">Card</div>
                  <div class="cc-chip"></div>
                  <div class="cc-number" id="ccDisplayNumber">•••• •••• •••• ••••</div>
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <div class="cc-label">Card Holder</div>
                      <div class="cc-holder" id="ccDisplayHolder">Your Name</div>
                    </div>
                    <div>
                      <div class="cc-label">Expires</div>
                      <div class="cc-expiry" id="ccDisplayExpiry">MM/YY</div>
                    </div>
                  </div>
                </div>
              </div>
              
              <!-- CC Form -->
              <form id="ccForm" class="d-flex flex-column gap-3" style="max-width: 480px; margin: 0 auto;">
                <div class="mb-2">
                  <label class="form-label small fw-bold text-uppercase text-muted">Card Number</label>
                  <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-regular fa-credit-card"></i></span>
                    <input type="text" class="form-control border-start-0" id="ccNumber" placeholder="XXXX XXXX XXXX XXXX" maxlength="19" required>
                  </div>
                </div>
                
                <div class="mb-2">
                  <label class="form-label small fw-bold text-uppercase text-muted">Cardholder Name</label>
                  <input type="text" class="form-control" id="ccHolder" placeholder="e.g. John Doe" required>
                </div>
                
                <div class="row">
                  <div class="col-6 mb-2">
                    <label class="form-label small fw-bold text-uppercase text-muted">Expiry Date</label>
                    <input type="text" class="form-control" id="ccExpiry" placeholder="MM/YY" maxlength="5" required>
                  </div>
                  <div class="col-6 mb-2">
                    <label class="form-label small fw-bold text-uppercase text-muted">CVV / CVN</label>
                    <input type="password" class="form-control" id="ccCvv" placeholder="•••" maxlength="4" required>
                  </div>
                </div>
                
                <button type="submit" class="btn btn-primary w-100 rounded-pill py-3 fw-bold mt-2">
                  Pay Now (Rp <?= number_format($total, 0, ',', '.') ?>) <i class="fa-solid fa-shield-halved ms-2"></i>
                </button>
              </form>
            </div>
            
          <!-- BANK VIRTUAL ACCOUNT METHOD -->
          <?php elseif ($method === 'bank'): ?>
            <div>
              <h5 class="fw-bold text-body text-center mb-3">Bank Transfer Virtual Account</h5>
              <p class="text-muted small text-center mb-4">Please transfer the exact amount to the Virtual Account details listed below.</p>
              
              <div class="p-4 bg-light rounded-4 mb-4 border" style="max-width: 480px; margin: 0 auto;">
                <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-2">
                  <span class="text-muted small fw-bold">BANK NAME</span>
                  <span class="fw-bold text-primary">BCA Virtual Account</span>
                </div>
                <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-2">
                  <span class="text-muted small fw-bold">ACCOUNT NUMBER</span>
                  <div class="d-flex align-items-center gap-2">
                    <span class="fw-bold fs-5 text-body" id="vaNumber">8801208129482910</span>
                    <button class="btn btn-sm btn-outline-primary py-0 px-2 rounded-pill text-uppercase fw-bold" style="font-size: 9px;" id="btnCopyVA">Copy</button>
                  </div>
                </div>
                <div class="d-flex align-items-center justify-content-between">
                  <span class="text-muted small fw-bold">TOTAL AMOUNT</span>
                  <span class="fw-bold text-body">Rp <?= number_format($total, 0, ',', '.') ?></span>
                </div>
              </div>
              
              <!-- Payment Instructions Accordion -->
              <div class="accordion mb-4" id="instructionsAccordion" style="max-width: 480px; margin: 0 auto;">
                <div class="accordion-item rounded-3 border overflow-hidden mb-2">
                  <h2 class="accordion-header" id="headingATM">
                    <button class="accordion-button collapsed fw-bold small text-body" type="button" data-bs-toggle="collapse" data-bs-target="#collapseATM" aria-expanded="false" aria-controls="collapseATM">
                      ATM Transfer Instructions
                    </button>
                  </h2>
                  <div id="collapseATM" class="accordion-collapse collapse" aria-labelledby="headingATM" data-bs-parent="#instructionsAccordion">
                    <div class="accordion-body small text-secondary">
                      <ol class="mb-0 ps-3">
                        <li>Insert your ATM Card and PIN.</li>
                        <li>Select <strong>Other Transactions</strong> > <strong>Transfer</strong> > <strong>To BCA Virtual Account</strong>.</li>
                        <li>Enter the Virtual Account number: <strong>8801208129482910</strong>.</li>
                        <li>Verify transfer details (Amount: Rp <?= number_format($total, 0, ',', '.') ?>) and confirm.</li>
                      </ol>
                    </div>
                  </div>
                </div>
                <div class="accordion-item rounded-3 border overflow-hidden">
                  <h2 class="accordion-header" id="headingMobile">
                    <button class="accordion-button collapsed fw-bold small text-body" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMobile" aria-expanded="false" aria-controls="collapseMobile">
                      Mobile / Internet Banking Instructions
                    </button>
                  </h2>
                  <div id="collapseMobile" class="accordion-collapse collapse" aria-labelledby="headingMobile" data-bs-parent="#instructionsAccordion">
                    <div class="accordion-body small text-secondary">
                      <ol class="mb-0 ps-3">
                        <li>Log in to your Mobile Banking app.</li>
                        <li>Select <strong>m-Transfer</strong> > <strong>BCA Virtual Account</strong>.</li>
                        <li>Enter or select Virtual Account number: <strong>8801208129482910</strong>.</li>
                        <li>The system will retrieve transaction amount automatically. Confirm your transaction pin to complete transfer.</li>
                      </ol>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="text-center">
                <button type="button" id="btnConfirmBank" class="btn btn-primary rounded-pill px-5 py-2.5 fw-bold">
                  Confirm Payment Status <i class="fa-solid fa-circle-check ms-2"></i>
                </button>
              </div>
            </div>
          <?php endif; ?>
          
        </div>
      </div>
      
    </div>
  </div>
</section>

<script>
document.addEventListener("DOMContentLoaded", function() {
  // 1. Countdown Timer Logic (15:00 minutes)
  let timerDuration = 15 * 60; // 15 minutes
  const countdownTimer = document.getElementById("countdownTimer");

  const intervalId = setInterval(function() {
    let minutes = Math.floor(timerDuration / 60);
    let seconds = timerDuration % 60;

    minutes = minutes < 10 ? "0" + minutes : minutes;
    seconds = seconds < 10 ? "0" + seconds : seconds;

    countdownTimer.innerText = minutes + ":" + seconds;

    if (--timerDuration < 0) {
      clearInterval(intervalId);
      countdownTimer.innerText = "EXPIRED";
      alert("Payment window has expired. Please place your order again.");
      window.location.href = "pricing.php";
    }
  }, 1000);

  // 2. Redirect back helper
  function completePayment() {
    // Redirect to onboarding page (post-purchase)
    window.location.href = "onboarding.php?token=<?= $draft_token ?>&package=<?= $packageName ?>";
  }

  // QRIS Confirm Button
  const btnConfirmQris = document.getElementById("btnConfirmQris");
  if (btnConfirmQris) {
    btnConfirmQris.addEventListener("click", completePayment);
  }

  // Bank VA Confirm Button
  const btnConfirmBank = document.getElementById("btnConfirmBank");
  if (btnConfirmBank) {
    btnConfirmBank.addEventListener("click", completePayment);
  }

  // Bank VA Clipboard Copy Button
  const btnCopyVA = document.getElementById("btnCopyVA");
  if (btnCopyVA) {
    btnCopyVA.addEventListener("click", function() {
      const vaNumber = document.getElementById("vaNumber").innerText;
      navigator.clipboard.writeText(vaNumber).then(function() {
        btnCopyVA.innerText = "Copied!";
        btnCopyVA.className = "btn btn-sm btn-success py-0 px-2 rounded-pill text-uppercase fw-bold";
        setTimeout(function() {
          btnCopyVA.innerText = "Copy";
          btnCopyVA.className = "btn btn-sm btn-outline-primary py-0 px-2 rounded-pill text-uppercase fw-bold";
        }, 2000);
      });
    });
  }

  // 3. Credit Card Input Real-time Live Display Binding & Form submit
  const ccNumberInput = document.getElementById("ccNumber");
  const ccHolderInput = document.getElementById("ccHolder");
  const ccExpiryInput = document.getElementById("ccExpiry");
  const ccForm = document.getElementById("ccForm");

  const ccDisplayNumber = document.getElementById("ccDisplayNumber");
  const ccDisplayHolder = document.getElementById("ccDisplayHolder");
  const ccDisplayExpiry = document.getElementById("ccDisplayExpiry");
  const ccLogo = document.getElementById("ccLogo");

  if (ccForm) {
    // Live update card number format as user types
    ccNumberInput.addEventListener("input", function(e) {
      let value = e.target.value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
      
      // Auto-detect brand logo
      if (value.startsWith('4')) {
        ccLogo.innerText = "Visa";
        ccLogo.style.color = "#00e5ff";
      } else if (value.startsWith('5')) {
        ccLogo.innerText = "Mastercard";
        ccLogo.style.color = "#ff9100";
      } else {
        ccLogo.innerText = "Card";
        ccLogo.style.color = "#fff";
      }

      // Group digits in fours
      let formatted = "";
      for (let i = 0; i < value.length; i++) {
        if (i > 0 && i % 4 === 0) {
          formatted += " ";
        }
        formatted += value[i];
      }
      e.target.value = formatted;

      // Update mock card label
      ccDisplayNumber.innerText = formatted.padEnd(19, '•').substring(0, 19);
    });

    // Live update card holder
    ccHolderInput.addEventListener("input", function(e) {
      let value = e.target.value;
      ccDisplayHolder.innerText = value ? value : "Your Name";
    });

    // Live update expiry formatting (MM/YY)
    ccExpiryInput.addEventListener("input", function(e) {
      let value = e.target.value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
      if (value.length > 2) {
        value = value.substring(0, 2) + "/" + value.substring(2, 4);
      }
      e.target.value = value;
      ccDisplayExpiry.innerText = value ? value : "MM/YY";
    });

    // Submit Simulated Validation
    ccForm.addEventListener("submit", function(e) {
      e.preventDefault();
      
      const number = ccNumberInput.value.replace(/\s/g, '');
      const holder = ccHolderInput.value.trim();
      const expiry = ccExpiryInput.value.trim();
      const cvv = document.getElementById("ccCvv").value;

      if (number.length < 16) {
        alert("Please enter a valid 16-digit credit card number.");
        return;
      }
      if (expiry.length < 5) {
        alert("Please enter card expiry date in MM/YY format.");
        return;
      }
      if (cvv.length < 3) {
        alert("Please enter your CVV.");
        return;
      }

      // Successful simulated card validation redirect
      completePayment();
    });
  }
});
</script>

<?php
$content = ob_get_clean();
include ROOT_PATH . 'includes/layouts/app.php';
?>
