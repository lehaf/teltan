<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/** @var array $arParams */
/** @var array $arResult */
/** @global object $USER */
/** @global object $APPLICATION */

use Bitrix\Main\Localization\Loc;

$itemCounter = 0;
$pixel = 'data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==';

$this->addExternalJs(SITE_TEMPLATE_PATH.'/js/image-defer.min.js');
$this->addExternalJs(SITE_TEMPLATE_PATH.'/assets/components/buttons/boost.js');
$this->addExternalJs(SITE_TEMPLATE_PATH.'/assets/components/buttons/edit.js');
$this->addExternalCss(SITE_TEMPLATE_PATH.'/assets/components/buttons/boost.css');
?>
<?php if (!empty($arResult['ADS'])):?>
        <?php foreach ($arResult['ADS'] as $item):?>
            <?php
                $this->AddEditAction($item['ID'], $item['EDIT_LINK'], $item["EDIT_LINK_TEXT"]);
                $this->AddDeleteAction($item['ID'], $item['DELETE_LINK'], $item["DELETE_LINK_TEXT"], array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
            ?>
                <div class="mb-4 card product-card product-line user-product" id="<?=$this->GetEditAreaID($item['ID'])?>">
                    <div class="card-link" href="<?= $item['DETAIL_PAGE_URL'] ?>">
                        <div onclick="window.location.href='<?= $item['DETAIL_PAGE_URL'] ?>'" style="cursor: pointer" class="image-block">
                            <div class="i-box">
                                <img src="<?=$item["PREVIEW_PICTURE"]['src']?>"
                                     alt="<?=$item['NAME']?>"
                                     title="<?=$item['NAME']?>"
                                >
                            </div>
                        </div>
                        <div class="px-2 px-lg-3 content-block">
                            <div class="d-flex flex-column h-100 justify-content-between text-right">
                                <div class="mb-3 mb-lg-5 d-flex flex-column-reverse flex-lg-row justify-content-between align-items-end">
                                    <?php if (!empty($item['PRICE'])):?>
                                        <p class="price"><?=$item['PRICE']?></p>
                                    <?php endif;?>
                                    <a href="<?=$item['DETAIL_PAGE_URL']?>" class="title"><?=$item['NAME']?></a>
                                </div>
                                <div class="mb-4 d-flex flex-column flex-lg-row">
                                    <?php $APPLICATION->IncludeComponent(
                                        "webco:buttons",
                                        "edit",
                                        array(
                                            'ITEM_ID' => $item['ID'],
                                            'IBLOCK_ID' => $item['IBLOCK_ID'],
                                            'ITEM_ACTIVE' => $item['ACTIVE'],
                                            'EDIT_PAGE' => $item['EDIT_PAGE']
                                        )
                                    );

                                    $APPLICATION->IncludeComponent(
                                        "webco:buttons",
                                        "boost",
                                        array(
                                            'ITEM_ID' => $item['ID'],
                                            'IBLOCK_ID' => $item['IBLOCK_ID']
                                        )
                                    ); ?>
                                </div>
                            </div>
                            <div class="border-top py-3 d-flex justify-content-between align-items-center text-nowrap product-line__data-viwe">
                                <div class="d-flex">
                                    <span class="mr-0 mr-lg-2 views">
                                        <span><?=$item['SHOW_COUNTER']?></span>
                                        <i class="icon-visibility"></i>
                                    </span>
                                    <div class="d-none d-lg-flex justify-content-end align-items-center ml-5 product-line__up-date">
                                        <?php if (!empty($item['TIME_RAISE'])):?>
                                            <div class="mr-2 d-flex justify-content-center align-items-center user-product__up-product">
                                                <span data-id="<?=$item['ID']?>" class="text-uppercase font-weight-bold upRise">UP</span>
                                            </div>
                                            <?php $strDate = getStringDate($item['TIME_RAISE'])?>
                                            <span class="up-date"><?= ($strDate['MES']) ? GetMessage($strDate['MES']) . ', ' . $strDate['HOURS'] : $strDate['HOURS']; ?></span>
                                        <?php endif;?>
                                    </div>
                                </div>
                                <?php if ($strDate2 = getStringDate($item['DATE_CREATE'])):?>
                                    <span class="date">
                                        <?=$strDate2['MES'] ? GetMessage($strDate2['MES']) . ', ' . $strDate2['HOURS'] : $strDate2['HOURS'];?></span>
                                <?php endif;?>
                            </div>
                        </div>
                    </div>
                    <?php // Значки платных услуг?>
                    <?php if (!empty($item['COUNT_RAISE'])):?>
                        <div type="button"
                             data-id="<?= $item['ID'] ?>" data-iblock-id="<?=$item['IBLOCK_ID']?>"
                             class="b-none d-lg-flex justify-content-center align-items-center rise-btn"
                        >
                            <span data-id="<?=$item['ID']?>" class="mr-1 text-uppercase font-weight-bold up">UP</span>
                            <p class="m-0">
                                <?= Loc::getMessage('UP_RISE'); ?>
                                (<span><?= $item['COUNT_RAISE'] ?></span>)
                            </p>
                        </div>
                    <?php endif;?>
                    <div class="d-flex flex-column controls-rise-item">
                        <?php if ($item['VIP_DATE'] && strtotime($item['VIP_DATE']) > time()):?>
                            <div class="d-flex justify-content-center align-items-center item">
                                <svg width="22" height="19" viewBox="0 0 22 19" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1.58936 3.42876L5.88549 6.18822L10.1673 0.413067C10.2619 0.285313 10.3868 0.181179 10.5317 0.109331C10.6765 0.0374835 10.837 0 10.9999 0C11.1628 0 11.3234 0.0374835 11.4682 0.109331C11.613 0.181179 11.7379 0.285313 11.8326 0.413067L16.1144 6.18822L20.4105 3.42876C20.5731 3.32454 20.7633 3.26734 20.9585 3.26392C21.1538 3.2605 21.346 3.31101 21.5124 3.40947C21.6788 3.50793 21.8125 3.65023 21.8976 3.81956C21.9828 3.98888 22.0159 4.17815 21.9929 4.36501L20.3123 18.1298C20.283 18.3695 20.1634 18.5905 19.9762 18.7509C19.7889 18.9113 19.5471 19 19.2966 19H2.70328C2.45274 19 2.21093 18.9113 2.0237 18.7509C1.83648 18.5905 1.71687 18.3695 1.68755 18.1298L0.00694712 4.36402C-0.015761 4.17725 0.0174677 3.98811 0.102711 3.81895C0.187954 3.64978 0.321652 3.50764 0.488023 3.40931C0.654394 3.31098 0.846492 3.26056 1.04164 3.26401C1.23679 3.26745 1.42684 3.32462 1.58936 3.42876ZM10.9999 13.0869C11.5425 13.0869 12.0629 12.8792 12.4465 12.5096C12.8302 12.1399 13.0457 11.6386 13.0457 11.1158C13.0457 10.5931 12.8302 10.0917 12.4465 9.72209C12.0629 9.35245 11.5425 9.14479 10.9999 9.14479C10.4574 9.14479 9.93701 9.35245 9.55335 9.72209C9.16969 10.0917 8.95416 10.5931 8.95416 11.1158C8.95416 11.6386 9.16969 12.1399 9.55335 12.5096C9.93701 12.8792 10.4574 13.0869 10.9999 13.0869Z"
                                          fill="#F50000"/>
                                </svg>
                            </div>
                        <?php endif;?>
                        <?php if ($item['COLOR_DATE'] && strtotime($item['COLOR_DATE']) > time()):?>
                            <div class="d-flex justify-content-center align-items-center item">
                                <svg width="16" height="17" viewBox="0 0 16 17" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M8.20189 0.934761C8.20189 0.779763 8.14032 0.631114 8.03072 0.521514C7.92112 0.411914 7.77247 0.350342 7.61747 0.350342C7.46247 0.350342 7.31382 0.411914 7.20422 0.521514C7.09462 0.631114 7.03305 0.779763 7.03305 0.934761V1.90879C6.78643 1.99564 6.56248 2.13677 6.37772 2.32178L1.01743 7.68285C0.854624 7.84566 0.725478 8.03894 0.637367 8.25165C0.549256 8.46437 0.503906 8.69236 0.503906 8.9226C0.503906 9.15284 0.549256 9.38083 0.637367 9.59355C0.725478 9.80626 0.854624 9.99954 1.01743 10.1623L4.82005 13.9634C4.98286 14.1262 5.17613 14.2554 5.38885 14.3435C5.60157 14.4316 5.82956 14.4769 6.0598 14.4769C6.29004 14.4769 6.51803 14.4316 6.73075 14.3435C6.94346 14.2554 7.13674 14.1262 7.29955 13.9634L12.6598 8.60312C12.8226 8.44031 12.9518 8.24703 13.0399 8.03432C13.128 7.8216 13.1734 7.59361 13.1734 7.36337C13.1734 7.13313 13.128 6.90514 13.0399 6.69242C12.9518 6.47971 12.8226 6.28643 12.6598 6.12362L8.85644 2.32178C8.67191 2.13687 8.44823 1.99574 8.20189 1.90879V0.934761ZM7.03305 3.31919V4.44127C7.03305 4.59627 7.09462 4.74492 7.20422 4.85452C7.31382 4.96412 7.46247 5.02569 7.61747 5.02569C7.77247 5.02569 7.92112 4.96412 8.03072 4.85452C8.14032 4.74492 8.20189 4.59627 8.20189 4.44127V3.31919L11.8323 6.95038C11.9417 7.05996 12.0032 7.2085 12.0032 7.36337C12.0032 7.51824 11.9417 7.66678 11.8323 7.77636L11.0765 8.53221H1.82159L1.84419 8.50883L7.03305 3.31919Z"
                                          fill="#6633F5"/>
                                    <path d="M14.063 9.78046C14.0049 9.67162 13.9183 9.5806 13.8125 9.51714C13.7067 9.45369 13.5856 9.42017 13.4622 9.42017C13.3388 9.42017 13.2177 9.45369 13.1119 9.51714C13.0061 9.5806 12.9195 9.67162 12.8614 9.78046L11.2967 12.715C10.4232 14.3498 11.6092 16.3244 13.4622 16.3244C15.3152 16.3244 16.4996 14.3498 15.6284 12.715L14.063 9.78046Z"
                                          fill="#6633F5"/>
                                </svg>
                            </div>
                        <?php endif;?>
                        <?php if ($item['LENTA_DATE'] && strtotime($item['LENTA_DATE']) > time()):?>
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
                        <?php endif;?>
                        <?php if ($item['PAKET_DATE'] && strtotime($item['PAKET_DATE']) > time()):?>
                            <div class="d-flex justify-content-center align-items-center item">
                                <svg width="16" height="18" viewBox="0 0 16 18" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M10.7811 0.968714C10.7811 0.792056 10.7264 0.619732 10.6246 0.475353C10.5228 0.330975 10.3789 0.221608 10.2125 0.16224C10.0461 0.102871 9.86545 0.0964054 9.69525 0.143729C9.52505 0.191053 9.37365 0.289851 9.26179 0.426584L0.697334 9.84749C0.594729 9.97297 0.529841 10.125 0.510211 10.2859C0.49058 10.4468 0.517013 10.61 0.586437 10.7564C0.655861 10.9029 0.765426 11.0267 0.902399 11.1133C1.03937 11.2 1.19813 11.246 1.36022 11.2461H5.64245V16.3847C5.64248 16.5614 5.69714 16.7337 5.79894 16.8781C5.90074 17.0225 6.04469 17.1318 6.21107 17.1912C6.37746 17.2506 6.55813 17.257 6.72833 17.2097C6.89853 17.1624 7.04993 17.0636 7.16179 16.9269L15.7262 7.50596C15.8288 7.38048 15.8937 7.22845 15.9134 7.06755C15.933 6.90666 15.9066 6.74349 15.8371 6.59702C15.7677 6.45054 15.6582 6.32678 15.5212 6.24011C15.3842 6.15343 15.2254 6.10741 15.0634 6.10739H10.7811V0.968714Z"
                                          fill="#FF6B00"/>
                                </svg>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
        <?php endforeach ?>
        <?=$arResult['PAGINATION']?>
<?php endif;?>


