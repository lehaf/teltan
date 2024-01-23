<? if (!$_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') die();
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

if (isset($_POST) && !empty($_POST)) {

    global $USER;

    $error = array();

    $phone = $_POST['phone'];
    $userEmail = $_POST['userEmail'];
    $name = $_POST['name'];
    $userPasword = $_POST['userPasword'];
    $confirmUserPassword = $_POST['confirmUserPassword'];

    $user = new CUser;
    $arFields = array(
        "NAME" => $name,
        "EMAIL" => $userEmail,
        "LOGIN" => $userEmail,
        "ACTIVE" => "N",
        "PASSWORD" => $userPasword,
        "CONFIRM_PASSWORD" => $confirmUserPassword,
        "PERSONAL_PHONE" => $phone
    );

    $IDUser = $user->Add($arFields);

    if ($IDUser) {
        $error = array('OK' => 'Y', "ID_USER" => $IDUser);

        // Создаем код для проверки
        addConfirmCode(randString(4, array("0123456789")), $IDUser, 'register');
        // Отправляем смс
        $code = getConfirmCode($IDUser, 'register');
        $url = "https://slng5.com/Api/SendSmsJsonBody.ashx";
        $msg_body = addslashes("THIS IS A TEST MESSAGE FROM SLNG");
        $json = '{
 "Username": "tetl.c.il01@gmail.com",
 "Password": "8ff439fa-58c2-4ed0-82fc-44fc55232682",
 "MsgName": "YOUR CODE",
 "MsgBody": "THIS IS A CODE ' . $code . '",
 "FromMobile": "0533028865",
 "DeliveryAckUrl": null,
 "Mobiles": [ { "Mobile": "' . preg_replace("/[^0-9]/", '', $_REQUEST['phone']) . '"}]
 }';
//-----------------------------------------------
        $CR = curl_init();
        //print_r($CR);
        curl_setopt($CR, CURLOPT_URL, $url);
        curl_setopt($CR, CURLOPT_POST, 1);
        curl_setopt($CR, CURLOPT_FAILONERROR, true);
        curl_setopt($CR, CURLOPT_POSTFIELDS, $json);
        curl_setopt($CR, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($CR, CURLOPT_HTTPHEADER, array("charset=utf-8"));
//-----------------------------------------------
        $result = curl_exec($CR);
    //    $error = curl_error($CR);
//$response = new SimpleXMLElement($result);
        $response = json_decode(urldecode($result));
        $error['sms_resp'] = $response;
    } else {
        $error['TYPE'] = 'ERROR';
        $error['MESSAGE'] = $user->LAST_ERROR;
        
    }

    header('Content-type: application/json; charset=utf-8');
    print json_encode($error);
}
