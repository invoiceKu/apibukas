// Contoh sederhana: Dropdown bisa juga dibuat toggle klik untuk mobile
const dropdowns = document.querySelectorAll('.dropdown');

dropdowns.forEach(drop => {
    drop.addEventListener('click', () => {
        if (window.innerWidth <= 768) {
            const submenu = drop.querySelector('.submenu');
            submenu.classList.toggle('show');
        }
    });
});

document.addEventListener('DOMContentLoaded', () => {
  const sliderEl = document.querySelector('.business-slider');
  const slides = Array.from(document.querySelectorAll('.business-slide'));
  const tabs = Array.from(document.querySelectorAll('.nav-tab'));
  const captions = Array.from(document.querySelectorAll('.caption-item'));

  if (!slides.length) return; // tidak ada slide, hentikan

  let currentIndex = 0;
  let autoplayTimer = null;
  const AUTOPLAY_INTERVAL = 4000; // ms

  function showSlide(index) {
    // normalisasi index
    index = ((index % slides.length) + slides.length) % slides.length;

    // hapus active dari semua
    slides.forEach(s => s.classList.remove('active'));
    tabs.forEach(t => t.classList.remove('active'));
    captions.forEach(c => c.classList.remove('active'));

    // set active pada elemen yang ada (cek eksistensi)
    if (slides[index]) slides[index].classList.add('active');
    if (tabs[index]) tabs[index].classList.add('active');
    if (captions[index]) captions[index].classList.add('active');

    currentIndex = index;
  }

  function nextSlide() {
    showSlide(currentIndex + 1);
  }

  function startAutoplay() {
    stopAutoplay(); // pastikan tidak double
    autoplayTimer = setInterval(nextSlide, AUTOPLAY_INTERVAL);
  }

  function stopAutoplay() {
    if (autoplayTimer) {
      clearInterval(autoplayTimer);
      autoplayTimer = null;
    }
  }

  // klik pada tab -> pindah slide dan reset autoplay
  tabs.forEach(tab => {
    tab.addEventListener('click', (e) => {
      const target = e.currentTarget;
      const idx = parseInt(target.getAttribute('data-slide'), 10);
      if (!Number.isNaN(idx)) {
        showSlide(idx);
        // restart autoplay supaya pengguna punya waktu membaca
        startAutoplay();
      }
    });
  });

  // pause saat hover (optional)
  if (sliderEl) {
    sliderEl.addEventListener('mouseenter', stopAutoplay);
    sliderEl.addEventListener('mouseleave', startAutoplay);
  }

  // inisialisasi
  showSlide(0);
  startAutoplay();

  // (opsional) exposed controls:
  // window.mySlider = { showSlide, startAutoplay, stopAutoplay };
});

 document.addEventListener('DOMContentLoaded', () => {
  const toggleSwitch = document.querySelector('#toggle-pricing');
  const toggleLabels = document.querySelectorAll('.toggle-label');
  const priceElements = document.querySelectorAll('.pricing-card .price');

  toggleSwitch.addEventListener('change', function () {
    toggleLabels.forEach(label => label.classList.toggle('active'));
    priceElements.forEach(priceEl => {
      const monthly = priceEl.getAttribute('data-monthly');
      const yearly = priceEl.getAttribute('data-yearly');
      priceEl.textContent = this.checked ? yearly : monthly;
    });
  });
});

document.addEventListener("DOMContentLoaded", function() {
    const faqItems = document.querySelectorAll(".faq-item");

    faqItems.forEach(item => {
        const question = item.querySelector(".faq-question");
        question.addEventListener("click", () => {
            item.classList.toggle("active");
        });
    });
});