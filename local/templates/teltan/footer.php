<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/** @global object $APPLICATION */

use Bitrix\Main\Localization\Loc;

global $mapArray;

Loc::loadMessages(__FILE__);

$url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$needle = '/property/';
$pos = strripos($url, $needle);

if ($pos !== false):?>
    <button id="btnToTheTop" class="btn-to-top">
        <img src="/local/templates/teltan/assets/settings.svg" alt="filter">
    </button>
<?php endif;?>
<footer class="footer py-3"
        bis_size="{&quot;x&quot;:18,&quot;y&quot;:205,&quot;w&quot;:426,&quot;h&quot;:132,&quot;abs_x&quot;:468,&quot;abs_y&quot;:695}">
    <div class="container"
         bis_size="{&quot;x&quot;:18,&quot;y&quot;:205,&quot;w&quot;:426,&quot;h&quot;:132,&quot;abs_x&quot;:468,&quot;abs_y&quot;:695}">
        <div class="row flex-column-reverse flex-md-row d-flex"
             bis_size="{&quot;x&quot;:18,&quot;y&quot;:205,&quot;w&quot;:426,&quot;h&quot;:132,&quot;abs_x&quot;:468,&quot;abs_y&quot;:695}">
            <div class="col-12 col-md-8 col-xl-9"
                 bis_size="{&quot;x&quot;:18,&quot;y&quot;:205,&quot;w&quot;:426,&quot;h&quot;:66,&quot;abs_x&quot;:468,&quot;abs_y&quot;:695}">
                <div class="mr-4 footer__info text-center text-lg-rigth"
                     bis_size="{&quot;x&quot;:18,&quot;y&quot;:205,&quot;w&quot;:426,&quot;h&quot;:66,&quot;abs_x&quot;:468,&quot;abs_y&quot;:695}">
                    <?php $APPLICATION->IncludeComponent(
                        "bitrix:menu",
                        "template_menu_footer",
                        array(
                            "ALLOW_MULTI_SELECT" => "N",
                            "CHILD_MENU_TYPE" => "left",
                            "DELAY" => "N",
                            "MAX_LEVEL" => "1",
                            "MENU_CACHE_GET_VARS" => array(""),
                            "MENU_CACHE_TIME" => "360000",
                            "MENU_CACHE_TYPE" => "A",
                            "MENU_CACHE_USE_GROUPS" => "N",
                            "ROOT_MENU_TYPE" => "bottom",
                            "USE_EXT" => "N"
                        )
                    ); ?>
                    <p class="m-0 copyright"
                       bis_size="{&quot;x&quot;:18,&quot;y&quot;:246,&quot;w&quot;:426,&quot;h&quot;:25,&quot;abs_x&quot;:468,&quot;abs_y&quot;:736}">
                        <?php $APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            "",
                            array(
                                "AREA_FILE_SHOW" => "file",
                                "AREA_FILE_SUFFIX" => "inc",
                                "EDIT_TEMPLATE" => "",
                                "PATH" => SITE_TEMPLATE_PATH . "/includes/" . SITE_ID . "/footer/about.php"
                            )
                        ); ?>
                    </p>
                </div>
            </div>
            <div class="col-12 col-md-4 col-xl-3"
                 bis_size="{&quot;x&quot;:18,&quot;y&quot;:287,&quot;w&quot;:426,&quot;h&quot;:50,&quot;abs_x&quot;:468,&quot;abs_y&quot;:777}">
                <div class="h-100 mb-4 mb-lg-0 d-flex align-items-center justify-content-center justify-content-md-end"
                     bis_size="{&quot;x&quot;:18,&quot;y&quot;:287,&quot;w&quot;:426,&quot;h&quot;:50,&quot;abs_x&quot;:468,&quot;abs_y&quot;:777}">
                    <div class="mr-4 footer__social"
                         bis_size="{&quot;x&quot;:18,&quot;y&quot;:287,&quot;w&quot;:426,&quot;h&quot;:50,&quot;abs_x&quot;:468,&quot;abs_y&quot;:777}">
                        <?php if ($BXK_OPTIONS['URL_FACEBOOK']) { ?> <a class="mr-2"
                                                                        href="<?= $BXK_OPTIONS['URL_FACEBOOK']; ?>"
                                                                        bis_size="{&quot;x&quot;:133,&quot;y&quot;:294,&quot;w&quot;:193,&quot;h&quot;:17,&quot;abs_x&quot;:583,&quot;abs_y&quot;:784}">
                            <style>.cls-1 {
                                    fill: #1877f2;
                                }

                                .cls-2 {
                                    fill: #fff;
                                }</style>
                            <span class="cls-1"
                                  d="M506.86,253.43C506.86,113.46,393.39,0,253.43,0S0,113.46,0,253.43C0,379.92,92.68,484.77,213.83,503.78V326.69H149.48V253.43h64.35V197.6c0-63.52,37.84-98.6,95.72-98.6,27.73,0,56.73,5,56.73,5v62.36H334.33c-31.49,0-41.3,19.54-41.3,39.58v47.54h70.28l-11.23,73.26H293V503.78C414.18,484.77,506.86,379.92,506.86,253.43Z"
                                  bis_size="{&quot;x&quot;:322,&quot;y&quot;:294,&quot;w&quot;:4,&quot;h&quot;:17,&quot;abs_x&quot;:772,&quot;abs_y&quot;:784}"><span
                                        class="cls-2"
                                        d="M352.08,326.69l11.23-73.26H293V205.89c0-20,9.81-39.58,41.3-39.58h31.95V104s-29-5-56.73-5c-57.88,0-95.72,35.08-95.72,98.6v55.83H149.48v73.26h64.35V503.78a256.11,256.11,0,0,0,79.2,0V326.69Z"
                                        bis_size="{&quot;x&quot;:322,&quot;y&quot;:294,&quot;w&quot;:4,&quot;h&quot;:17,&quot;abs_x&quot;:772,&quot;abs_y&quot;:784}"> </span></span></a>
                        <?php } ?> <?php if ($BXK_OPTIONS['URL_INSTAGRAM']) { ?> <a
                                href="<?= $BXK_OPTIONS['URL_INSTAGRAM']; ?>"
                                bis_size="{&quot;x&quot;:133,&quot;y&quot;:319,&quot;w&quot;:0,&quot;h&quot;:17,&quot;abs_x&quot;:583,&quot;abs_y&quot;:809}"> </a>
                        <?php } ?>
                    </div>
                    <div class="footer__logo"
                         bis_size="{&quot;x&quot;:18,&quot;y&quot;:337,&quot;w&quot;:426,&quot;h&quot;:0,&quot;abs_x&quot;:468,&quot;abs_y&quot;:827}">
                        <a href="<?= $GLOBALS['arSetting'][SITE_ID]['href']; ?>"
                           bis_size="{&quot;x&quot;:18,&quot;y&quot;:337,&quot;w&quot;:0,&quot;h&quot;:0,&quot;abs_x&quot;:468,&quot;abs_y&quot;:827}">
                            <span class="image"
                                  bis_size="{&quot;x&quot;:18,&quot;y&quot;:337,&quot;w&quot;:0,&quot;h&quot;:0,&quot;abs_x&quot;:468,&quot;abs_y&quot;:827}"> </span>
                            <span class="text"
                                  bis_size="{&quot;x&quot;:18,&quot;y&quot;:337,&quot;w&quot;:0,&quot;h&quot;:0,&quot;abs_x&quot;:468,&quot;abs_y&quot;:827}"> </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="pop-up">
        <span class="pop-up-cross">
            <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0.338896 0.338896C0.790758 -0.112965 1.52314 -0.112965 1.97476 0.338896L7.42773 5.79188L12.8807 0.338896C13.3326 -0.112965 14.065 -0.112965 14.5166 0.338896C14.9684 0.790758 14.9684 1.52313 14.5166 1.97476L9.06359 7.42773L14.5166 12.8807C14.9684 13.3326 14.9684 14.065 14.5166 14.5166C14.0647 14.9684 13.3323 14.9682 12.8807 14.5166L7.42773 9.06359L1.97476 14.5166C1.52289 14.9682 0.790517 14.9682 0.338896 14.5166C-0.112965 14.0647 -0.112965 13.3323 0.338896 12.8807L5.79187 7.42773L0.338896 1.97476C-0.112965 1.52289 -0.112965 0.790517 0.338896 0.338896Z"
                      fill="#A0A0A0"/>
            </svg>
        </span>
        <div class="pop-up__text"></div>
    </div>
</footer>
<?php
// Modal window auth
include $_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH . "/includes/footer/auth_modal.php";
// Modal window register
include $_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH . "/includes/footer/register_modal.php";
include $_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH . "/includes/footer/confirm_tel_modal.php";
