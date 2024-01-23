<?if(!$_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') die();
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

if($_POST['section'] && (int)$_POST['section'] > 0)
{
// Получаем ID свойст для показа
$propsIDs = getHighloadInfo(8, array(
        'select' => array('*'),
        'filter' => array('UF_ID_SECTION' => (int)$_POST['section']),
    )
)[0];

if($propsIDs['UF_ID_PROPS'])
{
    $property = array();

    foreach($propsIDs['UF_ID_PROPS'] as $prop)
    {
        $properties = CIBlockProperty::GetList(Array("sort"=>"asc", "name"=>"asc"), Array("ID"=>$prop));
        while ($prop_fields = $properties->GetNext())
        {
            if($prop_fields['PROPERTY_TYPE'] == 'L')
            {
                $property[$prop_fields['CODE']]['NAME'] = $prop_fields['NAME'];
                $property[$prop_fields['CODE']]['TYPE'] = $prop_fields['PROPERTY_TYPE'];
                $property[$prop_fields['CODE']]['CODE'] = $prop_fields['CODE'];
                $property[$prop_fields['CODE']]['ID'] = $prop_fields['ID'];
                $property[$prop_fields['CODE']]['MULTIPLE'] = $prop_fields['MULTIPLE'];
                // Получаем значения списка
                $db_enum_list = CIBlockProperty::GetPropertyEnum($prop_fields['CODE'], array('ID' => 'ASC'));
                while($ar_enum_list = $db_enum_list->GetNext())
                {
                    $property[$prop_fields['CODE']]['VALUES'][] = $ar_enum_list;
                }
            }
            if($prop_fields['PROPERTY_TYPE'] == 'S')
            {
                $property[$prop_fields['CODE']]['NAME'] = $prop_fields['NAME'];
                $property[$prop_fields['CODE']]['TYPE'] = $prop_fields['PROPERTY_TYPE'];
                $property[$prop_fields['CODE']]['CODE'] = $prop_fields['CODE'];
                $property[$prop_fields['CODE']]['ID'] = $prop_fields['ID'];
            }
        }
    }

}
//print_r($property);
?>


<h2 class="mb-4 d-flex justify-content-center align-items-center section-title">Детальное описание</h2>

    <?
    foreach($property as $ItemProp)
    {
        if($ItemProp['TYPE'] == 'L')
        {?>
            <div class="mb-4 row flex-column-reverse flex-lg-row select-w-100">
                <div class="col col-lg-10">
                    <div class="d-flex flex-wrap justify-content-end">
                        <?foreach($ItemProp['VALUES'] as $val){?>
                            <div class="form_radio_btn">
                                <input id="<?=$ItemProp['CODE'].'_'.$val['ID'];?>" value="<?=$val['ID'];?>" type="<?=($ItemProp['MULTIPLE'] == 'Y') ? 'checkbox' : 'radio';?>" name="<?=$ItemProp['CODE'];?>">
                                <label for="<?=$ItemProp['CODE'].'_'.$val['ID'];?>"><?=$val['VALUE'];?></label>
                            </div>
                        <?}?>
                    </div>
                </div>

                <div class="col-12 col-lg-2  d-lg-block">
                    <p class="m-0 mb-2 mb-lg-0 font-weight-bold label-name"><?=$ItemProp['NAME'];?>:</p>
                </div>
            </div>
        <?}
        if($ItemProp['TYPE'] == 'S')
        {?>
            <div class="mb-4 row flex-column-reverse flex-lg-row select-w-100">
                <div class="col col-lg-10">
                    <div class="d-flex flex-wrap justify-content-end">
                        <div class="d-flex form-group">
                            <input class="ml-2 form-control" type="text" value="" name="<?=$ItemProp['CODE'];?>">
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-2  d-lg-block">
                    <p class="m-0 mb-2 mb-lg-0 font-weight-bold label-name"><?=$ItemProp['NAME'];?>:</p>
                </div>
            </div>
        <?}
        ?>



    <?}
    ?>


<div class="d-flex align-items-center justify-content-center">
    <button type="submit" class="btn btn-primary text-uppercase font-weight-bold p-3">
        Submit your add
    </button>
</div>
<?}?>