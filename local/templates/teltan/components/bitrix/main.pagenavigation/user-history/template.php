<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

/** @var array $arParams */
/** @var array $arResult */
/** @var CBitrixComponentTemplate $this */
/** @var PageNavigationComponent $component */

$component = $this->getComponent();
$this->setFrameMode(true);

?>
<div class="history-pagenavigation justify-content-center">
    <nav class="mb-4 mb-xl-0 justify-content-between justify-content-md-center pagination" aria-label="pagination">
        <?if($arResult["REVERSED_PAGES"] === true):?>

            <?if ($arResult["CURRENT_PAGE"] < $arResult["PAGE_COUNT"]):?>
                <?if (($arResult["CURRENT_PAGE"]+1) == $arResult["PAGE_COUNT"]):?>
                    <li class="bx-pag-prev"><a href="<?=htmlspecialcharsbx($arResult["URL"])?>"><span><?echo GetMessage("round_nav_back")?></span></a></li>
                <?else:?>
                    <a class="mr-2 prev" href="<?=htmlspecialcharsbx($component->replaceUrlTemplate($arResult["CURRENT_PAGE"]+1))?>">
                        <img src="/local/templates/teltan/assets/paginaton-arrow.svg" alt="">
                    </a>
                <?endif?>
                    <li class="mr-2 pagination__list-item"><a href="<?=htmlspecialcharsbx($arResult["URL"])?>"><span>1</span></a></li>
            <?else:?>
                    <li class="mr-2 pagination__list-item active"><span>1</span></li>
            <?endif?>

            <?
            $page = $arResult["START_PAGE"] - 1;
            while($page >= $arResult["END_PAGE"] + 1):
            ?>
                <?if ($page == $arResult["CURRENT_PAGE"]):?>
                    <li class="mr-2 pagination__list-item active"><span><?=($arResult["PAGE_COUNT"] - $page + 1)?></span></li>
                <?else:?>
                    <li class="mr-2 pagination__list-item"><a href="<?=htmlspecialcharsbx($component->replaceUrlTemplate($page))?>"><span><?=($arResult["PAGE_COUNT"] - $page + 1)?></span></a></li>
                <?endif?>

                <?$page--?>
            <?endwhile?>

            <?if ($arResult["CURRENT_PAGE"] > 1):?>
                <?if($arResult["PAGE_COUNT"] > 1):?>
                    <li class="mr-2 pagination__list-item"><a href="<?=htmlspecialcharsbx($component->replaceUrlTemplate(1))?>"><span><?=$arResult["PAGE_COUNT"]?></span></a></li>
                <?endif?>
                    <a class="next" href="<?=htmlspecialcharsbx($component->replaceUrlTemplate($arResult["CURRENT_PAGE"]-1))?>">
                        <img src="/local/templates/teltan/assets/paginaton-arrow.svg" alt="paginaton">
                    </a>
            <?else:?>
                <?if($arResult["PAGE_COUNT"] > 1):?>
                    <li class="mr-2 pagination__list-item active"><span><?=$arResult["PAGE_COUNT"]?></span></li>
                <?endif?>
            <?endif?>

        <?else:?>

            <?if ($arResult["CURRENT_PAGE"] > 1):?>
                <?if ($arResult["CURRENT_PAGE"] > 2):?>
                    <a class="mr-2 prev" href="<?=htmlspecialcharsbx($component->replaceUrlTemplate($arResult["CURRENT_PAGE"]-1))?>">
                        <img src="/local/templates/teltan/assets/paginaton-arrow.svg" alt="">
                    </a>
                <?else:?>
                    <a class="mr-2 prev" href="<?=htmlspecialcharsbx($arResult["URL"])?>">
                        <img src="/local/templates/teltan/assets/paginaton-arrow.svg" alt="">
                    </a>
                <?endif?>
                    <li class="mr-2 pagination__list-item"><a href="<?=htmlspecialcharsbx($arResult["URL"])?>"><span>1</span></a></li>
            <?else:?>
                    <li class="mr-2 pagination__list-item active"><span>1</span></li>
            <?endif?>

            <?
            $page = $arResult["START_PAGE"] + 1;
            while($page <= $arResult["END_PAGE"]-1):
            ?>
                <?if ($page == $arResult["CURRENT_PAGE"]):?>
                    <li class="mr-2 pagination__list-item active"><span><?=$page?></span></li>
                <?else:?>
                    <li class="mr-2 pagination__list-item"><a href="<?=htmlspecialcharsbx($component->replaceUrlTemplate($page))?>"><span><?=$page?></span></a></li>
                <?endif?>
                <?$page++?>
            <?endwhile?>

            <?if($arResult["CURRENT_PAGE"] < $arResult["PAGE_COUNT"]):?>
                <?if($arResult["PAGE_COUNT"] > 1):?>
                    <li class="mr-2 pagination__list-item"><a href="<?=htmlspecialcharsbx($component->replaceUrlTemplate($arResult["PAGE_COUNT"]))?>"><span><?=$arResult["PAGE_COUNT"]?></span></a></li>
                <?endif?>
                    <a class="next" href="<?=htmlspecialcharsbx($component->replaceUrlTemplate($arResult["CURRENT_PAGE"]+1))?>">
                        <img src="/local/templates/teltan/assets/paginaton-arrow.svg" alt="paginaton">
                    </a>
            <?else:?>
                <?if($arResult["PAGE_COUNT"] > 1):?>
                    <li class="mr-2 pagination__list-item active"><span><?=$arResult["PAGE_COUNT"]?></span></li>
                <?endif?>
            <?endif?>
        <?endif?>
    </nav>
</div>
