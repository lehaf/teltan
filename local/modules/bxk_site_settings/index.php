<?php
use Bitrix\Main\Loader;
use Bitrix\Main\Config\Option;

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php");
Loader::includeModule("iblock");
$APPLICATION->SetTitle('Настройки сайта');

if(isset($_POST['submit_form']))
{
    // Сохраняем настройки
    unset($_POST['submit_form']);

    foreach($_POST as $option => $value)
    {
        Option::set("bxk_setting", $option, $value);
    }

}
// Получаем настройки из БД
$options = Option::getForModule('bxk_setting');
?>
    <div class="adm-detail-block" id="tabControl_layout">
        <div class="adm-detail-tabs-block" id="tabControl_tabs" style="left: 0px;">
            <span title=" id="tab_cont_edit1" class="adm-detail-tab adm-detail-tab-active adm-detail-tab-last">Общие настройки</span>	<div class="adm-detail-pin-btn-tabs"></div></div>
        <div class="adm-detail-content-wrap">

            <form method="post" class="next_options" enctype="multipart/form-data" action="/bitrix/admin/bxk_site_settings.php">

                <div class="adm-detail-content" id="edit1"><div class="adm-detail-title"></div>
                    <div class="adm-detail-content-item-block">
                        <table class="adm-detail-content-table edit-table" id="edit1_edit_table">
                            <tbody>
                            <tr class="heading"><td colspan="2">Социальные сети</td></tr>

                            <tr>
                                <td class="adm-detail-content-cell-l" width="50%">Ссылка на facebook:</td>
                                <td class="adm-detail-content-cell-r" width="50%">
                                    <input type="text" size="" maxlength="255" value="<?=$options['URL_FACEBOOK']?>" name="URL_FACEBOOK" style="width: 450px;">
                                </td>
                            </tr>

                            <tr>

                                <td class="adm-detail-content-cell-l" width="50%">Ссылка на instagram:</td>
                                <td class="adm-detail-content-cell-r" width="50%">
                                    <input type="text" size="" maxlength="255" value="<?=$options['URL_INSTAGRAM']?>" name="URL_INSTAGRAM" style="width: 450px;">
                                </td>
                            </tr>


                            </tbody>
                        </table>
                        <button type="submit" name="submit_form" class="adm-btn adm-btn-save" title="">Сохранить настройки</button>
                    </div>

                </div>
                <div style="display: block; height: 40px;" class="adm-detail-content-btns-wrap"></div>
                </form>
        </div></div>

<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");
?>