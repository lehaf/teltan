<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

/** @var array $arResult */
/** @var array $arParams */

use Bitrix\Main\Localization\Loc;

?>
<?php if (!empty($arResult['SORTS']) || !empty($arResult['VIEWS'])):?>
    <div class="col-12 col-xl-6 justify-content-center">
        <div class="d-flex justify-content-between justify-content-xl-end products-sort">
            <?php if (!empty($arParams['FILTER_BUTTON']) && $arParams['FILTER_BUTTON'] === 'Y'):?>
                <div class="d-flex">
                    <a href="#" class="mr-2 d-flex d-lg-none justify-content-center align-items-center products-sort__button filterTogglerMobile">
                        <img src="<?=SITE_TEMPLATE_PATH?>/assets/settings.svg" alt="">
                    </a>
                </div>
            <?php endif;?>
            <?php if (!empty($arResult['VIEWS'])):?>
                <div class="d-flex">
                    <?php foreach ($arResult['VIEWS'] as $viewName => $view):?>
                        <button data-view="<?=$viewName?>"
                                class="<?=!empty($view['ACTIVE']) && $view['ACTIVE'] === 'Y' ? 'active' : ''?> mr-2 d-none d-lg-flex justify-content-center align-items-center products-sort__button"
                        >
                            <i class="<?=$view['CLASS']?>"></i>
                        </button>
                    <?php endforeach;?>
                </div>
            <?php endif;?>
            <?php if (!empty($arResult['SORTS'])):?>
                <div class="d-flex dropdown">
                    <button class="btn bg-white d-flex justify-content-between align-items-center" href="#"  id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="icon-arrow-down-sign-to-navigate-3"></i>
                        <span id="sort-text" class="text-right"><?=$arResult['SORT_TEXT'];?></span>
                    </button>
                    <div class="dropdown-menu menu-sort" aria-labelledby="dropdownMenuLink">
                        <?php foreach ($arResult['SORTS'] as $key => $sort):?>
                            <a class="dropdown-item sort-item <?=!empty($sort['ACTIVE']) && $sort['ACTIVE'] === 'Y' ? 'active' : ''?>"
                               data-sort="<?=$key?>"
                               href="<?=$sort['URL']?>"
                            >
                                <?=$sort['NAME']?>
                            </a>
                        <?php endforeach;?>
                    </div>
                </div>
            <?php endif;?>
        </div>
    </div>
<?php endif;?>


