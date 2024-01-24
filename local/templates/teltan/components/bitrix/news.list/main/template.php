<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

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
$this->addExternalJs(SITE_TEMPLATE_PATH.'/js/image-defer.min.js');

if (!empty($arResult['VIPS']) || !empty($arResult['ITEMS'])):?>
    <div class="mb-4">
        <?php if (!empty($arParams['BLOCK_TITLE'])):?>
            <p class="h2 mb-4 subtitle"><?=$arParams['BLOCK_TITLE']?></p>
        <?php endif;?>
        <?php if (!empty($arResult['VIPS'])):?>
            <div class="row row-cols-1 row-cols-lg-2">
                <?php foreach ($arResult['VIPS'] as $vipItem):
                    $this->AddEditAction($vipItem['ID'], $vipItem['EDIT_LINK'], $vipItem["EDIT_LINK_TEXT"]);
                    $this->AddDeleteAction($vipItem['ID'], $vipItem['DELETE_LINK'], $vipItem["DELETE_LINK_TEXT"], array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                    ?>
                    <div class="mb-4 col" id="<?=$this->GetEditAreaID($vipItem['ID'])?>">
                        <div class="big-card-product auto-product">
                            <a href="<?=$vipItem['DETAIL_PAGE_URL'];?>" class="fake-link-card"></a>
                            <div   class="image-box">
                                <img
                                        class="thumbnail defer"
                                        src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=="
                                        data-defer-src="<?=$vipItem['PREVIEW_PICTURE']['src']?>"
                                        alt="<?=$vipItem['NAME']?>"
                                        title="<?=$vipItem['NAME']?>"
                                >
                            </div>
                            <div class="data">
                                <?php if (!empty($vipItem['SHOW_COUNTER'])):?>
                                    <span class="mr-2">
                                        <span class="views"><?=$vipItem['SHOW_COUNTER'];?></span>
                                        <i class="icon-visibility"></i>
                                    </span>
                                <?php endif;?>
                                <?php $strDate = getStringDate($vipItem['DATE_CREATE']); ?>
                                <span class="date"><?=($strDate['MES']) ? GetMessage($strDate['MES']).', '.$strDate['HOURS'] : $strDate['HOURS'];?></span>
                            </div>
                            <?php if($vipItem['TAPE'] && (strtotime($vipItem['PROPERTIES']['LENTA_DATE']['VALUE']) > time())):?>
                                <div class="d-flex marker">
                                    <div class="d-flex flex-column decor-rec"
                                         style="border-color: <?='#'.$vipItem['TAPE']['UF_COLOR']?>;"
                                    >
                                        <div class="rec-top"></div>
                                        <div class="rec-bottom"></div>
                                    </div>
                                    <div class="text"
                                         style="background-color: <?='#'.$vipItem['TAPE']['UF_COLOR']?>;"
                                    >
                                        <?=$vipItem['TAPE']['UF_NAME'];?>
                                    </div>
                                </div>
                            <?php endif;?>
                            <div class="decor-crown-image">
                                <svg width="22" height="19" viewBox="0 0 22 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1.58936 3.42876L5.88549 6.18822L10.1673 0.413067C10.2619 0.285313 10.3868 0.181179 10.5317 0.109331C10.6765 0.0374835 10.837 0 10.9999 0C11.1628 0 11.3234 0.0374835 11.4682 0.109331C11.613 0.181179 11.7379 0.285313 11.8326 0.413067L16.1144 6.18822L20.4105 3.42876C20.5731 3.32454 20.7633 3.26734 20.9585 3.26392C21.1538 3.2605 21.346 3.31101 21.5124 3.40947C21.6788 3.50793 21.8125 3.65023 21.8976 3.81956C21.9828 3.98888 22.0159 4.17815 21.9929 4.36501L20.3123 18.1298C20.283 18.3695 20.1634 18.5905 19.9762 18.7509C19.7889 18.9113 19.5471 19 19.2966 19H2.70328C2.45274 19 2.21093 18.9113 2.0237 18.7509C1.83648 18.5905 1.71687 18.3695 1.68755 18.1298L0.00694712 4.36402C-0.015761 4.17725 0.0174677 3.98811 0.102711 3.81895C0.187954 3.64978 0.321652 3.50764 0.488023 3.40931C0.654394 3.31098 0.846492 3.26056 1.04164 3.26401C1.23679 3.26745 1.42684 3.32462 1.58936 3.42876ZM10.9999 13.0869C11.5425 13.0869 12.0629 12.8792 12.4465 12.5096C12.8302 12.1399 13.0457 11.6386 13.0457 11.1158C13.0457 10.5931 12.8302 10.0917 12.4465 9.72209C12.0629 9.35245 11.5425 9.14479 10.9999 9.14479C10.4574 9.14479 9.93701 9.35245 9.55335 9.72209C9.16969 10.0917 8.95416 10.5931 8.95416 11.1158C8.95416 11.6386 9.16969 12.1399 9.55335 12.5096C9.93701 12.8792 10.4574 13.0869 10.9999 13.0869Z" fill="#F50000"/>
                                </svg>

                            </div>
                            <div class="info d-flex flex-column flex-lg-row">
                                <div class="mr-0 mr-lg-4 d-flex">
                                    <div class="d-flex justify-content-between justify-content-lg-end align-items-lg-center h-100 knock-stream">
                                        <?php if (!$USER->IsAuthorized()):?><a data-toggle="modal" data-target="#logInModal" class="d-flex align-items-center mr-3" href="#"><?php endif; ?>
                                            <p class="mr-3 mb-0 like" data-ad_id="<?= $vipItem['ID']; ?>">
                                                <svg id="iconLike" class="iconLike" viewBox="0 0 612 792">
                                                    <path d="M562.413,284.393c-9.68,41.044-32.121,78.438-64.831,108.07L329.588,542.345l-165.11-149.843 c-32.771-29.691-55.201-67.076-64.892-108.12c-6.965-29.484-4.103-46.14-4.092-46.249l0.147-0.994 c6.395-72.004,56.382-124.273,118.873-124.273c46.111,0,86.703,28.333,105.965,73.933l9.061,21.477l9.061-21.477 c18.958-44.901,61.694-73.922,108.896-73.922c62.481,0,112.478,52.27,119,125.208C566.517,238.242,569.379,254.908,562.413,284.393z"/>
                                                </svg>
                                            </p>
                                        <?php if (!$USER->IsAuthorized()):?></a><?php endif; ?>
                                        <?php if (!empty($vipItem['PROPERTIES']['PRICE']['VALUE'])):?>
                                            <div class="price">
                                                <?=$vipItem['PROPERTIES']['PRICE']['VALUE']?>
                                            </div>
                                        <?php endif;?>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <div class="text-right">
                                        <a href="<?=$vipItem['DETAIL_PAGE_URL']?>" class="title text-uppercase"><?=$vipItem['NAME']?></a>
                                        <?php if ($arParams['CATEGORY'] === AUTO_ADS_TYPE_CODE && !empty($vipItem['PROPERTIES']['PROP_PROBEG_Left']['VALUE']) && !empty($vipItem['PROPERTIES']['PROP_KM_ML']['VALUE'])):?>
                                            <p class="mb-2 text-with-icon">
                                                <span><?=$vipItem['PROPERTIES']['PROP_PROBEG_Left']['VALUE'].' '.$vipItem['PROPERTIES']['PROP_KM_ML']['VALUE']?></span>
                                                <i class="ml-2 icon-download-speed"></i>
                                            </p>
                                        <?php endif;?>
                                        <?php if (!empty($vipItem['LOCATION'])):?>
                                            <p class="text-with-icon">
                                                <span class="addres"><?=$vipItem['LOCATION']?></span>
                                                <svg class="icon-local" id="Capa_1"
                                                     xmlns="http://www.w3.org/2000/svg"
                                                     xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                     viewBox="0 0 513.597 513.597" xml:space="preserve"
                                                >
                                                    <g>
                                                        <path d="M263.278,0.107C158.977-3.408,73.323,80.095,73.323,183.602c0,117.469,112.73,202.72,175.915,325.322
                                                      c3.208,6.225,12.169,6.233,15.388,0.009c57.16-110.317,154.854-184.291,172.959-290.569
                                                      C456.331,108.387,374.776,3.866,263.278,0.107z M256.923,279.773c-53.113,0-96.171-43.059-96.171-96.171
                                                      s43.059-96.171,96.171-96.171c53.113,0,96.172,43.059,96.172,96.171S310.036,279.773,256.923,279.773z"/>
                                                    </g>
                                                </svg>
                                            </p>
                                        <?php endif;?>
                                        <?php if ($arParams['CATEGORY'] !== AUTO_ADS_TYPE_CODE && !empty($vipItem['SECTION'])):?>
                                            <a href="<?=$vipItem['SECTION']['SECTION_PAGE_URL']?>" class="category"><?=$vipItem['SECTION']['NAME']?></a>
                                        <?php endif;?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach;?>
            </div>
        <?php endif;

        if (!empty($arResult['ITEMS'])):?>
            <div class="row row-cols-2 row-cols-lg-4">
                <?php foreach ($arResult['ITEMS'] as $item):
                    $this->AddEditAction($item['ID'], $item['EDIT_LINK'], $item["EDIT_LINK_TEXT"]);
                    $this->AddDeleteAction($item['ID'], $item['DELETE_LINK'], $item["DELETE_LINK_TEXT"], array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                    ?>
                    <div class="mb-4 col tile-card" id="<?=$this->GetEditAreaID($item['ID'])?>">
                        <div class="card product-card <?=$arParams['IMG_VIEW'] !== 'CONTAINER' ? 'property-product' : ''?>"
                             style="background-color: <?=$item['PROPERTIES']['COLOR_DATE']['VALUE'] && strtotime($item['PROPERTIES']['COLOR_DATE']['VALUE']) > time() ? '#FFF5D9' : ''?>"
                        >
                            <div class="image-block">
                                <div class="i-box">
                                    <a href="<?=$item['DETAIL_PAGE_URL'];?>">
                                        <img
                                            class="thumbnail defer"
                                            src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=="
                                            data-defer-src="<?=$item['PREVIEW_PICTURE']['src']?>"
                                            alt="<?=$item['NAME'];?>"
                                            title="<?=$item['NAME'];?>"
                                        >
                                    </a>
                                </div>
                            </div>
                            <div class="px-2 px-lg-3 d-flex justify-content-between">
                                <?php if (!$USER->IsAuthorized()):?><a data-toggle="modal" data-target="#logInModal" class="d-flex align-items-center mr-3" href="#"><?php endif; ?>
                                    <p class="mb-0 like followThisItem" data-ad_id="<?= $item['ID']; ?>">
                                        <svg id="iconLike" class="iconLike" viewBox="0 0 612 792">
                                            <path d="M562.413,284.393c-9.68,41.044-32.121,78.438-64.831,108.07L329.588,542.345l-165.11-149.843 c-32.771-29.691-55.201-67.076-64.892-108.12c-6.965-29.484-4.103-46.14-4.092-46.249l0.147-0.994 c6.395-72.004,56.382-124.273,118.873-124.273c46.111,0,86.703,28.333,105.965,73.933l9.061,21.477l9.061-21.477 c18.958-44.901,61.694-73.922,108.896-73.922c62.481,0,112.478,52.27,119,125.208C566.517,238.242,569.379,254.908,562.413,284.393z"/>
                                        </svg>
                                    </p>
                                    <?php if (!$USER->IsAuthorized()):?></a><?php endif; ?>
                                <?php if (!empty($item['PROPERTIES']['PRICE']['VALUE'])):?>
                                    <p class="mb-0 price">
                                        <?=ICON_CURRENCY.' '.number_format($item['PROPERTIES']['PRICE']['VALUE'], 0, '.', ' ');?>
                                    </p>
                                <?php endif;?>
                            </div>
                            <div class="px-2 px-lg-3 content-block">
                                <div class="text-right">
                                    <a href="<?=$item['DETAIL_PAGE_URL'];?>" class="mb-2 mb-lg-3 title"><?=$item['NAME'];?></a>
                                    <?php if ($arParams['CATEGORY'] === AUTO_ADS_TYPE_CODE && !empty($item['PROPERTIES']['PROP_PROBEG_Left']['VALUE']) && !empty($item['PROPERTIES']['PROP_KM_ML']['VALUE'])):?>
                                        <p class="mb-2 mileage">
                                            <?=$item['PROPERTIES']['PROP_PROBEG_Left']['VALUE'].' '.$item['PROPERTIES']['PROP_KM_ML']['VALUE']?>
                                            <i class="ml-2 icon-download-speed"></i>
                                        </p>
                                    <?php endif;?>
                                    <?php if (!empty($item['LOCATION'])):?>
                                        <p class="mb-2 location">
                                            <span class="addres"><?=$item['LOCATION']?></span>
                                            <svg class="icon-local" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                                 xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 513.597 513.597" xml:space="preserve">
                                                  <g>
                                                      <path d="M263.278,0.107C158.977-3.408,73.323,80.095,73.323,183.602c0,117.469,112.73,202.72,175.915,325.322
                                                    c3.208,6.225,12.169,6.233,15.388,0.009c57.16-110.317,154.854-184.291,172.959-290.569
                                                    C456.331,108.387,374.776,3.866,263.278,0.107z M256.923,279.773c-53.113,0-96.171-43.059-96.171-96.171
                                                    s43.059-96.171,96.171-96.171c53.113,0,96.172,43.059,96.172,96.171S310.036,279.773,256.923,279.773z"/>
                                                  </g>
                                            </svg>
                                        </p>
                                    <?php endif;?>
                                    <?php if ($arParams['CATEGORY'] !== AUTO_ADS_TYPE_CODE && !empty($item['SECTION'])):?>
                                        <a class="mb-2 mb-lg-3 category" href="<?=$item['SECTION']['SECTION_PAGE_URL']?>">
                                            <?=$item['SECTION']['NAME']?>
                                        </a>
                                    <?php endif;?>
                                </div>
                                <div class="border-top mt-3 py-2 py-lg-3 d-flex justify-content-between align-items-center text-nowrap">
                                    <span class="mr-0 mr-lg-2 views">
                                        <span><?=!empty($item['SHOW_COUNTER']) ? $item['SHOW_COUNTER'] : '0'?></span>
                                        <i class="icon-visibility"></i>
                                    </span>
                                    <?php $strDate = getStringDate($item['DATE_CREATE']); ?>
                                    <span class="date">
                                        <?=!empty($strDate['MES']) ? GetMessage($strDate['MES']).', '.$strDate['HOURS'] : $strDate['HOURS']?>
                                    </span>
                                </div>
                            </div>
                            <?php if($item['TAPE'] && (strtotime($item['PROPERTIES']['LENTA_DATE']['VALUE']) > time())):?>
                                <div class="d-flex marker">
                                    <div class="d-flex flex-column decor-rec"
                                         style="border-color: <?='#'.$item['TAPE']['UF_COLOR']?>;"
                                    >
                                        <div class="rec-top"></div>
                                        <div class="rec-bottom"></div>
                                    </div>
                                    <div class="text"
                                         style="background-color: <?='#'.$item['TAPE']['UF_COLOR']?>;"
                                    >
                                        <?=$item['TAPE']['UF_NAME'];?>
                                    </div>
                                </div>
                            <?php endif;?>
                        </div>
                    </div>
                <?php endforeach;?>
            </div>
        <?php endif;?>
    </div>
<?php endif;?>