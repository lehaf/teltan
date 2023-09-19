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

if(!$arResult["NavShowAlways"])
{
	if ($arResult["NavRecordCount"] == 0 || ($arResult["NavPageCount"] == 1 && $arResult["NavShowAll"] == false))
		return;
}

$strNavQueryString = ($arResult["NavQueryString"] != "" ? $arResult["NavQueryString"]."&amp;" : "");
$strNavQueryStringFull = ($arResult["NavQueryString"] != "" ? "?".$arResult["NavQueryString"] : "");

?>
<div class="col-12 col-xl-6 justify-content-center">
    <nav class="mb-4 mb-xl-0 justify-content-between justify-content-md-center pagination" aria-label="">

        <?if($arResult["NavPageNomer"] < $arResult["NavPageCount"]):?>


            <a class="prev" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>">
                <img src="<?=SITE_TEMPLATE_PATH;?>/assets/paginaton-arrow.svg" alt="">
            </a>
            <div class="mx-3 dots 2">
                <span></span>
                <span></span>
                <span></span>

            </div>
        <?endif?>
<ul class="p-0 m-0 d-flex flex-row-reverse">
	<?while($arResult["nStartPage"] <= $arResult["nEndPage"]):?>

		<?if ($arResult["nStartPage"] == $arResult["NavPageNomer"]):?>
            <li class="mr-2 pagination__list-item active">
                <a><?=$arResult["nStartPage"]?></a>
            </li>
		<?elseif($arResult["nStartPage"] == 1 && $arResult["bSavePage"] == false):?>
            <li class="mr-2 pagination__list-item">
                <a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>"><?=$arResult["nStartPage"]?></a>
            </li>
		<?else:?>
            <li class="mr-2 pagination__list-item">
			    <a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["nStartPage"]?>"><?=$arResult["nStartPage"]?></a>
            </li>
		<?endif?>
		<?$arResult["nStartPage"]++?>
	<?endwhile?>
</ul>
        <?if ($arResult["NavPageNomer"] > 1):?>
            <div class="mx-3 dots 1">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <?if ($arResult["NavPageNomer"] > 2):?>
                <a class="next" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>"><img src="<?=SITE_TEMPLATE_PATH;?>/assets/paginaton-arrow.svg" alt=""></a>
            <?else:?>
                <a class="next" href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>"><img src="<?=SITE_TEMPLATE_PATH;?>/assets/paginaton-arrow.svg" alt=""></a>
            <?endif?>





        <?endif?>


    </nav>
</div>