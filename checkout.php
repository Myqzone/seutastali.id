<?php
// Load bootstrap
require_once __DIR__ . '/config/bootstrap.php';

/** @var mysqli $conn */
global $conn;

// Prevent null connection warning in IDE and halt if database unavailable
if (!isset($conn) || !$conn || $conn->connect_error) {
    die("Database connection is not available.");
}

// Initialize session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Fetch token from GET or SESSION
$draft_token = isset($_GET['token']) ? htmlspecialchars($_GET['token']) : (isset($_SESSION['active_draft_token']) ? $_SESSION['active_draft_token'] : '');
$guest_name = isset($_SESSION['guest_name']) ? $_SESSION['guest_name'] : (isset($_GET['guest_name']) ? htmlspecialchars($_GET['guest_name']) : 'Guest Customer');
$guest_email = isset($_SESSION['guest_email']) ? $_SESSION['guest_email'] : (isset($_GET['guest_email']) ? htmlspecialchars($_GET['guest_email']) : '');

// Fetch draft data if token exists
$draft_data = null;
$subdomain = isset($_SESSION['active_subdomain']) ? $_SESSION['active_subdomain'] : '';
if (!empty($draft_token) && $draft_token !== 'mocktoken') {
    try {
        $stmt = $conn->prepare("SELECT draft_data FROM invitation_drafts WHERE draft_token = ?");
        if ($stmt) {
            $stmt->bind_param("s", $draft_token);
            $stmt->execute();
            $result = $stmt->get_result();
            $draft_row = $result->fetch_assoc();
            $stmt->close();
            
            if ($draft_row) {
                $draft_data = json_decode($draft_row['draft_data'], true);
            }
        }
    } catch (Exception $e) {
        // Fallback silently
    }
}

// Map packages in English
$packages = [
    'Dasar' => [
        'name' => 'Dasar (Basic Package)',
        'price' => 149000,
        'duration' => '30 Days'
    ],
    'Lengkap' => [
        'name' => 'Lengkap (Complete Package)',
        'price' => 199000,
        'duration' => '60 Days'
    ],
    'Eksklusif' => [
        'name' => 'Eksklusif (Exclusive Package)',
        'price' => 249000,
        'duration' => '90 Days'
    ],
    'Premium' => [
        'name' => 'Premium (Ultra Package)',
        'price' => 399000,
        'duration' => '1 Year'
    ]
];

$selected_package_key = isset($_GET['package']) ? htmlspecialchars($_GET['package']) : 'Dasar';
if (!array_key_exists($selected_package_key, $packages)) {
    $selected_package_key = 'Dasar';
}
$package = $packages[$selected_package_key];

// If subdomain is empty, try to auto-generate a fallback
if (empty($subdomain) && $draft_data) {
    $groom_slug = preg_replace('/[^a-zA-Z0-9]/', '', strtolower($draft_data['groom']));
    $bride_slug = preg_replace('/[^a-zA-Z0-9]/', '', strtolower($draft_data['bride']));
    $subdomain = $groom_slug . '-' . $bride_slug;
}

// Set page meta
$page_title = 'Checkout - Seutastali';
$page_description = 'Review your digital invitation order details and finalize your purchase.';

ob_start();
?>

<style>
  .payment-method-card {
    border: 1px solid rgba(var(--c-primary-rgb), 0.2);
    border-radius: 12px;
    padding: 1rem;
    background-color: var(--c-sand-dark);
    cursor: pointer;
    transition: all 0.2s ease;
  }
  .payment-method-card:hover, .payment-method-card.active {
    border-color: var(--c-primary);
    background-color: #fffcf8;
    transform: translateY(-2px);
  }
  .payment-method-card.active {
    box-shadow: 0 0 0 2px var(--c-primary);
  }
</style>

<!-- Page Header Section -->
<section class="position-relative mt-5 mt-lg-4">
  <div class="container position-relative z-3">
    <!-- Header Title & Breadcrumb -->
    <div class="d-flex flex-column flex-md-row align-items-md-start justify-content-md-between gap-3 mb-3">
      <div class="section-header text-start mb-0 order-2 order-md-1">
        <h1 class="hero-title text-start ms-0" style="margin-left: 0 !important; margin-bottom: 0.5rem !important;">
          Secure <span class="text-primary fw-bold">Checkout</span>
        </h1>
        <p class="ms-0 text-start mb-0" style="margin-left: 0 !important; max-width: 620px;">
          Review your order details and choose your preferred payment method.
        </p>
      </div>

      <nav aria-label="breadcrumb" class="mb-0 order-1 order-md-2 align-self-start pt-md-2">
        <ol class="breadcrumb mb-0 text-uppercase fw-bold" style="font-size: 0.75rem; letter-spacing: 1px;">
          <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none text-muted">Home</a></li>
          <li class="breadcrumb-item"><a href="pricing.php" class="text-decoration-none text-muted">Pricing</a></li>
          <li class="breadcrumb-item active text-primary" aria-current="page">Checkout</li>
        </ol>
      </nav>
    </div>
  </div>
</section>

<!-- Checkout Form Content -->
<section class="pt-3 pb-5">
  <div class="container">
    <div class="row g-4">
      
      <!-- Left Column: Details & Payment Methods -->
      <div class="col-lg-7">
        
        <!-- Billing Details Card -->
        <div class="card rounded-4 p-4 mb-4">
          <h4 class="fw-bold text-primary mb-4" style="font-size: 1.25rem;">
            <i class="fa-solid fa-file-invoice me-2"></i>Billing & Invitation Details
          </h4>
          
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label small fw-bold text-uppercase text-muted">Full Name</label>
              <input type="text" class="form-control" value="<?= htmlspecialchars($guest_name) ?>" readonly>
            </div>
            
            <div class="col-md-6">
              <label class="form-label small fw-bold text-uppercase text-muted">Email Address</label>
              <input type="email" class="form-control" value="<?= htmlspecialchars($guest_email) ?>" readonly>
            </div>
            
            <?php if ($draft_data): ?>
              <div class="col-md-6">
                <label class="form-label small fw-bold text-uppercase text-muted">Groom Name</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($draft_data['groom']) ?>" readonly>
              </div>
              
              <div class="col-md-6">
                <label class="form-label small fw-bold text-uppercase text-muted">Bride Name</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($draft_data['bride']) ?>" readonly>
              </div>
              
              <div class="col-12">
                <label class="form-label small fw-bold text-uppercase text-muted">Subdomain / Link</label>
                <div class="input-group">
                  <span class="input-group-text bg-light text-muted fw-bold small">seutastali.id/</span>
                  <input type="text" class="form-control" value="<?= htmlspecialchars($subdomain) ?>" readonly>
                </div>
              </div>
            <?php endif; ?>
          </div>
        </div>
        
        <!-- Payment Methods Card -->
        <div class="card rounded-4 p-4">
          <h4 class="fw-bold text-primary mb-4" style="font-size: 1.25rem;">
            <i class="fa-solid fa-credit-card me-2"></i>Select Payment Method
          </h4>
          
          <div class="d-flex flex-column gap-3">
            
            <!-- QRIS -->
            <div class="payment-method-card active" data-method="qris">
              <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-3">
                  <input class="form-check-input text-primary" type="radio" name="payment_method" id="payQris" value="qris" checked>
                  <div>
                    <label class="form-check-label fw-bold d-block text-body" for="payQris" style="cursor: pointer;">
                      QRIS / E-Wallet
                    </label>
                    <span class="text-muted small">Pay instantly with GoPay, OVO, Dana, LinkAja, or any QRIS app</span>
                  </div>
                </div>
                <i class="fa-solid fa-qrcode fs-3 text-primary"></i>
              </div>
            </div>
            
            <!-- Credit Card -->
            <div class="payment-method-card" data-method="card">
              <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-3">
                  <input class="form-check-input text-primary" type="radio" name="payment_method" id="payCard" value="card">
                  <div>
                    <label class="form-check-label fw-bold d-block text-body" for="payCard" style="cursor: pointer;">
                      Credit / Debit Card
                    </label>
                    <span class="text-muted small">Visa, Mastercard, JCB, or AMEX card</span>
                  </div>
                </div>
                <i class="fa-solid fa-credit-card fs-3 text-primary"></i>
              </div>
            </div>
            
            <!-- Bank Transfer -->
            <div class="payment-method-card" data-method="bank">
              <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-3">
                  <input class="form-check-input text-primary" type="radio" name="payment_method" id="payBank" value="bank">
                  <div>
                    <label class="form-check-label fw-bold d-block text-body" for="payBank" style="cursor: pointer;">
                      Virtual Account (Bank Transfer)
                    </label>
                    <span class="text-muted small">BCA, Mandiri, BNI, or BRI Virtual Account</span>
                  </div>
                </div>
                <i class="fa-solid fa-building-columns fs-3 text-primary"></i>
              </div>
            </div>
            
          </div>
        </div>
        
      </div>
      
      <!-- Right Column: Order Summary -->
      <div class="col-lg-5">
        <div class="card rounded-4 p-4">
          <h4 class="fw-bold text-primary mb-4" style="font-size: 1.25rem;">
            <i class="fa-solid fa-basket-shopping me-2"></i>Order Summary
          </h4>
          
          <div class="mb-4">
            <h5 class="fw-bold mb-1"><?= htmlspecialchars($package['name']) ?></h5>
            <p class="text-muted small mb-0">Active Period: <?= htmlspecialchars($package['duration']) ?></p>
          </div>
          
          <hr>
          
          <!-- Promo Coupon -->
          <div class="mb-4">
            <label class="form-label small fw-bold text-uppercase text-muted">Promo Coupon</label>
            <div class="input-group">
              <input type="text" class="form-control" id="couponCode" placeholder="Enter coupon code" style="border-radius: 999px 0 0 999px;">
              <button class="btn btn-primary" type="button" id="btnApplyCoupon" style="border-radius: 0 999px 999px 0; padding-left: 1.5rem; padding-right: 1.5rem;">
                Apply
              </button>
            </div>
            <div id="couponMessage" class="small mt-2" style="display: none;"></div>
          </div>
          
          <hr>
          
          <!-- Order Price Breakdown -->
          <div class="d-flex flex-column gap-2 mb-4">
            <div class="d-flex justify-content-between">
              <span class="text-muted">Subtotal</span>
              <span id="txtSubtotal" data-value="<?= $package['price'] ?>">
                Rp <?= number_format($package['price'], 0, ',', '.') ?>
              </span>
            </div>
            <div class="d-flex justify-content-between text-success" id="rowDiscount" style="display: none !important;">
              <span>Discount</span>
              <span>- Rp <span id="txtDiscount">0</span></span>
            </div>
            <div class="d-flex justify-content-between">
              <span class="text-muted">Service Fee</span>
              <span id="txtServiceFee" data-value="2500">Rp 2.500</span>
            </div>
            <hr class="my-1">
            <div class="d-flex justify-content-between align-items-center">
              <span class="fw-bold fs-5 text-body">Total Amount</span>
              <span class="fw-bold fs-4 text-primary" id="txtGrandTotal">
                Rp <?= number_format($package['price'] + 2500, 0, ',', '.') ?>
              </span>
            </div>
          </div>
          
          <!-- Final Checkout Button -->
          <button type="button" id="btnPlaceOrder" class="btn btn-primary w-100 rounded-pill py-3 fw-bold">
            Proceed to Payment <i class="fa-solid fa-arrow-right ms-2"></i>
          </button>
        </div>
      </div>
      
    </div>
  </div>
</section>

<script>
document.addEventListener("DOMContentLoaded", function() {
  const methodCards = document.querySelectorAll(".payment-method-card");
  let selectedMethod = "qris";

  // Handle visual payment method selection
  methodCards.forEach(card => {
    card.addEventListener("click", function() {
      methodCards.forEach(c => c.classList.remove("active"));
      this.classList.add("active");
      
      const radio = this.querySelector('input[type="radio"]');
      radio.checked = true;
      selectedMethod = radio.value;
    });
  });

  // Coupon Logic
  const couponInput = document.getElementById("couponCode");
  const btnApplyCoupon = document.getElementById("btnApplyCoupon");
  const couponMessage = document.getElementById("couponMessage");
  const rowDiscount = document.getElementById("rowDiscount");
  const txtDiscount = document.getElementById("txtDiscount");
  const txtGrandTotal = document.getElementById("txtGrandTotal");

  const subtotal = parseInt(document.getElementById("txtSubtotal").getAttribute("data-value"));
  const serviceFee = parseInt(document.getElementById("txtServiceFee").getAttribute("data-value"));
  let discount = 0;

  btnApplyCoupon.addEventListener("click", function() {
    const code = couponInput.value.trim().toUpperCase();
    if (!code) {
      couponMessage.style.display = "block";
      couponMessage.className = "small mt-2 text-danger";
      couponMessage.innerText = "Please enter a coupon code.";
      return;
    }

    if (code === "SEUTASTALI50") {
      discount = Math.round(subtotal * 0.5);
      couponMessage.className = "small mt-2 text-success";
      couponMessage.innerText = "50% Discount coupon applied successfully!";
    } else if (code === "WELCOME10") {
      discount = Math.round(subtotal * 0.1);
      couponMessage.className = "small mt-2 text-success";
      couponMessage.innerText = "10% Discount coupon applied successfully!";
    } else {
      discount = 0;
      couponMessage.className = "small mt-2 text-danger";
      couponMessage.innerText = "Invalid coupon code.";
    }

    // Update Pricing Breakdown UI
    if (discount > 0) {
      rowDiscount.setAttribute("style", "display: flex !important;");
      txtDiscount.innerText = new Intl.NumberFormat('id-ID').format(discount);
    } else {
      rowDiscount.setAttribute("style", "display: none !important;");
      txtDiscount.innerText = "0";
    }

    const grandTotal = subtotal - discount + serviceFee;
    txtGrandTotal.innerText = "Rp " + new Intl.NumberFormat('id-ID').format(grandTotal);
    couponMessage.style.display = "block";
  });

  // Handle final checkout button click
  const btnPlaceOrder = document.getElementById("btnPlaceOrder");
  btnPlaceOrder.addEventListener("click", function() {
    const queryParams = new URLSearchParams({
      token: "<?= $draft_token ?>",
      package: "<?= $selected_package_key ?>",
      method: selectedMethod,
      discount: discount,
      total: subtotal - discount + serviceFee
    });
    
    window.location.href = "payment.php?" + queryParams.toString();
  });
});
</script>

<?php
$content = ob_get_clean();
include ROOT_PATH . 'includes/layouts/app.php';
?>
