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