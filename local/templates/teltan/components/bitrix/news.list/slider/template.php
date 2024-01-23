<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
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

$pixel = 'data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==';
$this->addExternalJs(SITE_TEMPLATE_PATH.'/js/image-defer.min.js');
?>
<?php if(!empty($arResult["ITEMS"])):?>
    <div class="d-none d-lg-block">
        <div id="carouselExampleInterval" class="carousel slide disable-on-mobile rounded mb-4" data-ride="carousel">
            <div class="carousel-inner">
                <?php foreach($arResult["ITEMS"] as $k => $item):
                    $this->AddEditAction($item['ID'], $item['EDIT_LINK'], $item["EDIT_LINK_TEXT"]);
                    $this->AddDeleteAction($item['ID'], $item['DELETE_LINK'], $item["DELETE_LINK_TEXT"], array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                    ?>
                    <div id="<?=$this->GetEditAreaID($item['ID'])?>" class="carousel-item <?=($k == 0) ? 'active' : ''?>">
                        <div class="slide">
                            <?php if($item['PROPERTIES']['TEXT_BUTTON']['VALUE'] && $item['PROPERTIES']['URL_BUTTON']['VALUE']):?>
                                <a href="<?=$item['PROPERTIES']['URL_BUTTON']['VALUE'];?>" 
                                   class="btn btn-primary btn-slider-link font-weight-bold text-center text-uppercase"
                                >
                                    <?=$item['PROPERTIES']['TEXT_BUTTON']['VALUE'];?>
                                </a>
                            <?php endif;?>
                            <img class="d-block w-100"
                                 src="<?=$k > 0 ? $pixel : $item['PREVIEW_PICTURE']['SRC']?>"
                                 data-defer-src="<?=$item['PREVIEW_PICTURE']['SRC']?>"
                                 alt="<?=$item['NAME']?>"
                                 title="<?=$item['NAME']?>"
                            >
                        </div>
                    </div>
                <?php endforeach;?>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleInterval" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleInterval" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
<?php endif;?>