<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 */

$this->setFrameMode(true);

require_once $_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/include/classes/AuctionBase.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/include/classes/AuctionBidding.php';

$this->addExternalJs(SITE_TEMPLATE_PATH . '/js/auction-card.js');

$Auction = new AuctionBidding($arResult['ID'], $arParams['IBLOCK_ID'], IBLOCK_ID_AUCTION_RATES);

$templateLibrary = array('popup', 'fx');
$currencyList = '';

if (!empty($arResult['CURRENCIES'])) {
    $templateLibrary[] = 'currency';
    $currencyList = CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true);
}

$templateData = array(
    'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
    'TEMPLATE_LIBRARY' => $templateLibrary,
    'CURRENCIES' => $currencyList,
    'ITEM' => array(
        'ID' => $arResult['ID'],
        'IBLOCK_ID' => $arResult['IBLOCK_ID'],
    )
);
unset($currencyList, $templateLibrary);

$mainId = $this->GetEditAreaId($arResult['ID']);
$itemIds = array(
    'ID' => $mainId,
    'DISCOUNT_PERCENT_ID' => $mainId . '_dsc_pict',
    'STICKER_ID' => $mainId . '_sticker',
    'BIG_SLIDER_ID' => $mainId . '_big_slider',
    'BIG_IMG_CONT_ID' => $mainId . '_bigimg_cont',
    'SLIDER_CONT_ID' => $mainId . '_slider_cont',
    'OLD_PRICE_ID' => $mainId . '_old_price',
    'PRICE_ID' => $mainId . '_price',
    'DISCOUNT_PRICE_ID' => $mainId . '_price_discount',
    'PRICE_TOTAL' => $mainId . '_price_total',
    'SLIDER_CONT_OF_ID' => $mainId . '_slider_cont_',
    'QUANTITY_ID' => $mainId . '_quantity',
    'QUANTITY_DOWN_ID' => $mainId . '_quant_down',
    'QUANTITY_UP_ID' => $mainId . '_quant_up',
    'QUANTITY_MEASURE' => $mainId . '_quant_measure',
    'QUANTITY_LIMIT' => $mainId . '_quant_limit',
    'BUY_LINK' => $mainId . '_buy_link',
    'ADD_BASKET_LINK' => $mainId . '_add_basket_link',
    'BASKET_ACTIONS_ID' => $mainId . '_basket_actions',
    'NOT_AVAILABLE_MESS' => $mainId . '_not_avail',
    'COMPARE_LINK' => $mainId . '_compare_link',
    'TREE_ID' => $mainId . '_skudiv',
    'DISPLAY_PROP_DIV' => $mainId . '_sku_prop',
    'DESCRIPTION_ID' => $mainId . '_description',
    'DISPLAY_MAIN_PROP_DIV' => $mainId . '_main_sku_prop',
    'OFFER_GROUP' => $mainId . '_set_group_',
    'BASKET_PROP_DIV' => $mainId . '_basket_prop',
    'SUBSCRIBE_LINK' => $mainId . '_subscribe',
    'TABS_ID' => $mainId . '_tabs',
    'TAB_CONTAINERS_ID' => $mainId . '_tab_containers',
    'SMALL_CARD_PANEL_ID' => $mainId . '_small_card_panel',
    'TABS_PANEL_ID' => $mainId . '_tabs_panel'
);
$obName = $templateData['JS_OBJ'] = 'ob' . preg_replace('/[^a-zA-Z0-9_]/', 'x', $mainId);

$haveOffers = !empty($arResult['OFFERS']);

$showOffersBlock = $haveOffers && !empty($arResult['OFFERS_PROP']);
$mainBlockProperties = array_intersect_key($arResult['DISPLAY_PROPERTIES'], $arParams['MAIN_BLOCK_PROPERTY_CODE']);
$showPropsBlock = !empty($mainBlockProperties) || $arResult['SHOW_OFFERS_PROPS'];
$showBlockWithOffersAndProps = $showOffersBlock || $showPropsBlock;

$auctionState = $arResult['AUCTION_STATE'];
$dataFinish = $arResult['DATA_FINISH'];
$dataFinishTs = $arResult['DATA_FINISH_TS'];

if ($arResult['AUCTION_STATE'] == $Auction::AUCTION_STATE_BIDDING_FINISHED && empty($arResult['PROPERTIES']['STATUS_FINAL']['VALUE'])) {
    // время вышло, но статус не сменён...
    // финалим аукцион
    $Auction->finalize();

    LocalRedirect($arResult['DETAIL_PAGE_URL']);
}

// тип торгов... lang-константа
$tradeTypeLangConst = 'TRADE_TYPE_' . mb_strtoupper(str_replace('-', '_', $arResult['DISPLAY_PROPERTIES']['TRADE_TYPE_REQUIRED']['VALUE_XML_ID']));

// рандомно определяем интервал обновления информации по текущим торгам,
// чтобы пользователя не разлогинило
$checkStatusVoteIntervalWs = rand(20, 100) * 1000;
//echo ($arResult['PROPERTIES']['APPS_DATE_START_REQUIRED']['VALUE']);

//pr($arResult['GROUPS_TREE']);
?>
<? /*
<div><?= "Текущее время" . ': ' . $arResult['OBJ_DATE_TIME_NOW']->toString() ?></div>
<div><?= $arResult['PROPERTIES']['APPS_DATE_START_REQUIRED']['NAME'] . ': ' . $arResult['PROPERTIES']['APPS_DATE_START_REQUIRED']['VALUE']?></div>
<div><?= $arResult['PROPERTIES']['APPS_DATE_END_REQUIRED']['NAME'] . ': ' . $arResult['PROPERTIES']['APPS_DATE_END_REQUIRED']['VALUE']?></div>
*/ ?>
<div class="card" id="<?= $itemIds['ID'] ?>">
    <div class="card-main" data-aos="fade-right">
        <div class="card-main__lot"><?= Loc::getMessage('LOT') ?>: <?= $arResult['ID'] ?></div>
        <div class="auction-gallery">
            <div class="auction-gallery__main js-gallery__main">
                <?
                foreach ($arResult['MORE_PHOTO'] as $key => $photo) {
                    ?>
                    <div class="auction-gallery__main-slide"><a href="<?= $photo['SRC'] ?>"
                                                                style="background-image: url('<?= $photo['SRC'] ?>')"></a>
                    </div><?
                }
                ?>
            </div>
            <div class="auction-gallery__nav js-gallery__nav">
                <?
                foreach ($arResult['MORE_PHOTO'] as $key => $photo) {
                    ?>
                    <div class="auction-gallery__nav-slide">
                    <div class="img" style="background-image: url('<?= $photo['SRC'] ?>')"></div></div><?
                }
                ?>
            </div>
        </div>
        <div class="card-main__content">
            <div class="content-zag"><?= Loc::getMessage('LOT_BASE_INFO') ?>:</div>
            <div class="card-list">
                <?
                foreach ($arResult['GROUPS_TREE'] as $arGroup) {
                    if (empty($arGroup['NAME']) || empty($arGroup['ITEMS']) || $arGroup['NAME'] == 'Дополнительно') continue;
                    ?>
                    <div class="card-list__item js-card-list__item">
                        <div class="card-list__item-name js-card-list__name">
                            <span><?= $arGroup['NAME'] ?></span>
                            <svg class="icon icon-arrow-drop ">
                                <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/img/svg/symbol/sprite.svg#arrow-drop"></use>
                            </svg>
                        </div>

                        <div class="card-list__hide js-content">
                            <? foreach ($arGroup['ITEMS'] as $arProp) { ?>
                                <div class="card-list__item-content">
                                    <div class="zag"><?= $arProp['NAME'] ?></div>
                                    <div class="val"><?= $arProp['DISPLAY_VALUE'] ?></div>
                                </div>
                            <? } ?>
                        </div>
                    </div>
                    <?
                }
                ?>
                <? if (!empty($arResult['DISPLAY_PROPERTIES']['DOCUMENTS']['DISPLAY_VALUE'])) { ?>
                    <div class="card-list__item js-card-list__item">
                        <div class="card-list__item-name js-card-list__name">
                            <span><?= Loc::getMessage('DOCUMENTS_COPIES') ?></span>
                            <svg class="icon icon-arrow-drop ">
                                <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/img/svg/symbol/sprite.svg#arrow-drop"></use>
                            </svg>
                        </div>
                        <div class="card-list__hide js-content">
                            <div class="card-list__item-doc">
                                <div class="list-doc">
                                    <? if (!empty($arResult['DISPLAY_PROPERTIES']['DOCUMENTS']['FILE_VALUE']['ID'])) { ?>
                                        <a class="documents w100"
                                           href="<?= $arResult['DISPLAY_PROPERTIES']['DOCUMENTS']['FILE_VALUE']['SRC'] ?>"
                                           download>
                                            <div class="img"><img
                                                        src="<?= SITE_TEMPLATE_PATH ?>/img/content/documents.png"></div>
                                            <div class="name">
                                                <span class="blue"><?= $arResult['DISPLAY_PROPERTIES']['DOCUMENTS']['FILE_VALUE']['ORIGINAL_NAME'] ?></span>
                                                <span><?= CFile::FormatSize($arResult['DISPLAY_PROPERTIES']['DOCUMENTS']['FILE_VALUE']['FILE_SIZE']) ?></span>
                                            </div>
                                        </a>
                                    <? } else { ?>
                                        <? foreach ($arResult['DISPLAY_PROPERTIES']['DOCUMENTS']['FILE_VALUE'] as $arFile) { ?>
                                            <a class="documents w100" href="<?= $arFile['SRC'] ?>" download>
                                                <div class="img"><img
                                                            src="<?= SITE_TEMPLATE_PATH ?>/img/content/documents.png">
                                                </div>
                                                <div class="name">
                                                    <span class="blue"><?= $arFile['ORIGINAL_NAME'] ?></span>
                                                    <span><?= CFile::FormatSize($arFile['FILE_SIZE']) ?></span>
                                                </div>
                                            </a>
                                        <? } ?>
                                    <? } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <? } ?>

                <div class="card-list__item js-card-list__item">
                    <div class="card-list__item-name js-card-list__name">
                        <span><?= Loc::getMessage('ORGANIZATOR_INFO') ?></span>
                        <svg class="icon icon-arrow-drop ">
                            <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/img/svg/symbol/sprite.svg#arrow-drop"></use>
                        </svg>
                    </div>
                    <div class="card-list__hide js-content">
                        <div class="card-list__item-content">
                            <div class="zag"><?= Loc::getMessage('ORGANIZATOR_INFO_NAME') ?></div>
                            <div class="val">Evsun Ltd</div>
                        </div>
                        <div class="card-list__item-content">
                            <div class="zag"><?= Loc::getMessage('ORGANIZATOR_INFO_WEBSITE') ?></div>
                            <div class="val"><?= getDomainUrl() ?></div>
                        </div>
                        <div class="card-list__item-content">
                            <div class="zag"><?= Loc::getMessage('ORGANIZATOR_INFO_COUNTRY') ?></div>
                            <div class="val">Cyprus</div>
                        </div>
                        <div class="card-list__item-content">
                            <div class="zag"><?= Loc::getMessage('ORGANIZATOR_INFO_CITY') ?></div>
                            <div class="val">Nicosia</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-info __auction" data-aos="fade-left">
        <div class="card-info__top">
            <div class="card-info__count">
                <svg class="icon icon-card-info-count ">
                    <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/img/svg/symbol/sprite.svg#card-info-count"></use>
                </svg>
                <span><b><?= Loc::getMessage('PARTICIPATION_COUNT') ?>: </b><?= $arResult['PARTICIPATION_COUNT'] ?></span>
            </div>
            <div class="card-info__rules">
                <a class="documents ajax-form" data-class="w800" href="<?= SITE_DIR ?>modals/static/auction-rules/"
                   download>
                    <svg class="icon icon-card-info-doc ">
                        <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/img/svg/symbol/sprite.svg#card-info-doc"></use>
                    </svg>
                    <span><?= Loc::getMessage('GENERAL_RULES') ?></span>
                </a>
            </div>
        </div>

        <div class="card-info__item border-blue __timer">
            <div class="zag"><?= Loc::getMessage("AUCTION_STATE_TITLE_{$auctionState}") ?>:</div>
            <? if ($auctionState == $Auction::AUCTION_STATE_BIDDING_FINISHED) { ?>
                <? $ar = explode(' ', $arResult['PROPERTIES']['AUCTION_DATE_END_REQUIRED']['VALUE']); ?>
                <div class="card-info__item-time__sm"><span><?= $ar[0] ?></span><span><?= $ar[1] ?></span></div>
            <? } else { ?>
                <div class="card-info__timer js-timer" data-finish="<?= $dataFinish ?>"
                     data-finish-ts="<?= $dataFinishTs ?>" <?= $auctionState == $Auction::AUCTION_STATE_BIDDING_FINISHED ? 'style="opacity: 0;visibility: hidden;"' : '' ?>>
                    <div class="timer_section js-timer_section" data-type="days">
                        <div class="num days_1 js-days_1">0</div>
                        <div class="num days_2 js-days_2">0</div>
                        <div class="timer_section_desc"><?= Loc::getMessage('TIMER_DAYS') ?></div>
                    </div>
                    <div class="timer_section js-timer_section" data-type="hours">
                        <div class="num hours_1 js-hours_1">0</div>
                        <div class="num hours_2 js-hours_2">0</div>
                        <div class="timer_section_desc"><?= Loc::getMessage('TIMER_HOURS') ?></div>
                    </div>
                    <div class="timer_section js-timer_section" data-type="minutes">
                        <div class="num minutes_1 js-minutes_1">0</div>
                        <div class="num minutes_2 js-minutes_2">0</div>
                        <div class="timer_section_desc"><?= Loc::getMessage('TIMER_MINUTES') ?></div>
                    </div>
                    <div class="timer_section js-timer_section" data-type="seconds">
                        <div class="num seconds_1 js-seconds_1">0</div>
                        <div class="num seconds_2 js-seconds_2">0</div>
                        <div class="timer_section_desc"><?= Loc::getMessage('TIMER_SECONDS') ?></div>
                    </div>
                </div>
            <? } ?>
        </div>

        <? if ($auctionState == $Auction::AUCTION_STATE_BIDDING_IN_PROCESS && !empty($arResult['USER_ID'])) { ?>
            <? /* идут торги и пользователь авторизован */ ?>
            <div class="card-info__item border-blue w50">
                <div class="info-zag"><?= Loc::getMessage('TRADE_TYPE') ?>:</div>
                <div class="info-val"><?= $arResult['DISPLAY_PROPERTIES']['TRADE_TYPE_REQUIRED']['DISPLAY_VALUE'] ?></div>
            </div>

            <div class="card-info__item border-blue w50">
                <div class="info-zag"><?= Loc::getMessage('USER_RATE_STATUS') ?>:</div>
                <div id="userRateStatus" class="info-val"></div>
            </div>

            <div class="card-info__item border-blue">
                <div id="your-name" class="info-zag"><?= Loc::getMessage('YOUR_NAME_IN_AUCTION') ?>: <span
                            class="blue"><?= $arResult['USER_INFO']['NAME'] ?></span></div>
            </div>
        <? } elseif ($auctionState == $Auction::AUCTION_STATE_APPS_IN_PROCESS && $arResult['USER_SEND_PARTICIPATION'] == 'Y') { ?>
            <div class="card-info__item border-blue w50">
                <div class="info-zag"><?= Loc::getMessage('TRADE_TYPE') ?>:</div>
                <div class="info-val"><?= $arResult['DISPLAY_PROPERTIES']['TRADE_TYPE_REQUIRED']['DISPLAY_VALUE'] ?></div>
            </div>

            <div class="card-info__item border-blue w50">
                <div class="info-zag"><?= Loc::getMessage('USER_RATE_STATUS') ?>:</div>
                <div id="userRateStatus"
                     class="info-val"><?= Loc::getMessage("USER_PARTICIPATION_STATUS_{$arResult['USER_PARTICIPATION_STATUS']}") ?></div>
            </div>

            <div class="card-info__item border-blue" style="display: none;">
                <div id="your-name" class="info-zag"></div>
            </div>
        <? } else { ?>
            <div class="card-info__item border-blue">
                <div class="info-zag"><?= Loc::getMessage('TRADE_TYPE') ?>:</div>
                <div class="info-val"><?= $arResult['DISPLAY_PROPERTIES']['TRADE_TYPE_REQUIRED']['DISPLAY_VALUE'] ?></div>
            </div>
            <? if ($arResult['AUCTION_STATE'] == $Auction::AUCTION_STATE_BIDDING_FINISHED && $arResult['USER_ID'] == $arResult['LAST_RATE']['CREATED_BY']) { ?>
                <div class="card-info__item border-blue w100">
                    <div class="info-val"
                         style="color: green"><?= Loc::getMessage('AUCTION_WINNER_CONGRATULATIONS') ?></div>
                </div>
            <? } ?>
            <div class="card-info__item border-blue" style="display: none;">
                <div id="your-name" class="info-zag"></div>
            </div>
        <? } ?>

        <div class="card-info__item">
            <? if (!empty($arResult['LOCATION_DATA'])) { ?>
                <div class="info-list"><b><?= Loc::getMessage("LOT_ADDRESS") ?>
                        : </b><?= implode(', ', $arResult['LOCATION_DATA']) ?></div>
            <? } ?>
            <div class="info-list"><b><?= Loc::getMessage("LOT_SELLER") ?>: </b><?= $arResult['SELLER_INFO']['NAME'] ?>
            </div>
        </div>
        <script>console.log(<?=json_encode($arResult['PROPERTIES'])?>)</script>
        <? if (!$arResult['PROPERTIES']['SMART_CONTRACT_ID']['VALUE'] && $arResult['PROPERTIES']['STATUS_FINAL']['VALUE_XML_ID'] == "success") { ?>
            <? if ($arResult['USER_ID'] == $arResult['LAST_RATE']['CREATED_BY'] || $arResult['CREATED_BY'] == $arResult['USER_ID']) { ?>
                <div class="card-info__item">
                    <div class="b_info">
                        <a href="?CONTRACT=Y"><?= Loc::getMessage('SMART_CONTRACT') ?></a>
                    </div>
                </div>
            <? } ?>
        <? } elseif ($arResult['CREATED_BY'] == $USER->GetID() && $arResult['PROPERTIES']['STATUS_FINAL']['VALUE_XML_ID'] == "success") { ?>
        <? if ($arResult['USER_ID'] == $arResult['LAST_RATE']['CREATED_BY'] || $arResult['CREATED_BY'] == $arResult['USER_ID']) { ?>
            <div class="card-info__item">
                <div class="b_info">
                    <a href="?CONTRACT=Y&CREATE=Y"><?= Loc::getMessage('ADD_SMART_CONTRACT') ?></a>
                </div>
            </div>
            <? } ?>
        <? } ?>
        <?if($auctionState < $Auction::AUCTION_STATE_BIDDING_WAITING && $arResult['CREATED_BY'] == $USER->GetID()){?>
            <div class="card-info__item">
                <div id="<?=$arResult['ID']?>" class="b_info invite_user">
                    <a href="#"><?= Loc::getMessage('INVITE_USER') ?></a>
                </div>
            </div>
        <?}?>
        <? if ($auctionState == $Auction::AUCTION_STATE_BIDDING_IN_PROCESS) { ?>
            <? // торги идут прямо сейчас ?>
            <? if ($arResult['USER_SEND_PARTICIPATION'] == 'Y' && $arResult['USER_PARTICIPATION_STATUS'] == OFFER_STATUS_APPROVED) { ?>
                <? // заява на участие одобрена ?>
                <form id="auctionForm" class="card-info__item item__auction">
                    <?= bitrix_sessid_post() ?>
                    <input type="hidden" name="ID" value="<?= $arResult['ID'] ?>">
                    <input type="hidden" name="IBLOCK_ID_AUCTION" value="<?= $arParams['IBLOCK_ID'] ?>">
                    <input type="hidden" name="IBLOCK_ID_RATES" value="<?= IBLOCK_ID_AUCTION_RATES ?>">
                    <input type="hidden" name="TASK" id="TASK" value="checkState">
                    <input type="hidden" name="firstCheck" id="firstCheck" value="1">
                    <? if ($arResult['PARTICIPATION_COUNT'] > 1) { ?>
                        <? /* кол-во участников больше 1 */ ?>
                        <div class="zag"><?= Loc::getMessage("LOT_CURRENT_PRICE") ?></div>
                        <div class="price-end">
                            <div id="currentPrice" style="display:inline;"><?= $arResult['PRINT_CURRENT_PRICE'] ?></div>
                            <span class="type"><?= $arResult['DISPLAY_PROPERTIES']['VAT_REQUIRED']['DISPLAY_VALUE'] ?></span>
                        </div>
                        <div class="gray"><?= Loc::getMessage("NEXT_MIN_RATE") ?> -
                            <div id="nextRate" style="display: inline;"><?= $arResult['PRINT_NEXT_STEP_VALUE'] ?></div>
                        </div>
                        <div class="step"><?= Loc::getMessage("STEP_VALUE", ['#VALUE#' => $arResult['STEP_VALUE']]) ?>
                            <div class="gray"><?= Loc::getMessage($tradeTypeLangConst) ?></div>
                        </div>
                        <div class="form-auction">
                            <div class="row">
                                <div class="form-item num--inset form-item--currency">
                                    <input id="rateValue" name="rateValue" type="text"
                                           value="<?= number_format(floatval($arResult['NEXT_STEP_VALUE']), 0, '.', '') ?>">
                                    <span class="currency"><?= $arResult['CURRENCY'] ?></span>
                                    <div id="errorRate" class="error-rate"></div>
                                </div>
                                <button id="btnSetRate" class="btn btn-blue"
                                        type="button"><?= Loc::getMessage("PLACE_BID") ?></button>
                            </div>
                            <? /*
                            <div class="form-auction__zag">Разместить автоматическую ставку:</div>
                            <div class="row">
                                <div class="form-item">
                                    <select class="styler">
					                    <?
					                    foreach ($arResult['AUTO_BIDS_LIST'] as $value=>$item)
					                    {
						                    ?><option value="<?= $value ?>"><?= $item ?></option><?
					                    }
					                    ?>
                                    </select>
                                </div>
                                <button id="btnSendVoteAuto" class="btn btn-border" type="button">Автоставка</button>
                            </div>

                            <div id="currentAutoVoteInfo" class="row">
                                <div class="form-item">
                                    <input type="text" value="710$" disabled>
                                </div>
                                <div class="form-auction__text">Текущая автоставка</div>
                            </div>
                            */ ?>
                        </div>
                        <? /*
                        <a class="form-auction__link" href="#">
                            <svg class="icon icon-tooltip ">
                                <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/img/svg/symbol/sprite.svg#tooltip"></use>
                            </svg>
                            <span>Что такое "Автоматическая ставка" и как она работает?</span>
                        </a>*/ ?>
                    <? } else { ?>
                        <?
                        /* только 1 участник */
                        $newPrice = $Auction->getBuyPrice();
                        $newPrice = $Auction->printPrice($newPrice, $arResult['CURRENCY']);
                        ?>
                        <input type="hidden" name="BUY_AGREE" id="BUY_AGREE" value="N">
                        <p><?= Loc::getMessage("OPPORTUNITY_TO_BUY", ['#LOT_NUM#' => $arResult['ID']]) ?></p>
                        <div class="auction-price"><span><?= $arResult['PRINT_CURRENT_PRICE'] ?></span></div>
                        <p><?= Loc::getMessage("OPPORTUNITY_TO_BUY_FINAL_PRICE") ?>:</p>
                        <div class="price-end"><?= $newPrice ?> <span
                                    class="type"><?= $arResult['DISPLAY_PROPERTIES']['VAT_REQUIRED']['DISPLAY_VALUE'] ?></span>
                        </div>
                        <div class="row">
                            <button class="btn btn-blue js-buy-auction"
                                    data-agree="Y"><?= Loc::getMessage("OPPORTUNITY_TO_BUY_AGREE_BTN") ?></button>
                            <button class="btn btn-border js-buy-auction"
                                    data-agree="N"><?= Loc::getMessage("OPPORTUNITY_TO_BUY_DISAGREE_BTN") ?></button>
                        </div>
                    <? } ?>
                </form>
            <? } else { ?>
                <div class="card-info__item item__auction">
                    <div class="zag"><?= Loc::getMessage("LOT_CURRENT_PRICE") ?></div>
                    <div class="price-end"><?= $arResult['PRINT_CURRENT_PRICE'] ?> <span
                                class="type"><?= $arResult['DISPLAY_PROPERTIES']['VAT_REQUIRED']['DISPLAY_VALUE'] ?></span>
                    </div>
                    <div class="gray"><?= Loc::getMessage("NEXT_MIN_RATE") ?>
                        - <?= $arResult['PRINT_NEXT_STEP_VALUE'] ?></div>
                    <div class="step">
                        <?= Loc::getMessage("STEP_VALUE", ['#VALUE#' => $arResult['STEP_VALUE']]) ?>
                        <div class="gray"><?= Loc::getMessage($tradeTypeLangConst) ?></div>
                    </div>
                </div>
            <? } ?>
        <? } elseif ($auctionState == $Auction::AUCTION_STATE_BIDDING_FINISHED) { ?>
            <? // аукцион завершён ?>
            <div class="card-info__item item__auction">
                <div class="zag"><?= Loc::getMessage("INITIAL_PRICE") ?>:</div>
                <div class="price-end"><?= $arResult['PRINT_START_PRICE'] ?> <span
                            class="type"><?= $arResult['DISPLAY_PROPERTIES']['VAT_REQUIRED']['DISPLAY_VALUE'] ?></span>
                </div>
                <div class="step">
                    <? /*<p><b>Сумма задатка:</b>100%</p>*/ ?>
                    <?= Loc::getMessage("STEP_VALUE", ['#VALUE#' => $arResult['STEP_VALUE']]) ?>
                    <div class="gray"><?= Loc::getMessage($tradeTypeLangConst) ?></div>
                </div>
                <div class="zag"><?= Loc::getMessage("SELLING_PRICE") ?>:</div>
                <div class="price-end"><?= $arResult['PRINT_CURRENT_PRICE'] ?></div>
                <? if (!empty($arResult['LAST_RATE'])) { ?>
                    <div class="card-info__item-winner">
                        <svg class="icon icon-card-info-count ">
                            <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/img/svg/symbol/sprite.svg#card-info-count"></use>
                        </svg>
                        <p><b><?= Loc::getMessage("WINNER") ?>:</b><span
                                    class="blue"><?= $arResult['USER_ID'] == $arResult['LAST_RATE']['CREATED_BY'] ? $arResult['USER_INFO']['NAME'] : (Loc::getMessage("PARTICIPANT") . ' #' . $arResult['LAST_RATE']['CREATED_BY']) ?></span>
                        </p>
                    </div>
                <? } ?>
            </div>
        <? } else { ?>
            <? // ожидание подачи заявок и подача заявок ?>
            <div class="card-info__item item__auction">
                <div class="zag"><?= Loc::getMessage("INITIAL_PRICE") ?></div>
                <div class="price-end"><?= $arResult['PRINT_START_PRICE'] ?> <span
                            class="type"><?= $arResult['DISPLAY_PROPERTIES']['VAT_REQUIRED']['DISPLAY_VALUE'] ?></span>
                </div>
                <div class="gray"><?= Loc::getMessage("NEXT_MIN_RATE") ?>
                    - <?= $arResult['PRINT_NEXT_STEP_VALUE'] ?></div>
                <div class="step">
                    <?= Loc::getMessage("STEP_VALUE", ['#VALUE#' => $arResult['STEP_VALUE']]) ?>
                    <div class="gray"><?= Loc::getMessage($tradeTypeLangConst) ?></div>
                </div>
                <?
                if ($auctionState == $Auction::AUCTION_STATE_APPS_IN_PROCESS && $arResult['USER_ID']) {
                    // если пользователь ещё не отправлял заявку на участие - выводим кнопку
                    if (($arResult['USER_SEND_PARTICIPATION'] == 'N') && ($arResult['USER_ID'] != $arResult['CREATED_BY'])) {
                        ?><a id="apply-for-participation"
                             href="<?= $templateFolder ?>/apply-for-participation.php?ID=<?= $arResult['ID'] ?>"
                             class="btn btn-blue ajax-form" data-class="w500"
                             type="button"><?= Loc::getMessage("TO_APPLY") ?></a><?
                    } else {
                        // если пользователь отправлял заявку на участие - выводим статус
                         ?><p><?= Loc::getMessage("USER_PARTICIPATION_STATUS_{$arResult['USER_PARTICIPATION_STATUS']}") ?></p><? 
                    }
                }
                ?>
            </div>
        <? } ?>

        <? if (($auctionState >= $Auction::AUCTION_STATE_BIDDING_IN_PROCESS) && ($arResult['PARTICIPATION_COUNT'] > 1)) { ?>
            <div class="card-info__item __bargaining">
                <div class="zag"><?= Loc::getMessage("BIDDING_PROGRESS") ?>:</div>
                <div id="ratesList" class="bargaining-items">
                    <? foreach ($arResult['RATES_LIST'] as $arRate) { ?>
                        <div class="bargaining-row <?= $arRate['CREATED_BY'] == $arResult['USER_ID'] ? 'blue' : '' ?>">
                            <div class="bargaining-row__item"><?= $arRate['USER_NAME'] ?></div>
                            <div class="bargaining-row__item">
                                <span><?= $arRate['TIME'] ?></span><span><?= $arRate['DATE'] ?></span></div>
                            <div class="bargaining-row__item"><?= $arRate['VALUE'] ?></div>
                        </div>
                    <? } ?>
                </div>
                <div class="bargaining-items" style="padding: 0;">
                    <a id="showAllRates" class="ajax-form" data-class="w600"
                       href="<?= SITE_DIR ?>modals/auction-rates-list.php?ID=<?= $arResult['ID'] ?>"><?= Loc::getMessage("VIEW_ALL_BIDS") ?></a>
                </div>
            </div>
        <? } ?>
    </div>
</div>
<?


$jsParams = array(
    'CONFIG' => array(),
    'VISUAL' => $itemIds,
    'PRODUCT_TYPE' => $arResult['PRODUCT']['TYPE'],
    'PRODUCT' => array(
        'ID' => $arResult['ID'],
        'ACTIVE' => $arResult['ACTIVE'],
        'PICT' => reset($arResult['MORE_PHOTO']),
        'NAME' => $arResult['~NAME'],
    ),
);

$requestsUrl = $templateFolder . '/ajax.php';

$messageUserRateStatus3 = Loc::getMessage("YOUR_BID_OUTBID");
if ($arResult['PARTICIPATION_COUNT'] == 2)
    $messageUserRateStatus3 .= '. ' . '<a href="#" class="js-btn-surrender">' . Loc::getMessage("BTN_SURRENDER") . '</a>';
?>
<script>
    BX.message({
        SITE_ID: '<?=CUtil::JSEscape($component->getSiteId())?>'
    });

    var <?=$obName?> = new JCCatalogElement(<?=CUtil::PhpToJSObject($jsParams, false, true)?>);
</script>
<script type="text/javascript">
    var requestsUrl = "<?= CUtil::JSEscape($requestsUrl) ?>",
        //serverTimeZoneOffsetInHours = -3,
        //currentTimeZoneOffsetInHours = -3,
        //currentTimeZoneOffsetInSeconds = <?= $arResult['TIME_ZONE_OFFSET'] * 1000 ?>,
        checkStatusVoteIntervalWs = <?= $checkStatusVoteIntervalWs ?>,
        finishTimeStamp,
        nowServerTimeStamp,
        ajaxInProgress = false,
        // checkerTime,
        currentPrice = 0,
        $obCurrentPrice,
        nextRate,
        $obNextRate,
        $obRateValue,
        $obTask,
        $obErrorRate,
        lastRateID,
        lastRateUserID,
        currentUserID = <?= $arResult['USER_ID'] ?>,
        lotCreatedBy = <?= $arResult['CREATED_BY'] ?>,
        lotID = <?= $arResult['ID'] ?>,
        firstCheck = 1,
        lastRateIdUser = -1,
        $obUserRateStatus,
        messageUserRateStatus1 = '<span><?= CUtil::JSEscape(Loc::getMessage("YOU_HAVENT_PLACED_BID")) ?></span>',
        messageUserRateStatus2 = '<span style="color: green;"><?= CUtil::JSEscape(Loc::getMessage("YOU_HIGH_BIDDER")) ?></span>',
        messageUserRateStatus3 = '<span class="your-bid-outbid"><?= CUtil::JSEscape($messageUserRateStatus3) ?></span>',
        messageYourLot = '<?= CUtil::JSEscape(Loc::getMessage("YOUR_LOT")) ?>',
        $obRatesList,
        bOnPullEvent = false,
        counterDate,
        start,
        $auctionForm = $('#auctionForm'),
        timerDataFinish = '',
        timerDataFinishTs = 0;

    function calculateDiff_N(f_time, n_time) {
        // console.log(f_time, n_time);
        // console.log(f_time > n_time);

        var diff = f_time - n_time;

        if (diff <= 0) return false;

        var left = diff % 1000;
        if (left === 0) left = 1000;

        //секунды
        diff = Math.floor(diff / 1000);
        var secondsLeft = diff;
        var s = diff % 60;

        if (s < 10) {
            $(".seconds_1").html(0);
            $(".seconds_2").html(s);
        } else {
            $(".seconds_1").html(Math.floor(s / 10));
            $(".seconds_2").html(s % 10);
        }

        //минуты
        diff = Math.floor(diff / 60);
        var m = diff % 60;
        if (m < 10) {
            $(".minutes_1").html(0);
            $(".minutes_2").html(m);
        } else {
            $(".minutes_1").html(Math.floor(m / 10));
            $(".minutes_2").html(m % 10);
        }

        //часы
        diff = Math.floor(diff / 60);
        var h = diff % 24;
        if (h < 10) {
            $(".hours_1").html(0);
            $(".hours_2").html(h);
        } else {
            $(".hours_1").html(Math.floor(h / 10));
            $(".hours_2").html(h % 10);
        }

        //дни
        var d = Math.floor(diff / 24);
        if (d < 10 && d != 0) {
            $(".days_1").html(0);
            $(".days_2").html(d);
        } else if (d == 0) {
            $('.timer_section').each(function () {
                if ($(this).attr('data-type') == 'days') {
                    $(this).hide();
                }
            })
        } else {
            $(".days_1").html(Math.floor(d / 10));
            $(".days_2").html(d % 10);
        }

        // добавляем обновление страницы когда осталась 1 секунда до окончания таймера
        // console.log(secondsLeft);
        if (secondsLeft === 1) {
            setTimeout(function () {
                document.location.reload();
            }, 1000)
        }
    }

    function timerInit(_finishDate, _finishTimeStamp) {
        function calculateDiff() {
            // console.log(f_time, n_time);

            var diff = f_time - n_time;

            if (diff <= 0) return false;

            var left = diff % 1000;
            if (left === 0) left = 1000;

            //секунды
            diff = Math.floor(diff / 1000);
            var secondsLeft = diff;
            var s = diff % 60;

            if (s < 10) {
                $(".seconds_1").html(0);
                $(".seconds_2").html(s);
            } else {
                $(".seconds_1").html(Math.floor(s / 10));
                $(".seconds_2").html(s % 10);
            }

            //минуты
            diff = Math.floor(diff / 60);
            var m = diff % 60;
            if (m < 10) {
                $(".minutes_1").html(0);
                $(".minutes_2").html(m);
            } else {
                $(".minutes_1").html(Math.floor(m / 10));
                $(".minutes_2").html(m % 10);
            }

            //часы
            diff = Math.floor(diff / 60);
            var h = diff % 24;
            if (h < 10) {
                $(".hours_1").html(0);
                $(".hours_2").html(h);
            } else {
                $(".hours_1").html(Math.floor(h / 10));
                $(".hours_2").html(h % 10);
            }

            //дни
            var d = Math.floor(diff / 24);
            if (d < 10 && d != 0) {
                $(".days_1").html(0);
                $(".days_2").html(d);
            } else if (d == 0) {
                $('.timer_section').each(function () {
                    if ($(this).attr('data-type') == 'days') {
                        $(this).hide();
                    }
                })
            } else {
                $(".days_1").html(Math.floor(d / 10));
                $(".days_2").html(d % 10);
            }

            // добавляем обновление страницы когда осталась 1 секунда до окончания таймера
            // console.log(secondsLeft);
            if (secondsLeft === 1) {
                // console.log('document.location.reload();');
                setTimeout(function () {
                    document.location.reload();
                }, 1000)
            }

        }

        function timer_go() {
            var tsDate = new Date(window.serverTimeStamp),
                year = tsDate.getFullYear(),
                month = tsDate.getMonth() + 1,
                day = tsDate.getDate(),
                hour = tsDate.getHours(),
                minutes = tsDate.getMinutes(),
                seconds = tsDate.getSeconds();

            if (month < 10) month = '0' + month;
            if (day < 10) day = '0' + day;
            if (hour < 10) hour = '0' + hour;
            if (minutes < 10) minutes = '0' + minutes;
            if (seconds < 10) seconds = '0' + seconds;

            var dd = year + '-' + month + '-' + day + ' ' + hour + ':' + minutes + ':' + seconds,
                date1 = new Date(dd.replace(/ /g, "T"));

            n_time = Date.parse(date1);

            calculateDiff()

            window.serverTimeStamp += 1000;
        }

        if (_finishDate.length !== 0) {
            if (window.viaWs === 1) {
                if (!bOnPullEvent) {
                    console.log('viaWs');
                    counterDate = _finishDate;
                    finishTimeStamp = _finishTimeStamp;

                    BX.addCustomEvent("onPullEvent-auctions", BX.delegate(function (command, params) {
                        if (command === 'server_time') {
                            nowServerTimeStamp = params.timestamp_full;

                            calculateDiff_N(finishTimeStamp, nowServerTimeStamp);
                        } else if (command === 'new_rate') {
                            // console.log(command);
                            // console.log(params);
                            // кто-то сделал ставку.... обновляем инфу
                            console.log(params);
                            console.log(finishTimeStamp);
                            finishTimeStamp = params.AUCTION_DATE_END_TS;
                            console.log(finishTimeStamp);

                            firstCheck = 1;
                            $('#firstCheck').val(firstCheck)
                            checkStatusVote();
                        } else if (command === 'reload_page') {
                            // команда не перезагрузку страницы
                            window.location.reload();
                        }
                    }, this));
                    bOnPullEvent = true;
                }
            } else {
                start = setInterval(timer_go, 1000);
            }
        }
    }

    function updateAuctionState(response) {
        if (response.result === 'ok') {
            if (firstCheck === 1) {
                lastRateID = response.lastRateID;

                lastRateUserID = response.lastRateUserID;

                lastRateIdUser = response.lastRateIdUser;

                console.log(lastRateID, lastRateIdUser);

                if (lastRateIdUser === 0) {
                    $obUserRateStatus.html(messageUserRateStatus1)
                } else if (lastRateIdUser === lastRateID) {
                    $obUserRateStatus.html(messageUserRateStatus2)
                } else {
                    $obUserRateStatus.html(messageUserRateStatus3)
                }
            }

            if (response.dataFinishTs !== timerDataFinishTs) {
                timerDataFinishTs = response.dataFinishTs;
                timerDataFinish = response.dataFinish;
                clearInterval(start);
                timerInit(timerDataFinish, timerDataFinishTs);
            }

            if (response.currentPrice !== currentPrice) {
                // изменилась цена

                currentPrice = response.currentPrice;

                // обновляем значение
                $obCurrentPrice.text(response.currentPricePrint);

                // обновляем значение по автоставкам

                // обновляем список ставок пользователей
                loadRatesList();
            }

            if (response.lastRateUserID != lastRateUserID && lastRateIdUser > 0) {
                $obUserRateStatus.html(messageUserRateStatus3)
            }

            if (response.nextRateValue != nextRate) {
                nextRate = response.nextRateValue;
                $obNextRate.text(response.nextRateValuePrint);
                $obRateValue.val(nextRate);
            }
        }
    }


    function checkStatusVote() {
        if (ajaxInProgress) return;

        if ($obTask.val() !== 'checkState') $obTask.val('checkState');

        $.ajax({
            url: requestsUrl,
            method: 'post',
            dataType: 'json',
            data: $auctionForm.serialize(),
            beforeSend: function () {
                ajaxInProgress = true;
            },
            success: function (response) {
                updateAuctionState(response);

                if (firstCheck === 1) {
                    firstCheck = 0;
                    $('#firstCheck').val(firstCheck);
                }

                ajaxInProgress = false;
            },
            error: function () {
                console.log('error in "checkStatusVote"');
                setTimeout(function () {
                    ajaxInProgress = false;
                }, 4000)
            },
        });
    }

    function renderRatesHtml(ratesList) {
        if (ratesList.length === 0) return;

        $obRatesList.empty();

        for (var key in ratesList) {
            if (typeof ratesList[key].USER_NAME !== 'undefined')
                ratesList[key].USER_NAME = ratesList[key].USER_NAME.replace('&quot;', '"');

            itemClass = 'bargaining-row';
            if (ratesList[key].CREATED_BY == currentUserID) {
                itemClass += ' blue';
            }

            $('<div>', {
                class: itemClass,
                append: [
                    $('<div>', {
                        class: 'bargaining-row__item',
                        text: ratesList[key].USER_NAME
                    }),
                    $('<div>', {
                        class: 'bargaining-row__item',
                        append: [
                            $('<span>', {
                                text: ratesList[key].TIME
                            }),
                            $('<span>', {
                                text: ratesList[key].DATE
                            }),
                        ],
                    }),
                    $('<div>', {
                        class: 'bargaining-row__item',
                        text: ratesList[key].VALUE
                    }),
                ]
            }).appendTo($obRatesList);
        }
    }

    function loadRatesList() {
        $obTask.val('getRatesList');

        $.ajax({
            type: "POST",
            url: requestsUrl,
            data: $auctionForm.serialize(),
            dataType: 'json',
            success: function (response) {
                if (typeof response.ratesList !== "undefined") {
                    renderRatesHtml(response.ratesList)
                }
            }
        });
    }

    $('document').ready(function () {
        if (currentUserID == lotCreatedBy) {
            $('#your-name').html(messageYourLot);
            $('#your-name').closest('.card-info__item').show();
        }

        if ($(".js-timer").length) {
            timerDataFinish = $(".js-timer").attr("data-finish");
            timerDataFinishTs = parseInt($(".js-timer").attr("data-finish-ts"));
            timerInit(timerDataFinish, timerDataFinishTs);

            if ($('#firstCheck').length) $('#firstCheck').val(1);
            <?
            if($auctionState == $Auction::AUCTION_STATE_BIDDING_IN_PROCESS && !empty($arResult['USER_ID']) && $arResult['USER_PARTICIPATION_STATUS'] == OFFER_STATUS_APPROVED)
            {
            ?>
            currentPrice = <?= $arResult['DISPLAY_PROPERTIES']['CURRENT_PRICE']['DISPLAY_VALUE'] ?>;
            $obCurrentPrice = $('#currentPrice');
            nextRate = <?= $arResult['NEXT_STEP_VALUE'] ?>;
            $obNextRate = $('#nextRate');
            $obRateValue = $('#rateValue');

            $obTask = $('#TASK');
            $obErrorRate = $('#errorRate');
            $obUserRateStatus = $('#userRateStatus');
            $obRatesList = $('#ratesList');
            <? if (($arResult['PARTICIPATION_COUNT'] > 1)) { ?>
            if (window.viaWs === 1) {
                checkStatusVote();
                setInterval(function () {
                    checkStatusVote()
                }, checkStatusVoteIntervalWs);
            } else {
                setInterval(function () {
                    checkStatusVote()
                }, 2000);
            }
            <? } ?>
            <?
            }
            ?>
        }
    });

    <? if($auctionState == $Auction::AUCTION_STATE_BIDDING_IN_PROCESS) { ?>
    $(document).on('click', '#btnSetRate', function (e) {
        e.preventDefault();

        if (ajaxInProgress) return;

        $obTask.val('setRate');

        $.ajax({
            type: "POST",
            url: requestsUrl,
            data: $auctionForm.serialize(),
            dataType: 'json',
            beforeSend: function () {
                ajaxInProgress = true;
            },
            success: function (response) {
                ajaxInProgress = false;

                if (response.result == 'error' && response.message != '') {
                    $obErrorRate.html(response.message).addClass('open');
                    setTimeout(function () {
                        $obErrorRate.removeClass('open');
                    }, 3000);
                } else {
                    $obErrorRate.html('');
                }

                if (typeof response.lastRateIdUser !== "undefined") {
                    lastRateIdUser = response.lastRateIdUser;
                    $obUserRateStatus.html(messageUserRateStatus2);
                }
            },
            error: function () {
                console.log('error in "setRate"');
                setTimeout(function () {
                    ajaxInProgress = false;
                }, 4000)
            },
        });
    });

    $(document).on('click', '.js-btn-surrender', function (e) {
        e.preventDefault();

        if (ajaxInProgress) return;

        $obTask.val('surrender');

        $.ajax({
            type: "POST",
            url: requestsUrl,
            data: $auctionForm.serialize(),
            dataType: 'json',
            beforeSend: function () {
                ajaxInProgress = true;
            },
            success: function (response) {
            },
            error: function () {
                console.log('error in "surrender"');
                setTimeout(function () {
                    ajaxInProgress = false;
                }, 4000)
            },
        });
    });

    $(document).on('click', '.js-buy-auction', function (e) {
        e.preventDefault();

        if (ajaxInProgress) return;

        $obTask.val('buyAuction');
        $auctionForm.find('#BUY_AGREE').val($(this).data('agree'));

        $.ajax({
            type: "POST",
            url: requestsUrl,
            data: $auctionForm.serialize(),
            dataType: 'json',
            beforeSend: function () {
                ajaxInProgress = true;
            },
            success: function (response) {
                ajaxInProgress = false;
                if (response.result == 'ok') {
                    if (response.reloadPage == 1) {
                        window.location.reload();
                    }
                } else if (response.message != '') {
                    alert(response.message);
                }

                // if(response.result == 'error' && response.message != '')
                // {
                //     $obErrorRate.html(response.message).addClass('open');
                //     setTimeout(function (){ $obErrorRate.removeClass('open'); }, 3000);
                // }
                // else
                // {
                //     $obErrorRate.html('');
                // }
                //
                // if (typeof response.lastRateIdUser !== "undefined")
                // {
                //     lastRateIdUser = response.lastRateIdUser;
                //     $obUserRateStatus.html(messageUserRateStatus2);
                // }
            },
            error: function () {
                console.log('error in "buyAuction"');
                setTimeout(function () {
                    ajaxInProgress = false;
                }, 4000)
            },
        });
    });
    <? } ?>
</script>