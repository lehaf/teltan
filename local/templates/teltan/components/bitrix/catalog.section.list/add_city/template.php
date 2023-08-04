<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
$arCity = [];
$arRegion = [];
$regionSelectedId = 0;
foreach ($arResult['SECTIONS'] as $arItem) {
    if ($arItem['IBLOCK_SECTION_ID']) {
        $arCity[$arItem['IBLOCK_SECTION_ID']][] = $arItem;
    } else {
        $arRegion[] = $arItem;
    }
}

use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

?>
<div class="form-group row flex-column-reverse flex-lg-row">
    <div class="col col-lg-10 d-flex justify-content-end">
        <div class="dependens-dropdon d-flex gap-1 w-100">
            <div class="dependens-dropdon-block dependens-dropdon-after">
                <button type="button" class="dep-select second-drop"><?= ($arParams['PROPS']['UF_CITY']['VALUE'] != '' || $arParams['PROPS']['UF_REGION']['VALUE'] != '')? $arParams['PROPS']['UF_CITY']['VALUE']: Loc::getMessage('City'); ?></button>
                <ul class="show-city <?= ($arParams['PROPS']['UF_CITY']['VALUE'] != '')? 'selected': '' ?>">
                    <? foreach ($arCity as $id => $citys) {
                        foreach ($citys as $city) {
                            ?>
                            <li class="cityClassSelector">
                                <label for="city">
                                    <input data-parent-class="parentClass<?= $id ?>"
                                           name="city"
                                           value="<?= $city['NAME'] ?>"
                                           type="radio"
                                    >
                                    <?= $city['NAME']?>
                                </label>
                            </li>
                        <? } ?>
                    <? } ?>
                </ul>
            </div>
            <div class="dependens-dropdon-block dependens-dropdon-after">
                <button type="button" class="dep-select first-drop"><?= ($arParams['PROPS']['UF_REGION']['VALUE'] != '')? $arParams['PROPS']['UF_REGION']['VALUE']: Loc::getMessage('Region'); ?></button>
                <ul class="show-country <?= ($arParams['PROPS']['UF_REGION']['VALUE'] != '')? 'selected': '' ?>">
                    <? foreach ($arRegion as $key => $value) {
                        if ($value['NAME'] == $arParams['PROPS']['UF_REGION']['VALUE']){
                            $regionSelectedId = $value['ID'];
                        }
                        ?>
                        <li class="regionClassSelector ">
                            <label class="parentClass">
                                <input id="parentClass<?= $value['ID'] ?>" name="country" value="<?= $value['NAME'] ?>"
                                       type="radio"/>
                                <?= $value['NAME'] ?>
                            </label>
                        </li>
                    <? } ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-2 d-flex justify-content-end align-items-center">
        <p class="text-right mb-3 mb-lg-0 font-weight-bold">:<?=Loc::getMessage('Country');?>*</p>
    </div>
</div>

<?if (!empty($arParams['PROPS']['UF_REGION']['VALUE'])):?>
    <script>
        function renderCity(id) {
            let parent = id;
            $('.show-city').find('input').each(function () {

                $(this).parent('label').parent('li').hide()
                if($(this).attr('data-parent-class') ===  parent) {

                    $(this).parent('label').parent('li').show()
                    console.log(this);
                }else {

                    $(this).parent('label').parent('li').hide()
                }
            })
        }

        renderCity('parentClass<?=$regionSelectedId?>');
    </script>
<?endif;?>