<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

use Bitrix\Main\Localization\Loc;

$entity_data_class = GetEntityDataClass(TYPE_RATES_HL_ID);
$rsData = $entity_data_class::getList(array(
    'select' => array('*'),
    'cache' => [
        'ttl' => 360000,
        'cache_joins' => true
    ],
));

$arTypeFlea = [];
$arTypeProp = [];
$arTypeAuto = [];

while ($arTypes = $rsData->fetch()) {
    if ($arTypes['UF_SECTION'] == 'AUTO') {
        if ($arTypes['UF_CLASS_BUISNESS'] == 1) {
            $arTypeAuto['CLASSIC'][] = $arTypes;
        } else {
            $arTypeAuto['BUSINES'][] = $arTypes;
        }
    }
    if ($arTypes['UF_SECTION'] == 'FLEA') {
        if ($arTypes['UF_CLASS_BUISNESS'] == 1) {
            $arTypeFlea['CLASSIC'][] = $arTypes;
        } else {
            $arTypeFlea['BUSINES'][] = $arTypes;
        }
    }
    if ($arTypes['UF_SECTION'] == 'PROPERTY') {
        if ($arTypes['UF_CLASS_BUISNESS'] == 1) {
            $arTypeProp['CLASSIC'][] = $arTypes;
        } else {
            $arTypeProp['BUSINES'][] = $arTypes;
        }
    }
}
?>
    <div class="container">
        <h2 class="mb-4 subtitle"><?=$APPLICATION->ShowTitle()?></h2>
        <div class="row">
            <div id="paketControl" class="col-12 col-lg-8 col-xl-9">
                <!-- CLASSIC TARIF -->
                <div class="d-flex justify-content-end select-tarif-nav-box">
                    <ul class="nav nav-pills bg-white" id="pills-tab" role="tablist">
                        <li class="nav-item nav-item-first" role="presentation">
                            <a class="nav-link" id="pills-flea-market-tab" data-toggle="pill" href="#pills-flea-market"
                               role="tab" aria-controls="pills-flea-market" aria-selected="false"><?=Loc::getMessage('Flea-market')?></a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="pills-property-tab" data-toggle="pill" href="#pills-property"
                               role="tab" aria-controls="pills-property" aria-selected="false"><?=Loc::getMessage('Property')?></a>
                        </li>
                        <li class="nav-item nav-item-last" role="presentation">
                            <a class="nav-link active" id="pills-auto-tab" data-toggle="pill" href="#pills-auto"
                               role="tab" aria-controls="pills-auto" aria-selected="true"><?=Loc::getMessage('Auto')?></a>
                        </li>
                    </ul>
                </div>
                <div class="px-3 px-md-4 px-lg-5 pt-0 card select-tarif">
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade active show" id="pills-auto" role="tabpanel"
                             aria-labelledby="pills-auto-tab">
                            <form action="">
                                <p class="h3 mb-4 px-4 pt-4 pb-3 text-right border-bottom"><?=Loc::getMessage('Classic')?></p>

                                <div class="mb-4 d-flex flex-column">
                                    <?php foreach ($arTypeAuto['CLASSIC'] as $arItem) { ?>
                                        <div class="mb-4 d-flex flex-column">
                                            <div class="d-flex justify-content-between justify-content-end">
                                                <p class="m-0 mx-2 mx-lg-4 text-primary font-weight-bold text-nowrap"><?= $arItem['UF_PRICE'] ?>
                                                    T</p>

                                                <div class="d-flex">
                                                    <div class="mr-4 d-flex flex-column align-items-end">
                                                        <p class="font-weight-bold title"><?=str_replace('#COUNT#',$arItem['UF_COUNT'] ,Loc::getMessage('propPattern'))?></p>
                                                        <p class="text-subtitle"><?=Loc::getMessage('paket_for')?><?= $arItem['UF_DAYS'] ?>
                                                            <?=Loc::getMessage('days')?></p>
                                                    </div>

                                                    <label class="custom-radio-btn">
                                                        <input class="controlPanelPaket" type="radio" name="selectPack"
                                                               data-id-paket="<?= $arItem['ID'] ?>"
                                                               data-price="<?= $arItem['UF_PRICE'] ?>"
                                                               data-days="<?= $arItem['UF_DAYS'] ?>"
                                                               data-count="<?= $arItem['UF_COUNT'] ?>"
                                                               data-type="<?=AUTO_ADS_TYPE_CODE?>"
                                                        >
                                                        <span class="checkbox"></span>
                                                    </label>
                                                </div>
                                            </div>

                                        </div>
                                    <?php } ?>
                                </div>

                                <!-- BUSINES TARIF -->
                                <p class="h3 mb-4 px-4 pt-4 pb-3 text-right border-bottom"><?=Loc::getMessage('Business')?></p>

                                <div class="mb-4 d-flex flex-column">
                                    <?php foreach ($arTypeAuto['BUSINES'] as $arItem) { ?>
                                        <div class="mb-4 d-flex flex-column">
                                            <div class="d-flex justify-content-between justify-content-end">
                                                <p class="m-0 mx-2 mx-lg-4 text-primary font-weight-bold text-nowrap"><?= $arItem['UF_PRICE'] ?>
                                                    T</p>

                                                <div class="d-flex">
                                                    <div class="mr-4 d-flex flex-column align-items-end">
                                                        <p class="font-weight-bold title"><?= str_replace('#COUNT#',$arItem['UF_COUNT'] ,Loc::getMessage('propPattern'))?></p>
                                                        <p class="text-subtitle"><?=Loc::getMessage('paket_for')?><?= $arItem['UF_DAYS'] ?>
                                                            <?=Loc::getMessage('days')?></p>
                                                    </div>

                                                    <label class="custom-radio-btn">
                                                        <input class="controlPanelPaket" type="radio" name="selectPack"
                                                               data-count="<?= $arItem['UF_COUNT'] ?>"
                                                               data-id-paket="<?= $arItem['ID'] ?>"
                                                               data-price="<?= $arItem['UF_PRICE'] ?>"
                                                               data-days="<?= $arItem['UF_DAYS'] ?>"
                                                               data-type="<?=AUTO_ADS_TYPE_CODE?>"
                                                        >
                                                        <span class="checkbox"></span>
                                                    </label>
                                                </div>
                                            </div>

                                        </div>
                                    <?php } ?>
                                </div>

                                <div class="mb-4 d-flex flex-column flex-md-row justify-content-end">
                                    <!-- Button trigger modal -->
                                    <button type="button"
                                            class="mb-3 mb-md-0 mr-0 mr-md-2 mr-lg-4 btn btn-primary btn-paid "
                                            data-toggle="modal" data-target="#payTcoins"><span class="mr-2"><svg
                                                    width="17" height="17" viewBox="0 0 17 17" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
<path d="M11.8169 0.00066338C8.95442 0.00066338 6.63389 1.28034 6.63389 2.8612C6.63389 4.44205 8.95508 5.72239 11.8169 5.72239C14.6795 5.72239 17 4.44205 17 2.8612C17 1.28034 14.6788 0 11.8169 0V0.00066338ZM17 3.711C16.9987 5.29185 14.6795 6.57219 11.8169 6.57219C8.96238 6.57219 6.64716 5.30578 6.63389 3.73223V4.85136C6.63389 5.52669 7.06642 6.14497 7.77492 6.63455C8.49138 6.82959 9.12956 7.10025 9.66093 7.44256C10.3197 7.60973 11.0441 7.71189 11.8169 7.71189C14.6795 7.71189 17 6.43222 17 4.85136V3.711ZM17 5.70116C17 7.28202 14.6795 8.56236 11.8169 8.56236C11.4687 8.56236 11.1303 8.53649 10.8013 8.5C11.0609 8.84969 11.2381 9.25361 11.3194 9.6815C11.4846 9.69078 11.6478 9.70206 11.8169 9.70206C14.6795 9.70206 17 8.42238 17 6.84153V5.70116ZM5.18306 7.29728C2.32053 7.29728 0 8.57762 0 10.1585C0 11.7393 2.3212 13.0197 5.18306 13.0197C8.04558 13.0197 10.3661 11.7393 10.3661 10.1585C10.3661 8.57762 8.04492 7.29728 5.18306 7.29728ZM17 7.69133C16.9987 9.27219 14.6795 10.5525 11.8169 10.5525C11.6504 10.5525 11.4819 10.5406 11.3194 10.5313C11.3121 10.5811 11.3081 10.6474 11.2988 10.6971C11.332 10.7973 11.3605 10.8962 11.3605 11.0089V11.6723C11.5111 11.6796 11.6624 11.6922 11.8169 11.6922C14.6795 11.6922 17 10.4125 17 8.83169V7.69133ZM17 9.6815C16.9987 11.2624 14.6795 12.5427 11.8169 12.5427C11.6504 12.5427 11.4819 12.5308 11.3194 12.5215C11.3121 12.5712 11.3081 12.6376 11.2988 12.6873C11.332 12.7868 11.3605 12.8863 11.3605 12.9991V13.6625C11.5111 13.6698 11.6624 13.6824 11.8169 13.6824C14.6795 13.6824 17 12.4027 17 10.8219V9.6815ZM10.3661 11.0083C10.3648 12.5891 8.04558 13.8695 5.18306 13.8695C2.32849 13.8695 0.0132678 12.6031 0 11.0288V12.1486C0 13.7295 2.31987 15.0098 5.18306 15.0098C8.04624 15.0098 10.3661 13.7295 10.3661 12.1486V11.0083ZM10.3661 12.9984C10.3648 14.5793 8.04558 15.8596 5.18306 15.8596C2.32849 15.8596 0.0132678 14.5932 0 13.019V14.1388C0 15.7197 2.31987 17 5.18306 17C8.04624 17 10.3661 15.7197 10.3661 14.1388V12.9984Z"
      fill="white"></path>
</svg>
</span> <?=Loc::getMessage('pay_tcoins')?>
                                    </button>


                                    <button type="button" class="btn btn-primary btn-paid payCardPayPlus" ><span class="mr-2"><svg width="17" height="14"
                                                                                           viewBox="0 0 17 14"
                                                                                           fill="none"
                                                                                           xmlns="http://www.w3.org/2000/svg">
<path d="M16.3929 0H0.607143C0.271317 0 0 0.284375 0 0.636364V3.81818H17V0.636364C17 0.284375 16.7287 0 16.3929 0ZM0 13.3636C0 13.7156 0.271317 14 0.607143 14H16.3929C16.7287 14 17 13.7156 17 13.3636V5.56818H0V13.3636ZM10.9855 9.70455C10.9855 9.61705 11.0538 9.54545 11.1373 9.54545H14.2679C14.3513 9.54545 14.4196 9.61705 14.4196 9.70455V11.1364C14.4196 11.2239 14.3513 11.2955 14.2679 11.2955H11.1373C11.0538 11.2955 10.9855 11.2239 10.9855 11.1364V9.70455Z"
      fill="white"></path>
</svg>
</span> <?=Loc::getMessage('pay_shek')?>
                                    </button>

                                    <div class="modal fade" id="payCard" tabindex="-1" aria-labelledby="payCard"
                                         aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content pt-3 pb-5 px-5">
                                                <div class="p-0 mb-4 border-bottom-0 modal-header justify-content-end">
                                                    <h2 class="subtitle" id="exampleModalLabel">Оплата</h2>
                                                </div>

                                                <div class="p-0 modal-body text-right">
                                                    <p class="mb-4 text-uppercase font-weight-bold">MY BALANCE: <span
                                                                class="text-primary">100 TCOIN</span></p>
                                                    <p class="mb-0 text-uppercase font-weight-bold">К списанию: <span
                                                                class="text-primary">80 TCOIN</span></p>

                                                    <hr>

                                                    <p class="mb-3 text-uppercase font-weight-bold text-secondary">
                                                        Остаток: <span>20 TCOIN</span></p>
                                                    <p class="mb-3 text-uppercase font-weight-bold text-secondary">У вас
                                                        недостаточно средств</p>
                                                </div>

                                                <div class="p-0 border-top-0 modal-footer">
                                                    <button type="button" class="btn" data-dismiss="modal">Close
                                                    </button>
                                                    <button type="submit" class="btn btn-primary">Оплатить</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane fade" id="pills-property" role="tabpanel"
                             aria-labelledby="pills-property-tab">
                            <form action="">
                                <p class="h3 mb-4 px-4 pt-4 pb-3 text-right border-bottom"><?=Loc::getMessage('Classic')?></p>

                                <div class="mb-4 d-flex flex-column">
                                    <?php foreach ($arTypeProp['CLASSIC'] as $arItem) { ?>
                                        <div class="mb-4 d-flex flex-column">
                                            <div class="d-flex justify-content-between justify-content-end">
                                                <p class="m-0 mx-2 mx-lg-4 text-primary font-weight-bold text-nowrap"><?= $arItem['UF_PRICE'] ?>
                                                    T</p>

                                                <div class="d-flex">
                                                    <div class="mr-4 d-flex flex-column align-items-end">
                                                        <p class="font-weight-bold title"><?= $arItem['UF_NAME'] ?></p>
                                                        <p class="text-subtitle"><?=Loc::getMessage('paket_for')?><?= $arItem['UF_DAYS'] ?>
                                                            <?=Loc::getMessage('days')?></p>
                                                    </div>

                                                    <label class="custom-radio-btn">
                                                        <input class="controlPanelPaket" type="radio" name="selectPack"
                                                               data-count="<?= $arItem['UF_COUNT'] ?>"
                                                               data-id-paket="<?= $arItem['ID'] ?>"
                                                               data-price="<?= $arItem['UF_PRICE'] ?>"
                                                               data-days="<?= $arItem['UF_DAYS'] ?>"
                                                               data-type="<?=PROPERTY_ADS_TYPE_CODE?>"
                                                        >
                                                        <span class="checkbox"></span>
                                                    </label>
                                                </div>
                                            </div>

                                        </div>
                                    <?php } ?>
                                </div>

                                <!-- BUSINES TARIF -->
                                <p class="h3 mb-4 px-4 pt-4 pb-3 text-right border-bottom"><?=Loc::getMessage('Business')?></p>

                                <div class="mb-4 d-flex flex-column">
                                    <?php foreach ($arTypeProp['BUSINES'] as $arItem) { ?>
                                        <div class="mb-4 d-flex flex-column">
                                            <div class="d-flex justify-content-between justify-content-end">
                                                <p class="m-0 mx-2 mx-lg-4 text-primary font-weight-bold text-nowrap"><?= $arItem['UF_PRICE'] ?>
                                                    T</p>

                                                <div class="d-flex">
                                                    <div class="mr-4 d-flex flex-column align-items-end">
                                                        <p class="font-weight-bold title"><?= $arItem['UF_NAME'] ?></p>
                                                        <p class="text-subtitle"><?=Loc::getMessage('paket_for')?><?= $arItem['UF_DAYS'] ?>
                                                            <?=Loc::getMessage('days')?></p>
                                                    </div>

                                                    <label class="custom-radio-btn">
                                                        <input class="controlPanelPaket" type="radio" name="selectPack"
                                                               data-count="<?= $arItem['UF_COUNT'] ?>"
                                                               data-id-paket="<?= $arItem['ID'] ?>"
                                                               data-price="<?= $arItem['UF_PRICE'] ?>"
                                                               data-days="<?= $arItem['UF_DAYS'] ?>"
                                                               data-type="<?=PROPERTY_ADS_TYPE_CODE?>"
                                                        >
                                                        <span class="checkbox"></span>
                                                    </label>
                                                </div>
                                            </div>

                                        </div>
                                    <?php } ?>
                                </div>

                                <div class="mb-4 d-flex flex-column flex-md-row justify-content-end">
                                    <!-- Button trigger modal -->
                                    <button type="button"
                                            class="mb-3 mb-md-0 mr-0 mr-md-2 mr-lg-4 btn btn-primary btn-paid "
                                            data-toggle="modal" data-target="#payTcoins"><span class="mr-2"><svg
                                                    width="17" height="17" viewBox="0 0 17 17" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
<path d="M11.8169 0.00066338C8.95442 0.00066338 6.63389 1.28034 6.63389 2.8612C6.63389 4.44205 8.95508 5.72239 11.8169 5.72239C14.6795 5.72239 17 4.44205 17 2.8612C17 1.28034 14.6788 0 11.8169 0V0.00066338ZM17 3.711C16.9987 5.29185 14.6795 6.57219 11.8169 6.57219C8.96238 6.57219 6.64716 5.30578 6.63389 3.73223V4.85136C6.63389 5.52669 7.06642 6.14497 7.77492 6.63455C8.49138 6.82959 9.12956 7.10025 9.66093 7.44256C10.3197 7.60973 11.0441 7.71189 11.8169 7.71189C14.6795 7.71189 17 6.43222 17 4.85136V3.711ZM17 5.70116C17 7.28202 14.6795 8.56236 11.8169 8.56236C11.4687 8.56236 11.1303 8.53649 10.8013 8.5C11.0609 8.84969 11.2381 9.25361 11.3194 9.6815C11.4846 9.69078 11.6478 9.70206 11.8169 9.70206C14.6795 9.70206 17 8.42238 17 6.84153V5.70116ZM5.18306 7.29728C2.32053 7.29728 0 8.57762 0 10.1585C0 11.7393 2.3212 13.0197 5.18306 13.0197C8.04558 13.0197 10.3661 11.7393 10.3661 10.1585C10.3661 8.57762 8.04492 7.29728 5.18306 7.29728ZM17 7.69133C16.9987 9.27219 14.6795 10.5525 11.8169 10.5525C11.6504 10.5525 11.4819 10.5406 11.3194 10.5313C11.3121 10.5811 11.3081 10.6474 11.2988 10.6971C11.332 10.7973 11.3605 10.8962 11.3605 11.0089V11.6723C11.5111 11.6796 11.6624 11.6922 11.8169 11.6922C14.6795 11.6922 17 10.4125 17 8.83169V7.69133ZM17 9.6815C16.9987 11.2624 14.6795 12.5427 11.8169 12.5427C11.6504 12.5427 11.4819 12.5308 11.3194 12.5215C11.3121 12.5712 11.3081 12.6376 11.2988 12.6873C11.332 12.7868 11.3605 12.8863 11.3605 12.9991V13.6625C11.5111 13.6698 11.6624 13.6824 11.8169 13.6824C14.6795 13.6824 17 12.4027 17 10.8219V9.6815ZM10.3661 11.0083C10.3648 12.5891 8.04558 13.8695 5.18306 13.8695C2.32849 13.8695 0.0132678 12.6031 0 11.0288V12.1486C0 13.7295 2.31987 15.0098 5.18306 15.0098C8.04624 15.0098 10.3661 13.7295 10.3661 12.1486V11.0083ZM10.3661 12.9984C10.3648 14.5793 8.04558 15.8596 5.18306 15.8596C2.32849 15.8596 0.0132678 14.5932 0 13.019V14.1388C0 15.7197 2.31987 17 5.18306 17C8.04624 17 10.3661 15.7197 10.3661 14.1388V12.9984Z"
      fill="white"></path>
</svg>
</span> <?=Loc::getMessage('pay_tcoins')?>
                                    </button>


                                    <button type="button" class="btn btn-primary btn-paid payCardPayPlus" ><span class="mr-2"><svg width="17" height="14"
                                                                                           viewBox="0 0 17 14"
                                                                                           fill="none"
                                                                                           xmlns="http://www.w3.org/2000/svg">
<path d="M16.3929 0H0.607143C0.271317 0 0 0.284375 0 0.636364V3.81818H17V0.636364C17 0.284375 16.7287 0 16.3929 0ZM0 13.3636C0 13.7156 0.271317 14 0.607143 14H16.3929C16.7287 14 17 13.7156 17 13.3636V5.56818H0V13.3636ZM10.9855 9.70455C10.9855 9.61705 11.0538 9.54545 11.1373 9.54545H14.2679C14.3513 9.54545 14.4196 9.61705 14.4196 9.70455V11.1364C14.4196 11.2239 14.3513 11.2955 14.2679 11.2955H11.1373C11.0538 11.2955 10.9855 11.2239 10.9855 11.1364V9.70455Z"
      fill="white"></path>
</svg>
</span> <?=Loc::getMessage('pay_shek')?>
                                    </button>

                                    <div class="modal fade" id="payCard" tabindex="-1" aria-labelledby="payCard"
                                         aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content pt-3 pb-5 px-5">
                                                <div class="p-0 mb-4 border-bottom-0 modal-header justify-content-end">
                                                    <h2 class="subtitle" id="exampleModalLabel">Оплата</h2>
                                                </div>

                                                <div class="p-0 modal-body text-right">
                                                    <p class="mb-4 text-uppercase font-weight-bold">MY BALANCE: <span
                                                                class="text-primary">100 TCOIN</span></p>
                                                    <p class="mb-0 text-uppercase font-weight-bold">К списанию: <span
                                                                class="text-primary">80 TCOIN</span></p>

                                                    <hr>

                                                    <p class="mb-3 text-uppercase font-weight-bold text-secondary">
                                                        Остаток: <span>20 TCOIN</span></p>
                                                    <p class="mb-3 text-uppercase font-weight-bold text-secondary">У вас
                                                        недостаточно средств</p>
                                                </div>

                                                <div class="p-0 border-top-0 modal-footer">
                                                    <button type="button" class="btn" data-dismiss="modal">Close
                                                    </button>
                                                    <button type="submit" class="btn btn-primary">Оплатить</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane fade" id="pills-flea-market" role="tabpanel"
                             aria-labelledby="pills-flea-market-tab">
                            <form action="">
                                <p class="h3 mb-4 px-4 pt-4 pb-3 text-right border-bottom"><?=Loc::getMessage('Classic')?></p>
                                <?php foreach ($arTypeFlea['CLASSIC'] as $arItem) { ?>
                                    <div class="mb-4 d-flex flex-column">
                                        <div class="d-flex justify-content-between justify-content-end">
                                            <p class="m-0 mx-2 mx-lg-4 text-primary font-weight-bold text-nowrap"><?= $arItem['UF_PRICE'] ?>
                                                T</p>

                                            <div class="d-flex">
                                                <div class="mr-4 d-flex flex-column align-items-end">
                                                    <p class="font-weight-bold title"><?= $arItem['UF_NAME'] ?></p>
                                                    <p class="text-subtitle"><?=Loc::getMessage('paket_for')?><?= $arItem['UF_DAYS'] ?> <?=Loc::getMessage('days')?></p>
                                                </div>

                                                <label class="custom-radio-btn">
                                                    <input class="controlPanelPaket" type="radio" name="selectPack"
                                                           data-count="<?= $arItem['UF_COUNT'] ?>"
                                                           data-id-paket="<?= $arItem['ID'] ?>"
                                                           data-price="<?= $arItem['UF_PRICE'] ?>"
                                                           data-days="<?= $arItem['UF_DAYS'] ?>"
                                                           data-type="<?=FLEA_ADS_TYPE_CODE?>"
                                                    >
                                                    <span class="checkbox"></span>
                                                </label>
                                            </div>
                                        </div>

                                    </div>
                                <?php } ?>

                                <!-- BUSINES TARIF -->
                                <p class="h3 mb-4 px-4 pt-4 pb-3 text-right border-bottom"><?=Loc::getMessage('Business')?></p>

                                <?php foreach ($arTypeFlea['BUSINES'] as $arItem) { ?>
                                    <div class="mb-4 d-flex flex-column">
                                        <div class="d-flex justify-content-between justify-content-end">
                                            <p class="m-0 mx-2 mx-lg-4 text-primary font-weight-bold text-nowrap"><?= $arItem['UF_PRICE'] ?> T</p>
                                            <div class="d-flex">
                                                <div class="mr-4 d-flex flex-column align-items-end">
                                                    <p class="font-weight-bold title"><?= $arItem['UF_NAME'] ?></p>
                                                    <p class="text-subtitle"><?=Loc::getMessage('paket_for')?><?= $arItem['UF_DAYS'] ?> <?=Loc::getMessage('days')?></p>
                                                </div>
                                                <label class="custom-radio-btn">
                                                    <input class="controlPanelPaket" type="radio" name="selectPack"
                                                           data-count="<?= $arItem['UF_COUNT'] ?>"
                                                           data-id-paket="<?= $arItem['ID'] ?>"
                                                           data-price="<?= $arItem['UF_PRICE'] ?>"
                                                           data-days="<?= $arItem['UF_DAYS'] ?>"
                                                           data-type="<?=FLEA_ADS_TYPE_CODE?>"
                                                    >
                                                    <span class="checkbox"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>

                                <div class="mb-4 d-flex flex-column flex-md-row justify-content-end">
                                    <!-- Button trigger modal -->
                                    <button type="button"
                                            class="mb-3 mb-md-0 mr-0 mr-md-2 mr-lg-4 btn btn-primary btn-paid "
                                            data-toggle="modal" data-target="#payTcoins">
                                        <span class="mr-2">
                                            <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M11.8169 0.00066338C8.95442 0.00066338 6.63389 1.28034 6.63389 2.8612C6.63389 4.44205 8.95508 5.72239 11.8169 5.72239C14.6795 5.72239 17 4.44205 17 2.8612C17 1.28034 14.6788 0 11.8169 0V0.00066338ZM17 3.711C16.9987 5.29185 14.6795 6.57219 11.8169 6.57219C8.96238 6.57219 6.64716 5.30578 6.63389 3.73223V4.85136C6.63389 5.52669 7.06642 6.14497 7.77492 6.63455C8.49138 6.82959 9.12956 7.10025 9.66093 7.44256C10.3197 7.60973 11.0441 7.71189 11.8169 7.71189C14.6795 7.71189 17 6.43222 17 4.85136V3.711ZM17 5.70116C17 7.28202 14.6795 8.56236 11.8169 8.56236C11.4687 8.56236 11.1303 8.53649 10.8013 8.5C11.0609 8.84969 11.2381 9.25361 11.3194 9.6815C11.4846 9.69078 11.6478 9.70206 11.8169 9.70206C14.6795 9.70206 17 8.42238 17 6.84153V5.70116ZM5.18306 7.29728C2.32053 7.29728 0 8.57762 0 10.1585C0 11.7393 2.3212 13.0197 5.18306 13.0197C8.04558 13.0197 10.3661 11.7393 10.3661 10.1585C10.3661 8.57762 8.04492 7.29728 5.18306 7.29728ZM17 7.69133C16.9987 9.27219 14.6795 10.5525 11.8169 10.5525C11.6504 10.5525 11.4819 10.5406 11.3194 10.5313C11.3121 10.5811 11.3081 10.6474 11.2988 10.6971C11.332 10.7973 11.3605 10.8962 11.3605 11.0089V11.6723C11.5111 11.6796 11.6624 11.6922 11.8169 11.6922C14.6795 11.6922 17 10.4125 17 8.83169V7.69133ZM17 9.6815C16.9987 11.2624 14.6795 12.5427 11.8169 12.5427C11.6504 12.5427 11.4819 12.5308 11.3194 12.5215C11.3121 12.5712 11.3081 12.6376 11.2988 12.6873C11.332 12.7868 11.3605 12.8863 11.3605 12.9991V13.6625C11.5111 13.6698 11.6624 13.6824 11.8169 13.6824C14.6795 13.6824 17 12.4027 17 10.8219V9.6815ZM10.3661 11.0083C10.3648 12.5891 8.04558 13.8695 5.18306 13.8695C2.32849 13.8695 0.0132678 12.6031 0 11.0288V12.1486C0 13.7295 2.31987 15.0098 5.18306 15.0098C8.04624 15.0098 10.3661 13.7295 10.3661 12.1486V11.0083ZM10.3661 12.9984C10.3648 14.5793 8.04558 15.8596 5.18306 15.8596C2.32849 15.8596 0.0132678 14.5932 0 13.019V14.1388C0 15.7197 2.31987 17 5.18306 17C8.04624 17 10.3661 15.7197 10.3661 14.1388V12.9984Z"
                                                      fill="white"></path>
                                            </svg>
                                        </span>
                                        <?=Loc::getMessage('pay_tcoins')?>
                                    </button>
                                    <button type="button" class="btn btn-primary btn-paid payCardPayPlus" >
                                        <span class="mr-2">
                                            <svg width="17" height="14"
                                               viewBox="0 0 17 14"
                                               fill="none"
                                               xmlns="http://www.w3.org/2000/svg">
                                                <path d="M16.3929 0H0.607143C0.271317 0 0 0.284375 0 0.636364V3.81818H17V0.636364C17 0.284375 16.7287 0 16.3929 0ZM0 13.3636C0 13.7156 0.271317 14 0.607143 14H16.3929C16.7287 14 17 13.7156 17 13.3636V5.56818H0V13.3636ZM10.9855 9.70455C10.9855 9.61705 11.0538 9.54545 11.1373 9.54545H14.2679C14.3513 9.54545 14.4196 9.61705 14.4196 9.70455V11.1364C14.4196 11.2239 14.3513 11.2955 14.2679 11.2955H11.1373C11.0538 11.2955 10.9855 11.2239 10.9855 11.1364V9.70455Z"
                                                      fill="white"></path>
                                            </svg>
                                        </span> <?=Loc::getMessage('pay_shek')?>
                                    </button>
                                    <div class="modal fade" id="payCard" tabindex="-1" aria-labelledby="payCard" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content pt-3 pb-5 px-5">
                                                <div class="p-0 mb-4 border-bottom-0 modal-header justify-content-end">
                                                    <h2 class="subtitle" id="exampleModalLabel">Оплата</h2>
                                                </div>
                                                <div class="p-0 modal-body text-right">
                                                    <p class="mb-4 text-uppercase font-weight-bold">MY BALANCE: <span class="text-primary">100 TCOIN</span></p>
                                                    <p class="mb-0 text-uppercase font-weight-bold">К списанию: <span class="text-primary">80 TCOIN</span></p>
                                                    <hr>
                                                    <p class="mb-3 text-uppercase font-weight-bold text-secondary">
                                                        Остаток: <span>20 TCOIN</span></p>
                                                    <p class="mb-3 text-uppercase font-weight-bold text-secondary">У вас
                                                        недостаточно средств</p>
                                                </div>
                                                <div class="p-0 border-top-0 modal-footer">
                                                    <button type="button" class="btn" data-dismiss="modal">Close
                                                    </button>
                                                    <button type="submit" class="btn btn-primary">Оплатить</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="payTcoins" tabindex="-1" aria-labelledby="payTcoins" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content pt-3 pb-5 px-5">
                        <div class="p-0 mb-4 border-bottom-0 modal-header justify-content-end">
                            <h2 class="subtitle" id="exampleModalLabel"><?=Loc::getMessage('pay')?></h2>
                        </div>
                        <div class="p-0 modal-body text-right">
                            <p  class="mb-4 text-uppercase font-weight-bold"><?=Loc::getMessage('BALANCE')?> <span id="payTcoinsBalance" class="text-primary">100 </span>TCOIN
                            </p>
                            <p class="mb-0 text-uppercase font-weight-bold"><?=Loc::getMessage('need_to_pay')?> <span id="payTcoinsNeedle" class="text-primary">80 </span>TCOIN
                            </p>
                            <hr>
                            <p class="mb-3 text-uppercase font-weight-bold text-secondary"><?=Loc::getMessage('result')?>
                                <span id="payTcoinsNeedleRes">20</span> TCOIN</p>
                        </div>
                        <div class="p-0 border-top-0 modal-footer">
                            <button type="button" class="btn" data-dismiss="modal"><?=Loc::getMessage('Close')?></button>
                            <button id="formControlTcoins" type="submit" class="btn btn-primary"><?=Loc::getMessage('Make_pay')?></button>
                        </div>
                    </div>
                </div>
            </div>
            <?php include $_SERVER['DOCUMENT_ROOT'] . '/personal/left.php' ?>
            <script>
                $('.controlPanelPaket').click(function () {
                    let $data;
                    $('#paketControl').find('input, textearea, select').each(function () {
                        if ($(this).is(':checked')) {
                            $data = $(this).data();
                        }
                    });

                    $.ajax({
                        url: '/ajax/buy-rate-ajax.php',
                        method: 'post',
                        async: false,
                        data: {type: 'getData'},
                        success: function (data) {
                            console.log(data);
                            $('#payTcoinsBalance').text(data);
                            $('#payTcoinsNeedle').text($data.price);
                            $('#payTcoinsNeedleRes').text(data- $data.price)
                            if (data - $data.price < 0){
                                $('#formControlTcoins').show();
                                $('#formControlTcoins').click(function () {
                                    window.location.href = "/personal/wallet/"
                                });
                            }else {
                                $('#formControlTcoins').show();
                            }
                        }
                    });
                });

                $('#formControlTcoins').click(function () {
                    var $data;

                    $('#paketControl').find('input, textearea, select').each(function () {
                        if ($(this).is(':checked')) {
                            $data = $(this).data();
                        }
                    });

                    if($data == undefined){
                        $('.allert__text').html('не выбран тариф');

                        $('.del_all_in_chat').html('ok');
                        $('.alert-confirmation').addClass('show');
                    }else {

                        $.ajax({
                            url: '/ajax/buy-rate-ajax.php',
                            method: 'post',
                            async: false,
                            data: $data,
                            success: function (data) {
                                window.location.href = '/personal/';
                            }
                        });
                    }

                });

                $('.payCardPayPlus').click(function () {
                    let $data;

                    $('#paketControl').find('input, textearea, select').each(function () {
                        if ($(this).is(':checked')) {
                            $data = $(this).data()
                        }
                    });

                    if ($data == undefined) {
                        $('.allert__text').html('не выбран тариф');

                        $('.del_all_in_chat').html('ok');
                        $('.alert-confirmation').addClass('show');
                    }else {
                        $.ajax({
                            url: '/ajax/secureZXC/pay.php',
                            method: 'post',
                            dataType: 'json',
                            async: false,
                            data: {
                                url: '/ajax/buy-rate-ajax.php',
                                count: $data.count,
                                days: $data.days,
                                idPaket: $data.idPaket,
                                price: $data.price,
                                type: $data.type
                            },
                            success: function (data) {
                                window.location.href = data.data.payment_page_link
                            }
                        });
                    }
                });
            </script>
        </div>
    </div>
    <div class="allert alert-confirmation flex-column card">
        <button onclick="$('.alert-confirmation').removeClass('show');" type="button" class="close" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <div class="d-flex justify-content-center allert__text"></div>
        <div class="d-flex justify-content-center mt-4">
            <button onclick="$('.alert-confirmation').removeClass('show');" class="btn_confirm btn border-primary text-uppercase font-weight-bold text-primary py-3 px-5">ok</button>
        </div>
    </div>
<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>