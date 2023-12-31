function buyServiceBoost(itemId, itemSelector, iblockId, boostType, typeBuy) {
    console.log(123);

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
                uf_vip: price.uf_vip,
                uf_lenta: price.uf_lenta,
                uf_rise_day: price.uf_rise_day,
                uf_rise_count: price.uf_rise_count,
                uf_xml_id_lent: price.uf_xml_id_lent
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
                                console.log(params);
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

document.addEventListener('DOMContentLoaded', () => {
    const servicesBtns = document.querySelectorAll('button.btn-accelerate-sale');

    if (servicesBtns.length > 0) {
        servicesBtns.forEach((btn) => {
            btn.onclick = () => {
                const dropdown = btn.querySelector('div.accardion-wrap');

                if (dropdown) {
                    let dropdownClasses = dropdown.classList;

                    if (dropdownClasses.contains('active')) {
                        dropdownClasses.remove('active');
                    } else {
                        dropdownClasses.add('active');
                    }
                }
            }
        });
    }
});