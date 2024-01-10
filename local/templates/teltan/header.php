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
                        <?php $APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            "",
                            Array(
                                "AREA_FILE_SHOW" => "file",
                                "AREA_FILE_SUFFIX" => "inc",
                                "EDIT_TEMPLATE" => "",
                                "PATH" => SITE_TEMPLATE_PATH."/includes/".SITE_ID."/header/languages_list.php"
                            )
                        );?>

                        <div class="d-none d-lg-flex align-items-center" style="visibility: hidden">

                            <a class="d-flex align-items-center mr-2 pr-2 mr-lg-3 pr-lg-3 mr-xl-5 pr-xl-5 border-right" href="#">
                                <span class="mr-2"><?=Loc::getMessage('CATALOG');?></span> <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M22.3556 12.0919H18.3488V7.20703C18.3488 6.30234 17.6128 5.56641 16.7081 5.56641H13.2754V2.10914C13.2754 0.946172 12.3292 0 11.1662 0H7.18256C6.01959 0 5.07342 0.946172 5.07342 2.10914V5.56641H1.64063C0.735938 5.56641 0 6.30234 0 7.20703V22.3594C0 23.2641 0.735938 24 1.64063 24C13.1446 24 21.8296 23.9963 22.3556 23.9963C23.2603 23.9963 23.9963 23.2603 23.9963 22.3556V13.732C23.9963 12.8273 23.2603 12.0919 22.3556 12.0919ZM7.18256 1.40625H11.1662C11.5538 1.40625 11.8691 1.72158 11.8691 2.10914V5.56641H6.47967V2.10914C6.47967 1.72158 6.795 1.40625 7.18256 1.40625ZM1.64063 22.5938C1.51125 22.5938 1.40625 22.4888 1.40625 22.3594V7.20703C1.40625 7.07766 1.51125 6.97266 1.64063 6.97266H5.07342V9.04542C5.07342 9.43373 5.38824 9.74855 5.77655 9.74855C6.16486 9.74855 6.47967 9.43373 6.47967 9.04542V6.97266H11.8691V9.04542C11.8691 9.43373 12.1839 9.74855 12.5723 9.74855C12.9606 9.74855 13.2754 9.43373 13.2754 9.04542V6.97266H16.7081C16.8375 6.97266 16.9425 7.07766 16.9425 7.20703V12.0919H10.1156C9.21094 12.0919 8.475 12.8273 8.475 13.732V22.3556C8.475 22.4367 8.4811 22.5159 8.49234 22.5938H1.64063ZM22.59 22.3556C22.59 22.4845 22.485 22.59 22.3556 22.59C21.9663 22.59 10.6801 22.59 10.1156 22.59C9.98672 22.59 9.88125 22.4845 9.88125 22.3556V13.732C9.88125 13.6031 9.98672 13.4981 10.1156 13.4981H22.3556C22.485 13.4981 22.59 13.6031 22.59 13.732V22.3556Z" fill="#2A2A2A"/>
                                    <path d="M19.376 15.1378C18.9879 15.1378 18.6729 15.4528 18.6729 15.8409V17.9269C18.6729 18.1748 18.5435 18.3928 18.349 18.518C18.1121 18.6715 18.2753 18.6295 14.502 18.6295C14.1143 18.6295 13.7988 18.3141 13.7988 17.9269V15.8409C13.7988 15.4528 13.4843 15.1378 13.0957 15.1378C12.7076 15.1378 12.3926 15.4528 12.3926 15.8409V17.9269C12.3926 19.0898 13.339 20.0358 14.502 20.0358C18.3048 20.0358 18.0909 20.0487 18.349 20.0016C19.332 19.8225 20.0791 18.9605 20.0791 17.9269V15.8409C20.0791 15.4528 19.7641 15.1378 19.376 15.1378Z" fill="#2A2A2A"/>
                                </svg>

                            </a>

                            <a class="d-flex align-items-center mr-2 pr-2 pr-lg-3 pr-xl-5 border-right" href="#">
                                <span class="mr-2"><?=Loc::getMessage('DRAWS');?></span> <i class="mb-1 icon-giftbox-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-7 col-xl-6">
                    <div class="d-flex justify-content-end justify-content-lg-between align-items-center">
                        <a href="#" class="mr-auto mr-md-5 mr-lg-0 text-uppercase btn-your-add" data-toggle="modal" data-target="#<?=($IDUser) ? 'modalTypeAdd' : 'logInModal';?>">
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
                                <a href="/auto/" class="border-bottom dropdown-item <?php echo (CSite::InDir('/auto/')) ? "active" : " "; ?>"><?=Loc::getMessage('AUTO');?></a>
                                <a href="/moto/" class="border-bottom dropdown-item <?php echo (CSite::InDir('/moto/')) ? "active" : " "; ?>">Moto</a>
                                <a href="/scooters/" class="dropdown-item <?php echo (CSite::InDir('/scooters/')) ? "active" : " "; ?>">Scooters</a>
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
                            <img src="<?=SITE_TEMPLATE_PATH?>/assets/img/logo.png" />
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
                            <a href="<?=$GLOBALS['arSetting'][SITE_ID]['href'];?>add/fm/" class="btn btn-primary text-uppercase font-weight-bold mb-4">
                                <?=Loc::getMessage('yourAds')?>
                            </a>
                        </div>
                    </div>
                    <div class="col">
                        <p class="h6 font-weight-bold">
                            <?=Loc::getMessage('realEstate')?>
                        </p>

                        <div class="d-flex flex-column">
                            <a href="<?=$GLOBALS['arSetting'][SITE_ID]['href'];?>add/rent/" class="btn btn-primary text-uppercase font-weight-bold mb-4">
                                <?=Loc::getMessage('rent')?>
                            </a>

                            <a href="<?=$GLOBALS['arSetting'][SITE_ID]['href'];?>add/buy/" class="btn btn-primary text-uppercase font-weight-bold mb-4">
                                <?=Loc::getMessage('buy')?>
                            </a>
                        </div>
                    </div>
                    <div class="col">
                        <p class="h6 font-weight-bold">
                            <?=Loc::getMessage('transport')?>
                        </p>
                        <div class="d-flex flex-column">
                            <a href="<?=$GLOBALS['arSetting'][SITE_ID]['href'];?>add/auto/" class="btn btn-primary text-uppercase font-weight-bold mb-4">
                                <?=Loc::getMessage('auto')?>
                            </a>

                            <a href="<?=$GLOBALS['arSetting'][SITE_ID]['href'];?>add/moto/" class="btn btn-primary text-uppercase font-weight-bold mb-4">
                                <?=Loc::getMessage('moto')?>
                            </a>

                            <a href="<?=$GLOBALS['arSetting'][SITE_ID]['href'];?>add/scooter/" class="btn btn-primary text-uppercase font-weight-bold mb-4">
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
