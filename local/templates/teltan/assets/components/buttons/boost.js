const BoostBtn = function () {
    this.init();
}

BoostBtn.prototype.init = function () {
    this.setEventListener();
}

BoostBtn.prototype.setEventListener = function () {
    // Кнопка открытия все услуг
    $('.btn-accelerate-sale').click(function () {
        $(this).next().toggleClass('active')
    });

    // Кнопка поднятия объявлений
    let att = '1';
    $('.rise-btn').click(function () {
        let isSend = confirm("Поднять объявление?");
        if (isSend == true) {
            $.ajax({
                url: '/ajax/rise_item.php',
                method: 'post',
                async: false,
                data: $(this).data(),
                success: function (data) {
                    att = data;
                }
            });

            if (att == 'none') {
                $(this).css('visibility', 'hidden');
            } else {
                $(this).children('.m-0').text(att);
            }
        }
    })
}


document.addEventListener('DOMContentLoaded', () => {
    window.BoostBtn = new BoostBtn();
});


function buyServiceBoost(itemId, itemSelector, iblockId, boostType, typeBuy) {
    let price = 0;
    let count = 0;
    let ajaxUrl = null;
    let params = {};

    $(itemSelector).find('input').each(function () {
        if ($(this).is(':checked')) {
            count = $(this).val()
            price = $(this).data()

        }
    });


    switch (boostType) {
        case 'RISE':
            ajaxUrl = '/ajax/buy_item.php';
            params = {
                idItem: itemId,
                count: count,
                iblock: iblockId,
                price: price.price
            };
            break;
        case 'RIBBON':
            ajaxUrl = '/ajax/buy_item_lenta.php';
            params = {
                idItem: itemId,
                count: count,
                iblock: iblockId,
                price: price.price,
                xml: price.xmlId
            }
            break;
        case 'VIP':
            ajaxUrl = '/ajax/buy_item_vip.php';
            params = {
                idItem: itemId,
                count: count,
                iblock: iblockId,
                price: price.price
            };
            break;
        case 'COLOR':
            ajaxUrl = '/ajax/buy_item_colour.php';
            params = {
                idItem: itemId,
                count: count,
                iblock: iblockId,
                price: price.price
            };
            break;
        case 'SET':
            ajaxUrl = '/ajax/buy_item_paket.php';
            params = {
                idItem: itemId,
                count: count,
                iblock: iblockId,
                price: price.price,
                vip_date: price.vip_date,
                ribbon_date: price.ribbon_date,
                ribbon_type: price.ribbon_type,
                color_date: price.color_date,
                rise_count: price.rise_count,
            }
            break;
    }

    if (typeBuy === 'tcoins') {
        $.ajax({
            url: ajaxUrl,
            method: 'post',
            async: false,
            data: {
                idItem: itemId,
                type: 'getData'
            },
            success: function (data) {
                $('#payTcoinsBalance').text(data);
                $('#payTcoinsNeedle').text(price.price);
                if (data - price.price >= 0) {
                    let rels = data - price.price;
                    $('#payTcoinsAtEnd').text('остаток ' + rels + ' T')
                    $("#buyItemFew").unbind();
                    $('#buyItemFew').click(function () {
                        $.ajax({
                            url: ajaxUrl,
                            method: 'post',
                            async: false,
                            data: params,
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
    } else {
        params['ulr'] = ajaxUrl;
        $.ajax({
            url: '/ajax/secureZXC/pay.php',
            method: 'post',
            dataType: 'json',
            async: false,
            data: params,
            success: function (data) {
                window.location.href = data.data.payment_page_link
            }
        });
    }
}