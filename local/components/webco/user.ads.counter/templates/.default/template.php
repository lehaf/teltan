<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

/** @var array $arResult */

use Bitrix\Main\Localization\Loc;

?>
<div class="mb-1 p-3 card d-flex flex-column-reverse flex-lg-row announcement-list">
    <a class="p-3 d-flex justify-content-center align-items-center"
       data-toggle="collapse" href="#userAnnouncementList" role="button" aria-expanded="false"
       aria-controls="collapseExample">
        <i class="icon-arrow-down-sign-to-navigate-3"></i>
    </a>
    <div class="w-100 d-flex flex-column flex-xl-row align-items-xl-center justify-content-between">
        <div class="pl-lg-3 d-flex flex-column text-right">
            <p class="header-title font-weight-bold"><?= Loc::getMessage('AVAILABLE_ADS')?>:</p>
            <p>
                <?php if (!empty($arResult['COUNTER'])):?>
                    <?php $lastKey = array_key_last($arResult['COUNTER'])?>
                    <?php foreach ($arResult['COUNTER'] as $categoryName => $countAds):?>
                        <?=$categoryName?>
                        <span class="counters"><?=!empty($countAds['USED']) ? $countAds['USED'] : 0?></span>
                        <?=Loc::getMessage('OF_COUNT')?>
                        <span class="counters"><?=!empty($countAds['POSSIBLE']) ? $countAds['POSSIBLE'] : 0?></span>
                        <?=$lastKey !== $categoryName ? '/' : ''?>
                    <?php endforeach;?>
                <?php endif;?>
            </p>
        </div>
        <div class="d-flex flex-column text-right">
            <p class="mb-0"><?= Loc::getMessage('BUY_NEW_TARIF'); ?></p>
        </div>
        <div class="d-flex justify-content-center align-items-center">
            <button onclick="window.location.href = '/personal/rate/'"
                    class="btn btn-primary text-uppercase align-self-end"
            >
                <?= Loc::getMessage('BUY'); ?>
            </button>
        </div>
    </div>
</div>
<?php if (!empty($arResult['USER_ADS'])):?>
    <div class="collapse" id="userAnnouncementList">
        <?php foreach ($arResult['USER_ADS'] as $adsType => $adsData):?>
            <div class="mb-2">
                <table class="w-100">
                    <tbody>
                        <th class="text-right pr-3"><?=$adsType?></th>
                        <tr class="d-flex">
                            <td class="d-flex flex-column flex-lg-row justify-content-end">
                                <div class="m-0 mr-lg-4 d-flex align-items-center justify-content-end justify-content-lg-center category">
                                    <img src="<?= SITE_TEMPLATE_PATH ?>/assets/announsment-list-free.svg"
                                         title="free"
                                         alt="free"
                                    >
                                </div>
                                <div class="d-flex justify-content-end align-items-center justify-content-lg-center font-weight-bold">
                                    <span class="mr-1"><?=!empty($adsData['FREE_ADS_COUNT']) ? $adsData['FREE_ADS_COUNT'] : 0 ?></span>
                                    <span class="mr-1"><?=Loc::getMessage('OF_COUNT')?></span>
                                    <span class="mr-1"><?=!empty($arResult['COUNTER'][$adsType]['FREE_LIMIT']) ? $arResult['COUNTER'][$adsType]['FREE_LIMIT'] : 0 ?></span>
                                </div>
                            </td>
                            <td class="d-flex justify-content-center align-items-center date-announcment">
                                <span><?=!empty($adsData['FREE_DATE_EXPIRED']) ? $adsData['FREE_DATE_EXPIRED'] : '-'?></span>
                            </td>
                        </tr>
                        <?php if (!empty($adsData['COST_ADS'])):?>
                            <?php foreach ($adsData['COST_ADS'] as $rateData):?>
                                <tr class="d-flex">
                                    <td class="d-flex flex-column flex-lg-row justify-content-center">
                                        <div class="ml-auto d-flex justify-content-end align-items-center justify-content-lg-center font-weight-bold">
                                            <span class="mr-1"><?=!empty($rateData['COUNT']) ? $rateData['COUNT'] : 0 ?></span>
                                            <span class="mr-1"><?=Loc::getMessage('OF_COUNT')?></span>
                                            <span class="mr-1"><?=!empty($rateData['LIMIT']) ? $rateData['LIMIT'] : 0 ?></span>
                                        </div>
                                    </td>
                                    <td class="d-flex justify-content-center align-items-center date-announcment">
                                        <span><?=$rateData['DATE_EXPIRED']?></span>
                                    </td>
                                </tr>
                            <?php endforeach;?>
                        <?php endif;?>
                    </tbody>
                </table>
            </div>
        <?php endforeach;?>
    </div>
<?php endif;?>