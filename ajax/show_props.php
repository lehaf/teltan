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

<?/*<div class="mb-4 row flex-column-reverse flex-lg-row">
    <div class="col col-lg-10">
        <div class="d-lg-flex justify-content-between auto-ad-step3__colors">
            <input type="radio" class="d-none" name="color" id="gradient">
            <label class="colour-element" for="gradient" style="background: conic-gradient(from 45deg , #ffe600, #ffa200, #f92400, #999999, #e5e5e5, #4fadff, #9f40ff, #926547, #c5172d);"></label>
            <input type="radio" class="d-none" name="color" id="orange">
            <label class="colour-element" for="orange" style="background: #ffe600;"></label>
            <input type="radio" class="d-none" name="color" id="red">
            <label class="colour-element" for="red" style="background: #ffa200;"></label>
            <input type="radio" class="d-none" name="color" id="silver">
            <label class="colour-element" for="silver" style="background: #f92400;"></label>
            <input type="radio" class="d-none" name="color" id="metalic">
            <label class="colour-element" for="metalic" style="background: #999999;"></label>
            <input type="radio" class="d-none" name="color" id="white">
            <label class="colour-element" for="white" style="background: #e5e5e5;"></label>
            <input type="radio" class="d-none" name="color" id="black">
            <label class="colour-element" for="black" style="background: #ffffff;"></label>
            <input type="radio" class="d-none" name="color" id="sky">
            <label class="colour-element" for="sky" style="background: #000000;"></label>
            <input type="radio" class="d-none" name="color" id="blue">
            <label class="colour-element" for="blue" style="background: #4fadff;"></label>
            <input type="radio" class="d-none" name="color" id="purple">
            <label class="colour-element" for="purple" style="background: #102efe;"></label>
            <input type="radio" class="d-none" name="color" id="brown">
            <label class="colour-element" for="brown" style="background: #9f40ff;"></label>
            <input type="radio" class="d-none" name="color" id="crem">
            <label class="colour-element" for="crem" style="background: #926547;"></label>
            <input type="radio" class="d-none" name="color" id="burgundy">
            <label class="colour-element" for="burgundy" style="background: #f1d9b2;"></label>
            <input type="radio" class="d-none" name="color" id="candy">
            <label class="colour-element" for="candy" style="background: #c5172d;"></label>
            <input type="radio" class="d-none" name="color" id="yellow">
            <label class="colour-element" for="yellow" style="background: #efbe60;"></label>
        </div>
    </div>

    <div class="col-12 col-lg-2 d-lg-block">
        <p class="m-0 mb-2 mb-lg-0 font-weight-bold label-name">Colour:</p>
    </div>
</div>

<div class="mb-4 row flex-column-reverse flex-lg-row select-w-100">
    <div class="col col-lg-10">
        <div class="d-flex flex-wrap justify-content-end">
            <div class="form_radio_btn">
                <input id="conditionCustoms" type="checkbox" name="Condition">
                <label for="conditionCustoms">Not cleared by customs </label>
            </div>

            <div class="form_radio_btn">
                <input id="conditionAccident" type="checkbox" name="Condition">
                <label for="conditionAccident">After the accident</label>
            </div>

            <div class="form_radio_btn">
                <input id="conditionMileage" type="checkbox" name="Condition">
                <label for="conditionMileage">With mileage</label>
            </div>

            <div class="form_radio_btn">
                <input id="conditionNew" type="checkbox" name="Condition">
                <label for="conditionNew">New</label>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-2  d-lg-block">
        <p class="m-0 mb-2 mb-lg-0 font-weight-bold label-name">Condition:</p>
    </div>
</div>

<div class="mb-4 row flex-column-reverse flex-lg-row">
    <div class="col col-lg-10">
        <div class="d-flex justify-content-end">
            <div class="form_radio_btn">
                <input id="mileageKm" type="radio" name="Condition">
                <label class="mileage-btn line-height" for="mileageKm">km</label>
            </div>

            <div class="form_radio_btn">
                <input id="mileageMiles" type="radio" name="Condition">
                <label class="mileage-btn line-height" for="mileageMiles">miles</label>
            </div>

            <div class="d-flex form-group">
                <input class="ml-2 form-control" type="text" placeholder="0" required>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-2 d-lg-block">
        <p class="m-0 mb-2 mb-lg-0 font-weight-bold label-name">Mileage:</p>
    </div>
</div>

<div class="mb-4 row flex-column-reverse flex-lg-row">
    <div class="col col-lg-10">
        <div class="d-flex flex-row-reverse justify-content-center justify-content-lg-start flex-wrap">
            <select class="selectpicker" data-style-base="form-control form-control-select" data-style="" name="Multimedia" id="">
                <option value="Audio system">Audio system</option>
            </select>

            <div class="form_radio_btn">
                <input id="multimediaNavigation" type="checkbox" name="Multimedia">
                <label for="multimediaNavigation">Navigation system</label>
            </div>

            <div class="form_radio_btn">
                <input id="multimediaCarPlay" type="checkbox" name="Multimedia">
                <label for="multimediaCarPlay">CarPlay</label>
            </div>

            <div class="form_radio_btn">
                <input id="multimediaAndroid" type="checkbox" name="Multimedia">
                <label for="multimediaAndroid">Android Auto</label>
            </div>

            <div class="form_radio_btn">
                <input id="multimediaBluetooth" type="checkbox" name="Multimedia">
                <label for="multimediaBluetooth">Bluetooth</label>
            </div>

            <div class="form_radio_btn">
                <input id="multimediaAUX" type="checkbox" name="Multimedia">
                <label for="multimediaAUX">AUX</label>
            </div>

            <div class="form_radio_btn">
                <input id="multimedia220V" type="checkbox" name="Multimedia">
                <label for="multimedia220V">220V</label>
            </div>

            <div class="form_radio_btn">
                <input id="multimediaUSB" type="checkbox" name="Multimedia">
                <label for="multimediaUSB">USB</label>
            </div>

            <div class="form_radio_btn">
                <input id="multimedia12V" type="checkbox" name="Multimedia">
                <label for="multimedia12V">12V</label>
            </div>

            <div class="form_radio_btn">
                <input id="multimediaRear" type="checkbox" name="Multimedia">
                <label for="multimediaRear">Rear seat multimedia system</label>
            </div>
        </div>
    </div>

    <div class="mb-2 mb-lg-0 col col-lg-2 d-flex d-lg-block justify-content-end justify-content-lg-center">
        <p class="m-0 font-weight-bold label-name">Multimedia:</p>
    </div>
</div>

<div class="mb-5 row flex-column-reverse flex-lg-row">
    <div class="col col-lg-10">
        <div class="d-flex flex-row-reverse justify-content-center justify-content-lg-start flex-wrap">
            <select class="selectpicker" data-style-base="form-control form-control-select" data-style="" name="Comfort" id="">
                <option value="Air conditioning">Air conditioning</option>
            </select>

            <select class="selectpicker" data-style-base="form-control form-control-select" data-style="" name="Comfort" id="">
                <option value="Steering wheel adjustment">Steering wheel adjustment</option>
            </select>

            <select class="selectpicker" data-style-base="form-control form-control-select" data-style="" name="Comfort" id="">
                <option value="Suspension">Suspension</option>
            </select>

            <select class="selectpicker" data-style-base="form-control form-control-select" data-style="" name="Comfort" id="">
                <option value="Camera">Camera</option>
            </select>

            <select class="selectpicker" data-style-base="form-control form-control-select" data-style="" name="Comfort" id="">
                <option value="Power windows">Power windows</option>
            </select>

            <select class="selectpicker" data-style-base="form-control form-control-select" data-style="" name="Comfort" id="">
                <option value="Parktronic">Parktronic</option>
            </select>

            <div class="form_radio_btn">
                <input id="comfortOnBoardComputer" type="checkbox" name="Comfort">
                <label for="comfortOnBoardComputer">On-board computer</label>
            </div>

            <div class="form_radio_btn">
                <input id="comfortTrunk" type="checkbox" name="Comfort">
                <label for="comfortTrunk">Trunk lid motor</label>
            </div>

            <div class="form_radio_btn">
                <input id="comfortRemoteEngineStart" type="checkbox" name="Comfort">
                <label for="comfortRemoteEngineStart">Remote engine start</label>
            </div>

            <div class="form_radio_btn">
                <input id="comfortDigitalInstrumentPanel" type="checkbox" name="Comfort">
                <label for="comfortDigitalInstrumentPanel">Digital instrument panel</label>
            </div>

            <div class="form_radio_btn">
                <input id="comfortMultifunction" type="checkbox" name="Comfort">
                <label for="comfortMultifunction">Multifunction</label>
            </div>

            <div class="form_radio_btn">
                <input id="comfortKeylessAccess" type="checkbox" name="Comfort">
                <label for="comfortKeylessAccess">Keyless access</label>
            </div>

            <div class="form_radio_btn">
                <input id="comfortHeater" type="checkbox" name="Comfort">
                <label for="comfortHeater">Heater</label>
            </div>

            <div class="form_radio_btn">
                <input id="comfortActiveParkingAssistance" type="checkbox" name="Comfort">
                <label for="comfortActiveParkingAssistance">Active parking assistance system</label>
            </div>
        </div>
    </div>

    <div class="mb-4 mb-lg-0 col col-lg-2 d-flex d-lg-block justify-content-end justify-content-lg-center">
        <p class="m-0 font-weight-bold label-name">Comfort:</p>
    </div>
</div>
*/?>


<div class="d-flex align-items-center justify-content-center">
    <button type="submit" class="btn btn-primary text-uppercase font-weight-bold p-3">
        Submit your add
    </button>
</div>
<?}?>