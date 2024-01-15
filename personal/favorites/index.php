<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

/** @global object $APPLICATION */

use Bitrix\Main\Localization\Loc;

$APPLICATION->SetTitle("Избранные объявления");
?>
<div class="container">
    <h2 class="mb-4 subtitle">
        <?=$APPLICATION->ShowTitle();?>
    </h2>
    <div class="row">
        <div class="col-12 col-lg-8 col-xl-9 full-box">
            <div class="row row-cols-2 row-cols-md-1">
                <?php $APPLICATION->IncludeComponent(
                    "webco:user.favorite.list",
                    "",
                    array(
                        'MAX_PAGE_ELEMENTS' => 12,
                        'CACHE_TIME' => 36000000
                    )
                );?>
            </div>
        </div>
        <?php include $_SERVER['DOCUMENT_ROOT'].'/personal/left.php'?>
    </div>
</div>
<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>