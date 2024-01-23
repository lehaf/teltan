<?if(!$_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') die();
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

if(isset($_POST) && !empty($_POST) && check_bitrix_sessid()) {

    global $USER;
    $arResult = $USER->SendPassword($_POST['email'], $_POST['email']);

    if($arResult["TYPE"] == "OK")
    {
        $error['TYPE'] = 'OK';
        $error['MESSAGE'] = $arResult['MESSAGE'];
    }
    else
    {
        $error['TYPE'] = 'ERROR';
        $error['MESSAGE'] = $arResult['MESSAGE'];
    }

    header('Content-type: application/json; charset=utf-8');
    print json_encode($error);
}
