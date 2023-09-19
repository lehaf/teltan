<?if(!$_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') die();
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

if(isset($_POST) && !empty($_POST) && check_bitrix_sessid()) {

    global $USER;
    $error = array();
    $params = Array(
        "max_len" => "100", // обрезает символьный код до 100 символов
        "change_case" => "L", // буквы преобразуются к нижнему регистру
        "replace_space" => "_", // меняем пробелы на нижнее подчеркивание
        "replace_other" => "_", // меняем левые символы на нижнее подчеркивание
        "delete_repeat_replace" => "true", // удаляем повторяющиеся нижние подчеркивания
        "use_google" => "false", // отключаем использование google
    );


    CModule::IncludeModule('iblock');
    $el = new CIBlockElement;

    $PROP = array();
    $PROP['ID_USER'] = $USER->GetID();
    $PROP['PRICE'] = $_POST['itemPrice'] * 1;

    $arLoadProductArray = Array(
        "IBLOCK_SECTION_ID" => (int)$_POST['section_id'],
        "IBLOCK_ID"      => 1,
        "PROPERTY_VALUES"=> $PROP,
        "NAME"           => $_POST['itemTitle'],
        "CODE" => CUtil::translit($_POST['itemTitle'], "ru" , $params),
        "ACTIVE"         => "N",
        "PREVIEW_TEXT"   => $_POST['itemShortDescription'],
        "DETAIL_TEXT"    => $_POST['itemDescription'],
        //"DETAIL_PICTURE" => CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"]."/image.gif")
    );

    if($PRODUCT_ID = $el->Add($arLoadProductArray))
        $error['OK'] = 'Y';
    else
        $error['OK'] = 'N';

    header('Content-type: application/json; charset=utf-8');
    print json_encode($error);
}
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>