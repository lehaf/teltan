<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

/** @global object $APPLICATION */
/** @global object $USER */

use Bitrix\Main\Localization\Loc;

$APPLICATION->SetTitle("Персональный раздел");

if (!$USER->IsAuthorized()) LocalRedirect("/");

$request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();

if ((!empty($request->get('active')) && $request->get('active') === 'N') || !empty($_GET['ads_inactive'])) {
    $curTab = "inactive" ;
} else {
    $curTab = 'active';
}

$activeCount = getCurUserAdsCount();
$unActiveCount = getCurUserAdsCount('N');
?>
<div class="container">
    <div class="preloader">
        <div class="preloader__row">
            <div class="preloader__item"></div>
            <div class="preloader__item"></div>
        </div>
    </div>
    <h2 class="mb-4 subtitle"><?= Loc::getMessage('TITl'); ?></h2>
    <div class="row">
        <div class="col-12 col-xl-9">
            <!-- counter -->
            <div class="mb-4">
                <div id="tabs">
                    <div class="mb-4 d-flex justify-content-center justify-content-lg-end status-announcement">
                        <div class="form_radio_btn <?=$curTab === 'inactive' ? 'active' : ''?>" data-active="N">
                            <label class="btn-left" for="falseAnnouncement"><?=Loc::getMessage('UNACTIVE_COUNT')?>
                                <span class="ml-2 falseAnnouncementCounter"><?=$unActiveCount?></span>
                            </label>
                        </div>
                        <div class="form_radio_btn <?=$curTab === 'active'? 'active' : ''?>" data-active="Y">
                            <label class="btn-right" for="trueAnnouncement"><?=Loc::getMessage('ACTIVE_COUNT')?>
                                <span class="ml-2 trueAnnouncementCounter"><?=$activeCount?></span>
                            </label>
                        </div>
                    </div>
                </div>
                <?php
                    $APPLICATION->IncludeComponent(
                        "webco:user.ads.counter",
                        "",
                        array(
                        )
                    );
                ?>
            </div>
            <!-- counter -->
            <?php if (empty($activeCount) && empty($unActiveCount)):?>
                <div class="mb-4 card d-flex flex-column flex-lg-row w-100 justify-content-around no-message">
                    <div class="mb-3 mb-0 d-flex flex-column align-items-center justify-content-center">
                        <p class="mb-4"><?=Loc::getMessage('NO_ADS')?></p>
                        <img src="<?=SITE_TEMPLATE_PATH?>/assets/no-message.svg"
                             alt="no-ads"
                             title="no-ads"
                        >
                    </div>
                    <div class="d-flex align-items-center justify-content-center">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#modalTypeAdd"><?= Loc::getMessage('To_add_an_advert'); ?></button>
                    </div>
                </div>
            <?php endif;?>
            <?php if ($request->get('isAjax') === 'y') $APPLICATION->RestartBuffer();?>
            <div id="user_ads" class="<?=$curTab?>">
                <?php $APPLICATION->IncludeComponent(
                    "webco:user.ads.list",
                    "",
                    array(
                        'MAX_PAGE_ELEMENTS' => 12,
                        'ACTIVE' =>  $curTab === 'inactive' ? 'N' : 'Y',
                        'CACHE_TIME' => 360000000,
                    )
                );?>
            </div>
            <?php if ($request->get('isAjax') === 'y') die();?>
        </div>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/personal/left.php' ?>
    </div>
</div>
<!-- Sale modal -->
<div class="modal fade" id="payTcoins" tabindex="-1" aria-labelledby="payTcoins" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content pt-3 pb-5 px-5">
            <div class="p-0 mb-4 border-bottom-0 modal-header justify-content-end">
                <h2 class="subtitle" id="exampleModalLabel">Оплата</h2>
            </div>

            <div class="p-0 modal-body text-right">
                <p class="mb-4 text-uppercase font-weight-bold">MY BALANCE: <span id="payTcoinsBalance"
                                                                                  class="text-primary"> </span>
                    TCOIN</p>
                <p class="mb-0 text-uppercase font-weight-bold">К списанию: <span id="payTcoinsNeedle"
                                                                                  class="text-primary">2.5 </span>
                    TCOIN</p>

                <hr>

                <p id="payTcoinsAtEnd" class="mb-3 text-uppercase font-weight-bold text-secondary">Остаток: <span>20 TCOIN</span>
                </p>
            </div>

            <div class="p-0 border-top-0 modal-footer">
                <button type="button" class="btn" data-dismiss="modal">Close</button>
                <button id="buyItemFew" type="submit" class="btn btn-primary">Оплатить</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="payShek" tabindex="-1" aria-labelledby="payShek" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content pt-3 pb-5 px-5">
            <div class="p-0 mb-4 border-bottom-0 modal-header justify-content-end">
                <h2 class="subtitle" id="exampleModalLabel">Оплата</h2>
            </div>

            <div class="p-0 modal-body text-right">
                <p class="mb-4 text-uppercase font-weight-bold">MY BALANCE: <span id="paySkekBalance"
                                                                                  class="text-primary"> </span> <?= ICON_CURRENCY ?>
                </p>
                <p class="mb-0 text-uppercase font-weight-bold">К списанию: <span id="payShekNeedle"
                                                                                  class="text-primary">2.5 </span> <?= ICON_CURRENCY ?>
                </p>

                <hr>

                <p id="payShekAtEnd" class="mb-3 text-uppercase font-weight-bold text-secondary">Остаток:
                    <span>20 <?= ICON_CURRENCY ?></span></p>
            </div>

            <div class="p-0 border-top-0 modal-footer">
                <button type="button" class="btn" data-dismiss="modal">Close</button>
                <button id="buyItemFewShek" type="submit" class="btn btn-primary">Оплатить</button>
            </div>
        </div>
    </div>
</div>
<!-- alert modal -->
<div class="allert alert-confirmation flex-column card">
    <button onclick="window.location.reload()" type="button" class="close" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <div class="d-flex justify-content-center allert__text"></div>
    <div class="d-flex justify-content-center mt-4">
        <button onclick="window.location.reload()"
                class="btn_confirm btn border-primary text-uppercase font-weight-bold text-primary py-3 px-5">
            <?=Loc::getMessage('OK_BTN')?>
        </button>
    </div>
</div>
<?php require ($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>