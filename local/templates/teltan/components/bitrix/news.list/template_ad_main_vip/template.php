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
$this->setFrameMode(true);
?>
<?
global $arSetting;
if ($arResult['ITEMS']) {
    ?>
    <div class="row row-cols-1 row-cols-lg-2">
        <? foreach ($arResult['ITEMS'] as $arItem) {
            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], $arItem["EDIT_LINK_TEXT"]);
            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], $arItem["DELETE_LINK_TEXT"], array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
            ?>
            <div class="mb-4 col" id="<?=$this->GetEditAreaID($arItem['ID'])?>">
                <div class="big-card-product">
                    <a href="<?= $arItem['DETAIL_PAGE_URL']; ?>" class="fake-link-card"></a>
                    <div class="p-3 p-lg-0 image-box">
                        <img onclick="window.location.href='<?= $arItem['DETAIL_PAGE_URL']; ?>'"
                             src="<?= $arItem['PREVIEW_450_377']; ?>" alt="<?= $arItem['NAME']; ?>">
                    </div>
                    <div class="data">
                        <? if ($arItem['SHOW_COUNTER']) {
                            ?>
                            <span class="mr-2"><span class="views"><?= $arItem['SHOW_COUNTER']; ?></span> <i
                                        class="icon-visibility"></i></span>
                        <? } ?>
                        <?
                        $strDate = getStringDate($arItem['DATE_CREATE']);
                        ?>
                        <span class="date"><?= ($strDate['MES']) ? GetMessage($strDate['MES']) . ', ' . $strDate['HOURS'] : $strDate['HOURS']; ?></span>
                    </div>

                    <?
                    if ($arItem['TAPE'] && (strtotime($arItem['PROPERTIES']['LENTA_DATE']['VALUE']) > time())) {
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

                    <div class="decor-crown-image">
                        <svg width="22" height="19" viewBox="0 0 22 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1.58936 3.42876L5.88549 6.18822L10.1673 0.413067C10.2619 0.285313 10.3868 0.181179 10.5317 0.109331C10.6765 0.0374835 10.837 0 10.9999 0C11.1628 0 11.3234 0.0374835 11.4682 0.109331C11.613 0.181179 11.7379 0.285313 11.8326 0.413067L16.1144 6.18822L20.4105 3.42876C20.5731 3.32454 20.7633 3.26734 20.9585 3.26392C21.1538 3.2605 21.346 3.31101 21.5124 3.40947C21.6788 3.50793 21.8125 3.65023 21.8976 3.81956C21.9828 3.98888 22.0159 4.17815 21.9929 4.36501L20.3123 18.1298C20.283 18.3695 20.1634 18.5905 19.9762 18.7509C19.7889 18.9113 19.5471 19 19.2966 19H2.70328C2.45274 19 2.21093 18.9113 2.0237 18.7509C1.83648 18.5905 1.71687 18.3695 1.68755 18.1298L0.00694712 4.36402C-0.015761 4.17725 0.0174677 3.98811 0.102711 3.81895C0.187954 3.64978 0.321652 3.50764 0.488023 3.40931C0.654394 3.31098 0.846492 3.26056 1.04164 3.26401C1.23679 3.26745 1.42684 3.32462 1.58936 3.42876ZM10.9999 13.0869C11.5425 13.0869 12.0629 12.8792 12.4465 12.5096C12.8302 12.1399 13.0457 11.6386 13.0457 11.1158C13.0457 10.5931 12.8302 10.0917 12.4465 9.72209C12.0629 9.35245 11.5425 9.14479 10.9999 9.14479C10.4574 9.14479 9.93701 9.35245 9.55335 9.72209C9.16969 10.0917 8.95416 10.5931 8.95416 11.1158C8.95416 11.6386 9.16969 12.1399 9.55335 12.5096C9.93701 12.8792 10.4574 13.0869 10.9999 13.0869Z"
                                  fill="#F50000"/>
                        </svg>

                    </div>

                    <div class="info d-flex flex-column flex-lg-row">
                        <div class="mr-0 mr-lg-4 d-flex">
                            <div class="d-flex justify-content-between justify-content-lg-end align-items-lg-center h-100 knock-stream">
                                <? if ($USER->IsAuthorized()) { ?>
                                    <p class="mr-3 mb-0 like" data-ad_id="<?= $arItem['ID']; ?>">
                                        <svg id="iconLike" class="iconLike" viewBox="0 0 612 792">
                                            <path d="M562.413,284.393c-9.68,41.044-32.121,78.438-64.831,108.07L329.588,542.345l-165.11-149.843 c-32.771-29.691-55.201-67.076-64.892-108.12c-6.965-29.484-4.103-46.14-4.092-46.249l0.147-0.994 c6.395-72.004,56.382-124.273,118.873-124.273c46.111,0,86.703,28.333,105.965,73.933l9.061,21.477l9.061-21.477 c18.958-44.901,61.694-73.922,108.896-73.922c62.481,0,112.478,52.27,119,125.208C566.517,238.242,569.379,254.908,562.413,284.393z"/>
                                        </svg>
                                    </p>
                                    <?
                                } else { ?>
                                    <a data-toggle="modal" data-target="#logInModal"
                                       class="d-flex align-items-center mr-3"
                                       href="#">
                                        <p class="mr-3 mb-0 like" data-ad_id="<?= $arItem['ID']; ?>">
                                            <svg id="iconLike" class="iconLike" viewBox="0 0 612 792">
                                                <path d="M562.413,284.393c-9.68,41.044-32.121,78.438-64.831,108.07L329.588,542.345l-165.11-149.843 c-32.771-29.691-55.201-67.076-64.892-108.12c-6.965-29.484-4.103-46.14-4.092-46.249l0.147-0.994 c6.395-72.004,56.382-124.273,118.873-124.273c46.111,0,86.703,28.333,105.965,73.933l9.061,21.477l9.061-21.477 c18.958-44.901,61.694-73.922,108.896-73.922c62.481,0,112.478,52.27,119,125.208C566.517,238.242,569.379,254.908,562.413,284.393z"/>
                                            </svg>
                                        </p>
                                    </a>
                                    <?
                                } ?>

                                <div class="price"><?= ICON_CURRENCY; ?> <?= number_format($arItem['PROPERTIES']['PRICE']['VALUE'], 0, '.', ' '); ?></div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <div class="text-right">
                                <a href="<?= $arItem['DETAIL_PAGE_URL']; ?>"
                                   class="title text-uppercase"><?= $arItem['NAME']; ?></a>
                                <? if ($arItem['PROPERTIES']['LOCATION']['VALUE']) {
                                    ?>
                                    <p class="text-with-icon">
                                        <span class="addres"><?=$arItem['PROPERTIES']['LOCATION']['VALUE']?></span>
                                        <svg class="icon-local" version="1.1" id="Capa_1"
                                             xmlns="http://www.w3.org/2000/svg"
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <? } ?>
    </div>
<? } ?>