<?php require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$userId = \Bitrix\Main\Engine\CurrentUser::get()->getId();
$arUser = CUser::GetByID($userId)->Fetch();
$exchangeClass = GetEntityDataClass(EXCHANGE_RATE_HL_ID);
$exchanghe = $exchangeClass::getList(array(
    'select' => array('*'),
    'filter' => array('ID'=> 1)
))->fetch();

$user = new CUser;
$fields = array('UF_COUNT_SHEK' => (double)$arUser['UF_COUNT_SHEK'] + (double)$_REQUEST['shekel']);
$user->Update($userId, $fields);
addEntryToUserBuyHistory(0,'SHEKEL');
LocalRedirect("/personal/wallet/");

