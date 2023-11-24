<?php require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$userId = \Bitrix\Main\Engine\CurrentUser::get()->getId();
$userInfo = CUser::GetByID($userId)->Fetch();

$keyApi = [
    "api_key" => "2fb4bd6b-8e19-43e3-825c-74b429dc38be",
    "secret_key" => "f8bdd6cb-6793-4738-b436-323ea605439e"
];
$successUrl = $_REQUEST['url'];
unset($_REQUEST['url']);
$count = 0 ;
foreach ($_REQUEST as $key => $value){

        if ($count == 0) {
            $successUrl .= '?' . $key . '=' . $value;
        } else {
            $successUrl .= '&' . $key . '=' . $value;
        }

    $count++;
}

$successUrl .= '&' . 'success' . '=' . 'Y';
if ($_REQUEST['withoutcourse'] == 'Y') {
    $amountPrice = (double)$_REQUEST["price"];
} else {
    CModule::IncludeModule('highloadblock');
   
    $entity_data_class = GetEntityDataClass(EXCHANGE_RATE_HL_ID);
    $exchange = $entity_data_class::getList(array(
        'select' => array('*'),
        'filter' => array('ID'=> 1)
    ))->fetch();
    $needSheck = (double)$_REQUEST['price'];
    $amountPrice = $needSheck * (double)$exchange['UF_VALUE'];
}

$errorUrl = '';
$totalArray = [
    'payment_page_uid' => '573196a5-32ad-4b4a-afbe-4ee81323f6e2',
    'expiry_datetime' => '1',
    'charge_method' => '1',
    'more_info' => 'money_transfer',
    'customer' => [
        'customer_name' => $userInfo['NAME'],
        'email' => $userInfo['EMAIL'],
        'phone' => $userInfo['PHONE'],
        'vat_number' => $userInfo['ID'],
    ],
   'refURL_success' => $_SERVER['HTTP_ORIGIN'].'/'.$successUrl,
  //  'refURL_callback'=> $_SERVER['HTTP_ORIGIN'].'/test4.php',
   'refURL_failure' => $_SERVER['HTTP_ORIGIN'].'/testError.php?failure=Y',
    'amount' =>$amountPrice ,
    'payments' => 1,
    'currency_code' => 'ILS',
    'sendEmailApproval' => false,
    'sendEmailFailure' => false

];

$ch = curl_init();
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