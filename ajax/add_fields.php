<?php  require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');

if ($_POST['get_fields'] !== 'y' || empty($_POST['iblockId']) || empty($_POST['sectionId'])) die();

\Bitrix\Main\Loader::includeModule('iblock');
$sectionEntity = \Bitrix\Iblock\Model\Section::compileEntityByIblock($_POST['iblockId']);
$section = $sectionEntity::getList(array(
    "filter" => array(
        "ID" => $_POST['sectionId'],
        "ACTIVE" => "Y",
    ),
    "select" => array("UF_PROPS"),
    'cache' => array(
        'ttl' => 360000, // Время жизни кеша
        'cache_joins' => true // Кешировать ли выборки с JOIN
    ),
))->fetch();

if (!empty($section['UF_PROPS'])) {
    $props = \Bitrix\Iblock\PropertyTable::getList(array(
        'order' => array('SORT' => 'DESC'),
        'select' => array('*'),
        'filter' => array('IBLOCK_ID' => $_POST['iblockId'], 'CODE' => $section['UF_PROPS']),
        'cache' => array(
            'ttl' => 360000, // Время жизни кеша
            'cache_joins' => true // Кешировать ли выборки с JOIN
        ),
    ))->fetchAll();

    if (!empty($props)) {
        $addProps = [];
        $enumPropsId = [];
        foreach ($props as $prop) {
            if ($prop['PROPERTY_TYPE'] === 'L') {
                $enumPropsId[] = $prop['ID'];
            }
            $addProps[$prop['ID']] = $prop;
        }

        if (!empty($enumPropsId)) {
            $enumValues = \Bitrix\Iblock\PropertyEnumerationTable::getList(array(
                'order' => array('SORT' => 'DESC','ID' => 'ASC'),
                'select' => array('*'),
                'filter' => array('PROPERTY_ID' => $enumPropsId),
                'cache' => array(
                    'ttl' => 360000, // Время жизни кеша
                    'cache_joins' => true // Кешировать ли выборки с JOIN
                ),
            ))->fetchAll();

            if (!empty($enumValues)) {
                foreach ($enumValues as $value) {
                    if (!empty($addProps[$value['PROPERTY_ID']])) {
                        $addProps[$value['PROPERTY_ID']]['VALUES'][] = $value;
                    }
                }
            }
        }
    }

    if ($_POST['edit'] === 'y' && !empty($_POST['itemId'])) {
        $iblock = \Bitrix\Iblock\Iblock::wakeUp($_POST['iblockId']);
        $class = $iblock->getEntityDataClass();
        $element = $class::getList(array(
            'select' => array_merge(array('ID'),$section['UF_PROPS']),
            'filter' => array('ID' => $_POST['itemId']),
        ))->fetchObject();

        if (!empty($element)) {
            foreach ($addProps as $propId => &$prop) {
                if ($element->get($prop['CODE']) && $prop['MULTIPLE'] === 'N') {
                    $itemValue = $element->get($prop['CODE'])->getValue();
                    if ($prop['PROPERTY_TYPE'] === 'L') {
                        if (!empty($prop['VALUES'])) {
                            foreach ($prop['VALUES'] as &$val) {
                                if ($val['ID'] == $itemValue) $val['SELECTED'] = true;
                            }
                            unset($val);
                        }
                    } else {
                        $prop['VALUES'] = $itemValue;
                    }
                } else {
                    if ($prop['PROPERTY_TYPE'] === 'L') {
                        if ($element->get($prop['CODE'])) {
                            $allValues = $element->get($prop['CODE'])->getAll();
                            if (!empty($allValues)) {
                                $selectedValues = [];
                                foreach ($allValues as $value) {
                                    $selectedValues[] = $value->getValue();
                                }

                                if (!empty($selectedValues) && !empty($prop['VALUES'])) {
                                    foreach ($prop['VALUES'] as &$val) {
                                        if (in_array($val['ID'],$selectedValues)) $val['SELECTED'] = true;
                                    }
                                    unset($val);
                                }
                            }
                        }
                    }
                }
            }
            unset($prop);
        }
    }
}
?>
<?php if (!empty($addProps)):?>
    <?php foreach ($addProps as $propId => $prop):?>
        <?php switch ($prop['PROPERTY_TYPE']): case 'L':?>
            <?php if ($prop['MULTIPLE'] === 'N'):?>
                <?// radio?>
                <div class="mb-3 mb-lg-4 row flex-column-reverse flex-lg-row additional-prop" data-parent-id="29" style="">
                    <div class="col-12 col-lg-10">
                        <div class="d-flex justify-content-center justify-content-lg-end align-items-center gap-1">
                            <?foreach($prop['VALUES'] as $key => $value):?>
                                <div class="mr-3 form_radio_btn">
                                    <input id="radio-<?= $value['ID'] ?>1"
                                           data-id_prop="<?= $value['PROPERTY_ID'] ?>"
                                           data-id-self="<?= $value['ID'] ?>"
                                           type="radio" name="<?=$prop['CODE']?>1"
                                           <?if ($value['SELECTED'] === true):?>checked<?endif;?>
                                           <?if ($prop['IS_REQUIRED'] === 'Y'):?>data-req="Y"<?endif;?>
                                    >
                                    <label for="radio-<?=$value['ID'] ?>1"><?=$value['VALUE']?></label>
                                </div>
                            <?endforeach;?>
                        </div>
                    </div>
                    <div class="col-12 col-lg-2">
                        <p class="mb-3 m-lg-0 d-flex justify-content-center justify-content-lg-start font-weight-bold">
                            :<?=$prop['IS_REQUIRED'] === 'Y' ? $prop['NAME'].' *': $prop['NAME']?>
                        </p>
                    </div>
                </div>
            <?php else:?>
                <?// checkbox?>
                <div class="mb-3 mb-lg-4 row flex-column-reverse flex-lg-row additional-prop">
                    <div class="col-12 col-lg-10">
                        <div class="d-flex justify-content-center justify-content-lg-end align-items-center gap-1">
                            <?foreach($prop['VALUES'] as $key => $value):?>
                                <div class="mr-2 mb-2 mr-md-4 mb-md-4 form_radio_btn">
                                    <input id="checkbox-<?=$value['ID']?>"
                                           type="checkbox"
                                           name="<?=$value['VALUE']?>"
                                           data-id_prop="<?= $value['PROPERTY_ID'] ?>"
                                           data-id-self="<?= $value['ID'] ?>"
                                           <?if ($value['SELECTED'] === true):?>checked<?endif;?>
                                           <?if ($prop['IS_REQUIRED'] === 'Y'):?>data-req="Y"<?endif;?>
                                    >
                                    <label for="checkbox-<?=$value['ID']?>"><?=$value['VALUE']?></label>
                                </div>
                            <?endforeach;?>
                        </div>
                    </div>
                    <div class="col-12 col-lg-2">
                        <p class="mb-3 m-lg-0 d-flex justify-content-center justify-content-lg-start font-weight-bold">
                            :<?=$prop['IS_REQUIRED'] === 'Y' ? $prop['NAME'].' *': $prop['NAME']?>
                        </p>
                    </div>
                </div>
            <?php endif;?>
            <?php break;?>
            <?php case 'S':?>
                <?// СТрока?>
                    <div class="mb-3 mb-lg-4 row flex-column-reverse flex-lg-row additional-prop" data-parent-id="27" style="">
                        <div class="col-12 col-lg-10">
                            <div class="d-flex flex-wrap justify-content-center justify-content-lg-end">
                                <div class="form-group">
                                    <input id="<?= $prop['ID'] ?>"
                                           data-id_prop="<?= $prop['CODE'] ?>"
                                           class="form-control"
                                           type="text"
                                           placeholder=""
                                           value="<?=$prop['VALUES']?>"
                                           <?if ($prop['IS_REQUIRED'] === 'Y'):?>data-req="Y"<?endif;?>
                                    >
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-2">
                            <p class="mb-3 m-lg-0 d-flex justify-content-center justify-content-lg-start font-weight-bold">
                                :<?=$prop['IS_REQUIRED'] === 'Y' ? $prop['NAME'].' *': $prop['NAME']?>
                            </p>
                        </div>
                    </div>
            <?php break;?>
        <?php endswitch;?>
    <?php endforeach;?>
<?php endif;?>