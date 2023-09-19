<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
use Bitrix\Main\Localization\Loc;
use Bitrix\Highloadblock\HighloadBlockTable as HLBT;
Loc::loadMessages(__FILE__);
CModule::IncludeModule('iblock');

$entity_data_class = GetEntityDataClass(28);
$rsData = $entity_data_class::getList(array(
    'select' => array('*'),
    'filter' => array('UF_USER_ID'=> $USER->GetID())
));
$entity_data_class = GetEntityDataClass(29);
$rsexData = $entity_data_class::getList(array(
    'select' => array('*'),
    'filter' => array('ID'=> 1)
));
$exchanghe = $rsexData->fetch();
$entity_data_class = GetEntityDataClass(30);
$rshiData = $entity_data_class::getList(array(
    'select' => array('*'),
    'filter' => array('UF_USER_ID'=> $USER->GetID())
));

while($history[] = $rshiData->fetch()){

}
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
arsort($history);
$rsUser = CUser::GetByID($USER->GetID());
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
$ar1 = resGetter(1, $USER->GetID());
$ar2 = resGetter(2, $USER->GetID());
$ar3 = resGetter(3, $USER->GetID());
$ar7 = resGetter(7, $USER->GetID());
$ar8 = resGetter(8, $USER->GetID());
$result = array_merge_recursive($ar1, $ar2,$ar3, $ar7,$ar8);
?>
    <div class="container">
        <h2 class="mb-4 subtitle">
            <?= $APPLICATION->ShowTitle(); ?>
        </h2>
        <div class="row">

            <div class="col-12 col-lg-8 col-xl-9">
                <div class="wallet-history">
                    <div class="current-balance">
                        <div class="card mb-4">
                            <div class="wallet-history__title border-bottom">
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
                                <script>
                                    $('#numberT').change(function () {
                                        var a = $(this).val()
                                        $('#numberS').val(a * 0.1)
                                    })
                                    $('#numberS').change(function () {
                                        var b = $(this).val()
                                        $('#numberT').val(b / 0.1)
                                    })
                                    $('#sendCovertorData').click(function () {
                                        var a = $('#numberT').val()
                                        var b =  $('#numberS').val()
                                        var c = $('#convertorCurentBalance').text()
                                        if(b <= c){
                                            $.ajax({
                                                url: '/ajax/buy_t_coins.php',
                                                method: 'post',
                                                data: {tcoins: a, shekel: b},
                                                success: function (data) {
                                                    if(data == 'ok'){
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
                                        }else {
                                            $('#convertorError').css({
                                                'border':'2px solid #ff4d4d',
                                                'border-radius':'10px',
                                                'box-shadow': '0px 0px 5px red'
                                            });
                                        }
                                    })
                                </script>
                                <div class="d-flex justify-content-center align-items-center w-100-mobile">
                                    <button  data-toggle="modal" data-target="#addCoins" id="buyOrderCoins" type="submit" class="mr-4 btn btn-primary text-uppercase font-weight-bolder"><?=Loc::getMessage('add')?></button>

                                    <span class="d-block"><i class="icon-wallet-3"></i></span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="mb-4 col-12 col-xl-4">
                                    <span class="m-0 text-uppercase font-weight-bolder wallet-balance-name"><?=Loc::getMessage('My_subscriptions:')?></span>
                                </div>

                                <div class="col">
                                    <div class="d-flex flex-column">
                                    <?foreach ($arPaket as $arItem){?>
                                        <?if($arItem['UF_USER_ID'] != null){?>

                                        <div class="mb-4 d-flex justify-content-end align-items-center">
                                            <div class="d-flex flex-column text-right">
                                                <p href="#" class="mb-2 text-primary"><?=$arItem['TARIF'][0]['UF_NAME']?></p>
                                                <p class="mb-0 text-secondary">(<?=Loc::getMessage('until')?> <?=date("d.m.Y H:i:s", strtotime('+ '. $arItem['UF_DAYS_REMAIN'] . ' days'))?>)</p>
                                            </div>
                                        </div>
                                        <?}}?>
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


                    <div class="card purchase-history">
                        <div class="mb-4 pb-3 wallet-history__title border-bottom">
                            <?=Loc::getMessage('purchase_history')?>
                        </div>

<?foreach ($history as $arItem){?>
    <?if($arItem['UF_NAME'] != null){?>
        <?$res = CIBlockElement::GetByID($arItem['UF_ITEM_ID']);
    if($ar_res = $res->GetNext())
        $nameNew = $ar_res['NAME'];?>
            <?if($arItem['UF_NAME'] == 'buy_pjet_anon' || $arItem['UF_NAME'] == 'buy_t_coins' || $arItem['UF_NAME'] == 'buy_shekel') {
            $nameNew = '';
            $forMessage = '';
        }else{
            $forMessage = 'for';
        }
                ?>
                        <div class="pb-2 mb-2 d-flex justify-content-between align-items-center border-bottom">
                            <div class="text-uppercase purchase-history__name"><?=Loc::getMessage($arItem["UF_NAME"]) . ' '. Loc::getMessage($forMessage) . ' ' . $nameNew?></div>

                            <div class="text-uppercase purchase-history__date"><?=$arItem['UF_DATE_BUY']?></div>
                        </div>
    <?}}?>

                    </div>
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
                                <span>20 TCOIN</span></p>
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
            <? include $_SERVER['DOCUMENT_ROOT'] . '/personal/left.php' ?>

        </div>
    </div>
    <script>

        $('#formControlPayPlus').click(function () {
            $.ajax({
                url: '/ajax/secureZXC/pay.php',
                method: 'post',
                dataType: 'json',
                async: false,
                data: {url: 'http://650739-cm41399.tmweb.ru/ajax/buy_shek.php', price: $('#shekValPayPlus').val(), shekel: $('#shekValPayPlus').val(), withoutcourse: 'Y'},
                success: function (data) {
                    window.location.href = data.data.payment_page_link
                }
            });
        })
    </script>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>