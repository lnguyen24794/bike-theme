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
    
    
    // Dropdown on mouse hover
    const $dropdown = $(".dropdown");
    const $dropdownToggle = $(".dropdown-toggle");
    const $dropdownMenu = $(".dropdown-menu");
    const showClass = "show";
    
    $(window).on("load resize", function() {
        if (this.matchMedia("(min-width: 992px)").matches) {
            $dropdown.hover(
            function() {
                const $this = $(this);
                $this.addClass(showClass);
                $this.find($dropdownToggle).attr("aria-expanded", "true");
                $this.find($dropdownMenu).addClass(showClass);
            },
            function() {
                const $this = $(this);
                $this.removeClass(showClass);
                $this.find($dropdownToggle).attr("aria-expanded", "false");
                $this.find($dropdownMenu).removeClass(showClass);
            }
            );
        } else {
            $dropdown.off("mouseenter mouseleave");
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


    // Facts counter
    $('[data-toggle="counter-up"]').counterUp({
        delay: 10,
        time: 2000
    });


    // Modal Video
    $(document).ready(function () {
        var $videoSrc;
        $('.btn-play').click(function () {
            $videoSrc = $(this).data("src");
        });

        $('#videoModal').on('shown.bs.modal', function (e) {
            $("#video").attr('src', $videoSrc + "?autoplay=1&amp;modestbranding=1&amp;showinfo=0");
        });

        $('#videoModal').on('hide.bs.modal', function (e) {
            $("#video").attr('src', $videoSrc);
        });
    }); 
    
    // Bike carousel
    $(".bike-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1000,
        margin: 25,
        dots: true,
        loop: true,
        center: true,
        responsive: {
            0:{
                items:1
            },
            576:{
                items:1
            },
            768:{
                items:2
            },
            992:{
                items:3
            }
        }
    });

    // Service carousel
    $(".service-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1000,
        margin: 25,
        dots: true,
        loop: true,
        nav : false,
        responsive: {
            0:{
                items:1
            },
            576:{
                items:1
            },
            768:{
                items:2
            },
            992:{
                items:3
            }
        }
    });

    // Team carousel
    $(".team-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1000,
        margin: 25,
        dots: true,
        loop: true,
        nav : false,
        responsive: {
            0:{
                items:1
            },
            576:{
                items:1
            },
            768:{
                items:2
            },
            992:{
                items:3
            },
            1200:{
                items:4
            }
        }
    });
    
    // Date and time picker
    $('.date').datetimepicker({
        format: 'L'
    });
    $('.time').datetimepicker({
        format: 'LT'
    });
    
    // Configure lazySizes
    window.lazySizesConfig = window.lazySizesConfig || {};
    window.lazySizesConfig.loadMode = 1;
    window.lazySizesConfig.expand = 100;
    window.lazySizesConfig.preloadAfterLoad = true;

    // Handle lazy-loaded images
    $(function() {
        // Skip elements with unlazy class
        window.lazySizesConfig.init = true;
        window.lazySizesConfig.selector = '.lazyload:not(.unlazy)';

        document.addEventListener('lazybeforeunveil', function(e) {
            var bg = e.target.getAttribute('data-bg');
            // Skip if element has unlazy class
            if (e.target.classList.contains('unlazy')) {
                return;
            }
            if (bg) {
                e.target.style.backgroundImage = 'url(' + bg + ')';
            }
        });

        // Handle error loading
        document.addEventListener('lazyunveilread', function(e) {
            var img = e.target;
            // Skip if element has unlazy class
            if (img.classList.contains('unlazy')) {
                return;
            }
            if (img.tagName === 'IMG') {
                img.addEventListener('error', function() {
                    img.classList.add('lazyload-error');
                });
            }
        });

        // Handle iframe loading
        $('.iframe-container iframe:not(.unlazy)').each(function() {
            var iframe = $(this);
            if (!iframe.attr('data-src')) {
                var src = iframe.attr('src');
                if (src) {
                    iframe.attr('data-src', src).removeAttr('src');
                    iframe.addClass('lazyload');
                }
            }
        });

        // Reinitialize lazy loading after dynamic content load
        function reinitLazyLoad() {
            if (window.lazySizes) {
                // window.lazySizes.autoInit();
            }
        }

        // Hook into Owl Carousel events
        $('.owl-carousel').on('initialized.owl.carousel translated.owl.carousel', function() {
            reinitLazyLoad();
        });

        // Hook into any Ajax complete events
        $(document).ajaxComplete(function() {
            reinitLazyLoad();
        });
    });
    
})(jQuery); 