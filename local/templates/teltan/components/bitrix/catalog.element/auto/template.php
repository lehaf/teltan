<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */

/** @var CBitrixComponent $component */

use Bitrix\Main\Localization\Loc;
use Bitrix\Highloadblock\HighloadBlockTable as HLBT;

if ($arResult['PREVIEW_PICTURE']['SRC']) {
    array_unshift($arResult['PHOTOS'], ['ORIG' => $arResult['PREVIEW_PICTURE']['SRC']]);
}
Loc::loadMessages(__FILE__);
$this->setFrameMode(true);

$entity_data_class = GetEntityDataClass(21);
$rsData = $entity_data_class::getList(array(
    'select' => array('*')
));
while ($arTypesRise[] = $rsData->fetch()) {

}
$entity_data_class = GetEntityDataClass(22);
$rsData = $entity_data_class::getList(array(
    'select' => array('*')
));
while ($arTypesVip[] = $rsData->fetch()) {

}
$entity_data_class = GetEntityDataClass(23);
$rsData = $entity_data_class::getList(array(
    'select' => array('*')
));
while ($arTypesColour[] = $rsData->fetch()) {

}
$entity_data_class = GetEntityDataClass(24);
$rsData = $entity_data_class::getList(array(
    'select' => array('*')
));
while ($arTypesLent[] = $rsData->fetch()) {

}
$entity_data_class = GetEntityDataClass(25);
$rsData = $entity_data_class::getList(array(
    'select' => array('*')
));
while ($arTypesPaket[] = $rsData->fetch()) {

}

$editUrl = '#';
switch ($arResult['IBLOCK_ID']) {
    case 1:
        $editUrl = '/add/fm/?ID=' . $arResult['ID'] . '&EDIT=Y';
        break;
    case 2:
        $editUrl = '/add/buy/?ID=' . $arResult['ID'] . '&EDIT=Y';
        $editUrl = '/add/rent/?ID=' . $arResult['ID'] . '&EDIT=Y';
        break;
    case 3:
        $editUrl = '/add/auto/?ID=' . $arResult['ID'] . '&EDIT=Y';
        break;
    case 7:
        $editUrl = '/add/moto/?ID=' . $arResult['ID'] . '&EDIT=Y';
        break;
    case 8:
        $editUrl = '/add/scooter/?ID=' . $arResult['ID'] . '&EDIT=Y';

        break;
}
global $arSetting;
if ($_GET['TEST'] == 'Y') { ?>
    <pre>
    <?= var_dump($arParams['USER_ID']) ?>
</pre>
<? } ?>
<div class="container">
    <div class="row flex-column-reverse flex-lg-row mb-4">
        <div class="col-12 col-lg-4 flex-column">
            <div class="d-lg-block">

                <? if (!$arParams['USER_ID']) { ?>
                    <div class="mb-4 card connection-with-seller text-right">
                        <h1 class="mb-4 connection-with-seller__title"><?= $arResult['NAME']; ?></h1>

                        <p class="mb-4 connection-with-seller__price text-primary">
                            <?= number_format($arResult['PROPERTIES']['PRICE']['VALUE'], 0, '.', ' '); ?> <?= ICON_CURRENCY; ?>
                        </p>
                        <? if (!empty($arResult['PROPERTIES']['UF_REGION']['~VALUE'])) { ?>
                            <p class="pb-3 border-bottom">
                                <span class="mr-1"><?= $arResult['PROPERTIES']['UF_CITY']['VALUE']; ?> <?= (!empty($arResult['PROPERTIES']['UF_CITY']['VALUE'])) ? ',' : '' ?> <?= $arResult['PROPERTIES']['UF_REGION']['VALUE']; ?></span>
                                <svg class="icon-local"
                                     style="position: relative; width: 16px; top: -2px; fill: #747474" version="1.1"
                                     id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                     xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                     viewBox="0 0 513.597 513.597" xml:space="preserve">
                                      <g>
                                          <path d="M263.278,0.107C158.977-3.408,73.323,80.095,73.323,183.602c0,117.469,112.73,202.72,175.915,325.322
                                        c3.208,6.225,12.169,6.233,15.388,0.009c57.16-110.317,154.854-184.291,172.959-290.569
                                        C456.331,108.387,374.776,3.866,263.278,0.107z M256.923,279.773c-53.113,0-96.171-43.059-96.171-96.171
                                        s43.059-96.171,96.171-96.171c53.113,0,96.172,43.059,96.172,96.171S310.036,279.773,256.923,279.773z"></path>
                                      </g>
                                    </svg>
                            </p>
                        <? } ?>

                        <div class="mb-4 row no-gutters">
                            <button class="mr-2 col btn btn-show-phone text-uppercase font-weight-bold"
                                    disabled><?= Loc::getMessage('SHOW_PHONE'); ?>
                            </button>
                            <button class="ml-2 col btn btn-primary text-uppercase font-weight-bold"
                                    disabled><?= Loc::getMessage('SEND_MESSAGE'); ?>
                            </button>
                        </div>

                        <p class="text-unaurh-user"><?= Loc::getMessage('VIEW_REGISTER_MESS'); ?></p>

                        <div class="row">
                            <div class="col">
                                <ul class="nav justify-content-end font-weight-bold">
                                    <li class="mr-4 justify-content-center">
                                        <a class="" href="#" data-toggle="modal" data-target="#registerModal">
                                            <span class="mr-2"><?= Loc::getMessage('REGISTER'); ?></span>
                                            <i class="icon-user-1"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="" href="#" data-toggle="modal" data-target="#logInModal">
                                            <span class="mr-2"><?= Loc::getMessage('Sign_In'); ?></span>
                                            <i class="icon-log-in"></i>
                                        </a>
                                    </li>
                                </ul>
                                <? include $_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH . "/includes/footer/register_modal.php"; ?>
                                <? include $_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH . "/includes/footer/auth_modal.php"; ?>
                            </div>
                        </div>
                    </div>

                <? } elseif ($arParams['USER_ID'] == $arResult['PROPERTIES']['ID_USER']['VALUE']) { ?>

                    <div class="mb-4 card connection-with-seller text-right">
                        <h1 class="mb-4 connection-with-seller__title"><?= $arResult['NAME']; ?></h1>

                        <p class="mb-4 connection-with-seller__price text-primary">
                            <?= number_format($arResult['PROPERTIES']['PRICE']['VALUE'], 0, '.', ' '); ?> <?= ICON_CURRENCY; ?>
                        </p>

                        <? if (!empty($arResult['PROPERTIES']['UF_REGION']['~VALUE'])) { ?>
                            <p class="pb-3 border-bottom">
                                <span class="mr-1"><?= $arResult['PROPERTIES']['UF_CITY']['VALUE']; ?> <?= (!empty($arResult['PROPERTIES']['UF_CITY']['VALUE'])) ? ',' : '' ?> <?= $arResult['PROPERTIES']['UF_REGION']['VALUE']; ?></span>
                                <svg class="icon-local"
                                     style="position: relative; width: 16px; top: -2px; fill: #747474" version="1.1"
                                     id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                     xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                     viewBox="0 0 513.597 513.597" xml:space="preserve">
                                      <g>
                                          <path d="M263.278,0.107C158.977-3.408,73.323,80.095,73.323,183.602c0,117.469,112.73,202.72,175.915,325.322
                                        c3.208,6.225,12.169,6.233,15.388,0.009c57.16-110.317,154.854-184.291,172.959-290.569
                                        C456.331,108.387,374.776,3.866,263.278,0.107z M256.923,279.773c-53.113,0-96.171-43.059-96.171-96.171
                                        s43.059-96.171,96.171-96.171c53.113,0,96.172,43.059,96.172,96.171S310.036,279.773,256.923,279.773z"></path>
                                      </g>
                                    </svg>
                            </p>
                        <? } ?>


                        <div class="flex-column">
                            <button onclick="window.location.href='<?= $editUrl ?>'"
                                    class="mb-3 w-100 btn btn-primary text-uppercase font-weight-bold"><a
                                        href="<?= $editUrl ?>"><?= Loc::getMessage('EDIT'); ?></a></button>
                            <button class="w-100 btn btn-accelerate-sale text-uppercase font-weight-bold btn-accelerate-sale"><span><svg
                                            width="31" height="18" viewBox="0 0 31 18" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                    <path d="M29.4417 3.27725H14.2853L14.06 0.734453C14.0231 0.318623 13.6792 0 13.2671 0H11.6496C11.2099 0 10.8535 0.361101 10.8535 0.806543C10.8535 1.25198 11.2099 1.61309 11.6496 1.61309H12.5393C13.0254 7.10073 11.7689 -7.08279 13.4549 11.9479C13.5199 12.6928 13.9171 13.5011 14.6014 14.0503C13.3676 15.6466 14.495 18 16.502 18C18.1678 18 19.3427 16.3168 18.7715 14.7226H23.1286C22.558 16.3147 23.7304 18 25.398 18C26.7289 18 27.8116 16.9031 27.8116 15.5548C27.8116 14.2064 26.7289 13.1095 25.398 13.1095H16.5074C15.9026 13.1095 15.3757 12.7399 15.1482 12.2013L27.8708 11.4438C28.2181 11.4231 28.512 11.1763 28.5964 10.8343L30.214 4.2794C30.3394 3.77113 29.9597 3.27725 29.4417 3.27725ZM16.502 16.3869C16.0491 16.3869 15.6806 16.0136 15.6806 15.5548C15.6806 15.0959 16.0491 14.7226 16.502 14.7226C16.9549 14.7226 17.3234 15.0959 17.3234 15.5548C17.3234 16.0136 16.9549 16.3869 16.502 16.3869ZM25.398 16.3869C24.9451 16.3869 24.5766 16.0136 24.5766 15.5548C24.5766 15.0959 24.9451 14.7226 25.398 14.7226C25.8509 14.7226 26.2194 15.0959 26.2194 15.5548C26.2194 16.0136 25.8509 16.3869 25.398 16.3869ZM27.1936 9.86828L14.9339 10.5982L14.4282 4.8903H28.4221L27.1936 9.86828Z"
                                          fill="white"/>
                                    <path d="M10.509 8.05168C10.6904 8.02447 10.8535 8.16495 10.8535 8.34836V10.6516C10.8535 10.8351 10.6904 10.9755 10.509 10.9483L2.83139 9.79668C2.49072 9.74558 2.49072 9.25442 2.83139 9.20332L10.509 8.05168Z"
                                          fill="white"/>
                                    <path d="M10.5111 5.04892C10.6918 5.0231 10.8535 5.16334 10.8535 5.3459V6.6541C10.8535 6.83666 10.6918 6.9769 10.5111 6.95108L5.93241 6.29698C5.58898 6.24792 5.58898 5.75208 5.93241 5.70302L10.5111 5.04892Z"
                                          fill="white"/>
                                    <path d="M10.5111 12.0489C10.6918 12.0231 10.8535 12.1633 10.8535 12.3459V13.6541C10.8535 13.8367 10.6918 13.9769 10.5111 13.9511L5.93241 13.297C5.58898 13.2479 5.58898 12.7521 5.93241 12.703L10.5111 12.0489Z"
                                          fill="white"/>
                                    </svg>
                                    </span> <?= Loc::getMessage('SPEED_SALE'); ?>
                            </button>
                            <div class="accardion-wrap"
                                 id="accordionUserItemWrap<?= $arResult['ID'] ?>">

                                <div class="accordion user-promote-menu"
                                     id="accordionUserItem<?= $arResult['ID'] ?>">
                                    <!-- RISE -->
                                    <div class="promote-card">
                                        <!-- ID "headingRiseItem" shold be UNIC for every product card -->
                                        <div class="card-header" id="headingRiseItem">
                                            <button class="btn btn-link btn-block text-right collapsed"
                                                    type="button" data-toggle="collapse"
                                                    data-target="#riseItem<?= $arResult['ID'] ?>"
                                                    aria-expanded="false"
                                                    aria-controls="riseItem">
                                                <div class="pr-4 d-flex justify-content-between align-items-center">
                                                    <span class="plus"></span>
                                                    <span class="card-header__title"><?= Loc::getMessage('RISE_PAKET'); ?></span>

                                                </div>
                                            </button>
                                            <span class="text-uppercase font-weight-bold up card-header__icon">UP</span>
                                        </div>

                                        <!-- data-parent depend on "accordionUserItem<?= $arResult['ID'] ?>" -->
                                        <!-- aria-labelledby depend on "headingRiseItem" -->
                                        <div id="riseItem<?= $arResult['ID'] ?>" class="collapse"
                                             aria-labelledby="headingRiseItem"
                                             data-parent="#accordionUserItem<?= $arResult['ID'] ?>">
                                            <div class="p-3 bg-lightgray">
                                                <? $APPLICATION->IncludeComponent(
                                                    "bitrix:main.include",
                                                    "",
                                                    array(
                                                        "AREA_FILE_SHOW" => "file",
                                                        "AREA_FILE_SUFFIX" => "inc",
                                                        "EDIT_TEMPLATE" => "",
                                                        "PATH" => "/include-area/up-rise-" . LANGUAGE_ID . ".php"
                                                    )
                                                ); ?>

                                                <p class="mb-3 font-weight-bold content-subtitle">
                                                    <?= Loc::getMessage('type_item') ?></p>
                                                <form id="formProdactRise1">
                                                    <div class="mb-4 px-3 card">
                                                        <? foreach ($arTypesRise as $arRise) { ?>
                                                            <? if ($arRise['UF_COUNT'] > 0) { ?>
                                                                <div class="py-3 border-bottom d-flex justify-content-between">
                                                                    <span class="font-weight-bold"><?= $arRise["UF_PRICE"] ?> T</span>


                                                                    <label class="custom-radio-btn">
                                                                        <input type="radio"
                                                                               value="<?= $arRise["UF_COUNT"] ?>"
                                                                               data-price="<?= $arRise["UF_PRICE"] ?>"
                                                                               data-price-shek="<?= $arRise["UF_PRICE_SHEK"] ?>"
                                                                               name="riseProduct">
                                                                        <span><?= $arRise["UF_NAME"] ?></span>
                                                                        <span class="checkbox"></span>
                                                                    </label>
                                                                </div>
                                                            <? }
                                                        } ?>
                                                    </div>

                                                    <p class="mb-3 font-weight-bold content-subtitle">
                                                        <?= Loc::getMessage('PAY_CHOISE'); ?>
                                                        :</p>

                                                    <div class="d-flex flex-column justify-content-end align-items-end">
                                                        <button type="button"
                                                                onclick="countRiseBuy(<?= $arResult['ID'] ?>, $('#formProdactRise1'), <?= $arResult['IBLOCK_ID'] ?>)"
                                                                data-toggle="modal" data-target="#payTcoins"
                                                                class="mb-3 btn btn-primary btn-paid"><span
                                                                    class="mr-2"><svg width="17" height="17"
                                                                                      viewBox="0 0 17 17" fill="none"
                                                                                      xmlns="http://www.w3.org/2000/svg"><path
                                                                            d="M11.8169 0.00066338C8.95442 0.00066338 6.63389 1.28034 6.63389 2.8612C6.63389 4.44205 8.95508 5.72239 11.8169 5.72239C14.6795 5.72239 17 4.44205 17 2.8612C17 1.28034 14.6788 0 11.8169 0V0.00066338ZM17 3.711C16.9987 5.29185 14.6795 6.57219 11.8169 6.57219C8.96238 6.57219 6.64716 5.30578 6.63389 3.73223V4.85136C6.63389 5.52669 7.06642 6.14497 7.77492 6.63455C8.49138 6.82959 9.12956 7.10025 9.66093 7.44256C10.3197 7.60973 11.0441 7.71189 11.8169 7.71189C14.6795 7.71189 17 6.43222 17 4.85136V3.711ZM17 5.70116C17 7.28202 14.6795 8.56236 11.8169 8.56236C11.4687 8.56236 11.1303 8.53649 10.8013 8.5C11.0609 8.84969 11.2381 9.25361 11.3194 9.6815C11.4846 9.69078 11.6478 9.70206 11.8169 9.70206C14.6795 9.70206 17 8.42238 17 6.84153V5.70116ZM5.18306 7.29728C2.32053 7.29728 0 8.57762 0 10.1585C0 11.7393 2.3212 13.0197 5.18306 13.0197C8.04558 13.0197 10.3661 11.7393 10.3661 10.1585C10.3661 8.57762 8.04492 7.29728 5.18306 7.29728ZM17 7.69133C16.9987 9.27219 14.6795 10.5525 11.8169 10.5525C11.6504 10.5525 11.4819 10.5406 11.3194 10.5313C11.3121 10.5811 11.3081 10.6474 11.2988 10.6971C11.332 10.7973 11.3605 10.8962 11.3605 11.0089V11.6723C11.5111 11.6796 11.6624 11.6922 11.8169 11.6922C14.6795 11.6922 17 10.4125 17 8.83169V7.69133ZM17 9.6815C16.9987 11.2624 14.6795 12.5427 11.8169 12.5427C11.6504 12.5427 11.4819 12.5308 11.3194 12.5215C11.3121 12.5712 11.3081 12.6376 11.2988 12.6873C11.332 12.7868 11.3605 12.8863 11.3605 12.9991V13.6625C11.5111 13.6698 11.6624 13.6824 11.8169 13.6824C14.6795 13.6824 17 12.4027 17 10.8219V9.6815ZM10.3661 11.0083C10.3648 12.5891 8.04558 13.8695 5.18306 13.8695C2.32849 13.8695 0.0132678 12.6031 0 11.0288V12.1486C0 13.7295 2.31987 15.0098 5.18306 15.0098C8.04624 15.0098 10.3661 13.7295 10.3661 12.1486V11.0083ZM10.3661 12.9984C10.3648 14.5793 8.04558 15.8596 5.18306 15.8596C2.32849 15.8596 0.0132678 14.5932 0 13.019V14.1388C0 15.7197 2.31987 17 5.18306 17C8.04624 17 10.3661 15.7197 10.3661 14.1388V12.9984Z"
                                                                            fill="white"/></svg>
                                                                                    </span>
                                                            <?= Loc::getMessage('PAY_T_COINS'); ?>

                                                        </button>
                                                        <button type="button"
                                                                onclick="countRiseBuy(<?= $arResult['ID'] ?>, $('#formProdactRise<?= $arResult['ID'] ?>'), <?= $arResult['IBLOCK_ID'] ?>)"


                                                                class="btn btn-primary btn-paid"><span
                                                                    class="mr-2"><svg width="17"
                                                                                      height="14"
                                                                                      viewBox="0 0 17 14"
                                                                                      fill="none"
                                                                                      xmlns="http://www.w3.org/2000/svg">
<path d="M16.3929 0H0.607143C0.271317 0 0 0.284375 0 0.636364V3.81818H17V0.636364C17 0.284375 16.7287 0 16.3929 0ZM0 13.3636C0 13.7156 0.271317 14 0.607143 14H16.3929C16.7287 14 17 13.7156 17 13.3636V5.56818H0V13.3636ZM10.9855 9.70455C10.9855 9.61705 11.0538 9.54545 11.1373 9.54545H14.2679C14.3513 9.54545 14.4196 9.61705 14.4196 9.70455V11.1364C14.4196 11.2239 14.3513 11.2955 14.2679 11.2955H11.1373C11.0538 11.2955 10.9855 11.2239 10.9855 11.1364V9.70455Z"
      fill="white"/>
</svg>
</span> <?= Loc::getMessage('PAY_CARD'); ?>

                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- VIP -->
                                    <div class="promote-card">
                                        <!-- ID "headingVipItem" shold be UNIC for every product card -->
                                        <div class="card-header" id="headingVipItem">
                                            <!-- data-target="#vipItem" depend on "accordionUserItem<?= $arResult['ID'] ?>" -->
                                            <!-- aria-controls="vipItem" depend on "headingRiseItem" -->
                                            <button class="btn btn-link btn-block text-right collapsed"
                                                    type="button" data-toggle="collapse"
                                                    data-target="#vipItem<?= $arResult['ID'] ?>" aria-expanded="false"
                                                    aria-controls="vipItem">
                                                <div class="pr-4 d-flex justify-content-between align-items-center">
                                                    <span class="plus"></span>
                                                    <span class="card-header__title"><?= Loc::getMessage('VIP_PAKET'); ?></span>

                                                </div>

                                                <span class="card-header__icon"><svg width="22"
                                                                                     height="19"
                                                                                     viewBox="0 0 22 19"
                                                                                     fill="none"
                                                                                     xmlns="http://www.w3.org/2000/svg">
<path d="M1.58936 3.42876L5.88549 6.18822L10.1673 0.413067C10.2619 0.285313 10.3868 0.181179 10.5317 0.109331C10.6765 0.0374835 10.837 0 10.9999 0C11.1628 0 11.3234 0.0374835 11.4682 0.109331C11.613 0.181179 11.7379 0.285313 11.8326 0.413067L16.1144 6.18822L20.4105 3.42876C20.5731 3.32454 20.7633 3.26734 20.9585 3.26392C21.1538 3.2605 21.346 3.31101 21.5124 3.40947C21.6788 3.50793 21.8125 3.65023 21.8976 3.81956C21.9828 3.98888 22.0159 4.17815 21.9929 4.36501L20.3123 18.1298C20.283 18.3695 20.1634 18.5905 19.9762 18.7509C19.7889 18.9113 19.5471 19 19.2966 19H2.70328C2.45274 19 2.21093 18.9113 2.0237 18.7509C1.83648 18.5905 1.71687 18.3695 1.68755 18.1298L0.00694712 4.36402C-0.015761 4.17725 0.0174677 3.98811 0.102711 3.81895C0.187954 3.64978 0.321652 3.50764 0.488023 3.40931C0.654394 3.31098 0.846492 3.26056 1.04164 3.26401C1.23679 3.26745 1.42684 3.32462 1.58936 3.42876ZM10.9999 13.0869C11.5425 13.0869 12.0629 12.8792 12.4465 12.5096C12.8302 12.1399 13.0457 11.6386 13.0457 11.1158C13.0457 10.5931 12.8302 10.0917 12.4465 9.72209C12.0629 9.35245 11.5425 9.14479 10.9999 9.14479C10.4574 9.14479 9.93701 9.35245 9.55335 9.72209C9.16969 10.0917 8.95416 10.5931 8.95416 11.1158C8.95416 11.6386 9.16969 12.1399 9.55335 12.5096C9.93701 12.8792 10.4574 13.0869 10.9999 13.0869Z"
      fill="#F50000"/>
</svg>
</span>
                                            </button>
                                        </div>

                                        <!-- ID "vipItem" shold be UNIC for every product card -->
                                        <!-- aria-labelledby="headingVipItem" data-parent="#accordionUserItem<?= $arResult['ID'] ?>" -->
                                        <div id="vipItem<?= $arResult['ID'] ?>" class="collapse"
                                             aria-labelledby="headingVipItem"
                                             data-parent="#accordionUserItem<?= $arResult['ID'] ?>">
                                            <div class="p-3 bg-lightgray">
                                                <? $APPLICATION->IncludeComponent(
                                                    "bitrix:main.include",
                                                    "",
                                                    array(
                                                        "AREA_FILE_SHOW" => "file",
                                                        "AREA_FILE_SUFFIX" => "inc",
                                                        "EDIT_TEMPLATE" => "",
                                                        "PATH" => "/include-area/up-vip-" . LANGUAGE_ID . ".php"
                                                    )
                                                ); ?>

                                                <p class="mb-3 font-weight-bold content-subtitle">
                                                    <?= Loc::getMessage('type_item') ?></p>
                                                <form id="formProdactVip1">
                                                    <div class="mb-4 px-3 card">
                                                        <? foreach ($arTypesVip as $arRise) { ?>
                                                            <? if ($arRise['UF_COUNT'] > 0) { ?>
                                                                <div class="py-3 border-bottom d-flex justify-content-between">
                                                                    <span class="font-weight-bold"><?= $arRise["UF_PRICE"] ?> T</span>


                                                                    <label class="custom-radio-btn">
                                                                        <input type="radio"
                                                                               value="<?= $arRise["UF_COUNT"] ?>"
                                                                               data-price="<?= $arRise["UF_PRICE"] ?>"
                                                                               data-price-shek="<?= $arRise["UF_PRICE_SHEK"] ?>"
                                                                               name="riseProduct">
                                                                        <span><?= $arRise["UF_NAME"] ?></span>
                                                                        <span class="checkbox"></span>
                                                                    </label>
                                                                </div>
                                                            <? }
                                                        } ?>
                                                    </div>
                                                </form>

                                                <p class="mb-3 font-weight-bold content-subtitle">
                                                    <?= Loc::getMessage('PAY_CHOISE'); ?>
                                                    :</p>

                                                <div class="d-flex flex-column justify-content-end align-items-end">
                                                    <button type="button"
                                                            onclick="countVipBuy(<?= $arResult['ID'] ?>, $('#formProdactVip1'), <?= $arResult['IBLOCK_ID'] ?>)"
                                                            data-toggle="modal" data-target="#payTcoins"
                                                            class="mb-3 btn btn-primary btn-paid"><span
                                                                class="mr-2"><svg width="17" height="17"
                                                                                  viewBox="0 0 17 17" fill="none"
                                                                                  xmlns="http://www.w3.org/2000/svg"><path
                                                                        d="M11.8169 0.00066338C8.95442 0.00066338 6.63389 1.28034 6.63389 2.8612C6.63389 4.44205 8.95508 5.72239 11.8169 5.72239C14.6795 5.72239 17 4.44205 17 2.8612C17 1.28034 14.6788 0 11.8169 0V0.00066338ZM17 3.711C16.9987 5.29185 14.6795 6.57219 11.8169 6.57219C8.96238 6.57219 6.64716 5.30578 6.63389 3.73223V4.85136C6.63389 5.52669 7.06642 6.14497 7.77492 6.63455C8.49138 6.82959 9.12956 7.10025 9.66093 7.44256C10.3197 7.60973 11.0441 7.71189 11.8169 7.71189C14.6795 7.71189 17 6.43222 17 4.85136V3.711ZM17 5.70116C17 7.28202 14.6795 8.56236 11.8169 8.56236C11.4687 8.56236 11.1303 8.53649 10.8013 8.5C11.0609 8.84969 11.2381 9.25361 11.3194 9.6815C11.4846 9.69078 11.6478 9.70206 11.8169 9.70206C14.6795 9.70206 17 8.42238 17 6.84153V5.70116ZM5.18306 7.29728C2.32053 7.29728 0 8.57762 0 10.1585C0 11.7393 2.3212 13.0197 5.18306 13.0197C8.04558 13.0197 10.3661 11.7393 10.3661 10.1585C10.3661 8.57762 8.04492 7.29728 5.18306 7.29728ZM17 7.69133C16.9987 9.27219 14.6795 10.5525 11.8169 10.5525C11.6504 10.5525 11.4819 10.5406 11.3194 10.5313C11.3121 10.5811 11.3081 10.6474 11.2988 10.6971C11.332 10.7973 11.3605 10.8962 11.3605 11.0089V11.6723C11.5111 11.6796 11.6624 11.6922 11.8169 11.6922C14.6795 11.6922 17 10.4125 17 8.83169V7.69133ZM17 9.6815C16.9987 11.2624 14.6795 12.5427 11.8169 12.5427C11.6504 12.5427 11.4819 12.5308 11.3194 12.5215C11.3121 12.5712 11.3081 12.6376 11.2988 12.6873C11.332 12.7868 11.3605 12.8863 11.3605 12.9991V13.6625C11.5111 13.6698 11.6624 13.6824 11.8169 13.6824C14.6795 13.6824 17 12.4027 17 10.8219V9.6815ZM10.3661 11.0083C10.3648 12.5891 8.04558 13.8695 5.18306 13.8695C2.32849 13.8695 0.0132678 12.6031 0 11.0288V12.1486C0 13.7295 2.31987 15.0098 5.18306 15.0098C8.04624 15.0098 10.3661 13.7295 10.3661 12.1486V11.0083ZM10.3661 12.9984C10.3648 14.5793 8.04558 15.8596 5.18306 15.8596C2.32849 15.8596 0.0132678 14.5932 0 13.019V14.1388C0 15.7197 2.31987 17 5.18306 17C8.04624 17 10.3661 15.7197 10.3661 14.1388V12.9984Z"
                                                                        fill="white"/></svg>
                                                                                    </span>
                                                        <?= Loc::getMessage('PAY_T_COINS'); ?>

                                                    </button>
                                                    <button type="button"
                                                            onclick="countVipBuyShek(<?= $arResult['ID'] ?>, $('#formProdactVip1'), <?= $arResult['IBLOCK_ID'] ?>)"

                                                            class="btn btn-primary btn-paid"><span
                                                                class="mr-2"><svg width="17"
                                                                                  height="14"
                                                                                  viewBox="0 0 17 14"
                                                                                  fill="none"
                                                                                  xmlns="http://www.w3.org/2000/svg">
<path d="M16.3929 0H0.607143C0.271317 0 0 0.284375 0 0.636364V3.81818H17V0.636364C17 0.284375 16.7287 0 16.3929 0ZM0 13.3636C0 13.7156 0.271317 14 0.607143 14H16.3929C16.7287 14 17 13.7156 17 13.3636V5.56818H0V13.3636ZM10.9855 9.70455C10.9855 9.61705 11.0538 9.54545 11.1373 9.54545H14.2679C14.3513 9.54545 14.4196 9.61705 14.4196 9.70455V11.1364C14.4196 11.2239 14.3513 11.2955 14.2679 11.2955H11.1373C11.0538 11.2955 10.9855 11.2239 10.9855 11.1364V9.70455Z"
      fill="white"/>
</svg>
</span> <?= Loc::getMessage('PAY_CARD'); ?>

                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- COLOUR -->
                                    <div class="promote-card">
                                        <!-- ID "headingSelectColorItem" shold be UNIC for every product card -->
                                        <div class="card-header" id="headingSelectColorItem">
                                            <!-- Change for every button "data-target", "aria-controls" data value "#ID under section"-->
                                            <button class="btn btn-link btn-block text-right collapsed"
                                                    type="button" data-toggle="collapse"
                                                    data-target="#selectColorItem<?= $arResult['ID'] ?>"
                                                    aria-expanded="false"
                                                    aria-controls="selectColorItem">
                                                <div class="pr-4 d-flex justify-content-between align-items-center">
                                                    <span class="plus"></span>
                                                    <span class="card-header__title"><?= Loc::getMessage('COLOUR_PAKET'); ?></span>

                                                </div>
                                                <span class="card-header__icon"><svg width="16"
                                                                                     height="17"
                                                                                     viewBox="0 0 16 17"
                                                                                     fill="none"
                                                                                     xmlns="http://www.w3.org/2000/svg">
<path d="M8.20189 0.934761C8.20189 0.779763 8.14032 0.631114 8.03072 0.521514C7.92112 0.411914 7.77247 0.350342 7.61747 0.350342C7.46247 0.350342 7.31382 0.411914 7.20422 0.521514C7.09462 0.631114 7.03305 0.779763 7.03305 0.934761V1.90879C6.78643 1.99564 6.56248 2.13677 6.37772 2.32178L1.01743 7.68285C0.854624 7.84566 0.725478 8.03894 0.637367 8.25165C0.549256 8.46437 0.503906 8.69236 0.503906 8.9226C0.503906 9.15284 0.549256 9.38083 0.637367 9.59355C0.725478 9.80626 0.854624 9.99954 1.01743 10.1623L4.82005 13.9634C4.98286 14.1262 5.17613 14.2554 5.38885 14.3435C5.60157 14.4316 5.82956 14.4769 6.0598 14.4769C6.29004 14.4769 6.51803 14.4316 6.73075 14.3435C6.94346 14.2554 7.13674 14.1262 7.29955 13.9634L12.6598 8.60312C12.8226 8.44031 12.9518 8.24703 13.0399 8.03432C13.128 7.8216 13.1734 7.59361 13.1734 7.36337C13.1734 7.13313 13.128 6.90514 13.0399 6.69242C12.9518 6.47971 12.8226 6.28643 12.6598 6.12362L8.85644 2.32178C8.67191 2.13687 8.44823 1.99574 8.20189 1.90879V0.934761ZM7.03305 3.31919V4.44127C7.03305 4.59627 7.09462 4.74492 7.20422 4.85452C7.31382 4.96412 7.46247 5.02569 7.61747 5.02569C7.77247 5.02569 7.92112 4.96412 8.03072 4.85452C8.14032 4.74492 8.20189 4.59627 8.20189 4.44127V3.31919L11.8323 6.95038C11.9417 7.05996 12.0032 7.2085 12.0032 7.36337C12.0032 7.51824 11.9417 7.66678 11.8323 7.77636L11.0765 8.53221H1.82159L1.84419 8.50883L7.03305 3.31919Z"
      fill="#6633F5"/>
<path d="M14.063 9.78046C14.0049 9.67162 13.9183 9.5806 13.8125 9.51714C13.7067 9.45369 13.5856 9.42017 13.4622 9.42017C13.3388 9.42017 13.2177 9.45369 13.1119 9.51714C13.0061 9.5806 12.9195 9.67162 12.8614 9.78046L11.2967 12.715C10.4232 14.3498 11.6092 16.3244 13.4622 16.3244C15.3152 16.3244 16.4996 14.3498 15.6284 12.715L14.063 9.78046Z"
      fill="#6633F5"/>
</svg></span>

                                            </button>
                                        </div>

                                        <!-- ID "selectColorItem" shold be UNIC for every product card -->
                                        <!-- data-parent = MAIN ID data-parent="#accordionUserItem<?= $arResult['ID'] ?>" -->
                                        <div id="selectColorItem<?= $arResult['ID'] ?>" class="collapse"
                                             aria-labelledby="headingSelectColorItem"
                                             data-parent="#accordionUserItem<?= $arResult['ID'] ?>">
                                            <div class="p-3 bg-lightgray">
                                                <? $APPLICATION->IncludeComponent(
                                                    "bitrix:main.include",
                                                    "",
                                                    array(
                                                        "AREA_FILE_SHOW" => "file",
                                                        "AREA_FILE_SUFFIX" => "inc",
                                                        "EDIT_TEMPLATE" => "",
                                                        "PATH" => "/include-area/up-colour-" . LANGUAGE_ID . ".php"
                                                    )
                                                ); ?>

                                                <p class="mb-3 font-weight-bold content-subtitle">
                                                    <?= Loc::getMessage('type_item') ?></p>
                                                <form id="formProdactColour1">
                                                    <div class="mb-4 px-3 card">
                                                        <? foreach ($arTypesColour as $arRise) { ?>
                                                            <? if ($arRise['UF_COUNT'] > 0) { ?>
                                                                <div class="py-3 border-bottom d-flex justify-content-between">
                                                                    <span class="font-weight-bold"><?= $arRise["UF_PRICE"] ?> T</span>


                                                                    <label class="custom-radio-btn">
                                                                        <input type="radio"
                                                                               value="<?= $arRise["UF_COUNT"] ?>"
                                                                               data-price="<?= $arRise["UF_PRICE"] ?>"
                                                                               data-price-shek="<?= $arRise["UF_PRICE_SHEK"] ?>"
                                                                               name="riseProduct">
                                                                        <span><?= $arRise["UF_NAME"] ?></span>
                                                                        <span class="checkbox"></span>
                                                                    </label>
                                                                </div>
                                                            <? }
                                                        } ?></div>
                                                </form>

                                                <p class="mb-3 font-weight-bold content-subtitle">
                                                    <?= Loc::getMessage('PAY_CHOISE'); ?>
                                                    :</p>

                                                <div class="d-flex flex-column justify-content-end align-items-end">
                                                    <button type="button"
                                                            onclick="countColourBuy(<?= $arResult['ID'] ?>, $('#formProdactColour1'), <?= $arResult['IBLOCK_ID'] ?>)"
                                                            data-toggle="modal" data-target="#payTcoins"
                                                            class="mb-3 btn btn-primary btn-paid"><span
                                                                class="mr-2"><svg width="17" height="17"
                                                                                  viewBox="0 0 17 17" fill="none"
                                                                                  xmlns="http://www.w3.org/2000/svg"><path
                                                                        d="M11.8169 0.00066338C8.95442 0.00066338 6.63389 1.28034 6.63389 2.8612C6.63389 4.44205 8.95508 5.72239 11.8169 5.72239C14.6795 5.72239 17 4.44205 17 2.8612C17 1.28034 14.6788 0 11.8169 0V0.00066338ZM17 3.711C16.9987 5.29185 14.6795 6.57219 11.8169 6.57219C8.96238 6.57219 6.64716 5.30578 6.63389 3.73223V4.85136C6.63389 5.52669 7.06642 6.14497 7.77492 6.63455C8.49138 6.82959 9.12956 7.10025 9.66093 7.44256C10.3197 7.60973 11.0441 7.71189 11.8169 7.71189C14.6795 7.71189 17 6.43222 17 4.85136V3.711ZM17 5.70116C17 7.28202 14.6795 8.56236 11.8169 8.56236C11.4687 8.56236 11.1303 8.53649 10.8013 8.5C11.0609 8.84969 11.2381 9.25361 11.3194 9.6815C11.4846 9.69078 11.6478 9.70206 11.8169 9.70206C14.6795 9.70206 17 8.42238 17 6.84153V5.70116ZM5.18306 7.29728C2.32053 7.29728 0 8.57762 0 10.1585C0 11.7393 2.3212 13.0197 5.18306 13.0197C8.04558 13.0197 10.3661 11.7393 10.3661 10.1585C10.3661 8.57762 8.04492 7.29728 5.18306 7.29728ZM17 7.69133C16.9987 9.27219 14.6795 10.5525 11.8169 10.5525C11.6504 10.5525 11.4819 10.5406 11.3194 10.5313C11.3121 10.5811 11.3081 10.6474 11.2988 10.6971C11.332 10.7973 11.3605 10.8962 11.3605 11.0089V11.6723C11.5111 11.6796 11.6624 11.6922 11.8169 11.6922C14.6795 11.6922 17 10.4125 17 8.83169V7.69133ZM17 9.6815C16.9987 11.2624 14.6795 12.5427 11.8169 12.5427C11.6504 12.5427 11.4819 12.5308 11.3194 12.5215C11.3121 12.5712 11.3081 12.6376 11.2988 12.6873C11.332 12.7868 11.3605 12.8863 11.3605 12.9991V13.6625C11.5111 13.6698 11.6624 13.6824 11.8169 13.6824C14.6795 13.6824 17 12.4027 17 10.8219V9.6815ZM10.3661 11.0083C10.3648 12.5891 8.04558 13.8695 5.18306 13.8695C2.32849 13.8695 0.0132678 12.6031 0 11.0288V12.1486C0 13.7295 2.31987 15.0098 5.18306 15.0098C8.04624 15.0098 10.3661 13.7295 10.3661 12.1486V11.0083ZM10.3661 12.9984C10.3648 14.5793 8.04558 15.8596 5.18306 15.8596C2.32849 15.8596 0.0132678 14.5932 0 13.019V14.1388C0 15.7197 2.31987 17 5.18306 17C8.04624 17 10.3661 15.7197 10.3661 14.1388V12.9984Z"
                                                                        fill="white"/></svg>
                                                                                    </span>
                                                        <?= Loc::getMessage('PAY_T_COINS'); ?>

                                                    </button>
                                                    <button type="button"
                                                            onclick="countColourBuyShek(<?= $arResult['ID'] ?>, $('#formProdactColour1'), <?= $arResult['IBLOCK_ID'] ?>)"
                                                            class="btn btn-primary btn-paid"><span
                                                                class="mr-2"><svg width="17"
                                                                                  height="14"
                                                                                  viewBox="0 0 17 14"
                                                                                  fill="none"
                                                                                  xmlns="http://www.w3.org/2000/svg">
<path d="M16.3929 0H0.607143C0.271317 0 0 0.284375 0 0.636364V3.81818H17V0.636364C17 0.284375 16.7287 0 16.3929 0ZM0 13.3636C0 13.7156 0.271317 14 0.607143 14H16.3929C16.7287 14 17 13.7156 17 13.3636V5.56818H0V13.3636ZM10.9855 9.70455C10.9855 9.61705 11.0538 9.54545 11.1373 9.54545H14.2679C14.3513 9.54545 14.4196 9.61705 14.4196 9.70455V11.1364C14.4196 11.2239 14.3513 11.2955 14.2679 11.2955H11.1373C11.0538 11.2955 10.9855 11.2239 10.9855 11.1364V9.70455Z"
      fill="white"/>
</svg>
</span> <?= Loc::getMessage('PAY_CARD'); ?>

                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="promote-card">
                                        <!-- ID "headingSelectRiddonItem" shold be UNIC for every product card -->
                                        <div class="card-header" id="headingSelectRiddonItem">
                                            <!-- data-target="#selectRiddonItem" depend on "accordionUserItem<?= $arResult['ID'] ?>" -->
                                            <!-- aria-controls="selectRiddonItem" depend on "headingRiseItem" -->
                                            <button class="btn btn-link btn-block text-right collapsed"
                                                    type="button" data-toggle="collapse"
                                                    data-target="#selectRiddonItem<?= $arResult['ID'] ?>"
                                                    aria-expanded="false"
                                                    aria-controls="selectRiddonItem">
                                                <div class="pr-4 d-flex justify-content-between align-items-center">
                                                    <span class="plus"></span>
                                                    <span class="card-header__title"><?= Loc::getMessage('LENT_PAKET'); ?></span>

                                                </div>

                                                <span class="card-header__icon"><svg width="16"
                                                                                     height="16"
                                                                                     viewBox="0 0 16 16"
                                                                                     fill="none"
                                                                                     xmlns="http://www.w3.org/2000/svg">
<rect width="9.40476" height="6.83184" rx="0.5"
      transform="matrix(0.977206 -0.212292 0.118541 0.992949 0.503906 9.04102)" fill="#FB2BFF"/>
<rect width="10.4788" height="6.83184" rx="0.5" transform="matrix(0.977206 -0.212292 0.118541 0.992949 4.87109 3.15161)"
      fill="#FB2BFF"/>
<path d="M5.58984 9.95654L9.93666 9.01223L10.4706 13.4847L5.58984 9.95654Z" fill="#961299"/>
</svg>
</span>
                                            </button>
                                        </div>

                                        <!-- ID "selectRiddonItem" shold be UNIC for every product card -->
                                        <!-- aria-labelledby="headingSelectRiddonItem" data-parent="#accordionUserItem<?= $arResult['ID'] ?>" -->
                                        <div id="selectRiddonItem<?= $arResult['ID'] ?>" class="collapse"
                                             aria-labelledby="headingSelectRiddonItem"
                                             data-parent="#accordionUserItem<?= $arResult['ID'] ?>">
                                            <div class="p-3 bg-lightgray">
                                                <? $APPLICATION->IncludeComponent(
                                                    "bitrix:main.include",
                                                    "",
                                                    array(
                                                        "AREA_FILE_SHOW" => "file",
                                                        "AREA_FILE_SUFFIX" => "inc",
                                                        "EDIT_TEMPLATE" => "",
                                                        "PATH" => "/include-area/up-lent-" . LANGUAGE_ID . ".php"
                                                    )
                                                ); ?>

                                                <p class="mb-3 font-weight-bold content-subtitle">
                                                    <?= Loc::getMessage('type_item') ?></p>
                                                <form id="formProdactLent1">
                                                    <div class="mb-4 px-3 card">
                                                        <? foreach ($arTypesLent as $arRise) { ?>
                                                            <? if ($arRise['UF_COUNT'] > 0) { ?>
                                                                <div class="py-3 border-bottom d-flex justify-content-between">
                                                                    <span class="font-weight-bold"><?= $arRise["UF_PRICE"] ?> T</span>

                                                                    <label class="custom-radio-btn">
                                                                        <input type="radio"
                                                                               value="<?= $arRise["UF_COUNT"] ?>"
                                                                               data-price="<?= $arRise["UF_PRICE"] ?>"
                                                                               data-price-shek="<?= $arRise["UF_PRICE_SHEK"] ?>"
                                                                               data-xml-id="<?= $arRise["UF_XML_ID_LENT"] ?>"
                                                                               name="riseProduct">
                                                                        <div class="d-flex marker">
                                                                            <div class="d-flex flex-column decor-rec"
                                                                                 style="border-color: #<?= $arRise["UF_COLOUR"] ?>;">
                                                                                <div class="rec-top"></div>
                                                                                <div class="rec-bottom"></div>
                                                                            </div>

                                                                            <div class="text"
                                                                                 style="background-color: #<?= $arRise["UF_COLOUR"] ?>;">
                                                                                <?= $arRise["UF_NAME"] ?>
                                                                            </div>
                                                                        </div>
                                                                        <span class="checkbox"></span>
                                                                    </label>
                                                                </div>
                                                            <? }
                                                        } ?>
                                                    </div>
                                                </form>
                                                <p class="mb-3 font-weight-bold content-subtitle">
                                                    <?= Loc::getMessage('PAY_CHOISE'); ?>
                                                    :</p>

                                                <div class="d-flex flex-column justify-content-end align-items-end">
                                                    <button type="button"
                                                            onclick="countLentaBuy(<?= $arResult['ID'] ?>, $('#formProdactLent1'), <?= $arResult['IBLOCK_ID'] ?>)"
                                                            data-toggle="modal" data-target="#payTcoins"
                                                            class="mb-3 btn btn-primary btn-paid"><span
                                                                class="mr-2"><svg width="17" height="17"
                                                                                  viewBox="0 0 17 17" fill="none"
                                                                                  xmlns="http://www.w3.org/2000/svg"><path
                                                                        d="M11.8169 0.00066338C8.95442 0.00066338 6.63389 1.28034 6.63389 2.8612C6.63389 4.44205 8.95508 5.72239 11.8169 5.72239C14.6795 5.72239 17 4.44205 17 2.8612C17 1.28034 14.6788 0 11.8169 0V0.00066338ZM17 3.711C16.9987 5.29185 14.6795 6.57219 11.8169 6.57219C8.96238 6.57219 6.64716 5.30578 6.63389 3.73223V4.85136C6.63389 5.52669 7.06642 6.14497 7.77492 6.63455C8.49138 6.82959 9.12956 7.10025 9.66093 7.44256C10.3197 7.60973 11.0441 7.71189 11.8169 7.71189C14.6795 7.71189 17 6.43222 17 4.85136V3.711ZM17 5.70116C17 7.28202 14.6795 8.56236 11.8169 8.56236C11.4687 8.56236 11.1303 8.53649 10.8013 8.5C11.0609 8.84969 11.2381 9.25361 11.3194 9.6815C11.4846 9.69078 11.6478 9.70206 11.8169 9.70206C14.6795 9.70206 17 8.42238 17 6.84153V5.70116ZM5.18306 7.29728C2.32053 7.29728 0 8.57762 0 10.1585C0 11.7393 2.3212 13.0197 5.18306 13.0197C8.04558 13.0197 10.3661 11.7393 10.3661 10.1585C10.3661 8.57762 8.04492 7.29728 5.18306 7.29728ZM17 7.69133C16.9987 9.27219 14.6795 10.5525 11.8169 10.5525C11.6504 10.5525 11.4819 10.5406 11.3194 10.5313C11.3121 10.5811 11.3081 10.6474 11.2988 10.6971C11.332 10.7973 11.3605 10.8962 11.3605 11.0089V11.6723C11.5111 11.6796 11.6624 11.6922 11.8169 11.6922C14.6795 11.6922 17 10.4125 17 8.83169V7.69133ZM17 9.6815C16.9987 11.2624 14.6795 12.5427 11.8169 12.5427C11.6504 12.5427 11.4819 12.5308 11.3194 12.5215C11.3121 12.5712 11.3081 12.6376 11.2988 12.6873C11.332 12.7868 11.3605 12.8863 11.3605 12.9991V13.6625C11.5111 13.6698 11.6624 13.6824 11.8169 13.6824C14.6795 13.6824 17 12.4027 17 10.8219V9.6815ZM10.3661 11.0083C10.3648 12.5891 8.04558 13.8695 5.18306 13.8695C2.32849 13.8695 0.0132678 12.6031 0 11.0288V12.1486C0 13.7295 2.31987 15.0098 5.18306 15.0098C8.04624 15.0098 10.3661 13.7295 10.3661 12.1486V11.0083ZM10.3661 12.9984C10.3648 14.5793 8.04558 15.8596 5.18306 15.8596C2.32849 15.8596 0.0132678 14.5932 0 13.019V14.1388C0 15.7197 2.31987 17 5.18306 17C8.04624 17 10.3661 15.7197 10.3661 14.1388V12.9984Z"
                                                                        fill="white"/></svg>
                                                                                    </span>
                                                        <?= Loc::getMessage('PAY_T_COINS'); ?>

                                                    </button>
                                                    <button type="button"
                                                            onclick="countLentaBuyShek(<?= $arResult['ID'] ?>, $('#formProdactLent1'), <?= $arResult['IBLOCK_ID'] ?>)"

                                                            class="btn btn-primary btn-paid"><span
                                                                class="mr-2"><svg width="17"
                                                                                  height="14"
                                                                                  viewBox="0 0 17 14"
                                                                                  fill="none"
                                                                                  xmlns="http://www.w3.org/2000/svg">
<path d="M16.3929 0H0.607143C0.271317 0 0 0.284375 0 0.636364V3.81818H17V0.636364C17 0.284375 16.7287 0 16.3929 0ZM0 13.3636C0 13.7156 0.271317 14 0.607143 14H16.3929C16.7287 14 17 13.7156 17 13.3636V5.56818H0V13.3636ZM10.9855 9.70455C10.9855 9.61705 11.0538 9.54545 11.1373 9.54545H14.2679C14.3513 9.54545 14.4196 9.61705 14.4196 9.70455V11.1364C14.4196 11.2239 14.3513 11.2955 14.2679 11.2955H11.1373C11.0538 11.2955 10.9855 11.2239 10.9855 11.1364V9.70455Z"
      fill="white"/>
</svg>
</span> <?= Loc::getMessage('PAY_CARD'); ?>

                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="promote-card">
                                        <!-- ID "headingBustPack" shold be UNIC for every product card -->
                                        <div class="card-header" id="headingBustPack">
                                            <!-- Change for every button "data-target", "aria-controls" data value "#ID under section"-->
                                            <button class="btn btn-link btn-block text-right collapsed"
                                                    type="button" data-toggle="collapse"
                                                    data-target="#bustPack<?= $arResult['ID'] ?>"
                                                    aria-expanded="false"
                                                    aria-controls="bustPack">
                                                <div class="pr-4 d-flex justify-content-between align-items-center">
                                                    <span class="plus"></span>
                                                    <span class="card-header__title"><?= Loc::getMessage('UP_COMPLEX'); ?></span>

                                                </div>
                                                <span class="card-header__icon"><svg width="16"
                                                                                     height="18"
                                                                                     viewBox="0 0 16 18"
                                                                                     fill="none"
                                                                                     xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd"
      d="M10.7811 0.968714C10.7811 0.792056 10.7264 0.619732 10.6246 0.475353C10.5228 0.330975 10.3789 0.221608 10.2125 0.16224C10.0461 0.102871 9.86545 0.0964054 9.69525 0.143729C9.52505 0.191053 9.37365 0.289851 9.26179 0.426584L0.697334 9.84749C0.594729 9.97297 0.529841 10.125 0.510211 10.2859C0.49058 10.4468 0.517013 10.61 0.586437 10.7564C0.655861 10.9029 0.765426 11.0267 0.902399 11.1133C1.03937 11.2 1.19813 11.246 1.36022 11.2461H5.64245V16.3847C5.64248 16.5614 5.69714 16.7337 5.79894 16.8781C5.90074 17.0225 6.04469 17.1318 6.21107 17.1912C6.37746 17.2506 6.55813 17.257 6.72833 17.2097C6.89853 17.1624 7.04993 17.0636 7.16179 16.9269L15.7262 7.50596C15.8288 7.38048 15.8937 7.22845 15.9134 7.06755C15.933 6.90666 15.9066 6.74349 15.8371 6.59702C15.7677 6.45054 15.6582 6.32678 15.5212 6.24011C15.3842 6.15343 15.2254 6.10741 15.0634 6.10739H10.7811V0.968714Z"
      fill="#FF6B00"/>
</svg>
</span>
                                            </button>
                                        </div>

                                        <div id="bustPack<?= $arResult['ID'] ?>" class="collapse"
                                             aria-labelledby="headingBustPack"
                                             data-parent="#accordionUserItem<?= $arResult['ID'] ?>">
                                            <div class="p-3 bg-lightgray">
                                                <? $APPLICATION->IncludeComponent(
                                                    "bitrix:main.include",
                                                    "",
                                                    array(
                                                        "AREA_FILE_SHOW" => "file",
                                                        "AREA_FILE_SUFFIX" => "inc",
                                                        "EDIT_TEMPLATE" => "",
                                                        "PATH" => "/include-area/up-paket-" . LANGUAGE_ID . ".php"
                                                    )
                                                ); ?>

                                                <p class="mb-3 font-weight-bold content-subtitle">
                                                    <?= Loc::getMessage('type_item') ?></p>

                                                <form id="formProdactPaket1">
                                                    <div class="mb-4 px-3 card"
                                                         id="accordionSection<?= $arResult['ID'] ?>">
                                                        <? foreach ($arTypesPaket as $arRise) { ?>
                                                            <? if ($arRise['UF_PRICE'] > 0) { ?>
                                                                <div class="py-3 border-bottom d-flex justify-content-between"
                                                                     id="tipe1">
                                                                    <span class="font-weight-bold"><?= $arRise['UF_PRICE'] ?> T</span>

                                                                    <label class="custom-radio-btn">
                                                                        <!-- Change for every button "data-target", "aria-controls" data value "#ID under section"-->
                                                                        <input type="radio"
                                                                               value="<?= $arRise["ID"] ?>"
                                                                               data-price="<?= $arRise["UF_PRICE"] ?>"
                                                                               data-UF_RISE_COUNT="<?= $arRise["UF_RISE_COUNT"] ?>"
                                                                               data-UF_RISE_DAY="<?= $arRise["UF_RISE_DAY"] ?>"
                                                                               data-UF_LENTA="<?= $arRise["UF_LENTA"] ?>"
                                                                               data-UF_VIP="<?= $arRise["UF_VIP"] ?>"
                                                                               data-UF_COLOUR="<?= $arRise["UF_COLOUR"] ?>"
                                                                               data-UF_XML_ID_LENT="<?= $arRise["UF_XML_ID_LENT"] ?>"

                                                                               data-price-shek="<?= $arRise["UF_PRICE_SHEK"] ?>"
                                                                               name="riseProduct"
                                                                               data-toggle="collapse"
                                                                               data-target="#collapsePaket<?= $arResult['ID'] . $arRise['ID'] ?>"
                                                                               aria-expanded="true"

                                                                               aria-controls="collapseOne">
                                                                        <span><?= $arRise['UF_NAME'] ?></span>
                                                                        <span class="checkbox"></span>
                                                                    </label>
                                                                </div>

                                                                <div id="collapsePaket<?= $arResult['ID'] . $arRise['ID'] ?>"
                                                                     class="collapse"
                                                                     aria-labelledby="tipe1"
                                                                     data-parent="#accordionSection<?= $arResult['ID'] ?>">
                                                                    <div class="p-3 d-flex flex-column new-collapse">
                                                                        <p class="mb-4 text-uppercase font-weight-bold">
                                                                            <?= $arRise['UF_BIG_TEXT1'] ?>
                                                                        </p>

                                                                        <p class="text-right">
                                                                            <?= $arRise['UF_STANDART_TEXT'] ?>
                                                                        </p>

                                                                        <div class="d-flex position-relative justify-content-end pr-5">
                                                                            <p class="text-right"><?= $arRise['UF_RISE_DAY'] ?>
                                                                                поднятие
                                                                                в
                                                                                день - на <span
                                                                                        class="font-weight-bold"><?= $arRise['UF_RISE_COUNT'] ?></span>
                                                                                дней <span
                                                                                        class="font-weight-bold">(первое - завтра)</span>
                                                                            </p>

                                                                            <div class="circle-icon">
                                                                                <div class="d-flex justify-content-center align-items-center user-product__up-product">
                                                                                                <span data-id="<?= $arResult['ID'] ?>"
                                                                                                      class="text-uppercase font-weight-bold upRise">UP</span>

                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="d-flex position-relative justify-content-end pr-5">
                                                                            <p class="text-right">Выделение
                                                                                - на
                                                                                <span class="font-weight-bold"><?= $arRise['UF_LENTA'] ?></span>
                                                                                дней</p>

                                                                            <div class="circle-icon">
                                                                                <svg width="16" height="16"
                                                                                     viewBox="0 0 16 16"
                                                                                     fill="none"
                                                                                     xmlns="http://www.w3.org/2000/svg">
                                                                                    <rect width="9.40476"
                                                                                          height="6.83184"
                                                                                          rx="0.5"
                                                                                          transform="matrix(0.977206 -0.212292 0.118541 0.992949 0.503906 9.04102)"
                                                                                          fill="#FB2BFF"/>
                                                                                    <rect width="10.4788"
                                                                                          height="6.83184"
                                                                                          rx="0.5"
                                                                                          transform="matrix(0.977206 -0.212292 0.118541 0.992949 4.87109 3.15161)"
                                                                                          fill="#FB2BFF"/>
                                                                                    <path d="M5.58984 9.95654L9.93666 9.01223L10.4706 13.4847L5.58984 9.95654Z"
                                                                                          fill="#961299"/>
                                                                                </svg>

                                                                            </div>
                                                                        </div>

                                                                        <div class="d-flex position-relative justify-content-end pr-5">
                                                                            <p class="text-right">VIP -
                                                                                закрепление - на <span
                                                                                        class="font-weight-bold"><?= $arRise['UF_VIP'] ?></span>
                                                                                дня</p>

                                                                            <div class="circle-icon">
                                                                                <svg width="22" height="19"
                                                                                     viewBox="0 0 22 19"
                                                                                     fill="none"
                                                                                     xmlns="http://www.w3.org/2000/svg">
                                                                                    <path d="M1.58936 3.42876L5.88549 6.18822L10.1673 0.413067C10.2619 0.285313 10.3868 0.181179 10.5317 0.109331C10.6765 0.0374835 10.837 0 10.9999 0C11.1628 0 11.3234 0.0374835 11.4682 0.109331C11.613 0.181179 11.7379 0.285313 11.8326 0.413067L16.1144 6.18822L20.4105 3.42876C20.5731 3.32454 20.7633 3.26734 20.9585 3.26392C21.1538 3.2605 21.346 3.31101 21.5124 3.40947C21.6788 3.50793 21.8125 3.65023 21.8976 3.81956C21.9828 3.98888 22.0159 4.17815 21.9929 4.36501L20.3123 18.1298C20.283 18.3695 20.1634 18.5905 19.9762 18.7509C19.7889 18.9113 19.5471 19 19.2966 19H2.70328C2.45274 19 2.21093 18.9113 2.0237 18.7509C1.83648 18.5905 1.71687 18.3695 1.68755 18.1298L0.00694712 4.36402C-0.015761 4.17725 0.0174677 3.98811 0.102711 3.81895C0.187954 3.64978 0.321652 3.50764 0.488023 3.40931C0.654394 3.31098 0.846492 3.26056 1.04164 3.26401C1.23679 3.26745 1.42684 3.32462 1.58936 3.42876ZM10.9999 13.0869C11.5425 13.0869 12.0629 12.8792 12.4465 12.5096C12.8302 12.1399 13.0457 11.6386 13.0457 11.1158C13.0457 10.5931 12.8302 10.0917 12.4465 9.72209C12.0629 9.35245 11.5425 9.14479 10.9999 9.14479C10.4574 9.14479 9.93701 9.35245 9.55335 9.72209C9.16969 10.0917 8.95416 10.5931 8.95416 11.1158C8.95416 11.6386 9.16969 12.1399 9.55335 12.5096C9.93701 12.8792 10.4574 13.0869 10.9999 13.0869Z"
                                                                                          fill="#F50000"/>
                                                                                </svg>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <? }
                                                        } ?>
                                                    </div>
                                                </form>

                                                <p class="mb-3 font-weight-bold content-subtitle">
                                                    <?= Loc::getMessage('PAY_CHOISE'); ?>
                                                    :</p>

                                                <div class="d-flex flex-column justify-content-end align-items-end">
                                                    <button type="button"
                                                            onclick="countPaketBuy(<?= $arResult['ID'] ?>, $('#formProdactPaket1'), <?= $arResult['IBLOCK_ID'] ?>)"
                                                            data-toggle="modal" data-target="#payTcoins"
                                                            class="mb-3 btn btn-primary btn-paid"><span
                                                                class="mr-2"><svg width="17" height="17"
                                                                                  viewBox="0 0 17 17" fill="none"
                                                                                  xmlns="http://www.w3.org/2000/svg"><path
                                                                        d="M11.8169 0.00066338C8.95442 0.00066338 6.63389 1.28034 6.63389 2.8612C6.63389 4.44205 8.95508 5.72239 11.8169 5.72239C14.6795 5.72239 17 4.44205 17 2.8612C17 1.28034 14.6788 0 11.8169 0V0.00066338ZM17 3.711C16.9987 5.29185 14.6795 6.57219 11.8169 6.57219C8.96238 6.57219 6.64716 5.30578 6.63389 3.73223V4.85136C6.63389 5.52669 7.06642 6.14497 7.77492 6.63455C8.49138 6.82959 9.12956 7.10025 9.66093 7.44256C10.3197 7.60973 11.0441 7.71189 11.8169 7.71189C14.6795 7.71189 17 6.43222 17 4.85136V3.711ZM17 5.70116C17 7.28202 14.6795 8.56236 11.8169 8.56236C11.4687 8.56236 11.1303 8.53649 10.8013 8.5C11.0609 8.84969 11.2381 9.25361 11.3194 9.6815C11.4846 9.69078 11.6478 9.70206 11.8169 9.70206C14.6795 9.70206 17 8.42238 17 6.84153V5.70116ZM5.18306 7.29728C2.32053 7.29728 0 8.57762 0 10.1585C0 11.7393 2.3212 13.0197 5.18306 13.0197C8.04558 13.0197 10.3661 11.7393 10.3661 10.1585C10.3661 8.57762 8.04492 7.29728 5.18306 7.29728ZM17 7.69133C16.9987 9.27219 14.6795 10.5525 11.8169 10.5525C11.6504 10.5525 11.4819 10.5406 11.3194 10.5313C11.3121 10.5811 11.3081 10.6474 11.2988 10.6971C11.332 10.7973 11.3605 10.8962 11.3605 11.0089V11.6723C11.5111 11.6796 11.6624 11.6922 11.8169 11.6922C14.6795 11.6922 17 10.4125 17 8.83169V7.69133ZM17 9.6815C16.9987 11.2624 14.6795 12.5427 11.8169 12.5427C11.6504 12.5427 11.4819 12.5308 11.3194 12.5215C11.3121 12.5712 11.3081 12.6376 11.2988 12.6873C11.332 12.7868 11.3605 12.8863 11.3605 12.9991V13.6625C11.5111 13.6698 11.6624 13.6824 11.8169 13.6824C14.6795 13.6824 17 12.4027 17 10.8219V9.6815ZM10.3661 11.0083C10.3648 12.5891 8.04558 13.8695 5.18306 13.8695C2.32849 13.8695 0.0132678 12.6031 0 11.0288V12.1486C0 13.7295 2.31987 15.0098 5.18306 15.0098C8.04624 15.0098 10.3661 13.7295 10.3661 12.1486V11.0083ZM10.3661 12.9984C10.3648 14.5793 8.04558 15.8596 5.18306 15.8596C2.32849 15.8596 0.0132678 14.5932 0 13.019V14.1388C0 15.7197 2.31987 17 5.18306 17C8.04624 17 10.3661 15.7197 10.3661 14.1388V12.9984Z"
                                                                        fill="white"/></svg>
                                                                                    </span>
                                                        <?= Loc::getMessage('PAY_T_COINS'); ?>

                                                    </button>
                                                    <button type="button"
                                                            onclick="countPaketBuyShek(<?= $arResult['ID'] ?>, $('#formProdactPaket1'), <?= $arResult['IBLOCK_ID'] ?>)"

                                                            class="btn btn-primary btn-paid"><span
                                                                class="mr-2"><svg width="17"
                                                                                  height="14"
                                                                                  viewBox="0 0 17 14"
                                                                                  fill="none"
                                                                                  xmlns="http://www.w3.org/2000/svg">
<path d="M16.3929 0H0.607143C0.271317 0 0 0.284375 0 0.636364V3.81818H17V0.636364C17 0.284375 16.7287 0 16.3929 0ZM0 13.3636C0 13.7156 0.271317 14 0.607143 14H16.3929C16.7287 14 17 13.7156 17 13.3636V5.56818H0V13.3636ZM10.9855 9.70455C10.9855 9.61705 11.0538 9.54545 11.1373 9.54545H14.2679C14.3513 9.54545 14.4196 9.61705 14.4196 9.70455V11.1364C14.4196 11.2239 14.3513 11.2955 14.2679 11.2955H11.1373C11.0538 11.2955 10.9855 11.2239 10.9855 11.1364V9.70455Z"
      fill="white"/>
</svg>
</span> <?= Loc::getMessage('PAY_CARD'); ?>

                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>


                <? } else { ?>

                    <div class="mb-4 card connection-with-seller text-right">
                        <h1 class="mb-4 connection-with-seller__title"><?= $arResult['NAME']; ?></h1>

                        <p class="mb-4 connection-with-seller__price text-primary">
                            <?= number_format($arResult['PROPERTIES']['PRICE']['VALUE'], 0, '.', ' '); ?> <?= ICON_CURRENCY; ?>
                        </p>

                        <? if (!empty($arResult['PROPERTIES']['UF_REGION']['~VALUE'])) { ?>
                            <p class="pb-3 border-bottom">
                                <span class="mr-1"><?= $arResult['PROPERTIES']['UF_CITY']['VALUE']; ?> <?= (!empty($arResult['PROPERTIES']['UF_CITY']['VALUE'])) ? ',' : '' ?> <?= $arResult['PROPERTIES']['UF_REGION']['VALUE']; ?></span>
                                <svg class="icon-local"
                                     style="position: relative; width: 16px; top: -2px; fill: #747474" version="1.1"
                                     id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                     xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                     viewBox="0 0 513.597 513.597" xml:space="preserve">
                                      <g>
                                          <path d="M263.278,0.107C158.977-3.408,73.323,80.095,73.323,183.602c0,117.469,112.73,202.72,175.915,325.322
                                        c3.208,6.225,12.169,6.233,15.388,0.009c57.16-110.317,154.854-184.291,172.959-290.569
                                        C456.331,108.387,374.776,3.866,263.278,0.107z M256.923,279.773c-53.113,0-96.171-43.059-96.171-96.171
                                        s43.059-96.171,96.171-96.171c53.113,0,96.172,43.059,96.172,96.171S310.036,279.773,256.923,279.773z"></path>
                                      </g>
                                    </svg>
                            </p>
                        <? } ?>

                        <div class="row no-gutters">
                            <button class="mr-2 col btn btn-show-phone text-uppercase font-weight-bold"
                                    data-toggle="collapse" href="#showContactPhone" role="button" aria-expanded="false"
                                    aria-controls="showContactPhone"><?= Loc::getMessage('SHOW_PHONE'); ?>
                            </button>

                            <button class="ml-2 col btn btn-primary text-uppercase font-weight-bold" data-toggle="modal"
                                    data-target="#modalSandMessage"><?= Loc::getMessage('SEND_MESSAGE'); ?>
                            </button>
                        </div>

                        <ul class="text-right collapse contact-list" id="showContactPhone">
                            <li class="d-flex justify-content-end">
                                <p class="mb-0 d-flex align-items-center time">
                                    <? if ($arResult['PROPERTIES']['UF_CALL_ANYTIME']['VALUE'] == 1) { ?>
                                        <span class="mx-2"><?= Loc::getMessage('CALL_ANYTIME'); ?></span>
                                    <? } else { ?>

                                        from<span
                                                class="mx-2"><?= $arResult['PROPERTIES']['UF_CALL_FROM']['VALUE'] ?></span>
                                        to <span
                                                class="mx-2"><?= $arResult['PROPERTIES']['UF_CALL_TO']['VALUE'] ?></span>
                                    <? } ?>
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9.99 0C4.47 0 0 4.48 0 10C0 15.52 4.47 20 9.99 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 9.99 0ZM10 18C5.58 18 2 14.42 2 10C2 5.58 5.58 2 10 2C14.42 2 18 5.58 18 10C18 14.42 14.42 18 10 18ZM9.78 5H9.72C9.32 5 9 5.32 9 5.72V10.44C9 10.79 9.18 11.12 9.49 11.3L13.64 13.79C13.98 13.99 14.42 13.89 14.62 13.55C14.6702 13.469 14.7036 13.3788 14.7182 13.2846C14.7328 13.1905 14.7283 13.0943 14.705 13.002C14.6817 12.9096 14.64 12.8229 14.5824 12.7469C14.5249 12.671 14.4526 12.6074 14.37 12.56L10.5 10.26V5.72C10.5 5.32 10.18 5 9.78 5Z"
                                              fill="#555555"/>
                                    </svg>

                                </p>
                            </li>
                            <? if ($arResult['PROPERTIES']['UF_PHONE_1']['VALUE']) { ?>
                                <li>
                                    <a href="tel:<?= $arResult['PROPERTIES']['UF_PHONE_1']['VALUE'] ?>"><?= $arResult['PROPERTIES']['UF_PHONE_1']['VALUE'] ?></a>
                                </li>
                            <? } ?>
                            <? if ($arResult['PROPERTIES']['UF_PHONE_2']['VALUE']) { ?>
                                <li>
                                    <a href="tel:<?= $arResult['PROPERTIES']['UF_PHONE_2']['VALUE'] ?>"><?= $arResult['PROPERTIES']['UF_PHONE_2']['VALUE'] ?></a>
                                </li>
                            <? } ?>
                            <? if ($arResult['PROPERTIES']['UF_PHONE_3']['VALUE']) { ?>
                                <li>
                                    <a href="tel:<?= $arResult['PROPERTIES']['UF_PHONE_3']['VALUE'] ?>"><?= $arResult['PROPERTIES']['UF_PHONE_3']['VALUE'] ?></a>
                                </li>
                            <? } ?>
                        </ul>
                    </div>

                <? } ?>


                <div class="mb-4 p-3 card d-lg-block">
                    <table class="table text-right text-dark">
                        <tbody>
                    
                        <? foreach ($arResult['PROPERTIES'] as $PROPERTY) {
                            $needle = 'PROP';
                            $pos = strripos($PROPERTY['CODE'], $needle);
                            $needle2 = '_Left';
                            $pos2 = strripos($PROPERTY['CODE'], $needle2);
                            if ($pos2 !== false && $pos !== false && $PROPERTY['CODE'] !== 'PRICE') {
                                ?>
                                <tr>
                                    <td class="border-top-0">
                                    <? if (is_array($PROPERTY['VALUE'])) {
                                        foreach ($PROPERTY['VALUE'] as $value) {
                                            echo $value . '</br>';
                                        }
                                    } else {
                                        echo $PROPERTY['VALUE'];
                                    } ?>
                                    <?if($PROPERTY['CODE'] == 'PROP_PROBEG_Left'){
                                        echo '/ ' . $arResult['PROPERTIES']['PROP_KM_ML']['VALUE'];
                                    }elseif ($PROPERTY['CODE'] == 'PROP_ENGIEN_NEW_Left'){
                                        echo '/ ' . $arResult['PROPERTIES']['PROP_KM_ML_ENGIE']['VALUE'];
                                    }?>
                                    </td>
                                    <td class="border-top-0"><?= $PROPERTY['HINT'] ?></td>
                                </tr>
                            <? }
                        } ?>
                        </tbody>
                    </table>
                </div>
                <div class="mb-5 card mainCardMobile">
                    <div class="about-auto">
                        <div class="mb-4 text-right seller-comment">
                            <? if (!empty($arResult['PREVIEW_TEXT'])) { ?>
                                <h4 class="mb-5 font-weight-bold text-uppercase"><?=Loc::getMessage('sellerComment')?></h4>
                                <p><?= $arResult['PREVIEW_TEXT']; ?></p>
                            <? } ?>
                        </div>

                        <h5 class="mb-4 text-right font-weight-bolder text-uppercase"><?=Loc::getMessage('equipment')?></h5>
                        <? foreach ($arResult['PROPERTIES'] as $PROPERTY) {
                            if ($PROPERTY['MULTIPLE'] == 'Y' && $PROPERTY['ID'] != '53' && $PROPERTY['CODE'] != 'PHOTOS' && $PROPERTY['VALUE'] != null && strpos($PROPERTY['CODE'], "_Left") === false) {
                                ?>
                                <div class="pb-3 border-top d-flex justify-content-between" data-toggle="collapse"
                                     href="#collapse<?= $PROPERTY["CODE"] ?>" role="button" aria-expanded="false"
                                     aria-controls="collapse<?= $PROPERTY["HINT"] ?>">
                                    <span><i class="mr-3 icon-arrow-down-sign-to-navigate-3"></i><?= count($PROPERTY["VALUE"]) ?> אופציות</span>
                                    <span class="font-weight-bold"><?= $PROPERTY["HINT"] ?>    :</span>
                                </div>
                                <div class="collapse show" id="collapse<?= $PROPERTY["CODE"] ?>">
                                    <div class="row flex-row-reverse text-right">
                                        <div style="display: none">
                                            <? $col = 0; ?>
                                            <? foreach ($PROPERTY['VALUE'] as $item) { ?>
                                            <? if ($col == 0 || $col == 2 || $col == 5){ ?>
                                        </div>
                                        <div class="col-3">
                                            <p><?= $item ?></p>
                                            <? } else { ?>
                                                <p><?= $item ?></p>
                                            <? } ?>
                                            <? $col++; ?>
                                            <? } ?>
                                        </div>
                                    </div>
                                </div>
                            <? }
                        } ?>


                        <div class="mt-3 pt-3 border-top d-flex justify-content-between">
                            <div class="viewers">
                            <span class="mr-2"><? $res = CIBlockElement::GetByID($arResult["ID"]);
                                if ($ar_res = $res->GetNext())
                                    echo $ar_res['SHOW_COUNTER'];
                                ?></span>
                                <i class="icon-visibility"></i>
                            </div>
                            <?
                            $strDate = getStringDate($arResult['DATE_CREATE']);
                            ?>
                            <div class="date"><?= ($strDate['MES']) ? GetMessage($strDate['MES']) . ', ' . $strDate['HOURS'] : $strDate['HOURS']; ?></div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="mb-4 card seller-card text-right">
                <p class="text-uppercase seller-card__title"><?= $arResult['PROPERTIES']['UF_SELLER_TYPE']['VALUE']; ?></p>

                <div class="mb-4 d-flex justify-content-end align-items-center">
                    <div class="seller-card__data">
                        <span class="name"><?= $arResult['PROPERTIES']['UF_NAME']['VALUE']; ?></span>

                        <? if ($arResult['USER']['IS_ONLINE'] == 'Y') { ?>
                            <p class="m-0 d-flex justify-content-end align-items-center">
                                <span class="status">Online</span>
                                <span class="status_dot"></span>
                            </p>
                        <? } else { ?>
                            <p class="m-0 d-flex justify-content-end align-items-center offline">
                                <span class="status">Offline</span>
                                <span class="status_dot"></span>
                            </p>
                        <? } ?>


                        <span class="date-registration">Registered: <?= $arResult['USER']['DATE_REGISTER']; ?></span>
                    </div>
                    <div class="seller-card__photo">
                        <img src="<?= SITE_TEMPLATE_PATH; ?>/img/seller-photo.png" alt="">
                    </div>
                </div>

                <button class="w-100 btn btn-primary text-uppercase btn-author-add"><a
                            href="/search/author/?R=<?= $arResult['IBLOCK_ID'] ?>&I=<?= $arResult['PROPERTIES']['ID_USER']['VALUE'] ?>&sort=price_d&display=block"><?= Loc::getMessage('ALL_ADS_AUTHOR'); ?></a>
                </button>
            </div>
        </div>

        <div class="col-12 col-lg-8">
            <div class="item-slider">
                  <span class="add-item-favorite">
                       <? if ($USER->IsAuthorized()) { ?>
                           <svg id="iconLike" data-ad_id="<?= $arResult['ID']; ?>" class="iconLike like"
                                viewBox="0 0 612 792"><path
                                       d="M562.413,284.393c-9.68,41.044-32.121,78.438-64.831,108.07L329.588,542.345l-165.11-149.843 c-32.771-29.691-55.201-67.076-64.892-108.12c-6.965-29.484-4.103-46.14-4.092-46.249l0.147-0.994 c6.395-72.004,56.382-124.273,118.873-124.273c46.111,0,86.703,28.333,105.965,73.933l9.061,21.477l9.061-21.477 c18.958-44.901,61.694-73.922,108.896-73.922c62.481,0,112.478,52.27,119,125.208C566.517,238.242,569.379,254.908,562.413,284.393z"/>
                    </svg>
                           <?
                       } else { ?>
                           <a data-toggle="modal" data-target="#logInModal" class="d-flex align-items-center mr-3"
                              href="#">
                                <svg id="iconLike" data-ad_id="<?= $arResult['ID']; ?>" class="iconLike like"
                                     viewBox="0 0 612 792"><path
                                            d="M562.413,284.393c-9.68,41.044-32.121,78.438-64.831,108.07L329.588,542.345l-165.11-149.843 c-32.771-29.691-55.201-67.076-64.892-108.12c-6.965-29.484-4.103-46.14-4.092-46.249l0.147-0.994 c6.395-72.004,56.382-124.273,118.873-124.273c46.111,0,86.703,28.333,105.965,73.933l9.061,21.477l9.061-21.477 c18.958-44.901,61.694-73.922,108.896-73.922c62.481,0,112.478,52.27,119,125.208C566.517,238.242,569.379,254.908,562.413,284.393z"/>
                    </svg>
                            </a>
                           <?
                       } ?>
                  </span>

                <div class="slider-for">
                    <?
                    foreach ($arResult['PHOTOS'] as $k => $item) {
                        ?>
                        <div class="slide" data-toggle="modal" data-target="#modalFullSize"
                             data-current-slider="<?= $k; ?>">
                            <img src="<?= $item['ORIG']; ?>" alt="">
                        </div>
                        <?
                    }
                    ?>
                </div>

                <div class="dots slider-nav">
                    <?
                    $count = count($arResult['PHOTOS']);
                    foreach ($arResult['PHOTOS'] as $k => $item) {
                        ?>
                        <?
                        if ($count > 10 && $k == 9) {
                            ?>
                            <div class="dot all-photo" data-toggle="modal" data-target="#modalFullSize">
                                <img src="<?= $item['ORIG']; ?>" alt="">
                                <span class="text">Еще <?= ($count - 10); ?> фото</span>
                            </div>
                            <? break;
                        } else {
                            ?>
                            <div class="dot" data-slide="<?= $k; ?>">
                                <img src="<?= $item['ORIG']; ?>" alt="">
                            </div>
                            <?
                        }

                        ?>
                        <?
                    }
                    ?>

                </div>

                <div class="modal fade" id="modalFullSize" tabindex="-1" role="dialog"
                     aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                    <div class="modal-dialog m-0 mw-100" role="document">
                        <div class="modal-content bg-transparent">
                            <div class="fullScreenItemModal">
                                <button type="button" class="m-0 mr-auto close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>

                                <div class="slider-counter-mobile">
                                </div>

                                <div class="fullScreenItemModal__content">
                                    <div class="row h-100">
                                        <div class="col-3 seller-cards">
                                            <? if (!$arParams['USER_ID']) { ?>
                                                <div class="mb-4 card connection-with-seller text-right">
                                                    <h1 class="mb-4 connection-with-seller__title"><?= $arResult['NAME']; ?></h1>

                                                    <p class="mb-4 connection-with-seller__price text-primary">
                                                        <?= number_format($arResult['PROPERTIES']['PRICE']['VALUE'], 0, '.', ' '); ?> <?= ICON_CURRENCY; ?>
                                                    </p>

                                                    <? if (!empty($arResult['PROPERTIES']['UF_REGION']['~VALUE'])) { ?>
                                                        <p class="pb-3 border-bottom">
                                                            <span class="mr-1"><?= $arResult['PROPERTIES']['UF_CITY']['VALUE']; ?> <?= (!empty($arResult['PROPERTIES']['UF_CITY']['VALUE'])) ? ',' : '' ?> <?= $arResult['PROPERTIES']['UF_REGION']['VALUE']; ?></span>
                                                            <svg class="icon-local"
                                                                 style="position: relative; width: 16px; top: -2px; fill: #747474"
                                                                 version="1.1"
                                                                 id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                                                 xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                                                                 y="0px"
                                                                 viewBox="0 0 513.597 513.597" xml:space="preserve">
                                      <g>
                                          <path d="M263.278,0.107C158.977-3.408,73.323,80.095,73.323,183.602c0,117.469,112.73,202.72,175.915,325.322
                                        c3.208,6.225,12.169,6.233,15.388,0.009c57.16-110.317,154.854-184.291,172.959-290.569
                                        C456.331,108.387,374.776,3.866,263.278,0.107z M256.923,279.773c-53.113,0-96.171-43.059-96.171-96.171
                                        s43.059-96.171,96.171-96.171c53.113,0,96.172,43.059,96.172,96.171S310.036,279.773,256.923,279.773z"></path>
                                      </g>
                                    </svg>
                                                        </p>
                                                    <? } ?>


                                                    <div class="mb-4 row no-gutters">
                                                        <button class="mr-2 col btn btn-show-phone text-uppercase font-weight-bold"
                                                                disabled><?= Loc::getMessage('SHOW_PHONE'); ?>
                                                        </button>
                                                        <button class="ml-2 col btn btn-primary text-uppercase font-weight-bold"
                                                                disabled><?= Loc::getMessage('SEND_MESSAGE'); ?>
                                                        </button>
                                                    </div>

                                                    <p class="text-unaurh-user"><?= Loc::getMessage('VIEW_REGISTER_MESS'); ?></p>

                                                    <div class="row">
                                                        <div class="col">
                                                            <ul class="nav justify-content-end font-weight-bold">
                                                                <li class="mr-4 justify-content-center">
                                                                    <a class="" href="#" data-toggle="modal"
                                                                       data-target="#registerModal">
                                                                        <span class="mr-2"><?= Loc::getMessage('REGISTER'); ?></span>
                                                                        <i class="icon-user-1"></i>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="" href="#" data-toggle="modal"
                                                                       data-target="#logInModal">
                                                                        <span class="mr-2"><?= Loc::getMessage('Sign_In'); ?></span>
                                                                        <i class="icon-log-in"></i>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                            <? include $_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH . "/includes/footer/register_modal.php"; ?>
                                                            <? include $_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH . "/includes/footer/auth_modal.php"; ?>
                                                        </div>
                                                    </div>
                                                </div>

                                            <? } elseif ($arParams['USER_ID'] == $arResult['PROPERTIES']['ID_USER']['VALUE']) { ?>

                                                <div class="mb-4 card connection-with-seller text-right">
                                                    <h1 class="mb-4 connection-with-seller__title"><?= $arResult['NAME']; ?></h1>

                                                    <p class="mb-4 connection-with-seller__price text-primary">
                                                        <?= number_format($arResult['PROPERTIES']['PRICE']['VALUE'], 0, '.', ' '); ?> <?= ICON_CURRENCY; ?>
                                                    </p>

                                                    <? if (!empty($arResult['PROPERTIES']['UF_REGION']['~VALUE'])) { ?>
                                                        <p class="pb-3 border-bottom">
                                                            <span class="mr-1"><?= $arResult['PROPERTIES']['UF_CITY']['VALUE']; ?> <?= (!empty($arResult['PROPERTIES']['UF_CITY']['VALUE'])) ? ',' : '' ?> <?= $arResult['PROPERTIES']['UF_REGION']['VALUE']; ?></span>
                                                            <svg class="icon-local"
                                                                 style="position: relative; width: 16px; top: -2px; fill: #747474"
                                                                 version="1.1"
                                                                 id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                                                 xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                                                                 y="0px"
                                                                 viewBox="0 0 513.597 513.597" xml:space="preserve">
                                      <g>
                                          <path d="M263.278,0.107C158.977-3.408,73.323,80.095,73.323,183.602c0,117.469,112.73,202.72,175.915,325.322
                                        c3.208,6.225,12.169,6.233,15.388,0.009c57.16-110.317,154.854-184.291,172.959-290.569
                                        C456.331,108.387,374.776,3.866,263.278,0.107z M256.923,279.773c-53.113,0-96.171-43.059-96.171-96.171
                                        s43.059-96.171,96.171-96.171c53.113,0,96.172,43.059,96.172,96.171S310.036,279.773,256.923,279.773z"></path>
                                      </g>
                                    </svg>
                                                        </p>
                                                    <? } ?>


                                                    <div class="flex-column">
                                                        <button onclick="window.location.href='<?= $editUrl ?>'"
                                                                class="mb-3 w-100 btn btn-primary text-uppercase font-weight-bold">
                                                            <a href="<?= $editUrl ?>"><?= Loc::getMessage('EDIT'); ?></a>
                                                        </button>
                                                        <button class="w-100 btn btn-accelerate-sale text-uppercase font-weight-bold btn-accelerate-sale"><span><svg
                                                                        width="31" height="18" viewBox="0 0 31 18"
                                                                        fill="none"
                                                                        xmlns="http://www.w3.org/2000/svg">
                                    <path d="M29.4417 3.27725H14.2853L14.06 0.734453C14.0231 0.318623 13.6792 0 13.2671 0H11.6496C11.2099 0 10.8535 0.361101 10.8535 0.806543C10.8535 1.25198 11.2099 1.61309 11.6496 1.61309H12.5393C13.0254 7.10073 11.7689 -7.08279 13.4549 11.9479C13.5199 12.6928 13.9171 13.5011 14.6014 14.0503C13.3676 15.6466 14.495 18 16.502 18C18.1678 18 19.3427 16.3168 18.7715 14.7226H23.1286C22.558 16.3147 23.7304 18 25.398 18C26.7289 18 27.8116 16.9031 27.8116 15.5548C27.8116 14.2064 26.7289 13.1095 25.398 13.1095H16.5074C15.9026 13.1095 15.3757 12.7399 15.1482 12.2013L27.8708 11.4438C28.2181 11.4231 28.512 11.1763 28.5964 10.8343L30.214 4.2794C30.3394 3.77113 29.9597 3.27725 29.4417 3.27725ZM16.502 16.3869C16.0491 16.3869 15.6806 16.0136 15.6806 15.5548C15.6806 15.0959 16.0491 14.7226 16.502 14.7226C16.9549 14.7226 17.3234 15.0959 17.3234 15.5548C17.3234 16.0136 16.9549 16.3869 16.502 16.3869ZM25.398 16.3869C24.9451 16.3869 24.5766 16.0136 24.5766 15.5548C24.5766 15.0959 24.9451 14.7226 25.398 14.7226C25.8509 14.7226 26.2194 15.0959 26.2194 15.5548C26.2194 16.0136 25.8509 16.3869 25.398 16.3869ZM27.1936 9.86828L14.9339 10.5982L14.4282 4.8903H28.4221L27.1936 9.86828Z"
                                          fill="white"/>
                                    <path d="M10.509 8.05168C10.6904 8.02447 10.8535 8.16495 10.8535 8.34836V10.6516C10.8535 10.8351 10.6904 10.9755 10.509 10.9483L2.83139 9.79668C2.49072 9.74558 2.49072 9.25442 2.83139 9.20332L10.509 8.05168Z"
                                          fill="white"/>
                                    <path d="M10.5111 5.04892C10.6918 5.0231 10.8535 5.16334 10.8535 5.3459V6.6541C10.8535 6.83666 10.6918 6.9769 10.5111 6.95108L5.93241 6.29698C5.58898 6.24792 5.58898 5.75208 5.93241 5.70302L10.5111 5.04892Z"
                                          fill="white"/>
                                    <path d="M10.5111 12.0489C10.6918 12.0231 10.8535 12.1633 10.8535 12.3459V13.6541C10.8535 13.8367 10.6918 13.9769 10.5111 13.9511L5.93241 13.297C5.58898 13.2479 5.58898 12.7521 5.93241 12.703L10.5111 12.0489Z"
                                          fill="white"/>
                                    </svg>
                                    </span> <?= Loc::getMessage('SPEED_SALE'); ?>
                                                        </button>
                                                        <div class="accardion-wrap"
                                                             id="accordionUserItemWrap<?= $arResult['ID'] ?>">

                                                            <div class="accordion user-promote-menu"
                                                                 id="accordionUserItem<?= $arResult['ID'] ?>">
                                                                <!-- RISE -->
                                                                <div class="promote-card">
                                                                    <!-- ID "headingRiseItem" shold be UNIC for every product card -->
                                                                    <div class="card-header" id="headingRiseItem">
                                                                        <button class="btn btn-link btn-block text-right collapsed"
                                                                                type="button" data-toggle="collapse"
                                                                                data-target="#riseItem<?= $arResult['ID'] ?>"
                                                                                aria-expanded="false"
                                                                                aria-controls="riseItem">
                                                                            <div class="pr-4 d-flex justify-content-between align-items-center">
                                                                                <span class="plus"></span>
                                                                                <span class="card-header__title"><?= Loc::getMessage('RISE_PAKET'); ?></span>

                                                                            </div>
                                                                        </button>
                                                                        <span class="text-uppercase font-weight-bold up card-header__icon">UP</span>
                                                                    </div>

                                                                    <!-- data-parent depend on "accordionUserItem<?= $arResult['ID'] ?>" -->
                                                                    <!-- aria-labelledby depend on "headingRiseItem" -->
                                                                    <div id="riseItem<?= $arResult['ID'] ?>"
                                                                         class="collapse"
                                                                         aria-labelledby="headingRiseItem"
                                                                         data-parent="#accordionUserItem<?= $arResult['ID'] ?>">
                                                                        <div class="p-3 bg-lightgray">
                                                                            <? $APPLICATION->IncludeComponent(
                                                                                "bitrix:main.include",
                                                                                "",
                                                                                array(
                                                                                    "AREA_FILE_SHOW" => "file",
                                                                                    "AREA_FILE_SUFFIX" => "inc",
                                                                                    "EDIT_TEMPLATE" => "",
                                                                                    "PATH" => "/include-area/up-rise-" . LANGUAGE_ID . ".php"
                                                                                )
                                                                            ); ?>

                                                                            <p class="mb-3 font-weight-bold content-subtitle">
                                                                                <?= Loc::getMessage('type_item') ?></p>
                                                                            <form id="formProdactRise2">
                                                                                <div class="mb-4 px-3 card">
                                                                                    <? foreach ($arTypesRise as $arRise) { ?>
                                                                                        <? if ($arRise['UF_COUNT'] > 0) { ?>
                                                                                            <div class="py-3 border-bottom d-flex justify-content-between">
                                                                                                <span class="font-weight-bold"><?= $arRise["UF_PRICE"] ?> T</span>


                                                                                                <label class="custom-radio-btn">
                                                                                                    <input type="radio"
                                                                                                           value="<?= $arRise["UF_COUNT"] ?>"
                                                                                                           data-price="<?= $arRise["UF_PRICE"] ?>"
                                                                                                           data-price-shek="<?= $arRise["UF_PRICE_SHEK"] ?>"
                                                                                                           name="riseProduct">
                                                                                                    <span><?= $arRise["UF_NAME"] ?></span>
                                                                                                    <span class="checkbox"></span>
                                                                                                </label>
                                                                                            </div>
                                                                                        <? }
                                                                                    } ?>
                                                                                </div>

                                                                                <p class="mb-3 font-weight-bold content-subtitle">
                                                                                    <?= Loc::getMessage('PAY_CHOISE'); ?>
                                                                                    :</p>

                                                                                <div class="d-flex flex-column justify-content-end align-items-end">
                                                                                    <button type="button"
                                                                                            onclick="countRiseBuy(<?= $arResult['ID'] ?>, $('#formProdactRise2'), <?= $arResult['IBLOCK_ID'] ?>)"
                                                                                            data-toggle="modal"
                                                                                            data-target="#payTcoins"
                                                                                            class="mb-3 btn btn-primary btn-paid"><span
                                                                                                class="mr-2"><svg
                                                                                                    width="17"
                                                                                                    height="17"
                                                                                                    viewBox="0 0 17 17"
                                                                                                    fill="none"
                                                                                                    xmlns="http://www.w3.org/2000/svg"><path
                                                                                                        d="M11.8169 0.00066338C8.95442 0.00066338 6.63389 1.28034 6.63389 2.8612C6.63389 4.44205 8.95508 5.72239 11.8169 5.72239C14.6795 5.72239 17 4.44205 17 2.8612C17 1.28034 14.6788 0 11.8169 0V0.00066338ZM17 3.711C16.9987 5.29185 14.6795 6.57219 11.8169 6.57219C8.96238 6.57219 6.64716 5.30578 6.63389 3.73223V4.85136C6.63389 5.52669 7.06642 6.14497 7.77492 6.63455C8.49138 6.82959 9.12956 7.10025 9.66093 7.44256C10.3197 7.60973 11.0441 7.71189 11.8169 7.71189C14.6795 7.71189 17 6.43222 17 4.85136V3.711ZM17 5.70116C17 7.28202 14.6795 8.56236 11.8169 8.56236C11.4687 8.56236 11.1303 8.53649 10.8013 8.5C11.0609 8.84969 11.2381 9.25361 11.3194 9.6815C11.4846 9.69078 11.6478 9.70206 11.8169 9.70206C14.6795 9.70206 17 8.42238 17 6.84153V5.70116ZM5.18306 7.29728C2.32053 7.29728 0 8.57762 0 10.1585C0 11.7393 2.3212 13.0197 5.18306 13.0197C8.04558 13.0197 10.3661 11.7393 10.3661 10.1585C10.3661 8.57762 8.04492 7.29728 5.18306 7.29728ZM17 7.69133C16.9987 9.27219 14.6795 10.5525 11.8169 10.5525C11.6504 10.5525 11.4819 10.5406 11.3194 10.5313C11.3121 10.5811 11.3081 10.6474 11.2988 10.6971C11.332 10.7973 11.3605 10.8962 11.3605 11.0089V11.6723C11.5111 11.6796 11.6624 11.6922 11.8169 11.6922C14.6795 11.6922 17 10.4125 17 8.83169V7.69133ZM17 9.6815C16.9987 11.2624 14.6795 12.5427 11.8169 12.5427C11.6504 12.5427 11.4819 12.5308 11.3194 12.5215C11.3121 12.5712 11.3081 12.6376 11.2988 12.6873C11.332 12.7868 11.3605 12.8863 11.3605 12.9991V13.6625C11.5111 13.6698 11.6624 13.6824 11.8169 13.6824C14.6795 13.6824 17 12.4027 17 10.8219V9.6815ZM10.3661 11.0083C10.3648 12.5891 8.04558 13.8695 5.18306 13.8695C2.32849 13.8695 0.0132678 12.6031 0 11.0288V12.1486C0 13.7295 2.31987 15.0098 5.18306 15.0098C8.04624 15.0098 10.3661 13.7295 10.3661 12.1486V11.0083ZM10.3661 12.9984C10.3648 14.5793 8.04558 15.8596 5.18306 15.8596C2.32849 15.8596 0.0132678 14.5932 0 13.019V14.1388C0 15.7197 2.31987 17 5.18306 17C8.04624 17 10.3661 15.7197 10.3661 14.1388V12.9984Z"
                                                                                                        fill="white"/></svg>
                                                                                    </span>
                                                                                        <?= Loc::getMessage('PAY_T_COINS'); ?>

                                                                                    </button>
                                                                                    <button type="button"
                                                                                            onclick="countRiseBuy(<?= $arResult['ID'] ?>, $('#formProdactRise<?= $arResult['ID'] ?>'), <?= $arResult['IBLOCK_ID'] ?>)"


                                                                                            class="btn btn-primary btn-paid"><span
                                                                                                class="mr-2"><svg
                                                                                                    width="17"
                                                                                                    height="14"
                                                                                                    viewBox="0 0 17 14"
                                                                                                    fill="none"
                                                                                                    xmlns="http://www.w3.org/2000/svg">
<path d="M16.3929 0H0.607143C0.271317 0 0 0.284375 0 0.636364V3.81818H17V0.636364C17 0.284375 16.7287 0 16.3929 0ZM0 13.3636C0 13.7156 0.271317 14 0.607143 14H16.3929C16.7287 14 17 13.7156 17 13.3636V5.56818H0V13.3636ZM10.9855 9.70455C10.9855 9.61705 11.0538 9.54545 11.1373 9.54545H14.2679C14.3513 9.54545 14.4196 9.61705 14.4196 9.70455V11.1364C14.4196 11.2239 14.3513 11.2955 14.2679 11.2955H11.1373C11.0538 11.2955 10.9855 11.2239 10.9855 11.1364V9.70455Z"
      fill="white"/>
</svg>
</span> <?= Loc::getMessage('PAY_CARD'); ?>

                                                                                    </button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- VIP -->
                                                                <div class="promote-card">
                                                                    <!-- ID "headingVipItem" shold be UNIC for every product card -->
                                                                    <div class="card-header" id="headingVipItem">
                                                                        <!-- data-target="#vipItem" depend on "accordionUserItem<?= $arResult['ID'] ?>" -->
                                                                        <!-- aria-controls="vipItem" depend on "headingRiseItem" -->
                                                                        <button class="btn btn-link btn-block text-right collapsed"
                                                                                type="button" data-toggle="collapse"
                                                                                data-target="#vipItem<?= $arResult['ID'] ?>"
                                                                                aria-expanded="false"
                                                                                aria-controls="vipItem">
                                                                            <div class="pr-4 d-flex justify-content-between align-items-center">
                                                                                <span class="plus"></span>
                                                                                <span class="card-header__title"><?= Loc::getMessage('VIP_PAKET'); ?></span>

                                                                            </div>

                                                                            <span class="card-header__icon"><svg
                                                                                        width="22"
                                                                                        height="19"
                                                                                        viewBox="0 0 22 19"
                                                                                        fill="none"
                                                                                        xmlns="http://www.w3.org/2000/svg">
<path d="M1.58936 3.42876L5.88549 6.18822L10.1673 0.413067C10.2619 0.285313 10.3868 0.181179 10.5317 0.109331C10.6765 0.0374835 10.837 0 10.9999 0C11.1628 0 11.3234 0.0374835 11.4682 0.109331C11.613 0.181179 11.7379 0.285313 11.8326 0.413067L16.1144 6.18822L20.4105 3.42876C20.5731 3.32454 20.7633 3.26734 20.9585 3.26392C21.1538 3.2605 21.346 3.31101 21.5124 3.40947C21.6788 3.50793 21.8125 3.65023 21.8976 3.81956C21.9828 3.98888 22.0159 4.17815 21.9929 4.36501L20.3123 18.1298C20.283 18.3695 20.1634 18.5905 19.9762 18.7509C19.7889 18.9113 19.5471 19 19.2966 19H2.70328C2.45274 19 2.21093 18.9113 2.0237 18.7509C1.83648 18.5905 1.71687 18.3695 1.68755 18.1298L0.00694712 4.36402C-0.015761 4.17725 0.0174677 3.98811 0.102711 3.81895C0.187954 3.64978 0.321652 3.50764 0.488023 3.40931C0.654394 3.31098 0.846492 3.26056 1.04164 3.26401C1.23679 3.26745 1.42684 3.32462 1.58936 3.42876ZM10.9999 13.0869C11.5425 13.0869 12.0629 12.8792 12.4465 12.5096C12.8302 12.1399 13.0457 11.6386 13.0457 11.1158C13.0457 10.5931 12.8302 10.0917 12.4465 9.72209C12.0629 9.35245 11.5425 9.14479 10.9999 9.14479C10.4574 9.14479 9.93701 9.35245 9.55335 9.72209C9.16969 10.0917 8.95416 10.5931 8.95416 11.1158C8.95416 11.6386 9.16969 12.1399 9.55335 12.5096C9.93701 12.8792 10.4574 13.0869 10.9999 13.0869Z"
      fill="#F50000"/>
</svg>
</span>
                                                                        </button>
                                                                    </div>

                                                                    <!-- ID "vipItem" shold be UNIC for every product card -->
                                                                    <!-- aria-labelledby="headingVipItem" data-parent="#accordionUserItem<?= $arResult['ID'] ?>" -->
                                                                    <div id="vipItem<?= $arResult['ID'] ?>"
                                                                         class="collapse"
                                                                         aria-labelledby="headingVipItem"
                                                                         data-parent="#accordionUserItem<?= $arResult['ID'] ?>">
                                                                        <div class="p-3 bg-lightgray">
                                                                            <? $APPLICATION->IncludeComponent(
                                                                                "bitrix:main.include",
                                                                                "",
                                                                                array(
                                                                                    "AREA_FILE_SHOW" => "file",
                                                                                    "AREA_FILE_SUFFIX" => "inc",
                                                                                    "EDIT_TEMPLATE" => "",
                                                                                    "PATH" => "/include-area/up-vip-" . LANGUAGE_ID . ".php"
                                                                                )
                                                                            ); ?>

                                                                            <p class="mb-3 font-weight-bold content-subtitle">
                                                                                <?= Loc::getMessage('type_item') ?></p>
                                                                            <form id="formProdactVip2">
                                                                                <div class="mb-4 px-3 card">
                                                                                    <? foreach ($arTypesVip as $arRise) { ?>
                                                                                        <? if ($arRise['UF_COUNT'] > 0) { ?>
                                                                                            <div class="py-3 border-bottom d-flex justify-content-between">
                                                                                                <span class="font-weight-bold"><?= $arRise["UF_PRICE"] ?> T</span>


                                                                                                <label class="custom-radio-btn">
                                                                                                    <input type="radio"
                                                                                                           value="<?= $arRise["UF_COUNT"] ?>"
                                                                                                           data-price="<?= $arRise["UF_PRICE"] ?>"
                                                                                                           data-price-shek="<?= $arRise["UF_PRICE_SHEK"] ?>"
                                                                                                           name="riseProduct">
                                                                                                    <span><?= $arRise["UF_NAME"] ?></span>
                                                                                                    <span class="checkbox"></span>
                                                                                                </label>
                                                                                            </div>
                                                                                        <? }
                                                                                    } ?>
                                                                                </div>
                                                                            </form>

                                                                            <p class="mb-3 font-weight-bold content-subtitle">
                                                                                <?= Loc::getMessage('PAY_CHOISE'); ?>
                                                                                :</p>

                                                                            <div class="d-flex flex-column justify-content-end align-items-end">
                                                                                <button type="button"
                                                                                        onclick="countVipBuy(<?= $arResult['ID'] ?>, $('#formProdactVip2'), <?= $arResult['IBLOCK_ID'] ?>)"
                                                                                        data-toggle="modal"
                                                                                        data-target="#payTcoins"
                                                                                        class="mb-3 btn btn-primary btn-paid"><span
                                                                                            class="mr-2"><svg width="17"
                                                                                                              height="17"
                                                                                                              viewBox="0 0 17 17"
                                                                                                              fill="none"
                                                                                                              xmlns="http://www.w3.org/2000/svg"><path
                                                                                                    d="M11.8169 0.00066338C8.95442 0.00066338 6.63389 1.28034 6.63389 2.8612C6.63389 4.44205 8.95508 5.72239 11.8169 5.72239C14.6795 5.72239 17 4.44205 17 2.8612C17 1.28034 14.6788 0 11.8169 0V0.00066338ZM17 3.711C16.9987 5.29185 14.6795 6.57219 11.8169 6.57219C8.96238 6.57219 6.64716 5.30578 6.63389 3.73223V4.85136C6.63389 5.52669 7.06642 6.14497 7.77492 6.63455C8.49138 6.82959 9.12956 7.10025 9.66093 7.44256C10.3197 7.60973 11.0441 7.71189 11.8169 7.71189C14.6795 7.71189 17 6.43222 17 4.85136V3.711ZM17 5.70116C17 7.28202 14.6795 8.56236 11.8169 8.56236C11.4687 8.56236 11.1303 8.53649 10.8013 8.5C11.0609 8.84969 11.2381 9.25361 11.3194 9.6815C11.4846 9.69078 11.6478 9.70206 11.8169 9.70206C14.6795 9.70206 17 8.42238 17 6.84153V5.70116ZM5.18306 7.29728C2.32053 7.29728 0 8.57762 0 10.1585C0 11.7393 2.3212 13.0197 5.18306 13.0197C8.04558 13.0197 10.3661 11.7393 10.3661 10.1585C10.3661 8.57762 8.04492 7.29728 5.18306 7.29728ZM17 7.69133C16.9987 9.27219 14.6795 10.5525 11.8169 10.5525C11.6504 10.5525 11.4819 10.5406 11.3194 10.5313C11.3121 10.5811 11.3081 10.6474 11.2988 10.6971C11.332 10.7973 11.3605 10.8962 11.3605 11.0089V11.6723C11.5111 11.6796 11.6624 11.6922 11.8169 11.6922C14.6795 11.6922 17 10.4125 17 8.83169V7.69133ZM17 9.6815C16.9987 11.2624 14.6795 12.5427 11.8169 12.5427C11.6504 12.5427 11.4819 12.5308 11.3194 12.5215C11.3121 12.5712 11.3081 12.6376 11.2988 12.6873C11.332 12.7868 11.3605 12.8863 11.3605 12.9991V13.6625C11.5111 13.6698 11.6624 13.6824 11.8169 13.6824C14.6795 13.6824 17 12.4027 17 10.8219V9.6815ZM10.3661 11.0083C10.3648 12.5891 8.04558 13.8695 5.18306 13.8695C2.32849 13.8695 0.0132678 12.6031 0 11.0288V12.1486C0 13.7295 2.31987 15.0098 5.18306 15.0098C8.04624 15.0098 10.3661 13.7295 10.3661 12.1486V11.0083ZM10.3661 12.9984C10.3648 14.5793 8.04558 15.8596 5.18306 15.8596C2.32849 15.8596 0.0132678 14.5932 0 13.019V14.1388C0 15.7197 2.31987 17 5.18306 17C8.04624 17 10.3661 15.7197 10.3661 14.1388V12.9984Z"
                                                                                                    fill="white"/></svg>
                                                                                    </span>
                                                                                    <?= Loc::getMessage('PAY_T_COINS'); ?>

                                                                                </button>
                                                                                <button type="button"
                                                                                        onclick="countVipBuyShek(<?= $arResult['ID'] ?>, $('#formProdactVip2'), <?= $arResult['IBLOCK_ID'] ?>)"

                                                                                        class="btn btn-primary btn-paid"><span
                                                                                            class="mr-2"><svg width="17"
                                                                                                              height="14"
                                                                                                              viewBox="0 0 17 14"
                                                                                                              fill="none"
                                                                                                              xmlns="http://www.w3.org/2000/svg">
<path d="M16.3929 0H0.607143C0.271317 0 0 0.284375 0 0.636364V3.81818H17V0.636364C17 0.284375 16.7287 0 16.3929 0ZM0 13.3636C0 13.7156 0.271317 14 0.607143 14H16.3929C16.7287 14 17 13.7156 17 13.3636V5.56818H0V13.3636ZM10.9855 9.70455C10.9855 9.61705 11.0538 9.54545 11.1373 9.54545H14.2679C14.3513 9.54545 14.4196 9.61705 14.4196 9.70455V11.1364C14.4196 11.2239 14.3513 11.2955 14.2679 11.2955H11.1373C11.0538 11.2955 10.9855 11.2239 10.9855 11.1364V9.70455Z"
      fill="white"/>
</svg>
</span> <?= Loc::getMessage('PAY_CARD'); ?>

                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- COLOUR -->
                                                                <div class="promote-card">
                                                                    <!-- ID "headingSelectColorItem" shold be UNIC for every product card -->
                                                                    <div class="card-header"
                                                                         id="headingSelectColorItem">
                                                                        <!-- Change for every button "data-target", "aria-controls" data value "#ID under section"-->
                                                                        <button class="btn btn-link btn-block text-right collapsed"
                                                                                type="button" data-toggle="collapse"
                                                                                data-target="#selectColorItem<?= $arResult['ID'] ?>"
                                                                                aria-expanded="false"
                                                                                aria-controls="selectColorItem">
                                                                            <div class="pr-4 d-flex justify-content-between align-items-center">
                                                                                <span class="plus"></span>
                                                                                <span class="card-header__title"><?= Loc::getMessage('COLOUR_PAKET'); ?></span>

                                                                            </div>
                                                                            <span class="card-header__icon"><svg
                                                                                        width="16"
                                                                                        height="17"
                                                                                        viewBox="0 0 16 17"
                                                                                        fill="none"
                                                                                        xmlns="http://www.w3.org/2000/svg">
<path d="M8.20189 0.934761C8.20189 0.779763 8.14032 0.631114 8.03072 0.521514C7.92112 0.411914 7.77247 0.350342 7.61747 0.350342C7.46247 0.350342 7.31382 0.411914 7.20422 0.521514C7.09462 0.631114 7.03305 0.779763 7.03305 0.934761V1.90879C6.78643 1.99564 6.56248 2.13677 6.37772 2.32178L1.01743 7.68285C0.854624 7.84566 0.725478 8.03894 0.637367 8.25165C0.549256 8.46437 0.503906 8.69236 0.503906 8.9226C0.503906 9.15284 0.549256 9.38083 0.637367 9.59355C0.725478 9.80626 0.854624 9.99954 1.01743 10.1623L4.82005 13.9634C4.98286 14.1262 5.17613 14.2554 5.38885 14.3435C5.60157 14.4316 5.82956 14.4769 6.0598 14.4769C6.29004 14.4769 6.51803 14.4316 6.73075 14.3435C6.94346 14.2554 7.13674 14.1262 7.29955 13.9634L12.6598 8.60312C12.8226 8.44031 12.9518 8.24703 13.0399 8.03432C13.128 7.8216 13.1734 7.59361 13.1734 7.36337C13.1734 7.13313 13.128 6.90514 13.0399 6.69242C12.9518 6.47971 12.8226 6.28643 12.6598 6.12362L8.85644 2.32178C8.67191 2.13687 8.44823 1.99574 8.20189 1.90879V0.934761ZM7.03305 3.31919V4.44127C7.03305 4.59627 7.09462 4.74492 7.20422 4.85452C7.31382 4.96412 7.46247 5.02569 7.61747 5.02569C7.77247 5.02569 7.92112 4.96412 8.03072 4.85452C8.14032 4.74492 8.20189 4.59627 8.20189 4.44127V3.31919L11.8323 6.95038C11.9417 7.05996 12.0032 7.2085 12.0032 7.36337C12.0032 7.51824 11.9417 7.66678 11.8323 7.77636L11.0765 8.53221H1.82159L1.84419 8.50883L7.03305 3.31919Z"
      fill="#6633F5"/>
<path d="M14.063 9.78046C14.0049 9.67162 13.9183 9.5806 13.8125 9.51714C13.7067 9.45369 13.5856 9.42017 13.4622 9.42017C13.3388 9.42017 13.2177 9.45369 13.1119 9.51714C13.0061 9.5806 12.9195 9.67162 12.8614 9.78046L11.2967 12.715C10.4232 14.3498 11.6092 16.3244 13.4622 16.3244C15.3152 16.3244 16.4996 14.3498 15.6284 12.715L14.063 9.78046Z"
      fill="#6633F5"/>
</svg></span>

                                                                        </button>
                                                                    </div>

                                                                    <!-- ID "selectColorItem" shold be UNIC for every product card -->
                                                                    <!-- data-parent = MAIN ID data-parent="#accordionUserItem<?= $arResult['ID'] ?>" -->
                                                                    <div id="selectColorItem<?= $arResult['ID'] ?>"
                                                                         class="collapse"
                                                                         aria-labelledby="headingSelectColorItem"
                                                                         data-parent="#accordionUserItem<?= $arResult['ID'] ?>">
                                                                        <div class="p-3 bg-lightgray">
                                                                            <? $APPLICATION->IncludeComponent(
                                                                                "bitrix:main.include",
                                                                                "",
                                                                                array(
                                                                                    "AREA_FILE_SHOW" => "file",
                                                                                    "AREA_FILE_SUFFIX" => "inc",
                                                                                    "EDIT_TEMPLATE" => "",
                                                                                    "PATH" => "/include-area/up-colour-" . LANGUAGE_ID . ".php"
                                                                                )
                                                                            ); ?>

                                                                            <p class="mb-3 font-weight-bold content-subtitle">
                                                                                <?= Loc::getMessage('type_item') ?></p>
                                                                            <form id="formProdactColour2">
                                                                                <div class="mb-4 px-3 card">
                                                                                    <? foreach ($arTypesColour as $arRise) { ?>
                                                                                        <? if ($arRise['UF_COUNT'] > 0) { ?>
                                                                                            <div class="py-3 border-bottom d-flex justify-content-between">
                                                                                                <span class="font-weight-bold"><?= $arRise["UF_PRICE"] ?> T</span>


                                                                                                <label class="custom-radio-btn">
                                                                                                    <input type="radio"
                                                                                                           value="<?= $arRise["UF_COUNT"] ?>"
                                                                                                           data-price="<?= $arRise["UF_PRICE"] ?>"
                                                                                                           data-price-shek="<?= $arRise["UF_PRICE_SHEK"] ?>"
                                                                                                           name="riseProduct">
                                                                                                    <span><?= $arRise["UF_NAME"] ?></span>
                                                                                                    <span class="checkbox"></span>
                                                                                                </label>
                                                                                            </div>
                                                                                        <? }
                                                                                    } ?></div>
                                                                            </form>

                                                                            <p class="mb-3 font-weight-bold content-subtitle">
                                                                                <?= Loc::getMessage('PAY_CHOISE'); ?>
                                                                                :</p>

                                                                            <div class="d-flex flex-column justify-content-end align-items-end">
                                                                                <button type="button"
                                                                                        onclick="countColourBuy(<?= $arResult['ID'] ?>, $('#formProdactColour2'), <?= $arResult['IBLOCK_ID'] ?>)"
                                                                                        data-toggle="modal"
                                                                                        data-target="#payTcoins"
                                                                                        class="mb-3 btn btn-primary btn-paid"><span
                                                                                            class="mr-2"><svg width="17"
                                                                                                              height="17"
                                                                                                              viewBox="0 0 17 17"
                                                                                                              fill="none"
                                                                                                              xmlns="http://www.w3.org/2000/svg"><path
                                                                                                    d="M11.8169 0.00066338C8.95442 0.00066338 6.63389 1.28034 6.63389 2.8612C6.63389 4.44205 8.95508 5.72239 11.8169 5.72239C14.6795 5.72239 17 4.44205 17 2.8612C17 1.28034 14.6788 0 11.8169 0V0.00066338ZM17 3.711C16.9987 5.29185 14.6795 6.57219 11.8169 6.57219C8.96238 6.57219 6.64716 5.30578 6.63389 3.73223V4.85136C6.63389 5.52669 7.06642 6.14497 7.77492 6.63455C8.49138 6.82959 9.12956 7.10025 9.66093 7.44256C10.3197 7.60973 11.0441 7.71189 11.8169 7.71189C14.6795 7.71189 17 6.43222 17 4.85136V3.711ZM17 5.70116C17 7.28202 14.6795 8.56236 11.8169 8.56236C11.4687 8.56236 11.1303 8.53649 10.8013 8.5C11.0609 8.84969 11.2381 9.25361 11.3194 9.6815C11.4846 9.69078 11.6478 9.70206 11.8169 9.70206C14.6795 9.70206 17 8.42238 17 6.84153V5.70116ZM5.18306 7.29728C2.32053 7.29728 0 8.57762 0 10.1585C0 11.7393 2.3212 13.0197 5.18306 13.0197C8.04558 13.0197 10.3661 11.7393 10.3661 10.1585C10.3661 8.57762 8.04492 7.29728 5.18306 7.29728ZM17 7.69133C16.9987 9.27219 14.6795 10.5525 11.8169 10.5525C11.6504 10.5525 11.4819 10.5406 11.3194 10.5313C11.3121 10.5811 11.3081 10.6474 11.2988 10.6971C11.332 10.7973 11.3605 10.8962 11.3605 11.0089V11.6723C11.5111 11.6796 11.6624 11.6922 11.8169 11.6922C14.6795 11.6922 17 10.4125 17 8.83169V7.69133ZM17 9.6815C16.9987 11.2624 14.6795 12.5427 11.8169 12.5427C11.6504 12.5427 11.4819 12.5308 11.3194 12.5215C11.3121 12.5712 11.3081 12.6376 11.2988 12.6873C11.332 12.7868 11.3605 12.8863 11.3605 12.9991V13.6625C11.5111 13.6698 11.6624 13.6824 11.8169 13.6824C14.6795 13.6824 17 12.4027 17 10.8219V9.6815ZM10.3661 11.0083C10.3648 12.5891 8.04558 13.8695 5.18306 13.8695C2.32849 13.8695 0.0132678 12.6031 0 11.0288V12.1486C0 13.7295 2.31987 15.0098 5.18306 15.0098C8.04624 15.0098 10.3661 13.7295 10.3661 12.1486V11.0083ZM10.3661 12.9984C10.3648 14.5793 8.04558 15.8596 5.18306 15.8596C2.32849 15.8596 0.0132678 14.5932 0 13.019V14.1388C0 15.7197 2.31987 17 5.18306 17C8.04624 17 10.3661 15.7197 10.3661 14.1388V12.9984Z"
                                                                                                    fill="white"/></svg>
                                                                                    </span>
                                                                                    <?= Loc::getMessage('PAY_T_COINS'); ?>

                                                                                </button>
                                                                                <button type="button"
                                                                                        onclick="countColourBuyShek(<?= $arResult['ID'] ?>, $('#formProdactColour2'), <?= $arResult['IBLOCK_ID'] ?>)"
                                                                                        class="btn btn-primary btn-paid"><span
                                                                                            class="mr-2"><svg width="17"
                                                                                                              height="14"
                                                                                                              viewBox="0 0 17 14"
                                                                                                              fill="none"
                                                                                                              xmlns="http://www.w3.org/2000/svg">
<path d="M16.3929 0H0.607143C0.271317 0 0 0.284375 0 0.636364V3.81818H17V0.636364C17 0.284375 16.7287 0 16.3929 0ZM0 13.3636C0 13.7156 0.271317 14 0.607143 14H16.3929C16.7287 14 17 13.7156 17 13.3636V5.56818H0V13.3636ZM10.9855 9.70455C10.9855 9.61705 11.0538 9.54545 11.1373 9.54545H14.2679C14.3513 9.54545 14.4196 9.61705 14.4196 9.70455V11.1364C14.4196 11.2239 14.3513 11.2955 14.2679 11.2955H11.1373C11.0538 11.2955 10.9855 11.2239 10.9855 11.1364V9.70455Z"
      fill="white"/>
</svg>
</span> <?= Loc::getMessage('PAY_CARD'); ?>

                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="promote-card">
                                                                    <!-- ID "headingSelectRiddonItem" shold be UNIC for every product card -->
                                                                    <div class="card-header"
                                                                         id="headingSelectRiddonItem">
                                                                        <!-- data-target="#selectRiddonItem" depend on "accordionUserItem<?= $arResult['ID'] ?>" -->
                                                                        <!-- aria-controls="selectRiddonItem" depend on "headingRiseItem" -->
                                                                        <button class="btn btn-link btn-block text-right collapsed"
                                                                                type="button" data-toggle="collapse"
                                                                                data-target="#selectRiddonItem<?= $arResult['ID'] ?>"
                                                                                aria-expanded="false"
                                                                                aria-controls="selectRiddonItem">
                                                                            <div class="pr-4 d-flex justify-content-between align-items-center">
                                                                                <span class="plus"></span>
                                                                                <span class="card-header__title"><?= Loc::getMessage('LENT_PAKET'); ?></span>

                                                                            </div>

                                                                            <span class="card-header__icon"><svg
                                                                                        width="16"
                                                                                        height="16"
                                                                                        viewBox="0 0 16 16"
                                                                                        fill="none"
                                                                                        xmlns="http://www.w3.org/2000/svg">
<rect width="9.40476" height="6.83184" rx="0.5"
      transform="matrix(0.977206 -0.212292 0.118541 0.992949 0.503906 9.04102)" fill="#FB2BFF"/>
<rect width="10.4788" height="6.83184" rx="0.5" transform="matrix(0.977206 -0.212292 0.118541 0.992949 4.87109 3.15161)"
      fill="#FB2BFF"/>
<path d="M5.58984 9.95654L9.93666 9.01223L10.4706 13.4847L5.58984 9.95654Z" fill="#961299"/>
</svg>
</span>
                                                                        </button>
                                                                    </div>

                                                                    <!-- ID "selectRiddonItem" shold be UNIC for every product card -->
                                                                    <!-- aria-labelledby="headingSelectRiddonItem" data-parent="#accordionUserItem<?= $arResult['ID'] ?>" -->
                                                                    <div id="selectRiddonItem<?= $arResult['ID'] ?>"
                                                                         class="collapse"
                                                                         aria-labelledby="headingSelectRiddonItem"
                                                                         data-parent="#accordionUserItem<?= $arResult['ID'] ?>">
                                                                        <div class="p-3 bg-lightgray">
                                                                            <? $APPLICATION->IncludeComponent(
                                                                                "bitrix:main.include",
                                                                                "",
                                                                                array(
                                                                                    "AREA_FILE_SHOW" => "file",
                                                                                    "AREA_FILE_SUFFIX" => "inc",
                                                                                    "EDIT_TEMPLATE" => "",
                                                                                    "PATH" => "/include-area/up-lent-" . LANGUAGE_ID . ".php"
                                                                                )
                                                                            ); ?>

                                                                            <p class="mb-3 font-weight-bold content-subtitle">
                                                                                <?= Loc::getMessage('type_item') ?></p>
                                                                            <form id="formProdactLent2">
                                                                                <div class="mb-4 px-3 card">
                                                                                    <? foreach ($arTypesLent as $arRise) { ?>
                                                                                        <? if ($arRise['UF_COUNT'] > 0) { ?>
                                                                                            <div class="py-3 border-bottom d-flex justify-content-between">
                                                                                                <span class="font-weight-bold"><?= $arRise["UF_PRICE"] ?> T</span>

                                                                                                <label class="custom-radio-btn">
                                                                                                    <input type="radio"
                                                                                                           value="<?= $arRise["UF_COUNT"] ?>"
                                                                                                           data-price="<?= $arRise["UF_PRICE"] ?>"
                                                                                                           data-price-shek="<?= $arRise["UF_PRICE_SHEK"] ?>"
                                                                                                           data-xml-id="<?= $arRise["UF_XML_ID_LENT"] ?>"
                                                                                                           name="riseProduct">
                                                                                                    <div class="d-flex marker">
                                                                                                        <div class="d-flex flex-column decor-rec"
                                                                                                             style="border-color: #<?= $arRise["UF_COLOUR"] ?>;">
                                                                                                            <div class="rec-top"></div>
                                                                                                            <div class="rec-bottom"></div>
                                                                                                        </div>

                                                                                                        <div class="text"
                                                                                                             style="background-color: #<?= $arRise["UF_COLOUR"] ?>;">
                                                                                                            <?= $arRise["UF_NAME"] ?>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <span class="checkbox"></span>
                                                                                                </label>
                                                                                            </div>
                                                                                        <? }
                                                                                    } ?>
                                                                                </div>
                                                                            </form>
                                                                            <p class="mb-3 font-weight-bold content-subtitle">
                                                                                <?= Loc::getMessage('PAY_CHOISE'); ?>
                                                                                :</p>

                                                                            <div class="d-flex flex-column justify-content-end align-items-end">
                                                                                <button type="button"
                                                                                        onclick="countLentaBuy(<?= $arResult['ID'] ?>, $('#formProdactLent2'), <?= $arResult['IBLOCK_ID'] ?>)"
                                                                                        data-toggle="modal"
                                                                                        data-target="#payTcoins"
                                                                                        class="mb-3 btn btn-primary btn-paid"><span
                                                                                            class="mr-2"><svg width="17"
                                                                                                              height="17"
                                                                                                              viewBox="0 0 17 17"
                                                                                                              fill="none"
                                                                                                              xmlns="http://www.w3.org/2000/svg"><path
                                                                                                    d="M11.8169 0.00066338C8.95442 0.00066338 6.63389 1.28034 6.63389 2.8612C6.63389 4.44205 8.95508 5.72239 11.8169 5.72239C14.6795 5.72239 17 4.44205 17 2.8612C17 1.28034 14.6788 0 11.8169 0V0.00066338ZM17 3.711C16.9987 5.29185 14.6795 6.57219 11.8169 6.57219C8.96238 6.57219 6.64716 5.30578 6.63389 3.73223V4.85136C6.63389 5.52669 7.06642 6.14497 7.77492 6.63455C8.49138 6.82959 9.12956 7.10025 9.66093 7.44256C10.3197 7.60973 11.0441 7.71189 11.8169 7.71189C14.6795 7.71189 17 6.43222 17 4.85136V3.711ZM17 5.70116C17 7.28202 14.6795 8.56236 11.8169 8.56236C11.4687 8.56236 11.1303 8.53649 10.8013 8.5C11.0609 8.84969 11.2381 9.25361 11.3194 9.6815C11.4846 9.69078 11.6478 9.70206 11.8169 9.70206C14.6795 9.70206 17 8.42238 17 6.84153V5.70116ZM5.18306 7.29728C2.32053 7.29728 0 8.57762 0 10.1585C0 11.7393 2.3212 13.0197 5.18306 13.0197C8.04558 13.0197 10.3661 11.7393 10.3661 10.1585C10.3661 8.57762 8.04492 7.29728 5.18306 7.29728ZM17 7.69133C16.9987 9.27219 14.6795 10.5525 11.8169 10.5525C11.6504 10.5525 11.4819 10.5406 11.3194 10.5313C11.3121 10.5811 11.3081 10.6474 11.2988 10.6971C11.332 10.7973 11.3605 10.8962 11.3605 11.0089V11.6723C11.5111 11.6796 11.6624 11.6922 11.8169 11.6922C14.6795 11.6922 17 10.4125 17 8.83169V7.69133ZM17 9.6815C16.9987 11.2624 14.6795 12.5427 11.8169 12.5427C11.6504 12.5427 11.4819 12.5308 11.3194 12.5215C11.3121 12.5712 11.3081 12.6376 11.2988 12.6873C11.332 12.7868 11.3605 12.8863 11.3605 12.9991V13.6625C11.5111 13.6698 11.6624 13.6824 11.8169 13.6824C14.6795 13.6824 17 12.4027 17 10.8219V9.6815ZM10.3661 11.0083C10.3648 12.5891 8.04558 13.8695 5.18306 13.8695C2.32849 13.8695 0.0132678 12.6031 0 11.0288V12.1486C0 13.7295 2.31987 15.0098 5.18306 15.0098C8.04624 15.0098 10.3661 13.7295 10.3661 12.1486V11.0083ZM10.3661 12.9984C10.3648 14.5793 8.04558 15.8596 5.18306 15.8596C2.32849 15.8596 0.0132678 14.5932 0 13.019V14.1388C0 15.7197 2.31987 17 5.18306 17C8.04624 17 10.3661 15.7197 10.3661 14.1388V12.9984Z"
                                                                                                    fill="white"/></svg>
                                                                                    </span>
                                                                                    <?= Loc::getMessage('PAY_T_COINS'); ?>

                                                                                </button>
                                                                                <button type="button"
                                                                                        onclick="countLentaBuyShek(<?= $arResult['ID'] ?>, $('#formProdactLent2'), <?= $arResult['IBLOCK_ID'] ?>)"

                                                                                        class="btn btn-primary btn-paid"><span
                                                                                            class="mr-2"><svg width="17"
                                                                                                              height="14"
                                                                                                              viewBox="0 0 17 14"
                                                                                                              fill="none"
                                                                                                              xmlns="http://www.w3.org/2000/svg">
<path d="M16.3929 0H0.607143C0.271317 0 0 0.284375 0 0.636364V3.81818H17V0.636364C17 0.284375 16.7287 0 16.3929 0ZM0 13.3636C0 13.7156 0.271317 14 0.607143 14H16.3929C16.7287 14 17 13.7156 17 13.3636V5.56818H0V13.3636ZM10.9855 9.70455C10.9855 9.61705 11.0538 9.54545 11.1373 9.54545H14.2679C14.3513 9.54545 14.4196 9.61705 14.4196 9.70455V11.1364C14.4196 11.2239 14.3513 11.2955 14.2679 11.2955H11.1373C11.0538 11.2955 10.9855 11.2239 10.9855 11.1364V9.70455Z"
      fill="white"/>
</svg>
</span> <?= Loc::getMessage('PAY_CARD'); ?>

                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="promote-card">
                                                                    <!-- ID "headingBustPack" shold be UNIC for every product card -->
                                                                    <div class="card-header" id="headingBustPack">
                                                                        <!-- Change for every button "data-target", "aria-controls" data value "#ID under section"-->
                                                                        <button class="btn btn-link btn-block text-right collapsed"
                                                                                type="button" data-toggle="collapse"
                                                                                data-target="#bustPack<?= $arResult['ID'] ?>"
                                                                                aria-expanded="false"
                                                                                aria-controls="bustPack">
                                                                            <div class="pr-4 d-flex justify-content-between align-items-center">
                                                                                <span class="plus"></span>
                                                                                <span class="card-header__title"><?= Loc::getMessage('UP_COMPLEX'); ?></span>

                                                                            </div>
                                                                            <span class="card-header__icon"><svg
                                                                                        width="16"
                                                                                        height="18"
                                                                                        viewBox="0 0 16 18"
                                                                                        fill="none"
                                                                                        xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd"
      d="M10.7811 0.968714C10.7811 0.792056 10.7264 0.619732 10.6246 0.475353C10.5228 0.330975 10.3789 0.221608 10.2125 0.16224C10.0461 0.102871 9.86545 0.0964054 9.69525 0.143729C9.52505 0.191053 9.37365 0.289851 9.26179 0.426584L0.697334 9.84749C0.594729 9.97297 0.529841 10.125 0.510211 10.2859C0.49058 10.4468 0.517013 10.61 0.586437 10.7564C0.655861 10.9029 0.765426 11.0267 0.902399 11.1133C1.03937 11.2 1.19813 11.246 1.36022 11.2461H5.64245V16.3847C5.64248 16.5614 5.69714 16.7337 5.79894 16.8781C5.90074 17.0225 6.04469 17.1318 6.21107 17.1912C6.37746 17.2506 6.55813 17.257 6.72833 17.2097C6.89853 17.1624 7.04993 17.0636 7.16179 16.9269L15.7262 7.50596C15.8288 7.38048 15.8937 7.22845 15.9134 7.06755C15.933 6.90666 15.9066 6.74349 15.8371 6.59702C15.7677 6.45054 15.6582 6.32678 15.5212 6.24011C15.3842 6.15343 15.2254 6.10741 15.0634 6.10739H10.7811V0.968714Z"
      fill="#FF6B00"/>
</svg>
</span>
                                                                        </button>
                                                                    </div>

                                                                    <div id="bustPack<?= $arResult['ID'] ?>"
                                                                         class="collapse"
                                                                         aria-labelledby="headingBustPack"
                                                                         data-parent="#accordionUserItem<?= $arResult['ID'] ?>">
                                                                        <div class="p-3 bg-lightgray">
                                                                            <? $APPLICATION->IncludeComponent(
                                                                                "bitrix:main.include",
                                                                                "",
                                                                                array(
                                                                                    "AREA_FILE_SHOW" => "file",
                                                                                    "AREA_FILE_SUFFIX" => "inc",
                                                                                    "EDIT_TEMPLATE" => "",
                                                                                    "PATH" => "/include-area/up-paket-" . LANGUAGE_ID . ".php"
                                                                                )
                                                                            ); ?>

                                                                            <p class="mb-3 font-weight-bold content-subtitle">
                                                                                <?= Loc::getMessage('type_item') ?></p>

                                                                            <form id="formProdactPaket2">
                                                                                <div class="mb-4 px-3 card"
                                                                                     id="accordionSection<?= $arResult['ID'] ?>">
                                                                                    <? foreach ($arTypesPaket as $arRise) { ?>
                                                                                        <? if ($arRise['UF_PRICE'] > 0) { ?>
                                                                                            <div class="py-3 border-bottom d-flex justify-content-between"
                                                                                                 id="tipe1">
                                                                                                <span class="font-weight-bold"><?= $arRise['UF_PRICE'] ?> T</span>

                                                                                                <label class="custom-radio-btn">
                                                                                                    <!-- Change for every button "data-target", "aria-controls" data value "#ID under section"-->
                                                                                                    <input type="radio"
                                                                                                           value="<?= $arRise["ID"] ?>"
                                                                                                           data-price="<?= $arRise["UF_PRICE"] ?>"
                                                                                                           data-UF_RISE_COUNT="<?= $arRise["UF_RISE_COUNT"] ?>"
                                                                                                           data-UF_RISE_DAY="<?= $arRise["UF_RISE_DAY"] ?>"
                                                                                                           data-UF_LENTA="<?= $arRise["UF_LENTA"] ?>"
                                                                                                           data-UF_VIP="<?= $arRise["UF_VIP"] ?>"
                                                                                                           data-UF_COLOUR="<?= $arRise["UF_COLOUR"] ?>"
                                                                                                           data-UF_XML_ID_LENT="<?= $arRise["UF_XML_ID_LENT"] ?>"

                                                                                                           data-price-shek="<?= $arRise["UF_PRICE_SHEK"] ?>"
                                                                                                           name="riseProduct"
                                                                                                           data-toggle="collapse"
                                                                                                           data-target="#collapsePaket<?= $arResult['ID'] . $arRise['ID'] ?>"
                                                                                                           aria-expanded="true"

                                                                                                           aria-controls="collapseOne">
                                                                                                    <span><?= $arRise['UF_NAME'] ?></span>
                                                                                                    <span class="checkbox"></span>
                                                                                                </label>
                                                                                            </div>

                                                                                            <div id="collapsePaket<?= $arResult['ID'] . $arRise['ID'] ?>"
                                                                                                 class="collapse"
                                                                                                 aria-labelledby="tipe1"
                                                                                                 data-parent="#accordionSection<?= $arResult['ID'] ?>">
                                                                                                <div class="p-3 d-flex flex-column new-collapse">
                                                                                                    <p class="mb-4 text-uppercase font-weight-bold">
                                                                                                        <?= $arRise['UF_BIG_TEXT1'] ?>
                                                                                                    </p>

                                                                                                    <p class="text-right">
                                                                                                        <?= $arRise['UF_STANDART_TEXT'] ?>
                                                                                                    </p>

                                                                                                    <div class="d-flex position-relative justify-content-end pr-5">
                                                                                                        <p class="text-right"><?= $arRise['UF_RISE_DAY'] ?>
                                                                                                            поднятие
                                                                                                            в
                                                                                                            день - на
                                                                                                            <span
                                                                                                                    class="font-weight-bold"><?= $arRise['UF_RISE_COUNT'] ?></span>
                                                                                                            дней <span
                                                                                                                    class="font-weight-bold">(первое - завтра)</span>
                                                                                                        </p>

                                                                                                        <div class="circle-icon">
                                                                                                            <div class="d-flex justify-content-center align-items-center user-product__up-product">
                                                                                                <span data-id="<?= $arResult['ID'] ?>"
                                                                                                      class="text-uppercase font-weight-bold upRise">UP</span>

                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>

                                                                                                    <div class="d-flex position-relative justify-content-end pr-5">
                                                                                                        <p class="text-right">
                                                                                                            Выделение
                                                                                                            - на
                                                                                                            <span class="font-weight-bold"><?= $arRise['UF_LENTA'] ?></span>
                                                                                                            дней</p>

                                                                                                        <div class="circle-icon">
                                                                                                            <svg width="16"
                                                                                                                 height="16"
                                                                                                                 viewBox="0 0 16 16"
                                                                                                                 fill="none"
                                                                                                                 xmlns="http://www.w3.org/2000/svg">
                                                                                                                <rect width="9.40476"
                                                                                                                      height="6.83184"
                                                                                                                      rx="0.5"
                                                                                                                      transform="matrix(0.977206 -0.212292 0.118541 0.992949 0.503906 9.04102)"
                                                                                                                      fill="#FB2BFF"/>
                                                                                                                <rect width="10.4788"
                                                                                                                      height="6.83184"
                                                                                                                      rx="0.5"
                                                                                                                      transform="matrix(0.977206 -0.212292 0.118541 0.992949 4.87109 3.15161)"
                                                                                                                      fill="#FB2BFF"/>
                                                                                                                <path d="M5.58984 9.95654L9.93666 9.01223L10.4706 13.4847L5.58984 9.95654Z"
                                                                                                                      fill="#961299"/>
                                                                                                            </svg>

                                                                                                        </div>
                                                                                                    </div>

                                                                                                    <div class="d-flex position-relative justify-content-end pr-5">
                                                                                                        <p class="text-right">
                                                                                                            VIP -
                                                                                                            закрепление
                                                                                                            - на <span
                                                                                                                    class="font-weight-bold"><?= $arRise['UF_VIP'] ?></span>
                                                                                                            дня</p>

                                                                                                        <div class="circle-icon">
                                                                                                            <svg width="22"
                                                                                                                 height="19"
                                                                                                                 viewBox="0 0 22 19"
                                                                                                                 fill="none"
                                                                                                                 xmlns="http://www.w3.org/2000/svg">
                                                                                                                <path d="M1.58936 3.42876L5.88549 6.18822L10.1673 0.413067C10.2619 0.285313 10.3868 0.181179 10.5317 0.109331C10.6765 0.0374835 10.837 0 10.9999 0C11.1628 0 11.3234 0.0374835 11.4682 0.109331C11.613 0.181179 11.7379 0.285313 11.8326 0.413067L16.1144 6.18822L20.4105 3.42876C20.5731 3.32454 20.7633 3.26734 20.9585 3.26392C21.1538 3.2605 21.346 3.31101 21.5124 3.40947C21.6788 3.50793 21.8125 3.65023 21.8976 3.81956C21.9828 3.98888 22.0159 4.17815 21.9929 4.36501L20.3123 18.1298C20.283 18.3695 20.1634 18.5905 19.9762 18.7509C19.7889 18.9113 19.5471 19 19.2966 19H2.70328C2.45274 19 2.21093 18.9113 2.0237 18.7509C1.83648 18.5905 1.71687 18.3695 1.68755 18.1298L0.00694712 4.36402C-0.015761 4.17725 0.0174677 3.98811 0.102711 3.81895C0.187954 3.64978 0.321652 3.50764 0.488023 3.40931C0.654394 3.31098 0.846492 3.26056 1.04164 3.26401C1.23679 3.26745 1.42684 3.32462 1.58936 3.42876ZM10.9999 13.0869C11.5425 13.0869 12.0629 12.8792 12.4465 12.5096C12.8302 12.1399 13.0457 11.6386 13.0457 11.1158C13.0457 10.5931 12.8302 10.0917 12.4465 9.72209C12.0629 9.35245 11.5425 9.14479 10.9999 9.14479C10.4574 9.14479 9.93701 9.35245 9.55335 9.72209C9.16969 10.0917 8.95416 10.5931 8.95416 11.1158C8.95416 11.6386 9.16969 12.1399 9.55335 12.5096C9.93701 12.8792 10.4574 13.0869 10.9999 13.0869Z"
                                                                                                                      fill="#F50000"/>
                                                                                                            </svg>

                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        <? }
                                                                                    } ?>
                                                                                </div>
                                                                            </form>

                                                                            <p class="mb-3 font-weight-bold content-subtitle">
                                                                                <?= Loc::getMessage('PAY_CHOISE'); ?>
                                                                                :</p>

                                                                            <div class="d-flex flex-column justify-content-end align-items-end">
                                                                                <button type="button"
                                                                                        onclick="countPaketBuy(<?= $arResult['ID'] ?>, $('#formProdactPaket2'), <?= $arResult['IBLOCK_ID'] ?>)"
                                                                                        data-toggle="modal"
                                                                                        data-target="#payTcoins"
                                                                                        class="mb-3 btn btn-primary btn-paid"><span
                                                                                            class="mr-2"><svg width="17"
                                                                                                              height="17"
                                                                                                              viewBox="0 0 17 17"
                                                                                                              fill="none"
                                                                                                              xmlns="http://www.w3.org/2000/svg"><path
                                                                                                    d="M11.8169 0.00066338C8.95442 0.00066338 6.63389 1.28034 6.63389 2.8612C6.63389 4.44205 8.95508 5.72239 11.8169 5.72239C14.6795 5.72239 17 4.44205 17 2.8612C17 1.28034 14.6788 0 11.8169 0V0.00066338ZM17 3.711C16.9987 5.29185 14.6795 6.57219 11.8169 6.57219C8.96238 6.57219 6.64716 5.30578 6.63389 3.73223V4.85136C6.63389 5.52669 7.06642 6.14497 7.77492 6.63455C8.49138 6.82959 9.12956 7.10025 9.66093 7.44256C10.3197 7.60973 11.0441 7.71189 11.8169 7.71189C14.6795 7.71189 17 6.43222 17 4.85136V3.711ZM17 5.70116C17 7.28202 14.6795 8.56236 11.8169 8.56236C11.4687 8.56236 11.1303 8.53649 10.8013 8.5C11.0609 8.84969 11.2381 9.25361 11.3194 9.6815C11.4846 9.69078 11.6478 9.70206 11.8169 9.70206C14.6795 9.70206 17 8.42238 17 6.84153V5.70116ZM5.18306 7.29728C2.32053 7.29728 0 8.57762 0 10.1585C0 11.7393 2.3212 13.0197 5.18306 13.0197C8.04558 13.0197 10.3661 11.7393 10.3661 10.1585C10.3661 8.57762 8.04492 7.29728 5.18306 7.29728ZM17 7.69133C16.9987 9.27219 14.6795 10.5525 11.8169 10.5525C11.6504 10.5525 11.4819 10.5406 11.3194 10.5313C11.3121 10.5811 11.3081 10.6474 11.2988 10.6971C11.332 10.7973 11.3605 10.8962 11.3605 11.0089V11.6723C11.5111 11.6796 11.6624 11.6922 11.8169 11.6922C14.6795 11.6922 17 10.4125 17 8.83169V7.69133ZM17 9.6815C16.9987 11.2624 14.6795 12.5427 11.8169 12.5427C11.6504 12.5427 11.4819 12.5308 11.3194 12.5215C11.3121 12.5712 11.3081 12.6376 11.2988 12.6873C11.332 12.7868 11.3605 12.8863 11.3605 12.9991V13.6625C11.5111 13.6698 11.6624 13.6824 11.8169 13.6824C14.6795 13.6824 17 12.4027 17 10.8219V9.6815ZM10.3661 11.0083C10.3648 12.5891 8.04558 13.8695 5.18306 13.8695C2.32849 13.8695 0.0132678 12.6031 0 11.0288V12.1486C0 13.7295 2.31987 15.0098 5.18306 15.0098C8.04624 15.0098 10.3661 13.7295 10.3661 12.1486V11.0083ZM10.3661 12.9984C10.3648 14.5793 8.04558 15.8596 5.18306 15.8596C2.32849 15.8596 0.0132678 14.5932 0 13.019V14.1388C0 15.7197 2.31987 17 5.18306 17C8.04624 17 10.3661 15.7197 10.3661 14.1388V12.9984Z"
                                                                                                    fill="white"/></svg>
                                                                                    </span>
                                                                                    <?= Loc::getMessage('PAY_T_COINS'); ?>

                                                                                </button>
                                                                                <button type="button"
                                                                                        onclick="countPaketBuyShek(<?= $arResult['ID'] ?>, $('#formProdactPaket2'), <?= $arResult['IBLOCK_ID'] ?>)"

                                                                                        class="btn btn-primary btn-paid"><span
                                                                                            class="mr-2"><svg width="17"
                                                                                                              height="14"
                                                                                                              viewBox="0 0 17 14"
                                                                                                              fill="none"
                                                                                                              xmlns="http://www.w3.org/2000/svg">
<path d="M16.3929 0H0.607143C0.271317 0 0 0.284375 0 0.636364V3.81818H17V0.636364C17 0.284375 16.7287 0 16.3929 0ZM0 13.3636C0 13.7156 0.271317 14 0.607143 14H16.3929C16.7287 14 17 13.7156 17 13.3636V5.56818H0V13.3636ZM10.9855 9.70455C10.9855 9.61705 11.0538 9.54545 11.1373 9.54545H14.2679C14.3513 9.54545 14.4196 9.61705 14.4196 9.70455V11.1364C14.4196 11.2239 14.3513 11.2955 14.2679 11.2955H11.1373C11.0538 11.2955 10.9855 11.2239 10.9855 11.1364V9.70455Z"
      fill="white"/>
</svg>
</span> <?= Loc::getMessage('PAY_CARD'); ?>

                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <script>
                                                            $('#dropdownMenuLink<?=$arResult['ID']?>').on('click', (e) => {
                                                                e.preventDefault()
                                                                $('#accordionUserItemWrap<?=$arResult['ID']?>').toggleClass('active')
                                                            })
                                                        </script>
                                                    </div>
                                                </div>


                                            <? } else { ?>

                                                <div class="mb-4 card connection-with-seller text-right">
                                                    <h1 class="mb-4 connection-with-seller__title"><?= $arResult['NAME']; ?></h1>

                                                    <p class="mb-4 connection-with-seller__price text-primary">
                                                        <?= number_format($arResult['PROPERTIES']['PRICE']['VALUE'], 0, '.', ' '); ?> <?= ICON_CURRENCY; ?>
                                                    </p>

                                                    <? if (!empty($arResult['PROPERTIES']['UF_REGION']['~VALUE'])) { ?>
                                                        <p class="pb-3 border-bottom">
                                                            <span class="mr-1"><?= $arResult['PROPERTIES']['UF_CITY']['VALUE']; ?> <?= (!empty($arResult['PROPERTIES']['UF_CITY']['VALUE'])) ? ',' : '' ?> <?= $arResult['PROPERTIES']['UF_REGION']['VALUE']; ?></span>
                                                            <svg class="icon-local"
                                                                 style="position: relative; width: 16px; top: -2px; fill: #747474"
                                                                 version="1.1"
                                                                 id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                                                 xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                                                                 y="0px"
                                                                 viewBox="0 0 513.597 513.597" xml:space="preserve">
                                      <g>
                                          <path d="M263.278,0.107C158.977-3.408,73.323,80.095,73.323,183.602c0,117.469,112.73,202.72,175.915,325.322
                                        c3.208,6.225,12.169,6.233,15.388,0.009c57.16-110.317,154.854-184.291,172.959-290.569
                                        C456.331,108.387,374.776,3.866,263.278,0.107z M256.923,279.773c-53.113,0-96.171-43.059-96.171-96.171
                                        s43.059-96.171,96.171-96.171c53.113,0,96.172,43.059,96.172,96.171S310.036,279.773,256.923,279.773z"></path>
                                      </g>
                                    </svg>
                                                        </p>
                                                    <? } ?>

                                                    <div class="row no-gutters">
                                                        <button class="mr-2 col btn btn-show-phone text-uppercase font-weight-bold"
                                                                data-toggle="collapse" href="#showContactPhone"
                                                                role="button" aria-expanded="false"
                                                                aria-controls="showContactPhone"><?= Loc::getMessage('SHOW_PHONE'); ?>
                                                        </button>

                                                        <button class="ml-2 col btn btn-primary text-uppercase font-weight-bold"
                                                                data-toggle="modal"
                                                                data-target="#modalSandMessage"><?= Loc::getMessage('SEND_MESSAGE'); ?>
                                                        </button>
                                                    </div>

                                                    <ul class="text-right collapse contact-list" id="showContactPhone">
                                                        <li class="d-flex justify-content-end">
                                                            <p class="mb-0 d-flex align-items-center time">
                                                                <? if ($arResult['PROPERTIES']['UF_CALL_ANYTIME']['VALUE'] == 1) { ?>
                                                                    <span class="mx-2"><?= Loc::getMessage('CALL_ANYTIME'); ?></span>
                                                                <? } else { ?>

                                                                    from<span
                                                                            class="mx-2"><?= $arResult['PROPERTIES']['UF_CALL_FROM']['VALUE'] ?></span>
                                                                    to <span
                                                                            class="mx-2"><?= $arResult['PROPERTIES']['UF_CALL_TO']['VALUE'] ?></span>                                                                <? } ?>
                                                                <svg width="20" height="20" viewBox="0 0 20 20"
                                                                     fill="none"
                                                                     xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M9.99 0C4.47 0 0 4.48 0 10C0 15.52 4.47 20 9.99 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 9.99 0ZM10 18C5.58 18 2 14.42 2 10C2 5.58 5.58 2 10 2C14.42 2 18 5.58 18 10C18 14.42 14.42 18 10 18ZM9.78 5H9.72C9.32 5 9 5.32 9 5.72V10.44C9 10.79 9.18 11.12 9.49 11.3L13.64 13.79C13.98 13.99 14.42 13.89 14.62 13.55C14.6702 13.469 14.7036 13.3788 14.7182 13.2846C14.7328 13.1905 14.7283 13.0943 14.705 13.002C14.6817 12.9096 14.64 12.8229 14.5824 12.7469C14.5249 12.671 14.4526 12.6074 14.37 12.56L10.5 10.26V5.72C10.5 5.32 10.18 5 9.78 5Z"
                                                                          fill="#555555"/>
                                                                </svg>

                                                            </p>
                                                        </li>
                                                        <? if ($arResult['PROPERTIES']['UF_PHONE_1']['VALUE']) { ?>
                                                            <li>
                                                                <a href="tel:<?= $arResult['PROPERTIES']['UF_PHONE_1']['VALUE'] ?>"><?= $arResult['PROPERTIES']['UF_PHONE_1']['VALUE'] ?></a>
                                                            </li>
                                                        <? } ?>
                                                        <? if ($arResult['PROPERTIES']['UF_PHONE_2']['VALUE']) { ?>
                                                            <li>
                                                                <a href="tel:<?= $arResult['PROPERTIES']['UF_PHONE_2']['VALUE'] ?>"><?= $arResult['PROPERTIES']['UF_PHONE_2']['VALUE'] ?></a>
                                                            </li>
                                                        <? } ?>
                                                        <? if ($arResult['PROPERTIES']['UF_PHONE_3']['VALUE']) { ?>
                                                            <li>
                                                                <a href="tel:<?= $arResult['PROPERTIES']['UF_PHONE_3']['VALUE'] ?>"><?= $arResult['PROPERTIES']['UF_PHONE_3']['VALUE'] ?></a>
                                                            </li>
                                                        <? } ?>
                                                    </ul>
                                                </div>

                                            <? } ?>
                                        </div>

                                        <div class="main-contetnt col-12 col-xl-9">
                                            <div class="row h-100">
                                                <div class="col-12 col-xl-10">
                                                    <div class="mainItemSlider">

                                                        <?
                                                        foreach ($arResult['PHOTOS'] as $k => $item) {
                                                            ?>
                                                            <div class="slide">
                                                                <img src="<?= $item['ORIG']; ?>" alt="">
                                                            </div>
                                                            <?
                                                        }
                                                        ?>
                                                    </div>
                                                </div>

                                                <div class="d-none d-xl-flex col-xl-2">
                                                    <div class="dots navMainItemSlider">

                                                        <?
                                                        foreach ($arResult['PHOTOS'] as $k => $item) {
                                                            ?>
                                                            <div class="dots__dot">
                                                                <img src="<?= $item['ORIG']; ?>" alt="">
                                                            </div>
                                                            <?
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="info-and-coll-btn">
                                    <div class="d-flex flex-column">
                                        <p class="price"><?= number_format($arResult['PROPERTIES']['PRICE']['VALUE'], 0, '.', ' '); ?> <?= ICON_CURRENCY; ?></p>
                                        <p class="mb-0 title"><?= $arResult['NAME']; ?></p>
                                    </div>
                                    <? if ($USER->IsAuthorized()) { ?>
                                        <div class="d-flex justify-content-center align-items-center call-item">
                                            <? if ($arResult['PROPERTIES']['UF_PHONE_1']['VALUE']) { ?>
                                                <a href="tel:<?= $arResult['PROPERTIES']['UF_PHONE_1']['VALUE'] ?>"
                                                   class="btn">
                                                    <svg width="17" height="17" viewBox="0 0 17 17" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M11.3239 12.0618L12.7799 10.6058C12.976 10.4122 13.2242 10.2796 13.4942 10.2242C13.7642 10.1688 14.0444 10.193 14.3009 10.2938L16.0754 11.0023C16.3347 11.1076 16.5569 11.2872 16.7143 11.5185C16.8716 11.7498 16.9569 12.0226 16.9594 12.3023V15.5523C16.9579 15.7426 16.9179 15.9307 16.8418 16.1051C16.7657 16.2795 16.6551 16.4368 16.5167 16.5673C16.3782 16.6979 16.2148 16.7991 16.0362 16.8648C15.8576 16.9306 15.6675 16.9595 15.4774 16.9498C3.04294 16.1763 0.533938 5.64633 0.0594376 1.61633C0.037411 1.41843 0.0575361 1.21811 0.118489 1.02854C0.179442 0.838978 0.279841 0.664466 0.413081 0.51649C0.546322 0.368513 0.709384 0.250424 0.89154 0.169993C1.0737 0.0895611 1.27082 0.0486092 1.46994 0.0498313H4.60944C4.88959 0.0506605 5.1631 0.135285 5.39476 0.29282C5.62643 0.450356 5.80568 0.673597 5.90944 0.933831L6.61794 2.70833C6.7221 2.96383 6.74868 3.24435 6.69434 3.51486C6.64001 3.78537 6.50718 4.03387 6.31244 4.22933L4.85644 5.68533C4.85644 5.68533 5.69494 11.3598 11.3239 12.0618Z"
                                                              fill="white"/>
                                                    </svg>
                                                </a>
                                            <? } ?>
                                        </div>
                                    <? } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div style="display: none !important;" class="d-block d-lg-none">

                <? if (!$arParams['USER_ID']) { ?>
                    <div class="mb-4 card connection-with-seller text-right">
                        <h1 class="mb-4 connection-with-seller__title"><?= $arResult['NAME']; ?></h1>

                        <p class="mb-4 connection-with-seller__price text-primary">
                            <?= number_format($arResult['PROPERTIES']['PRICE']['VALUE'], 0, '.', ' '); ?> <?= ICON_CURRENCY; ?>
                        </p>

                        <? if (!empty($arResult['PROPERTIES']['UF_REGION']['~VALUE'])) { ?>
                            <p class="pb-3 border-bottom">
                                <span class="mr-1"><?= $arResult['PROPERTIES']['UF_CITY']['VALUE']; ?> <?= (!empty($arResult['PROPERTIES']['UF_CITY']['VALUE'])) ? ',' : '' ?> <?= $arResult['PROPERTIES']['UF_REGION']['VALUE']; ?></span>
                                <svg class="icon-local"
                                     style="position: relative; width: 16px; top: -2px; fill: #747474" version="1.1"
                                     id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                     xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                     viewBox="0 0 513.597 513.597" xml:space="preserve">
                                      <g>
                                          <path d="M263.278,0.107C158.977-3.408,73.323,80.095,73.323,183.602c0,117.469,112.73,202.72,175.915,325.322
                                        c3.208,6.225,12.169,6.233,15.388,0.009c57.16-110.317,154.854-184.291,172.959-290.569
                                        C456.331,108.387,374.776,3.866,263.278,0.107z M256.923,279.773c-53.113,0-96.171-43.059-96.171-96.171
                                        s43.059-96.171,96.171-96.171c53.113,0,96.172,43.059,96.172,96.171S310.036,279.773,256.923,279.773z"></path>
                                      </g>
                                    </svg>
                            </p>
                        <? } ?>


                        <div class="mb-4 row no-gutters">
                            <button class="mr-2 col btn btn-show-phone text-uppercase font-weight-bold"
                                    disabled><?= Loc::getMessage('SHOW_PHONE'); ?>
                            </button>
                            <button class="ml-2 col btn btn-primary text-uppercase font-weight-bold"
                                    disabled><?= Loc::getMessage('SEND_MESSAGE'); ?>
                            </button>
                        </div>

                        <p class="text-unaurh-user"><?= Loc::getMessage('VIEW_REGISTER_MESS'); ?></p>

                        <div class="row">
                            <div class="col">
                                <ul class="nav justify-content-end font-weight-bold">
                                    <li class="mr-4 justify-content-center">
                                        <a class="" href="#" data-toggle="modal" data-target="#registerModal">
                                            <span class="mr-2"><?= Loc::getMessage('REGISTER'); ?></span>
                                            <i class="icon-user-1"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="" href="#" data-toggle="modal" data-target="#logInModal">
                                            <span class="mr-2"><?= Loc::getMessage('Sign_In'); ?></span>
                                            <i class="icon-log-in"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                <? } elseif ($arParams['USER_ID'] == $arResult['PROPERTIES']['ID_USER']['VALUE']) { ?>
                    <div class="mb-4 card connection-with-seller text-right">
                        <h1 class="mb-4 connection-with-seller__title"><?= $arResult['NAME']; ?></h1>

                        <p class="mb-4 connection-with-seller__price text-primary">
                            <?= number_format($arResult['PROPERTIES']['PRICE']['VALUE'], 0, '.', ' '); ?> <?= ICON_CURRENCY; ?>
                        </p>

                        <? if (!empty($arResult['PROPERTIES']['UF_REGION']['~VALUE'])) { ?>
                            <p class="pb-3 border-bottom">
                                <span class="mr-1"><?= $arResult['PROPERTIES']['UF_CITY']['VALUE']; ?> <?= (!empty($arResult['PROPERTIES']['UF_CITY']['VALUE'])) ? ',' : '' ?> <?= $arResult['PROPERTIES']['UF_REGION']['VALUE']; ?></span>
                                <svg class="icon-local"
                                     style="position: relative; width: 16px; top: -2px; fill: #747474" version="1.1"
                                     id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                     xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                     viewBox="0 0 513.597 513.597" xml:space="preserve">
                                      <g>
                                          <path d="M263.278,0.107C158.977-3.408,73.323,80.095,73.323,183.602c0,117.469,112.73,202.72,175.915,325.322
                                        c3.208,6.225,12.169,6.233,15.388,0.009c57.16-110.317,154.854-184.291,172.959-290.569
                                        C456.331,108.387,374.776,3.866,263.278,0.107z M256.923,279.773c-53.113,0-96.171-43.059-96.171-96.171
                                        s43.059-96.171,96.171-96.171c53.113,0,96.172,43.059,96.172,96.171S310.036,279.773,256.923,279.773z"></path>
                                      </g>
                                    </svg>
                            </p>
                        <? } ?>


                        <div class="flex-column">
                            <button onclick="window.location.href='<?= $editUrl ?>'"
                                    class="mb-3 w-100 btn btn-primary text-uppercase font-weight-bold"><a
                                        href="<?= $editUrl ?>"><?= Loc::getMessage('EDIT'); ?></a></button>
                            <button class="w-100 btn btn-accelerate-sale text-uppercase font-weight-bold btn-accelerate-sale"><span><svg
                                            width="31" height="18" viewBox="0 0 31 18" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                    <path d="M29.4417 3.27725H14.2853L14.06 0.734453C14.0231 0.318623 13.6792 0 13.2671 0H11.6496C11.2099 0 10.8535 0.361101 10.8535 0.806543C10.8535 1.25198 11.2099 1.61309 11.6496 1.61309H12.5393C13.0254 7.10073 11.7689 -7.08279 13.4549 11.9479C13.5199 12.6928 13.9171 13.5011 14.6014 14.0503C13.3676 15.6466 14.495 18 16.502 18C18.1678 18 19.3427 16.3168 18.7715 14.7226H23.1286C22.558 16.3147 23.7304 18 25.398 18C26.7289 18 27.8116 16.9031 27.8116 15.5548C27.8116 14.2064 26.7289 13.1095 25.398 13.1095H16.5074C15.9026 13.1095 15.3757 12.7399 15.1482 12.2013L27.8708 11.4438C28.2181 11.4231 28.512 11.1763 28.5964 10.8343L30.214 4.2794C30.3394 3.77113 29.9597 3.27725 29.4417 3.27725ZM16.502 16.3869C16.0491 16.3869 15.6806 16.0136 15.6806 15.5548C15.6806 15.0959 16.0491 14.7226 16.502 14.7226C16.9549 14.7226 17.3234 15.0959 17.3234 15.5548C17.3234 16.0136 16.9549 16.3869 16.502 16.3869ZM25.398 16.3869C24.9451 16.3869 24.5766 16.0136 24.5766 15.5548C24.5766 15.0959 24.9451 14.7226 25.398 14.7226C25.8509 14.7226 26.2194 15.0959 26.2194 15.5548C26.2194 16.0136 25.8509 16.3869 25.398 16.3869ZM27.1936 9.86828L14.9339 10.5982L14.4282 4.8903H28.4221L27.1936 9.86828Z"
                                          fill="white"/>
                                    <path d="M10.509 8.05168C10.6904 8.02447 10.8535 8.16495 10.8535 8.34836V10.6516C10.8535 10.8351 10.6904 10.9755 10.509 10.9483L2.83139 9.79668C2.49072 9.74558 2.49072 9.25442 2.83139 9.20332L10.509 8.05168Z"
                                          fill="white"/>
                                    <path d="M10.5111 5.04892C10.6918 5.0231 10.8535 5.16334 10.8535 5.3459V6.6541C10.8535 6.83666 10.6918 6.9769 10.5111 6.95108L5.93241 6.29698C5.58898 6.24792 5.58898 5.75208 5.93241 5.70302L10.5111 5.04892Z"
                                          fill="white"/>
                                    <path d="M10.5111 12.0489C10.6918 12.0231 10.8535 12.1633 10.8535 12.3459V13.6541C10.8535 13.8367 10.6918 13.9769 10.5111 13.9511L5.93241 13.297C5.58898 13.2479 5.58898 12.7521 5.93241 12.703L10.5111 12.0489Z"
                                          fill="white"/>
                                    </svg>
                                    </span> <?= Loc::getMessage('SPEED_SALE'); ?>
                            </button>
                            <div class="accardion-wrap"
                                 id="accordionUserItemWrap<?= $arResult['ID'] ?>">

                                <div class="accordion user-promote-menu"
                                     id="accordionUserItem<?= $arResult['ID'] ?>">
                                    <!-- RISE -->
                                    <div class="promote-card">
                                        <!-- ID "headingRiseItem" shold be UNIC for every product card -->
                                        <div class="card-header" id="headingRiseItem">
                                            <button class="btn btn-link btn-block text-right collapsed"
                                                    type="button" data-toggle="collapse"
                                                    data-target="#riseItem<?= $arResult['ID'] ?>"
                                                    aria-expanded="false"
                                                    aria-controls="riseItem">
                                                <div class="pr-4 d-flex justify-content-between align-items-center">
                                                    <span class="plus"></span>
                                                    <span class="card-header__title"><?= Loc::getMessage('RISE_PAKET'); ?></span>

                                                </div>
                                            </button>
                                            <span class="text-uppercase font-weight-bold up card-header__icon">UP</span>
                                        </div>

                                        <!-- data-parent depend on "accordionUserItem<?= $arResult['ID'] ?>" -->
                                        <!-- aria-labelledby depend on "headingRiseItem" -->
                                        <div id="riseItem<?= $arResult['ID'] ?>" class="collapse"
                                             aria-labelledby="headingRiseItem"
                                             data-parent="#accordionUserItem<?= $arResult['ID'] ?>">
                                            <div class="p-3 bg-lightgray">
                                                <? $APPLICATION->IncludeComponent(
                                                    "bitrix:main.include",
                                                    "",
                                                    array(
                                                        "AREA_FILE_SHOW" => "file",
                                                        "AREA_FILE_SUFFIX" => "inc",
                                                        "EDIT_TEMPLATE" => "",
                                                        "PATH" => "/include-area/up-rise-" . LANGUAGE_ID . ".php"
                                                    )
                                                ); ?>

                                                <p class="mb-3 font-weight-bold content-subtitle">
                                                    <?= Loc::getMessage('type_item') ?></p>
                                                <form id="formProdactRise3">
                                                    <div class="mb-4 px-3 card">
                                                        <? foreach ($arTypesRise as $arRise) { ?>
                                                            <? if ($arRise['UF_COUNT'] > 0) { ?>
                                                                <div class="py-3 border-bottom d-flex justify-content-between">
                                                                    <span class="font-weight-bold"><?= $arRise["UF_PRICE"] ?> T</span>


                                                                    <label class="custom-radio-btn">
                                                                        <input type="radio"
                                                                               value="<?= $arRise["UF_COUNT"] ?>"
                                                                               data-price="<?= $arRise["UF_PRICE"] ?>"
                                                                               data-price-shek="<?= $arRise["UF_PRICE_SHEK"] ?>"
                                                                               name="riseProduct">
                                                                        <span><?= $arRise["UF_NAME"] ?></span>
                                                                        <span class="checkbox"></span>
                                                                    </label>
                                                                </div>
                                                            <? }
                                                        } ?>
                                                    </div>

                                                    <p class="mb-3 font-weight-bold content-subtitle">
                                                        <?= Loc::getMessage('PAY_CHOISE'); ?>
                                                        :</p>

                                                    <div class="d-flex flex-column justify-content-end align-items-end">
                                                        <button type="button"
                                                                onclick="countRiseBuy(<?= $arResult['ID'] ?>, $('#formProdactRise3'), <?= $arResult['IBLOCK_ID'] ?>)"
                                                                data-toggle="modal" data-target="#payTcoins"
                                                                class="mb-3 btn btn-primary btn-paid"><span
                                                                    class="mr-2"><svg width="17" height="17"
                                                                                      viewBox="0 0 17 17" fill="none"
                                                                                      xmlns="http://www.w3.org/2000/svg"><path
                                                                            d="M11.8169 0.00066338C8.95442 0.00066338 6.63389 1.28034 6.63389 2.8612C6.63389 4.44205 8.95508 5.72239 11.8169 5.72239C14.6795 5.72239 17 4.44205 17 2.8612C17 1.28034 14.6788 0 11.8169 0V0.00066338ZM17 3.711C16.9987 5.29185 14.6795 6.57219 11.8169 6.57219C8.96238 6.57219 6.64716 5.30578 6.63389 3.73223V4.85136C6.63389 5.52669 7.06642 6.14497 7.77492 6.63455C8.49138 6.82959 9.12956 7.10025 9.66093 7.44256C10.3197 7.60973 11.0441 7.71189 11.8169 7.71189C14.6795 7.71189 17 6.43222 17 4.85136V3.711ZM17 5.70116C17 7.28202 14.6795 8.56236 11.8169 8.56236C11.4687 8.56236 11.1303 8.53649 10.8013 8.5C11.0609 8.84969 11.2381 9.25361 11.3194 9.6815C11.4846 9.69078 11.6478 9.70206 11.8169 9.70206C14.6795 9.70206 17 8.42238 17 6.84153V5.70116ZM5.18306 7.29728C2.32053 7.29728 0 8.57762 0 10.1585C0 11.7393 2.3212 13.0197 5.18306 13.0197C8.04558 13.0197 10.3661 11.7393 10.3661 10.1585C10.3661 8.57762 8.04492 7.29728 5.18306 7.29728ZM17 7.69133C16.9987 9.27219 14.6795 10.5525 11.8169 10.5525C11.6504 10.5525 11.4819 10.5406 11.3194 10.5313C11.3121 10.5811 11.3081 10.6474 11.2988 10.6971C11.332 10.7973 11.3605 10.8962 11.3605 11.0089V11.6723C11.5111 11.6796 11.6624 11.6922 11.8169 11.6922C14.6795 11.6922 17 10.4125 17 8.83169V7.69133ZM17 9.6815C16.9987 11.2624 14.6795 12.5427 11.8169 12.5427C11.6504 12.5427 11.4819 12.5308 11.3194 12.5215C11.3121 12.5712 11.3081 12.6376 11.2988 12.6873C11.332 12.7868 11.3605 12.8863 11.3605 12.9991V13.6625C11.5111 13.6698 11.6624 13.6824 11.8169 13.6824C14.6795 13.6824 17 12.4027 17 10.8219V9.6815ZM10.3661 11.0083C10.3648 12.5891 8.04558 13.8695 5.18306 13.8695C2.32849 13.8695 0.0132678 12.6031 0 11.0288V12.1486C0 13.7295 2.31987 15.0098 5.18306 15.0098C8.04624 15.0098 10.3661 13.7295 10.3661 12.1486V11.0083ZM10.3661 12.9984C10.3648 14.5793 8.04558 15.8596 5.18306 15.8596C2.32849 15.8596 0.0132678 14.5932 0 13.019V14.1388C0 15.7197 2.31987 17 5.18306 17C8.04624 17 10.3661 15.7197 10.3661 14.1388V12.9984Z"
                                                                            fill="white"/></svg>
                                                                                    </span>
                                                            <?= Loc::getMessage('PAY_T_COINS'); ?>

                                                        </button>
                                                        <button type="button"
                                                                onclick="countRiseBuy(<?= $arResult['ID'] ?>, $('#formProdactRise<?= $arResult['ID'] ?>'), <?= $arResult['IBLOCK_ID'] ?>)"


                                                                class="btn btn-primary btn-paid"><span
                                                                    class="mr-2"><svg width="17"
                                                                                      height="14"
                                                                                      viewBox="0 0 17 14"
                                                                                      fill="none"
                                                                                      xmlns="http://www.w3.org/2000/svg">
<path d="M16.3929 0H0.607143C0.271317 0 0 0.284375 0 0.636364V3.81818H17V0.636364C17 0.284375 16.7287 0 16.3929 0ZM0 13.3636C0 13.7156 0.271317 14 0.607143 14H16.3929C16.7287 14 17 13.7156 17 13.3636V5.56818H0V13.3636ZM10.9855 9.70455C10.9855 9.61705 11.0538 9.54545 11.1373 9.54545H14.2679C14.3513 9.54545 14.4196 9.61705 14.4196 9.70455V11.1364C14.4196 11.2239 14.3513 11.2955 14.2679 11.2955H11.1373C11.0538 11.2955 10.9855 11.2239 10.9855 11.1364V9.70455Z"
      fill="white"/>
</svg>
</span> <?= Loc::getMessage('PAY_CARD'); ?>

                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- VIP -->
                                    <div class="promote-card">
                                        <!-- ID "headingVipItem" shold be UNIC for every product card -->
                                        <div class="card-header" id="headingVipItem">
                                            <!-- data-target="#vipItem" depend on "accordionUserItem<?= $arResult['ID'] ?>" -->
                                            <!-- aria-controls="vipItem" depend on "headingRiseItem" -->
                                            <button class="btn btn-link btn-block text-right collapsed"
                                                    type="button" data-toggle="collapse"
                                                    data-target="#vipItem<?= $arResult['ID'] ?>" aria-expanded="false"
                                                    aria-controls="vipItem">
                                                <div class="pr-4 d-flex justify-content-between align-items-center">
                                                    <span class="plus"></span>
                                                    <span class="card-header__title"><?= Loc::getMessage('VIP_PAKET'); ?></span>

                                                </div>

                                                <span class="card-header__icon"><svg width="22"
                                                                                     height="19"
                                                                                     viewBox="0 0 22 19"
                                                                                     fill="none"
                                                                                     xmlns="http://www.w3.org/2000/svg">
<path d="M1.58936 3.42876L5.88549 6.18822L10.1673 0.413067C10.2619 0.285313 10.3868 0.181179 10.5317 0.109331C10.6765 0.0374835 10.837 0 10.9999 0C11.1628 0 11.3234 0.0374835 11.4682 0.109331C11.613 0.181179 11.7379 0.285313 11.8326 0.413067L16.1144 6.18822L20.4105 3.42876C20.5731 3.32454 20.7633 3.26734 20.9585 3.26392C21.1538 3.2605 21.346 3.31101 21.5124 3.40947C21.6788 3.50793 21.8125 3.65023 21.8976 3.81956C21.9828 3.98888 22.0159 4.17815 21.9929 4.36501L20.3123 18.1298C20.283 18.3695 20.1634 18.5905 19.9762 18.7509C19.7889 18.9113 19.5471 19 19.2966 19H2.70328C2.45274 19 2.21093 18.9113 2.0237 18.7509C1.83648 18.5905 1.71687 18.3695 1.68755 18.1298L0.00694712 4.36402C-0.015761 4.17725 0.0174677 3.98811 0.102711 3.81895C0.187954 3.64978 0.321652 3.50764 0.488023 3.40931C0.654394 3.31098 0.846492 3.26056 1.04164 3.26401C1.23679 3.26745 1.42684 3.32462 1.58936 3.42876ZM10.9999 13.0869C11.5425 13.0869 12.0629 12.8792 12.4465 12.5096C12.8302 12.1399 13.0457 11.6386 13.0457 11.1158C13.0457 10.5931 12.8302 10.0917 12.4465 9.72209C12.0629 9.35245 11.5425 9.14479 10.9999 9.14479C10.4574 9.14479 9.93701 9.35245 9.55335 9.72209C9.16969 10.0917 8.95416 10.5931 8.95416 11.1158C8.95416 11.6386 9.16969 12.1399 9.55335 12.5096C9.93701 12.8792 10.4574 13.0869 10.9999 13.0869Z"
      fill="#F50000"/>
</svg>
</span>
                                            </button>
                                        </div>

                                        <!-- ID "vipItem" shold be UNIC for every product card -->
                                        <!-- aria-labelledby="headingVipItem" data-parent="#accordionUserItem<?= $arResult['ID'] ?>" -->
                                        <div id="vipItem<?= $arResult['ID'] ?>" class="collapse"
                                             aria-labelledby="headingVipItem"
                                             data-parent="#accordionUserItem<?= $arResult['ID'] ?>">
                                            <div class="p-3 bg-lightgray">
                                                <? $APPLICATION->IncludeComponent(
                                                    "bitrix:main.include",
                                                    "",
                                                    array(
                                                        "AREA_FILE_SHOW" => "file",
                                                        "AREA_FILE_SUFFIX" => "inc",
                                                        "EDIT_TEMPLATE" => "",
                                                        "PATH" => "/include-area/up-vip-" . LANGUAGE_ID . ".php"
                                                    )
                                                ); ?>

                                                <p class="mb-3 font-weight-bold content-subtitle">
                                                    <?= Loc::getMessage('type_item') ?></p>
                                                <form id="formProdactVip3">
                                                    <div class="mb-4 px-3 card">
                                                        <? foreach ($arTypesVip as $arRise) { ?>
                                                            <? if ($arRise['UF_COUNT'] > 0) { ?>
                                                                <div class="py-3 border-bottom d-flex justify-content-between">
                                                                    <span class="font-weight-bold"><?= $arRise["UF_PRICE"] ?> T</span>


                                                                    <label class="custom-radio-btn">
                                                                        <input type="radio"
                                                                               value="<?= $arRise["UF_COUNT"] ?>"
                                                                               data-price="<?= $arRise["UF_PRICE"] ?>"
                                                                               data-price-shek="<?= $arRise["UF_PRICE_SHEK"] ?>"
                                                                               name="riseProduct">
                                                                        <span><?= $arRise["UF_NAME"] ?></span>
                                                                        <span class="checkbox"></span>
                                                                    </label>
                                                                </div>
                                                            <? }
                                                        } ?>
                                                    </div>
                                                </form>

                                                <p class="mb-3 font-weight-bold content-subtitle">
                                                    <?= Loc::getMessage('PAY_CHOISE'); ?>
                                                    :</p>

                                                <div class="d-flex flex-column justify-content-end align-items-end">
                                                    <button type="button"
                                                            onclick="countVipBuy(<?= $arResult['ID'] ?>, $('#formProdactVip3'), <?= $arResult['IBLOCK_ID'] ?>)"
                                                            data-toggle="modal" data-target="#payTcoins"
                                                            class="mb-3 btn btn-primary btn-paid"><span
                                                                class="mr-2"><svg width="17" height="17"
                                                                                  viewBox="0 0 17 17" fill="none"
                                                                                  xmlns="http://www.w3.org/2000/svg"><path
                                                                        d="M11.8169 0.00066338C8.95442 0.00066338 6.63389 1.28034 6.63389 2.8612C6.63389 4.44205 8.95508 5.72239 11.8169 5.72239C14.6795 5.72239 17 4.44205 17 2.8612C17 1.28034 14.6788 0 11.8169 0V0.00066338ZM17 3.711C16.9987 5.29185 14.6795 6.57219 11.8169 6.57219C8.96238 6.57219 6.64716 5.30578 6.63389 3.73223V4.85136C6.63389 5.52669 7.06642 6.14497 7.77492 6.63455C8.49138 6.82959 9.12956 7.10025 9.66093 7.44256C10.3197 7.60973 11.0441 7.71189 11.8169 7.71189C14.6795 7.71189 17 6.43222 17 4.85136V3.711ZM17 5.70116C17 7.28202 14.6795 8.56236 11.8169 8.56236C11.4687 8.56236 11.1303 8.53649 10.8013 8.5C11.0609 8.84969 11.2381 9.25361 11.3194 9.6815C11.4846 9.69078 11.6478 9.70206 11.8169 9.70206C14.6795 9.70206 17 8.42238 17 6.84153V5.70116ZM5.18306 7.29728C2.32053 7.29728 0 8.57762 0 10.1585C0 11.7393 2.3212 13.0197 5.18306 13.0197C8.04558 13.0197 10.3661 11.7393 10.3661 10.1585C10.3661 8.57762 8.04492 7.29728 5.18306 7.29728ZM17 7.69133C16.9987 9.27219 14.6795 10.5525 11.8169 10.5525C11.6504 10.5525 11.4819 10.5406 11.3194 10.5313C11.3121 10.5811 11.3081 10.6474 11.2988 10.6971C11.332 10.7973 11.3605 10.8962 11.3605 11.0089V11.6723C11.5111 11.6796 11.6624 11.6922 11.8169 11.6922C14.6795 11.6922 17 10.4125 17 8.83169V7.69133ZM17 9.6815C16.9987 11.2624 14.6795 12.5427 11.8169 12.5427C11.6504 12.5427 11.4819 12.5308 11.3194 12.5215C11.3121 12.5712 11.3081 12.6376 11.2988 12.6873C11.332 12.7868 11.3605 12.8863 11.3605 12.9991V13.6625C11.5111 13.6698 11.6624 13.6824 11.8169 13.6824C14.6795 13.6824 17 12.4027 17 10.8219V9.6815ZM10.3661 11.0083C10.3648 12.5891 8.04558 13.8695 5.18306 13.8695C2.32849 13.8695 0.0132678 12.6031 0 11.0288V12.1486C0 13.7295 2.31987 15.0098 5.18306 15.0098C8.04624 15.0098 10.3661 13.7295 10.3661 12.1486V11.0083ZM10.3661 12.9984C10.3648 14.5793 8.04558 15.8596 5.18306 15.8596C2.32849 15.8596 0.0132678 14.5932 0 13.019V14.1388C0 15.7197 2.31987 17 5.18306 17C8.04624 17 10.3661 15.7197 10.3661 14.1388V12.9984Z"
                                                                        fill="white"/></svg>
                                                                                    </span>
                                                        <?= Loc::getMessage('PAY_T_COINS'); ?>

                                                    </button>
                                                    <button type="button"
                                                            onclick="countVipBuyShek(<?= $arResult['ID'] ?>, $('#formProdactVip3'), <?= $arResult['IBLOCK_ID'] ?>)"

                                                            class="btn btn-primary btn-paid"><span
                                                                class="mr-2"><svg width="17"
                                                                                  height="14"
                                                                                  viewBox="0 0 17 14"
                                                                                  fill="none"
                                                                                  xmlns="http://www.w3.org/2000/svg">
<path d="M16.3929 0H0.607143C0.271317 0 0 0.284375 0 0.636364V3.81818H17V0.636364C17 0.284375 16.7287 0 16.3929 0ZM0 13.3636C0 13.7156 0.271317 14 0.607143 14H16.3929C16.7287 14 17 13.7156 17 13.3636V5.56818H0V13.3636ZM10.9855 9.70455C10.9855 9.61705 11.0538 9.54545 11.1373 9.54545H14.2679C14.3513 9.54545 14.4196 9.61705 14.4196 9.70455V11.1364C14.4196 11.2239 14.3513 11.2955 14.2679 11.2955H11.1373C11.0538 11.2955 10.9855 11.2239 10.9855 11.1364V9.70455Z"
      fill="white"/>
</svg>
</span> <?= Loc::getMessage('PAY_CARD'); ?>

                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- COLOUR -->
                                    <div class="promote-card">
                                        <!-- ID "headingSelectColorItem" shold be UNIC for every product card -->
                                        <div class="card-header" id="headingSelectColorItem">
                                            <!-- Change for every button "data-target", "aria-controls" data value "#ID under section"-->
                                            <button class="btn btn-link btn-block text-right collapsed"
                                                    type="button" data-toggle="collapse"
                                                    data-target="#selectColorItem<?= $arResult['ID'] ?>"
                                                    aria-expanded="false"
                                                    aria-controls="selectColorItem">
                                                <div class="pr-4 d-flex justify-content-between align-items-center">
                                                    <span class="plus"></span>
                                                    <span class="card-header__title"><?= Loc::getMessage('COLOUR_PAKET'); ?></span>

                                                </div>
                                                <span class="card-header__icon"><svg width="16"
                                                                                     height="17"
                                                                                     viewBox="0 0 16 17"
                                                                                     fill="none"
                                                                                     xmlns="http://www.w3.org/2000/svg">
<path d="M8.20189 0.934761C8.20189 0.779763 8.14032 0.631114 8.03072 0.521514C7.92112 0.411914 7.77247 0.350342 7.61747 0.350342C7.46247 0.350342 7.31382 0.411914 7.20422 0.521514C7.09462 0.631114 7.03305 0.779763 7.03305 0.934761V1.90879C6.78643 1.99564 6.56248 2.13677 6.37772 2.32178L1.01743 7.68285C0.854624 7.84566 0.725478 8.03894 0.637367 8.25165C0.549256 8.46437 0.503906 8.69236 0.503906 8.9226C0.503906 9.15284 0.549256 9.38083 0.637367 9.59355C0.725478 9.80626 0.854624 9.99954 1.01743 10.1623L4.82005 13.9634C4.98286 14.1262 5.17613 14.2554 5.38885 14.3435C5.60157 14.4316 5.82956 14.4769 6.0598 14.4769C6.29004 14.4769 6.51803 14.4316 6.73075 14.3435C6.94346 14.2554 7.13674 14.1262 7.29955 13.9634L12.6598 8.60312C12.8226 8.44031 12.9518 8.24703 13.0399 8.03432C13.128 7.8216 13.1734 7.59361 13.1734 7.36337C13.1734 7.13313 13.128 6.90514 13.0399 6.69242C12.9518 6.47971 12.8226 6.28643 12.6598 6.12362L8.85644 2.32178C8.67191 2.13687 8.44823 1.99574 8.20189 1.90879V0.934761ZM7.03305 3.31919V4.44127C7.03305 4.59627 7.09462 4.74492 7.20422 4.85452C7.31382 4.96412 7.46247 5.02569 7.61747 5.02569C7.77247 5.02569 7.92112 4.96412 8.03072 4.85452C8.14032 4.74492 8.20189 4.59627 8.20189 4.44127V3.31919L11.8323 6.95038C11.9417 7.05996 12.0032 7.2085 12.0032 7.36337C12.0032 7.51824 11.9417 7.66678 11.8323 7.77636L11.0765 8.53221H1.82159L1.84419 8.50883L7.03305 3.31919Z"
      fill="#6633F5"/>
<path d="M14.063 9.78046C14.0049 9.67162 13.9183 9.5806 13.8125 9.51714C13.7067 9.45369 13.5856 9.42017 13.4622 9.42017C13.3388 9.42017 13.2177 9.45369 13.1119 9.51714C13.0061 9.5806 12.9195 9.67162 12.8614 9.78046L11.2967 12.715C10.4232 14.3498 11.6092 16.3244 13.4622 16.3244C15.3152 16.3244 16.4996 14.3498 15.6284 12.715L14.063 9.78046Z"
      fill="#6633F5"/>
</svg></span>

                                            </button>
                                        </div>

                                        <!-- ID "selectColorItem" shold be UNIC for every product card -->
                                        <!-- data-parent = MAIN ID data-parent="#accordionUserItem<?= $arResult['ID'] ?>" -->
                                        <div id="selectColorItem<?= $arResult['ID'] ?>" class="collapse"
                                             aria-labelledby="headingSelectColorItem"
                                             data-parent="#accordionUserItem<?= $arResult['ID'] ?>">
                                            <div class="p-3 bg-lightgray">
                                                <? $APPLICATION->IncludeComponent(
                                                    "bitrix:main.include",
                                                    "",
                                                    array(
                                                        "AREA_FILE_SHOW" => "file",
                                                        "AREA_FILE_SUFFIX" => "inc",
                                                        "EDIT_TEMPLATE" => "",
                                                        "PATH" => "/include-area/up-colour-" . LANGUAGE_ID . ".php"
                                                    )
                                                ); ?>

                                                <p class="mb-3 font-weight-bold content-subtitle">
                                                    <?= Loc::getMessage('type_item') ?></p>
                                                <form id="formProdactColour3">
                                                    <div class="mb-4 px-3 card">
                                                        <? foreach ($arTypesColour as $arRise) { ?>
                                                            <? if ($arRise['UF_COUNT'] > 0) { ?>
                                                                <div class="py-3 border-bottom d-flex justify-content-between">
                                                                    <span class="font-weight-bold"><?= $arRise["UF_PRICE"] ?> T</span>


                                                                    <label class="custom-radio-btn">
                                                                        <input type="radio"
                                                                               value="<?= $arRise["UF_COUNT"] ?>"
                                                                               data-price="<?= $arRise["UF_PRICE"] ?>"
                                                                               data-price-shek="<?= $arRise["UF_PRICE_SHEK"] ?>"
                                                                               name="riseProduct">
                                                                        <span><?= $arRise["UF_NAME"] ?></span>
                                                                        <span class="checkbox"></span>
                                                                    </label>
                                                                </div>
                                                            <? }
                                                        } ?></div>
                                                </form>

                                                <p class="mb-3 font-weight-bold content-subtitle">
                                                    <?= Loc::getMessage('PAY_CHOISE'); ?>
                                                    :</p>

                                                <div class="d-flex flex-column justify-content-end align-items-end">
                                                    <button type="button"
                                                            onclick="countColourBuy(<?= $arResult['ID'] ?>, $('#formProdactColour3'), <?= $arResult['IBLOCK_ID'] ?>)"
                                                            data-toggle="modal" data-target="#payTcoins"
                                                            class="mb-3 btn btn-primary btn-paid"><span
                                                                class="mr-2"><svg width="17" height="17"
                                                                                  viewBox="0 0 17 17" fill="none"
                                                                                  xmlns="http://www.w3.org/2000/svg"><path
                                                                        d="M11.8169 0.00066338C8.95442 0.00066338 6.63389 1.28034 6.63389 2.8612C6.63389 4.44205 8.95508 5.72239 11.8169 5.72239C14.6795 5.72239 17 4.44205 17 2.8612C17 1.28034 14.6788 0 11.8169 0V0.00066338ZM17 3.711C16.9987 5.29185 14.6795 6.57219 11.8169 6.57219C8.96238 6.57219 6.64716 5.30578 6.63389 3.73223V4.85136C6.63389 5.52669 7.06642 6.14497 7.77492 6.63455C8.49138 6.82959 9.12956 7.10025 9.66093 7.44256C10.3197 7.60973 11.0441 7.71189 11.8169 7.71189C14.6795 7.71189 17 6.43222 17 4.85136V3.711ZM17 5.70116C17 7.28202 14.6795 8.56236 11.8169 8.56236C11.4687 8.56236 11.1303 8.53649 10.8013 8.5C11.0609 8.84969 11.2381 9.25361 11.3194 9.6815C11.4846 9.69078 11.6478 9.70206 11.8169 9.70206C14.6795 9.70206 17 8.42238 17 6.84153V5.70116ZM5.18306 7.29728C2.32053 7.29728 0 8.57762 0 10.1585C0 11.7393 2.3212 13.0197 5.18306 13.0197C8.04558 13.0197 10.3661 11.7393 10.3661 10.1585C10.3661 8.57762 8.04492 7.29728 5.18306 7.29728ZM17 7.69133C16.9987 9.27219 14.6795 10.5525 11.8169 10.5525C11.6504 10.5525 11.4819 10.5406 11.3194 10.5313C11.3121 10.5811 11.3081 10.6474 11.2988 10.6971C11.332 10.7973 11.3605 10.8962 11.3605 11.0089V11.6723C11.5111 11.6796 11.6624 11.6922 11.8169 11.6922C14.6795 11.6922 17 10.4125 17 8.83169V7.69133ZM17 9.6815C16.9987 11.2624 14.6795 12.5427 11.8169 12.5427C11.6504 12.5427 11.4819 12.5308 11.3194 12.5215C11.3121 12.5712 11.3081 12.6376 11.2988 12.6873C11.332 12.7868 11.3605 12.8863 11.3605 12.9991V13.6625C11.5111 13.6698 11.6624 13.6824 11.8169 13.6824C14.6795 13.6824 17 12.4027 17 10.8219V9.6815ZM10.3661 11.0083C10.3648 12.5891 8.04558 13.8695 5.18306 13.8695C2.32849 13.8695 0.0132678 12.6031 0 11.0288V12.1486C0 13.7295 2.31987 15.0098 5.18306 15.0098C8.04624 15.0098 10.3661 13.7295 10.3661 12.1486V11.0083ZM10.3661 12.9984C10.3648 14.5793 8.04558 15.8596 5.18306 15.8596C2.32849 15.8596 0.0132678 14.5932 0 13.019V14.1388C0 15.7197 2.31987 17 5.18306 17C8.04624 17 10.3661 15.7197 10.3661 14.1388V12.9984Z"
                                                                        fill="white"/></svg>
                                                                                    </span>
                                                        <?= Loc::getMessage('PAY_T_COINS'); ?>

                                                    </button>
                                                    <button type="button"
                                                            onclick="countColourBuyShek(<?= $arResult['ID'] ?>, $('#formProdactColour3'), <?= $arResult['IBLOCK_ID'] ?>)"
                                                            class="btn btn-primary btn-paid"><span
                                                                class="mr-2"><svg width="17"
                                                                                  height="14"
                                                                                  viewBox="0 0 17 14"
                                                                                  fill="none"
                                                                                  xmlns="http://www.w3.org/2000/svg">
<path d="M16.3929 0H0.607143C0.271317 0 0 0.284375 0 0.636364V3.81818H17V0.636364C17 0.284375 16.7287 0 16.3929 0ZM0 13.3636C0 13.7156 0.271317 14 0.607143 14H16.3929C16.7287 14 17 13.7156 17 13.3636V5.56818H0V13.3636ZM10.9855 9.70455C10.9855 9.61705 11.0538 9.54545 11.1373 9.54545H14.2679C14.3513 9.54545 14.4196 9.61705 14.4196 9.70455V11.1364C14.4196 11.2239 14.3513 11.2955 14.2679 11.2955H11.1373C11.0538 11.2955 10.9855 11.2239 10.9855 11.1364V9.70455Z"
      fill="white"/>
</svg>
</span> <?= Loc::getMessage('PAY_CARD'); ?>

                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="promote-card">
                                        <!-- ID "headingSelectRiddonItem" shold be UNIC for every product card -->
                                        <div class="card-header" id="headingSelectRiddonItem">
                                            <!-- data-target="#selectRiddonItem" depend on "accordionUserItem<?= $arResult['ID'] ?>" -->
                                            <!-- aria-controls="selectRiddonItem" depend on "headingRiseItem" -->
                                            <button class="btn btn-link btn-block text-right collapsed"
                                                    type="button" data-toggle="collapse"
                                                    data-target="#selectRiddonItem<?= $arResult['ID'] ?>"
                                                    aria-expanded="false"
                                                    aria-controls="selectRiddonItem">
                                                <div class="pr-4 d-flex justify-content-between align-items-center">
                                                    <span class="plus"></span>
                                                    <span class="card-header__title"><?= Loc::getMessage('LENT_PAKET'); ?></span>

                                                </div>

                                                <span class="card-header__icon"><svg width="16"
                                                                                     height="16"
                                                                                     viewBox="0 0 16 16"
                                                                                     fill="none"
                                                                                     xmlns="http://www.w3.org/2000/svg">
<rect width="9.40476" height="6.83184" rx="0.5"
      transform="matrix(0.977206 -0.212292 0.118541 0.992949 0.503906 9.04102)" fill="#FB2BFF"/>
<rect width="10.4788" height="6.83184" rx="0.5" transform="matrix(0.977206 -0.212292 0.118541 0.992949 4.87109 3.15161)"
      fill="#FB2BFF"/>
<path d="M5.58984 9.95654L9.93666 9.01223L10.4706 13.4847L5.58984 9.95654Z" fill="#961299"/>
</svg>
</span>
                                            </button>
                                        </div>

                                        <!-- ID "selectRiddonItem" shold be UNIC for every product card -->
                                        <!-- aria-labelledby="headingSelectRiddonItem" data-parent="#accordionUserItem<?= $arResult['ID'] ?>" -->
                                        <div id="selectRiddonItem<?= $arResult['ID'] ?>" class="collapse"
                                             aria-labelledby="headingSelectRiddonItem"
                                             data-parent="#accordionUserItem<?= $arResult['ID'] ?>">
                                            <div class="p-3 bg-lightgray">
                                                <? $APPLICATION->IncludeComponent(
                                                    "bitrix:main.include",
                                                    "",
                                                    array(
                                                        "AREA_FILE_SHOW" => "file",
                                                        "AREA_FILE_SUFFIX" => "inc",
                                                        "EDIT_TEMPLATE" => "",
                                                        "PATH" => "/include-area/up-lent-" . LANGUAGE_ID . ".php"
                                                    )
                                                ); ?>

                                                <p class="mb-3 font-weight-bold content-subtitle">
                                                    <?= Loc::getMessage('type_item') ?></p>
                                                <form id="formProdactLent3">
                                                    <div class="mb-4 px-3 card">
                                                        <? foreach ($arTypesLent as $arRise) { ?>
                                                            <? if ($arRise['UF_COUNT'] > 0) { ?>
                                                                <div class="py-3 border-bottom d-flex justify-content-between">
                                                                    <span class="font-weight-bold"><?= $arRise["UF_PRICE"] ?> T</span>

                                                                    <label class="custom-radio-btn">
                                                                        <input type="radio"
                                                                               value="<?= $arRise["UF_COUNT"] ?>"
                                                                               data-price="<?= $arRise["UF_PRICE"] ?>"
                                                                               data-price-shek="<?= $arRise["UF_PRICE_SHEK"] ?>"
                                                                               data-xml-id="<?= $arRise["UF_XML_ID_LENT"] ?>"
                                                                               name="riseProduct">
                                                                        <div class="d-flex marker">
                                                                            <div class="d-flex flex-column decor-rec"
                                                                                 style="border-color: #<?= $arRise["UF_COLOUR"] ?>;">
                                                                                <div class="rec-top"></div>
                                                                                <div class="rec-bottom"></div>
                                                                            </div>

                                                                            <div class="text"
                                                                                 style="background-color: #<?= $arRise["UF_COLOUR"] ?>;">
                                                                                <?= $arRise["UF_NAME"] ?>
                                                                            </div>
                                                                        </div>
                                                                        <span class="checkbox"></span>
                                                                    </label>
                                                                </div>
                                                            <? }
                                                        } ?>
                                                    </div>
                                                </form>
                                                <p class="mb-3 font-weight-bold content-subtitle">
                                                    <?= Loc::getMessage('PAY_CHOISE'); ?>
                                                    :</p>

                                                <div class="d-flex flex-column justify-content-end align-items-end">
                                                    <button type="button"
                                                            onclick="countLentaBuy(<?= $arResult['ID'] ?>, $('#formProdactLent3'), <?= $arResult['IBLOCK_ID'] ?>)"
                                                            data-toggle="modal" data-target="#payTcoins"
                                                            class="mb-3 btn btn-primary btn-paid"><span
                                                                class="mr-2"><svg width="17" height="17"
                                                                                  viewBox="0 0 17 17" fill="none"
                                                                                  xmlns="http://www.w3.org/2000/svg"><path
                                                                        d="M11.8169 0.00066338C8.95442 0.00066338 6.63389 1.28034 6.63389 2.8612C6.63389 4.44205 8.95508 5.72239 11.8169 5.72239C14.6795 5.72239 17 4.44205 17 2.8612C17 1.28034 14.6788 0 11.8169 0V0.00066338ZM17 3.711C16.9987 5.29185 14.6795 6.57219 11.8169 6.57219C8.96238 6.57219 6.64716 5.30578 6.63389 3.73223V4.85136C6.63389 5.52669 7.06642 6.14497 7.77492 6.63455C8.49138 6.82959 9.12956 7.10025 9.66093 7.44256C10.3197 7.60973 11.0441 7.71189 11.8169 7.71189C14.6795 7.71189 17 6.43222 17 4.85136V3.711ZM17 5.70116C17 7.28202 14.6795 8.56236 11.8169 8.56236C11.4687 8.56236 11.1303 8.53649 10.8013 8.5C11.0609 8.84969 11.2381 9.25361 11.3194 9.6815C11.4846 9.69078 11.6478 9.70206 11.8169 9.70206C14.6795 9.70206 17 8.42238 17 6.84153V5.70116ZM5.18306 7.29728C2.32053 7.29728 0 8.57762 0 10.1585C0 11.7393 2.3212 13.0197 5.18306 13.0197C8.04558 13.0197 10.3661 11.7393 10.3661 10.1585C10.3661 8.57762 8.04492 7.29728 5.18306 7.29728ZM17 7.69133C16.9987 9.27219 14.6795 10.5525 11.8169 10.5525C11.6504 10.5525 11.4819 10.5406 11.3194 10.5313C11.3121 10.5811 11.3081 10.6474 11.2988 10.6971C11.332 10.7973 11.3605 10.8962 11.3605 11.0089V11.6723C11.5111 11.6796 11.6624 11.6922 11.8169 11.6922C14.6795 11.6922 17 10.4125 17 8.83169V7.69133ZM17 9.6815C16.9987 11.2624 14.6795 12.5427 11.8169 12.5427C11.6504 12.5427 11.4819 12.5308 11.3194 12.5215C11.3121 12.5712 11.3081 12.6376 11.2988 12.6873C11.332 12.7868 11.3605 12.8863 11.3605 12.9991V13.6625C11.5111 13.6698 11.6624 13.6824 11.8169 13.6824C14.6795 13.6824 17 12.4027 17 10.8219V9.6815ZM10.3661 11.0083C10.3648 12.5891 8.04558 13.8695 5.18306 13.8695C2.32849 13.8695 0.0132678 12.6031 0 11.0288V12.1486C0 13.7295 2.31987 15.0098 5.18306 15.0098C8.04624 15.0098 10.3661 13.7295 10.3661 12.1486V11.0083ZM10.3661 12.9984C10.3648 14.5793 8.04558 15.8596 5.18306 15.8596C2.32849 15.8596 0.0132678 14.5932 0 13.019V14.1388C0 15.7197 2.31987 17 5.18306 17C8.04624 17 10.3661 15.7197 10.3661 14.1388V12.9984Z"
                                                                        fill="white"/></svg>
                                                                                    </span>
                                                        <?= Loc::getMessage('PAY_T_COINS'); ?>

                                                    </button>
                                                    <button type="button"
                                                            onclick="countLentaBuyShek(<?= $arResult['ID'] ?>, $('#formProdactLent3'), <?= $arResult['IBLOCK_ID'] ?>)"

                                                            class="btn btn-primary btn-paid"><span
                                                                class="mr-2"><svg width="17"
                                                                                  height="14"
                                                                                  viewBox="0 0 17 14"
                                                                                  fill="none"
                                                                                  xmlns="http://www.w3.org/2000/svg">
<path d="M16.3929 0H0.607143C0.271317 0 0 0.284375 0 0.636364V3.81818H17V0.636364C17 0.284375 16.7287 0 16.3929 0ZM0 13.3636C0 13.7156 0.271317 14 0.607143 14H16.3929C16.7287 14 17 13.7156 17 13.3636V5.56818H0V13.3636ZM10.9855 9.70455C10.9855 9.61705 11.0538 9.54545 11.1373 9.54545H14.2679C14.3513 9.54545 14.4196 9.61705 14.4196 9.70455V11.1364C14.4196 11.2239 14.3513 11.2955 14.2679 11.2955H11.1373C11.0538 11.2955 10.9855 11.2239 10.9855 11.1364V9.70455Z"
      fill="white"/>
</svg>
</span> <?= Loc::getMessage('PAY_CARD'); ?>

                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="promote-card">
                                        <!-- ID "headingBustPack" shold be UNIC for every product card -->
                                        <div class="card-header" id="headingBustPack">
                                            <!-- Change for every button "data-target", "aria-controls" data value "#ID under section"-->
                                            <button class="btn btn-link btn-block text-right collapsed"
                                                    type="button" data-toggle="collapse"
                                                    data-target="#bustPack<?= $arResult['ID'] ?>"
                                                    aria-expanded="false"
                                                    aria-controls="bustPack">
                                                <div class="pr-4 d-flex justify-content-between align-items-center">
                                                    <span class="plus"></span>
                                                    <span class="card-header__title"><?= Loc::getMessage('UP_COMPLEX'); ?></span>

                                                </div>
                                                <span class="card-header__icon"><svg width="16"
                                                                                     height="18"
                                                                                     viewBox="0 0 16 18"
                                                                                     fill="none"
                                                                                     xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd"
      d="M10.7811 0.968714C10.7811 0.792056 10.7264 0.619732 10.6246 0.475353C10.5228 0.330975 10.3789 0.221608 10.2125 0.16224C10.0461 0.102871 9.86545 0.0964054 9.69525 0.143729C9.52505 0.191053 9.37365 0.289851 9.26179 0.426584L0.697334 9.84749C0.594729 9.97297 0.529841 10.125 0.510211 10.2859C0.49058 10.4468 0.517013 10.61 0.586437 10.7564C0.655861 10.9029 0.765426 11.0267 0.902399 11.1133C1.03937 11.2 1.19813 11.246 1.36022 11.2461H5.64245V16.3847C5.64248 16.5614 5.69714 16.7337 5.79894 16.8781C5.90074 17.0225 6.04469 17.1318 6.21107 17.1912C6.37746 17.2506 6.55813 17.257 6.72833 17.2097C6.89853 17.1624 7.04993 17.0636 7.16179 16.9269L15.7262 7.50596C15.8288 7.38048 15.8937 7.22845 15.9134 7.06755C15.933 6.90666 15.9066 6.74349 15.8371 6.59702C15.7677 6.45054 15.6582 6.32678 15.5212 6.24011C15.3842 6.15343 15.2254 6.10741 15.0634 6.10739H10.7811V0.968714Z"
      fill="#FF6B00"/>
</svg>
</span>
                                            </button>
                                        </div>

                                        <div id="bustPack<?= $arResult['ID'] ?>" class="collapse"
                                             aria-labelledby="headingBustPack"
                                             data-parent="#accordionUserItem<?= $arResult['ID'] ?>">
                                            <div class="p-3 bg-lightgray">
                                                <? $APPLICATION->IncludeComponent(
                                                    "bitrix:main.include",
                                                    "",
                                                    array(
                                                        "AREA_FILE_SHOW" => "file",
                                                        "AREA_FILE_SUFFIX" => "inc",
                                                        "EDIT_TEMPLATE" => "",
                                                        "PATH" => "/include-area/up-paket-" . LANGUAGE_ID . ".php"
                                                    )
                                                ); ?>

                                                <p class="mb-3 font-weight-bold content-subtitle">
                                                    <?= Loc::getMessage('type_item') ?></p>

                                                <form id="formProdactPaket3">
                                                    <div class="mb-4 px-3 card"
                                                         id="accordionSection<?= $arResult['ID'] ?>">
                                                        <? foreach ($arTypesPaket as $arRise) { ?>
                                                            <? if ($arRise['UF_PRICE'] > 0) { ?>
                                                                <div class="py-3 border-bottom d-flex justify-content-between"
                                                                     id="tipe1">
                                                                    <span class="font-weight-bold"><?= $arRise['UF_PRICE'] ?> T</span>

                                                                    <label class="custom-radio-btn">
                                                                        <!-- Change for every button "data-target", "aria-controls" data value "#ID under section"-->
                                                                        <input type="radio"
                                                                               value="<?= $arRise["ID"] ?>"
                                                                               data-price="<?= $arRise["UF_PRICE"] ?>"
                                                                               data-UF_RISE_COUNT="<?= $arRise["UF_RISE_COUNT"] ?>"
                                                                               data-UF_RISE_DAY="<?= $arRise["UF_RISE_DAY"] ?>"
                                                                               data-UF_LENTA="<?= $arRise["UF_LENTA"] ?>"
                                                                               data-UF_VIP="<?= $arRise["UF_VIP"] ?>"
                                                                               data-UF_COLOUR="<?= $arRise["UF_COLOUR"] ?>"
                                                                               data-UF_XML_ID_LENT="<?= $arRise["UF_XML_ID_LENT"] ?>"

                                                                               data-price-shek="<?= $arRise["UF_PRICE_SHEK"] ?>"
                                                                               name="riseProduct"
                                                                               data-toggle="collapse"
                                                                               data-target="#collapsePaket<?= $arResult['ID'] . $arRise['ID'] ?>"
                                                                               aria-expanded="true"

                                                                               aria-controls="collapseOne">
                                                                        <span><?= $arRise['UF_NAME'] ?></span>
                                                                        <span class="checkbox"></span>
                                                                    </label>
                                                                </div>

                                                                <div id="collapsePaket<?= $arResult['ID'] . $arRise['ID'] ?>"
                                                                     class="collapse"
                                                                     aria-labelledby="tipe1"
                                                                     data-parent="#accordionSection<?= $arResult['ID'] ?>">
                                                                    <div class="p-3 d-flex flex-column new-collapse">
                                                                        <p class="mb-4 text-uppercase font-weight-bold">
                                                                            <?= $arRise['UF_BIG_TEXT1'] ?>
                                                                        </p>

                                                                        <p class="text-right">
                                                                            <?= $arRise['UF_STANDART_TEXT'] ?>
                                                                        </p>

                                                                        <div class="d-flex position-relative justify-content-end pr-5">
                                                                            <p class="text-right"><?= $arRise['UF_RISE_DAY'] ?>
                                                                                поднятие
                                                                                в
                                                                                день - на <span
                                                                                        class="font-weight-bold"><?= $arRise['UF_RISE_COUNT'] ?></span>
                                                                                дней <span
                                                                                        class="font-weight-bold">(первое - завтра)</span>
                                                                            </p>

                                                                            <div class="circle-icon">
                                                                                <div class="d-flex justify-content-center align-items-center user-product__up-product">
                                                                                                <span data-id="<?= $arResult['ID'] ?>"
                                                                                                      class="text-uppercase font-weight-bold upRise">UP</span>

                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="d-flex position-relative justify-content-end pr-5">
                                                                            <p class="text-right">Выделение
                                                                                - на
                                                                                <span class="font-weight-bold"><?= $arRise['UF_LENTA'] ?></span>
                                                                                дней</p>

                                                                            <div class="circle-icon">
                                                                                <svg width="16" height="16"
                                                                                     viewBox="0 0 16 16"
                                                                                     fill="none"
                                                                                     xmlns="http://www.w3.org/2000/svg">
                                                                                    <rect width="9.40476"
                                                                                          height="6.83184"
                                                                                          rx="0.5"
                                                                                          transform="matrix(0.977206 -0.212292 0.118541 0.992949 0.503906 9.04102)"
                                                                                          fill="#FB2BFF"/>
                                                                                    <rect width="10.4788"
                                                                                          height="6.83184"
                                                                                          rx="0.5"
                                                                                          transform="matrix(0.977206 -0.212292 0.118541 0.992949 4.87109 3.15161)"
                                                                                          fill="#FB2BFF"/>
                                                                                    <path d="M5.58984 9.95654L9.93666 9.01223L10.4706 13.4847L5.58984 9.95654Z"
                                                                                          fill="#961299"/>
                                                                                </svg>

                                                                            </div>
                                                                        </div>

                                                                        <div class="d-flex position-relative justify-content-end pr-5">
                                                                            <p class="text-right">VIP -
                                                                                закрепление - на <span
                                                                                        class="font-weight-bold"><?= $arRise['UF_VIP'] ?></span>
                                                                                дня</p>

                                                                            <div class="circle-icon">
                                                                                <svg width="22" height="19"
                                                                                     viewBox="0 0 22 19"
                                                                                     fill="none"
                                                                                     xmlns="http://www.w3.org/2000/svg">
                                                                                    <path d="M1.58936 3.42876L5.88549 6.18822L10.1673 0.413067C10.2619 0.285313 10.3868 0.181179 10.5317 0.109331C10.6765 0.0374835 10.837 0 10.9999 0C11.1628 0 11.3234 0.0374835 11.4682 0.109331C11.613 0.181179 11.7379 0.285313 11.8326 0.413067L16.1144 6.18822L20.4105 3.42876C20.5731 3.32454 20.7633 3.26734 20.9585 3.26392C21.1538 3.2605 21.346 3.31101 21.5124 3.40947C21.6788 3.50793 21.8125 3.65023 21.8976 3.81956C21.9828 3.98888 22.0159 4.17815 21.9929 4.36501L20.3123 18.1298C20.283 18.3695 20.1634 18.5905 19.9762 18.7509C19.7889 18.9113 19.5471 19 19.2966 19H2.70328C2.45274 19 2.21093 18.9113 2.0237 18.7509C1.83648 18.5905 1.71687 18.3695 1.68755 18.1298L0.00694712 4.36402C-0.015761 4.17725 0.0174677 3.98811 0.102711 3.81895C0.187954 3.64978 0.321652 3.50764 0.488023 3.40931C0.654394 3.31098 0.846492 3.26056 1.04164 3.26401C1.23679 3.26745 1.42684 3.32462 1.58936 3.42876ZM10.9999 13.0869C11.5425 13.0869 12.0629 12.8792 12.4465 12.5096C12.8302 12.1399 13.0457 11.6386 13.0457 11.1158C13.0457 10.5931 12.8302 10.0917 12.4465 9.72209C12.0629 9.35245 11.5425 9.14479 10.9999 9.14479C10.4574 9.14479 9.93701 9.35245 9.55335 9.72209C9.16969 10.0917 8.95416 10.5931 8.95416 11.1158C8.95416 11.6386 9.16969 12.1399 9.55335 12.5096C9.93701 12.8792 10.4574 13.0869 10.9999 13.0869Z"
                                                                                          fill="#F50000"/>
                                                                                </svg>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <? }
                                                        } ?>
                                                    </div>
                                                </form>

                                                <p class="mb-3 font-weight-bold content-subtitle">
                                                    <?= Loc::getMessage('PAY_CHOISE'); ?>
                                                    :</p>

                                                <div class="d-flex flex-column justify-content-end align-items-end">
                                                    <button type="button"
                                                            onclick="countPaketBuy(<?= $arResult['ID'] ?>, $('#formProdactPaket3'), <?= $arResult['IBLOCK_ID'] ?>)"
                                                            data-toggle="modal" data-target="#payTcoins"
                                                            class="mb-3 btn btn-primary btn-paid"><span
                                                                class="mr-2"><svg width="17" height="17"
                                                                                  viewBox="0 0 17 17" fill="none"
                                                                                  xmlns="http://www.w3.org/2000/svg"><path
                                                                        d="M11.8169 0.00066338C8.95442 0.00066338 6.63389 1.28034 6.63389 2.8612C6.63389 4.44205 8.95508 5.72239 11.8169 5.72239C14.6795 5.72239 17 4.44205 17 2.8612C17 1.28034 14.6788 0 11.8169 0V0.00066338ZM17 3.711C16.9987 5.29185 14.6795 6.57219 11.8169 6.57219C8.96238 6.57219 6.64716 5.30578 6.63389 3.73223V4.85136C6.63389 5.52669 7.06642 6.14497 7.77492 6.63455C8.49138 6.82959 9.12956 7.10025 9.66093 7.44256C10.3197 7.60973 11.0441 7.71189 11.8169 7.71189C14.6795 7.71189 17 6.43222 17 4.85136V3.711ZM17 5.70116C17 7.28202 14.6795 8.56236 11.8169 8.56236C11.4687 8.56236 11.1303 8.53649 10.8013 8.5C11.0609 8.84969 11.2381 9.25361 11.3194 9.6815C11.4846 9.69078 11.6478 9.70206 11.8169 9.70206C14.6795 9.70206 17 8.42238 17 6.84153V5.70116ZM5.18306 7.29728C2.32053 7.29728 0 8.57762 0 10.1585C0 11.7393 2.3212 13.0197 5.18306 13.0197C8.04558 13.0197 10.3661 11.7393 10.3661 10.1585C10.3661 8.57762 8.04492 7.29728 5.18306 7.29728ZM17 7.69133C16.9987 9.27219 14.6795 10.5525 11.8169 10.5525C11.6504 10.5525 11.4819 10.5406 11.3194 10.5313C11.3121 10.5811 11.3081 10.6474 11.2988 10.6971C11.332 10.7973 11.3605 10.8962 11.3605 11.0089V11.6723C11.5111 11.6796 11.6624 11.6922 11.8169 11.6922C14.6795 11.6922 17 10.4125 17 8.83169V7.69133ZM17 9.6815C16.9987 11.2624 14.6795 12.5427 11.8169 12.5427C11.6504 12.5427 11.4819 12.5308 11.3194 12.5215C11.3121 12.5712 11.3081 12.6376 11.2988 12.6873C11.332 12.7868 11.3605 12.8863 11.3605 12.9991V13.6625C11.5111 13.6698 11.6624 13.6824 11.8169 13.6824C14.6795 13.6824 17 12.4027 17 10.8219V9.6815ZM10.3661 11.0083C10.3648 12.5891 8.04558 13.8695 5.18306 13.8695C2.32849 13.8695 0.0132678 12.6031 0 11.0288V12.1486C0 13.7295 2.31987 15.0098 5.18306 15.0098C8.04624 15.0098 10.3661 13.7295 10.3661 12.1486V11.0083ZM10.3661 12.9984C10.3648 14.5793 8.04558 15.8596 5.18306 15.8596C2.32849 15.8596 0.0132678 14.5932 0 13.019V14.1388C0 15.7197 2.31987 17 5.18306 17C8.04624 17 10.3661 15.7197 10.3661 14.1388V12.9984Z"
                                                                        fill="white"/></svg>
                                                                                    </span>
                                                        <?= Loc::getMessage('PAY_T_COINS'); ?>

                                                    </button>
                                                    <button type="button"
                                                            onclick="countPaketBuyShek(<?= $arResult['ID'] ?>, $('#formProdactPaket3'), <?= $arResult['IBLOCK_ID'] ?>)"

                                                            class="btn btn-primary btn-paid"><span
                                                                class="mr-2"><svg width="17"
                                                                                  height="14"
                                                                                  viewBox="0 0 17 14"
                                                                                  fill="none"
                                                                                  xmlns="http://www.w3.org/2000/svg">
<path d="M16.3929 0H0.607143C0.271317 0 0 0.284375 0 0.636364V3.81818H17V0.636364C17 0.284375 16.7287 0 16.3929 0ZM0 13.3636C0 13.7156 0.271317 14 0.607143 14H16.3929C16.7287 14 17 13.7156 17 13.3636V5.56818H0V13.3636ZM10.9855 9.70455C10.9855 9.61705 11.0538 9.54545 11.1373 9.54545H14.2679C14.3513 9.54545 14.4196 9.61705 14.4196 9.70455V11.1364C14.4196 11.2239 14.3513 11.2955 14.2679 11.2955H11.1373C11.0538 11.2955 10.9855 11.2239 10.9855 11.1364V9.70455Z"
      fill="white"/>
</svg>
</span> <?= Loc::getMessage('PAY_CARD'); ?>

                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <script>
                                $('#dropdownMenuLink<?=$arResult['ID']?>').on('click', (e) => {
                                    e.preventDefault()
                                    $('#accordionUserItemWrap<?=$arResult['ID']?>').toggleClass('active')
                                })
                            </script>
                        </div>
                    </div>
                <? } else { ?>

                    <div class="mb-4 card connection-with-seller text-right">
                        <h1 class="mb-4 connection-with-seller__title"><?= $arResult['NAME']; ?></h1>

                        <p class="mb-4 connection-with-seller__price text-primary">
                            <?= number_format($arResult['PROPERTIES']['PRICE']['VALUE'], 0, '.', ' '); ?> <?= ICON_CURRENCY; ?>
                        </p>

                        <? if (!empty($arResult['PROPERTIES']['UF_REGION']['~VALUE'])) { ?>
                            <p class="pb-3 border-bottom">
                                <span class="mr-1"><?= $arResult['PROPERTIES']['UF_CITY']['VALUE']; ?> <?= (!empty($arResult['PROPERTIES']['UF_CITY']['VALUE'])) ? ',' : '' ?> <?= $arResult['PROPERTIES']['UF_REGION']['VALUE']; ?></span>
                                <svg class="icon-local"
                                     style="position: relative; width: 16px; top: -2px; fill: #747474" version="1.1"
                                     id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                     xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                     viewBox="0 0 513.597 513.597" xml:space="preserve">
                                      <g>
                                          <path d="M263.278,0.107C158.977-3.408,73.323,80.095,73.323,183.602c0,117.469,112.73,202.72,175.915,325.322
                                        c3.208,6.225,12.169,6.233,15.388,0.009c57.16-110.317,154.854-184.291,172.959-290.569
                                        C456.331,108.387,374.776,3.866,263.278,0.107z M256.923,279.773c-53.113,0-96.171-43.059-96.171-96.171
                                        s43.059-96.171,96.171-96.171c53.113,0,96.172,43.059,96.172,96.171S310.036,279.773,256.923,279.773z"></path>
                                      </g>
                                    </svg>
                            </p>
                        <? } ?>


                        <div class="row no-gutters">
                            <button class="mr-2 col btn btn-show-phone text-uppercase font-weight-bold"
                                    data-toggle="collapse" href="#showContactPhone" role="button" aria-expanded="false"
                                    aria-controls="showContactPhone"><?= Loc::getMessage('SHOW_PHONE'); ?>
                            </button>

                            <button class="ml-2 col btn btn-primary text-uppercase font-weight-bold" data-toggle="modal"
                                    data-target="#modalSandMessage"><?= Loc::getMessage('SEND_MESSAGE'); ?>
                            </button>
                        </div>

                        <ul class="text-right collapse contact-list" id="showContactPhone">
                            <li class="d-flex justify-content-end">
                                <p class="mb-0 d-flex align-items-center time">
                                    <? if ($arResult['PROPERTIES']['UF_CALL_ANYTIME']['VALUE'] == 1) { ?>
                                        <span class="mx-2"><?= Loc::getMessage('CALL_ANYTIME'); ?></span>
                                    <? } else { ?>

                                        from<span
                                                class="mx-2"><?= $arResult['PROPERTIES']['UF_CALL_FROM']['VALUE'] ?></span>
                                        to <span
                                                class="mx-2"><?= $arResult['PROPERTIES']['UF_CALL_TO']['VALUE'] ?></span>
                                    <? } ?>
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9.99 0C4.47 0 0 4.48 0 10C0 15.52 4.47 20 9.99 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 9.99 0ZM10 18C5.58 18 2 14.42 2 10C2 5.58 5.58 2 10 2C14.42 2 18 5.58 18 10C18 14.42 14.42 18 10 18ZM9.78 5H9.72C9.32 5 9 5.32 9 5.72V10.44C9 10.79 9.18 11.12 9.49 11.3L13.64 13.79C13.98 13.99 14.42 13.89 14.62 13.55C14.6702 13.469 14.7036 13.3788 14.7182 13.2846C14.7328 13.1905 14.7283 13.0943 14.705 13.002C14.6817 12.9096 14.64 12.8229 14.5824 12.7469C14.5249 12.671 14.4526 12.6074 14.37 12.56L10.5 10.26V5.72C10.5 5.32 10.18 5 9.78 5Z"
                                              fill="#555555"/>
                                    </svg>

                                </p>
                            </li>
                            <? if ($arResult['PROPERTIES']['UF_PHONE_1']['VALUE']) { ?>
                                <li>
                                    <a href="tel:<?= $arResult['PROPERTIES']['UF_PHONE_1']['VALUE'] ?>"><?= $arResult['PROPERTIES']['UF_PHONE_1']['VALUE'] ?></a>
                                </li>
                            <? } ?>
                            <? if ($arResult['PROPERTIES']['UF_PHONE_2']['VALUE']) { ?>
                                <li>
                                    <a href="tel:<?= $arResult['PROPERTIES']['UF_PHONE_2']['VALUE'] ?>"><?= $arResult['PROPERTIES']['UF_PHONE_2']['VALUE'] ?></a>
                                </li>
                            <? } ?>
                            <? if ($arResult['PROPERTIES']['UF_PHONE_3']['VALUE']) { ?>
                                <li>
                                    <a href="tel:<?= $arResult['PROPERTIES']['UF_PHONE_3']['VALUE'] ?>"><?= $arResult['PROPERTIES']['UF_PHONE_3']['VALUE'] ?></a>
                                </li>
                            <? } ?>
                        </ul>
                    </div>
                <? } ?>

            </div>
            <div class="mb-5 card mainCardDesktop">
                <div class="about-auto">
                    <div class="mb-4 text-right seller-comment">
                        <? if (!empty($arResult['~PREVIEW_TEXT']) && (int)strlen(trim($arResult['~PREVIEW_TEXT'])) > 0) { ?>
                            <h4 class="mb-5 font-weight-bold text-uppercase"><?=Loc::getMessage('sellerComment')?></h4>

                            <p>
                                <?= $arResult['~PREVIEW_TEXT']; ?>
                            </p>
                        <? } ?>
                    </div>
                    <?
                    $count = 0;
                    foreach ($arResult['PROPERTIES'] as $PROPERTY) {
                        if ($PROPERTY['MULTIPLE'] == 'Y' && $PROPERTY['ID'] != '53' && $PROPERTY['CODE'] != 'PHOTOS' && $PROPERTY['VALUE'] != null) {
                        $count++;
                        }
                    }
                    if ($count > 0){
                        ?>
                        <h5 class="mb-4 text-right font-weight-bolder text-uppercase"><?=Loc::getMessage('equipment')?></h5>
                        <?
                    }
                    unset($count);
                    ?>

                    <? foreach ($arResult['PROPERTIES'] as $PROPERTY) {
                        if ($PROPERTY['MULTIPLE'] == 'Y' && $PROPERTY['ID'] != '53' && $PROPERTY['CODE'] != 'PHOTOS' && $PROPERTY['VALUE'] != null && strpos($PROPERTY['CODE'], "_Left") === false) {
                            ?>
                            <div class="pb-3 border-top d-flex justify-content-between" data-toggle="collapse"
                                 href="#collapse<?= $PROPERTY["CODE"] ?>" role="button" aria-expanded="false"
                                 aria-controls="collapse<?= $PROPERTY["HINT"] ?>">
                                <span><i class="mr-3 icon-arrow-down-sign-to-navigate-3"></i><?= count($PROPERTY["VALUE"]) ?> אופציות</span>
                                <span class="font-weight-bold"><?= $PROPERTY["HINT"] ?>    :</span>
                            </div>
                            <div class="collapse show" id="collapse<?= $PROPERTY["CODE"] ?>">
                                <div class="row flex-row-reverse text-right">
                                    <div style="display: none">
                                        <? $col = 0; ?>
                                        <? foreach ($PROPERTY['VALUE'] as $item) { ?>
                                        <? if ($col == 0 || $col == 2 || $col == 5){ ?>
                                    </div>
                                    <div class="col-3">
                                        <p><?= $item ?></p>
                                        <? } else { ?>
                                            <p><?= $item ?></p>
                                        <? } ?>
                                        <? $col++; ?>
                                        <? } ?>
                                    </div>
                                </div>
                            </div>
                        <? }
                    } ?>


                    <div class="mt-3 pt-3 border-top d-flex justify-content-between">
                        <div class="viewers">
                            <span class="mr-2"><? $res = CIBlockElement::GetByID($arResult["ID"]);
                                if ($ar_res = $res->GetNext())
                                    echo $ar_res['SHOW_COUNTER'];
                                ?></span>
                            <i class="icon-visibility"></i>
                        </div>
                        <?
                        $strDate = getStringDate($arResult['DATE_CREATE']);
                        ?>
                        <div class="date"><?= ($strDate['MES']) ? GetMessage($strDate['MES']) . ', ' . $strDate['HOURS'] : $strDate['HOURS']; ?></div>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <? if ($arResult['SIMILAR']) { ?>
        <h2 class="mb-4 subtitle">
            <?= Loc::getMessage('SIMILAR'); ?>
        </h2>
        <div class="similar-products-slider">
            <? foreach ($arResult['SIMILAR'] as $arItem) { ?>
                <?
                $color = '';
                if ($arItem['PROPERTY_COLOR_DATE_VALUE'] && strtotime($arItem['PROPERTY_COLOR_DATE_VALUE']) > time())
                    $color = '#FFF5D9';
                ?>
                <div class="card product-card" style="background-color: <?= $color; ?>">
                    <div class="image-block">
                        <div class="i-box">
                            <a href="<?= $arItem['DETAIL_PAGE_URL']; ?>"><img
                                        src="<?= CFile::GetPath($arItem['PREVIEW_PICTURE']); ?>" alt="no-img"></a>
                        </div>
                    </div>
                    <div class="px-2 px-lg-3 d-flex justify-content-between">
                        <? if ($USER->IsAuthorized()) { ?>
                            <p class="mb-0 like followThisItem" data-ad_id="<?= $arItem['ID']; ?>">
                                <svg id="iconLike" class="iconLike" viewBox="0 0 612 792">
                                    <path d="M562.413,284.393c-9.68,41.044-32.121,78.438-64.831,108.07L329.588,542.345l-165.11-149.843 c-32.771-29.691-55.201-67.076-64.892-108.12c-6.965-29.484-4.103-46.14-4.092-46.249l0.147-0.994 c6.395-72.004,56.382-124.273,118.873-124.273c46.111,0,86.703,28.333,105.965,73.933l9.061,21.477l9.061-21.477 c18.958-44.901,61.694-73.922,108.896-73.922c62.481,0,112.478,52.27,119,125.208C566.517,238.242,569.379,254.908,562.413,284.393z"/>
                                </svg>
                            </p>
                            <?
                        } else { ?>
                            <a data-toggle="modal" data-target="#registerModal" class="d-flex align-items-center mr-3"
                               href="#">
                                <p class="mb-0 like followThisItem" data-ad_id="">
                                    <svg class="iconLike" viewBox="0 0 612 792">
                                        <path d="M562.413,284.393c-9.68,41.044-32.121,78.438-64.831,108.07L329.588,542.345l-165.11-149.843 c-32.771-29.691-55.201-67.076-64.892-108.12c-6.965-29.484-4.103-46.14-4.092-46.249l0.147-0.994 c6.395-72.004,56.382-124.273,118.873-124.273c46.111,0,86.703,28.333,105.965,73.933l9.061,21.477l9.061-21.477 c18.958-44.901,61.694-73.922,108.896-73.922c62.481,0,112.478,52.27,119,125.208C566.517,238.242,569.379,254.908,562.413,284.393z"/>
                                    </svg>
                                </p>
                            </a>
                            <?
                        } ?>

                        <p class="mb-0 price"><?= ICON_CURRENCY; ?> <?= number_format($arItem['PROPERTY_PRICE_VALUE'], 0, '.', ' '); ?></p>
                    </div>

                    <div class="px-2 px-lg-3 content-block">
                        <div class="text-right">
                            <a class="mb-2 mb-lg-3 title"
                               href="<?= $arItem['DETAIL_PAGE_URL']; ?>"><?= $arItem['NAME']; ?></a>
                        </div>

                        <div class="border-top py-2 py-lg-3 d-flex justify-content-between align-items-center text-nowrap">
                            <? if ($arItem['SHOW_COUNTER']) { ?>
                                <span class="mr-0 mr-lg-2 views"><span><?= $arItem['SHOW_COUNTER']; ?></span> <i
                                            class="icon-visibility"></i></span>
                            <? } ?>
                            <?
                            $strDate = getStringDate($arItem['DATE_CREATE']);
                            ?>
                            <span class="date"><?= ($strDate['MES']) ? GetMessage($strDate['MES']) . ', ' . $strDate['HOURS'] : $strDate['HOURS']; ?></span>
                        </div>
                    </div>
                    <?
                    if ($arItem['TAPE'] && (strtotime($arItem['PROPERTY_LENTA_DATE_VALUE']) > time())) {
                        ?>
                        <div class="d-flex marker">
                            <div class="d-flex flex-column decor-rec"
                                 style="border-color: <?= $arItem['TAPE']['UF_COLOR']; ?>;">
                                <div class="rec-top"></div>
                                <div class="rec-bottom"></div>
                            </div>
                            <div class="text"
                                 style="background-color: <?= $arItem['TAPE']['UF_COLOR']; ?>;"><?= $arItem['TAPE']['UF_NAME_' . mb_strtoupper($arSetting[SITE_ID]['lang'])]; ?></div>
                        </div>
                        <?
                    }
                    ?>
                </div>
            <? } ?>
        </div>
    <? } ?>
</div>
<? if ($arParams['USER_ID'] and $USER->IsAuthorized()) { ?>
    <div class="mobile-block-show-contacts">
        <ul class="list-unstyled">
            <button type="button" class="close" id="closeNumberList">
                <span aria-hidden="true">&times;</span>
            </button>

            <li class="justify-content-end">
                <p class="mb-0 d-flex align-items-center time">
                    <? if ($arResult['PROPERTIES']['UF_CALL_ANYTIME']['VALUE'] == 1) { ?>
                        <span class="mx-2"><?= Loc::getMessage('CALL_ANYTIME'); ?></span>
                    <? } else { ?>

                        from<span class="mx-2"><?= $arResult['PROPERTIES']['UF_CALL_FROM']['VALUE'] ?></span>
                        to <span class="mx-2"><?= $arResult['PROPERTIES']['UF_CALL_TO']['VALUE'] ?></span>
                    <? } ?>
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9.99 0C4.47 0 0 4.48 0 10C0 15.52 4.47 20 9.99 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 9.99 0ZM10 18C5.58 18 2 14.42 2 10C2 5.58 5.58 2 10 2C14.42 2 18 5.58 18 10C18 14.42 14.42 18 10 18ZM9.78 5H9.72C9.32 5 9 5.32 9 5.72V10.44C9 10.79 9.18 11.12 9.49 11.3L13.64 13.79C13.98 13.99 14.42 13.89 14.62 13.55C14.6702 13.469 14.7036 13.3788 14.7182 13.2846C14.7328 13.1905 14.7283 13.0943 14.705 13.002C14.6817 12.9096 14.64 12.8229 14.5824 12.7469C14.5249 12.671 14.4526 12.6074 14.37 12.56L10.5 10.26V5.72C10.5 5.32 10.18 5 9.78 5Z"
                              fill="#555555"/>
                    </svg>

                </p>
            </li>

            <? if ($arResult['PROPERTIES']['UF_PHONE_1']['VALUE']) { ?>
                <li>
                    <a href="tel:<?= $arResult['PROPERTIES']['UF_PHONE_1']['VALUE'] ?>"><?= $arResult['PROPERTIES']['UF_PHONE_1']['VALUE'] ?></a>
                </li>
            <? } ?>
            <? if ($arResult['PROPERTIES']['UF_PHONE_2']['VALUE']) { ?>
                <li>
                    <a href="tel:<?= $arResult['PROPERTIES']['UF_PHONE_2']['VALUE'] ?>"><?= $arResult['PROPERTIES']['UF_PHONE_2']['VALUE'] ?></a>
                </li>
            <? } ?>
            <? if ($arResult['PROPERTIES']['UF_PHONE_3']['VALUE']) { ?>
                <li>
                    <a href="tel:<?= $arResult['PROPERTIES']['UF_PHONE_3']['VALUE'] ?>"><?= $arResult['PROPERTIES']['UF_PHONE_3']['VALUE'] ?></a>
                </li>
            <? } ?>
        </ul>

        <div class="button-wrap d-flex">
            <button class="btn btn-show-phone w-100 text-uppercase font-weight-bold"
                    id="showListUserNumber"><?= Loc::getMessage('SHOW_PHONE'); ?>
            </button>
            <button class="btn btn-primary btn-sand-message w-100 text-uppercase font-weight-bold" data-toggle="modal"
                    data-target="#modalSandMessage"><?= Loc::getMessage('SEND_MESSAGE'); ?>
            </button>
        </div>
    </div>
<? } ?>
<div class="modal fade modal-sand-message" id="modalSandMessage" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <button type="button" class="m-0 mr-auto close close-modal" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="p-4 modal-body">
                <h3 class="subtitle">
                    <?= $arResult['NAME']; ?>
                </h3>
                <form class="mb-0 form-group sendMessageForm" name="send_message" action="/ajax/send_message.php">
                    <?= bitrix_sessid_post() ?>
                    <input type="hidden" value="<?= $arResult['ID']; ?>" name="IDAd" id="idAd">
                    <textarea name="message" class="mb-4 form-control" id="messageContent" rows="5"
                              placeholder="<?=Loc::getMessage('textareaPlaceholder')?>" required></textarea>

                    <!-- BOX add upload file -->
                    <div id="fileUploaderRenderMessageContainer"
                         class="mb-4 d-flex justify-content-end flex-wrap fileUploaderRenderMessageContainer">
                        <input id="fileUploaderMessageFiles" class="d-none" type="file" name="files[]" multiple>
                    </div>
                    <!-- BOX add upload file END-->

                    <div class="d-flex justify-content-between align-items-center">
                        <!-- BUTTON add upload file -->
                        <div class="d-block">
                            <label for="fileUploaderMessageFiles" class="mb-0 text-primary labelAddFileMessage"><i
                                        class="mr-2 icon-add-file"></i><?= Loc::getMessage('add_file'); ?></label>
                        </div>
                        <!-- BUTTON add upload file END-->

                        <div>
                            <button type="button" class="btn btn-transparent" data-dismiss="modal"><?=Loc::getMessage('modalCloseBtn')?></button>
                            <button type="submit"
                                    class="py-2 px-4 btn btn-primary btn-rm-data"><?= Loc::getMessage('SEND_MESSAGE'); ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="allert alert-confirmation flex-column card">
    <button type="button" class="close" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
    <div class="d-flex justify-content-center allert__text">
        <?= Loc::getMessage('sended'); ?>
    </div>
</div>
<div class="modal fade" id="payTcoins" tabindex="-1" aria-labelledby="payTcoins" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content pt-3 pb-5 px-5">
            <div class="p-0 mb-4 border-bottom-0 modal-header justify-content-end">
                <h2 class="subtitle" id="exampleModalLabel"><?= Loc::getMessage('pay') ?></h2>
            </div>

            <div class="p-0 modal-body text-right">
                <p class="mb-4 text-uppercase font-weight-bold"><?= Loc::getMessage('BALANCE') ?> <span
                            id="payTcoinsBalance" class="text-primary">100 </span>TCOIN
                </p>
                <p class="mb-0 text-uppercase font-weight-bold"><?= Loc::getMessage('need_to_pay') ?> <span
                            id="payTcoinsNeedle" class="text-primary">80 </span>TCOIN
                </p>

                <hr>

                <p class="mb-3 text-uppercase font-weight-bold text-secondary"><?= Loc::getMessage('result') ?>
                    <span id="payTcoinsNeedleRes">20</span> TCOIN</p>
            </div>

            <div class="p-0 border-top-0 modal-footer">
                <button type="button" class="btn" data-dismiss="modal"><?= Loc::getMessage('Close') ?></button>
                <button id="buyItemFew" type="submit"
                        class="btn btn-primary"><?= Loc::getMessage('Make_pay') ?></button>
            </div>
        </div>
    </div>
</div>

<script>
    function countRiseBuy(id, el, eltrigger) {
        var price = 0;
        var count = 0;

        $(el).find('input').each(function () {

            if ($(this).is(':checked')) {
                count = $(this).val()
                price = $(this).data()

            }
        });
        console.log(price);
        $.ajax({
            url: '/ajax/buy_item.php',
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
                    $('#payTcoinsAtEnd').text('<?=Loc::getMessage('error_ajax')?>')
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
        console.log(price);
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
                    $('#payTcoinsAtEnd').text('<?=Loc::getMessage('error_ajax')?>')
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
        console.log(price);
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
                    $('#payTcoinsAtEnd').text('<?=Loc::getMessage('error_ajax')?>')
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
        console.log(price);
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
                            data: {idItem: id, count: count, iblock: eltrigger, price: price.price, xml: price.xmlId},
                            success: function (data) {
                                window.location.reload();
                            }
                        });
                    })
                } else {
                    $('#payTcoinsAtEnd').text('<?=Loc::getMessage('error_ajax')?>')
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
        console.log(price);
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
                    $('#payTcoinsAtEnd').text('<?=Loc::getMessage('error_ajax')?>')
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
        console.log(price);

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
        console.log(price);

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
        console.log(price);

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
        console.log(price);
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
</script>
<script>
    $('#dropdownMenuLink<?=$arResult['ID']?>').on('click', (e) => {
        e.preventDefault()
        $('#accordionUserItemWrap<?=$arResult['ID']?>').toggleClass('active')
    })
</script>