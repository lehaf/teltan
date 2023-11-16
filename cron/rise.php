<?require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Highloadblock\HighloadBlockTable as HLBT;
CModule::IncludeModule('iblock');
const MY_HL_BLOCK_ID = 26;
        CModule::IncludeModule('highloadblock');
        function GetEntityDataClass($HlBlockId) {
            if (empty($HlBlockId) || $HlBlockId < 1)
            {
                return false;
            }
            $hlblock = HLBT::getById($HlBlockId)->fetch();
            $entity = HLBT::compileEntity($hlblock);
            $entity_data_class = $entity->getDataClass();
            return $entity_data_class;
        }
$entity_data_class = GetEntityDataClass(MY_HL_BLOCK_ID);
$rsData = $entity_data_class::getList(array(

    'select' => array('*'),
    'filter' => array('!UF_DAYS'=>0)
));
while($el = $rsData->fetch()){
    print_r($el);
    $db_props = CIBlockElement::GetProperty($el['UF_I_BLOCK'], $el['UF_ITEM'], array("sort" => "asc"), Array("CODE"=>"COUNT_RAISE"));
    if($ar_props = $db_props->Fetch())
        $COUNT_RAISE = $ar_props["VALUE"];
    CIBlockElement::SetPropertyValueCode($el['UF_ITEM'], "COUNT_RAISE",  $COUNT_RAISE += $el['UF_COUNT']);
    $result = $entity_data_class::update($el['ID'], array(
        'UF_DAYS'         => --$el['UF_DAYS'],
    ));

}
