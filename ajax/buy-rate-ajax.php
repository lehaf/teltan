<?require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Highloadblock\HighloadBlockTable as HLBT;
CModule::IncludeModule('iblock');

$rsUser = CUser::GetByID($USER->GetID());
$arUser = $rsUser->Fetch();

if($_REQUEST['type'] != 'getData') {
    if($_REQUEST['success'] == 'Y') {
            $entity_data_class = GetEntityDataClass(28);
            $result = $entity_data_class::add(array(
                'UF_USER_ID' => intval($USER->GetID()),
                'UF_TYPE' => $_REQUEST['type'],
                'UF_PARENT_XML' => intval($_REQUEST['idPaket']),
                'UF_DAYS_REMAIN' => intval($_REQUEST['days']),
                'UF_COUNT_REMAIN' => intval($_REQUEST['count'])
            ));
            $user = new CUser;
            if ($_REQUEST['type'] == 'Prop') {
                $fields['UF_COUNT_RENT'] = $arUser['UF_COUNT_RENT'] + intval($_REQUEST['count']);
            }
            if ($_REQUEST['type'] == 'AUTO') {
                $fields['UF_AUTO'] = $arUser['UF_AUTO'] + intval($_REQUEST['count']);
            }
            if ($_REQUEST['type'] == 'FLEA') {
                $fields['UF_ANOUNC'] = $arUser['UF_ANOUNC'] + intval($_REQUEST['count']);
            }
            $user->Update($USER->GetID(), $fields);


    }else{
        if ($arUser['UF_TCOINS'] >= intval($_REQUEST['data']['price'])) {
            $entity_data_class = GetEntityDataClass(28);
            $result = $entity_data_class::add(array(
                'UF_USER_ID' => intval($USER->GetID()),
                'UF_TYPE' => $_REQUEST['data']['type'],
                'UF_PARENT_XML' => intval($_REQUEST['data']['idPaket']),
                'UF_DAYS_REMAIN' => intval($_REQUEST['data']['days']),
                'UF_COUNT_REMAIN' => intval($_REQUEST['data']['count'])
            ));
            $user = new CUser;
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
            $user->Update($USER->GetID(), $fields);
        }
    }
    $entity_data_class = GetEntityDataClass(30);
    $result = $entity_data_class::add(array(
        'UF_NAME' => 'buy_pjet_anon',
        'UF_USER_ID'         => (int)$USER->GetID(),
        'UF_DATE_BUY' => date("d.m.Y H:i:s"),

    ));
}else{
    echo $arUser['UF_TCOINS'];
}


if($_REQUEST['success'] == 'Y') {
    LocalRedirect("/personal/wallet/");
}
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>