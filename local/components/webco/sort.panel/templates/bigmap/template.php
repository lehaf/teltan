<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

/** @var array $arResult */
/** @var array $arParams */

if (!empty($arResult['VIEWS'])):?>
    <div class="d-flex justify-content-end">
        <div class="d-flex justify-content-between justify-content-lg-end products-sort">
            <div class="d-flex align-items-center py-3">
                <?php foreach ($arResult['VIEWS'] as $viewName => $view):?>
                    <button id="<?=$view['CLASS']?>"
                       data-view="<?=$viewName?>"
                       type="button"
                       class="<?=!empty($view['ACTIVE']) && $view['ACTIVE'] === 'Y' ? 'active' : ''?> mr-2 d-none d-lg-flex justify-content-center align-items-center products-sort__button"
                    >
                        <i class="<?=$view['CLASS']?>"></i>
                    </button>
                <?php endforeach;?>
            </div>
        </div>
    </div>
<?php endif;?>



