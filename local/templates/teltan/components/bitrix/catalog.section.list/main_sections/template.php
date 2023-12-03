<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Localization\Loc;

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
?>
<?php if (!empty($arResult['SECTIONS'])):?>
    <div id="accordion" class="accordion-main">
        <div class="accordion-main__inner">
            <?php foreach ($arResult['SECTIONS'] as $key => $sectionsRow):?>
               <div class="row accordion-main__row">
                    <?php foreach ($sectionsRow as $section) :
                        $this->AddEditAction($section['ID'], $section['EDIT_LINK'], $section["EDIT_LINK_TEXT"]);
                        $this->AddDeleteAction($section['ID'], $section['DELETE_LINK'], $section["DELETE_LINK_TEXT"], array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                    ?>
                        <div id="<?=$this->GetEditAreaID($section['ID'])?>" class="col-3 mb-4 accordion-main__btn">
                            <a href="<?=$section['SECTION_PAGE_URL']?>"
                               style="background-image: url('<?=$section['PICTURE']['src'];?>');<?=($section['UF_FON']) ? ' background-color: '.$section['UF_FON'].' !important;' : '';?>"
                               class="card h-100"
                               data-toggle="collapse"
                               <?php if (!empty($section['UF_URL'])):?>
                                    onclick="location.href = '<?=$section['SECTION_PAGE_URL']?>'"
                               <?php else:?>
                                    data-target="#<?='subsections_'.$section['ID'];?>"
                               <?php endif;?>
                            >
                                <div class="card-body">
                                    <h5 class="card-title font-weight-bold text-white"><?=$section["NAME"]?></h5>
                                </div>
                            </a>
                        </div>
                    <?php endforeach;?>
                </div>
                <div class="row">
                    <?php foreach ($sectionsRow as $section):?>
                        <div class="col-12 collapse collapse-menu-on-drop" id="<?='subsections_'.$section['ID'];?>" data-parent="#accordion">
                            <div class="mb-4 p-4 card">
                                <h5 class="pb-4 mb-4 border-bottom font-weight-bold text-right"><?=Loc::getMessage('SEE_ALL').' '.$section['NAME']?></h5>
                                <div class="d-flex flex-column flex-lg-row-reverse">
                                    <ul class="ml-5 list-unstyled text-right list-wrap">
                                        <?php foreach ($section['ITEMS'] as $g => $subsection):
                                            $this->AddEditAction($subsection['ID'], $subsection['EDIT_LINK'], $subsection["EDIT_LINK_TEXT"]);
                                            $this->AddDeleteAction($subsection['ID'], $subsection['DELETE_LINK'], $subsection["DELETE_LINK_TEXT"], array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                                            ?>
                                            <li id="<?=$this->GetEditAreaID($subsection['ID'])?>">
                                                <a href="<?=$subsection['SECTION_PAGE_URL'];?>"><?=$subsection['NAME'];?></a>
                                            </li>
                                        <?php endforeach;?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach;?>
        </div>
    </div>
<?php endif;?>