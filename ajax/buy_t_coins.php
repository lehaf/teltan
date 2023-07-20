<?require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Highloadblock\HighloadBlockTable as HLBT;
CModule::IncludeModule('highloadblock');

$entity_data_class = GetEntityDataClass(29);
$rsexData = $entity_data_class::getList(array(
    'select' => array('*'),
    'filter' => array('ID'=> 1)
));
$exchanghe = $rsexData->fetch();
$rsUser = CUser::GetByID($USER->GetID());
$arUser = $rsUser->Fetch();


if((double)$arUser['UF_COUNT_SHEK'] >= (double)$_REQUEST['shekel']){

    $NeedShek = (int)$_REQUEST['shekel'];
    $resultTcoins = $NeedShek / (double)$exchanghe['UF_VALUE'];

    $user = new CUser;
    $fields = array(
        'UF_TCOINS' => (double)$arUser['UF_TCOINS'] + $resultTcoins,
        'UF_COUNT_SHEK' => (double)$arUser['UF_COUNT_SHEK'] - (double)$_REQUEST['shekel']
        );

    $user->Update($USER->GetID(), $fields);
    echo 'ok';
    $entity_data_class = GetEntityDataClass(30);
    $result = $entity_data_class::add(array(
        'UF_NAME' => 'buy_t_coins',
        'UF_USER_ID'         => (int)$USER->GetID(),
        'UF_DATE_BUY' => date("d.m.Y H:i:s"),

    ));
}
else{
    echo 'not enought schekels';
}
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>