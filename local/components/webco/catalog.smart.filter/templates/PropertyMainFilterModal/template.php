<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);
?>

<script>console.log(<?=json_encode($arParams)?>)</script>
<form id="modalFormId" name="<? echo $arResult["FILTER_NAME"] . "_form" ?>" action="<? echo $arResult["FORM_ACTION"] ?>"
      method="get">
    <div class="modal-body">
        <?
        $propertyToAllow = [];
        if(CSite::InDir('/zhilaya/')){
            $propertyToAllow = [];
        }elseif (CSite::InDir('/kommercheskaya/')){
            $propertyToAllow = [];
        }elseif (CSite::InDir('/novostroyki/')){
            $propertyToAllow = [];
        }
        foreach ($arResult["ITEMS"] as $key => $arItem) {
            if ($arItem['ID'] == 61 || $arItem['ID'] == 109 || $arItem['ID'] == 165 || $arItem['ID'] == 200 || $arItem['ID'] == 201 || $arItem['ID'] == 199)
                continue;
            ?>
            <? if ($_GET['view'] == 'maplist') { ?>
                <input style="display: none" type="text" name="view" value="maplist">
            <?
            } ?>
            <?

            switch ($arItem["DISPLAY_TYPE"]) {
                case "A"://NUMBERS_WITH_SLIDER
                    ?>

                    <?
                    break;
                case "B"://NUMBERS
                    ?>
                    <div class="row mb-4">
                        <div class="col-10">
                            <div class="input-group-modal">
                                <div class="d-flex flex-row-reverse align-items-center">
                                    <div class="input-decoration">
                                        <input
                                                type="text"
                                                value="<? echo $arItem["VALUES"]["MAX"]["HTML_VALUE"] ?>"
                                                name="<? echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"] ?>"
                                                placeholder="<?= $arItem["VALUES"]["MAX"]["VALUE"] ?>"
                                                id="<? echo $arItem["VALUES"]["MAX"]["CONTROL_ID"] ?>"
                                                onkeyup="smartFilter.keyup(this); $(this).data('valued', $(this).val())">
                                        <span class="decoration">м²</span>
                                    </div>

                                    <div class="input-decoration mr-3">
                                        <input
                                                type="text"
                                                value="<? echo $arItem["VALUES"]["MIN"]["HTML_VALUE"] ?>"
                                                name="<? echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"] ?>"
                                                placeholder="<?= $arItem["VALUES"]["MIN"]["VALUE"] ?>"
                                                id="<? echo $arItem["VALUES"]["MIN"]["CONTROL_ID"] ?>"
                                                onkeyup="smartFilter.keyup(this); $(this).data('valued', $(this).val())">
                                        <span class="decoration">м²</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-2 text-right">
                            <?= $arItem['NAME'] ?>
                        </div>
                    </div>
                    <?
                    break;
                case "G"://CHECKBOXES_WITH_PICTURES
                    ?>

                    <?
                    break;
                case "H"://CHECKBOXES_WITH_PICTURES_AND_LABELS
                    ?>

                    <?
                    break;
                case "P"://DROPDOWN

                    ?>

                    <?
                    break;
                case "R"://DROPDOWN_WITH_PICTURES_AND_LABELS
                    ?>

                    <?
                    break;
                case "K"://RADIO_BUTTONS
                    ?>
                    <div class="row mb-4">
                        <div class="col-10">
                            <div class="d-flex flex-wrap flex-row-reverse align-items-center">
                                <? foreach ($arItem["VALUES"] as $val => $ar) { ?>

                                    <label class="parameter">
                                        <input
                                                type="radio"
                                                value="<? echo $ar["HTML_VALUE"] ?>"
                                                name="<? echo $ar["CONTROL_NAME"] ?>"
                                                id="<? echo $ar["CONTROL_ID"] ?>"
                                                data-valued="<? echo $ar["VALUE"] ?>"
                                            <? echo $ar["CHECKED"] ? 'checked="checked"' : '' ?>
                                            <? echo $ar["DISABLED"] ? '' : '' ?>
                                                onclick="smartFilter.click(this)"
                                        />
                                        <div><? echo $ar["VALUE"] ?></div>
                                    </label>
                                <?
                                } ?>
                            </div>
                        </div>
                        <div class="col-2 text-right">
                            <?= $arItem['NAME'] ?>
                        </div>
                    </div>
                    <?
                    break;
                case "U"://CALENDAR
                    ?>
                    <div class="row mb-4">
                        <div class="col-10">
                            <div class="d-flex flex-row-reverse align-items-center">

                                <div class="d-flex input-group-modal">
                                    <div class="input-decoration date-input">
                                        <? $APPLICATION->IncludeComponent(
                                            'bitrix:main.calendar',
                                            '',
                                            array(
                                                'FORM_NAME' => $arResult["FILTER_NAME"] . "_form",
                                                'SHOW_INPUT' => 'Y',
                                                'INPUT_ADDITIONAL_ATTR' => 'class="calendar" placeholder="' . FormatDate("SHORT", $arItem["VALUES"]["MIN"]["VALUE"]) . '" onkeyup="smartFilter.keyup(this)" onchange="smartFilter.keyup(this)"',
                                                'INPUT_NAME' => $arItem["VALUES"]["MAX"]["CONTROL_NAME"],
                                                'INPUT_VALUE' => $arItem["VALUES"]["MAX"]["HTML_VALUE"],
                                                'SHOW_TIME' => 'N',
                                                'HIDE_TIMEBAR' => 'Y',
                                            ),
                                            null,
                                            array('HIDE_ICONS' => 'Y')
                                        ); ?>
                                    </div>
                                </div>

                                <div style="width: auto;" class="d-flex check-box-prop-filter">
                                    <div class="mr-5">
                                        <label class="cb-wrap">
                                            <span class="text"><?= Loc::getMessage('now'); ?></span>
                                            <input type="checkbox" name="check-in-now" value="Немедленный въезд">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-2 text-right">
                            <?= $arItem['NAME'] ?>
                        </div>
                    </div>
                    <?
                    break;
                default:

                    ?>
                    <div class="row mb-4">
                        <div class="col-10">
                            <div class="d-flex flex-wrap flex-row-reverse align-items-center">
                                <? foreach ($arItem["VALUES"] as $val => $ar) { ?>

                                    <label class="parameter">
                                        <input
                                                type="checkbox"
                                                value="<? echo $ar["HTML_VALUE"] ?>"
                                                name="<? echo $ar["CONTROL_NAME"] ?>"
                                                id="<? echo $ar["CONTROL_ID"] ?>"
                                                data-valued="<? echo $ar["VALUE"] ?>"
                                            <? echo $ar["CHECKED"] ? 'checked="checked"' : '' ?>
                                            <? echo $ar["DISABLED"] ? '' : '' ?>
                                                onclick="smartFilter.click(this)"
                                        />
                                        <div><? echo $ar["VALUE"] ?></div>
                                    </label>
                                <?
                                } ?>
                            </div>
                        </div>
                        <div class="col-2 text-right">
                            <?= $arItem['NAME'] ?>
                        </div>
                    </div>
                <?
            }
        }
        ?>

        <script>
            function getLink(event) {
                event.preventDefault()
               let url = $('#modefParen').attr('href');
               console.log(url)
                setTimeout(() => { window.location.href = url},1500)
            }
        </script>
    </div>

    <!-- </ul> -->
    <div class="modal-footer flex-row-reverse border-top-0">

        <div class="clb"></div>
        <div class="bx_filter_button_box active">
            <div class="bx_filter_block">
                <div class="bx_filter_parameters_box_container">
                    <input
                            class="btn btn-primary ressetFilterAll"
                            type="submit"
                            id="set_filter"
                            onclick="getLink(event)"
                            name="set_filter"
                            value="<?= GetMessage("CT_BCSF_SET_FILTER") ?>"
                    />
                    <input
                            class="btn text-primary"
                            type="submit"
                            id="del_filter"
                            name="del_filter"
                            value="<?= GetMessage("CT_BCSF_DEL_FILTER") ?>"
                    />
                </div>
            </div>
        </div>
    </div>

</form>


<script>
    var smartFilter = new JCSmartFilter('<?echo CUtil::JSEscape($arResult["FORM_ACTION"])?>', '<?=CUtil::JSEscape($arParams["FILTER_VIEW_MODE"])?>', <?=CUtil::PhpToJSObject($arResult["JS_FILTER_PARAMS"])?>);
</script>
