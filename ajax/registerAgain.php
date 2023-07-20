<? if (!$_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') die();
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Main\UserTable;

$user = UserTable::getList([
    'select' => [
        'ID'
    ],
    'filter' => [
        'EMAIL' => $_POST['userEmail']
    ]
])->fetch();

echo $user['ID'];

//old
$cUser = $USER::GetList(
    $by="ID",
    $order="desc",
    [
        'EMAIL' => $_POST['userEmail']
    ],
    [
        'SELECT' => [
            'ID'
        ]
    ]
)->fetch();

echo $cUser['ID'];
if (isset($_POST) && !empty($_POST)) {

        $error = array('OK' => 'Y', "ID_USER" => $cUser['ID']);

        // Создаем код для проверки
        addConfirmCode(randString(4, array("0123456789")), $cUser['ID'], 'register');
        // Отправляем смс
        $code = getConfirmCode($cUser['ID'], 'register');
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


    header('Content-type: application/json; charset=utf-8');
    print json_encode($error);
}
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php");
?>