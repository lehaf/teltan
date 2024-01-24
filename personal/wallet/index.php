<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

/** @global object $APPLICATION */

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);
CModule::IncludeModule('iblock');
$userId = \Bitrix\Main\Engine\CurrentUser::get()->getId();

$entity_data_class = GetEntityDataClass(BOUGHT_RATE_HL_ID);
$rsData = $entity_data_class::getList(array(
    'select' => array('*'),
    'filter' => array('UF_USER_ID'=> $userId)
));

$entity_data_class = GetEntityDataClass(EXCHANGE_RATE_HL_ID);
$exchanghe = $entity_data_class::getList(array(
    'select' => array('*'),
    'filter' => array('ID'=> 1)
))->fetch();


$count = 0;
while ($arPaket[] = $rsData->fetch()) {
    $entity_data_class = GetEntityDataClass(27);
    $rssData = $entity_data_class::getList(array(
        'select' => array('*'),
        'filter' => array('ID'=> $arPaket[$count]['UF_PARENT_XML'])
    ));
    while ($arPaket[$count]['TARIF'][] = $rssData->fetch()) {
    }
    $count++;
}

$rsUser = CUser::GetByID($userId);
$arUser = $rsUser->Fetch();
function resGetter($id, $userId)
{
    $arResult = [];
    $arSelect = array("ID", "IBLOCK_ID", "NAME",'PROPERTY_TIME_RISE', 'DATE_CREATE', 'ACTIVE');
    $arFilter = array("IBLOCK_ID" => IntVal($id), "ACTIVE" => "Y", "PROPERTY_ID_USER" => $userId);
    $res = CIBlockElement::GetList(array("DATE_CREATE" => "DESC"), $arFilter, false, false, $arSelect);
    while ($ob = $res->GetNextElement()) {
        static $counter;
        $arFields = $ob->GetFields();
        $arResult['ITEMS'][$counter] = $arFields;
        $arProps = $ob->GetProperties();
        $arResult['ITEMS'][$counter]['PROPERTY'] = $arProps;
        $counter++;
    }
    if (empty($arResult)) {
        $arResult = ['N'];
    }
    return $arResult;
}
$ar1 = resGetter(1, $userId);
$ar2 = resGetter(2, $userId);
$ar3 = resGetter(3, $userId);
$ar7 = resGetter(7, $userId);
$ar8 = resGetter(8, $userId);
$result = array_merge_recursive($ar1, $ar2,$ar3, $ar7,$ar8);
$userActiveRates = getCurUserActiveRates();
?>
    <div class="container">
        <h2 class="mb-4 subtitle"><?=$APPLICATION->ShowTitle()?></h2>
        <div class="row full-height">
            <div class="col-12 col-lg-8 col-xl-9">
                <div class="wallet-history">
                    <div class="current-balance">
                        <div class="card mb-4">
                            <div id="exchange-rate" class="wallet-history__title border-bottom" data-exchange="<?=$exchanghe['UF_VALUE']?>">
                                1 Tcoin = <?=$exchanghe['UF_VALUE']?> <span class="currency-sign">₪</span>
                            </div>

                            <div class="d-flex flex-column flex-lg-row justify-content-lg-center align-items-lg-center">
                                <div class="mb-4 mb-lg-0 d-flex flex-column flex-lg-row justify-content-start justify-content-lg-end">
                                    <span class="mb-4 mb-lg-0 mr-3 d-flex align-items-center text-uppercase font-weight-bolder wallet-balance-name"><?=Loc::getMessage('My_Tcoins')?> <span class="ml-3 mb-md-0 pl-1 state-of-an-account"><?=$arUser['UF_TCOINS']?> T</span></span>

                                    <form id="convertor" class="d-flex justify-content-between align-items-center conversion-booth" action="">
                                        <div class="input-group">
                                            <input id="numberT" type="number" class="form-control" placeholder="100" aria-describedby="basic-addon2">
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="tCoin">T</span>
                                            </div>
                                        </div>

                                        <span class="mx-3">=</span>

                                        <div id="convertorError" class="input-group">
                                            <input id="numberS" type="number" class="form-control" placeholder="10" aria-describedby="basic-addon2">
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="shekel">₪</span>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="ml-lg-4 d-flex justify-content-center justify-content-lg-start w-100-mobile">
                                    <button id="sendCovertorData" for="convertor" type="submit" class="btn btn-primary text-uppercase font-weight-bolder"><?=Loc::getMessage('change')?></button>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4 card">
                            <div class="pb-4 mb-4 d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center border-bottom">
                                <span class="mb-4 mb-lg-0 m-0 text-nowrap text-uppercase font-weight-bolder wallet-balance-name">  <span id="convertorCurentBalance" class="ml-3 mb-md-0 state-of-an-account"><?=$arUser['UF_COUNT_SHEK']?> <span class="currency-sign">₪</span></span> <?=Loc::getMessage('My_balance:')?></span>
                                <div class="d-flex justify-content-center align-items-center w-100-mobile">
                                    <button  data-toggle="modal" data-target="#addCoins" id="buyOrderCoins" type="submit" class="mr-4 btn btn-primary text-uppercase font-weight-bolder"><?=Loc::getMessage('add')?></button>

                                    <span class="d-block"><i class="icon-wallet-3"></i></span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="mb-4 col-12 col-xl-4">
                                    <span class="m-0 text-uppercase font-weight-bolder wallet-balance-name">
                                        <?=Loc::getMessage('My_subscriptions:')?>
                                    </span>
                                </div>
                                <div class="col">
                                    <div class="d-flex flex-column">
                                        <?php if (!empty($userActiveRates)):?>
                                            <?php foreach ($userActiveRates as $rateName => $rateUntilDate):?>
                                                <div class="mb-4 d-flex justify-content-end align-items-center">
                                                    <div class="d-flex flex-column text-right">
                                                        <p href="#" class="mb-2 text-primary"><?=$rateName?></p>
                                                        <p class="mb-0 text-secondary">(<?=Loc::getMessage('until').' '.$rateUntilDate?>)</p>
                                                    </div>
                                                </div>
                                            <?php endforeach;?>
                                        <?endif;?>
                                        <?foreach ($result['ITEMS'] as $arItem){?>
                                            <?if($arItem['ACTIVE'] == 'Y'){?>
                                                <?if($arItem['PROPERTY']['COUNT_RAISE']['VALUE'] > 0){?>
                                                    <div class="mb-4 d-flex justify-content-end align-items-center">
                                                        <div class="d-flex flex-column text-right">
                                                            <p href="#" class="mb-2 text-primary"><?=Loc::getMessage('rise_item'). ' ' . $arItem['NAME'] . '</p><p class="mb-0 text-secondary"> '. Loc::getMessage('remain'). ' ' .$arItem['PROPERTY']['COUNT_RAISE']['VALUE']?></p>
                                                        </div>
                                                    </div>
                                                <?}?>
                                                <?if($arItem['PROPERTY']['COLOR_DATE']['VALUE'] && strtotime($arItem['PROPERTY']['COLOR_DATE']['VALUE']) > time()){?>
                                                    <div class="mb-4 d-flex justify-content-end align-items-center">
                                                        <div class="d-flex flex-column text-right">
                                                            <p href="#" class="mb-2 text-primary"><?=Loc::getMessage('color_item'). ' ' . $arItem['NAME'] . '</p><p class="mb-0 text-secondary">'. Loc::getMessage('until'). ' ' . date("d.m.Y H:i:s", strtotime($arItem['PROPERTY']['COLOR_DATE']['VALUE']))?></p>
                                                        </div>
                                                    </div>
                                                <?}?>
                                                <?if($arItem['PROPERTY']['VIP_DATE']['VALUE'] && strtotime($arItem['PROPERTY']['VIP_DATE']['VALUE']) > time()){?>
                                                    <div class="mb-4 d-flex justify-content-end align-items-center">
                                                        <div class="d-flex flex-column text-right">
                                                            <p href="#" class="mb-2 text-primary"><?=Loc::getMessage('vip_item'). ' ' . $arItem['NAME'] . '</p><p class="mb-0 text-secondary">' . Loc::getMessage('until'). ' ' .date("d.m.Y H:i:s", strtotime($arItem['PROPERTY']['VIP_DATE']['VALUE']))?></p>
                                                        </div>
                                                    </div>
                                                <?}?>
                                                <?if($arItem['PROPERTY']['LENTA_DATE']['VALUE'] && strtotime($arItem['PROPERTY']['LENTA_DATE']['VALUE']) > time()){?>
                                                    <div class="mb-4 d-flex justify-content-end align-items-center">
                                                        <div class="d-flex flex-column text-right">
                                                            <p href="#" class="mb-2 text-primary"><?=Loc::getMessage('lent_item'). ' ' . $arItem['NAME'] . '</p><p class="mb-0 text-secondary"> '. Loc::getMessage('until'). ' ' .date("d.m.Y H:i:s", strtotime($arItem['PROPERTY']['LENTA_DATE']['VALUE']))?></p>
                                                        </div>
                                                    </div>
                                                <?}?>
                                            <?}
                                        }?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    $APPLICATION->IncludeComponent(
                        "webco:user.history",
                        "",
                        array(
                            'MAX_PAGE_ELEMENTS' => 20
                        )
                    );
                    ?>
                </div>
            </div>
            <div class="modal fade" id="payTcoins" tabindex="-1" aria-labelledby="payTcoins" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content pt-3 pb-5 px-5">
                        <div class="p-0 mb-4 border-bottom-0 modal-header justify-content-end">
                            <h2 class="subtitle" id="exampleModalLabel">Оплата</h2>
                        </div>
                        <div class="p-0 modal-body text-right">
                            <p  class="mb-4 text-uppercase font-weight-bold">MY BALANCE: <span id="payTcoinsBalance" class="text-primary">100 </span>TCOIN
                            </p>
                            <p class="mb-0 text-uppercase font-weight-bold">К списанию: <span id="payTcoinsNeedle" class="text-primary">80 </span>TCOIN
                            </p>
                            <hr>
                            <p class="mb-3 text-uppercase font-weight-bold text-secondary">Остаток:
                                <span>20 TCOIN</span>
                            </p>
                        </div>
                        <div class="p-0 border-top-0 modal-footer">
                            <button type="button" class="btn" data-dismiss="modal">Close</button>
                            <button id="formControlTcoins" type="submit" class="btn btn-primary">Оплатить</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="addCoins" tabindex="-1" aria-labelledby="addCoins" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content pt-3 pb-5 px-5">
                        <div class="p-0 mb-4 border-bottom-0 modal-header justify-content-end">
                            <h2 class="subtitle" id="exampleModalLabel"><?=Loc::getMessage('pay')?></h2>
                        </div>

                        <div class="p-0 modal-body text-right">
                            <p  class="mb-4 text-uppercase font-weight-bold"><?=Loc::getMessage('sum')?>
                            </p>

                            <input id="shekValPayPlus" class="ml-2 form-control" type="text"
                                   placeholder="<?=Loc::getMessage('sum')?>"
                                   required/>
                            <hr>

                        </div>

                        <div class="p-0 border-top-0 modal-footer">
                            <button type="button" class="btn" data-dismiss="modal"><?=Loc::getMessage('Close')?></button>
                            <button id="formControlPayPlus" type="submit" class="btn btn-primary"><?=Loc::getMessage('Make_pay')?></button>
                        </div>
                    </div>
                </div>
            </div>
            <?php $APPLICATION->IncludeComponent(
                "bitrix:menu",
                "personal",
                array(
                    "ALLOW_MULTI_SELECT" => "N",
                    "CHILD_MENU_TYPE" => "",
                    "DELAY" => "N",
                    "MAX_LEVEL" => "1",
                    "MENU_CACHE_GET_VARS" => array(""),
                    "MENU_CACHE_TIME" => "360000",
                    "MENU_CACHE_TYPE" => "A",
                    "MENU_CACHE_USE_GROUPS" => "N",
                    "ROOT_MENU_TYPE" => "personal",
                    "USE_EXT" => "N"
                )
            ); ?>
        </div>
    </div>
    <script>
        // Покупка валюты
        $('#formControlPayPlus').click(function () {
            $.ajax({
                url: '/ajax/secureZXC/pay.php',
                method: 'post',
                dataType: 'json',
                async: false,
                data: {
                    url: '/ajax/buy_shek.php',
                    price: $('#shekValPayPlus').val(),
                    shekel: $('#shekValPayPlus').val(),
                    withoutcourse: 'Y'
                },
                success: function (data) {
                    window.location.href = data.data.payment_page_link
                }
            });
        });

        // Конвертация валюты в TCOINS
        const exchangeRate = Number(document.querySelector('#exchange-rate').getAttribute('data-exchange'));

        $('#numberT').keyup(function () {
            let tCoins = $(this).val();
            $('#numberS').val(tCoins * exchangeRate);
        });

        $('#numberS').keyup(function () {
            let sekel = $(this).val();
            let convetToTCoins = Math.ceil(sekel / exchangeRate);
            $('#numberT').val(convetToTCoins);
        });

        $('#sendCovertorData').click(function () {
            let tCoins = $('#numberT').val();
            let sekel =  $('#numberS').val();
            let balance = $('#convertorCurentBalance').text();
            if (sekel <= balance) {
                $.ajax({
                    url: '/ajax/buy_t_coins.php',
                    method: 'post',
                    data: {
                        tcoins: tCoins,
                        shekel: sekel
                    },
                    success: function (data) {
                        if(data === 'ok'){
                            window.location.reload();
                        }else{
                            $('#convertorError').css({
                                'border':'2px solid #ff4d4d',
                                'border-radius':'10px',
                                'box-shadow': '0px 0px 5px red'
                            });
                        }
                    }
                });
            } else {
                $('#convertorError').css({
                    'border':'2px solid #ff4d4d',
                    'border-radius':'10px',
                    'box-shadow': '0px 0px 5px red'
                });
            }
        });
    </script>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>