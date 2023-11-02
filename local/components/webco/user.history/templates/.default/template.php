<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

/** @var array $arResult */

use Bitrix\Main\Localization\Loc;

?>
<?php if (!empty($arResult['HISTORY'])):?>
    <div class="card purchase-history">
        <div class="mb-4 pb-3 wallet-history__title border-bottom">
            <?=Loc::getMessage('purchase_history')?>
        </div>
        <?php foreach ($arResult['HISTORY'] as $entry):?>
            <?php if (!empty($entry['UF_NAME'])):?>
                <div class="pb-2 mb-2 d-flex justify-content-between align-items-center border-bottom">
                    <div class="text-uppercase purchase-history__name">
                        <?=$entry["UF_NAME"]?>
                    </div>
                    <div class="text-uppercase purchase-history__date">
                        <?=$entry['UF_DATE_BUY']?>
                    </div>
                </div>
            <?php endif;?>
        <?php endforeach;?>
    </div>
<?php endif;?>


