<?if(!$_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') die();
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

if(isset($_POST)) {

    global $USER;
    $error = array();

    $IDUser = $USER->GetID();
    $count = getCountUnreadMessages($IDUser);

    if($count > 99)
        $count = 99;

    header('Content-type: application/json; charset=utf-8');
    print json_encode($count);
}
