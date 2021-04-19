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
        Product Slider
    --------------------*/
    $(".related-pr-slider").owlCarousel({
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
    --------------------- */
    var rangeSlider = $(".filter-price-range"),
        minamount = $("#minamount"),
        maxamount = $("#maxamount"),
        minPrice = rangeSlider.data('min'),
        maxPrice = rangeSlider.data('max');
    rangeSlider.slider({
        range: true,
        min: minPrice,
        max: maxPrice,
        values: [minPrice, maxPrice],
        slide: function (event, ui) {
            minamount.val('$' + ui.values[0]);
            maxamount.val('$' + ui.values[1]);
        }
    });
    minamount.val('$' + rangeSlider.slider("values", 0));
    maxamount.val('$' + rangeSlider.slider("values", 1));

    /*-------------------
        Range Slider Mobile
    --------------------- */
    var rangeSlider = $(".filter-price-range"),
        minamountmobile = $("#minamountmobile"),
        maxamountmobile = $("#maxamountmobile"),
        minPricemobile = rangeSlider.data('min'),
        maxPricemobile = rangeSlider.data('max');
    rangeSlider.slider({
        range: true,
        min: minPricemobile,
        max: maxPricemobile,
        values: [minPricemobile, maxPricemobile],
        slide: function (event, ui) {
            minamountmobile.val('$' + ui.values[0]);
            maxamountmobile.val('$' + ui.values[1]);
        }
    });
    minamountmobile.val('$' + rangeSlider.slider("values", 0));
    maxamountmobile.val('$' + rangeSlider.slider("values", 1));

    /*-------------------
        Radio Btn
    --------------------- */
    $(".fw-size .size-item-container label, .pd-size-choose .size-item-container label, .pd-color .pd-color-choose .color-item-container label").on('click', function () {
        $(".fw-size .size-item-container label, .pd-color .pd-color-choose .color-item-container label, .pd-size-choose .size-item-container label").removeClass('active');
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
    // handle-cart.js

    var body = $("body");
    var wrap = $("#showSticky");

    body.on("scroll", function (e) {

        if (this.scrollTop > 250) {
            wrap.addClass("sticky");
        } else {
            wrap.removeClass("sticky");
        }

    });

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

    /* $("#btnSearchMobile").on('click', function () {
        $("#displaySearchMobile").addClass('display-search-mobile')
    });

    $(window).on('click',function(event){
        if(!$(event.target).is('.nav-mobile')){
          $("#displaySearchMobile").removeClass("display-search-mobile");
        }
     }); 

     $(document).on({
        click: function(){
           $("body").removeClass("display-search-mobile")
        }
     },":not(#displaySearchMobile)"); */

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


})(jQuery);