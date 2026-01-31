<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buku Kasir @ Aplikasi POS Pendukung UMKM Lebih Pasti</title>
    <link rel="shortcut icon" href="{{ asset('images/logo-icon.png') }}">
    <link rel="stylesheet" href="{{ asset('css/homepage.css') }}">
</head>
<body>

    <!-- Header -->
    <header>
        <div class="logo">
            <a href="https://bukukasir.co.id">
                <img src="{{ asset('images/main-logo1.png') }}" alt="Buku Kasir Logo" class="main-logo">
            </a>
        </div>

        <nav>
            <ul class="menu">
                <li class="dropdown">
                    <a href="#">Layanan ▾</a>
                    <ul class="submenu">
                        <li><a href="#">POS</a></li>
                        <li><a href="#">Inventory</a></li>
                        <li><a href="#">Laporan</a></li>
                    </ul>
                </li>
                <li><a href="#">Hardware</a></li>
                <li><a href="#">Harga</a></li>
                <li><a href="#">Hubungi Kami</a></li>
                <li><a href="#">Blog</a></li>
                <li class="dropdown">
                    <a href="#">Solusi Bisnis ▾</a>
                    <ul class="submenu">
                        <li><a href="#">Retail</a></li>
                        <li><a href="#">F&B</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#">Tambahan ▾</a>
                    <ul class="submenu">
                        <li><a href="#">Integrasi</a></li>
                        <li><a href="#">API</a></li>
                    </ul>
                </li>
            </ul>
        </nav>

        <div class="auth-buttons">
            <a href="#" class="login">Log In</a>
            <a href="#" class="cta">Coba gratis</a>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-content">
            <h1>Aplikasi Kasir & Pembukuan untuk UMKM</h1>
            <p>Catat semua pembukuan dalam bisnis secara otomatis</p>

            <div class="feature-buttons">
                <span>Aplikasi Kasir</span>
                <span>Inventori</span>
                <span>Laporan Bisnis</span>
                <span>Marketing</span>
                <span>Manajemen Karyawan</span>
                <span>Akuntansi</span>
            </div>

            <div class="cta-buttons">
                <a href="#" class="btn-orange">Coba Gratis</a>
                <a href="#" class="btn-white">Whatsapp Kami Sekarang</a>
            </div>
        </div>

        <div class="business-slider">
            <div class="business-slide active">
                <img src="{{ asset('images/slider1.png') }}" alt="Food & Beverage">
            </div>
            <div class="business-slide">
                <img src="{{ asset('images/slider2.png') }}" alt="Toko Retail">
            </div>
            <div class="business-slide">
                <img src="{{ asset('images/slider3.png') }}" alt="Services">
            </div>
            <div class="business-slide">
                <img src="{{ asset('images/slider4.png') }}" alt="Beauty">
            </div>

            <div class="business-nav">
                <button class="nav-tab active" data-slide="0">Food & Beverage</button>
                <button class="nav-tab" data-slide="1">Toko Retail</button>
                <button class="nav-tab" data-slide="2">Services</button>
                <button class="nav-tab" data-slide="3">Beauty</button>
            </div>

            <div class="business-caption">
                <div class="caption-item active">
                    <h3>Food & Beverage</h3>
                    <p>Kelola pesanan, stok, dan pembayaran dengan cepat untuk bisnis kuliner Anda.</p>
                </div>
                <div class="caption-item">
                    <h3>Toko Retail</h3>
                    <p>Atur inventori, penjualan, dan laporan real-time untuk toko retail.</p>
                </div>
                <div class="caption-item">
                    <h3>Services</h3>
                    <p>Permudah pengelolaan layanan dan pembayaran untuk berbagai jenis jasa.</p>
                </div>
                <div class="caption-item">
                    <h3>Salon & Barbershop</h3>
                    <p>Berikan komisi untuk karyawan sesuai layanan dan produk, plus cek absensi & jadwal shift.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- POS Section 1 -->
    <section class="pos-section">
        <div class="pos-container">
            <div class="pos-image">
                <img src="{{ asset('images/slider1.png') }}" alt="POS Image">
            </div>

            <div class="pos-content">
                <p class="pos-subtitle">Buku Kasir Point of Sale</p>
                <h2 class="pos-title">
                    Kelola usaha offline<br>
                    Anda dengan<br>
                    Aplikasi Buku Kasir
                </h2>
                <p class="pos-desc">
                    Kami membantu Anda mendapatkan data-data menarik dari transaksi Anda
                    sehingga Anda bisa menjual lebih banyak lagi.
                </p>
                <a href="#" class="pos-link">Pelajari <span>→</span></a>
            </div>
        </div>
    </section>

    <!-- POS Section 2 -->
    <section class="pos-section">
        <div class="pos-container">
            <div class="pos-content">
                <p class="pos-subtitle">Buku Kasir Order</p>
                <h2 class="pos-title">
                    Kelola Pesanan<br>
                    Lebih cepat &<br>
                    akurat dengan<br>
                    Contactless Order
                </h2>
                <p class="pos-desc">
                    Terima ragam pilihan cara pesan yang lebih cepat dan akurat untuk bisnis kuliner,
                    mulai dari dine-in, pick-up, hingga delivery.
                </p>
                <a href="#" class="pos-link">Pelajari <span>→</span></a>
            </div>

            <div class="pos-image">
                <img src="{{ asset('images/slider2.png') }}" alt="POS Image">
            </div>
        </div>
    </section>

    <!-- Why Section -->
    <section class="why-section">
        <div class="why-container">
            <h2 class="why-title">Kenapa Harus <span>Buku Kasir?</span></h2>

            <div class="why-grid">
                <div class="why-card">
                    <img src="{{ asset('images/icon-reliable.png') }}" alt="Kehandalan">
                    <h3>All in One App</h3>
                    <p>Menawarkan solusi aplikasi yang handal dan memberikan keyakinan bahwa proses penjualan, inventori, karyawan, hingga akuntansi berjalan dengan lancar dan akurat.</p>
                </div>

                <div class="why-card">
                    <img src="{{ asset('images/icon-easy.png') }}" alt="Kemudahan">
                    <h3>Kemudahan Penggunaan</h3>
                    <p>Dirancang dengan desain ramah pengguna, mudah dipahami oleh siapa pun.</p>
                </div>

                <div class="why-card">
                    <img src="{{ asset('images/icon-customer.png') }}" alt="Keamanan">
                    <h3>Keamanan Terjamin</h3>
                    <p>Dilengkapi fitur keamanan privacy untuk mengatur level akses karyawan.</p>
                </div>

                <div class="why-card">
                    <img src="{{ asset('images/icon-innovation.png') }}" alt="Harga">
                    <h3>Harga Kompetitif</h3>
                    <p>Pilihan harga langganan sesuai kebutuhan bisnis.</p>
                </div>

                <div class="why-card">
                    <img src="{{ asset('images/icon-law.png') }}" alt="Ekosistem Digital">
                    <h3>Ekosistem Digital Terbaik</h3>
                    <p>Layanan digital lengkap: pembelian supplies, penyediaan modal, promosi digital.</p>
                </div>

                <div class="why-card">
                    <img src="{{ asset('images/icon-ecosystem.png') }}" alt="Customer Support">
                    <h3>Customer Support</h3>
                    <p>Hotline & support 24 jam yang responsif.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section class="pricing-section">
        <div class="pricing-header">
            <h1>Dapatkan Harga Hemat Untuk</h1>
            <h2>Semua Fitur Hebat</h2>

            <div class="pricing-toggle">
                <span class="toggle-label active" data-type="monthly">Per bulan</span>
                <label class="toggle-switch">
                    <input type="checkbox" id="toggle-pricing">
                    <span class="toggle-slider"></span>
                </label>
                <span class="toggle-label" data-type="yearly">Per tahun</span>
            </div>

            <div class="discount-badge">Hemat 35% untuk langganan tahunan</div>
        </div>

        <div class="pricing-cards">
            <!-- Free Plan -->
            <div class="pricing-card free">
                <div class="plan-name">Free</div>
                <div class="price" data-monthly="Rp 0" data-yearly="Rp 0">Rp 0</div>
                <div class="price-period">Gratis sekarang</div>
                <a href="#" class="cta-button free">Daftar Gratis Sekarang</a>
                <ul class="features-list">
                    <li>1 User</li>
                    <li>Monitor Biaya Pengeluaran</li>
                    <li>Penjualan & Pembelian</li>
                    <li>Monitor Saldo Kas & Bank</li>
                </ul>
            </div>

            <!-- Dynamic Plans -->
            @foreach ($prices as $price)
                <div class="pricing-card {{ strtolower($price->name) }}">
                    <div class="plan-name">{{ $price->nama }}</div>
                    <div class="price"
                         data-monthly="Rp {{ number_format($price->harga, 0, ',', '.') }}"
                         data-yearly="Rp {{ number_format($price->harga * 12 * 0.65, 0, ',', '.') }}">
                        Rp {{ number_format($price->harga, 0, ',', '.') }}
                    </div>
                    <div class="price-period">Per bulan dibayar per tahun</div>
                    <a href="#" class="cta-button">Coba Gratis Sekarang</a>
                    <div class="feature-note">Semua fitur paket {{ $price->nama }}</div>
                    <ul class="features-list">
                        @if($price->nama === 'Basic')
                            <li>1 User</li>
                            <li>1 Gudang</li>
                            <li>Alur Bisnis Lengkap</li>
                            <li>Manajemen Stok</li>
                            <li>Multi Cabang & Multi Proyek</li>
                        @elseif($price->nama === 'Advance')
                            <li>2 User</li>
                            <li>10 Gudang</li>
                            <li>Produk Manufaktur</li>
                            <li>Marketplace Connect ***</li>
                            <li>Advance Sales Commission</li>
                            <li>Custom Template Invoice ***</li>
                        @elseif($price->nama === 'Expert')
                            <li>5 User</li>
                            <li>20 Gudang</li>
                            <li>Budgeting</li>
                            <li>Konsolidasi Anak Perusahaan</li>
                            <li>Multi Currency</li>
                            <li>Approval</li>
                        @else
                            <li>Fitur dasar paket {{ $price->name }}</li>
                        @endif
                    </ul>
                </div>
            @endforeach
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq-section">
        <h2 class="faq-title">FAQ</h2>

        <div class="faq-item">
            <div class="faq-question">
                <span>Apa itu Buku Kasir?</span>
                <span class="faq-icon">▼</span>
            </div>
            <div class="faq-answer">
                <p>Buku Kasir adalah aplikasi kasir (Point of Sale) berbasis cloud yang membantu bisnis mengelola transaksi dan laporan penjualan dengan mudah.</p>
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question">
                <span>Bagaimana cara menggunakan aplikasi kasir/POS dari Buku Kasir?</span>
                <span class="faq-icon">▼</span>
            </div>
            <div class="faq-answer">
                <p>Anda dapat mengunduh aplikasi Buku Kasir, login dengan akun Anda, lalu mulai menambahkan produk dan melakukan transaksi.</p>
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question">
                <span>Berapa biaya berlangganan Buku Kasir?</span>
                <span class="faq-icon">▼</span>
            </div>
            <div class="faq-answer">
                <p>Biaya berlangganan bervariasi tergantung paket yang dipilih. Anda dapat melihat detail harga di section pricing di atas.</p>
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question">
                <span>Bagaimana cara mendaftar Buku Kasir?</span>
                <span class="faq-icon">▼</span>
            </div>
            <div class="faq-answer">
                <p>Kunjungi aplikasi Buku Kasir, klik "Daftar", isi data bisnis Anda, lalu ikuti panduan pendaftaran yang tersedia.</p>
            </div>
        </div>
    </section>

    <!-- Trainer Section -->
    <section class="trainer">
        <div class="trainer-content">
            <div class="trainer-logo">
                <img src="{{ asset('images/main-logo2.png') }}" alt="Logo">
            </div>
            <h1>Solusi tepat untuk akselerasikan bisnis lebih pesat</h1>
            <p>
                Buku Kasir mempermudah operasional dan finansial bisnis agar Anda fokus
                pada perkembangan dan pengambilan keputusan lebih baik.
            </p>
            <div class="trainer-buttons">
                <a href="#" class="btn-whatsapp">WhatsApp sales</a>
                <a href="#" class="btn-outline">Mulai gratis</a>
            </div>
        </div>

        <div class="trainer-features">
            <div class="feature-item">
                <div class="feature-icon">🎓</div>
                <h3>Training gratis</h3>
                <p>Bantuan implementasi hingga training tanpa biaya tambahan</p>
            </div>
            <div class="feature-divider"></div>
            <div class="feature-item">
                <div class="feature-icon">💬</div>
                <h3>Live chat support</h3>
                <p>Bantuan kendala dan pertanyaan seputar penggunaan Buku Kasir</p>
            </div>
            <div class="feature-divider"></div>
            <div class="feature-item">
                <div class="feature-icon">🔐</div>
                <h3>ISO 27001</h3>
                <p>Jaminan keamanan data berstandar dunia</p>
            </div>
        </div>
    </section>

    <script src="{{ asset('js/homepage.js') }}"></script>
</body>
</html>
