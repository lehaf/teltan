<? require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Highloadblock\HighloadBlockTable as HLBT;

CModule::IncludeModule('iblock');
const MY_HL_BLOCK_ID = 28;
CModule::IncludeModule('highloadblock');
$order = array('sort' => 'asc');
$tmp = 'sort';
$rsUsers = CUser::GetList($order, $tmp, false, array("SELECT" => array("UF_COUNT_ITEM_FLEA", 'UF_COUNT_ITEM_AUTO', 'UF_COUNT_ITEM_PROP',
    'UF_DAYS_FLEA_REMAIN', 'UF_DAYS_AUTO_REMAIN', 'UF_DAYS_PROP_REMAIN', 'UF_COUNT_APART', 'UF_COUNT_FLEA', 'UF_COUNT_AUTO')));
while ($eler = $rsUsers->fetch()) {
    ?>

    <?
    if ($eler['UF_DAYS_FLEA_REMAIN'] <= 0) {
        foreach ($eler['UF_COUNT_ITEM_FLEA'] as $arItem) {
            $ell = new CIBlockElement;
            $arLoadProductArray = array(
                "ACTIVE" => "N",
            );
            $PRODUCT_ID = $arItem;
            $res = $ell->Update($PRODUCT_ID, $arLoadProductArray);
            $user = new CUser;
            $arDel = [];
            $fields = array(
                "UF_COUNT_ITEM_FLEA" => $arDel,
                'UF_COUNT_FLEA' => 0,
                'UF_DAYS_FLEA_REMAIN' => 30
            );
            $user->Update($eler['ID'], $fields);
            $strError .= $user->LAST_ERROR;
        }
    } else {
        if ($eler['UF_COUNT_ITEM_FLEA'][0] > 0) {
            $user = new CUser;
            $fields = array(
                "UF_DAYS_FLEA_REMAIN" => --$eler['UF_DAYS_FLEA_REMAIN'],
            );
            $user->Update($eler['ID'], $fields);
            $strError .= $user->LAST_ERROR;
        }
    }
    if ($eler['UF_DAYS_AUTO_REMAIN'] <= 0) {
        foreach ($eler['UF_COUNT_ITEM_AUTO'] as $arItem) {
            $ell = new CIBlockElement;
            $arLoadProductArray = array(
                "ACTIVE" => "N",
            );
            $PRODUCT_ID = $arItem;
            $res = $ell->Update($PRODUCT_ID, $arLoadProductArray);
        }
        $user = new CUser;
        $arDel = [];
        $fields = array(
            "UF_COUNT_ITEM_AUTO" => $arDel,
            'UF_COUNT_AUTO' => 0,
            'UF_DAYS_AUTO_REMAIN' => 30
        );
        $user->Update($eler['ID'], $fields);
        $strError .= $user->LAST_ERROR;
    } else {
        if ($eler['UF_COUNT_ITEM_AUTO'][0] > 0) {
            $user = new CUser;
            $fields = array(
                "UF_DAYS_AUTO_REMAIN" => --$eler['UF_DAYS_AUTO_REMAIN'],
            );
            $user->Update($eler['ID'], $fields);
            $strError .= $user->LAST_ERROR;
        }
    }
    if ($eler['UF_DAYS_PROP_REMAIN'] <= 0) {
        foreach ($eler['UF_COUNT_ITEM_PROP'] as $arItem) {
            $ell = new CIBlockElement;
            $arLoadProductArray = array(
                "ACTIVE" => "N",
            );
            $PRODUCT_ID = $arItem;
            $res = $ell->Update($PRODUCT_ID, $arLoadProductArray);
        }
        $user = new CUser;
        $arDel = [];
        $fields = array(
            "UF_COUNT_ITEM_PROP" => $arDel,
            'UF_COUNT_APART' => 0
        );
        $user->Update($eler['ID'], $fields);
        $strError .= $user->LAST_ERROR;
    } else {
        if ($eler['UF_COUNT_ITEM_AUTO'][0] > 0) {
            $user = new CUser;
            $fields = array(
                "UF_DAYS_PROP_REMAIN" => --$eler['UF_DAYS_PROP_REMAIN'],
            );
            $user->Update($eler['ID'], $fields);
            $strError .= $user->LAST_ERROR;
        }
    }
    $fields = [
        'UF_DAYS_PROP_REMAIN' => --$eler['UF_DAYS_PROP_REMAIN'], 'UF_DAYS_AUTO_REMAIN' => --$eler['UF_DAYS_AUTO_REMAIN'], 'UF_DAYS_FLEA_REMAIN' => --$eler['UF_DAYS_FLEA_REMAIN'],
    ];
    $user->Update($eler['ID'], $fields);
}

$entity_data_class = GetEntityDataClass(MY_HL_BLOCK_ID);
$rsData = $entity_data_class::getList(array(

    'select' => array('*'),
    'filter' => array('!UF_USER_ID' => 0)
));
while ($el = $rsData->fetch()) {

    if ($el['UF_DAYS_REMAIN'] <= 0) {

        foreach ($el['UF_ID_ANONC'] as $arItem) {
            $ell = new CIBlockElement;
            $arLoadProductArray = array(
                "ACTIVE" => "N",
            );
            $PRODUCT_ID = $arItem;
            $res = $ell->Update($PRODUCT_ID, $arLoadProductArray);
        }
        $idForDelete = $el['ID'];
        $entity_data_class = GetEntityDataClass(MY_HL_BLOCK_ID);
        $result = $entity_data_class::delete($idForDelete);
    } else {
        $result = $entity_data_class::update($el['ID'], array(
            'UF_DAYS_REMAIN' => --$el['UF_DAYS_REMAIN'],
        ));
    }
}

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php");
?>