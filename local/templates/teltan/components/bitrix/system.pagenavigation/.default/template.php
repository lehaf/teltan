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
    <nav class="mb-4 mb-xl-0 justify-content-between justify-content-md-center pagination" aria-label="pagination">
        <?
        $strNavQueryString = ($arResult["NavQueryString"] != "" ? $arResult["NavQueryString"]."&amp;" : "");
        $strNavQueryStringFull = ($arResult["NavQueryString"] != "" ? "?".$arResult["NavQueryString"] : "");
        ?>
        <?
        if($arResult["bDescPageNumbering"] === true):
            $bFirst = true;
            if ($arResult["NavPageNomer"] < $arResult["NavPageCount"]):
                if($arResult["bSavePage"]):
                    ?>
                    <li class="mr-2 pagination__list-item">
                        <a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>"></a>
                    </li>
                <?else:?>
                    <?if ($arResult["NavPageCount"] == ($arResult["NavPageNomer"]+1) ):?>
                        <a class="mr-2 prev" href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>">
                            <img src="<?=SITE_TEMPLATE_PATH;?>/assets/paginaton-arrow.svg" alt="">
                        </a>
                    <?else:?>
                        <a class="mr-2 prev" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>">
                            <img src="<?=SITE_TEMPLATE_PATH;?>/assets/paginaton-arrow.svg" alt="">
                        </a>
                    <?endif;?>
                <?endif;

                if ($arResult["nStartPage"] < $arResult["NavPageCount"]):
                    $bFirst = false;
                    if($arResult["bSavePage"]):
                        ?>

                        <li class="mr-2 pagination__list-item">
                            <a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["NavPageCount"]?>">1</a>
                        </li>


                    <?
                    else:
                        ?>
                        <li class="mr-2 pagination__list-item">
                            <a  href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>">1</a>
                        </li>
                    <?
                    endif;
                    if ($arResult["nStartPage"] < ($arResult["NavPageCount"] - 1)):?>

                        <li class="mr-2 pagination__list-item">
                            <a  href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=intval($arResult["nStartPage"] + ($arResult["NavPageCount"] - $arResult["nStartPage"]) / 2)?>">...</a>
                        </li>


                    <?
                    endif;
                endif;
            endif;
            do
            {
                $NavRecordGroupPrint = $arResult["NavPageCount"] - $arResult["nStartPage"] + 1;
                if ($arResult["nStartPage"] == $arResult["NavPageNomer"]):?>
                    <li class="mr-2 pagination__list-item active">
                        <a  href="#"><?=$NavRecordGroupPrint?></a>
                    </li>

                <?elseif($arResult["nStartPage"] == $arResult["NavPageCount"] && $arResult["bSavePage"] == false):?>
                    <li class="mr-2 pagination__list-item">
                        <a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>" ><?=$NavRecordGroupPrint?></a>
                    </li>
                <?else:?>
                    <li class="mr-2 pagination__list-item">
                        <a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["nStartPage"]?>" >
                            <?=$NavRecordGroupPrint?>
                        </a>
                    </li>
                <?endif;

                $arResult["nStartPage"]--;
                $bFirst = false;
            } while($arResult["nStartPage"] >= $arResult["nEndPage"]);

            if ($arResult["NavPageNomer"] > 1):
                if ($arResult["nEndPage"] > 1):
                    if ($arResult["nEndPage"] > 2):?>

                        <li class="mr-2 pagination__list-item paginations__total">
                            <a  href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=round($arResult["nEndPage"] / 2)?>">...</a>
                        </li>

                    <?endif; ?>
                    <a class="next" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>">
                        <img src="<?=SITE_TEMPLATE_PATH;?>/assets/paginaton-arrow.svg" alt="paginaton">
                    </a>

                <?endif; ?>
                <li class="mr-2 pagination__list-item">
                    <a  href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>"><svg class="icon pagination__link-icon" style="width:14px;height:14px;"><use xlink:href="<?=SITE_TEMPLATE_PATH;?>/assets/images/sprite.svg#i-arrow-small"/></svg></a>
                </li>

            <?endif;?>

        <?else:?>
            <?$bFirst = true;
            if ($arResult["NavPageNomer"] > 1):
                if($arResult["bSavePage"]):?>
                    <li class="mr-2 pagination__list-item">
                        <a  href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>"></a>
                    </li>
                <?else:?>
                    <?if ($arResult["NavPageNomer"] > 2):?>
                        <a class="mr-2 prev" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>">
                            <img src="<?=SITE_TEMPLATE_PATH;?>/assets/paginaton-arrow.svg" alt="">
                        </a>
                    <?else:?>
                        <a class="mr-2 prev" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>">
                            <img src="<?=SITE_TEMPLATE_PATH;?>/assets/paginaton-arrow.svg" alt="">
                        </a>
                    <?endif;?>
                <?endif;?>
                <?if ($arResult["nStartPage"] > 1):
                    $bFirst = false;
                    if($arResult["bSavePage"]):?>
                        <li class="mr-2 pagination__list-item">
                            <a  href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=1">1</a>
                        </li>
                    <?else:?>
                        <li class="mr-2 pagination__list-item">
                            <a  href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>">1</a>
                        </li>
                    <?endif;?>
                    <?if ($arResult["nStartPage"] > 2):?>

                        <li class="mr-2 pagination__list-item paginations__total">
                            <a  href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=round($arResult["nStartPage"] / 2)?>">...</a>
                        </li>
                    <?endif;?>
                <?endif;?>
            <?endif;?>
            <?do
            {
                if ($arResult["nStartPage"] == $arResult["NavPageNomer"]):
                    ?>
                    <li class="mr-2 pagination__list-item active">
                        <a  href="#"><?=$arResult["nStartPage"]?></a>
                    </li>
                <?
                elseif($arResult["nStartPage"] == 1 && $arResult["bSavePage"] == false):
                    ?>
                    <li class="mr-2 pagination__list-item">
                        <a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>" ><?=$arResult["nStartPage"]?></a>
                    </li>

                <?
                else:
                    ?>

                    <li class="mr-2 pagination__list-item">
                        <a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["nStartPage"]?>"<?
                        ?> ><?=$arResult["nStartPage"]?></a>
                    </li>



                <?
                endif;
                $arResult["nStartPage"]++;
                $bFirst = false;
            } while($arResult["nStartPage"] <= $arResult["nEndPage"]);

            if($arResult["NavPageNomer"] < $arResult["NavPageCount"]):
                if ($arResult["nEndPage"] < $arResult["NavPageCount"]):
                    if ($arResult["nEndPage"] < ($arResult["NavPageCount"] - 1)):
                        /*?>
                                <span class="modern-page-dots">...</span>
                        <?*/
                        ?>

                        <li class="mr-2 pagination__list-item">
                            <a  href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=round($arResult["nEndPage"] + ($arResult["NavPageCount"] - $arResult["nEndPage"]) / 2)?>">...</a>
                        </li>
                    <?
                    endif;
                    ?>

                    <li class="mr-2 pagination__list-item">
                        <a  href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["NavPageCount"]?>"><?=$arResult["NavPageCount"]?></a>
                    </li>



                <?endif; ?>
                <a class="next" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>">
                    <img src="<?=SITE_TEMPLATE_PATH;?>/assets/paginaton-arrow.svg" alt="paginaton">
                </a>
            <?endif;?>
        <?endif; ?>
    </nav>
</div>