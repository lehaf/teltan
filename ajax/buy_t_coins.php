<?php require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$userId = \Bitrix\Main\Engine\CurrentUser::get()->getId();
$arUser = CUser::GetByID($userId)->Fetch();

if ((double)$arUser['UF_COUNT_SHEK'] >= (double)$_REQUEST['shekel']){

    $exchangeClass = GetEntityDataClass(EXCHANGE_RATE_HL_ID);
    $exchange = $exchangeClass::getList(array(
        'select' => array('*')
    ))->fetch();

    $shekels = $_REQUEST['shekel'];
    $resultTCoins = $shekels / (double)$exchange['UF_VALUE'];

    $user = new CUser;
    $fields = [
        'UF_TCOINS' => (double)$arUser['UF_TCOINS'] + $resultTCoins,
        'UF_COUNT_SHEK' => (double)$arUser['UF_COUNT_SHEK'] - (double)$_REQUEST['shekel']
    ];
    $user->Update($userId, $fields);
    addEntryToUserBuyHistory(0,'EXCHANGE');

    echo 'ok';
} else {
    echo 'not enought schekels';
}
