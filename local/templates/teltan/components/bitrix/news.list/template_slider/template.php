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
?>
<?if(count($arResult["ITEMS"])){?>
    <div class="d-none d-lg-block">
        <div id="carouselExampleInterval" class="carousel slide disable-on-mobile rounded mb-4" data-ride="carousel">
            <div class="carousel-inner">
                <?foreach($arResult["ITEMS"] as $k => $arItem){?>
                    <div class="carousel-item <?=($k == 0) ? 'active' : '';?>">
                        <div class="slide">
                            <?
                            if($arItem['PROPERTIES']['TEXT_BUTTON']['VALUE'] && $arItem['PROPERTIES']['URL_BUTTON']['VALUE']){
                            ?>
                                <a href="<?=$arItem['PROPERTIES']['URL_BUTTON']['VALUE'];?>" class="btn btn-primary btn-slider-link font-weight-bold text-center text-uppercase"><?=$arItem['PROPERTIES']['TEXT_BUTTON']['VALUE'];?></a>
                            <?}?>
                            <img src="<?=$arItem['PREVIEW_PICTURE']['SRC'];?>" class="d-block w-100" alt="">
                        </div>
                    </div>
                <?}?>
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
<?}?>