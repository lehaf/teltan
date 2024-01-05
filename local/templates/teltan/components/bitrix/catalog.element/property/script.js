function countRiseBuy(id, el, eltrigger) {
    var price = 0;
    var count = 0;

    $(el).find('input').each(function () {

        if ($(this).is(':checked')) {
            count = $(this).val()
            price = $(this).data()

        }
    });

    $.ajax({
        url: '/ajax/buy_item.php',
        method: 'post',
        async: false,
        data: {idItem: id, type: 'getData'},
        success: function (data) {
            $('#payTcoinsBalance').text(data);
            $('#payTcoinsNeedle').text(price.price);
            $('#payTcoinsNeedleRes').text(data - price.price);
            if (data - price.price >= 0) {
                var rels = data - price.price;
                $('#payTcoinsAtEnd').text('  ' + rels + ' T')
                $("#buyItemFew").unbind();
                $('#buyItemFew').click(function () {
                    $.ajax({
                        url: '/ajax/buy_item.php',
                        method: 'post',
                        async: false,
                        data: {idItem: id, count: count, iblock: eltrigger, price: price.price},
                        success: function (data) {
                            window.location.reload();
                        }
                    });
                })
            } else {
                $('#payTcoinsAtEnd').text('недостаточно средств')
            }
        }
    });

}

function countVipBuy(id, el, eltrigger) {
    var price = 0;
    var count = 0;

    $(el).find('input').each(function () {

        if ($(this).is(':checked')) {
            count = $(this).val()
            price = $(this).data()

        }
    });

    $.ajax({
        url: '/ajax/buy_item_vip.php',
        method: 'post',
        async: false,
        data: {idItem: id, type: 'getData'},
        success: function (data) {
            $('#payTcoinsBalance').text(data);
            $('#payTcoinsNeedle').text(price.price);
            $('#payTcoinsNeedleRes').text(data - price.price)
            if (data - price.price >= 0) {
                var rels = data - price.price;
                $('#payTcoinsAtEnd').text('  ' + rels + ' T')
                $("#buyItemFew").unbind();
                $('#buyItemFew').click(function () {
                    $.ajax({
                        url: '/ajax/buy_item_vip.php',
                        method: 'post',
                        async: false,
                        data: {idItem: id, count: count, iblock: eltrigger, price: price.price},
                        success: function (data) {
                            window.location.reload();
                        }
                    });
                })
            } else {
                $('#payTcoinsAtEnd').text('недостаточно средств')
            }
        }
    });

}

function countColourBuy(id, el, eltrigger) {
    var price = 0;
    var count = 0;

    $(el).find('input').each(function () {

        if ($(this).is(':checked')) {
            count = $(this).val()
            price = $(this).data()

        }
    });

    $.ajax({
        url: '/ajax/buy_item_colour.php',
        method: 'post',
        async: false,
        data: {idItem: id, type: 'getData'},
        success: function (data) {
            $('#payTcoinsBalance').text(data);
            $('#payTcoinsNeedle').text(price.price);
            $('#payTcoinsNeedleRes').text(data - price.price)
            if (data - price.price >= 0) {
                var rels = data - price.price;
                $('#payTcoinsAtEnd').text('  ' + rels + ' T')
                $("#buyItemFew").unbind();
                $('#buyItemFew').click(function () {
                    $.ajax({
                        url: '/ajax/buy_item_colour.php',
                        method: 'post',
                        async: false,
                        data: {idItem: id, count: count, iblock: eltrigger, price: price.price},
                        success: function (data) {
                            window.location.reload();
                        }
                    });
                })
            } else {
                $('#payTcoinsAtEnd').text('недостаточно средств')
            }
        }
    });

}

function countLentaBuy(id, el, eltrigger) {
    var price = 0;
    var count = 0;

    $(el).find('input').each(function () {

        if ($(this).is(':checked')) {
            count = $(this).val()
            price = $(this).data()

        }
    });

    $.ajax({
        url: '/ajax/buy_item_lenta.php',
        method: 'post',
        async: false,
        data: {idItem: id, type: 'getData'},
        success: function (data) {
            $('#payTcoinsBalance').text(data);
            $('#payTcoinsNeedle').text(price.price);
            $('#payTcoinsNeedleRes').text(data - price.price)
            if (data - price.price >= 0) {
                var rels = data - price.price;
                $('#payTcoinsAtEnd').text('  ' + rels + ' T')
                $("#buyItemFew").unbind();
                $('#buyItemFew').click(function () {
                    $.ajax({
                        url: '/ajax/buy_item_lenta.php',
                        method: 'post',
                        async: false,
                        data: {
                            idItem: id,
                            count: count,
                            iblock: eltrigger,
                            price: price.price,
                            xml: price.xmlId
                        },
                        success: function (data) {
                            window.location.reload();
                        }
                    });
                })
            } else {
                $('#payTcoinsAtEnd').text('недостаточно средств')
            }
        }
    });

}

function countPaketBuy(id, el, eltrigger) {
    var price = 0;
    var count = 0;

    $(el).find('input').each(function () {

        if ($(this).is(':checked')) {
            count = $(this).val()
            price = $(this).data()

        }
    });

    $.ajax({
        url: '/ajax/buy_item_paket.php',
        method: 'post',
        async: false,
        data: {idItem: id, type: 'getData'},
        success: function (data) {
            $('#payTcoinsBalance').text(data);
            $('#payTcoinsNeedle').text(price.price);
            $('#payTcoinsNeedleRes').text(data - price.price)
            if (data - price.price >= 0) {
                var rels = data - price.price;
                $('#payTcoinsAtEnd').text('  ' + rels + ' T')
                $("#buyItemFew").unbind();
                $('#buyItemFew').click(function () {
                    $.ajax({
                        url: '/ajax/buy_item_paket.php',
                        method: 'post',
                        async: false,
                        data: {idItem: id, count: count, iblock: eltrigger, price: price.price, all: price},
                        success: function (data) {
                            window.location.reload();
                        }
                    });
                })
            } else {
                $('#payTcoinsAtEnd').text('недостаточно средств')
            }
        }
    });

}

function countPaketBuyShek(id, el, eltrigger) {
    var price = 0;
    var count = 0;

    $(el).find('input').each(function () {

        if ($(this).is(':checked')) {
            count = $(this).val()
            price = $(this).data()

        }
    });


    $.ajax({
        url: '/ajax/secureZXC/pay.php',
        method: 'post',
        dataType: 'json',
        async: false,
        data: {
            url: window.location.origin + '/ajax/buy_item_paket.php',
            idItem: id,
            count: count,
            iblock: eltrigger,
            price: price.price,
            uf_vip: price.uf_vip,
            uf_lenta: price.uf_lenta,
            uf_rise_day: price.uf_rise_day,
            uf_rise_count: price.uf_rise_count,
            uf_xml_id_lent: price.uf_xml_id_lent
        },
        success: function (data) {
            window.location.href = data.data.payment_page_link
        }
    });

}

function countLentaBuyShek(id, el, eltrigger) {
    var price = 0;
    var count = 0;

    $(el).find('input').each(function () {

        if ($(this).is(':checked')) {
            count = $(this).val()
            price = $(this).data()

        }
    });


    $.ajax({
        url: '/ajax/secureZXC/pay.php',
        method: 'post',
        dataType: 'json',
        async: false,
        data: {
            url: window.location.origin + '/ajax/buy_item_lenta.php',
            idItem: id,
            count: count,
            iblock: eltrigger,
            price: price.price,
            xml: price.xmlId
        },
        success: function (data) {
            window.location.href = data.data.payment_page_link
        }
    });

}

function countColourBuyShek(id, el, eltrigger) {
    var price = 0;
    var count = 0;

    $(el).find('input').each(function () {

        if ($(this).is(':checked')) {
            count = $(this).val()
            price = $(this).data()

        }
    });


    $.ajax({
        url: '/ajax/secureZXC/pay.php',
        method: 'post',
        dataType: 'json',
        async: false,
        data: {
            url: window.location.origin + '/ajax/buy_item_colour.php',
            idItem: id,
            count: count,
            iblock: eltrigger,
            price: price.price
        },
        success: function (data) {
            window.location.href = data.data.payment_page_link
        }
    });

}

function countVipBuyShek(id, el, eltrigger) {
    var price = 0;
    var count = 0;

    $(el).find('input').each(function () {

        if ($(this).is(':checked')) {
            count = $(this).val()
            price = $(this).data()

        }
    });


    $.ajax({
        url: '/ajax/secureZXC/pay.php',
        method: 'post',
        dataType: 'json',
        async: false,
        data: {
            url: window.location.origin + '/ajax/buy_item_vip.php',
            idItem: id,
            count: count,
            iblock: eltrigger,
            price: price.price
        },
        success: function (data) {
            window.location.href = data.data.payment_page_link
        }
    });

}

function countRiseBuyShek(id, el, eltrigger) {
    var price = 0;
    var count = 0;

    $(el).find('input').each(function () {

        if ($(this).is(':checked')) {
            count = $(this).val()
            price = $(this).data()

        }
    });

    $.ajax({
        url: '/ajax/secureZXC/pay.php',
        method: 'post',
        dataType: 'json',
        async: false,
        data: {
            url: window.location.origin + '/ajax/buy_item.php',
            idItem: id,
            count: count,
            iblock: eltrigger,
            price: price.price
        },
        success: function (data) {
            window.location.href = data.data.payment_page_link
        }
    });

}

document.addEventListener('DOMContentLoaded', () => {
    // SMALL SLIDER
    $('.slider-for').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        prevArrow: '<div class="carousel-control-prev" data-slide="prev"><i class="icon-left-arrow rotate-180"></i><span class="sr-only">Previous</span></div>',
        nextArrow: '<div class="carousel-control-next" data-slide="next"><i class="icon-left-arrow"></i><span class="sr-only">Next</span></div>',
        responsive: [{
            breakpoint: 768,
            settings: {
                centerPadding: '7%',
                centerMode: true,
                arrows: false,
            }
        }]
    });

    $('.slider-nav div[data-slide]').click(function (e) {
        e.preventDefault();
        var slideno = $(this).data('slide');
        $('.slider-for').slick('slickGoTo', slideno);
    });

    $('.slider-for .slide').click(function (e) {
        e.preventDefault();
        let currentSliderNumber = e.delegateTarget.attributes['data-current-slider'].value
        $('.navMainItemSlider').slick('slickGoTo', currentSliderNumber);
    });


    // BIG DETAIL SLIDER
    let $status = $('.slider-counter-mobile');
    let $slickElement = $('.mainItemSlider');

    $slickElement.on('init reInit afterChange', function (event, slick, currentSlide, nextSlide) {
        // currentSlide is undefined on init -- set it to 0 in this case (currentSlide is 0 based)
        var i = (currentSlide ? currentSlide : 0) + 1;
        $status.text(i + '/' + slick.slideCount);
    });

    $('.mainItemSlider').slick({
        slidesToShow: 1,
        arrows: false,
        vertical: true,
        centerMode: true,
        verticalSwiping: true,
        rtl: false,
        centerPadding: '18%',
        asNavFor: '.navMainItemSlider',
        responsive: [{
            breakpoint: 856,
            settings: {
                vertical: false,
                centerPadding: '15%',
                verticalSwiping: false,
                centerPadding: 0,
                centerMode: false,
            }
        }]
    });

    $('.navMainItemSlider').slick({
        slidesToShow: 9,
        slidesToScroll: 9,
        centerPadding: '24px',
        vertical: true,
        centerMode: true,
        focusOnSelect: true,
        prevArrow: '<div class="dots-arrow dots-arrow-prev"><i class="icon-left-arrow rotate-180"></i></div>',
        nextArrow: '<div class="dots-arrow dots-arrow-next"><i class="icon-left-arrow"></i></div>',
        asNavFor: '.mainItemSlider',
        responsive: [{
            breakpoint: 856,
            settings: "unslick",
        }]
    });

    $('.mainItemSlider').on('wheel', (function (e) {
        e.preventDefault();

        if (e.originalEvent.deltaY < 0) {
            $(this).slick('slickNext');
        } else {
            $(this).slick('slickPrev');
        }
    }));

    $('#modalFullSize').on('shown.bs.modal', function () {
        $('.mainItemSlider').slick('refresh');
        $('.navMainItemSlider').slick('refresh');
    })

    if ($(window).width() < 768) {
        $('#modalFullSize').on('shown.bs.modal', function () {
            $('body .modal-backdrop.show').css({"opacity": '1'})
            $(".item-slider > .add-item-favorite").css({
                'z-index': '2000',
                'top': '-100%',
                'right': '20px',
                'left': 'auto'
            })
        })

        $('#modalFullSize').on('hide.bs.modal', function () {
            $('body .modal-backdrop.show').css({"opacity": '0.5'})
            $(".item-slider > .add-item-favorite").css({
                'z-index': '2',
                'top': '20px',
                'right': 'auto',
                'left': '20px'
            })
        })
    } else {
        $('#modalFullSize').on('shown.bs.modal', function () {
            $('body .modal-backdrop.show').css({'opacity': '0.8', 'background-color': '#d5d5d5'})
        })

        $('#modalFullSize').on('hide.bs.modal', function () {
            $('body .modal-backdrop.show').css({'opacity': '0.8', 'background-color': '#d5d5d5'})
        })
    }

});