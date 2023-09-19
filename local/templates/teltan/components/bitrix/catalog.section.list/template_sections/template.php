<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
use Bitrix\Main\Localization\Loc;
?>

<div id="accordion" class="accordion-main">
    <div class="accordion-main__inner">
        <div class="row accordion-main__row">
            <?
            $i = 0;
            $subsection = array();
            $sectionName = '';
            foreach ($arResult['SECTIONS'] as $arSection)
            {


                switch (LANGUAGE_ID){
                    case 'en':
                        $arSection['NAME'] = $arSection['UF_NAME_EN'];
                        $arSection['~NAME'] = $arSection['~UF_NAME_EN'];
                        break;
                    case 'he':
                        $arSection['NAME'] = $arSection['UF_NAME_HEB'];
                        $arSection['~NAME'] = $arSection['~UF_NAME_HEB'];
                        break;
                }
            $arSection['NAME'] = '<a href="' . $arSection['SECTION_PAGE_URL'] . '"> ' . $arSection['~NAME'] . '</a>';

                if(!$arSection['IBLOCK_SECTION_ID'])
                {
                    $sectionName = preg_replace('/<br[^>]*>/', '', $arSection['~NAME']);
            $sectionName2 = preg_replace('/<br[^>]*>/', '', $arSection['NAME']);
                    if($i !== 0 && ($i % 4 == 0))

                    {?>
                        </div>
                        <div class="row">

                            <?
                            foreach ($subsection as $j => $arSection2)
                            {



                                ?>

                                <div class="col-12 collapse collapse-menu-on-drop" id="subcat_<?=$j;?>" data-parent="#accordion">
                                    <div class="mb-4 p-4 card">
                                        <h5 class="pb-4 mb-4 border-bottom font-weight-bold text-right"><?=Loc::getMessage('SEE_ALL');?><?=$arSection2['NAME']?> </h5>
                                        <div class="d-flex flex-column flex-lg-row-reverse">
                                            <ul class="ml-5 list-unstyled text-right list-wrap">
                                                <?foreach ($arSection2['ITEMS'] as $g => $item){
                                                    switch (LANGUAGE_ID){
                                                        case 'en':
                                                            $item['NAME'] = $item['UF_NAME_EN'];
                                                            $item['~NAME'] = $item['~UF_NAME_EN'];
                                                            break;
                                                        case 'he':
                                                            $item['NAME'] = $item['UF_NAME_HEB'];
                                                            $item['~NAME'] = $item['~UF_NAME_HEB'];
                                                            break;
                                                    }

                                                    if($g !== 0 && ($g % 5) == 0)
                                                        print '</ul><ul class="ml-5 list-unstyled text-right list-wrap">';
                                                    ?>
                                                    <li><a href="<?=$item['SECTION_PAGE_URL'];?>"><?=$item['NAME'];?></a></li>
                                                <?}?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <?
                            }
                            unset($subsection);
                            ?>
                        </div>
                        <div class="row accordion-main__row">
                    <?}
                    ?>
							<div<? if($arSection['UF_URL'] != null && $arSection['UF_URL'] != 0){?> onclick="window.location.href = '<? if($arSection['UF_URL'] != null){echo $arSection['SECTION_PAGE_URL'];} ?>'"<?}?> class="col-3 mb-4 accordion-main__btn">
                        <a href="<?
                        if($arSection['UF_URL'] != null){
                            echo $arSection['SECTION_PAGE_URL'];
                        }
                        ?>" style="background-image: url('<?=$arSection['PICTURE']['SRC'];?>');<?=($arSection['UF_FON']) ? ' background-color: '.$arSection['UF_FON'].' !important;' : '';?>" class="card h-100" id="<?=$arSection['UF_NAME_ID_FOR_HTML'];?>" data-toggle="collapse" data-target="#subcat_<?=$arSection['ID'];?>">
                            <div class="card-body">
                                <h5 class="card-title font-weight-bold text-white"><? echo "{$arSection["~NAME"]}";?>  </h5>

                            </div>
                        </a>
                    </div>
                    <?
                    $i++;
                }
                else
                {
                    $subsection[$arSection['IBLOCK_SECTION_ID']]['ITEMS'][] = $arSection;
                    $subsection[$arSection['IBLOCK_SECTION_ID']]['NAME'] = $sectionName2;
                }
            }

            if($subsection)
            {?>
                        </div>
                <div class="row">
                    <?
                    foreach ($subsection as $j => $arSection2)
                    {
                        ?>
                        <div class="col-12 collapse collapse-menu-on-drop" id="subcat_<?=$j;?>" data-parent="#accordion">
                            <div class="mb-4 p-4 card">
                                <h5 class="pb-4 mb-4 border-bottom font-weight-bold text-right"><?=Loc::getMessage('SEE_ALL');?> <?=$arSection2['NAME']?></h5>
                                <div class="d-flex flex-column flex-lg-row-reverse">
                                    <ul class="ml-5 list-unstyled text-right list-wrap">
                                        <?foreach ($arSection2['ITEMS'] as $g => $item){
                                            if($g !== 0 && ($g % 5) == 0)
                                                print '</ul><ul class="ml-5 list-unstyled text-right list-wrap">';
                                            ?>
                                            <li><a href="<?=$item['SECTION_PAGE_URL'];?>"><?=$item['NAME'];?></a></li>
                                        <?}?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <?
                    }
                    unset($subsection);
                    ?>
                </div>
            <?}
            ?>
        </div>

    </div>
</div>