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
    <div class="row row-cols-2 row-cols-lg-4">
        <? foreach ($arResult['ITEMS'] as $arItem) {
            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], $arItem["EDIT_LINK_TEXT"]);
            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], $arItem["DELETE_LINK_TEXT"], array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
            ?>
            <div class="mb-3 col" id="<?=$this->GetEditAreaID($arItem['ID'])?>">
                <?
                $color = '';
                if ($arItem['PROPERTIES']['COLOR_DATE']['VALUE'] && strtotime($arItem['PROPERTIES']['COLOR_DATE']['VALUE']) > time())
                    $color = '#FFF5D9';
                ?>
                <div class="card product-card" style="background-color: <?= $color; ?>">
                    <div class="image-block">
                        <div class="i-box">
                            <a href="<?= $arItem['DETAIL_PAGE_URL']; ?>"><img src="<?= $arItem['PREVIEW_450_377']; ?>"
                                                                              alt="<?= $arItem['NAME']; ?>"></a>
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
                            <a data-toggle="modal" data-target="#logInModal" class="d-flex align-items-center mr-3"
                               href="#">
                                <p class="mb-0 like followThisItem" data-ad_id="">
                                    <svg class="iconLike" viewBox="0 0 612 792">
                                        <path d="M562.413,284.393c-9.68,41.044-32.121,78.438-64.831,108.07L329.588,542.345l-165.11-149.843 c-32.771-29.691-55.201-67.076-64.892-108.12c-6.965-29.484-4.103-46.14-4.092-46.249l0.147-0.994 c6.395-72.004,56.382-124.273,118.873-124.273c46.111,0,86.703,28.333,105.965,73.933l9.061,21.477l9.061-21.477 c18.958-44.901,61.694-73.922,108.896-73.922c62.481,0,112.478,52.27,119,125.208C566.517,238.242,569.379,254.908,562.413,284.393z"/>
                                    </svg>
                                </p>
                            </a>
                            <?
                        } ?>


                        <p class="mb-0 price"><?= ICON_CURRENCY; ?> <?= number_format($arItem['PROPERTIES']['PRICE']['VALUE'], 0, '.', ' '); ?></p>
                    </div>

                    <div class="px-2 px-lg-3 content-block">
                        <div class="text-right">
                            <a href="<?= $arItem['DETAIL_PAGE_URL']; ?>"
                               class="mb-2 mb-lg-3 title"><?= $arItem['NAME']; ?></a>
                            <? if ($arItem['PROPERTIES']['LOCATION']['VALUE']) {
                                ?>
                                <p class="mb-2 location" style="
                                       font-size: 13px;
                                       color: #747474;">
                                    <span class="addres"><?=$arItem['PROPERTIES']['UF_CITY']['VALUE'];?> <?=(!empty($arItem['PROPERTIES']['UF_CITY']['VALUE']))? ',' : ''?> <?=$arItem['PROPERTIES']['UF_REGION']['VALUE'];?></span>
                                    <svg style="font-size: 16px; width: 16px; fill: #747474;" class="icon-local"
                                         version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                         xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                         viewBox="0 0 513.597 513.597" xml:space="preserve">
                                          <g>
                                              <path d="M263.278,0.107C158.977-3.408,73.323,80.095,73.323,183.602c0,117.469,112.73,202.72,175.915,325.322
                                            c3.208,6.225,12.169,6.233,15.388,0.009c57.16-110.317,154.854-184.291,172.959-290.569
                                            C456.331,108.387,374.776,3.866,263.278,0.107z M256.923,279.773c-53.113,0-96.171-43.059-96.171-96.171
                                            s43.059-96.171,96.171-96.171c53.113,0,96.172,43.059,96.172,96.171S310.036,279.773,256.923,279.773z"/>
                                          </g>
                                        </svg>
                                </p>
                            <? } ?>
                        </div>

                        <div class="border-top py-2 py-lg-3 d-flex justify-content-between align-items-center text-nowrap">
                            
                                <span class="mr-0 mr-lg-2 views"><span><?= $arItem['SHOW_COUNTER']; ?></span> <i
                                            class="icon-visibility"></i></span>

                            <?
                            $strDate = getStringDate($arItem['DATE_CREATE']);
                            ?>
                            <span class="date"><?= ($strDate['MES']) ? GetMessage($strDate['MES']) . ', ' . $strDate['HOURS'] : $strDate['HOURS']; ?></span>
                        </div>
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
                </div>
            </div>

        <? } ?>
    </div>
<? } ?>