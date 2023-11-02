<?php require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use \Bitrix\Main\Type\DateTime;

$userId = \Bitrix\Main\Engine\CurrentUser::get()->getId();
$arUser = CUser::GetByID($userId)->Fetch();

if ($_REQUEST['type'] !== 'getData') {
    if ($arUser['UF_TCOINS'] >= intval($_REQUEST['price'])) {
        $curDate = new DateTime();
        $boughtRateEntity = GetEntityDataClass(BOUGHT_RATE_HL_ID);
        $result = $boughtRateEntity::add(array(
            'UF_USER_ID' => $userId,
            'UF_TYPE' => $_REQUEST['type'],
            'UF_PARENT_XML' => intval($_REQUEST['idPaket']),
            'UF_COUNT_REMAIN' => intval($_REQUEST['count']),
            'UF_COUNT_LESS' => 0,
            'UF_DATE_PURCHASE' => $curDate,
            'UF_DATE_EXPIRED' => DateTime::createFromTimestamp(strtotime('+ '.$_REQUEST['days'].' days'))
        ));

        $user = new CUser;
        $fields = ['UF_TCOINS' => $arUser['UF_TCOINS'] - (double)$_REQUEST['price']];
        $user->Update($userId, $fields);
        addEntryToUserBuyHistory($_REQUEST['idPaket'],'RATE');
    }
} else {
    echo $arUser['UF_TCOINS'];
}

