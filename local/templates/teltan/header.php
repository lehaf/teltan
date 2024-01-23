<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Page\Asset;
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

global $USER, $APPLICATION;
if($USER->IsAuthorized())
    $IDUser = $USER->GetID();
else
    $IDUser = false;

?>
<!DOCTYPE html>
<html>
<head>
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
    <?php
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/js/jquery.min.js");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/js/bootstrap.bundle.min.js");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/js/vendors.js");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/js/scripts.js");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/js/dev.js");
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH.'/css/vendors.css');
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH.'/css/styles.css');
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH.'/css/dev.css');
    ?>
    <?php $APPLICATION->ShowHead()?>
    <title><?php $APPLICATION->ShowTitle()?></title>
</head>
<body>
<div id="panel"><?php $APPLICATION->ShowPanel();?></div>


<header class="header">
    <?php // Избранное
    if($USER->IsAuthorized()){
        $favorites = getFavoritesUser($IDUser);

        ?>
        <script>let favorites = <?=json_encode($favorites);?>;</script>
        <?php
    } ?>

    <?php $APPLICATION->IncludeComponent(
        "bitrix:catalog.section.list",
        "mobile",
        Array(
            "ADD_SECTIONS_CHAIN" => "N",
            "CACHE_FILTER" => "N",
            "CACHE_GROUPS" => "N",
            "CACHE_TIME" => "36000000",
            "CACHE_TYPE" => "A",
            "COUNT_ELEMENTS" => "Y",
            "COUNT_ELEMENTS_FILTER" => "CNT_ACTIVE",
            "FILTER_NAME" => "sectionsFilter",
            "IBLOCK_ID" => "1",
            "IBLOCK_TYPE" => "announcements",
            "SECTION_CODE" => "",
            "SECTION_FIELDS" => array("", ""),
            "SECTION_ID" => $_REQUEST["SECTION_ID"],
            "SECTION_URL" => "",
            "SECTION_USER_FIELDS" => array("UF_NAME_EN", "UF_NAME_HEB",'UF_SVG_ICON_URL', "UF_ICON"),

            "SHOW_PARENT_NAME" => "Y",
            "TOP_DEPTH" => "2",
            "VIEW_MODE" => "LINE"
        )
    );?>
    <div class="container">
        <div class="header__nav mb-3">
            <div class="row">
                <div class="col col-lg-5 col-xl-6">
                    <div class="d-flex h-100 justify-content-between align-items-center">
                        <?php
                        // Переключатель языков
//                        $APPLICATION->IncludeComponent(
//                            "bitrix:main.include",
//                            "",
//                            Array(
//                                "AREA_FILE_SHOW" => "file",
//                                "AREA_FILE_SUFFIX" => "inc",
//                                "EDIT_TEMPLATE" => "",
//                                "PATH" => SITE_TEMPLATE_PATH."/includes/header/languages_list.php"
//                            )
//                        );
                        ?>
                    </div>
                </div>
                <div class="col-7 col-xl-6">
                    <div class="d-flex justify-content-end justify-content-lg-between align-items-center">
                        <a href="#" class="mr-auto mr-md-5 mr-lg-0 text-uppercase btn-your-add"
                           data-toggle="modal"
                           data-target="#<?=($IDUser) ? 'modalTypeAdd' : 'logInModal';?>"
                        >
                            <i class="icon-user-1 mr-2"></i>
                            <span><?=Loc::getMessage('YOU_AD');?></span>
                        </a>
                        <?php $APPLICATION->IncludeComponent(
                            "bitrix:catalog.section.list",
                            "flea_menu",
                            Array(
                                "ADD_SECTIONS_CHAIN" => "N",
                                "CACHE_FILTER" => "N",
                                "CACHE_GROUPS" => "N",
                                "CACHE_TIME" => "36000000",
                                "CACHE_TYPE" => "A",
                                "COUNT_ELEMENTS" => "Y",
                                "COUNT_ELEMENTS_FILTER" => "CNT_ACTIVE",
                                "FILTER_NAME" => "sectionsFilter",
                                "IBLOCK_ID" => "1",
                                "IBLOCK_TYPE" => "announcements",
                                "SECTION_CODE" => "",

                                "SECTION_USER_FIELDS" => array("UF_NAME_EN", "UF_SVG_ICON_URL","UF_NAME_HEB", "UF_FON", 'UF_ICON'),
                                "SECTION_ID" => $_REQUEST["SECTION_ID"],
                                "SECTION_URL" => "",

                                "SHOW_PARENT_NAME" => "Y",
                                "TOP_DEPTH" => "2",
                                "VIEW_MODE" => "LINE"
                            )
                        );?>
                        <div class="d-none d-lg-flex align-items-center fleamarket-link">
                            <a class="font-weight-bold d-flex align-items-center" href="/property/zhilaya/snyat-j/">
                                <span class="mt-1 mr-2 ml-2"><?=Loc::getMessage('PROPERTY');?></span>
                                <i class="icon-home"></i>
                            </a>
                        </div>
                        <div class="d-none d-lg-flex align-items-center">
                            <a class="font-weight-bold d-flex align-items-center" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="/auto/">
                                <span class="mt-1 mr-2 ml-2"><?=Loc::getMessage('AUTO');?></span>
                                <i class="icon-steering"></i>
                            </a>
                            <div class="dropdown-menu">
                                <a href="/auto/" class="border-bottom dropdown-item <?php echo (CSite::InDir('/auto/')) ? "active" : " "; ?>">
                                    <?=Loc::getMessage('AUTO');?>
                                </a>
                                <a href="/moto/" class="border-bottom dropdown-item <?php echo (CSite::InDir('/moto/')) ? "active" : " "; ?>">
                                    <?=Loc::getMessage('moto')?>
                                </a>
                                <a href="/scooters/" class="dropdown-item <?php echo (CSite::InDir('/scooters/')) ? "active" : " "; ?>">
                                    <?=Loc::getMessage('scooters')?>
                                </a>
                            </div>
                        </div>
                        <div class="d-flex d-lg-none hamburger">
                            <span class="line"></span>
                            <span class="line"></span>
                            <span class="line"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header__search">
            <div class="row">
                <div class="col-6 col-xl-4 order-1">
                    <div class="header__user-menu-bar d-flex align-items-center h-100">
                        <?php if($IDUser) {
                            include_once $_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH."/includes/header/auth_block.php";
                        } else {
                            include_once $_SERVER['DOCUMENT_ROOT']. SITE_TEMPLATE_PATH."/includes/header/not_auth_block.php";
                        } ?>
                    </div>
                </div>
                <?php $APPLICATION->IncludeComponent(
                    "bitrix:search.title",
                    "search",
                    array(
                        "CATEGORY_0" => array(
                            0 => "iblock_announcements",
                        ),
                        "CATEGORY_0_TITLE" => "",
                        "CATEGORY_0_iblock_announcements" => array(
                            0 => "1",
                        ),
                        "CHECK_DATES" => "N",
                        "CONTAINER_ID" => "title-search",
                        "INPUT_ID" => "title-search-input",
                        "NUM_CATEGORIES" => "1",
                        "ORDER" => "rank",
                        "PAGE" => "#SITE_DIR#search/index.php",
                        "SHOW_INPUT" => "Y",
                        "SHOW_OTHERS" => "N",
                        "TOP_COUNT" => "5",
                        "USE_LANGUAGE_GUESS" => "N",
                        "COMPONENT_TEMPLATE" => "search"
                    ),
                    false
                );?>
                <div class="col-6 col-xl-2 order-2 order-xl-3">
                    <a <?=CSite::InDir('/index.php') ? '' : 'href="/"';?> class="ml-auto d-flex justify-content-end logo">
                        <div class="mr-2 mr-lg-2 logo__image">
                            <img src="<?=SITE_TEMPLATE_PATH?>/assets/img/logo.png"
                                 alt="logo-teltan"
                                 title="logo-teltan"
                            >
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
<div class="modal fade modal-user-add-category" id="modalTypeAdd" tabindex="-1" aria-hidden="true">
    <div class="modal-lg modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="p-0 d-flex flex-column align-items-end border-0 modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <p class="mb-3 modal-title subtitle" id="staticBackdropLabel">סוג מודעה</p>
            </div>
            <div class="p-4 p-lg-3 modal-body">
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3">
                    <div class="col">
                        <p class="h6 font-weight-bold">
                            <?=Loc::getMessage('other')?>
                        </p>
                        <div class="d-flex flex-column">
                            <a href="/add/flea/" class="btn btn-primary text-uppercase font-weight-bold mb-4">
                                <?=Loc::getMessage('yourAds')?>
                            </a>
                        </div>
                    </div>
                    <div class="col">
                        <p class="h6 font-weight-bold">
                            <?=Loc::getMessage('realEstate')?>
                        </p>
                        <div class="d-flex flex-column">
                            <a href="/add/rent/" class="btn btn-primary text-uppercase font-weight-bold mb-4">
                                <?=Loc::getMessage('rent')?>
                            </a>
                            <a href="/add/buy/" class="btn btn-primary text-uppercase font-weight-bold mb-4">
                                <?=Loc::getMessage('buy')?>
                            </a>
                        </div>
                    </div>
                    <div class="col">
                        <p class="h6 font-weight-bold">
                            <?=Loc::getMessage('transport')?>
                        </p>
                        <div class="d-flex flex-column">
                            <a href="/add/auto/" class="btn btn-primary text-uppercase font-weight-bold mb-4">
                                <?=Loc::getMessage('auto')?>
                            </a>
                            <a href="/add/moto/" class="btn btn-primary text-uppercase font-weight-bold mb-4">
                                <?=Loc::getMessage('moto')?>
                            </a>
                            <a href="/add/scooter/" class="btn btn-primary text-uppercase font-weight-bold mb-4">
                                <?=Loc::getMessage('scooters')?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if(!CSite::InDir('/property/')) {?>
    <main class="mb-5">
        <?php if (!CSite::InDir('/index.php')) {
             $APPLICATION->IncludeComponent(
                 "bitrix:breadcrumb",
                 "template_breadcrumbs",
                 array(
                     "PATH" => "",
                     "SITE_ID" => SITE_ID,
                     "START_FROM" => "0"
                 )
             );
        }
}
?>
