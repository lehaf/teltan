<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

/** @var array $arResult */
/** @var array $arParams */
/** @global object $APPLICATION */
/** @global object $USER */

use Bitrix\Main\Localization\Loc;

$this->addExternalJs(SITE_TEMPLATE_PATH.'/assets/components/buttons/edit.js');
?>
<div class="edit-user-item">
    <button class="mr-lg-4 mb-3 mb-lg-0 btn user-product__btn-edit text-uppercase item-edit-btn">
        <?= Loc::getMessage('UP_EDIT'); ?>
    </button>
    <ul id="edit-item-menu_item<?=$arResult['ITEM_ID']?>" class="flex-column edit-item-menu_item">
        <li class="border-bottom">
            <div class="custom-control custom-switch activateItem">
                <input type="checkbox"
                       class="custom-control-input"
                       id="activateItem<?=$arResult['ITEM_ID']?>"
                       <?=$arResult['ITEM_ACTIVE'] === 'Y' ? 'checked' : ''?>
                >
                <label id="activateItemText<?=$arResult['ITEM_ID']?>"
                       data-iblock-id="<?=$arResult['IBLOCK_ID']?>"
                       data-item-id="<?=$arResult['ITEM_ID']?>"
                       class="custom-control-label activate-item-toggle"
                       for="activateItem<?=$arResult['ITEM_ID']?>"
                >
                    <?= Loc::getMessage('DELETE_UN'); ?>
                </label>
            </div>
        </li>
        <?php if (!empty($arResult['EDIT_PAGE'])):?>
            <li class="border-bottom">
                <a class="mr-3" href="<?=$arResult['EDIT_PAGE']?>?ID=<?=$arResult['ITEM_ID']?>&EDIT=Y"><?= Loc::getMessage('UP_EDIT'); ?></a>
                <span class="mr-2">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15.4042 3.28224L12.6642 0.542241C12.3066 0.206336 11.838 0.0135995 11.3475 0.000692758C10.8571 -0.012214 10.379 0.15561 10.0042 0.472241L1.0042 9.47224C0.680969 9.79821 0.479707 10.2254 0.434203 10.6822L0.00420295 14.8522C-0.00926809 14.9987 0.00973728 15.1463 0.0598642 15.2846C0.109991 15.4229 0.190005 15.5484 0.294203 15.6522C0.387643 15.7449 0.498459 15.8182 0.620297 15.868C0.742134 15.9178 0.872596 15.943 1.0042 15.9422H1.0942L5.2642 15.5622C5.721 15.5167 6.14824 15.3155 6.4742 14.9922L15.4742 5.99224C15.8235 5.62321 16.0123 5.13075 15.9992 4.62278C15.9861 4.1148 15.7721 3.63275 15.4042 3.28224ZM12.0042 6.62224L9.3242 3.94224L11.2742 1.94224L14.0042 4.67224L12.0042 6.62224Z"
                              fill="#3FC5FF"/>
                    </svg>
                </span>
            </li>
        <?php endif;?>
        <li class="px-3">
            <button id="alertConfirmation<?=$arResult['ITEM_ID']?>"
                    data-ad-id="<?=$arResult['ITEM_ID']?>"
                    type="button"
                    class="btn p-0 text-secondary alert-confirmation-btn"
            >
                <span class="mr-2"><?= Loc::getMessage('DELETE'); ?></span>
                <i class="mr-2 icon-clear"></i>
            </button>
        </li>
    </ul>
    <div id="alert-confirmationIdView<?=$arResult['ITEM_ID']?>" class="allert alert-confirmation flex-column card">
        <button type="button" class="close" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <div class="d-flex justify-content-center allert__text"><?= Loc::getMessage('CT_BNL_ELEMENT_DELETE_CONFIRM'); ?></div>
        <div class="d-flex justify-content-center mt-4">
            <button data-item="<?=$arResult['ITEM_ID']?>"
                    class="btn border-primary text-uppercase font-weight-bold text-primary py-3 px-5 delete-item-btn"
            >
                    <?=Loc::getMessage('DELETE');?>
            </button>
        </div>
    </div>
</div>






