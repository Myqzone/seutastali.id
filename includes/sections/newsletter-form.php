<?php

/**
 * Newsletter Subscribe Section
 * Displays newsletter form with AJAX submit
 * Reusable across all pages
 * 
 * Required: ASSETS_URL, STATIC_URL constants
 */
?>

<!-- Subscribe Newsletter (footer band) -->
<section class="py-5" id="newsletter">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card h-100 rounded-4 p-4 p-lg-5" data-aos="fade-up" data-aos-delay="100" data-aos-duration="800">
                    <div class="card-body row align-items-center g-4">
                        <div class="col-12 col-lg-6 text-center text-lg-start">
                            <h3 class="fw-bold mb-3 fs-1">Subscribe our newsletter</h3>
                            <p class="mb-0">Get insights and updates about your child's growth and development delivered to your inbox.</p>
                        </div>
                        <div class="col-12 col-lg-6">
                            <p class="mb-3 text-center text-lg-start">Stay up to date</p>
                            <div id="subscribeFormWrapper">
                                <form id="newsletterForm" class="d-flex flex-column flex-sm-row align-items-stretch gap-2" novalidate>
                                    <input type="email" name="newsletter_email" class="form-control rounded-pill" placeholder="Enter your email" required>
                                    <button type="submit" class="btn btn-primary w-100 w-lg-auto flex-shrink-0">
                                        Subscribe
                                    </button>
                                </form>
                                <small class="d-block mt-3 text-center text-lg-start">By subscribing you agree to our <a href="<?= STATIC_URL ?>privacy-policy" class="text-decoration-underline fw-medium text-nowrap">Privacy Policy</a></small>
                            </div>
                            <div id="subscribeErrorWrapper" style="display: none;">
                                <div class="alert mb-0 d-flex align-items-center justify-content-center newsletter-alert-error" role="alert">
                                    <span class="fw-medium">This email is already registered.</span>
                                </div>
                                <small class="d-block mt-3 newsletter-policy">By subscribing you agree to our <a href="<?= STATIC_URL ?>privacy-policy" class="text-decoration-underline fw-medium newsletter-policy-link">Privacy Policy</a></small>
                            </div>
                            <div id="subscribeSuccessWrapper" style="display: none;">
                                <div class="alert mb-0 d-flex align-items-center justify-content-center newsletter-alert-success" role="alert">
                                    <div class="d-flex align-items-center justify-content-center w-100">
                                        <span class="fw-medium">Thank you! You're subscribed.</span>
                                    </div>
                                </div>
                                <small class="d-block mt-3 newsletter-policy">By subscribing you agree to our <a href="<?= STATIC_URL ?>privacy-policy" class="text-decoration-underline fw-medium newsletter-policy-link">Privacy Policy</a></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    const newsletterForm = document.getElementById('newsletterForm');
    const emailInput = newsletterForm.querySelector('input[name="newsletter_email"]');

    // Remove invalid state when user starts typing
    emailInput.addEventListener('input', function() {
        if (this.value.trim()) {
            this.classList.remove('is-invalid');
            newsletterForm.classList.remove('was-validated');
        }
    });

    newsletterForm.addEventListener('submit', function(e) {
        e.preventDefault();

        const emailInput = this.querySelector('input[name="newsletter_email"]');

        // Check validation
        if (!this.checkValidity() || !emailInput.value.trim()) {
            this.classList.add('was-validated');
            emailInput.classList.add('is-invalid');
            emailInput.focus();
            return;
        }

        emailInput.classList.remove('is-invalid');
        this.classList.remove('was-validated');
        const formData = new FormData(this);

        fetch('/api/newsletter.php', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.type === 'success') {
                    document.getElementById('subscribeFormWrapper').style.display = 'none';
                    document.getElementById('subscribeErrorWrapper').style.display = 'none';
                    document.getElementById('subscribeSuccessWrapper').style.display = 'block';

                    setTimeout(function() {
                        document.getElementById('subscribeFormWrapper').style.display = 'block';
                        document.getElementById('subscribeSuccessWrapper').style.display = 'none';
                        document.getElementById('newsletterForm').reset();
                        emailInput.classList.remove('is-invalid');
                        document.getElementById('newsletterForm').classList.remove('was-validated');
                    }, 5000);
                } else {
                    document.getElementById('subscribeFormWrapper').style.display = 'none';
                    document.getElementById('subscribeSuccessWrapper').style.display = 'none';
                    document.getElementById('subscribeErrorWrapper').style.display = 'block';

                    setTimeout(function() {
                        document.getElementById('subscribeFormWrapper').style.display = 'block';
                        document.getElementById('subscribeErrorWrapper').style.display = 'none';
                        document.getElementById('newsletterForm').reset();
                        emailInput.classList.remove('is-invalid');
                        document.getElementById('newsletterForm').classList.remove('was-validated');
                    }, 5000);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Maaf, terjadi kesalahan. Coba lagi nanti.');
            });
    });
</script>