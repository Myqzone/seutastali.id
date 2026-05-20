<?php
/**
 * Shared Templates Registry - SeutasTali
 * Location: config/templates.php
 */

if (!function_exists('get_templates')) {
    function get_templates() {
        return [
            // Adat (Classic Traditional Heritage)
            'syakira' => [
                'title' => 'Syakira',
                'category' => 'adat',
                'popular' => true,
                'image' => '3.webp',
                'alt' => 'Classic Editorial',
                'price' => 'Rp 299.000',
                'discount_price' => 'Rp 149.000',
                'description' => 'Desain undangan pernikahan bernuansa klasik editorial dengan tata letak majalah estetis. Sangat cocok bagi Anda yang menyukai perpaduan tipografi serif nan anggun dan ruang visual yang bersih serta elegan.',
                'demo_url' => 'templates/syakira',
                'features' => ['Tata Letak Editorial Klasik', 'Galeri Foto & Video Premium', 'Sistem RSVP & Buku Tamu', 'Integrasi Google Maps Interaktif', 'Musik Latar Kustom (Autoplay)']
            ],
            'kamila' => [
                'title' => 'Kamila',
                'category' => 'adat',
                'image' => '7.webp',
                'alt' => 'Classic Grace',
                'price' => 'Rp 299.000',
                'discount_price' => 'Rp 149.000',
                'description' => 'Keindahan romantis klasik yang abadi terpancar dari template Kamila. Mengedepankan ornamen garis halus yang mewah, nuansa warna pastel yang anggun, serta transisi animasi romantis yang memanjakan mata.',
                'demo_url' => 'templates/kamila',
                'features' => ['Ornamen Klasik Romantis', 'Kisah Cinta & Timeline Pernikahan', 'Fitur RSVP Realtime', 'Background Music Pilihan', 'Amplop Digital / Gift System']
            ],
            'annisa' => [
                'title' => 'Annisa',
                'category' => 'adat',
                'image' => '1.webp',
                'alt' => 'Classic Elegance',
                'price' => 'Rp 249.000',
                'discount_price' => 'Rp 129.000',
                'description' => 'Sentuhan keanggunan tradisional berpadu dengan modernitas digital. Annisa dirancang dengan aksen ukiran halus yang mewah dan kontras warna berani untuk menonjolkan setiap detail momen sakral Anda.',
                'demo_url' => 'templates/annisa',
                'features' => ['Aksen Ukiran Mewah', 'Countdown Timer Presisi', 'Konfirmasi RSVP & Ucapan', 'Google Maps Navigation', 'Format Tamu Tanpa Batas']
            ],
            'adinda' => [
                'title' => 'Adinda',
                'category' => 'adat',
                'image' => '2.webp',
                'alt' => 'Classic Royal',
                'price' => 'Rp 349.000',
                'discount_price' => 'Rp 179.000',
                'description' => 'Kemegahan kerajaan yang agung hadir dalam template Adinda. Mengusung skema warna royal emas dan ornamen tiara mewah, menjadikannya pilihan utama untuk resepsi pernikahan bertema agung nan megah.',
                'demo_url' => 'templates/adinda',
                'features' => ['Royal Gold Ornaments', 'Protokol Kesehatan Terintegrasi', 'Live Streaming Video Embed', 'Custom RSVP Dashboard', 'E-Gift & Rekening Terverifikasi']
            ],

            // Minimalis (Neubrutalist & Clean Minimalist)
            'katsudoto' => [
                'title' => 'Katsudoto',
                'category' => 'minimalis',
                'popular' => true,
                'image' => '1.webp',
                'alt' => 'Modern Neubrutalist',
                'price' => 'Rp 349.000',
                'discount_price' => 'Rp 189.000',
                'description' => 'Terinspirasi dari tren Neubrutalisme Katsudoto yang sedang viral. Memadukan warna kontras tinggi, border hitam super tebal (thick stroke), font sans-serif tebal, serta ornamen bento grid yang sangat modis dan kekinian.',
                'demo_url' => 'templates/katsudoto',
                'features' => ['Premium Bento Grid Layout', 'High Contrast Neubrutalist Shadows', 'Sistem RSVP & Live Guest Comments', 'Multi-rekening E-Wallet', 'Mobile-first Ultra Fast Loading']
            ],
            'mondrian' => [
                'title' => 'Mondrian',
                'category' => 'minimalis',
                'image' => '4.webp',
                'alt' => 'Neubrutalist Block',
                'price' => 'Rp 299.000',
                'discount_price' => 'Rp 149.000',
                'description' => 'Gaya seni rupa blok geometris Piet Mondrian yang ikonik diimplementasikan dalam bentuk undangan pernikahan digital. Menawarkan struktur asimetris, garis pembatas tebal, dan letupan warna primer yang estetik.',
                'demo_url' => 'templates/mondrian',
                'features' => ['Desain Blok Geometris Artistik', 'Animasi Hover Responsif', 'Rencana Acara & Google Calendar Integrasi', 'E-Gift Teraman', 'Unlimited Guest Names']
            ],
            'bauhaus' => [
                'title' => 'Bauhaus',
                'category' => 'minimalis',
                'image' => '5.webp',
                'alt' => 'Neubrutalist Grid',
                'price' => 'Rp 299.000',
                'discount_price' => 'Rp 159.000',
                'description' => 'Filosofi desain Bauhaus "Form Follows Function" berpadu dengan estetika Neubrutalis modern. Menampilkan grid minimalis yang sangat fungsional, tipografi tebal, dan kejelasan informasi yang luar biasa.',
                'demo_url' => 'templates/bauhaus',
                'features' => ['Estetika Minimalis Bauhaus', 'Sistem Peta Rute Navigasi', 'Integrasi RSVP Langsung ke WA', 'Music Player Elegan', 'Dark Mode Optimized']
            ],
            'brutal-chic' => [
                'title' => 'Brutal Chic',
                'category' => 'minimalis',
                'image' => '2.webp',
                'alt' => 'Neubrutalist Contrast',
                'price' => 'Rp 329.000',
                'discount_price' => 'Rp 169.000',
                'description' => 'Perpaduan sempurna antara kebrutalan desain modern dan keanggunan fashion kelas atas. Skema warna monokrom berpadu krem hangat menciptakan kontras visual premium yang mengesankan para penerima undangan Anda.',
                'demo_url' => 'templates/brutal-chic',
                'features' => ['Fashion-inspired Layout', 'Custom Font Pairings', 'Countdown Acara Eksklusif', 'Galeri Carousel Foto', 'Buku Tamu Interaktif']
            ],
            'minimalis' => [
                'title' => 'Minimalis',
                'category' => 'minimalis',
                'popular' => true,
                'image' => '5.webp',
                'alt' => 'Minimalist Chic',
                'price' => 'Rp 199.000',
                'discount_price' => 'Rp 99.000',
                'description' => 'Keindahan dalam kesederhanaan. Template Minimalis menyuguhkan ruang visual bersih yang luas (negative space), tipografi serif anggun, dan transisi halus tanpa gangguan visual yang berlebihan.',
                'demo_url' => 'templates/minimalis',
                'features' => ['Clean & Elegant Negative Space', 'Countdown Acara Minimalis', 'Integrasi Google Maps', 'RSVP Form Sederhana', 'Tamu Kustom Bebas']
            ],
            'zen' => [
                'title' => 'Zen',
                'category' => 'minimalis',
                'image' => '1.webp',
                'alt' => 'Minimalist Zen',
                'price' => 'Rp 249.000',
                'discount_price' => 'Rp 119.000',
                'description' => 'Terinspirasi dari ketenangan taman Zen Jepang. Memanfaatkan palet warna bumi (earthy tones), garis pembatas tipis yang estetik, dan alur informasi yang mengalir dengan tenang serta damai.',
                'demo_url' => 'templates/zen',
                'features' => ['Earthy Tones & Calm Design', 'Timeline Perjalanan Cinta', 'RSVP Realtime', 'Background Music Meditatif', 'Galeri Foto Slide']
            ],
            'elegance' => [
                'title' => 'Elegance',
                'category' => 'minimalis',
                'image' => '3.webp',
                'alt' => 'Minimalist Pure',
                'price' => 'Rp 249.000',
                'discount_price' => 'Rp 129.000',
                'description' => 'Desain murni berkelas tinggi untuk menonjolkan foto-foto prewedding terbaik Anda. Dibangun dengan grid proporsional yang rapi, menghasilkan presentasi visual yang memikat di setiap ukuran layar.',
                'demo_url' => 'templates/elegance',
                'features' => ['Premium Portrait Mockups', 'RSVP & Guest Book Terpadu', 'Peta Lokasi Tombol Pintar', 'Autoplay Backsound', 'Tampilan Mobile Sempurna']
            ],
            'pure-love' => [
                'title' => 'Pure Love',
                'category' => 'minimalis',
                'image' => '7.webp',
                'alt' => 'Minimalist Warm',
                'price' => 'Rp 229.000',
                'discount_price' => 'Rp 119.000',
                'description' => 'Kehangatan cinta sejati yang terpancar melalui desain minimalis bernuansa hangat. Pilihan warna krem lembut dan layout tanpa batas menciptakan kenyamanan membaca bagi setiap tamu penting Anda.',
                'demo_url' => 'templates/pure-love',
                'features' => ['Warm Canvas Style', 'Fitur Hitung Mundur Elegan', 'Amplop Digital QR Code', 'Sistem RSVP Terverifikasi', 'Peta Lokasi Instan']
            ],

            // Floral (Botanical & Floral Designs)
            'botanikal' => [
                'title' => 'Botanikal',
                'category' => 'floral',
                'popular' => true,
                'image' => '2.webp',
                'alt' => 'Romantic Botanical',
                'price' => 'Rp 249.000',
                'discount_price' => 'Rp 129.000',
                'description' => 'Desain undangan pernikahan bertema botani romantis. Dikelilingi ilustrasi dedaunan cat air (watercolor) yang indah dan estetis, memberikan kesan segar, alami, dan sangat intim.',
                'demo_url' => 'templates/botanikal',
                'features' => ['Watercolor Leaf Border', 'Wedding Timeline Estetis', 'Countdown Timer Daun', 'RSVP & Wishlist Terintegrasi', 'Musik Latar Akustik']
            ],
            'ginkgo' => [
                'title' => 'Ginkgo',
                'category' => 'floral',
                'image' => '5.webp',
                'alt' => 'Botanical Leaf',
                'price' => 'Rp 249.000',
                'discount_price' => 'Rp 129.000',
                'description' => 'Menghadirkan keindahan legendaris daun Ginkgo Biloba yang melambangkan keabadian cinta. Tata letak asimetris berpadu ilustrasi ginkgo emas tipis yang memukau di atas latar kanvas bertekstur.',
                'demo_url' => 'templates/ginkgo',
                'features' => ['Golden Ginkgo Ornaments', 'Galeri Foto Grid Unik', 'Konfirmasi RSVP Realtime', 'Background Music Pilihan', 'E-Gift & Amplop Pintar']
            ],
            'eucalyptus' => [
                'title' => 'Eucalyptus',
                'category' => 'floral',
                'image' => '6.webp',
                'alt' => 'Botanical Bloom',
                'price' => 'Rp 279.000',
                'discount_price' => 'Rp 139.000',
                'description' => 'Nuansa eucalyptus hijau sage yang menenangkan dan modern. Desain modern-botanical ini sangat populer di kalangan pasangan muda karena memberikan kesan tenang, anggun, dan bersih.',
                'demo_url' => 'templates/eucalyptus',
                'features' => ['Modern Sage Green Palette', 'Responsive Photo Carousel', 'Sistem RSVP & Buku Tamu Terintegrasi', 'Google Maps Direction', 'Music Autoplay']
            ],
            'olive-garden' => [
                'title' => 'Olive Garden',
                'category' => 'floral',
                'image' => '4.webp',
                'alt' => 'Botanical Forest',
                'price' => 'Rp 269.000',
                'discount_price' => 'Rp 129.000',
                'description' => 'Menampilkan pesona kebun zaitun Italia yang klasik dan asri. Perpaduan ranting zaitun cat air yang detail dengan aksen font romawi klasik, memberikan atmosfer pedesaan Eropa nan romantis.',
                'demo_url' => 'templates/olive-garden',
                'features' => ['Watercolor Olive Branch', 'Hitung Mundur Pernikahan Daun', 'RSVP & Guest Book Terverifikasi', 'Peta Lokasi Instan', 'Backsound Musik Pilihan']
            ],

            // Fairytale (Luxury Royal Magical Fairytale)
            'midnight' => [
                'title' => 'Midnight',
                'category' => 'fairytale',
                'popular' => true,
                'image' => '6.webp',
                'alt' => 'Dark Luxury',
                'price' => 'Rp 399.000',
                'discount_price' => 'Rp 199.000',
                'description' => 'Kemewahan malam bertabur bintang hadir dalam template Midnight. Menggunakan warna dasar hitam pekat yang dikombinasikan dengan foil emas berkilau dan marmer hitam premium, menciptakan kesan aristokrat yang megah.',
                'demo_url' => 'templates/midnight',
                'features' => ['Dark Marble Premium Background', 'Golden Foil Ornaments', 'RSVP & Live Wishlist Dashboard', 'VIP Guest Access Code', 'Autoplay Orchestral Music']
            ],
            'gold-royal' => [
                'title' => 'Gold Royal',
                'category' => 'fairytale',
                'image' => '5.webp',
                'alt' => 'Luxury Gold',
                'price' => 'Rp 399.000',
                'discount_price' => 'Rp 199.000',
                'description' => 'Desain undangan digital paling mewah dengan dominasi warna emas berkilau di atas latar kanvas sutra putih. Sangat cocok bagi Anda yang merencanakan resepsi pernikahan mewah berkapasitas besar.',
                'demo_url' => 'templates/gold-royal',
                'features' => ['White Silk & Royal Gold Motif', 'Countdown Jam Mewah', 'RSVP Terintegrasi WhatsApp & Database', 'Live Streaming Video Embed', 'Amplop Digital QR Code']
            ],
            'sapphire' => [
                'title' => 'Sapphire',
                'category' => 'fairytale',
                'image' => '2.webp',
                'alt' => 'Luxury Jewel',
                'price' => 'Rp 349.000',
                'discount_price' => 'Rp 189.000',
                'description' => 'Sentuhan keagungan batu safir biru tua yang dikelilingi oleh pola abstrak emas cair yang artistik. Menghasilkan perpaduan kontras warna mewah yang tiada duanya di dunia undangan pernikahan digital.',
                'demo_url' => 'templates/sapphire',
                'features' => ['Sapphire Liquid Gold Abstract', 'Interactive Gallery Carousel', 'Sistem RSVP Terverifikasi', 'Google Maps Pintar', 'Custom Music Player']
            ],
            'velvet-night' => [
                'title' => 'Velvet Night',
                'category' => 'fairytale',
                'image' => '7.webp',
                'alt' => 'Luxury Night',
                'price' => 'Rp 349.000',
                'discount_price' => 'Rp 179.000',
                'description' => 'Kelembutan kain beludru merah marun berpadu dengan aksen garis emas yang minimalis nan eksklusif. Velvet Night dirancang khusus bagi pasangan yang menyukai estetika mewah yang tenang, intim, dan berkelas.',
                'demo_url' => 'templates/velvet-night',
                'features' => ['Velvet Maroon Background Theme', 'Exclusive Minimalist Gold Accents', 'RSVP & Guest Book Database', 'Google Maps Navigation', 'E-Gift System']
            ],

            // Nature (Groovy Retro Nature-themed)
            'retro-chic' => [
                'title' => 'Retro Chic',
                'category' => 'nature',
                'popular' => true,
                'image' => '4.webp',
                'alt' => 'Modern Retro',
                'price' => 'Rp 249.000',
                'discount_price' => 'Rp 129.000',
                'description' => 'Desain undangan digital bertema retro modern yang penuh dengan keceriaan. Memadukan skema warna vintage pop yang kontras, ornamen berbentuk awan lembut dan bintang bersinar, serta tipografi retro nan funky.',
                'demo_url' => 'templates/retro-chic',
                'features' => ['Funky Retro Typography', 'Interactive Hover Effects', 'Buku Tamu Vintage', 'E-Gift Terintegrasi', 'Backsound Pop 80s']
            ],
            'vintage-love' => [
                'title' => 'Vintage Love',
                'category' => 'nature',
                'image' => '6.webp',
                'alt' => 'Retro Classic',
                'price' => 'Rp 249.000',
                'discount_price' => 'Rp 129.000',
                'description' => 'Bernostalgia ke masa lalu yang penuh kenangan indah. Mengusung skema warna sepia hangat, tekstur kertas tua yang realistis, serta ornamen vintage romantis untuk menceritakan kisah cinta abadi Anda.',
                'demo_url' => 'templates/vintage-love',
                'features' => ['Groovy Vintage Texture', 'Timeline Kisah Cinta Klasik', 'RSVP & Wishlist', 'Google Maps Navigation', 'Format Tamu Instan']
            ],
            'disco-fever' => [
                'title' => 'Disco Fever',
                'category' => 'nature',
                'image' => '1.webp',
                'alt' => 'Retro Neon',
                'price' => 'Rp 279.000',
                'discount_price' => 'Rp 139.000',
                'description' => 'Rayakan kebahagiaan Anda dengan kemeriahan pesta dansa era 70-an! Menawarkan kombinasi warna neon yang gemerlap, aksen piringan hitam (*vinyl record*) interaktif, serta efek animasi retro yang meriah.',
                'demo_url' => 'templates/disco-fever',
                'features' => ['Interactive Vinyl Music Player', 'Glow Neon Text Effects', 'Sistem RSVP & Buku Ucapan', 'Google Maps Direction', 'Gift System Terintegrasi']
            ],
            'groovy-day' => [
                'title' => 'Groovy Day',
                'category' => 'nature',
                'image' => '3.webp',
                'alt' => 'Retro Pop',
                'price' => 'Rp 259.000',
                'discount_price' => 'Rp 129.000',
                'description' => 'Hari pernikahan Anda adalah hari yang ceria dan penuh kebahagiaan! Groove Day menyajikan ornamen bunga pop retro 70-an, palet warna oranye-kuning pastel yang cerah, serta kehangatan tipografi groovy.',
                'demo_url' => 'templates/groovy-day',
                'features' => ['Groovy Flower Ornaments', 'Retro Countdown Timer', 'RSVP Form Responsif', 'Backsound Musik Akustik', 'Amplop Digital']
            ]
        ];
    }
}
