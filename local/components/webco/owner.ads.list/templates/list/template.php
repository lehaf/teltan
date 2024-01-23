<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/** @var array $arParams */
/** @var array $arResult */
/** @global object $USER */
/** @global object $APPLICATION */

use Bitrix\Main\Localization\Loc;

$itemCounter = 0;
$pixel = 'data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==';

$this->addExternalJs(SITE_TEMPLATE_PATH.'/js/image-defer.min.js');
?>
<?php if (!empty($arResult['ITEMS'])):?>
    <?php foreach ($arResult['ITEMS'] as $itemsType => $items):?>
        <div class="row <?=$itemsType === 'VIP' ? 'row-cols-1' : 'row-cols-2'?> row-cols-lg-1">
            <?php if (!empty($items)):?>
                <?php foreach ($items as $key => $item):
                    $itemCounter++;
                    $this->AddEditAction($item['ID'], $item['EDIT_LINK'], $item["EDIT_LINK_TEXT"]);
                    $this->AddDeleteAction($item['ID'], $item['DELETE_LINK'], $item["DELETE_LINK_TEXT"], array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                    ?>
                    <div class="mb-3 col" id="<?=$this->GetEditAreaID($item['ID'])?>">
                        <div class="card product-card product-line <?=$itemsType === 'VIP' ? 'product-line-vip property-vip' : ''?>"
                            <?php if (!empty($item['COLOR_DATE'] && strtotime($item['COLOR_DATE']) > time())):?>
                                style="background-color: <?=PROPERTY_VIP_COLOR;?>"
                            <?php endif;?>
                        >
                            <div class="card-link">
                                <div class="image-block">
                                    <div class="i-box">
                                        <a href="<?= $item['DETAIL_PAGE_URL'] ?>">
                                            <img src="<?=$itemCounter >  2 ? $pixel : $item['PREVIEW_PICTURE']['src']?>"
                                                 data-defer-src="<?=$item['PREVIEW_PICTURE']['src']?>"
                                                 alt="<?=$item['NAME']?>"
                                                 title="<?=$item['NAME']?>"
                                            >
                                        </a>
                                    </div>
                                </div>
                                <div class="px-2 px-lg-3 d-flex justify-content-between like-price">
                                    <?php if (!$USER->IsAuthorized()):?><a data-toggle="modal" data-target="#logInModal" class="d-flex align-items-center mr-3" href="#"><?php endif; ?>
                                        <p class="mb-0 like followThisItem" data-ad_id="<?= $item['ID']; ?>">
                                            <svg id="iconLike" class="iconLike" viewBox="0 0 612 792">
                                                <path d="M562.413,284.393c-9.68,41.044-32.121,78.438-64.831,108.07L329.588,542.345l-165.11-149.843 c-32.771-29.691-55.201-67.076-64.892-108.12c-6.965-29.484-4.103-46.14-4.092-46.249l0.147-0.994 c6.395-72.004,56.382-124.273,118.873-124.273c46.111,0,86.703,28.333,105.965,73.933l9.061,21.477l9.061-21.477 c18.958-44.901,61.694-73.922,108.896-73.922c62.481,0,112.478,52.27,119,125.208C566.517,238.242,569.379,254.908,562.413,284.393z"/>
                                            </svg>
                                        </p>
                                        <?php if (!$USER->IsAuthorized()):?></a><?php endif; ?>
                                    <?php if(!empty($item['PRICE'])):?>
                                        <p class="mb-0 price"><?=$item['PRICE']?></p>
                                    <?php endif;?>
                                    <?php if ($itemsType === 'VIP'):?>
                                        <div class="vip-marker">
                                            <div class="mr-2 icon">
                                                <svg width="14" height="13" viewBox="0 0 14 13" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M1.01141 2.346L3.74531 4.23405L6.4701 0.282625C6.53032 0.195214 6.60981 0.123964 6.70197 0.0748055C6.79413 0.0256466 6.8963 0 6.99996 0C7.10362 0 7.20578 0.0256466 7.29794 0.0748055C7.39011 0.123964 7.4696 0.195214 7.52982 0.282625L10.2546 4.23405L12.9885 2.346C13.092 2.27468 13.213 2.23555 13.3372 2.23321C13.4615 2.23087 13.5838 2.26542 13.6897 2.33279C13.7956 2.40016 13.8807 2.49753 13.9349 2.61338C13.989 2.72923 14.0101 2.85874 13.9955 2.98658L12.926 12.4046C12.9074 12.5686 12.8312 12.7198 12.7121 12.8296C12.593 12.9393 12.4391 13 12.2796 13H1.72027C1.56084 13 1.40695 12.9393 1.28781 12.8296C1.16867 12.7198 1.09255 12.5686 1.0739 12.4046L0.0044209 2.98591C-0.0100298 2.85812 0.0111158 2.72871 0.0653613 2.61296C0.119607 2.49722 0.204688 2.39996 0.31056 2.33268C0.416433 2.26541 0.538677 2.23091 0.662862 2.23327C0.787047 2.23563 0.907988 2.27474 1.01141 2.346ZM6.99996 8.95417C7.34523 8.95417 7.67637 8.81209 7.92051 8.55918C8.16466 8.30626 8.30182 7.96324 8.30182 7.60557C8.30182 7.24789 8.16466 6.90487 7.92051 6.65196C7.67637 6.39904 7.34523 6.25696 6.99996 6.25696C6.65468 6.25696 6.32355 6.39904 6.07941 6.65196C5.83526 6.90487 5.6981 7.24789 5.6981 7.60557C5.6981 7.96324 5.83526 8.30626 6.07941 8.55918C6.32355 8.81209 6.65468 8.95417 6.99996 8.95417Z"
                                                          fill="#F50000"></path>
                                                </svg>
                                            </div>
                                            <span class="text">vip</span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="px-2 px-lg-3 content-block">
                                    <div class="text-right">
                                        <a href="<?= $item['DETAIL_PAGE_URL'] ?>" class="mb-2 mb-lg-3 title"><?= $item['NAME'] ?></a>
                                        <?php if ($item['IBLOCK_ID'] == AUTO_IBLOCK_ID):?>
                                            <div class="row">
                                                <div class="col-12 col-xl">
                                                    <p class="d-none d-xl-inline-block engin">
                                                    <span>
                                                        <?= $item['PROP_ENGIEN_NEW_Left'] ?>
                                                        <?= $item['PROP_KM_ML_ENGIE'] ?>
                                                          <span><?= $item['PROP_ENGINE'] ?></span>
                                                        ,
                                                        <span> <?= $item['PROP_ENGIEN_LITERS_Left'] ?> l.</span>
                                                    </span>
                                                        <i class="icon-engine"></i>
                                                    </p>
                                                    <br>
                                                    <?php if (!empty($item['LOCATION'])):?>
                                                        <p class="mb-2 mb-lg-3 location">
                                                            <span class="addres"><?=$item['LOCATION']?></span>
                                                            <svg class="icon-local" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 513.597 513.597" xml:space="preserve">
                                                                <g>
                                                                    <path d="M263.278,0.107C158.977-3.408,73.323,80.095,73.323,183.602c0,117.469,112.73,202.72,175.915,325.322
                                                                          c3.208,6.225,12.169,6.233,15.388,0.009c57.16-110.317,154.854-184.291,172.959-290.569
                                                                          C456.331,108.387,374.776,3.866,263.278,0.107z M256.923,279.773c-53.113,0-96.171-43.059-96.171-96.171
                                                                          s43.059-96.171,96.171-96.171c53.113,0,96.172,43.059,96.172,96.171S310.036,279.773,256.923,279.773z">
                                                                    </path>
                                                                </g>
                                                            </svg>
                                                        </p>
                                                    <?php endif;?>
                                                </div>
                                                <div class="col-12 col-xl-4">
                                                    <?php if (!empty($item['PROP_PROBEG_Left'])):?>
                                                        <p class="mileage">
                                                            <span>
                                                                <?=number_format($item['PROP_PROBEG_Left'], 0, '.', ' '); ?>
                                                                <?= $item['PROP_KM_ML'] ?>
                                                            </span><i class="ml-2 icon-download-speed"></i>
                                                        </p>
                                                    <?php endif; ?>
                                                    <?php if (!empty($item['PROP_TRANSMISION_Left'])):?>
                                                        <p class="d-none d-xl-inline-block transmission">
                                                            <span><?= $item['PROP_TRANSMISION_Left'] ?></span>
                                                            <i class="ml-2 icon-manual-transmission"></i>
                                                        </p>
                                                    <?php endif;?>
                                                </div>
                                            </div>
                                        <?php else:?>
                                            <?php if (!empty($item['LOCATION'])):?>
                                                <p class="mb-2 mb-lg-3 location">
                                                    <span class="addres"><?=$item['LOCATION']?></span>
                                                    <svg class="icon-local" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 513.597 513.597" xml:space="preserve">
                                                        <g>
                                                            <path d="M263.278,0.107C158.977-3.408,73.323,80.095,73.323,183.602c0,117.469,112.73,202.72,175.915,325.322
                                                                  c3.208,6.225,12.169,6.233,15.388,0.009c57.16-110.317,154.854-184.291,172.959-290.569
                                                                  C456.331,108.387,374.776,3.866,263.278,0.107z M256.923,279.773c-53.113,0-96.171-43.059-96.171-96.171
                                                                  s43.059-96.171,96.171-96.171c53.113,0,96.172,43.059,96.172,96.171S310.036,279.773,256.923,279.773z">
                                                            </path>
                                                        </g>
                                                    </svg>
                                                </p>
                                            <?php endif;?>
                                        <?php endif;?>
                                        <?php if ($arParams['CATEGORY'] !== AUTO_ADS_TYPE_CODE && !empty($item['SECTION'])):?>
                                            <br><a class="mb-2 mb-lg-4 category" href="<?=$item['SECTION']['SECTION_PAGE_URL']?>">
                                                <?=$item['SECTION']['NAME']?>
                                            </a>
                                        <?php endif;?>
                                    </div>
                                    <div class="border-top py-2 d-flex justify-content-between align-items-center text-nowrap product-line__data-viwe">
                                        <div class="d-flex">
                                            <span class="mr-0 mr-lg-2 views">
                                                <span><?=!empty($item['SHOW_COUNTER']) ? $item['SHOW_COUNTER'] : '0'?></span>
                                                <i class="icon-visibility"></i>
                                            </span>
                                            <?php if (!$USER->IsAuthorized()):?><a data-toggle="modal" data-target="#logInModal" class="d-flex align-items-center mr-3" href="#"><?php endif; ?>
                                                <span data-ad_id="<?= $item['ID']; ?>" class="product-line__like">To favorites
                                              <svg id="iconLike" class="iconLike" viewBox="0 0 612 792">
                                                  <path d="M562.413,284.393c-9.68,41.044-32.121,78.438-64.831,108.07L329.588,542.345l-165.11-149.843 c-32.771-29.691-55.201-67.076-64.892-108.12c-6.965-29.484-4.103-46.14-4.092-46.249l0.147-0.994 c6.395-72.004,56.382-124.273,118.873-124.273c46.111,0,86.703,28.333,105.965,73.933l9.061,21.477l9.061-21.477 c18.958-44.901,61.694-73.922,108.896-73.922c62.481,0,112.478,52.27,119,125.208C566.517,238.242,569.379,254.908,562.413,284.393z"/></svg>
                                            </span>
                                                <?php if (!$USER->IsAuthorized()):?></a><?php endif; ?>
                                        </div>
                                        <?php $strDate = getStringDate($item['DATE_CREATE']); ?>
                                        <span class="date"><?= ($strDate['MES']) ? GetMessage($strDate['MES']) . ', ' . $strDate['HOURS'] : $strDate['HOURS']; ?></span>
                                    </div>
                                </div>
                            </div>
                            <?php if(!empty($item['RIBBON'])):?>
                                <div class="d-flex marker">
                                    <div class="d-flex flex-column decor-rec"
                                         style="border-color: <?='#'.$item['RIBBON']['UF_COLOR']?>;"
                                    >
                                        <div class="rec-top"></div>
                                        <div class="rec-bottom"></div>
                                    </div>
                                    <div class="text"
                                         style="background-color: <?='#'.$item['RIBBON']['UF_COLOR']?>">
                                        <?=$item['RIBBON']['UF_NAME']?>
                                    </div>
                                </div>
                            <?php endif;?>
                        </div>
                    </div>
                <?php endforeach ?>
            <?php endif;?>
        </div>
    <?php endforeach ?>
    <?=$arResult['PAGINATION']?>
<?php else:?>
    <div class="empty-ads"><?=Loc::getMessage('EMPTY_ITEMS')?></div>
<?php endif;?>


