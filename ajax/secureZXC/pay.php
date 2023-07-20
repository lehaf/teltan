<?require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Highloadblock\HighloadBlockTable as HLBT;

global $USER;

$keyApi = ["api_key" => "2fb4bd6b-8e19-43e3-825c-74b429dc38be", "secret_key" => "f8bdd6cb-6793-4738-b436-323ea605439e"];
$ch = curl_init();
$sucsessUrl = $_REQUEST['url'];
$count = 0 ;
unset($_REQUEST['url']);
foreach ($_REQUEST as $key => $value){

        if ($count == 0) {
            $sucsessUrl .= '?' . $key . '=' . $value;
        } else {
            $sucsessUrl .= '&' . $key . '=' . $value;
        }

    $count++;
}
$sucsessUrl .= '&' . 'success' . '=' . 'Y';
if($_REQUEST['withoutcourse'] == 'Y'){
    $amountPrice = (double)$_REQUEST["price"];
}else{
    CModule::IncludeModule('highloadblock');
   
    $entity_data_class = GetEntityDataClass(29);
    $rsexData = $entity_data_class::getList(array(
        'select' => array('*'),
        'filter' => array('ID'=> 1)
    ));
    $exchanghe = $rsexData->fetch();
    $NeedShek = (double)$_REQUEST['price'];
    $amountPrice = $NeedShek * (double)$exchanghe['UF_VALUE'];
}
$errorUrl = '';
$totalArray = [
    'payment_page_uid' => '573196a5-32ad-4b4a-afbe-4ee81323f6e2',
    'expiry_datetime' => '1',
    'charge_method' => '1',
    'more_info' => 'buy goods',
    'customer' => [
        'customer_name' => 'USERName',
        'email' => 'test@mail.ru',
        'phone' => '0509111111',
        'vat_number' => '036534683'
    ],
   'refURL_success' => $sucsessUrl,
  //  'refURL_callback'=> 'http://650739-cm41399.tmweb.ru/test4.php',
   'refURL_failure' => 'http://650739-cm41399.tmweb.ru/test4.php?failure=Y',
    'amount' =>$amountPrice ,
    'payments' => 1,
    'currency_code' => 'ILS',
    'sendEmailApproval' => false,
    'sendEmailFailure' => false

];
curl_setopt($ch, CURLOPT_URL, "https://restapidev.payplus.co.il/api/v1.0/PaymentPages/generateLink");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);

curl_setopt($ch, CURLOPT_POST, TRUE);

curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($totalArray));

curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "Authorization:" . json_encode($keyApi)
    ]
);

$response = curl_exec($ch);
curl_close($ch);

echo($response);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>