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


    $user = new CUser;
    $fields = array(

        'UF_COUNT_SHEK' => (double)$arUser['UF_COUNT_SHEK'] + (double)$_REQUEST['shekel']
    );
define("LOG_FILENAME", $_SERVER["DOCUMENT_ROOT"]."/logdefine.txt");
AddMessage2Log($fields);

    $user->Update($USER->GetID(), $fields);
    $entity_data_class = GetEntityDataClass(30);
    $result = $entity_data_class::add(array(
        'UF_NAME' => 'buy_shekel',
        'UF_USER_ID'         => (int)$USER->GetID(),
        'UF_DATE_BUY' => date("d.m.Y H:i:s"),

    ));
    LocalRedirect("/personal/wallet/");

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>