<?if(!$_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') die();
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

if(isset($_POST) && !empty($_POST) && check_bitrix_sessid()) {

    global $USER;

    $error = array();
    $fields = array();

    $old_pass = $_POST['old_pass'];
    $new_pass = $_POST['new_pass'];
    $confirm_pass = $_POST['confirm_pass'];

    if($old_pass && $new_pass && $confirm_pass)
    {
        $userData = CUser::GetByID($USER->GetID())->Fetch();


        $check_old = \Bitrix\Main\Security\Password::equals($userData['PASSWORD'], $old_pass);

        if($check_old)
        {
            $fields = array(
                "PASSWORD"          => $new_pass,
                "CONFIRM_PASSWORD"  => $confirm_pass,
            );

            $user = new CUser;

            $user->Update($USER->GetID(), $fields);

            if(!$user->LAST_ERROR)
            {
                $error['TYPE'] = 'OK';
            }
            else
            {
                $error['TYPE'] = 'ERROR';
                $error['MESSAGE'] .= $user->LAST_ERROR;
            }
        }
        else
        {
            $error['TYPE'] = 'ERROR';
            $error['MESSAGE'] = 'current password incorrect';
        }
    }

    header('Content-type: application/json; charset=utf-8');
    print json_encode($error);
}

