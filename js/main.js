(function ($) {
    "use strict";

    // Spinner
    var spinner = function () {
        setTimeout(function () {
            if ($('#spinner').length > 0) {
                $('#spinner').removeClass('show');
            }
        }, 1);
    };
    spinner();
    
    
    // Initiate the wowjs
    new WOW().init();


    // Sticky Navbar
    $(window).scroll(function () {
        if ($(this).scrollTop() > 45) {
            $('.nav-bar').addClass('sticky-top');
        } else {
            $('.nav-bar').removeClass('sticky-top');
        }
    });
    
    
    // Back to top button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            $('.back-to-top').fadeIn('slow');
        } else {
            $('.back-to-top').fadeOut('slow');
        }
    });
    $('.back-to-top').click(function () {
        $('html, body').animate({scrollTop: 0}, 1500, 'easeInOutExpo');
        return false;
    });


    // Active nav link on scroll
    var sections = [
        { id: '#proyects',   link: 'a[href="#proyects"]' },
        { id: '#about',      link: 'a[href="#about"]' },
        { id: '#contact-us', link: 'a[href="#contact-us"]' },
    ];

    $(window).on('scroll', function () {
        var scrollY = $(this).scrollTop() + 120;

        // Quitar activo de todos
        $('.navbar-nav .nav-link').removeClass('active');

        // Marcar el que corresponde
        var matched = false;
        for (var i = sections.length - 1; i >= 0; i--) {
            var $section = $(sections[i].id);
            if ($section.length && scrollY >= $section.offset().top) {
                $(sections[i].link).closest('.nav-item, .nav-link').find('.nav-link').addClass('active');
                $(sections[i].link).addClass('active');
                matched = true;
                break;
            }
        }

        // Si no hay sección activa → marcar Inicio
        if (!matched) {
            $('a[href="index.html"]').first().addClass('active');
        }
    });

    // Cerrar menú móvil al hacer clic en un enlace
    $('.navbar-nav .nav-link:not(.dropdown-toggle)').on('click', function () {
        if ($('.navbar-collapse').hasClass('show')) {
            $('.navbar-toggler').trigger('click');
        }
    });


    // Header carousel
    $(".header-carousel").owlCarousel({
        autoplay: true,
        autoplayTimeout: 5000,
        smartSpeed: 800,
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        items: 1,
        dots: false,
        loop: true,
        nav: true,
        navText: [
            '<i class="bi bi-chevron-left"></i>',
            '<i class="bi bi-chevron-right"></i>'
        ]
    });


    // Testimonials carousel
    $(".testimonial-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1000,
        margin: 24,
        dots: false,
        loop: true,
        nav : true,
        navText : [
            '<i class="bi bi-arrow-left"></i>',
            '<i class="bi bi-arrow-right"></i>'
        ],
        responsive: {
            0:{
                items:1
            },
            992:{
                items:2
            }
        }
    });
    
})(jQuery);

