<?php
/**
 * Reusable FAQ Section Partial
 * Location: /includes/sections/faq.php
 */

global $conn;

// Configuration with sensible defaults
$faq_limit = isset($faq_limit) ? (int)$faq_limit : 15;
$faq_accordion_id = isset($faq_accordion_id) ? $faq_accordion_id : 'faqAccordion';
$faq_id_prefix = isset($faq_id_prefix) ? $faq_id_prefix : 'faq-';
$faq_title = isset($faq_title) ? $faq_title : 'Frequently Asked Questions';
$faq_subtitle = isset($faq_subtitle) ? $faq_subtitle : 'Temukan jawaban atas berbagai pertanyaan umum tentang pembuatan undangan digital di SeutasTali';
?>

<section class="py-5" id="faq">
    <div class="container">
        <div class="d-flex flex-column gap-4 gap-md-4">
            <!-- 1. Section Header -->
            <div class="section-header text-center" data-aos="fade-up">
                <span class="badge bg-label-primary mb-3">FAQ</span>
                <h2><?= htmlspecialchars($faq_title) ?></h2>
                <p class="text-muted"><?= htmlspecialchars($faq_subtitle) ?></p>
            </div>

            <!-- 2. Section Content -->
            <div class="section-content mx-auto w-100" data-aos="fade-up" data-aos-delay="150" style="max-width: 650px;">
                <div class="accordion accordion-flush brand-faq-accordion mb-0" id="<?= $faq_accordion_id ?>">
                    <?php
                    try {
                        if ($conn && !$conn->connect_error) {
                            $result = $conn->query("SELECT * FROM faqs ORDER BY id ASC LIMIT $faq_limit");

                            if ($result && $result->num_rows > 0) {
                                $index = 0;
                                while ($faq = $result->fetch_assoc()) {
                                    $id = $faq_id_prefix . $faq['id'];
                    ?>
                                    <div class="accordion-item position-relative"
                                         data-aos="fade-up"
                                         data-aos-delay="<?= $index * 50 ?>"
                                         data-aos-duration="1000">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed"
                                                    type="button"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#<?= $id ?>"
                                                    aria-expanded="false"
                                                    aria-controls="<?= $id ?>">
                                                <i class="fa-solid fa-plus faq-icon"></i>
                                                <?= htmlspecialchars($faq['question']) ?>
                                            </button>
                                        </h2>
                                        <div id="<?= $id ?>" class="accordion-collapse collapse" data-bs-parent="#<?= $faq_accordion_id ?>">
                                            <div class="accordion-body">
                                                <?= nl2br(htmlspecialchars($faq['answer'])) ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                    $index++;
                                }
                            } else {
                                // Static Fallback FAQ items if database table is empty or connection fails
                                $fallback_faqs = [
                                    ['q' => 'Bagaimana cara membuat undangan digital di SeutasTali?', 'a' => 'Sangat mudah! Anda hanya perlu memilih salah satu template desain yang kami sediakan, mengisi detail data pernikahan, dan membagikannya secara instan kepada para tamu.'],
                                    ['q' => 'Apakah saya bisa mengganti musik latar di undangan saya?', 'a' => 'Ya, tentu! Di paket Silver dan Gold/Editorial, Anda dibebaskan untuk mengunggah berkas musik pilihan atau menempelkan tautan lagu romantis kesukaan Anda.'],
                                    ['q' => 'Bagaimana tamu saya memberikan konfirmasi kehadiran?', 'a' => 'Undangan digital Anda dilengkapi tombol RSVP interaktif. Tamu dapat mengonfirmasi kehadiran mereka, jumlah tamu yang datang, serta menuliskan ucapan doa restu secara langsung.'],
                                    ['q' => 'Berapa lama masa aktif undangan digital saya?', 'a' => 'Masa aktif bervariasi bergantung paket yang Anda pilih: 3 bulan untuk paket Bronze, 1 tahun untuk paket Silver, dan aktif selamanya untuk paket Gold/Editorial.'],
                                ];
                                foreach ($fallback_faqs as $i => $faq) {
                                    $id = $faq_id_prefix . "fallback-" . $i;
                                ?>
                                    <div class="accordion-item position-relative">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed"
                                                    type="button"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#<?= $id ?>"
                                                    aria-expanded="false"
                                                    aria-controls="<?= $id ?>">
                                                <i class="fa-solid fa-plus faq-icon"></i>
                                                <?= htmlspecialchars($faq['q']) ?>
                                            </button>
                                        </h2>
                                        <div id="<?= $id ?>" class="accordion-collapse collapse" data-bs-parent="#<?= $faq_accordion_id ?>">
                                            <div class="accordion-body">
                                                <?= htmlspecialchars($faq['a']) ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                            }
                        } else {
                            echo '<p class="text-warning text-center small">Koneksi database bermasalah.</p>';
                        }
                    } catch (Exception $e) {
                        echo '<!-- FAQ Error: ' . htmlspecialchars($e->getMessage()) . ' -->';
                        echo '<p class="text-muted text-center">FAQ sedang diperbarui.</p>';
                    }
                    ?>
                </div>
            </div>

            <!-- 3. Section Footer -->
            <div class="section-footer text-center d-flex flex-column align-items-center" data-aos="fade-up" data-aos-delay="200">
                <p class="mb-3 text-muted small">Punya pertanyaan lain?</p>
                <a href="mailto:hello@seutastali.id" class="btn btn-primary">
                    Email Kami
                </a>
            </div>
        </div>
    </div>
</section>
