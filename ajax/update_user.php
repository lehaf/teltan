<?if(!$_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') die();
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

if(isset($_POST) && !empty($_POST) && check_bitrix_sessid()) {

    global $USER;

    $error = array();
    $fields = array();

    $cur_user = getUserInfoByID();

    $user_email = $_POST['userEmail'];
    $user_phone = $_POST['userPhone'];
    $user_name = $_POST['userName'];


    if($user_email && filter_var($user_email, FILTER_VALIDATE_EMAIL))
    {
        $fields['EMAIL'] = $user_email;
        $fields['LOGIN'] = $user_email;

        // Текущий email
        $curEmail = $USER->GetEmail();
        if($curEmail != $user_email)
        {
            $error['TYPE'] = 'ERROR';
            $strError = 'שלחנו הודעה לדואר אלקטרוני שלך כדי לאשר את הפעולה';
            $arEventFields = array(
                "EMAIL"  => $curEmail,
                "URL" => '/personal/edit/?update_email=Y&email='.$user_email.'&str='.md5('54h7ghrt'.$USER->GetID().$user_email),
            );
            CEvent::Send("UPDATE_EMAIL", SITE_ID, $arEventFields);
        }
    }

    if($user_phone)
    {
        $fields['PERSONAL_PHONE'] = $user_phone;

        // Смена номера
        if($cur_user['PERSONAL_PHONE'] != $user_phone)
        {
            $error['TYPE'] = 'POPUP';
            $error['NUMBER'] = $user_phone;

           // $code = randString(4, array("0123456789"));
           // addConfirmCode($code, $cur_user['ID'], 'update_phone');
           // sendSMS('Код для подтверждения телефона: '.$code, $user_phone);
        }
    }


    if($user_name)
        $fields['NAME'] = $user_name;

    if($fields && !$strError && $error['TYPE'] != 'POPUP')
    {
        $user = new CUser;

        $user->Update($USER->GetID(), $fields);
        $strError .= $user->LAST_ERROR;

    }

    $error['MESSAGE'] = $strError;

    header('Content-type: application/json; charset=utf-8');
    print json_encode($error);
}
