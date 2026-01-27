// public/js/app.js
$(document).ready(function() {

    // Mobile Menu Toggle
    $('.header-menu-trigger').click(function(e) {
        e.preventDefault();
        // Sembunyikan atau tampilkan .main-navigation
        // Tambahkan logic untuk mengubah ikon bars/times
        alert("Mobile menu clicked! Implement navigation toggle logic here.");
    });

    // Sticky Header
    $(window).scroll(function() {
        if ($(this).scrollTop() > 50) {
            $('header').addClass('inverse');
        } else {
            $('header').removeClass('inverse');
        }
    });

    // Hero Slider Logic (Contoh Sederhana)
    let currentSlide = 0;
    const slides = $('.homepage-slider-content > div');
    const navItems = $('.homepage-navigation-item');

    function showSlide(index) {
        slides.removeClass('active').eq(index).addClass('active');
        navItems.removeClass('active').eq(index).addClass('active');
        const newImg = slides.eq(index).find('img').attr('src');
        $('#hero-image').attr('src', newImg);
    }

    navItems.click(function() {
        showSlide($(this).index());
    });

    // Auto-play slider (opsional)
    setInterval(() => {
        currentSlide = (currentSlide + 1) % slides.length;
        showSlide(currentSlide);
    }, 5000);

});