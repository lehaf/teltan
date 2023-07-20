<?if(!$_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') die();
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

if(isset($_POST) && isset($_POST['ad']) && isset($_POST['au'])) {

    global $USER;
    $error = array();

    $IDUser = $USER->GetID();
    $IDAd = (int)$_POST['ad'];
    $IDAu = (int)$_POST['au'];

    if($IDAd && $IDAu)
    {
        $messages = getMessagesChat($IDAd, $IDUser, $IDAu);
        if($messages)
        {
            foreach ($messages as $message) {
                if($message['UF_AUTOR_ID'] == $IDUser)
                {
                    UpdateHlItem(7, $message['ID'], array('UF_DEL_AUTOR' => 1));
                    $error['TYPE'] = 'OK';
                }
                elseif($message['UF_ID_USER'] == $IDUser)
                {
                    UpdateHlItem(7, $message['ID'], array('UF_DEL_USER' => 1));
                    $error['TYPE'] = 'OK';
                }
            }
        }
    }

    header('Content-type: application/json; charset=utf-8');
    print json_encode($error);
}
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>