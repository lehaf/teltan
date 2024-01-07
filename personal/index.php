<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

/** @global object $APPLICATION */
/** @global object $USER */

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);
$APPLICATION->SetTitle("Персональный раздел");

if (!$USER->IsAuthorized()) LocalRedirect("/");

$arTypesVip = getHLData(PERSONAL_VIP_TYPES_HL_ID, ['*']);
$arTypesRise = getHLData(PERSONAL_RISE_HL_ID, ['*']);
$arTypesColour = getHLData(PERSONAL_COLOR_HL_ID, ['*']);
$arTypesLent = getHLData(PERSONAL_RIBBON_HL_ID, ['*']);
$arTypesPaket = getHLData(PERSONAL_PACKET_HL_ID, ['*']);
$arPaket = getHLData(BOUGHT_RATE_HL_ID, ['*'],['UF_USER_ID' => $USER->GetID()]);


$arUser = CUser::GetByID($USER->GetID())->Fetch();

function resGetter(int $iblockId, int $userId) : array
{
    $arResult = [];
    $arSelect = array(
        "ID",
        "IBLOCK_ID",
        "NAME",
        'DATE_MODIFY',
        'TIMESTAMP_X',
        "DATE_ACTIVE_FROM",
        'PREVIEW_PICTURE',
        'DETAIL_PAGE_URL',
        'SHOW_COUNTER',
        'PROPERTY_TIME_RISE',
        'DATE_CREATE',
        'ACTIVE'
    );

    $arFilter = array(
        "IBLOCK_ID" => $iblockId,
        "ACTIVE" => "Y",
        "PROPERTY_ID_USER" => $userId
    );
    $res = CIBlockElement::GetList(array("DATE_CREATE" => "DESC"), $arFilter, false, false, $arSelect);
    $counter = 0;
    while ($ob = $res->GetNextElement()) {
        $arFields = $ob->GetFields();
        $arResult['ITEMS'][$counter] = $arFields;
        $arProps = $ob->GetProperties();
        $arResult['ITEMS'][$counter]['PROPERTY'] = $arProps;
        $counter++;
    }

    return !empty($arResult) ? $arResult : ['N'];
}

function resUnGetter(int $iblockId, int $userId) : array
{
    $arResult = [];
    $arSelect = array("ID", "IBLOCK_ID", "NAME", 'DATE_MODIFY', "DATE_ACTIVE_FROM", 'PREVIEW_PICTURE', 'DETAIL_PAGE_URL', 'PROPERTY_TIME_RISE', 'SHOW_COUNTER', 'DATE_CREATE', 'ACTIVE');
    $arFilter = array("IBLOCK_ID" => $iblockId, "ACTIVE" => "N", "PROPERTY_ID_USER" => $userId);
    $res = CIBlockElement::GetList(array("DATE_CREATE" => "DESC"), $arFilter, false, false, $arSelect);
    $counter = 0;
    while ($ob = $res->GetNextElement()) {
        $arFields = $ob->GetFields();
        $arResult['ITEMS'][$counter] = $arFields;
        $arProps = $ob->GetProperties();
        $arResult['ITEMS'][$counter]['PROPERTY'] = $arProps;
        $counter++;
    }

    return !empty($arResult) ? $arResult : ['N'];
}

function reCount($ar)
{
    if ($ar[0] != 'N' && $ar != null) {
        return count($ar);
    } else {
        return 0;
    }

}

$ar1 = resGetter(SIMPLE_ADS_IBLOCK_ID, $USER->GetID());
$ar2 = resGetter(PROPERTY_ADS_IBLOCK_ID, $USER->GetID());
$ar3 = resGetter(AUTO_IBLOCK_ID, $USER->GetID());
$ar7 = resGetter(MOTO_IBLOCK_ID, $USER->GetID());
$ar8 = resGetter(SCOOTER_IBLOCK_ID, $USER->GetID());
$ar1un = resUnGetter(SIMPLE_ADS_IBLOCK_ID, $USER->GetID());
$ar2un = resUnGetter(PROPERTY_ADS_IBLOCK_ID, $USER->GetID());
$ar3un = resUnGetter(AUTO_IBLOCK_ID, $USER->GetID());
$ar7un = resUnGetter(MOTO_IBLOCK_ID, $USER->GetID());
$ar8un = resUnGetter(SCOOTER_IBLOCK_ID, $USER->GetID());
$active = reCount($ar1['ITEMS']) + reCount($ar2['ITEMS']) + reCount($ar3['ITEMS']) + reCount($ar7['ITEMS']) + reCount($ar8['ITEMS']);
$unactive = reCount($ar1un['ITEMS']) + reCount($ar2un['ITEMS']) + reCount($ar3un['ITEMS']) + reCount($ar7un['ITEMS']) + reCount($ar8un['ITEMS']);


$allElements = [];


foreach ($ar1 as $value) {
    foreach ($value as $item) {
        $allElements[] = $item;
    }
}
foreach ($ar2 as $value) {
    foreach ($value as $item) {

        $allElements[] = $item;
    }
}
foreach ($ar3 as $value) {
    foreach ($value as $item) {

        $allElements[] = $item;
    }
}
foreach ($ar7 as $value) {

    foreach ($value as $item) {
        $allElements[] = $item;
    }
}
foreach ($ar8 as $value) {

    foreach ($value as $item) {
        $allElements[] = $item;
    }
}
usort($allElements, function ($a, $b) {
    $ad = new DateTime($a['TIMESTAMP_X']);
    $bd = new DateTime($b['TIMESTAMP_X']);

    if ($ad == $bd) {
        return 0;
    }

    return $ad < $bd ? -1 : 1;
});
$allElements = array_reverse($allElements);
?>

<?php //$APPLICATION->IncludeComponent(
//            "bitrix:news.list",
//            "personal_ads",
//            array(
//            "DISPLAY_DATE" => "Y",
//            "DISPLAY_NAME" => "Y",
//            "DISPLAY_PICTURE" => "Y",
//            "DISPLAY_PREVIEW_TEXT" => "Y",
//            "AJAX_MODE" => "Y",
//            "IBLOCK_TYPE" => "announcements",
//            "IBLOCK_ID" => "2",
//            "NEWS_COUNT" => "20",
//            "SORT_BY1" => "ACTIVE_FROM",
//            "SORT_ORDER1" => "DESC",
//            "SORT_BY2" => "SORT",
//            "SORT_ORDER2" => "ASC",
//            "FILTER_NAME" => "",
//            "FIELD_CODE" => Array("ID"),
//            "PROPERTY_CODE" => Array("DESCRIPTION"),
//            "CHECK_DATES" => "Y",
//            "DETAIL_URL" => "",
//            "PREVIEW_TRUNCATE_LEN" => "",
//            "ACTIVE_DATE_FORMAT" => "d.m.Y",
//            "SET_TITLE" => "Y",
//            "SET_BROWSER_TITLE" => "Y",
//            "SET_META_KEYWORDS" => "Y",
//            "SET_META_DESCRIPTION" => "Y",
//            "SET_LAST_MODIFIED" => "Y",
//            "INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
//            "ADD_SECTIONS_CHAIN" => "Y",
//            "HIDE_LINK_WHEN_NO_DETAIL" => "Y",
//            "PARENT_SECTION" => "",
//            "PARENT_SECTION_CODE" => "",
//            "INCLUDE_SUBSECTIONS" => "Y",
//            "CACHE_TYPE" => "A",
//            "CACHE_TIME" => "3600",
//            "CACHE_FILTER" => "Y",
//            "CACHE_GROUPS" => "Y",
//            "DISPLAY_TOP_PAGER" => "Y",
//            "DISPLAY_BOTTOM_PAGER" => "Y",
//            "PAGER_TITLE" => "Новости",
//            "PAGER_SHOW_ALWAYS" => "Y",
//            "PAGER_TEMPLATE" => "",
//            "PAGER_DESC_NUMBERING" => "Y",
//            "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
//            "PAGER_SHOW_ALL" => "Y",
//            "PAGER_BASE_LINK_ENABLE" => "Y",
//            "SET_STATUS_404" => "Y",
//            "SHOW_404" => "Y",
//            "MESSAGE_404" => "",
//            "PAGER_BASE_LINK" => "",
//            "PAGER_PARAMS_NAME" => "arrPager",
//            "AJAX_OPTION_JUMP" => "N",
//            "AJAX_OPTION_STYLE" => "Y",
//            "AJAX_OPTION_HISTORY" => "N",
//            "AJAX_OPTION_ADDITIONAL" => ""
//        )
//    );
//?>




<div class="container">
    <h2 class="mb-4 subtitle">
        <?= Loc::getMessage('TITl'); ?>
    </h2>
    <div class="row">
        <div class="col-12 col-xl-9">
            <!-- annoucments -->
            <div class="mb-4">
                <div id="tabs">
                    <div class="mb-4 d-flex justify-content-center justify-content-lg-end status-announcement">
                        <div class="form_radio_btn">
                            <input id="falseAnnouncement" type="radio" name="announcement" value="unActiveAnnouncement">
                            <label class="btn-left" for="falseAnnouncement"><?=Loc::getMessage('UNACTIVE_COUNT')?>
                                <span class="ml-2 falseAnnouncementCounter"><?=$unactive?></span>
                            </label>
                        </div>
                        <div class="form_radio_btn">
                            <input id="trueAnnouncement" type="radio" name="announcement" value="activeAnnouncement" checked>
                            <label class="btn-right" for="trueAnnouncement"><?=Loc::getMessage('ACTIVE_COUNT')?>
                                <span class="ml-2 trueAnnouncementCounter"><?=$active?></span>
                            </label>
                        </div>
                    </div>
                </div>
                <?php
                    $APPLICATION->IncludeComponent(
                        "webco:user.ads.counter",
                        "",
                        array(
                        )
                    );
                ?>
            </div>
            <!-- annoucments END -->
            <?php if ($active < 1 && $unactive < 1) { ?>
            <!-- message -->
            <div class="mb-4 card d-flex flex-column flex-lg-row w-100 justify-content-around no-message">
                <div class="mb-3 mb-0 d-flex flex-column align-items-center justify-content-center">
                    <p class="mb-4"><?= Loc::getMessage('NO_ADS'); ?></p>
                    <img src="<?= SITE_TEMPLATE_PATH ?>/assets/no-message.svg" alt="">
                </div>

                <div class="d-flex align-items-center justify-content-center">
                    <button class="btn btn-primary"><?= Loc::getMessage('To_add_an_advert'); ?></button>
                </div>
            </div>
            <?php } else { ?>
            <!-- message END -->

            <!-- user product -->
            <div  id="activeAnnouncement">

                <?php foreach ($allElements as $arItem) { ?>

                <div class="mb-4 card product-card product-line user-product">
                    <div class="card-link" href="<?= $arItem['DETAIL_PAGE_URL'] ?>">
                        <div onclick="window.location.href='<?= $arItem['DETAIL_PAGE_URL'] ?>'" style="cursor: pointer" class="image-block">
                            <div class="i-box">
                                <img src="<?= CFile::GetPath($arItem["PREVIEW_PICTURE"]); ?>" alt="no-img">
                            </div>
                        </div>

                        <div class="px-2 px-lg-3 content-block">
                            <div class="d-flex flex-column h-100 justify-content-between text-right">
                                <div class="mb-3 mb-lg-5 d-flex flex-column-reverse flex-lg-row justify-content-between align-items-end">
                                    <p class="price"><?= ICON_CURRENCY; ?> <?= number_format($arItem['PROPERTY']['PRICE']['VALUE'], 0, '.', ' '); ?></p>
                                    <a href="<?= $arItem['DETAIL_PAGE_URL'] ?>"
                                       class="title"><?= $arItem['NAME'] ?></a>
                                </div>

                                <div class="mb-4 d-flex flex-column flex-lg-row">
                                    <div class="edit-user-item">
                                        <button
                                                id="text-uppercase<?= $arItem['ID'] ?>"
                                                class="mr-lg-4 mb-3 mb-lg-0 btn user-product__btn-edit text-uppercase">
                                            <?= Loc::getMessage('UP_EDIT'); ?>
                                        </button>
                                        <script>
                                            $('#text-uppercase<?= $arItem['ID'] ?>').on('click', (e) => {
                                                e.preventDefault()
                                                $('#edit-item-menu_item<?= $arItem['ID'] ?>').toggleClass('active')
                                            })
                                        </script>
                                        <ul id="edit-item-menu_item<?= $arItem['ID'] ?>"
                                            class="flex-column edit-item-menu_item">
                                            <li class="border-bottom">
                                                <div class="custom-control custom-switch activateItem">
                                                    <input type="checkbox" class="custom-control-input"
                                                           id="activateItem<?= $arItem['ID'] ?>"
                                                           checked="checked">
                                                    <label id="activateItemText<?= $arItem['ID'] ?>"
                                                           data-iblock-id="<?= $arItem['IBLOCK_ID'] ?>"
                                                           data-item-id="<?= $arItem['ID'] ?>"
                                                           class="custom-control-label"
                                                           for="activateItem<?= $arItem['ID'] ?>"><?= Loc::getMessage('DELETE_UN'); ?></label>
                                                </div>
                                            </li>
                                            <script>
                                                $('#activateItemText<?= $arItem['ID'] ?>').click(function () {

                                                    var attе = '';
                                                    if ($('#activateItem<?= $arItem['ID'] ?>').is(':checked')) {

                                                        var tte = 'green';
                                                    } else {
                                                        var tte = 'red';
                                                    }

                                                    $.ajax({
                                                        url: '/ajax/active_item.php',
                                                        method: 'post',
                                                        async: false,
                                                        data: {data: $(this).data(), value: tte},
                                                        success: function (data) {
                                                            $('.allert__text').html(data);

                                                            $('.del_all_in_chat').html('ok');
                                                            $('.alert-confirmation').addClass('show');
                                                        }
                                                    })
                                                })
                                            </script>
                                            <li class="border-bottom">
                                                <a class="mr-3"
                                                   href="/add/<?php if ($arItem['PROPERTY']['BUY']['VALUE_XML_ID'] == 'true') {
                                                       echo 'rent';
                                                   } else {
                                                       if ($arItem['IBLOCK_ID'] == 2) {
                                                           echo 'buy';
                                                       } else {
                                                           if ($arItem['IBLOCK_ID'] == 1) {
                                                               echo 'fm';
                                                           } elseif ($arItem['IBLOCK_ID'] == 3) {

                                                               echo 'auto';
                                                           } elseif ($arItem['IBLOCK_ID'] == 8) {
                                                               echo 'scooter';
                                                           } else {
                                                               echo 'moto';
                                                           }
                                                       }
                                                   }

                                                    ?>/?ID=<?= $arItem['ID'] ?>&EDIT=Y"><?= Loc::getMessage('UP_EDIT'); ?></a>

                                                <span class="mr-2"><svg width="16" height="16"
                                                                        viewBox="0 0 16 16" fill="none"
                                                                        xmlns="http://www.w3.org/2000/svg">
                                                <path d="M15.4042 3.28224L12.6642 0.542241C12.3066 0.206336 11.838 0.0135995 11.3475 0.000692758C10.8571 -0.012214 10.379 0.15561 10.0042 0.472241L1.0042 9.47224C0.680969 9.79821 0.479707 10.2254 0.434203 10.6822L0.00420295 14.8522C-0.00926809 14.9987 0.00973728 15.1463 0.0598642 15.2846C0.109991 15.4229 0.190005 15.5484 0.294203 15.6522C0.387643 15.7449 0.498459 15.8182 0.620297 15.868C0.742134 15.9178 0.872596 15.943 1.0042 15.9422H1.0942L5.2642 15.5622C5.721 15.5167 6.14824 15.3155 6.4742 14.9922L15.4742 5.99224C15.8235 5.62321 16.0123 5.13075 15.9992 4.62278C15.9861 4.1148 15.7721 3.63275 15.4042 3.28224ZM12.0042 6.62224L9.3242 3.94224L11.2742 1.94224L14.0042 4.67224L12.0042 6.62224Z"
                                                      fill="#3FC5FF"/>
                                                </svg>
                                                </span>
                                            </li>

                                            <li class="px-3">
                                                <button id="alertConfirmation<?= $arItem['ID'] ?>"
                                                        type="button"
                                                        class="btn p-0 text-secondary">
                                                    <span class="mr-2"><?= Loc::getMessage('DELETE'); ?></span>

                                                    <i class="mr-2 icon-clear"></i>
                                                </button>
                                            </li>
                                        </ul>

                                        <div id="alert-confirmationIdView<?= $arItem['ID'] ?>"
                                             class="allert alert-confirmation flex-column card">
                                            <button type="button" class="close" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>

                                            <div class="d-flex justify-content-center allert__text">
                                                <?= Loc::getMessage('CT_BNL_ELEMENT_DELETE_CONFIRM'); ?></div>


                                            <div class="d-flex justify-content-center mt-4">
                                                <button data-item="<?= $arItem['ID'] ?>"
                                                        id="delItemId<?= $arItem['ID'] ?>"
                                                        class="btn border-primary text-uppercase font-weight-bold text-primary py-3 px-5">
                                                    <?= Loc::getMessage('DELETE'); ?></button>

                                            </div>
                                        </div>
                                    </div>
                                    <script>
                                        $('#alertConfirmation<?=$arItem['ID']?>').on('click', function () {
                                            $('#alert-confirmationIdView<?=$arItem['ID']?>').addClass('show');
                                        })
                                        $('#delItemId<?=$arItem['ID']?>').click(function () {
                                            $.ajax({
                                                url: '/ajax/del_item.php',
                                                method: 'post',
                                                async: false,
                                                data: $(this).data(),
                                                success: function (data) {
                                                }
                                            });
                                            window.location.reload();
                                        })
                                    </script>
                                    <?php $APPLICATION->IncludeComponent(
                                        "webco:buttons",
                                        "boost",
                                        array(
                                            'ITEM_ID' => $arItem['ID'],
                                            'IBLOCK_ID' => $arItem['IBLOCK_ID']
                                        )
                                    ); ?>
                                </div>
                            </div>

                            <div class="border-top py-3 d-flex justify-content-between align-items-center text-nowrap product-line__data-viwe">
                                <div class="d-flex">
                                            <span class="mr-0 mr-lg-2 views"><span><?= $arItem['SHOW_COUNTER'] ?></span> <i
                                                        class="icon-visibility"></i></span>

                                    <div class="d-none d-lg-flex justify-content-end align-items-center ml-5 product-line__up-date">
                                        <div class="mr-2 d-flex justify-content-center align-items-center user-product__up-product">
                                                        <span data-id="<?= $arItem['ID'] ?>"
                                                              class="text-uppercase font-weight-bold upRise">UP</span>
                                        </div>
                                        <?php $strDate = getStringDate($arItem['PROPERTY']['TIME_RAISE']['VALUE']); ?>
                                        <span class="up-date"><?= ($strDate['MES']) ? GetMessage($strDate['MES']) . ', ' . $strDate['HOURS'] : $strDate['HOURS']; ?></span>
                                    </div>
                                </div>
                                <?php $strDate2 = getStringDate($arItem['DATE_CREATE']); ?>
                                <span class="date"><?= ($strDate2['MES']) ? GetMessage($strDate2['MES']) . ', ' . $strDate2['HOURS'] : $strDate2['HOURS']; ?></span>
                            </div>
                        </div>
                    </div>
                    <?php if ($arItem['PROPERTY']['COUNT_RAISE']['VALUE'] != '' && $arItem['PROPERTY']['COUNT_RAISE']['VALUE'] > 0) { ?>
                        <div type="button"
                             data-id="<?= $arItem['ID'] ?>" data-iblock-id="<?= $arItem['IBLOCK_ID'] ?>"
                             class="b-none d-lg-flex justify-content-center align-items-center rise-btn">
                                        <span data-id="<?= $arItem['ID'] ?>"
                                              class="mr-1 text-uppercase font-weight-bold up">UP</span>

                            <p class="m-0"><?= Loc::getMessage('UP_RISE'); ?>
                                (<span><?= $arItem['PROPERTY']['COUNT_RAISE']['VALUE'] ?></span>)</p>
                        </div>
                    <?php } ?>

                    <div class="d-flex flex-column controls-rise-item">

                        <?php
                        if ($arItem['PROPERTY']['VIP_DATE']['VALUE'] && strtotime($arItem['PROPERTY']['VIP_DATE']['VALUE']) > time()) {
                            ?>
                            <div class="d-flex justify-content-center align-items-center item">
                                <svg width="22" height="19" viewBox="0 0 22 19" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1.58936 3.42876L5.88549 6.18822L10.1673 0.413067C10.2619 0.285313 10.3868 0.181179 10.5317 0.109331C10.6765 0.0374835 10.837 0 10.9999 0C11.1628 0 11.3234 0.0374835 11.4682 0.109331C11.613 0.181179 11.7379 0.285313 11.8326 0.413067L16.1144 6.18822L20.4105 3.42876C20.5731 3.32454 20.7633 3.26734 20.9585 3.26392C21.1538 3.2605 21.346 3.31101 21.5124 3.40947C21.6788 3.50793 21.8125 3.65023 21.8976 3.81956C21.9828 3.98888 22.0159 4.17815 21.9929 4.36501L20.3123 18.1298C20.283 18.3695 20.1634 18.5905 19.9762 18.7509C19.7889 18.9113 19.5471 19 19.2966 19H2.70328C2.45274 19 2.21093 18.9113 2.0237 18.7509C1.83648 18.5905 1.71687 18.3695 1.68755 18.1298L0.00694712 4.36402C-0.015761 4.17725 0.0174677 3.98811 0.102711 3.81895C0.187954 3.64978 0.321652 3.50764 0.488023 3.40931C0.654394 3.31098 0.846492 3.26056 1.04164 3.26401C1.23679 3.26745 1.42684 3.32462 1.58936 3.42876ZM10.9999 13.0869C11.5425 13.0869 12.0629 12.8792 12.4465 12.5096C12.8302 12.1399 13.0457 11.6386 13.0457 11.1158C13.0457 10.5931 12.8302 10.0917 12.4465 9.72209C12.0629 9.35245 11.5425 9.14479 10.9999 9.14479C10.4574 9.14479 9.93701 9.35245 9.55335 9.72209C9.16969 10.0917 8.95416 10.5931 8.95416 11.1158C8.95416 11.6386 9.16969 12.1399 9.55335 12.5096C9.93701 12.8792 10.4574 13.0869 10.9999 13.0869Z"
                                          fill="#F50000"/>
                                </svg>
                            </div>
                            <?php
                        }
                        if ($arItem['PROPERTY']['COLOR_DATE']['VALUE'] && strtotime($arItem['PROPERTY']['COLOR_DATE']['VALUE']) > time()) {
                            ?>
                            <div class="d-flex justify-content-center align-items-center item">
                                <svg width="16" height="17" viewBox="0 0 16 17" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M8.20189 0.934761C8.20189 0.779763 8.14032 0.631114 8.03072 0.521514C7.92112 0.411914 7.77247 0.350342 7.61747 0.350342C7.46247 0.350342 7.31382 0.411914 7.20422 0.521514C7.09462 0.631114 7.03305 0.779763 7.03305 0.934761V1.90879C6.78643 1.99564 6.56248 2.13677 6.37772 2.32178L1.01743 7.68285C0.854624 7.84566 0.725478 8.03894 0.637367 8.25165C0.549256 8.46437 0.503906 8.69236 0.503906 8.9226C0.503906 9.15284 0.549256 9.38083 0.637367 9.59355C0.725478 9.80626 0.854624 9.99954 1.01743 10.1623L4.82005 13.9634C4.98286 14.1262 5.17613 14.2554 5.38885 14.3435C5.60157 14.4316 5.82956 14.4769 6.0598 14.4769C6.29004 14.4769 6.51803 14.4316 6.73075 14.3435C6.94346 14.2554 7.13674 14.1262 7.29955 13.9634L12.6598 8.60312C12.8226 8.44031 12.9518 8.24703 13.0399 8.03432C13.128 7.8216 13.1734 7.59361 13.1734 7.36337C13.1734 7.13313 13.128 6.90514 13.0399 6.69242C12.9518 6.47971 12.8226 6.28643 12.6598 6.12362L8.85644 2.32178C8.67191 2.13687 8.44823 1.99574 8.20189 1.90879V0.934761ZM7.03305 3.31919V4.44127C7.03305 4.59627 7.09462 4.74492 7.20422 4.85452C7.31382 4.96412 7.46247 5.02569 7.61747 5.02569C7.77247 5.02569 7.92112 4.96412 8.03072 4.85452C8.14032 4.74492 8.20189 4.59627 8.20189 4.44127V3.31919L11.8323 6.95038C11.9417 7.05996 12.0032 7.2085 12.0032 7.36337C12.0032 7.51824 11.9417 7.66678 11.8323 7.77636L11.0765 8.53221H1.82159L1.84419 8.50883L7.03305 3.31919Z"
                                          fill="#6633F5"/>
                                    <path d="M14.063 9.78046C14.0049 9.67162 13.9183 9.5806 13.8125 9.51714C13.7067 9.45369 13.5856 9.42017 13.4622 9.42017C13.3388 9.42017 13.2177 9.45369 13.1119 9.51714C13.0061 9.5806 12.9195 9.67162 12.8614 9.78046L11.2967 12.715C10.4232 14.3498 11.6092 16.3244 13.4622 16.3244C15.3152 16.3244 16.4996 14.3498 15.6284 12.715L14.063 9.78046Z"
                                          fill="#6633F5"/>
                                </svg>
                            </div>
                            <?php
                        }
                        if ($arItem['PROPERTY']['LENTA_DATE']['VALUE'] && strtotime($arItem['PROPERTY']['LENTA_DATE']['VALUE']) > time()) {
                            ?>
                            <div class="d-flex justify-content-center align-items-center item">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <rect width="9.40476" height="6.83184" rx="0.5"
                                          transform="matrix(0.977206 -0.212292 0.118541 0.992949 0.503906 9.04102)"
                                          fill="#FB2BFF"/>
                                    <rect width="10.4788" height="6.83184" rx="0.5"
                                          transform="matrix(0.977206 -0.212292 0.118541 0.992949 4.87109 3.15161)"
                                          fill="#FB2BFF"/>
                                    <path d="M5.58984 9.95654L9.93666 9.01223L10.4706 13.4847L5.58984 9.95654Z"
                                          fill="#961299"/>
                                </svg>
                            </div>
                            <?php
                        }
                        if ($arItem['PROPERTY']['PAKET_DATE']['VALUE'] && strtotime($arItem['PROPERTY']['PAKET_DATE']['VALUE']) > time()) {
                            ?>
                            <div class="d-flex justify-content-center align-items-center item">
                                <svg width="16" height="18" viewBox="0 0 16 18" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M10.7811 0.968714C10.7811 0.792056 10.7264 0.619732 10.6246 0.475353C10.5228 0.330975 10.3789 0.221608 10.2125 0.16224C10.0461 0.102871 9.86545 0.0964054 9.69525 0.143729C9.52505 0.191053 9.37365 0.289851 9.26179 0.426584L0.697334 9.84749C0.594729 9.97297 0.529841 10.125 0.510211 10.2859C0.49058 10.4468 0.517013 10.61 0.586437 10.7564C0.655861 10.9029 0.765426 11.0267 0.902399 11.1133C1.03937 11.2 1.19813 11.246 1.36022 11.2461H5.64245V16.3847C5.64248 16.5614 5.69714 16.7337 5.79894 16.8781C5.90074 17.0225 6.04469 17.1318 6.21107 17.1912C6.37746 17.2506 6.55813 17.257 6.72833 17.2097C6.89853 17.1624 7.04993 17.0636 7.16179 16.9269L15.7262 7.50596C15.8288 7.38048 15.8937 7.22845 15.9134 7.06755C15.933 6.90666 15.9066 6.74349 15.8371 6.59702C15.7677 6.45054 15.6582 6.32678 15.5212 6.24011C15.3842 6.15343 15.2254 6.10741 15.0634 6.10739H10.7811V0.968714Z"
                                          fill="#FF6B00"/>
                                </svg>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <?php } ?>
            </div>

            <div class="d-none" id="unActiveAnnouncement" data-filter="unActiveAnnouncement">

                <?php foreach ($ar1un['ITEMS'] as $arItem) { ?>
                <div class="mb-4 card product-card product-line user-product">
                    <div class="card-link" href="<?= $arItem['DETAIL_PAGE_URL'] ?>">
                        <div onclick="window.location.href='<?= $arItem['DETAIL_PAGE_URL'] ?>'" style="cursor: pointer" class="image-block">
                            <div class="i-box">
                                <img src="<?= CFile::GetPath($arItem["PREVIEW_PICTURE"]); ?>" alt="no-img">
                            </div>
                        </div>

                        <div class="px-2 px-lg-3 content-block">
                            <div class="d-flex flex-column h-100 justify-content-between text-right">
                                <div class="mb-3 mb-lg-5 d-flex flex-column-reverse flex-lg-row justify-content-between align-items-end">
                                    <p class="price"><?= ICON_CURRENCY; ?> <?= number_format($arItem['PROPERTY']['PRICE']['VALUE'], 0, '.', ' '); ?></p>
                                    <a href="<?= $arItem['DETAIL_PAGE_URL'] ?>"
                                       class="title"><?= $arItem['NAME'] ?></a>
                                </div>

                                <div class="mb-4 d-flex flex-column flex-lg-row">
                                    <div class="edit-user-item">
                                        <button
                                                id="text-uppercase<?= $arItem['ID'] ?>"
                                                class="mr-lg-4 mb-3 mb-lg-0 btn user-product__btn-edit text-uppercase">
                                            <?= Loc::getMessage('UP_EDIT'); ?>
                                        </button>
                                        <script>
                                            $('#text-uppercase<?= $arItem['ID'] ?>').on('click', (e) => {
                                                e.preventDefault()
                                                $('#edit-item-menu_item<?= $arItem['ID'] ?>').toggleClass('active')
                                            })
                                        </script>
                                        <ul id="edit-item-menu_item<?= $arItem['ID'] ?>"
                                            class="flex-column edit-item-menu_item">
                                            <li class="border-bottom">
                                                <div class="custom-control custom-switch activateItem">
                                                    <input type="checkbox" class="custom-control-input"
                                                           id="activateItem<?= $arItem['ID'] ?>">
                                                    <label id="activateItemText<?= $arItem['ID'] ?>"
                                                           data-iblock-id="<?= $arItem['IBLOCK_ID'] ?>"
                                                           data-item-id="<?= $arItem['ID'] ?>"
                                                           class="custom-control-label"
                                                           for="activateItem<?= $arItem['ID'] ?>"><?= Loc::getMessage('DELETE_UN'); ?></label>
                                                </div>
                                            </li>
                                            <script>
                                                $('#activateItemText<?= $arItem['ID'] ?>').click(function () {
                                                    var attе = '';
                                                    if ($('#activateItem<?= $arItem['ID'] ?>').is(':checked')) {
                                                        var tte = 'green';
                                                    } else {
                                                        var tte = 'red';
                                                    }

                                                    $.ajax({
                                                        url: '/ajax/active_item.php',
                                                        method: 'post',
                                                        async: false,
                                                        data: {data: $(this).data(), value: tte},
                                                        success: function (data) {
                                                            $('.allert__text').html(data);

                                                            $('.del_all_in_chat').html('ok');
                                                            $('.alert-confirmation').addClass('show');
                                                        }
                                                    });
                                                })
                                            </script>


                                            <li class="border-bottom">
                                                <a class="mr-3"
                                                   href="/add/fm/?ID=<?= $arItem['ID'] ?>&EDIT=Y"><?= Loc::getMessage('UP_EDIT'); ?></a>

                                                <span class="mr-2"><svg width="16" height="16"
                                                                        viewBox="0 0 16 16" fill="none"
                                                                        xmlns="http://www.w3.org/2000/svg">
                                                <path d="M15.4042 3.28224L12.6642 0.542241C12.3066 0.206336 11.838 0.0135995 11.3475 0.000692758C10.8571 -0.012214 10.379 0.15561 10.0042 0.472241L1.0042 9.47224C0.680969 9.79821 0.479707 10.2254 0.434203 10.6822L0.00420295 14.8522C-0.00926809 14.9987 0.00973728 15.1463 0.0598642 15.2846C0.109991 15.4229 0.190005 15.5484 0.294203 15.6522C0.387643 15.7449 0.498459 15.8182 0.620297 15.868C0.742134 15.9178 0.872596 15.943 1.0042 15.9422H1.0942L5.2642 15.5622C5.721 15.5167 6.14824 15.3155 6.4742 14.9922L15.4742 5.99224C15.8235 5.62321 16.0123 5.13075 15.9992 4.62278C15.9861 4.1148 15.7721 3.63275 15.4042 3.28224ZM12.0042 6.62224L9.3242 3.94224L11.2742 1.94224L14.0042 4.67224L12.0042 6.62224Z"
                                                      fill="#3FC5FF"/>
                                                    </svg>
                                                </span>
                                            </li>

                                            <li class="px-3">
                                                <button id="alertConfirmation<?= $arItem['ID'] ?>"
                                                        type="button"
                                                        class="btn p-0 text-secondary">
                                                    <span class="mr-2"><?= Loc::getMessage('DELETE'); ?></span>

                                                    <i class="mr-2 icon-clear"></i>
                                                </button>
                                            </li>
                                        </ul>

                                        <div id="alert-confirmationIdView<?= $arItem['ID'] ?>"
                                             class="allert alert-confirmation flex-column card">
                                            <button type="button" class="close" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>

                                            <div class="d-flex justify-content-center allert__text">
                                                <?= Loc::getMessage('CT_BNL_ELEMENT_DELETE_CONFIRM'); ?></div>


                                            <div class="d-flex justify-content-center mt-4">
                                                <button data-item="<?= $arItem['ID'] ?>"
                                                        id="delItemId<?= $arItem['ID'] ?>"
                                                        class="btn border-primary text-uppercase font-weight-bold text-primary py-3 px-5">
                                                    <?= Loc::getMessage('DELETE'); ?></button>

                                            </div>
                                        </div>
                                    </div>
                                    <script>
                                        $('#alertConfirmation<?=$arItem['ID']?>').on('click', function () {
                                            $('#alert-confirmationIdView<?=$arItem['ID']?>').addClass('show');
                                        })
                                        $('#delItemId<?=$arItem['ID']?>').click(function () {
                                            $.ajax({
                                                url: '/ajax/del_item.php',
                                                method: 'post',
                                                async: false,
                                                data: $(this).data(),
                                                success: function (data) {
                                                }
                                            });
                                            window.location.reload();
                                        })
                                    </script>

                                    <?php $APPLICATION->IncludeComponent(
                                        "webco:buttons",
                                        "boost",
                                        array(
                                            'ITEM_ID' => $arItem['ID'],
                                            'IBLOCK_ID' => $arItem['IBLOCK_ID']
                                        )
                                    ); ?>
                                </div>
                            </div>

                            <div class="border-top py-3 d-flex justify-content-between align-items-center text-nowrap product-line__data-viwe">
                                <div class="d-flex">
                                            <span class="mr-0 mr-lg-2 views"><span><?= $arItem['SHOW_COUNTER'] ?></span> <i
                                                        class="icon-visibility"></i></span>

                                    <div class="d-none d-lg-flex justify-content-end align-items-center ml-5 product-line__up-date">
                                        <div class="mr-2 d-flex justify-content-center align-items-center user-product__up-product">
                                                        <span data-id="<?= $arItem['ID'] ?>"
                                                              class="text-uppercase font-weight-bold upRise">UP</span>
                                        </div>
                                        <?php $strDate = getStringDate($arItem['PROPERTY']['TIME_RAISE']['VALUE']); ?>
                                        <span class="up-date"><?= ($strDate['MES']) ? GetMessage($strDate['MES']) . ', ' . $strDate['HOURS'] : $strDate['HOURS']; ?></span>
                                    </div>
                                </div>
                                <?php $strDate2 = getStringDate($arItem['DATE_CREATE']); ?>
                                <span class="date"><?= ($strDate2['MES']) ? GetMessage($strDate2['MES']) . ', ' . $strDate2['HOURS'] : $strDate2['HOURS']; ?></span>
                            </div>
                        </div>
                    </div>
                    <?php if ($arItem['PROPERTY']['COUNT_RAISE']['VALUE'] != '' && $arItem['PROPERTY']['COUNT_RAISE']['VALUE'] > 0) { ?>
                    <div type="button"
                         data-id="<?= $arItem['ID'] ?>" data-iblock-id="<?= $arItem['IBLOCK_ID'] ?>"
                         class="b-none d-lg-flex justify-content-center align-items-center rise-btn">
                                        <span data-id="<?= $arItem['ID'] ?>"
                                              class="mr-1 text-uppercase font-weight-bold up">UP</span>

                        <p class="m-0"><?= Loc::getMessage('UP_RISE'); ?>
                            (<span><?= $arItem['PROPERTY']['COUNT_RAISE']['VALUE'] ?></span>)</p>
                    </div>
                    <?php } ?>

                    <div class="d-flex flex-column controls-rise-item">

                        <?php
                        if ($arItem['PROPERTY']['VIP_DATE']['VALUE'] && strtotime($arItem['PROPERTY']['VIP_DATE']['VALUE']) > time()) {
                        ?>
                            <div class="d-flex justify-content-center align-items-center item">
                                <svg width="22" height="19" viewBox="0 0 22 19" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1.58936 3.42876L5.88549 6.18822L10.1673 0.413067C10.2619 0.285313 10.3868 0.181179 10.5317 0.109331C10.6765 0.0374835 10.837 0 10.9999 0C11.1628 0 11.3234 0.0374835 11.4682 0.109331C11.613 0.181179 11.7379 0.285313 11.8326 0.413067L16.1144 6.18822L20.4105 3.42876C20.5731 3.32454 20.7633 3.26734 20.9585 3.26392C21.1538 3.2605 21.346 3.31101 21.5124 3.40947C21.6788 3.50793 21.8125 3.65023 21.8976 3.81956C21.9828 3.98888 22.0159 4.17815 21.9929 4.36501L20.3123 18.1298C20.283 18.3695 20.1634 18.5905 19.9762 18.7509C19.7889 18.9113 19.5471 19 19.2966 19H2.70328C2.45274 19 2.21093 18.9113 2.0237 18.7509C1.83648 18.5905 1.71687 18.3695 1.68755 18.1298L0.00694712 4.36402C-0.015761 4.17725 0.0174677 3.98811 0.102711 3.81895C0.187954 3.64978 0.321652 3.50764 0.488023 3.40931C0.654394 3.31098 0.846492 3.26056 1.04164 3.26401C1.23679 3.26745 1.42684 3.32462 1.58936 3.42876ZM10.9999 13.0869C11.5425 13.0869 12.0629 12.8792 12.4465 12.5096C12.8302 12.1399 13.0457 11.6386 13.0457 11.1158C13.0457 10.5931 12.8302 10.0917 12.4465 9.72209C12.0629 9.35245 11.5425 9.14479 10.9999 9.14479C10.4574 9.14479 9.93701 9.35245 9.55335 9.72209C9.16969 10.0917 8.95416 10.5931 8.95416 11.1158C8.95416 11.6386 9.16969 12.1399 9.55335 12.5096C9.93701 12.8792 10.4574 13.0869 10.9999 13.0869Z"
                                          fill="#F50000"/>
                                </svg>
                            </div>
                            <?php
                        }
                        if ($arItem['PROPERTY']['COLOR_DATE']['VALUE'] && strtotime($arItem['PROPERTY']['COLOR_DATE']['VALUE']) > time()) {
                        ?>
                            <div class="d-flex justify-content-center align-items-center item">
                                <svg width="16" height="17" viewBox="0 0 16 17" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M8.20189 0.934761C8.20189 0.779763 8.14032 0.631114 8.03072 0.521514C7.92112 0.411914 7.77247 0.350342 7.61747 0.350342C7.46247 0.350342 7.31382 0.411914 7.20422 0.521514C7.09462 0.631114 7.03305 0.779763 7.03305 0.934761V1.90879C6.78643 1.99564 6.56248 2.13677 6.37772 2.32178L1.01743 7.68285C0.854624 7.84566 0.725478 8.03894 0.637367 8.25165C0.549256 8.46437 0.503906 8.69236 0.503906 8.9226C0.503906 9.15284 0.549256 9.38083 0.637367 9.59355C0.725478 9.80626 0.854624 9.99954 1.01743 10.1623L4.82005 13.9634C4.98286 14.1262 5.17613 14.2554 5.38885 14.3435C5.60157 14.4316 5.82956 14.4769 6.0598 14.4769C6.29004 14.4769 6.51803 14.4316 6.73075 14.3435C6.94346 14.2554 7.13674 14.1262 7.29955 13.9634L12.6598 8.60312C12.8226 8.44031 12.9518 8.24703 13.0399 8.03432C13.128 7.8216 13.1734 7.59361 13.1734 7.36337C13.1734 7.13313 13.128 6.90514 13.0399 6.69242C12.9518 6.47971 12.8226 6.28643 12.6598 6.12362L8.85644 2.32178C8.67191 2.13687 8.44823 1.99574 8.20189 1.90879V0.934761ZM7.03305 3.31919V4.44127C7.03305 4.59627 7.09462 4.74492 7.20422 4.85452C7.31382 4.96412 7.46247 5.02569 7.61747 5.02569C7.77247 5.02569 7.92112 4.96412 8.03072 4.85452C8.14032 4.74492 8.20189 4.59627 8.20189 4.44127V3.31919L11.8323 6.95038C11.9417 7.05996 12.0032 7.2085 12.0032 7.36337C12.0032 7.51824 11.9417 7.66678 11.8323 7.77636L11.0765 8.53221H1.82159L1.84419 8.50883L7.03305 3.31919Z"
                                          fill="#6633F5"/>
                                    <path d="M14.063 9.78046C14.0049 9.67162 13.9183 9.5806 13.8125 9.51714C13.7067 9.45369 13.5856 9.42017 13.4622 9.42017C13.3388 9.42017 13.2177 9.45369 13.1119 9.51714C13.0061 9.5806 12.9195 9.67162 12.8614 9.78046L11.2967 12.715C10.4232 14.3498 11.6092 16.3244 13.4622 16.3244C15.3152 16.3244 16.4996 14.3498 15.6284 12.715L14.063 9.78046Z"
                                          fill="#6633F5"/>
                                </svg>
                            </div>
                            <?php
                        }
                        if ($arItem['PROPERTY']['LENTA_DATE']['VALUE'] && strtotime($arItem['PROPERTY']['LENTA_DATE']['VALUE']) > time()) {
                        ?>
                            <div class="d-flex justify-content-center align-items-center item">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <rect width="9.40476" height="6.83184" rx="0.5"
                                          transform="matrix(0.977206 -0.212292 0.118541 0.992949 0.503906 9.04102)"
                                          fill="#FB2BFF"/>
                                    <rect width="10.4788" height="6.83184" rx="0.5"
                                          transform="matrix(0.977206 -0.212292 0.118541 0.992949 4.87109 3.15161)"
                                          fill="#FB2BFF"/>
                                    <path d="M5.58984 9.95654L9.93666 9.01223L10.4706 13.4847L5.58984 9.95654Z"
                                          fill="#961299"/>
                                </svg>
                            </div>
                            <?php
                        }
                        if ($arItem['PROPERTY']['PAKET_DATE']['VALUE'] && strtotime($arItem['PROPERTY']['PAKET_DATE']['VALUE']) > time()) {
                        ?>
                            <div class="d-flex justify-content-center align-items-center item">
                                <svg width="16" height="18" viewBox="0 0 16 18" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M10.7811 0.968714C10.7811 0.792056 10.7264 0.619732 10.6246 0.475353C10.5228 0.330975 10.3789 0.221608 10.2125 0.16224C10.0461 0.102871 9.86545 0.0964054 9.69525 0.143729C9.52505 0.191053 9.37365 0.289851 9.26179 0.426584L0.697334 9.84749C0.594729 9.97297 0.529841 10.125 0.510211 10.2859C0.49058 10.4468 0.517013 10.61 0.586437 10.7564C0.655861 10.9029 0.765426 11.0267 0.902399 11.1133C1.03937 11.2 1.19813 11.246 1.36022 11.2461H5.64245V16.3847C5.64248 16.5614 5.69714 16.7337 5.79894 16.8781C5.90074 17.0225 6.04469 17.1318 6.21107 17.1912C6.37746 17.2506 6.55813 17.257 6.72833 17.2097C6.89853 17.1624 7.04993 17.0636 7.16179 16.9269L15.7262 7.50596C15.8288 7.38048 15.8937 7.22845 15.9134 7.06755C15.933 6.90666 15.9066 6.74349 15.8371 6.59702C15.7677 6.45054 15.6582 6.32678 15.5212 6.24011C15.3842 6.15343 15.2254 6.10741 15.0634 6.10739H10.7811V0.968714Z"
                                          fill="#FF6B00"/>
                                </svg>
                            </div>
                            <?php
                        }
                        ?>

                    </div>
                </div>
                <?php } ?>
                <?php foreach ($ar2un['ITEMS'] as $arItem) { ?>
                <div class="mb-4 card product-card product-line user-product">
                    <div class="card-link" href="<?= $arItem['DETAIL_PAGE_URL'] ?>">
                        <div onclick="window.location.href='<?= $arItem['DETAIL_PAGE_URL'] ?>'" style="cursor: pointer" class="image-block">
                            <div class="i-box">
                                <img src="<?= CFile::GetPath($arItem["PREVIEW_PICTURE"]); ?>" alt="no-img">
                            </div>
                        </div>

                        <div class="px-2 px-lg-3 content-block">
                            <div class="d-flex flex-column h-100 justify-content-between text-right">
                                <div class="mb-3 mb-lg-5 d-flex flex-column-reverse flex-lg-row justify-content-between align-items-end">
                                    <p class="price"><?= ICON_CURRENCY; ?> <?= number_format($arItem['PROPERTY']['PRICE']['VALUE'], 0, '.', ' '); ?></p>
                                    <a href="<?= $arItem['DETAIL_PAGE_URL'] ?>"
                                       class="title"><?= $arItem['NAME'] ?></a>
                                </div>

                                <div class="mb-4 d-flex flex-column flex-lg-row">
                                    <div class="edit-user-item">
                                        <button
                                                id="text-uppercase<?= $arItem['ID'] ?>"
                                                class="mr-lg-4 mb-3 mb-lg-0 btn user-product__btn-edit text-uppercase">
                                            <?= Loc::getMessage('UP_EDIT'); ?>
                                        </button>
                                        <script>
                                            $('#text-uppercase<?= $arItem['ID'] ?>').on('click', (e) => {
                                                e.preventDefault()
                                                $('#edit-item-menu_item<?= $arItem['ID'] ?>').toggleClass('active')
                                            })
                                        </script>
                                        <ul id="edit-item-menu_item<?= $arItem['ID'] ?>"
                                            class="flex-column edit-item-menu_item">
                                            <li class="border-bottom">
                                                <div class="custom-control custom-switch activateItem">
                                                    <input type="checkbox" class="custom-control-input"
                                                           id="activateItem<?= $arItem['ID'] ?>">
                                                    <label id="activateItemText<?= $arItem['ID'] ?>"
                                                           data-iblock-id="<?= $arItem['IBLOCK_ID'] ?>"
                                                           data-item-id="<?= $arItem['ID'] ?>"
                                                           class="custom-control-label"
                                                           for="activateItem<?= $arItem['ID'] ?>"><?= Loc::getMessage('DELETE_UN'); ?></label>
                                                </div>
                                            </li>
                                            <script>
                                                $('#activateItemText<?= $arItem['ID'] ?>').click(function () {

                                                    var attе = '';
                                                    if ($('#activateItem<?= $arItem['ID'] ?>').is(':checked')) {
                                                        var tte = 'green';
                                                    } else {
                                                        var tte = 'red';
                                                    }

                                                    $.ajax({
                                                        url: '/ajax/active_item.php',
                                                        method: 'post',
                                                        async: false,
                                                        data: {data: $(this).data(), value: tte},
                                                        success: function (data) {
                                                            $('.allert__text').html(data);

                                                            $('.del_all_in_chat').html('ok');
                                                            $('.alert-confirmation').addClass('show');
                                                        }
                                                    });

                                                })
                                            </script>


                                            <li class="border-bottom">
                                                <a class="mr-3"
                                                   href="/add/<?php if ($arItem['PROPERTY']['BUY']['VALUE_XML_ID'] == 'true') {
                                                   echo 'rent';
                                                   } else {
                                                   if ($arItem['IBLOCK_ID'] == 2) {
                                                   echo 'buy';
                                                   } else {
                                                   if ($arItem['IBLOCK_ID'] == 1) {
                                                   echo 'fm';
                                                   } elseif ($arItem['IBLOCK_ID'] == 3) {

                                                   echo 'auto';
                                                   } elseif ($arItem['IBLOCK_ID'] == 8) {
                                                   echo 'scooter';
                                                   } else {
                                                   echo 'moto';
                                                   }
                                                   }
                                                   }

                                                    ?>/?ID=<?= $arItem['ID'] ?>&EDIT=Y"><?= Loc::getMessage('UP_EDIT'); ?></a>

                                                <span class="mr-2"><svg width="16" height="16"
                                                                        viewBox="0 0 16 16" fill="none"
                                                                        xmlns="http://www.w3.org/2000/svg">
<path d="M15.4042 3.28224L12.6642 0.542241C12.3066 0.206336 11.838 0.0135995 11.3475 0.000692758C10.8571 -0.012214 10.379 0.15561 10.0042 0.472241L1.0042 9.47224C0.680969 9.79821 0.479707 10.2254 0.434203 10.6822L0.00420295 14.8522C-0.00926809 14.9987 0.00973728 15.1463 0.0598642 15.2846C0.109991 15.4229 0.190005 15.5484 0.294203 15.6522C0.387643 15.7449 0.498459 15.8182 0.620297 15.868C0.742134 15.9178 0.872596 15.943 1.0042 15.9422H1.0942L5.2642 15.5622C5.721 15.5167 6.14824 15.3155 6.4742 14.9922L15.4742 5.99224C15.8235 5.62321 16.0123 5.13075 15.9992 4.62278C15.9861 4.1148 15.7721 3.63275 15.4042 3.28224ZM12.0042 6.62224L9.3242 3.94224L11.2742 1.94224L14.0042 4.67224L12.0042 6.62224Z"
      fill="#3FC5FF"/>
</svg>
</span>
                                            </li>

                                            <li class="px-3">
                                                <button id="alertConfirmation<?= $arItem['ID'] ?>"
                                                        type="button"
                                                        class="btn p-0 text-secondary">
                                                    <span class="mr-2"><?= Loc::getMessage('DELETE'); ?></span>

                                                    <i class="mr-2 icon-clear"></i>
                                                </button>
                                            </li>
                                        </ul>

                                        <div id="alert-confirmationIdView<?= $arItem['ID'] ?>"
                                             class="allert alert-confirmation flex-column card">
                                            <button type="button" class="close" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>

                                            <div class="d-flex justify-content-center allert__text">
                                                <?= Loc::getMessage('CT_BNL_ELEMENT_DELETE_CONFIRM'); ?></div>


                                            <div class="d-flex justify-content-center mt-4">
                                                <button data-item="<?= $arItem['ID'] ?>"
                                                        id="delItemId<?= $arItem['ID'] ?>"
                                                        class="btn border-primary text-uppercase font-weight-bold text-primary py-3 px-5">
                                                    <?= Loc::getMessage('DELETE'); ?></button>

                                            </div>
                                        </div>
                                    </div>
                                    <script>
                                        $('#alertConfirmation<?=$arItem['ID']?>').on('click', function () {
                                            $('#alert-confirmationIdView<?=$arItem['ID']?>').addClass('show');
                                        })
                                        $('#delItemId<?=$arItem['ID']?>').click(function () {
                                            $.ajax({
                                                url: '/ajax/del_item.php',
                                                method: 'post',
                                                async: false,
                                                data: $(this).data(),
                                                success: function (data) {
                                                }
                                            });
                                            window.location.reload();
                                        })
                                    </script>

                                    <?php $APPLICATION->IncludeComponent(
                                        "webco:buttons",
                                        "boost",
                                        array(
                                            'ITEM_ID' => $arItem['ID'],
                                            'IBLOCK_ID' => $arItem['IBLOCK_ID']
                                        )
                                    ); ?>
                                </div>
                            </div>

                            <div class="border-top py-3 d-flex justify-content-between align-items-center text-nowrap product-line__data-viwe">
                                <div class="d-flex">
                                            <span class="mr-0 mr-lg-2 views"><span><?= $arItem['SHOW_COUNTER'] ?></span> <i
                                                        class="icon-visibility"></i></span>

                                    <div class="d-none d-lg-flex justify-content-end align-items-center ml-5 product-line__up-date">
                                        <div class="mr-2 d-flex justify-content-center align-items-center user-product__up-product">
                                                        <span data-id="<?= $arItem['ID'] ?>"
                                                              class="text-uppercase font-weight-bold upRise">UP</span>
                                        </div>
                                        <?php $strDate = getStringDate($arItem['PROPERTY']['TIME_RAISE']['VALUE']); ?>
                                        <span class="up-date"><?= ($strDate['MES']) ? GetMessage($strDate['MES']) . ', ' . $strDate['HOURS'] : $strDate['HOURS']; ?></span>
                                    </div>
                                </div>
                                <?php $strDate2 = getStringDate($arItem['DATE_CREATE']); ?>
                                <span class="date"><?= ($strDate2['MES']) ? GetMessage($strDate2['MES']) . ', ' . $strDate2['HOURS'] : $strDate2['HOURS']; ?></span>
                            </div>
                        </div>
                    </div>
                    <?php if ($arItem['PROPERTY']['COUNT_RAISE']['VALUE'] != '' && $arItem['PROPERTY']['COUNT_RAISE']['VALUE'] > 0) { ?>
                    <div type="button"
                         data-id="<?= $arItem['ID'] ?>" data-iblock-id="<?= $arItem['IBLOCK_ID'] ?>"
                         class="b-none d-lg-flex justify-content-center align-items-center rise-btn">
                                        <span data-id="<?= $arItem['ID'] ?>"
                                              class="mr-1 text-uppercase font-weight-bold up">UP</span>

                        <p class="m-0"><?= Loc::getMessage('UP_RISE'); ?>
                            (<span><?= $arItem['PROPERTY']['COUNT_RAISE']['VALUE'] ?></span>)</p>
                    </div>
                    <?php } ?>

                    <div class="d-flex flex-column controls-rise-item">

                        <?php
                        if ($arItem['PROPERTY']['VIP_DATE']['VALUE'] && strtotime($arItem['PROPERTY']['VIP_DATE']['VALUE']) > time()) {
                        ?>
                            <div class="d-flex justify-content-center align-items-center item">
                                <svg width="22" height="19" viewBox="0 0 22 19" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1.58936 3.42876L5.88549 6.18822L10.1673 0.413067C10.2619 0.285313 10.3868 0.181179 10.5317 0.109331C10.6765 0.0374835 10.837 0 10.9999 0C11.1628 0 11.3234 0.0374835 11.4682 0.109331C11.613 0.181179 11.7379 0.285313 11.8326 0.413067L16.1144 6.18822L20.4105 3.42876C20.5731 3.32454 20.7633 3.26734 20.9585 3.26392C21.1538 3.2605 21.346 3.31101 21.5124 3.40947C21.6788 3.50793 21.8125 3.65023 21.8976 3.81956C21.9828 3.98888 22.0159 4.17815 21.9929 4.36501L20.3123 18.1298C20.283 18.3695 20.1634 18.5905 19.9762 18.7509C19.7889 18.9113 19.5471 19 19.2966 19H2.70328C2.45274 19 2.21093 18.9113 2.0237 18.7509C1.83648 18.5905 1.71687 18.3695 1.68755 18.1298L0.00694712 4.36402C-0.015761 4.17725 0.0174677 3.98811 0.102711 3.81895C0.187954 3.64978 0.321652 3.50764 0.488023 3.40931C0.654394 3.31098 0.846492 3.26056 1.04164 3.26401C1.23679 3.26745 1.42684 3.32462 1.58936 3.42876ZM10.9999 13.0869C11.5425 13.0869 12.0629 12.8792 12.4465 12.5096C12.8302 12.1399 13.0457 11.6386 13.0457 11.1158C13.0457 10.5931 12.8302 10.0917 12.4465 9.72209C12.0629 9.35245 11.5425 9.14479 10.9999 9.14479C10.4574 9.14479 9.93701 9.35245 9.55335 9.72209C9.16969 10.0917 8.95416 10.5931 8.95416 11.1158C8.95416 11.6386 9.16969 12.1399 9.55335 12.5096C9.93701 12.8792 10.4574 13.0869 10.9999 13.0869Z"
                                          fill="#F50000"/>
                                </svg>
                            </div>
                            <?php
                        }
                        if ($arItem['PROPERTY']['COLOR_DATE']['VALUE'] && strtotime($arItem['PROPERTY']['COLOR_DATE']['VALUE']) > time()) {
                        ?>
                            <div class="d-flex justify-content-center align-items-center item">
                                <svg width="16" height="17" viewBox="0 0 16 17" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M8.20189 0.934761C8.20189 0.779763 8.14032 0.631114 8.03072 0.521514C7.92112 0.411914 7.77247 0.350342 7.61747 0.350342C7.46247 0.350342 7.31382 0.411914 7.20422 0.521514C7.09462 0.631114 7.03305 0.779763 7.03305 0.934761V1.90879C6.78643 1.99564 6.56248 2.13677 6.37772 2.32178L1.01743 7.68285C0.854624 7.84566 0.725478 8.03894 0.637367 8.25165C0.549256 8.46437 0.503906 8.69236 0.503906 8.9226C0.503906 9.15284 0.549256 9.38083 0.637367 9.59355C0.725478 9.80626 0.854624 9.99954 1.01743 10.1623L4.82005 13.9634C4.98286 14.1262 5.17613 14.2554 5.38885 14.3435C5.60157 14.4316 5.82956 14.4769 6.0598 14.4769C6.29004 14.4769 6.51803 14.4316 6.73075 14.3435C6.94346 14.2554 7.13674 14.1262 7.29955 13.9634L12.6598 8.60312C12.8226 8.44031 12.9518 8.24703 13.0399 8.03432C13.128 7.8216 13.1734 7.59361 13.1734 7.36337C13.1734 7.13313 13.128 6.90514 13.0399 6.69242C12.9518 6.47971 12.8226 6.28643 12.6598 6.12362L8.85644 2.32178C8.67191 2.13687 8.44823 1.99574 8.20189 1.90879V0.934761ZM7.03305 3.31919V4.44127C7.03305 4.59627 7.09462 4.74492 7.20422 4.85452C7.31382 4.96412 7.46247 5.02569 7.61747 5.02569C7.77247 5.02569 7.92112 4.96412 8.03072 4.85452C8.14032 4.74492 8.20189 4.59627 8.20189 4.44127V3.31919L11.8323 6.95038C11.9417 7.05996 12.0032 7.2085 12.0032 7.36337C12.0032 7.51824 11.9417 7.66678 11.8323 7.77636L11.0765 8.53221H1.82159L1.84419 8.50883L7.03305 3.31919Z"
                                          fill="#6633F5"/>
                                    <path d="M14.063 9.78046C14.0049 9.67162 13.9183 9.5806 13.8125 9.51714C13.7067 9.45369 13.5856 9.42017 13.4622 9.42017C13.3388 9.42017 13.2177 9.45369 13.1119 9.51714C13.0061 9.5806 12.9195 9.67162 12.8614 9.78046L11.2967 12.715C10.4232 14.3498 11.6092 16.3244 13.4622 16.3244C15.3152 16.3244 16.4996 14.3498 15.6284 12.715L14.063 9.78046Z"
                                          fill="#6633F5"/>
                                </svg>
                            </div>
                            <?php
                        }
                        if ($arItem['PROPERTY']['LENTA_DATE']['VALUE'] && strtotime($arItem['PROPERTY']['LENTA_DATE']['VALUE']) > time()) {
                        ?>
                            <div class="d-flex justify-content-center align-items-center item">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <rect width="9.40476" height="6.83184" rx="0.5"
                                          transform="matrix(0.977206 -0.212292 0.118541 0.992949 0.503906 9.04102)"
                                          fill="#FB2BFF"/>
                                    <rect width="10.4788" height="6.83184" rx="0.5"
                                          transform="matrix(0.977206 -0.212292 0.118541 0.992949 4.87109 3.15161)"
                                          fill="#FB2BFF"/>
                                    <path d="M5.58984 9.95654L9.93666 9.01223L10.4706 13.4847L5.58984 9.95654Z"
                                          fill="#961299"/>
                                </svg>
                            </div>
                            <?php
                        }
                        if ($arItem['PROPERTY']['PAKET_DATE']['VALUE'] && strtotime($arItem['PROPERTY']['PAKET_DATE']['VALUE']) > time()) {
                        ?>
                            <div class="d-flex justify-content-center align-items-center item">
                                <svg width="16" height="18" viewBox="0 0 16 18" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M10.7811 0.968714C10.7811 0.792056 10.7264 0.619732 10.6246 0.475353C10.5228 0.330975 10.3789 0.221608 10.2125 0.16224C10.0461 0.102871 9.86545 0.0964054 9.69525 0.143729C9.52505 0.191053 9.37365 0.289851 9.26179 0.426584L0.697334 9.84749C0.594729 9.97297 0.529841 10.125 0.510211 10.2859C0.49058 10.4468 0.517013 10.61 0.586437 10.7564C0.655861 10.9029 0.765426 11.0267 0.902399 11.1133C1.03937 11.2 1.19813 11.246 1.36022 11.2461H5.64245V16.3847C5.64248 16.5614 5.69714 16.7337 5.79894 16.8781C5.90074 17.0225 6.04469 17.1318 6.21107 17.1912C6.37746 17.2506 6.55813 17.257 6.72833 17.2097C6.89853 17.1624 7.04993 17.0636 7.16179 16.9269L15.7262 7.50596C15.8288 7.38048 15.8937 7.22845 15.9134 7.06755C15.933 6.90666 15.9066 6.74349 15.8371 6.59702C15.7677 6.45054 15.6582 6.32678 15.5212 6.24011C15.3842 6.15343 15.2254 6.10741 15.0634 6.10739H10.7811V0.968714Z"
                                          fill="#FF6B00"/>
                                </svg>
                            </div>
                            <?php
                        }
                        ?>

                    </div>
                </div>
                <?php } ?>
                <?php foreach ($ar3un['ITEMS'] as $arItem) { ?>
                <div class="mb-4 card product-card product-line user-product">
                    <div class="card-link" href="<?= $arItem['DETAIL_PAGE_URL'] ?>">
                        <div onclick="window.location.href='<?= $arItem['DETAIL_PAGE_URL'] ?>'" style="cursor: pointer" class="image-block">
                            <div class="i-box">
                                <img src="<?= CFile::GetPath($arItem["PREVIEW_PICTURE"]); ?>" alt="no-img">
                            </div>
                        </div>

                        <div class="px-2 px-lg-3 content-block">
                            <div class="d-flex flex-column h-100 justify-content-between text-right">
                                <div class="mb-3 mb-lg-5 d-flex flex-column-reverse flex-lg-row justify-content-between align-items-end">
                                    <p class="price"><?= ICON_CURRENCY; ?> <?= number_format($arItem['PROPERTY']['PRICE']['VALUE'], 0, '.', ' '); ?></p>
                                    <a href="<?= $arItem['DETAIL_PAGE_URL'] ?>"
                                       class="title"><?= $arItem['NAME'] ?></a>
                                </div>

                                <div class="mb-4 d-flex flex-column flex-lg-row">
                                    <div class="edit-user-item">
                                        <button
                                                id="text-uppercase<?= $arItem['ID'] ?>"
                                                class="mr-lg-4 mb-3 mb-lg-0 btn user-product__btn-edit text-uppercase">
                                            <?= Loc::getMessage('UP_EDIT'); ?>
                                        </button>
                                        <script>
                                            $('#text-uppercase<?= $arItem['ID'] ?>').on('click', (e) => {
                                                e.preventDefault()
                                                $('#edit-item-menu_item<?= $arItem['ID'] ?>').toggleClass('active')
                                            })
                                        </script>
                                        <ul id="edit-item-menu_item<?= $arItem['ID'] ?>"
                                            class="flex-column edit-item-menu_item">
                                            <li class="border-bottom">
                                                <div class="custom-control custom-switch activateItem">
                                                    <input type="checkbox" class="custom-control-input"
                                                           id="activateItem<?= $arItem['ID'] ?>">
                                                    <label id="activateItemText<?= $arItem['ID'] ?>"
                                                           data-iblock-id="<?= $arItem['IBLOCK_ID'] ?>"
                                                           data-item-id="<?= $arItem['ID'] ?>"
                                                           class="custom-control-label"
                                                           for="activateItem<?= $arItem['ID'] ?>"><?= Loc::getMessage('DELETE_UN'); ?></label>
                                                </div>
                                            </li>
                                            <script>
                                                $('#activateItemText<?= $arItem['ID'] ?>').click(function () {
                                                    var attе = '';
                                                    if ($('#activateItem<?= $arItem['ID'] ?>').is(':checked')) {
                                                        var tte = 'green';
                                                    } else {
                                                        var tte = 'red';
                                                    }

                                                    $.ajax({
                                                        url: '/ajax/active_item.php',
                                                        method: 'post',
                                                        async: false,
                                                        data: {data: $(this).data(), value: tte},
                                                        success: function (data) {
                                                            $('.allert__text').html(data);

                                                            $('.del_all_in_chat').html('ok');
                                                            $('.alert-confirmation').addClass('show');
                                                        }
                                                    });

                                                })
                                            </script>


                                            <li class="border-bottom">
                                                <a class="mr-3"
                                                   href="/add/auto/?ID=<?= $arItem['ID'] ?>&EDIT=Y"><?= Loc::getMessage('UP_EDIT'); ?></a>

                                                <span class="mr-2"><svg width="16" height="16"
                                                                        viewBox="0 0 16 16" fill="none"
                                                                        xmlns="http://www.w3.org/2000/svg">
<path d="M15.4042 3.28224L12.6642 0.542241C12.3066 0.206336 11.838 0.0135995 11.3475 0.000692758C10.8571 -0.012214 10.379 0.15561 10.0042 0.472241L1.0042 9.47224C0.680969 9.79821 0.479707 10.2254 0.434203 10.6822L0.00420295 14.8522C-0.00926809 14.9987 0.00973728 15.1463 0.0598642 15.2846C0.109991 15.4229 0.190005 15.5484 0.294203 15.6522C0.387643 15.7449 0.498459 15.8182 0.620297 15.868C0.742134 15.9178 0.872596 15.943 1.0042 15.9422H1.0942L5.2642 15.5622C5.721 15.5167 6.14824 15.3155 6.4742 14.9922L15.4742 5.99224C15.8235 5.62321 16.0123 5.13075 15.9992 4.62278C15.9861 4.1148 15.7721 3.63275 15.4042 3.28224ZM12.0042 6.62224L9.3242 3.94224L11.2742 1.94224L14.0042 4.67224L12.0042 6.62224Z"
      fill="#3FC5FF"/>
</svg>
</span>
                                            </li>

                                            <li class="px-3">
                                                <button id="alertConfirmation<?= $arItem['ID'] ?>"
                                                        type="button"
                                                        class="btn p-0 text-secondary">
                                                    <span class="mr-2"><?= Loc::getMessage('DELETE'); ?></span>

                                                    <i class="mr-2 icon-clear"></i>
                                                </button>
                                            </li>
                                        </ul>

                                        <div id="alert-confirmationIdView<?= $arItem['ID'] ?>"
                                             class="allert alert-confirmation flex-column card">
                                            <button type="button" class="close" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>

                                            <div class="d-flex justify-content-center allert__text">
                                                <?= Loc::getMessage('CT_BNL_ELEMENT_DELETE_CONFIRM'); ?></div>


                                            <div class="d-flex justify-content-center mt-4">
                                                <button data-item="<?= $arItem['ID'] ?>"
                                                        id="delItemId<?= $arItem['ID'] ?>"
                                                        class="btn border-primary text-uppercase font-weight-bold text-primary py-3 px-5">
                                                    <?= Loc::getMessage('DELETE'); ?></button>

                                            </div>
                                        </div>
                                    </div>
                                    <script>
                                        $('#alertConfirmation<?=$arItem['ID']?>').on('click', function () {
                                            $('#alert-confirmationIdView<?=$arItem['ID']?>').addClass('show');
                                        })
                                        $('#delItemId<?=$arItem['ID']?>').click(function () {
                                            $.ajax({
                                                url: '/ajax/del_item.php',
                                                method: 'post',
                                                async: false,
                                                data: $(this).data(),
                                                success: function (data) {
                                                }
                                            });
                                            window.location.reload();
                                        })
                                    </script>

                                    <?php $APPLICATION->IncludeComponent(
                                        "webco:buttons",
                                        "boost",
                                        array(
                                            'ITEM_ID' => $arItem['ID'],
                                            'IBLOCK_ID' => $arItem['IBLOCK_ID']
                                        )
                                    ); ?>
                                </div>
                            </div>

                            <div class="border-top py-3 d-flex justify-content-between align-items-center text-nowrap product-line__data-viwe">
                                <div class="d-flex">
                                            <span class="mr-0 mr-lg-2 views"><span><?= $arItem['SHOW_COUNTER'] ?></span> <i
                                                        class="icon-visibility"></i></span>

                                    <div class="d-none d-lg-flex justify-content-end align-items-center ml-5 product-line__up-date">
                                        <div class="mr-2 d-flex justify-content-center align-items-center user-product__up-product">
                                                        <span data-id="<?= $arItem['ID'] ?>"
                                                              class="text-uppercase font-weight-bold upRise">UP</span>
                                        </div>
                                        <?php $strDate = getStringDate($arItem['PROPERTY']['TIME_RAISE']['VALUE']); ?>
                                        <span class="up-date"><?= ($strDate['MES']) ? GetMessage($strDate['MES']) . ', ' . $strDate['HOURS'] : $strDate['HOURS']; ?></span>
                                    </div>
                                </div>
                                <?php $strDate2 = getStringDate($arItem['DATE_CREATE']); ?>
                                <span class="date"><?= ($strDate2['MES']) ? GetMessage($strDate2['MES']) . ', ' . $strDate2['HOURS'] : $strDate2['HOURS']; ?></span>
                            </div>
                        </div>
                    </div>
                    <?php if ($arItem['PROPERTY']['COUNT_RAISE']['VALUE'] != '' && $arItem['PROPERTY']['COUNT_RAISE']['VALUE'] > 0) { ?>
                    <div type="button"
                         data-id="<?= $arItem['ID'] ?>" data-iblock-id="<?= $arItem['IBLOCK_ID'] ?>"
                         class="b-none d-lg-flex justify-content-center align-items-center rise-btn">
                                        <span data-id="<?= $arItem['ID'] ?>"
                                              class="mr-1 text-uppercase font-weight-bold up">UP</span>

                        <p class="m-0"><?= Loc::getMessage('UP_RISE'); ?>
                            (<span><?= $arItem['PROPERTY']['COUNT_RAISE']['VALUE'] ?></span>)</p>
                    </div>
                    <?php } ?>

                    <div class="d-flex flex-column controls-rise-item">

                        <?php
                        if ($arItem['PROPERTY']['VIP_DATE']['VALUE'] && strtotime($arItem['PROPERTY']['VIP_DATE']['VALUE']) > time()) {
                        ?>
                            <div class="d-flex justify-content-center align-items-center item">
                                <svg width="22" height="19" viewBox="0 0 22 19" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1.58936 3.42876L5.88549 6.18822L10.1673 0.413067C10.2619 0.285313 10.3868 0.181179 10.5317 0.109331C10.6765 0.0374835 10.837 0 10.9999 0C11.1628 0 11.3234 0.0374835 11.4682 0.109331C11.613 0.181179 11.7379 0.285313 11.8326 0.413067L16.1144 6.18822L20.4105 3.42876C20.5731 3.32454 20.7633 3.26734 20.9585 3.26392C21.1538 3.2605 21.346 3.31101 21.5124 3.40947C21.6788 3.50793 21.8125 3.65023 21.8976 3.81956C21.9828 3.98888 22.0159 4.17815 21.9929 4.36501L20.3123 18.1298C20.283 18.3695 20.1634 18.5905 19.9762 18.7509C19.7889 18.9113 19.5471 19 19.2966 19H2.70328C2.45274 19 2.21093 18.9113 2.0237 18.7509C1.83648 18.5905 1.71687 18.3695 1.68755 18.1298L0.00694712 4.36402C-0.015761 4.17725 0.0174677 3.98811 0.102711 3.81895C0.187954 3.64978 0.321652 3.50764 0.488023 3.40931C0.654394 3.31098 0.846492 3.26056 1.04164 3.26401C1.23679 3.26745 1.42684 3.32462 1.58936 3.42876ZM10.9999 13.0869C11.5425 13.0869 12.0629 12.8792 12.4465 12.5096C12.8302 12.1399 13.0457 11.6386 13.0457 11.1158C13.0457 10.5931 12.8302 10.0917 12.4465 9.72209C12.0629 9.35245 11.5425 9.14479 10.9999 9.14479C10.4574 9.14479 9.93701 9.35245 9.55335 9.72209C9.16969 10.0917 8.95416 10.5931 8.95416 11.1158C8.95416 11.6386 9.16969 12.1399 9.55335 12.5096C9.93701 12.8792 10.4574 13.0869 10.9999 13.0869Z"
                                          fill="#F50000"/>
                                </svg>
                            </div>
                            <?php
                        }
                        if ($arItem['PROPERTY']['COLOR_DATE']['VALUE'] && strtotime($arItem['PROPERTY']['COLOR_DATE']['VALUE']) > time()) {
                        ?>
                            <div class="d-flex justify-content-center align-items-center item">
                                <svg width="16" height="17" viewBox="0 0 16 17" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M8.20189 0.934761C8.20189 0.779763 8.14032 0.631114 8.03072 0.521514C7.92112 0.411914 7.77247 0.350342 7.61747 0.350342C7.46247 0.350342 7.31382 0.411914 7.20422 0.521514C7.09462 0.631114 7.03305 0.779763 7.03305 0.934761V1.90879C6.78643 1.99564 6.56248 2.13677 6.37772 2.32178L1.01743 7.68285C0.854624 7.84566 0.725478 8.03894 0.637367 8.25165C0.549256 8.46437 0.503906 8.69236 0.503906 8.9226C0.503906 9.15284 0.549256 9.38083 0.637367 9.59355C0.725478 9.80626 0.854624 9.99954 1.01743 10.1623L4.82005 13.9634C4.98286 14.1262 5.17613 14.2554 5.38885 14.3435C5.60157 14.4316 5.82956 14.4769 6.0598 14.4769C6.29004 14.4769 6.51803 14.4316 6.73075 14.3435C6.94346 14.2554 7.13674 14.1262 7.29955 13.9634L12.6598 8.60312C12.8226 8.44031 12.9518 8.24703 13.0399 8.03432C13.128 7.8216 13.1734 7.59361 13.1734 7.36337C13.1734 7.13313 13.128 6.90514 13.0399 6.69242C12.9518 6.47971 12.8226 6.28643 12.6598 6.12362L8.85644 2.32178C8.67191 2.13687 8.44823 1.99574 8.20189 1.90879V0.934761ZM7.03305 3.31919V4.44127C7.03305 4.59627 7.09462 4.74492 7.20422 4.85452C7.31382 4.96412 7.46247 5.02569 7.61747 5.02569C7.77247 5.02569 7.92112 4.96412 8.03072 4.85452C8.14032 4.74492 8.20189 4.59627 8.20189 4.44127V3.31919L11.8323 6.95038C11.9417 7.05996 12.0032 7.2085 12.0032 7.36337C12.0032 7.51824 11.9417 7.66678 11.8323 7.77636L11.0765 8.53221H1.82159L1.84419 8.50883L7.03305 3.31919Z"
                                          fill="#6633F5"/>
                                    <path d="M14.063 9.78046C14.0049 9.67162 13.9183 9.5806 13.8125 9.51714C13.7067 9.45369 13.5856 9.42017 13.4622 9.42017C13.3388 9.42017 13.2177 9.45369 13.1119 9.51714C13.0061 9.5806 12.9195 9.67162 12.8614 9.78046L11.2967 12.715C10.4232 14.3498 11.6092 16.3244 13.4622 16.3244C15.3152 16.3244 16.4996 14.3498 15.6284 12.715L14.063 9.78046Z"
                                          fill="#6633F5"/>
                                </svg>
                            </div>
                            <?php
                        }
                        if ($arItem['PROPERTY']['LENTA_DATE']['VALUE'] && strtotime($arItem['PROPERTY']['LENTA_DATE']['VALUE']) > time()) {
                        ?>
                            <div class="d-flex justify-content-center align-items-center item">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <rect width="9.40476" height="6.83184" rx="0.5"
                                          transform="matrix(0.977206 -0.212292 0.118541 0.992949 0.503906 9.04102)"
                                          fill="#FB2BFF"/>
                                    <rect width="10.4788" height="6.83184" rx="0.5"
                                          transform="matrix(0.977206 -0.212292 0.118541 0.992949 4.87109 3.15161)"
                                          fill="#FB2BFF"/>
                                    <path d="M5.58984 9.95654L9.93666 9.01223L10.4706 13.4847L5.58984 9.95654Z"
                                          fill="#961299"/>
                                </svg>
                            </div>
                            <?php
                        }
                        if ($arItem['PROPERTY']['PAKET_DATE']['VALUE'] && strtotime($arItem['PROPERTY']['PAKET_DATE']['VALUE']) > time()) {
                        ?>
                            <div class="d-flex justify-content-center align-items-center item">
                                <svg width="16" height="18" viewBox="0 0 16 18" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M10.7811 0.968714C10.7811 0.792056 10.7264 0.619732 10.6246 0.475353C10.5228 0.330975 10.3789 0.221608 10.2125 0.16224C10.0461 0.102871 9.86545 0.0964054 9.69525 0.143729C9.52505 0.191053 9.37365 0.289851 9.26179 0.426584L0.697334 9.84749C0.594729 9.97297 0.529841 10.125 0.510211 10.2859C0.49058 10.4468 0.517013 10.61 0.586437 10.7564C0.655861 10.9029 0.765426 11.0267 0.902399 11.1133C1.03937 11.2 1.19813 11.246 1.36022 11.2461H5.64245V16.3847C5.64248 16.5614 5.69714 16.7337 5.79894 16.8781C5.90074 17.0225 6.04469 17.1318 6.21107 17.1912C6.37746 17.2506 6.55813 17.257 6.72833 17.2097C6.89853 17.1624 7.04993 17.0636 7.16179 16.9269L15.7262 7.50596C15.8288 7.38048 15.8937 7.22845 15.9134 7.06755C15.933 6.90666 15.9066 6.74349 15.8371 6.59702C15.7677 6.45054 15.6582 6.32678 15.5212 6.24011C15.3842 6.15343 15.2254 6.10741 15.0634 6.10739H10.7811V0.968714Z"
                                          fill="#FF6B00"/>
                                </svg>
                            </div>
                            <?php
                        }
                        ?>

                    </div>
                </div>
                <?php } ?>
                <?php foreach ($ar7un['ITEMS'] as $arItem) { ?>
                <div class="mb-4 card product-card product-line user-product">
                    <div class="card-link" href="<?= $arItem['DETAIL_PAGE_URL'] ?>">
                        <div onclick="window.location.href='<?= $arItem['DETAIL_PAGE_URL'] ?>'" style="cursor: pointer" class="image-block">
                            <div class="i-box">
                                <img src="<?= CFile::GetPath($arItem["PREVIEW_PICTURE"]); ?>" alt="no-img">
                            </div>
                        </div>

                        <div class="px-2 px-lg-3 content-block">
                            <div class="d-flex flex-column h-100 justify-content-between text-right">
                                <div class="mb-3 mb-lg-5 d-flex flex-column-reverse flex-lg-row justify-content-between align-items-end">
                                    <p class="price"><?= ICON_CURRENCY; ?> <?= number_format($arItem['PROPERTY']['PRICE']['VALUE'], 0, '.', ' '); ?></p>
                                    <a href="<?= $arItem['DETAIL_PAGE_URL'] ?>"
                                       class="title"><?= $arItem['NAME'] ?></a>
                                </div>

                                <div class="mb-4 d-flex flex-column flex-lg-row">
                                    <div class="edit-user-item">
                                        <button
                                                id="text-uppercase<?= $arItem['ID'] ?>"
                                                class="mr-lg-4 mb-3 mb-lg-0 btn user-product__btn-edit text-uppercase">
                                            <?= Loc::getMessage('UP_EDIT'); ?>
                                        </button>
                                        <script>
                                            $('#text-uppercase<?= $arItem['ID'] ?>').on('click', (e) => {
                                                e.preventDefault()
                                                $('#edit-item-menu_item<?= $arItem['ID'] ?>').toggleClass('active')
                                            })
                                        </script>
                                        <ul id="edit-item-menu_item<?= $arItem['ID'] ?>"
                                            class="flex-column edit-item-menu_item">
                                            <li class="border-bottom">
                                                <div class="custom-control custom-switch activateItem">
                                                    <input type="checkbox" class="custom-control-input"
                                                           id="activateItem<?= $arItem['ID'] ?>">
                                                    <label id="activateItemText<?= $arItem['ID'] ?>"
                                                           data-iblock-id="<?= $arItem['IBLOCK_ID'] ?>"
                                                           data-item-id="<?= $arItem['ID'] ?>"
                                                           class="custom-control-label"
                                                           for="activateItem<?= $arItem['ID'] ?>"><?= Loc::getMessage('DELETE_UN'); ?></label>
                                                </div>
                                            </li>
                                            <script>
                                                $('#activateItemText<?= $arItem['ID'] ?>').click(function () {

                                                    var attе = '';
                                                    if ($('#activateItem<?= $arItem['ID'] ?>').is(':checked')) {
                                                        var tte = 'green';
                                                    } else {
                                                        var tte = 'red';
                                                    }

                                                    $.ajax({
                                                        url: '/ajax/active_item.php',
                                                        method: 'post',
                                                        async: false,
                                                        data: {data: $(this).data(), value: tte},
                                                        success: function (data) {
                                                            $('.allert__text').html(data);

                                                            $('.del_all_in_chat').html('ok');
                                                            $('.alert-confirmation').addClass('show');
                                                        }
                                                    });

                                                })
                                            </script>


                                            <li class="border-bottom">
                                                <a class="mr-3"
                                                   href="/add/moto/?ID=<?= $arItem['ID'] ?>&EDIT=Y"><?= Loc::getMessage('UP_EDIT'); ?></a>

                                                <span class="mr-2"><svg width="16" height="16"
                                                                        viewBox="0 0 16 16" fill="none"
                                                                        xmlns="http://www.w3.org/2000/svg">
<path d="M15.4042 3.28224L12.6642 0.542241C12.3066 0.206336 11.838 0.0135995 11.3475 0.000692758C10.8571 -0.012214 10.379 0.15561 10.0042 0.472241L1.0042 9.47224C0.680969 9.79821 0.479707 10.2254 0.434203 10.6822L0.00420295 14.8522C-0.00926809 14.9987 0.00973728 15.1463 0.0598642 15.2846C0.109991 15.4229 0.190005 15.5484 0.294203 15.6522C0.387643 15.7449 0.498459 15.8182 0.620297 15.868C0.742134 15.9178 0.872596 15.943 1.0042 15.9422H1.0942L5.2642 15.5622C5.721 15.5167 6.14824 15.3155 6.4742 14.9922L15.4742 5.99224C15.8235 5.62321 16.0123 5.13075 15.9992 4.62278C15.9861 4.1148 15.7721 3.63275 15.4042 3.28224ZM12.0042 6.62224L9.3242 3.94224L11.2742 1.94224L14.0042 4.67224L12.0042 6.62224Z"
      fill="#3FC5FF"/>
</svg>
</span>
                                            </li>

                                            <li class="px-3">
                                                <button id="alertConfirmation<?= $arItem['ID'] ?>"
                                                        type="button"
                                                        class="btn p-0 text-secondary">
                                                    <span class="mr-2"><?= Loc::getMessage('DELETE'); ?></span>

                                                    <i class="mr-2 icon-clear"></i>
                                                </button>
                                            </li>
                                        </ul>

                                        <div id="alert-confirmationIdView<?= $arItem['ID'] ?>"
                                             class="allert alert-confirmation flex-column card">
                                            <button type="button" class="close" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>

                                            <div class="d-flex justify-content-center allert__text">
                                                <?= Loc::getMessage('CT_BNL_ELEMENT_DELETE_CONFIRM'); ?></div>


                                            <div class="d-flex justify-content-center mt-4">
                                                <button data-item="<?= $arItem['ID'] ?>"
                                                        id="delItemId<?= $arItem['ID'] ?>"
                                                        class="btn border-primary text-uppercase font-weight-bold text-primary py-3 px-5">
                                                    <?= Loc::getMessage('DELETE'); ?></button>

                                            </div>
                                        </div>
                                    </div>
                                    <script>
                                        $('#alertConfirmation<?=$arItem['ID']?>').on('click', function () {
                                            $('#alert-confirmationIdView<?=$arItem['ID']?>').addClass('show');
                                        })
                                        $('#delItemId<?=$arItem['ID']?>').click(function () {
                                            $.ajax({
                                                url: '/ajax/del_item.php',
                                                method: 'post',
                                                async: false,
                                                data: $(this).data(),
                                                success: function (data) {
                                                }
                                            });
                                            window.location.reload();
                                        })
                                    </script>

                                    <?php $APPLICATION->IncludeComponent(
                                        "webco:buttons",
                                        "boost",
                                        array(
                                            'ITEM_ID' => $arItem['ID'],
                                            'IBLOCK_ID' => $arItem['IBLOCK_ID']
                                        )
                                    ); ?>
                                </div>
                            </div>

                            <div class="border-top py-3 d-flex justify-content-between align-items-center text-nowrap product-line__data-viwe">
                                <div class="d-flex">
                                            <span class="mr-0 mr-lg-2 views"><span><?= $arItem['SHOW_COUNTER'] ?></span> <i
                                                        class="icon-visibility"></i></span>

                                    <div class="d-none d-lg-flex justify-content-end align-items-center ml-5 product-line__up-date">
                                        <div class="mr-2 d-flex justify-content-center align-items-center user-product__up-product">
                                                        <span data-id="<?= $arItem['ID'] ?>"
                                                              class="text-uppercase font-weight-bold upRise">UP</span>
                                        </div>
                                        <?php $strDate = getStringDate($arItem['PROPERTY']['TIME_RAISE']['VALUE']); ?>
                                        <span class="up-date"><?= ($strDate['MES']) ? GetMessage($strDate['MES']) . ', ' . $strDate['HOURS'] : $strDate['HOURS']; ?></span>
                                    </div>
                                </div>
                                <?php $strDate2 = getStringDate($arItem['DATE_CREATE']); ?>
                                <span class="date"><?= ($strDate2['MES']) ? GetMessage($strDate2['MES']) . ', ' . $strDate2['HOURS'] : $strDate2['HOURS']; ?></span>
                            </div>
                        </div>
                    </div>
                    <?php if ($arItem['PROPERTY']['COUNT_RAISE']['VALUE'] != '' && $arItem['PROPERTY']['COUNT_RAISE']['VALUE'] > 0) { ?>
                    <div type="button"
                         data-id="<?= $arItem['ID'] ?>" data-iblock-id="<?= $arItem['IBLOCK_ID'] ?>"
                         class="b-none d-lg-flex justify-content-center align-items-center rise-btn">
                                        <span data-id="<?= $arItem['ID'] ?>"
                                              class="mr-1 text-uppercase font-weight-bold up">UP</span>

                        <p class="m-0"><?= Loc::getMessage('UP_RISE'); ?>
                            (<span><?= $arItem['PROPERTY']['COUNT_RAISE']['VALUE'] ?></span>)</p>
                    </div>
                    <?php } ?>

                    <div class="d-flex flex-column controls-rise-item">

                        <?php
                        if ($arItem['PROPERTY']['VIP_DATE']['VALUE'] && strtotime($arItem['PROPERTY']['VIP_DATE']['VALUE']) > time()) {
                        ?>
                            <div class="d-flex justify-content-center align-items-center item">
                                <svg width="22" height="19" viewBox="0 0 22 19" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1.58936 3.42876L5.88549 6.18822L10.1673 0.413067C10.2619 0.285313 10.3868 0.181179 10.5317 0.109331C10.6765 0.0374835 10.837 0 10.9999 0C11.1628 0 11.3234 0.0374835 11.4682 0.109331C11.613 0.181179 11.7379 0.285313 11.8326 0.413067L16.1144 6.18822L20.4105 3.42876C20.5731 3.32454 20.7633 3.26734 20.9585 3.26392C21.1538 3.2605 21.346 3.31101 21.5124 3.40947C21.6788 3.50793 21.8125 3.65023 21.8976 3.81956C21.9828 3.98888 22.0159 4.17815 21.9929 4.36501L20.3123 18.1298C20.283 18.3695 20.1634 18.5905 19.9762 18.7509C19.7889 18.9113 19.5471 19 19.2966 19H2.70328C2.45274 19 2.21093 18.9113 2.0237 18.7509C1.83648 18.5905 1.71687 18.3695 1.68755 18.1298L0.00694712 4.36402C-0.015761 4.17725 0.0174677 3.98811 0.102711 3.81895C0.187954 3.64978 0.321652 3.50764 0.488023 3.40931C0.654394 3.31098 0.846492 3.26056 1.04164 3.26401C1.23679 3.26745 1.42684 3.32462 1.58936 3.42876ZM10.9999 13.0869C11.5425 13.0869 12.0629 12.8792 12.4465 12.5096C12.8302 12.1399 13.0457 11.6386 13.0457 11.1158C13.0457 10.5931 12.8302 10.0917 12.4465 9.72209C12.0629 9.35245 11.5425 9.14479 10.9999 9.14479C10.4574 9.14479 9.93701 9.35245 9.55335 9.72209C9.16969 10.0917 8.95416 10.5931 8.95416 11.1158C8.95416 11.6386 9.16969 12.1399 9.55335 12.5096C9.93701 12.8792 10.4574 13.0869 10.9999 13.0869Z"
                                          fill="#F50000"/>
                                </svg>
                            </div>
                            <?php
                        }
                        if ($arItem['PROPERTY']['COLOR_DATE']['VALUE'] && strtotime($arItem['PROPERTY']['COLOR_DATE']['VALUE']) > time()) {
                        ?>
                            <div class="d-flex justify-content-center align-items-center item">
                                <svg width="16" height="17" viewBox="0 0 16 17" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M8.20189 0.934761C8.20189 0.779763 8.14032 0.631114 8.03072 0.521514C7.92112 0.411914 7.77247 0.350342 7.61747 0.350342C7.46247 0.350342 7.31382 0.411914 7.20422 0.521514C7.09462 0.631114 7.03305 0.779763 7.03305 0.934761V1.90879C6.78643 1.99564 6.56248 2.13677 6.37772 2.32178L1.01743 7.68285C0.854624 7.84566 0.725478 8.03894 0.637367 8.25165C0.549256 8.46437 0.503906 8.69236 0.503906 8.9226C0.503906 9.15284 0.549256 9.38083 0.637367 9.59355C0.725478 9.80626 0.854624 9.99954 1.01743 10.1623L4.82005 13.9634C4.98286 14.1262 5.17613 14.2554 5.38885 14.3435C5.60157 14.4316 5.82956 14.4769 6.0598 14.4769C6.29004 14.4769 6.51803 14.4316 6.73075 14.3435C6.94346 14.2554 7.13674 14.1262 7.29955 13.9634L12.6598 8.60312C12.8226 8.44031 12.9518 8.24703 13.0399 8.03432C13.128 7.8216 13.1734 7.59361 13.1734 7.36337C13.1734 7.13313 13.128 6.90514 13.0399 6.69242C12.9518 6.47971 12.8226 6.28643 12.6598 6.12362L8.85644 2.32178C8.67191 2.13687 8.44823 1.99574 8.20189 1.90879V0.934761ZM7.03305 3.31919V4.44127C7.03305 4.59627 7.09462 4.74492 7.20422 4.85452C7.31382 4.96412 7.46247 5.02569 7.61747 5.02569C7.77247 5.02569 7.92112 4.96412 8.03072 4.85452C8.14032 4.74492 8.20189 4.59627 8.20189 4.44127V3.31919L11.8323 6.95038C11.9417 7.05996 12.0032 7.2085 12.0032 7.36337C12.0032 7.51824 11.9417 7.66678 11.8323 7.77636L11.0765 8.53221H1.82159L1.84419 8.50883L7.03305 3.31919Z"
                                          fill="#6633F5"/>
                                    <path d="M14.063 9.78046C14.0049 9.67162 13.9183 9.5806 13.8125 9.51714C13.7067 9.45369 13.5856 9.42017 13.4622 9.42017C13.3388 9.42017 13.2177 9.45369 13.1119 9.51714C13.0061 9.5806 12.9195 9.67162 12.8614 9.78046L11.2967 12.715C10.4232 14.3498 11.6092 16.3244 13.4622 16.3244C15.3152 16.3244 16.4996 14.3498 15.6284 12.715L14.063 9.78046Z"
                                          fill="#6633F5"/>
                                </svg>
                            </div>
                            <?php
                        }
                        if ($arItem['PROPERTY']['LENTA_DATE']['VALUE'] && strtotime($arItem['PROPERTY']['LENTA_DATE']['VALUE']) > time()) {
                        ?>
                            <div class="d-flex justify-content-center align-items-center item">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <rect width="9.40476" height="6.83184" rx="0.5"
                                          transform="matrix(0.977206 -0.212292 0.118541 0.992949 0.503906 9.04102)"
                                          fill="#FB2BFF"/>
                                    <rect width="10.4788" height="6.83184" rx="0.5"
                                          transform="matrix(0.977206 -0.212292 0.118541 0.992949 4.87109 3.15161)"
                                          fill="#FB2BFF"/>
                                    <path d="M5.58984 9.95654L9.93666 9.01223L10.4706 13.4847L5.58984 9.95654Z"
                                          fill="#961299"/>
                                </svg>
                            </div>
                            <?php
                        }
                        if ($arItem['PROPERTY']['PAKET_DATE']['VALUE'] && strtotime($arItem['PROPERTY']['PAKET_DATE']['VALUE']) > time()) {
                        ?>
                            <div class="d-flex justify-content-center align-items-center item">
                                <svg width="16" height="18" viewBox="0 0 16 18" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M10.7811 0.968714C10.7811 0.792056 10.7264 0.619732 10.6246 0.475353C10.5228 0.330975 10.3789 0.221608 10.2125 0.16224C10.0461 0.102871 9.86545 0.0964054 9.69525 0.143729C9.52505 0.191053 9.37365 0.289851 9.26179 0.426584L0.697334 9.84749C0.594729 9.97297 0.529841 10.125 0.510211 10.2859C0.49058 10.4468 0.517013 10.61 0.586437 10.7564C0.655861 10.9029 0.765426 11.0267 0.902399 11.1133C1.03937 11.2 1.19813 11.246 1.36022 11.2461H5.64245V16.3847C5.64248 16.5614 5.69714 16.7337 5.79894 16.8781C5.90074 17.0225 6.04469 17.1318 6.21107 17.1912C6.37746 17.2506 6.55813 17.257 6.72833 17.2097C6.89853 17.1624 7.04993 17.0636 7.16179 16.9269L15.7262 7.50596C15.8288 7.38048 15.8937 7.22845 15.9134 7.06755C15.933 6.90666 15.9066 6.74349 15.8371 6.59702C15.7677 6.45054 15.6582 6.32678 15.5212 6.24011C15.3842 6.15343 15.2254 6.10741 15.0634 6.10739H10.7811V0.968714Z"
                                          fill="#FF6B00"/>
                                </svg>
                            </div>
                            <?php
                        }
                        ?>

                    </div>
                </div>
                <?php } ?>
                <?php foreach ($ar8un['ITEMS'] as $arItem) { ?>
                <div class="mb-4 card product-card product-line user-product">
                    <div class="card-link" href="<?= $arItem['DETAIL_PAGE_URL'] ?>">
                        <div onclick="window.location.href='<?= $arItem['DETAIL_PAGE_URL'] ?>'" style="cursor: pointer" class="image-block">
                            <div class="i-box">
                                <img src="<?= CFile::GetPath($arItem["PREVIEW_PICTURE"]); ?>" alt="no-img">
                            </div>
                        </div>

                        <div class="px-2 px-lg-3 content-block">
                            <div class="d-flex flex-column h-100 justify-content-between text-right">
                                <div class="mb-3 mb-lg-5 d-flex flex-column-reverse flex-lg-row justify-content-between align-items-end">
                                    <p class="price"><?= ICON_CURRENCY; ?> <?= number_format($arItem['PROPERTY']['PRICE']['VALUE'], 0, '.', ' '); ?></p>
                                    <a href="<?= $arItem['DETAIL_PAGE_URL'] ?>"
                                       class="title"><?= $arItem['NAME'] ?></a>
                                </div>

                                <div class="mb-4 d-flex flex-column flex-lg-row">
                                    <div class="edit-user-item">
                                        <button
                                                id="text-uppercase<?= $arItem['ID'] ?>"
                                                class="mr-lg-4 mb-3 mb-lg-0 btn user-product__btn-edit text-uppercase">
                                            <?= Loc::getMessage('UP_EDIT'); ?>
                                        </button>
                                        <script>
                                            $('#text-uppercase<?= $arItem['ID'] ?>').on('click', (e) => {
                                                e.preventDefault()
                                                $('#edit-item-menu_item<?= $arItem['ID'] ?>').toggleClass('active')
                                            })
                                        </script>
                                        <ul id="edit-item-menu_item<?= $arItem['ID'] ?>"
                                            class="flex-column edit-item-menu_item">
                                            <li class="border-bottom">
                                                <div class="custom-control custom-switch activateItem">
                                                    <input type="checkbox" class="custom-control-input"
                                                           id="activateItem<?= $arItem['ID'] ?>">
                                                    <label id="activateItemText<?= $arItem['ID'] ?>"
                                                           data-iblock-id="<?= $arItem['IBLOCK_ID'] ?>"
                                                           data-item-id="<?= $arItem['ID'] ?>"
                                                           class="custom-control-label"
                                                           for="activateItem<?= $arItem['ID'] ?>"><?= Loc::getMessage('DELETE_UN'); ?></label>
                                                </div>
                                            </li>
                                            <script>
                                                $('#activateItemText<?= $arItem['ID'] ?>').click(function () {

                                                    var attе = '';
                                                    if ($('#activateItem<?= $arItem['ID'] ?>').is(':checked')) {
                                                        var tte = 'green';
                                                    } else {
                                                        var tte = 'red';
                                                    }

                                                    $.ajax({
                                                        url: '/ajax/active_item.php',
                                                        method: 'post',
                                                        async: false,
                                                        data: {data: $(this).data(), value: tte},
                                                        success: function (data) {
                                                            $('.allert__text').html(data);

                                                            $('.del_all_in_chat').html('ok');
                                                            $('.alert-confirmation').addClass('show');
                                                        }
                                                    });

                                                })
                                            </script>


                                            <li class="border-bottom">
                                                <a class="mr-3"
                                                   href="/add/scooter/?ID=<?= $arItem['ID'] ?>&EDIT=Y"><?= Loc::getMessage('UP_EDIT'); ?></a>

                                                <span class="mr-2"><svg width="16" height="16"
                                                                        viewBox="0 0 16 16" fill="none"
                                                                        xmlns="http://www.w3.org/2000/svg">
<path d="M15.4042 3.28224L12.6642 0.542241C12.3066 0.206336 11.838 0.0135995 11.3475 0.000692758C10.8571 -0.012214 10.379 0.15561 10.0042 0.472241L1.0042 9.47224C0.680969 9.79821 0.479707 10.2254 0.434203 10.6822L0.00420295 14.8522C-0.00926809 14.9987 0.00973728 15.1463 0.0598642 15.2846C0.109991 15.4229 0.190005 15.5484 0.294203 15.6522C0.387643 15.7449 0.498459 15.8182 0.620297 15.868C0.742134 15.9178 0.872596 15.943 1.0042 15.9422H1.0942L5.2642 15.5622C5.721 15.5167 6.14824 15.3155 6.4742 14.9922L15.4742 5.99224C15.8235 5.62321 16.0123 5.13075 15.9992 4.62278C15.9861 4.1148 15.7721 3.63275 15.4042 3.28224ZM12.0042 6.62224L9.3242 3.94224L11.2742 1.94224L14.0042 4.67224L12.0042 6.62224Z"
      fill="#3FC5FF"/>
</svg>
</span>
                                            </li>

                                            <li class="px-3">
                                                <button id="alertConfirmation<?= $arItem['ID'] ?>"
                                                        type="button"
                                                        class="btn p-0 text-secondary">
                                                    <span class="mr-2"><?= Loc::getMessage('DELETE'); ?></span>

                                                    <i class="mr-2 icon-clear"></i>
                                                </button>
                                            </li>
                                        </ul>

                                        <div id="alert-confirmationIdView<?= $arItem['ID'] ?>"
                                             class="allert alert-confirmation flex-column card">
                                            <button type="button" class="close" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>

                                            <div class="d-flex justify-content-center allert__text">
                                                <?= Loc::getMessage('CT_BNL_ELEMENT_DELETE_CONFIRM'); ?></div>


                                            <div class="d-flex justify-content-center mt-4">
                                                <button data-item="<?= $arItem['ID'] ?>"
                                                        id="delItemId<?= $arItem['ID'] ?>"
                                                        class="btn border-primary text-uppercase font-weight-bold text-primary py-3 px-5">
                                                    <?= Loc::getMessage('DELETE'); ?></button>

                                            </div>
                                        </div>
                                    </div>
                                    <script>
                                        $('#alertConfirmation<?=$arItem['ID']?>').on('click', function () {
                                            $('#alert-confirmationIdView<?=$arItem['ID']?>').addClass('show');
                                        })
                                        $('#delItemId<?=$arItem['ID']?>').click(function () {
                                            $.ajax({
                                                url: '/ajax/del_item.php',
                                                method: 'post',
                                                async: false,
                                                data: $(this).data(),
                                                success: function (data) {
                                                }
                                            });
                                            window.location.reload();
                                        })
                                    </script>

                                    <?php $APPLICATION->IncludeComponent(
                                        "webco:buttons",
                                        "boost",
                                        array(
                                            'ITEM_ID' => $arItem['ID'],
                                            'IBLOCK_ID' => $arItem['IBLOCK_ID']
                                        )
                                    ); ?>
                                </div>
                            </div>

                            <div class="border-top py-3 d-flex justify-content-between align-items-center text-nowrap product-line__data-viwe">
                                <div class="d-flex">
                                            <span class="mr-0 mr-lg-2 views"><span><?= $arItem['SHOW_COUNTER'] ?></span> <i
                                                        class="icon-visibility"></i></span>

                                    <div class="d-none d-lg-flex justify-content-end align-items-center ml-5 product-line__up-date">
                                        <div class="mr-2 d-flex justify-content-center align-items-center user-product__up-product">
                                                        <span data-id="<?= $arItem['ID'] ?>"
                                                              class="text-uppercase font-weight-bold upRise">UP</span>
                                        </div>
                                        <?php $strDate = getStringDate($arItem['PROPERTY']['TIME_RAISE']['VALUE']); ?>
                                        <span class="up-date"><?= ($strDate['MES']) ? GetMessage($strDate['MES']) . ', ' . $strDate['HOURS'] : $strDate['HOURS']; ?></span>
                                    </div>
                                </div>
                                <?php $strDate2 = getStringDate($arItem['DATE_CREATE']); ?>
                                <span class="date"><?= ($strDate2['MES']) ? GetMessage($strDate2['MES']) . ', ' . $strDate2['HOURS'] : $strDate2['HOURS']; ?></span>
                            </div>
                        </div>
                    </div>
                    <?php if ($arItem['PROPERTY']['COUNT_RAISE']['VALUE'] != '' && $arItem['PROPERTY']['COUNT_RAISE']['VALUE'] > 0) { ?>
                    <div type="button"
                         data-id="<?= $arItem['ID'] ?>" data-iblock-id="<?= $arItem['IBLOCK_ID'] ?>"
                         class="b-none d-lg-flex justify-content-center align-items-center rise-btn">
                                        <span data-id="<?= $arItem['ID'] ?>"
                                              class="mr-1 text-uppercase font-weight-bold up">UP</span>

                        <p class="m-0"><?= Loc::getMessage('UP_RISE'); ?>
                            (<span><?= $arItem['PROPERTY']['COUNT_RAISE']['VALUE'] ?></span>)</p>
                    </div>
                    <?php } ?>

                    <div class="d-flex flex-column controls-rise-item">

                        <?php
                        if ($arItem['PROPERTY']['VIP_DATE']['VALUE'] && strtotime($arItem['PROPERTY']['VIP_DATE']['VALUE']) > time()) {
                        ?>
                            <div class="d-flex justify-content-center align-items-center item">
                                <svg width="22" height="19" viewBox="0 0 22 19" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1.58936 3.42876L5.88549 6.18822L10.1673 0.413067C10.2619 0.285313 10.3868 0.181179 10.5317 0.109331C10.6765 0.0374835 10.837 0 10.9999 0C11.1628 0 11.3234 0.0374835 11.4682 0.109331C11.613 0.181179 11.7379 0.285313 11.8326 0.413067L16.1144 6.18822L20.4105 3.42876C20.5731 3.32454 20.7633 3.26734 20.9585 3.26392C21.1538 3.2605 21.346 3.31101 21.5124 3.40947C21.6788 3.50793 21.8125 3.65023 21.8976 3.81956C21.9828 3.98888 22.0159 4.17815 21.9929 4.36501L20.3123 18.1298C20.283 18.3695 20.1634 18.5905 19.9762 18.7509C19.7889 18.9113 19.5471 19 19.2966 19H2.70328C2.45274 19 2.21093 18.9113 2.0237 18.7509C1.83648 18.5905 1.71687 18.3695 1.68755 18.1298L0.00694712 4.36402C-0.015761 4.17725 0.0174677 3.98811 0.102711 3.81895C0.187954 3.64978 0.321652 3.50764 0.488023 3.40931C0.654394 3.31098 0.846492 3.26056 1.04164 3.26401C1.23679 3.26745 1.42684 3.32462 1.58936 3.42876ZM10.9999 13.0869C11.5425 13.0869 12.0629 12.8792 12.4465 12.5096C12.8302 12.1399 13.0457 11.6386 13.0457 11.1158C13.0457 10.5931 12.8302 10.0917 12.4465 9.72209C12.0629 9.35245 11.5425 9.14479 10.9999 9.14479C10.4574 9.14479 9.93701 9.35245 9.55335 9.72209C9.16969 10.0917 8.95416 10.5931 8.95416 11.1158C8.95416 11.6386 9.16969 12.1399 9.55335 12.5096C9.93701 12.8792 10.4574 13.0869 10.9999 13.0869Z"
                                          fill="#F50000"/>
                                </svg>
                            </div>
                            <?php
                        }
                        if ($arItem['PROPERTY']['COLOR_DATE']['VALUE'] && strtotime($arItem['PROPERTY']['COLOR_DATE']['VALUE']) > time()) {
                        ?>
                            <div class="d-flex justify-content-center align-items-center item">
                                <svg width="16" height="17" viewBox="0 0 16 17" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M8.20189 0.934761C8.20189 0.779763 8.14032 0.631114 8.03072 0.521514C7.92112 0.411914 7.77247 0.350342 7.61747 0.350342C7.46247 0.350342 7.31382 0.411914 7.20422 0.521514C7.09462 0.631114 7.03305 0.779763 7.03305 0.934761V1.90879C6.78643 1.99564 6.56248 2.13677 6.37772 2.32178L1.01743 7.68285C0.854624 7.84566 0.725478 8.03894 0.637367 8.25165C0.549256 8.46437 0.503906 8.69236 0.503906 8.9226C0.503906 9.15284 0.549256 9.38083 0.637367 9.59355C0.725478 9.80626 0.854624 9.99954 1.01743 10.1623L4.82005 13.9634C4.98286 14.1262 5.17613 14.2554 5.38885 14.3435C5.60157 14.4316 5.82956 14.4769 6.0598 14.4769C6.29004 14.4769 6.51803 14.4316 6.73075 14.3435C6.94346 14.2554 7.13674 14.1262 7.29955 13.9634L12.6598 8.60312C12.8226 8.44031 12.9518 8.24703 13.0399 8.03432C13.128 7.8216 13.1734 7.59361 13.1734 7.36337C13.1734 7.13313 13.128 6.90514 13.0399 6.69242C12.9518 6.47971 12.8226 6.28643 12.6598 6.12362L8.85644 2.32178C8.67191 2.13687 8.44823 1.99574 8.20189 1.90879V0.934761ZM7.03305 3.31919V4.44127C7.03305 4.59627 7.09462 4.74492 7.20422 4.85452C7.31382 4.96412 7.46247 5.02569 7.61747 5.02569C7.77247 5.02569 7.92112 4.96412 8.03072 4.85452C8.14032 4.74492 8.20189 4.59627 8.20189 4.44127V3.31919L11.8323 6.95038C11.9417 7.05996 12.0032 7.2085 12.0032 7.36337C12.0032 7.51824 11.9417 7.66678 11.8323 7.77636L11.0765 8.53221H1.82159L1.84419 8.50883L7.03305 3.31919Z"
                                          fill="#6633F5"/>
                                    <path d="M14.063 9.78046C14.0049 9.67162 13.9183 9.5806 13.8125 9.51714C13.7067 9.45369 13.5856 9.42017 13.4622 9.42017C13.3388 9.42017 13.2177 9.45369 13.1119 9.51714C13.0061 9.5806 12.9195 9.67162 12.8614 9.78046L11.2967 12.715C10.4232 14.3498 11.6092 16.3244 13.4622 16.3244C15.3152 16.3244 16.4996 14.3498 15.6284 12.715L14.063 9.78046Z"
                                          fill="#6633F5"/>
                                </svg>
                            </div>
                            <?php
                        }
                        if ($arItem['PROPERTY']['LENTA_DATE']['VALUE'] && strtotime($arItem['PROPERTY']['LENTA_DATE']['VALUE']) > time()) {
                        ?>
                            <div class="d-flex justify-content-center align-items-center item">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <rect width="9.40476" height="6.83184" rx="0.5"
                                          transform="matrix(0.977206 -0.212292 0.118541 0.992949 0.503906 9.04102)"
                                          fill="#FB2BFF"/>
                                    <rect width="10.4788" height="6.83184" rx="0.5"
                                          transform="matrix(0.977206 -0.212292 0.118541 0.992949 4.87109 3.15161)"
                                          fill="#FB2BFF"/>
                                    <path d="M5.58984 9.95654L9.93666 9.01223L10.4706 13.4847L5.58984 9.95654Z"
                                          fill="#961299"/>
                                </svg>
                            </div>
                            <?php
                        }
                        if ($arItem['PROPERTY']['PAKET_DATE']['VALUE'] && strtotime($arItem['PROPERTY']['PAKET_DATE']['VALUE']) > time()) {
                        ?>
                            <div class="d-flex justify-content-center align-items-center item">
                                <svg width="16" height="18" viewBox="0 0 16 18" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M10.7811 0.968714C10.7811 0.792056 10.7264 0.619732 10.6246 0.475353C10.5228 0.330975 10.3789 0.221608 10.2125 0.16224C10.0461 0.102871 9.86545 0.0964054 9.69525 0.143729C9.52505 0.191053 9.37365 0.289851 9.26179 0.426584L0.697334 9.84749C0.594729 9.97297 0.529841 10.125 0.510211 10.2859C0.49058 10.4468 0.517013 10.61 0.586437 10.7564C0.655861 10.9029 0.765426 11.0267 0.902399 11.1133C1.03937 11.2 1.19813 11.246 1.36022 11.2461H5.64245V16.3847C5.64248 16.5614 5.69714 16.7337 5.79894 16.8781C5.90074 17.0225 6.04469 17.1318 6.21107 17.1912C6.37746 17.2506 6.55813 17.257 6.72833 17.2097C6.89853 17.1624 7.04993 17.0636 7.16179 16.9269L15.7262 7.50596C15.8288 7.38048 15.8937 7.22845 15.9134 7.06755C15.933 6.90666 15.9066 6.74349 15.8371 6.59702C15.7677 6.45054 15.6582 6.32678 15.5212 6.24011C15.3842 6.15343 15.2254 6.10741 15.0634 6.10739H10.7811V0.968714Z"
                                          fill="#FF6B00"/>
                                </svg>
                            </div>
                            <?php
                        }
                        ?>

                    </div>
                </div>
                <?php } ?>
            </div>
            <!-- user product END-->
            <?php } ?>
        </div>

        <?php include $_SERVER['DOCUMENT_ROOT'] . '/personal/left.php' ?>
    </div>
</div>
    <div class="modal fade" id="payTcoins" tabindex="-1" aria-labelledby="payTcoins" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content pt-3 pb-5 px-5">
                <div class="p-0 mb-4 border-bottom-0 modal-header justify-content-end">
                    <h2 class="subtitle" id="exampleModalLabel">Оплата</h2>
                </div>

                <div class="p-0 modal-body text-right">
                    <p class="mb-4 text-uppercase font-weight-bold">MY BALANCE: <span id="payTcoinsBalance"
                                                                                      class="text-primary"> </span>
                        TCOIN</p>
                    <p class="mb-0 text-uppercase font-weight-bold">К списанию: <span id="payTcoinsNeedle"
                                                                                      class="text-primary">2.5 </span>
                        TCOIN</p>

                    <hr>

                    <p id="payTcoinsAtEnd" class="mb-3 text-uppercase font-weight-bold text-secondary">Остаток: <span>20 TCOIN</span>
                    </p>
                </div>

                <div class="p-0 border-top-0 modal-footer">
                    <button type="button" class="btn" data-dismiss="modal">Close</button>
                    <button id="buyItemFew" type="submit" class="btn btn-primary">Оплатить</button>
                </div>
            </div>
        </div>
    </div>
<div class="modal fade" id="payShek" tabindex="-1" aria-labelledby="payShek" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content pt-3 pb-5 px-5">
            <div class="p-0 mb-4 border-bottom-0 modal-header justify-content-end">
                <h2 class="subtitle" id="exampleModalLabel">Оплата</h2>
            </div>

            <div class="p-0 modal-body text-right">
                <p class="mb-4 text-uppercase font-weight-bold">MY BALANCE: <span id="paySkekBalance"
                                                                                  class="text-primary"> </span> <?= ICON_CURRENCY ?>
                </p>
                <p class="mb-0 text-uppercase font-weight-bold">К списанию: <span id="payShekNeedle"
                                                                                  class="text-primary">2.5 </span> <?= ICON_CURRENCY ?>
                </p>

                <hr>

                <p id="payShekAtEnd" class="mb-3 text-uppercase font-weight-bold text-secondary">Остаток:
                    <span>20 <?= ICON_CURRENCY ?></span></p>
            </div>

            <div class="p-0 border-top-0 modal-footer">
                <button type="button" class="btn" data-dismiss="modal">Close</button>
                <button id="buyItemFewShek" type="submit" class="btn btn-primary">Оплатить</button>
            </div>
        </div>
    </div>
</div>

    <script>
        addEventListener('DOMContentLoaded', () => {
            const activeAdsTab = document.querySelector('div#tabs .form_radio_btn input#trueAnnouncement');
            const notActiveAdsTab = document.querySelector('div#tabs .form_radio_btn input#falseAnnouncement');

            if (notActiveAdsTab && activeAdsTab) {
                notActiveAdsTab.parentNode.onclick = () => {
                    const itemsTabId = notActiveAdsTab.value;
                    const itemsTab = document.querySelector('div#'+itemsTabId);
                    if (itemsTab) {
                        if (itemsTab.classList.contains('d-none')) itemsTab.classList.remove('d-none');
                    }

                    const itemsTabId2 = activeAdsTab.value;
                    const itemsTab2 = document.querySelector('div#'+itemsTabId2);
                    if (itemsTab2) {
                        if (!itemsTab2.classList.contains('d-none')) itemsTab2.classList.add('d-none');
                    }
                }

                activeAdsTab.parentNode.onclick = () => {
                    const itemsTabId = activeAdsTab.value;
                    const itemsTab = document.querySelector('div#'+itemsTabId);
                    if (itemsTab) {
                        if (itemsTab.classList.contains('d-none')) itemsTab.classList.remove('d-none');
                    }

                    const itemsTabId2 = notActiveAdsTab.value;
                    const itemsTab2 = document.querySelector('div#'+itemsTabId2);
                    if (itemsTab2) {
                        if (!itemsTab2.classList.contains('d-none')) itemsTab2.classList.add('d-none');
                    }
                }
            }
        });
    </script>
    <div class="allert alert-confirmation flex-column card">
        <button onclick="window.location.reload()" type="button" class="close" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <div class="d-flex justify-content-center allert__text"></div>
        <div class="d-flex justify-content-center mt-4">
            <button onclick="window.location.reload()"
                    class="btn_confirm btn border-primary text-uppercase font-weight-bold text-primary py-3 px-5">
                <?=Loc::getMessage('OK_BTN')?>
            </button>
        </div>
    </div>
<?php require ($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>