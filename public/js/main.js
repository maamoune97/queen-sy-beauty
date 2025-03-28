'use strict';

(function ($) {

    $(window).on('load', function () {
        $(".loader").fadeOut();
        $("#preloder").delay(200).fadeOut("slow");
    });

    /*------------------
      Change Background
    --------------------*/
    $('.caroussel-baground').each(function () {
        var bg = $(this).data('bgcaroussel');
        $(this).css('background-image', 'url(' + bg + ')');
    });

    /*------------------
        Caroussel
    --------------------*/
    $(".caroussel-items").owlCarousel({
        loop: true,
        margin: 0,
        nav: true,
        items: 1,
        dots: false,
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        navText: ['<i class="ti-angle-left"></i>', '<i class="ti-angle-right"></i>'],
        smartSpeed: 3500,
        autoHeight: false,
        autoplay: true,
    });

    /*------------------
        Product Slider
    --------------------*/
    $(".product-slider").owlCarousel({
        loop: true,
        margin: 30,
        nav: true,
        //autoWidth: true,
        items: 4,
        dots: true,
        navText: ['<i class="ti-angle-left"></i>', '<i class="ti-angle-right"></i>'],
        smartSpeed: 1200,
        autoHeight: true,
        autoplay: true,
        responsive: {
            0: {
                items: 1,
            },
            576: {
                items: 2,
            },
            992: {
                items: 2,
            },
            1200: {
                items: 3,
            }
        }
    });

    /*------------------
        Product relatif
    --------------------*/
    $(".related-product-slider").owlCarousel({
        loop: true,
        margin: 10,
        nav: true,
        items: 5,
        dots: false,
        navText: ['<i class="ti-angle-left"></i>', '<i class="ti-angle-right"></i>'],
        smartSpeed: 1200,
        autoHeight: true,
        responsiveClass:true,
        responsive: {
            0: {
                items: 1,
            },
            576: {
                items: 2,
            },
            992: {
                items: 3,
            },
            1200: {
                items: 4,
            }
        }
    });

    /*-----------------------
       Product Single Slider
    -------------------------*/
    $(".ps-slider").owlCarousel({
        loop: false,
        margin: 10,
        nav: true,
        items: 3,
        dots: false,
        navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true,
    });

    /*-------------------
        Range Slider
    ------------------- */


    var minprice = 2500, maxprice = 90000, step =500
    $(".slider-range").slider({
        range: true,
        min: minprice,
        max: maxprice,
        step: step,
        values: [minprice, maxprice],
        slide: function(e, ui) {
            var min = Math.floor(ui.values[0]);
            $('#minamount, #minamountmobile').val(min + ' KMF');
    
            var max = Math.floor(ui.values[1]);
            
            $('#maxamount, #maxamountmobile').val(max + ' KMF');

    
        }
    });
    $('#minamount, #minamountmobile').val(minprice + ' KMF');
    $('#maxamount, #maxamountmobile').val(maxprice + ' KMF');

    /*-------------------
        Radio Btn
    --------------------- */
    $(".fw-size .size-item-container label, .pd-size-choose .size-item-container label").on('click', function () {
        $(".fw-size .size-item-container label, .pd-size-choose .size-item-container label").removeClass('active');
        $(this).addClass('active');
    });

    $(".pd-color .pd-color-choose .color-item-container label").on('click', function () {
        $(".pd-color .pd-color-choose .color-item-container label").removeClass('active');
        $(this).addClass('active');
    });

    /*-------------------
        Nice Select
    --------------------- */
    $('.sorting, .p-show').niceSelect();

    /*------------------
        Single Product
    --------------------*/
    $('.pr-img-caroussel .pt').on('click', function () {
        $('.pr-img-caroussel .pt').removeClass('active');
        $(this).addClass('active');
        var imgurl = $(this).data('pr-img-bg');
        var bigImg = $('.pr-active-image').attr('src');
        if (imgurl != bigImg) {
            $('.pr-active-image').attr({ src: imgurl });
            $('.zoomImg').attr({ src: imgurl });
        }
    });

    /*-------------------
        Quantity change
    --------------------- */
   //handle-cart.js

    /********************************
     *      Fermer Filtre
    ********************************/

    $(".btn-close-filter").on('click', function () {
        $("body").removeClass('toggle-filter');
    });


    /********************************
     *      Fermer Menu Burger
    ********************************/

    $("#btn-close-burger").on('click', function () {
        $("body").removeClass('nav-is-toggled');
    });

    /********************************
     *      Afficher Searchbar Mobile
    ********************************/

    const $menu = $('#displaySearchMobile');

    $(document).mouseup(e => {
        if (!$menu.is(e.target) // if the target of the click isn't the container...
            && $menu.has(e.target).length === 0) // ... nor a descendant of the container
        {
            $menu.removeClass('display-search-mobile');
        }
    });

    $('#btnSearchMobile').on('click', () => {
        $menu.toggleClass('display-search-mobile');
    });


    /*********************************
     *  PAGINATION
    **********************************/

     $('.pagination li').click(function() {
        $(this).addClass('active').siblings().removeClass('active');
      });


})(jQuery);