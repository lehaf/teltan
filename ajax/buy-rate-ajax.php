<?php require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use \Bitrix\Main\Type\DateTime;

CModule::IncludeModule('iblock');
$userId = \Bitrix\Main\Engine\CurrentUser::get()->getId();
$arUser = CUser::GetByID($userId)->Fetch();

if ($_REQUEST['type'] !== 'getData') {
    $boughtRateEntity = GetEntityDataClass(BOUGHT_RATE_HL_ID);
    $rateInfo = getRateInfoById($_REQUEST['idPaket']);
    $userPaidAdsProp = [
        'AUTO' => 'UF_AVAILABLE_AUTO',
        'PROPERTY' => 'UF_AVAILABLE_PROPERTY',
        'FLEA' => 'UF_AVAILABLE_FLEA',
    ];
    $user = new CUser;

    if ($arUser['UF_TCOINS'] >= intval($_REQUEST['price'])) {
        $result = $boughtRateEntity::add(array(
            'UF_USER_ID' => $userId,
            'UF_TYPE' => $_REQUEST['type'],
            'UF_PARENT_XML' => intval($_REQUEST['idPaket']),
            'UF_COUNT_REMAIN' => intval($_REQUEST['count']),
            'UF_COUNT_LESS' => 0,
            'UF_DATE_PURCHASE' => new DateTime(),
            'UF_DATE_EXPIRED' => DateTime::createFromTimestamp(strtotime('+ '.$_REQUEST['days'].' days'))
        ));

        $fields = array(
            'UF_TCOINS' => $arUser['UF_TCOINS'] - (double)$_REQUEST['price'],
            $userPaidAdsProp[$_REQUEST['type']] => $arUser[$userPaidAdsProp[$_REQUEST['type']]] + $_REQUEST['count']
        );

        $user->Update($userId, $fields);
    }

    $userHistoryClass = GetEntityDataClass(USER_BUY_HISTORY_HL_ID);
    $userHistoryClass::add(array(
        'UF_NAME' => 'buy_pjet_anon',
        'UF_USER_ID' => $userId,
        'UF_DATE_BUY' => date("d.m.Y H:i:s"),

    ));

} else {
    echo $arUser['UF_TCOINS'];
}

