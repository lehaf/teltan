<?php require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use \Bitrix\Main\Type\DateTime;

CModule::IncludeModule('iblock');
$userId = \Bitrix\Main\Engine\CurrentUser::get()->getId();
$arUser = CUser::GetByID($userId)->Fetch();

if($_REQUEST['type'] != 'getData') {
    $boughtRateEntity = GetEntityDataClass(BOUGHT_RATE_HL_ID);
    $user = new CUser;
    if($_REQUEST['success'] == 'Y') {
            $result = $boughtRateEntity::add(array(
                'UF_USER_ID' => intval($userId),
                'UF_TYPE' => $_REQUEST['type'],
                'UF_PARENT_XML' => intval($_REQUEST['idPaket']),
                'UF_DAYS_REMAIN' => intval($_REQUEST['days']),
                'UF_COUNT_REMAIN' => intval($_REQUEST['count']),
                'UF_COUNT_LESS' => 0,
                'UF_DATE_PURCHASE' => new DateTime()
            ));

            if ($_REQUEST['type'] == 'Prop') {
                $fields['UF_COUNT_RENT'] = $arUser['UF_COUNT_RENT'] + intval($_REQUEST['count']);
            }
            if ($_REQUEST['type'] == 'AUTO') {
                $fields['UF_AUTO'] = $arUser['UF_AUTO'] + intval($_REQUEST['count']);
            }
            if ($_REQUEST['type'] == 'FLEA') {
                $fields['UF_ANOUNC'] = $arUser['UF_ANOUNC'] + intval($_REQUEST['count']);
            }
            $user->Update($userId, $fields);

    }else{
        if ($arUser['UF_TCOINS'] >= intval($_REQUEST['data']['price'])) {
            $result = $boughtRateEntity::add(array(
                'UF_USER_ID' => intval($userId),
                'UF_TYPE' => $_REQUEST['data']['type'],
                'UF_PARENT_XML' => intval($_REQUEST['data']['idPaket']),
                'UF_DAYS_REMAIN' => intval($_REQUEST['data']['days']),
                'UF_COUNT_REMAIN' => intval($_REQUEST['data']['count']),
                'UF_COUNT_LESS' => 0,
                'UF_DATE_PURCHASE' => new DateTime()
            ));

            $fields = array(
                'UF_TCOINS' => $arUser['UF_TCOINS'] - (double)$_REQUEST['data']['price']
            );
            if ($_REQUEST['data']['type'] == 'Prop') {
                $fields['UF_COUNT_RENT'] = $arUser['UF_COUNT_RENT'] + intval($_REQUEST['data']['count']);
            }
            if ($_REQUEST['data']['type'] == 'AUTO') {
                $fields['UF_AUTO'] = $arUser['UF_AUTO'] + intval($_REQUEST['data']['count']);
            }
            if ($_REQUEST['data']['type'] == 'FLEA') {
                $fields['UF_ANOUNC'] = $arUser['UF_ANOUNC'] + intval($_REQUEST['data']['count']);
            }
            $user->Update($userId, $fields);
        }
    }
    $entity_data_class = GetEntityDataClass(USER_BUY_HISTORY_HL_ID);
    $entity_data_class::add(array(
        'UF_NAME' => 'buy_pjet_anon',
        'UF_USER_ID' => $userId,
        'UF_DATE_BUY' => date("d.m.Y H:i:s"),

    ));

}else{
    echo $arUser['UF_TCOINS'];
}

if($_REQUEST['success'] == 'Y') {
    LocalRedirect("/personal/wallet/");
}

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>