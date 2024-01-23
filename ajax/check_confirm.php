<?if(!$_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') die();
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

if(isset($_POST) && !empty($_POST)) {

    global $USER;

    $error = array();

    $code = $_POST['codeplace1'].$_POST['codeplace2'].$_POST['codeplace3'].$_POST['codeplace4'];
    $type = $_POST['type_confirm'];
    $id_user = ($_POST['id_user']) ? $_POST['id_user'] : $USER->GetID();

    if(getConfirmCode($id_user, $type) == $code)
    {
        if($type == 'register')
        {
            // Активируем пользователя
            $user = new CUser;
            $fields = Array(
                "ACTIVE" => "Y",
            );
            $user->Update($id_user, $fields);
            $USER->Authorize($id_user); // авторизуем
            //$strError .= $user->LAST_ERROR;
            $error['OK'] = 'Y';
        }

        if($type == 'update_phone')
        {
            $user = new CUser;
            $fields = Array(
                "PERSONAL_PHONE" => $_POST['number'],
            );
            $user->Update($id_user, $fields);
            $error['OK'] = 'Y';
        }

    }
    else
    {
        $error['TYPE'] = 'ERROR';
        $error['MESSAGE'] = 'Ошибка подтверждения кода';
    }



    header('Content-type: application/json; charset=utf-8');
    print json_encode($error);
}
