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
//    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH."/css/fonts.css");
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
        "mobile_sections",
        Array(
            "ADD_SECTIONS_CHAIN" => "N",
            "CACHE_FILTER" => "N",
            "CACHE_GROUPS" => "N",
            "CACHE_TIME" => "36000000",
            "CACHE_TYPE" => "A",
            "COUNT_ELEMENTS" => "N",
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

    <?php/*$APPLICATION->IncludeComponent(
        "bitrix:main.include",
        "",
        Array(
            "AREA_FILE_SHOW" => "file",
            "AREA_FILE_SUFFIX" => "inc",
            "EDIT_TEMPLATE" => "",
            "PATH" => SITE_TEMPLATE_PATH."/includes/header/mobile_menu.php"
        )
    );*/?>
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
                        <div class="d-none d-lg-flex align-items-center fleamarket-link">
                            <a class="font-weight-bold d-flex align-items-center" href="/flea/">
                                <span class="mt-1 mr-2 ml-2"><?=Loc::getMessage('FLEA_MARKET');?></span>
                                <i class="icon-free"></i>
                            </a>
                            <div class="fleamarket">
                                <?php $APPLICATION->IncludeComponent(
                                    "bitrix:catalog.section.list",
                                    "sections_menu",
                                    Array(
                                        "ADD_SECTIONS_CHAIN" => "N",
                                        "CACHE_FILTER" => "N",
                                        "CACHE_GROUPS" => "N",
                                        "CACHE_TIME" => "36000000",
                                        "CACHE_TYPE" => "A",
                                        "COUNT_ELEMENTS" => "N",
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
                            </div>
                        </div>
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
                            <img src="<?=SITE_TEMPLATE_PATH?>/img/png-03.png" />
                            <!--
                            <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <rect width="44" height="44" fill="url(#pattern0)"/>
                                <defs>
                                    <pattern id="pattern0" patternContentUnits="objectBoundingBox" width="1" height="1">
                                        <use xlink:href="#image0" transform="translate(-0.0206829) scale(0.00381679)"/>
                                    </pattern>
                                    <image id="image0" width="1073" height="262" xlink:href="data:image/png;base64,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"/>
                                </defs>
                            </svg>

                        </div>

                        <div class="d-flex flex-column">
                            <div class="logo__section-name text-right text-uppercase">
                                <?php/*
                                if(CSite::InDir('/property/'))
                                    print 'Property';
                                if(CSite::InDir('/flea/'))
                                    print 'Flea Market';
                                if(CSite::InDir('/auto/'))
                                    print 'Auto';
                                if(CSite::InDir('/moto/'))
                                    print 'Moto';
                                if(CSite::InDir('/scooters/'))
                                    print 'Scooters';*/
                                ?>
                            </div>
                            <div class="logo__text">
                                <svg width="75" height="13" viewBox="0 0 75 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M19.9743 2.11978V0H14.4549H11.6553V2.11978V5.07938V7.19909V10.2387V12.3985H19.9743V10.2387H14.4549V7.19909H19.1344V5.07938H14.4549V2.11978H19.9743Z" fill="#0C0C0C"/>
                                    <path d="M30.3746 2.11978V0H24.8553H22.0557V2.11978V5.07938V7.19909V10.2387V12.3985H30.3746V10.2387H24.8553V7.19909H29.5347V5.07938H24.8553V2.11978H30.3746Z" fill="#0C0C0C"/>
                                    <path d="M50.2517 0H40.8525V2.11978H44.4126V12.3985H46.9319V2.11978H50.2517V0Z" fill="#0C0C0C"/>
                                    <path d="M9.55801 0H0.199219V2.11978H3.71878V12.3985H6.23848V2.11978H9.55801V0Z" fill="#0C0C0C"/>
                                    <path d="M41.8931 12.3985V9.87876H34.9741V0H32.4541V12.3985H41.8931Z" fill="#0C0C0C"/>
                                    <path d="M59.8506 12.3985H62.0106L57.0113 0H54.8513H54.5718L49.6523 12.3985H52.0918L53.0919 9.87876H58.8512L59.8506 12.3985ZM53.8119 8.07898L55.9712 2.67966L58.1312 8.07898H53.8119Z" fill="#0C0C0C"/>
                                    <path d="M72.4082 0V8.55896L66.5292 0H64.0498V12.4784H66.5292V3.79951L72.4082 12.4784H74.9282V0H72.4082Z" fill="#0C0C0C"/>
                                </svg>

                            </div>-->
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
