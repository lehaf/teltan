<?if(!$_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') die();
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

if(isset($_POST)) {

    global $USER;
    $error = array();

    $IDUser = $USER->GetID();

    $messages = getChatsUser($IDUser, true);

    foreach ($messages as $message) {
        if($message['ID_AUTOR'] == $IDUser)
        {
            UpdateHlItem(7, $message['ID'], array('UF_DEL_AUTOR' => 1));
        }
        elseif($message['ID_SEC_USER'] == $IDUser)
        {
            UpdateHlItem(7, $message['ID'], array('UF_DEL_USER' => 1));
        }
    }

    $error['TYPE'] = 'OK';

    header('Content-type: application/json; charset=utf-8');
    print json_encode($error);
}
