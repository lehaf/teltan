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
        <?php $APPLICATION->IncludeComponent(
            "bitrix:menu",
            "personal",
            array(
                "ALLOW_MULTI_SELECT" => "N",
                "CHILD_MENU_TYPE" => "",
                "DELAY" => "N",
                "MAX_LEVEL" => "1",
                "MENU_CACHE_GET_VARS" => array(""),
                "MENU_CACHE_TIME" => "360000",
                "MENU_CACHE_TYPE" => "A",
                "MENU_CACHE_USE_GROUPS" => "N",
                "ROOT_MENU_TYPE" => "personal",
                "USE_EXT" => "N"
            )
        ); ?>
    </div>
</div>
<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>