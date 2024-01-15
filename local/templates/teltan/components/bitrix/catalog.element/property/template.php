<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

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

$this->setFrameMode(true);

$this->addExternalJs(SITE_TEMPLATE_PATH.'/js/slick.js');
$this->addExternalCss(SITE_TEMPLATE_PATH.'/css/map_vip_marker.css');
$this->addExternalJs(SITE_TEMPLATE_PATH.'/js/map/map_detail.js');
$this->addExternalJs(SITE_TEMPLATE_PATH.'/assets/components/buttons/boost.js');
$this->addExternalCss(SITE_TEMPLATE_PATH.'/assets/components/buttons/boost.css');
?>
<div class="row flex-column-reverse flex-lg-row mb-4">
    <div class="col-12 col-lg-4 flex-column">
        <div class="d-lg-block">
            <div class="mb-4 card connection-with-seller text-right 1">
                <h1 class="mb-4 connection-with-seller__title"><?= $arResult['NAME']; ?></h1>
                <?php if (!empty($arResult['PROPERTIES']['PRICE']['VALUE'])):?>
                    <p class="mb-4 connection-with-seller__price text-primary">
                        <?=ICON_CURRENCY.' '.round($arResult['PROPERTIES']['PRICE']['VALUE'])?>
                    </p>
                <?php endif;?>
                <?php if ($arResult['LOCATION']):?>
                    <p class="pb-3 border-bottom">
                        <span class="mr-1"><?=$arResult['LOCATION']?></span>
                        <svg class="icon-local"
                             style="position: relative; width: 16px; top: -2px; fill: #747474"
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
                <?php endif;?>
<!--                        <div class="mb-4 d-flex flex-column border-bottom">-->
<!--                            <p class="mb-2">Completion date: <span>Q1 2020</span></p>-->
<!--                            <p>Terms of the transaction: <span class="font-weight-bold">Sale</span></p>-->
<!--                        </div>-->
                <?php if ($arParams['USER_ID'] == $arResult['PROPERTIES']['ID_USER']['VALUE']):?>
                    <div class="flex-column">
                        <button onclick="location.href='<?=$arResult['EDIT_PAGE']?>'" class="mb-3 w-100 btn btn-primary text-uppercase font-weight-bold">
                            <?=Loc::getMessage('EDIT')?>
                        </button>
                        <?php
                        $APPLICATION->IncludeComponent(
                            "webco:buttons",
                            "boost",
                                array(
                                'ITEM_ID' => $arResult['ID'],
                                'IBLOCK_ID' => $arResult['IBLOCK_ID'],
                                'DETAIL_PAGE' => 'Y'
                                )
                            );
                        ?>
                    </div>
                <?php else:?>
                    <div class="mb-4 row no-gutters">
                        <button class="mr-2 col btn btn-show-phone text-uppercase font-weight-bold"
                                <?=empty($arParams['USER_ID']) ? 'disabled' : ''?>
                                data-toggle="collapse"
                                href="#showContactPhone"
                                role="button"
                                aria-expanded="false"
                                aria-controls="showContactPhone"
                        >
                            <?= Loc::getMessage('SHOW_PHONE'); ?>
                        </button>
                        <button class="ml-2 col btn btn-primary text-uppercase font-weight-bold"
                                <?=empty($arParams['USER_ID']) ? 'disabled' : ''?>
                                data-toggle="modal"
                                data-target="#modalSandMessage"
                        >
                            <?= Loc::getMessage('SEND_MESSAGE'); ?>
                        </button>
                    </div>
                    <?php if (!empty($arParams['USER_ID'])):?>
                        <ul class="text-right collapse contact-list" id="showContactPhone">
                            <li class="d-flex justify-content-end">
                                <p class="mb-0 d-flex align-items-center time">
                                    <?php if ($arResult['PROPERTIES']['UF_CALL_ANYTIME']['VALUE'] == 1):?>
                                        <span class="mx-2"><?= Loc::getMessage('CALL_ANYTIME'); ?></span>
                                    <?php else:?>
                                        from <span class="mx-2"><?= $arResult['PROPERTIES']['UF_CALL_FROM']['VALUE'] ?></span>
                                        to <span class="mx-2"><?= $arResult['PROPERTIES']['UF_CALL_TO']['VALUE'] ?></span>
                                    <?php endif;?>
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9.99 0C4.47 0 0 4.48 0 10C0 15.52 4.47 20 9.99 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 9.99 0ZM10 18C5.58 18 2 14.42 2 10C2 5.58 5.58 2 10 2C14.42 2 18 5.58 18 10C18 14.42 14.42 18 10 18ZM9.78 5H9.72C9.32 5 9 5.32 9 5.72V10.44C9 10.79 9.18 11.12 9.49 11.3L13.64 13.79C13.98 13.99 14.42 13.89 14.62 13.55C14.6702 13.469 14.7036 13.3788 14.7182 13.2846C14.7328 13.1905 14.7283 13.0943 14.705 13.002C14.6817 12.9096 14.64 12.8229 14.5824 12.7469C14.5249 12.671 14.4526 12.6074 14.37 12.56L10.5 10.26V5.72C10.5 5.32 10.18 5 9.78 5Z"
                                              fill="#555555"/>
                                    </svg>
                                </p>
                            </li>
                            <?php if (!empty($arResult['USER']['PERSONAL_PHONE'])):?>
                                <li>
                                    <a href="tel:<?=$arResult['USER']['PERSONAL_PHONE']?>">
                                        <?=$arResult['USER']['PERSONAL_PHONE']?>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    <?php else:?>
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
                                <?php include $_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH . "/includes/footer/register_modal.php"; ?>
                                <?php include $_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH . "/includes/footer/auth_modal.php"; ?>
                            </div>
                        </div>
                    <?php endif;?>
                <?php endif;?>
            </div>
        </div>
        <div class="mb-4 card seller-card text-right">
            <p class="text-uppercase seller-card__title"><?= Loc::getMessage('SELLER'); ?></p>
            <div class="mb-4 d-flex justify-content-end align-items-center">
                <div class="seller-card__data">
                    <span class="name"><?= $arResult['USER']['NAME']; ?></span>
                        <p class="m-0 d-flex justify-content-end align-items-center <?=$arResult['USER']['IS_ONLINE'] !== 'Y' ? 'offline' : ''?>">
                            <span class="status"><?=$arResult['USER']['IS_ONLINE'] === 'Y' ? 'Online' : 'Offline'?></span>
                            <span class="status_dot"></span>
                        </p>
                    <span class="date-registration">Registered: <?=$arResult['USER']['DATE_REGISTER']?></span>
                </div>
                <div class="seller-card__photo">
                    <img src="<?=SITE_TEMPLATE_PATH?>/assets/img/seller-photo.png"
                         alt="seller"
                         title="seller"
                    >
                </div>
            </div>
            <a class="w-100 btn btn-primary text-uppercase btn-author-add"
               href="/search/author/?R=<?= $arResult['IBLOCK_ID'] ?>&I=<?=$arResult['PROPERTIES']['ID_USER']['VALUE']?>&sort=price_d&display=block"
            >
                <?=Loc::getMessage('ALL_ADS_AUTHOR')?>
            </a>
        </div>
        <div class="mb-4 card exact-address-card text-right" data-toggle="modal" data-target="#itemMapFullSize">
            <p class="text-uppercase exact-address-card__title">Exact address</p>
            <?php if (!empty($arResult['PROPERTIES']['MAP_LAYOUT_BIG']['VALUE']) && !empty($arResult['PROPERTIES']['MAP_LAYOUT']['VALUE'])):?>
                <div type="button" class="flex-column">
                    <p class="map__address"><?=$arResult['PROPERTIES']['MAP_LAYOUT']['VALUE'].', '.$arResult['PROPERTIES']['MAP_LAYOUT_BIG']['VALUE'] ?>
                        <i class="icon-pin"></i></p>
                    <div id="mapMini" style="width: 100%; height: 200px;" data-map-mark='<?=$arResult['MAP_MARK']?>'></div>
                </div>
            <?php endif;?>
        </div>
        <div class="modal fade" id="itemMapFullSize">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="pb-0 modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <p class="mb-3 modal-title subtitle" id="staticBackdropLabel">Exact address</p>
                        <?php if ($arResult['PROPERTIES']['MAP_LAYOUT_BIG']['VALUE'] && $arResult['PROPERTIES']['MAP_LAYOUT']['VALUE']):?>
                            <p class="mb-0 map-address"><?=$arResult['PROPERTIES']['MAP_LAYOUT']['VALUE'].', '.$arResult['PROPERTIES']['MAP_LAYOUT_BIG']['VALUE']?>
                                <svg    class="icon-local"
                                        version="1.1"
                                        id="Capa_1"
                                        xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink"
                                        x="0px"
                                        y="0px"
                                        viewBox="0 0 513.597 513.597"
                                        xml:space="preserve"
                                >
                                    <g>
                                        <path d="M263.278,0.107C158.977-3.408,73.323,80.095,73.323,183.602c0,117.469,112.73,202.72,175.915,325.322
                                      c3.208,6.225,12.169,6.233,15.388,0.009c57.16-110.317,154.854-184.291,172.959-290.569
                                      C456.331,108.387,374.776,3.866,263.278,0.107z M256.923,279.773c-53.113,0-96.171-43.059-96.171-96.171
                                      s43.059-96.171,96.171-96.171c53.113,0,96.172,43.059,96.172,96.171S310.036,279.773,256.923,279.773z"
                                        />
                                    </g>
                              </svg>
                            </p>
                        <?php endif;?>
                    </div>
                    <div class="modal-body">
                        <div id="mapFullSize" style="width: 100%; height: 100%;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php // Правая часть с картинками?>
    <div class="col-12 col-lg-8">
        <div class="item-slider">
            <span class="add-item-favorite">
                <?php if (!$USER->IsAuthorized()):?><a data-toggle="modal" data-target="#logInModal" class="d-flex align-items-center mr-3" href="#"><?php endif;?>
                     <svg id="iconLike" data-ad_id="<?= $arResult['ID']; ?>" class="iconLike like" viewBox="0 0 612 792">
                         <path d="M562.413,284.393c-9.68,41.044-32.121,78.438-64.831,108.07L329.588,542.345l-165.11-149.843 c-32.771-29.691-55.201-67.076-64.892-108.12c-6.965-29.484-4.103-46.14-4.092-46.249l0.147-0.994 c6.395-72.004,56.382-124.273,118.873-124.273c46.111,0,86.703,28.333,105.965,73.933l9.061,21.477l9.061-21.477 c18.958-44.901,61.694-73.922,108.896-73.922c62.481,0,112.478,52.27,119,125.208C566.517,238.242,569.379,254.908,562.413,284.393z"/>
                     </svg>
                <?php if (!$USER->IsAuthorized()):?></a><?php endif;?>
            </span>
            <?php if (!empty($arResult['PHOTOS'])):?>
                <div class="slider-for">
                     <?php foreach ($arResult['PHOTOS']['BIG'] as $k => $img):?>
                         <div class="slide"
                              data-toggle="modal"
                              data-target="#modalFullSize"
                              data-current-slider="<?=$k;?>"
                         >
                                <img src="<?=$img['src']?>"
                                     alt="<?=$arResult['NAME']?>"
                                     title="<?=$arResult['NAME']?>"
                                >
                        </div>
                    <?php endforeach;?>
                </div>
                <div class="dots slider-nav">
                    <?php
                    $count = !empty($arResult['PHOTOS']['SMALL']) ? count($arResult['PHOTOS']['SMALL']) : 0;
                    foreach ($arResult['PHOTOS']['SMALL'] as $k => $img):?>
                        <?php if ($count > 10 && $k == 9):?>
                            <div class="dot all-photo" data-toggle="modal" data-target="#modalFullSize">
                                <img src="<?=$img['src']?>" alt="">
                                <span class="text">Еще <?=($count - 10)?> фото</span>
                            </div>
                            <?php break;?>
                        <?php else :?>
                            <div class="dot" data-slide="<?= $k; ?>">
                                <img src="<?=$img['src']?>"
                                     alt="<?=$arResult['NAME']?>"
                                     title="<?=$arResult['NAME']?>"
                                >
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            <?php endif;?>
            <?php // Модалка с картинками?>
            <div class="modal fade" id="modalFullSize" tabindex="-1" role="dialog"
                 aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                <div class="modal-dialog m-0 mw-100" role="document">
                    <div class="modal-content bg-transparent">
                        <div class="fullScreenItemModal">
                            <button type="button" class="m-0 mr-auto close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <div class="slider-counter-mobile"></div>
                            <div class="fullScreenItemModal__content">
                                <div class="row h-100">
                                    <div class="col-3 seller-cards">
                                        <?php if (!$arParams['USER_ID']) { ?>
                                            <div class="mb-4 card connection-with-seller text-right 4">
                                                <h1 class="mb-4 connection-with-seller__title"><?= $arResult['NAME']; ?></h1>
                                                <p class="mb-4 connection-with-seller__price text-primary">
                                                    <?= number_format($arResult['PROPERTIES']['PRICE']['VALUE'], 0, '.', ' '); ?> <?= ICON_CURRENCY; ?>
                                                </p>
                                                <?php if ($arResult['PROPERTIES']['LOCATION']['VALUE']) { ?>
                                                    <p class="pb-3 border-bottom">
                                                        <span class="mr-1"><?= $arResult['PROPERTIES']['LOCATION']['VALUE']; ?></span>
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
                                                <?php } ?>
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
                                                        <?php include $_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH . "/includes/footer/register_modal.php"; ?>
                                                        <?php include $_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH . "/includes/footer/auth_modal.php"; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } elseif ($arParams['USER_ID'] == $arResult['PROPERTIES']['ID_USER']['VALUE']) { ?>
                                            <div class="mb-4 card connection-with-seller text-right 5">
                                                <h1 class="mb-4 connection-with-seller__title"><?= $arResult['NAME']; ?></h1>
                                                <p class="mb-4 connection-with-seller__price text-primary">
                                                    <?= number_format($arResult['PROPERTIES']['PRICE']['VALUE'], 0, '.', ' '); ?> <?= ICON_CURRENCY; ?>
                                                </p>
                                                <?php if ($arResult['PROPERTIES']['LOCATION']['VALUE']) { ?>
                                                    <p class="pb-3 border-bottom">
                                                        <span class="mr-1"><?= $arResult['PROPERTIES']['LOCATION']['VALUE']; ?></span>
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
                                                <?php } ?>
                                                <div class="flex-column">
                                                    <a href="<?=$arResult['EDIT_PAGE']?>" class="mb-3 w-100 btn btn-primary text-uppercase font-weight-bold">
                                                        <?= Loc::getMessage('EDIT'); ?>
                                                    </a>
                                                    <?php
                                                    $APPLICATION->IncludeComponent(
                                                        "webco:buttons",
                                                        "boost",
                                                        array(
                                                            'ITEM_ID' => $arResult['ID'],
                                                            'IBLOCK_ID' => $arResult['IBLOCK_ID'],
                                                            'DETAIL_PAGE' => 'Y'
                                                        )
                                                    );
                                                    ?>
                                                </div>
                                            </div>
                                        <?php } else { ?>
                                            <div class="mb-4 card connection-with-seller text-right 6">
                                                <h1 class="mb-4 connection-with-seller__title"><?= $arResult['NAME']; ?></h1>
                                                <p class="mb-4 connection-with-seller__price text-primary">
                                                    <?= number_format($arResult['PROPERTIES']['PRICE']['VALUE'], 0, '.', ' '); ?> <?= ICON_CURRENCY; ?>
                                                </p>
                                                <?php if ($arResult['PROPERTIES']['LOCATION']['VALUE']) { ?>
                                                    <p class="pb-3 border-bottom">
                                                        <span class="mr-1"><?= $arResult['PROPERTIES']['LOCATION']['VALUE']; ?></span>
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
                                                <?php } ?>
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
                                                <ul class="text-right collapse contact-list"
                                                    id="showContactPhone">
                                                    <li class="d-flex justify-content-end">
                                                        <p class="mb-0 d-flex align-items-center time">
                                                            <?php if ($arResult['PROPERTIES']['UF_CALL_ANYTIME']['VALUE'] == 1) { ?>
                                                                <span class="mx-2"><?= Loc::getMessage('CALL_ANYTIME'); ?></span>
                                                            <?php } else { ?>

                                                                from<span
                                                                        class="mx-2"><?= $arResult['PROPERTIES']['UF_CALL_FROM']['VALUE'] ?></span>
                                                                to <span
                                                                        class="mx-2"><?= $arResult['PROPERTIES']['UF_CALL_TO']['VALUE'] ?></span>
                                                            <?php } ?>
                                                            <svg width="20" height="20" viewBox="0 0 20 20"
                                                                 fill="none"
                                                                 xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M9.99 0C4.47 0 0 4.48 0 10C0 15.52 4.47 20 9.99 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 9.99 0ZM10 18C5.58 18 2 14.42 2 10C2 5.58 5.58 2 10 2C14.42 2 18 5.58 18 10C18 14.42 14.42 18 10 18ZM9.78 5H9.72C9.32 5 9 5.32 9 5.72V10.44C9 10.79 9.18 11.12 9.49 11.3L13.64 13.79C13.98 13.99 14.42 13.89 14.62 13.55C14.6702 13.469 14.7036 13.3788 14.7182 13.2846C14.7328 13.1905 14.7283 13.0943 14.705 13.002C14.6817 12.9096 14.64 12.8229 14.5824 12.7469C14.5249 12.671 14.4526 12.6074 14.37 12.56L10.5 10.26V5.72C10.5 5.32 10.18 5 9.78 5Z"
                                                                      fill="#555555"/>
                                                            </svg>

                                                        </p>
                                                    </li>
                                                    <?php if ($arResult['USER']['PERSONAL_PHONE']) { ?>
                                                        <li>
                                                            <a href="tel:<?= $arResult['USER']['PERSONAL_PHONE'] ?>"><?= $arResult['USER']['PERSONAL_PHONE'] ?></a>
                                                        </li>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="main-contetnt col-12 col-xl-9">
                                        <div class="row h-100">
                                            <div class="col-12 col-xl-10">
                                                <div class="mainItemSlider">
                                                    <?php foreach ($arResult['PHOTOS']['BIG_SLIDER'] as $k => $img):?>
                                                        <div class="slide">
                                                            <img src="<?=$img['src']?>"
                                                                 alt="<?=$arResult['NAME']?>"
                                                                 title="<?=$arResult['NAME']?>"
                                                            >
                                                        </div>
                                                    <?php endforeach ?>
                                                </div>
                                            </div>
                                            <div class="d-none d-xl-flex col-xl-2">
                                                <div class="dots navMainItemSlider">
                                                    <?php foreach ($arResult['PHOTOS']['SMALL_SLIDER'] as $k => $img):?>
                                                        <div class="dots__dot">
                                                            <img src="<?=$img['src']?>"
                                                                 alt="<?=$arResult['NAME']?>"
                                                                 title="<?=$arResult['NAME']?>"
                                                            >
                                                        </div>
                                                    <?php endforeach ?>
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
                                <?php if($USER->IsAuthorized()){?>
                                <div class="d-flex justify-content-center align-items-center call-item">
                                    <a href="tel:+375293069433" class="btn">
                                        <svg width="17" height="17" viewBox="0 0 17 17" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path d="M11.3239 12.0618L12.7799 10.6058C12.976 10.4122 13.2242 10.2796 13.4942 10.2242C13.7642 10.1688 14.0444 10.193 14.3009 10.2938L16.0754 11.0023C16.3347 11.1076 16.5569 11.2872 16.7143 11.5185C16.8716 11.7498 16.9569 12.0226 16.9594 12.3023V15.5523C16.9579 15.7426 16.9179 15.9307 16.8418 16.1051C16.7657 16.2795 16.6551 16.4368 16.5167 16.5673C16.3782 16.6979 16.2148 16.7991 16.0362 16.8648C15.8576 16.9306 15.6675 16.9595 15.4774 16.9498C3.04294 16.1763 0.533938 5.64633 0.0594376 1.61633C0.037411 1.41843 0.0575361 1.21811 0.118489 1.02854C0.179442 0.838978 0.279841 0.664466 0.413081 0.51649C0.546322 0.368513 0.709384 0.250424 0.89154 0.169993C1.0737 0.0895611 1.27082 0.0486092 1.46994 0.0498313H4.60944C4.88959 0.0506605 5.1631 0.135285 5.39476 0.29282C5.62643 0.450356 5.80568 0.673597 5.90944 0.933831L6.61794 2.70833C6.7221 2.96383 6.74868 3.24435 6.69434 3.51486C6.64001 3.78537 6.50718 4.03387 6.31244 4.22933L4.85644 5.68533C4.85644 5.68533 5.69494 11.3598 11.3239 12.0618Z"
                                                  fill="white"/>
                                        </svg>
                                    </a>
                                </div>
                                <?php }?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-4 card">
            <div class="p-4 text-right property-about-item">
                <div class="<?=!empty($arResult['PREVIEW_TEXT']) ? 'mb-4 pb-4 border-bottom' : ''?> row text-center property-about-item__short-description">
                    <div class="col border-right">
                        <p class="mb-2 text-secondary font-weight-bold">Floor:</p>
                        <span class="d-flex justify-content-center align-items-center font-weight-bold">
                          <i class="pr-2 text-secondary icon-stairs"></i>
                          <?= $arResult['PROPERTIES']['PROP_FLOOR']['VALUE'] ?>
                        </span>
                    </div>
                    <div class="col border-right">
                        <p class="mb-2 text-secondary font-weight-bold">Area, м²:</p>
                        <span class="d-flex justify-content-center align-items-center font-weight-bold">
                          <i class="pr-2 text-secondary icon-plans"></i>
                          <?= $arResult['PROPERTIES']['PROP_AREA_3']['VALUE'] ?>
                        </span>
                    </div>
                    <?php if (!empty($arResult['IBLOCK_SECTION_ID']) &&
                        in_array($arResult['IBLOCK_SECTION_ID'],RENT_SECTION_ID_ARRAY) &&
                        !empty($arResult['PROPERTIES']['PROP_Completion']['VALUE'])):?>
                        <div class="col border-right">
                            <p class="mb-2 text-secondary font-weight-bold">Completion:</p>
                            <span class="d-flex justify-content-center align-items-center font-weight-bold">
                              <i class="pr-2 text-secondary icon-calendar"></i>
                              <?= $arResult['PROPERTIES']['PROP_Completion']['VALUE'] ?>
                            </span>
                        </div>
                    <?php endif;?>
                    <div class="col">
                        <p class="mb-2 text-secondary font-weight-bold">Rooms:</p>
                        <span class="d-flex justify-content-center align-items-center font-weight-bold">
                          <i class="pr-2 text-secondary icon-sketch"></i>
                          <?= $arResult['PROPERTIES']['PROP_COUNT_ROOMS']['VALUE'] ?>
                        </span>
                    </div>
                </div>
                <?php if (!empty($arResult['PREVIEW_TEXT'])):?>
                    <p class="h6 text-uppercase font-weight-bolder">Description</p>
                    <div class="d-flex flex-column-reverse align-items-end collaps-text-about">
                        <?php if (strlen($arResult['PREVIEW_TEXT']) > 350) { ?>
                            <a class="py-2 py-lg-3 px-3 btn btn-primary text-uppercase font-weight-bold collaps-text-about-btn">Show more</a>
                            <p class="property-about-item__text collaps-text-about-text"><?=$arResult['PREVIEW_TEXT']?></p>
                        <?php } else { ?>
                            <p class="property-about-item__text collaps-text-about-text show"><?=$arResult['PREVIEW_TEXT']?></p>
                        <?php } ?>
                    </div>
                <?php endif;?>
            </div>
        </div>
        <?php if (!empty($arResult['PROPERTIES'])):?>
            <p class=" h2 mb-4 subtitle">Description</p>
            <div class="mb-4">
                <div class="card p-4">
                    <table class="property-item-table table">
                        <tbody>
                            <tr>
                                <td class="border-top-0"></td>
                                <td class="border-top-0 font-weight-bold"></td>
                            </tr>
                            <?php foreach ($arResult['PROPERTIES'] as $prop):?>
                                <?php if (strripos($prop['CODE'], 'PROP') !== false && $prop['MULTIPLE'] == 'Y' && !empty($prop['VALUE']) && $prop['CODE'] !== 'PHOTOS'):?>
                                    <tr>
                                        <td>
                                            <?php if (is_array($prop['VALUE'])):
                                                foreach ($prop['VALUE'] as $key => $value):?>
                                                    <?='- '.$value . '</br>'?>
                                                <?php endforeach;?>
                                            <?php else:?>
                                                <?=$prop['VALUE']?>
                                            <?php endif;?>
                                        </td>
                                        <td class="font-weight-bold">:<?=$prop['NAME']?></td>
                                    </tr>
                                <?php endif;?>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif;?>
    </div>
</div>

<?php $this->setViewTarget('detail_mobile_buttons');?>
    <?php if (!empty($arParams['USER_ID']) && $USER->IsAuthorized()):?>
        <div class="mobile-block-show-contacts">
            <ul class="list-unstyled">
                <button type="button" class="close" id="closeNumberList">
                    <span aria-hidden="true">&times;</span>
                </button>
                <li class="justify-content-end">
                    <p class="mb-0 d-flex align-items-center time">
                        <?php if ($arResult['PROPERTIES']['UF_CALL_ANYTIME']['VALUE'] == 1):?>
                            <span class="mx-2"><?= Loc::getMessage('CALL_ANYTIME'); ?></span>
                        <?php else :?>
                            from <span class="mx-2"><?= $arResult['PROPERTIES']['UF_CALL_FROM']['VALUE'] ?></span>
                            to <span class="mx-2"><?= $arResult['PROPERTIES']['UF_CALL_TO']['VALUE'] ?></span>
                        <?php endif;?>
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.99 0C4.47 0 0 4.48 0 10C0 15.52 4.47 20 9.99 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 9.99 0ZM10 18C5.58 18 2 14.42 2 10C2 5.58 5.58 2 10 2C14.42 2 18 5.58 18 10C18 14.42 14.42 18 10 18ZM9.78 5H9.72C9.32 5 9 5.32 9 5.72V10.44C9 10.79 9.18 11.12 9.49 11.3L13.64 13.79C13.98 13.99 14.42 13.89 14.62 13.55C14.6702 13.469 14.7036 13.3788 14.7182 13.2846C14.7328 13.1905 14.7283 13.0943 14.705 13.002C14.6817 12.9096 14.64 12.8229 14.5824 12.7469C14.5249 12.671 14.4526 12.6074 14.37 12.56L10.5 10.26V5.72C10.5 5.32 10.18 5 9.78 5Z"
                                  fill="#555555"/>
                        </svg>

                    </p>
                </li>
                <?php if ($arResult['USER']['PERSONAL_PHONE']):?>
                    <li>
                        <a href="tel:<?= $arResult['USER']['PERSONAL_PHONE'] ?>">
                            <?= $arResult['USER']['PERSONAL_PHONE'] ?>
                        </a>
                    </li>
                <?php endif;?>
            </ul>
            <div class="button-wrap d-flex">
                <button class="btn btn-show-phone w-100 text-uppercase font-weight-bold"
                        id="showListUserNumber"
                        <?=empty($arParams['USER_ID']) ? 'disabled' : ''?>
                >
                    <?=Loc::getMessage('SHOW_PHONE')?>
                </button>
                <button class="btn btn-primary btn-sand-message w-100 text-uppercase font-weight-bold"
                        data-toggle="modal"
                        data-target="#modalSandMessage"
                        <?=empty($arParams['USER_ID']) ? 'disabled' : ''?>
                >
                    <?= Loc::getMessage('SEND_MESSAGE'); ?>
                </button>
            </div>
        </div>
    <?php endif;?>
<?php $this->endViewTarget();?>

<?php // MODALS?>
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
                              placeholder="Text message" required></textarea>

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
                            <button type="button" class="btn btn-transparent" data-dismiss="modal">Close</button>
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
