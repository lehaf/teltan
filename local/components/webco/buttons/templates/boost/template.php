<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

/** @var array $arResult */
/** @var array $arParams */
/** @global object $APPLICATION */
/** @global object $USER */

use Bitrix\Main\Localization\Loc;

$this->addExternalJs(SITE_TEMPLATE_PATH.'/assets/components/buttons/boost.js');
$this->addExternalJs(SITE_TEMPLATE_PATH.'/assets/components/buttons/edit.js');
$this->addExternalCss(SITE_TEMPLATE_PATH.'/assets/components/buttons/boost.css');
?>
<div class="userItemSettings">
    <button class="btn btn-accelerate-sale text-uppercase font-weight-bold"
            role="button"
            id="dropdownServices<?=$arResult['ITEM_ID']?>"
            data-toggle="dropdown" 
            aria-haspopup="true"
            aria-expanded="false"
    >
        <span>
           <img class="basket" src="<?=SITE_TEMPLATE_PATH?>/assets/svg/basket.svg">
        </span>
        <?=Loc::getMessage('UP_SPEED_SALE');?>
    </button>
    <?php if (!empty($arResult['BOOST'])):?>
        <div class="accardion-wrap" id="servicesList<?=$arResult['ITEM_ID']?>">
            <!-- ID "serviceForItem<?=$arResult['ITEM_ID']?>" shold be UNIC for every product card -->
            <div class="accordion user-promote-menu" id="serviceForItem<?=$arResult['ITEM_ID']?>">
                <?php foreach ($arResult['BOOST'] as $type => $boostData):?>
                    <div class="promote-card">
                        <!-- ID "headingRiseItem" shold be UNIC for every product card -->
                        <div class="card-header" id="headingItem<?=$type?>">
                            <button class="btn btn-link btn-block text-right collapsed"
                                    type="button" data-toggle="collapse"
                                    data-target="#item<?=$type?><?=$arResult['ITEM_ID']?>"
                                    aria-expanded="false"
                                    aria-controls="item<?=$type?>"
                            >
                                <div class="pr-4 d-flex justify-content-between align-items-center">
                                    <span class="plus"></span>
                                    <span class="card-header__title"><?=Loc::getMessage('SERVICE_'.$type);?></span>
                                </div>
                            </button>
                            <span class="card-header__icon <?=!empty($boostData['ICON']['NAME']) && !empty($boostData['ICON']['CLASS']) ? $boostData['ICON']['CLASS'] : ''?>">
                                <?php if (!empty($boostData['ICON']['SRC'])):?>
                                    <img class="<?=$boostData['ICON']['CLASS']?>" src="<?=$boostData['ICON']['SRC']?>">
                                <?php else:?>
                                    <?=$boostData['ICON']['NAME']?>
                                <?php endif;?>
                            </span>
                        </div>
                        <!-- data-parent depend on "serviceForItem<?=$arResult['ITEM_ID']?>" -->
                        <!-- aria-labelledby depend on "headingRiseItem" -->
                        <div id="item<?=$type?><?=$arResult['ITEM_ID']?>"
                             class="collapse"
                             aria-labelledby="headingItem<?=$type?>"
                             data-parent="#serviceForItem<?=$arResult['ITEM_ID']?>"
                        >
                            <div class="p-3 bg-lightgray">
                                <?php $APPLICATION->IncludeComponent(
                                    "bitrix:main.include",
                                    "",
                                    array(
                                        "AREA_FILE_SHOW" => "file",
                                        "AREA_FILE_SUFFIX" => "inc",
                                        "EDIT_TEMPLATE" => "",
                                        "PATH" => $boostData['INCLUDE_PATH']
                                    )
                                ); ?>
                                <p class="mb-3 font-weight-bold content-subtitle">Выберите тип поднятия:</p>
                                <form id="formProdact<?=$type.$arResult['ITEM_ID']?>">
                                    <?php if ($type !== 'SET'):?>
                                        <div class="mb-4 px-3 card">
                                            <?php foreach ($boostData['INFO'] as $key => $info):?>
                                                <?php if ($info['UF_COUNT'] > 0):?>
                                                    <div class="py-3 border-bottom d-flex justify-content-between">
                                                        <span class="font-weight-bold"><?=$info["UF_PRICE"]?> T</span>
                                                        <label class="custom-radio-btn">
                                                            <input type="radio"
                                                                   value="<?=$info["UF_COUNT"]?>"
                                                                   data-price="<?=$info["UF_PRICE"]?>"
                                                                   data-price-shek="<?=$info["UF_PRICE_SHEK"]?>"
                                                                   <?=!empty($info["UF_XML_ID"]) ? 'data-xml-id="'.$info["UF_XML_ID"].'"' : ''?>
                                                                   name="<?=$type?>Product"
                                                                   <?=$key === 0 ? "checked" : ''?>
                                                            >
                                                            <span><?=$info["UF_NAME"]?></span>
                                                            <span class="checkbox"></span>
                                                        </label>
                                                    </div>
                                                <?php endif;?>
                                            <?php endforeach;?>
                                        </div>
                                    <?php else:?>
                                        <div class="mb-4 px-3 card" id="accordionSection<?=$arResult['ITEM_ID']?>">
                                            <?php foreach ($boostData['INFO'] as $key => $info):?>
                                                <div class="py-3 border-bottom d-flex justify-content-between" id="tipe1">
                                                    <span class="font-weight-bold"><?=$info['UF_PRICE'].' T'?></span>
                                                    <label class="custom-radio-btn">
                                                        <!-- Change for every button "data-target", "aria-controls" data value "#ID under section"-->
                                                        <input type="radio"
                                                               value="<?=$info["ID"]?>"
                                                               data-price="<?=$info["UF_PRICE"]?>"
                                                               data-rise_count="<?=$info["UF_RISE_COUNT"]?>"
                                                               data-ribbon_date="<?=$info["UF_LENTA"]?>"
                                                               data-vip_date="<?=$info["UF_VIP"]?>"
                                                               data-color_date="<?=$info["UF_COLOUR"]?>"
                                                               data-ribbon_type="<?=$info["UF_XML_ID_LENT"]?>"
                                                               data-price-shek="<?=$info["UF_PRICE_SHEK"]?>"
                                                               name="<?=$type?>Product"
                                                               data-toggle="collapse"
                                                               data-target="#collapsePaket<?=$info['ID']?>"
                                                               aria-expanded="true"
                                                               aria-controls="collapseOne"
                                                               <?=$key === 0 ? "checked" : ''?>
                                                        >
                                                        <span><?=$info['UF_NAME']?></span>
                                                        <span class="checkbox"></span>
                                                    </label>
                                                </div>
                                                <div id="collapsePaket<?=$info['ID']?>" class="collapse <?=$key === 0 ? "show" : ''?>" aria-labelledby="tipe1" data-parent="#accordionSection<?=$arResult['ITEM_ID']?>">
                                                    <div class="p-3 d-flex flex-column new-collapse">
                                                        <p class="mb-4 text-uppercase font-weight-bold"><?=$info["UF_BIG_TEXT"]?></p>
                                                        <p class="text-right"><?=$info["UF_STANDART_TEXT"]?></p>
                                                        <?php if (!empty($info['UF_RISE_COUNT']) && !empty($info['UF_RISE_DESCRIPTION'])):?>
                                                            <div class="d-flex position-relative justify-content-end pr-5">
                                                                <p class="text-right">
                                                                    <span class="font-weight-bold"><?=$info['UF_RISE_COUNT']?></span> <?=$info['UF_RISE_DESCRIPTION']?>
                                                                </p>
                                                                <div class="circle-icon">
                                                                    <div class="d-flex justify-content-center align-items-center user-product__up-product">
                                                                        <span class="text-uppercase font-weight-bold upRise">UP</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php endif;?>
                                                        <?php if (!empty($info['RIBBON_NAME']) && !empty($info['UF_LENTA_DESCRIPTION'])):?>
                                                            <div class="d-flex position-relative justify-content-end pr-5">
                                                                <p class="text-right">
                                                                    <?=$info['UF_LENTA_DESCRIPTION']?> <span class="font-weight-bold">"<?=$info['RIBBON_NAME']?>"</span>
                                                                </p>
                                                                <div class="circle-icon">
                                                                    <img class="ribbon-small" src="/local/templates/teltan/assets/svg/ribbon.svg">
                                                                </div>
                                                            </div>
                                                        <?php endif;?>
                                                        <?php if (!empty($info['UF_VIP']) && !empty($info['UF_VIP_DESCRIPTION'])):?>
                                                            <div class="d-flex position-relative justify-content-end pr-5">
                                                                <p class="text-right">
                                                                    <span class="font-weight-bold"><?=$info['UF_VIP']?></span>  <?=$info['UF_VIP_DESCRIPTION']?>
                                                                </p>
                                                                <div class="circle-icon">
                                                                    <img class="crown-small" src="/local/templates/teltan/assets/svg/crown.svg">
                                                                </div>
                                                            </div>
                                                        <?php endif;?>
                                                        <?php if (!empty($info['UF_COLOR']) && !empty($info['UF_COLOR_DESCRIPTION'])):?>
                                                            <div class="d-flex position-relative justify-content-end pr-5">
                                                                <p class="text-right">
                                                                    <span class="font-weight-bold"><?=$info['UF_COLOR']?></span>  <?=$info['UF_COLOR_DESCRIPTION']?>
                                                                </p>
                                                                <div class="circle-icon">
                                                                    <img class="color-small" src="/local/templates/teltan/assets/svg/color.svg">
                                                                </div>
                                                            </div>
                                                        <?php endif;?>
                                                    </div>
                                                </div>
                                            <?php endforeach;?>
                                        </div>
                                    <?php endif;?>
                                    <p class="mb-3 font-weight-bold content-subtitle"><?=Loc::getMessage('PAY_CHOISE');?>:</p>
                                    <div class="d-flex flex-column justify-content-end align-items-end">
                                        <button type="button"
                                                onclick="buyServiceBoost(<?=$arResult['ITEM_ID']?>, $('#formProdact<?=$type.$arResult['ITEM_ID']?>'), <?=$arResult['IBLOCK_ID']?>, '<?=$type?>', 'tcoins')"
                                                data-toggle="modal"
                                                data-target="#payTcoins"
                                                class="mb-3 btn btn-primary btn-paid"
                                        >
                                            <span class="mr-2">
                                                <img class="tcoins" src="<?=SITE_TEMPLATE_PATH?>/assets/svg/tcoins.svg">
                                            </span>
                                            <?=Loc::getMessage('PAY_T_COINS');?>
                                        </button>
                                        <button type="button"
                                                onclick="buyServiceBoost(<?=$arResult['ITEM_ID']?>, $('#formProdact<?=$type.$arResult['ITEM_ID']?>'), <?=$arResult['IBLOCK_ID']?>, '<?=$type?>', 'sheck')"
                                                class="btn btn-primary btn-paid"
                                        >
                                            <span class="mr-2">
                                                <img class="credit-card" src="<?=SITE_TEMPLATE_PATH?>/assets/svg/creditcard.svg">
                                            </span>
                                            <?=Loc::getMessage('PAY_CARD');?>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach;?>
            </div>
        </div>
    <?php endif;?>
</div>