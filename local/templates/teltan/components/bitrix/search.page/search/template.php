<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

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


if (!empty($arResult['SEARCH'])) {

    $itemIds = [];
    foreach ($arResult['SEARCH'] as $k => $arItem) {
        if ($arItem['ITEM_ID'] != null) $itemIds[] = $arItem['ITEM_ID'];
    }

    $sortText = 'Price: Low to High';
    $arOrder['PRICE'] = 'ASC';
    if ($_GET['SORT'] == 'property_PRICE' and $_GET['ORDER'] == 'ASC') {
        $sortText = 'Price: Low to High';
        $arOrder['PRICE'] = 'ASC';
    } elseif ($_GET['SORT'] == 'property_PRICE' and $_GET['ORDER'] == 'DESC') {
        $sortText = 'Price: High to Low';
        $arOrder['PRICE'] = 'DESC';
    } elseif ($_GET['SORT'] == 'property_TIME_RAISE' and $_GET['ORDER'] == 'ASC') {
        $sortText = 'Date: Low to High';
        $arOrder['TIME_RAISE'] = 'ASC';
    } elseif ($_GET['SORT'] == 'property_TIME_RAISE' and $_GET['ORDER'] == 'DESC') {
        $sortText = 'Date: High to Low';
        $arOrder['TIME_RAISE'] = 'DESC';
    }

    $arOrder['ID'] = $itemIds;
    $arSelect = array(
        "ID",
        "IBLOCK_ID",
        "NAME",
        "DETAIL_PAGE_URL",
        "SHOW_COUNTER",
        "DATE_CREATE",
        "PREVIEW_PICTURE",
        "PREVIEW_TEXT",
        "PROPERTY_*"
    );

    $arFilter = array(
        "ID" => $itemIds,
        "ACTIVE" => "Y",
    );
    $res = CIBlockElement::GetList($arOrder, $arFilter, false, false, $arSelect);
    while ($item = $res->GetNext()) {
        $result[] = $item;
    }

    $arResult['RESULT'] = $result;

?>

    <div class="container">
        <h1 class="h2 mb-4 subtitle">
            <?=$APPLICATION->ShowTitle();?>
        </h1>
        <div class="mb-5 row d-flex align-items-center">
            <?=$arResult['NAV_STRING'];?>
            <div class="col-12 col-xl-6 justify-content-center">
                <div class="d-flex justify-content-between justify-content-xl-end products-sort">
                    <div class="d-flex">
                        <a href="?q=<?=$_GET['q'];?>&display=block" class="mr-2 d-none d-lg-flex justify-content-center align-items-center products-sort__button">
                            <i class="icon-sirting_block"></i>
                        </a>
                        <a href="?q=<?=$_GET['q'];?>&display=list" class="mr-2 d-none d-lg-flex justify-content-center align-items-center products-sort__button">
                            <i class="icon-sirting_line"></i>
                        </a>
                    </div>
                    <div class="d-flex dropdown">
                        <button class="btn bg-white d-flex justify-content-between align-items-center" href="#" role="a" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="icon-arrow-down-sign-to-navigate-3"></i>
                            <span class="text-right"><?=$sortText;?></span>
                        </button>

                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="?q=<?=$_GET['q']?>&SORT=property_PRICE&ORDER=ASC">Price: Low to High</a>
                            <a class="dropdown-item" href="?q=<?=$_GET['q']?>&SORT=property_PRICE&ORDER=DESC">Price: High to Low</a>
                            <a class="dropdown-item" href="?q=<?=$_GET['q']?>&SORT=property_TIME_RAISE&ORDER=ASC">Date: Low to High</a>
                            <a class="dropdown-item" href="?q=<?=$_GET['q']?>&SORT=property_TIME_RAISE&ORDER=DESC">Date: High to Low</a>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row row-cols-2 row-cols-lg-4">
            <?foreach($arResult['RESULT'] as $item){;?>
                <div class="mb-4 col">
                    <div class="card product-card">
                        <div class="image-block">
                            <div class="i-box">
                                <?
                                if($item['PREVIEW_PICTURE'])
                                {
                                    $image = resizeImg($item['PREVIEW_PICTURE'], 195, 158);
                                }
                                else
                                    $image = SITE_TEMPLATE_PATH.'/assets/no-image.svg';
                                ?>
                                <a href="<?=$item['DETAIL_PAGE_URL'];?>"><img src="<?=$image;?>" alt="<?=$item['NAME'];?>"></a>
                            </div>
                        </div>

                        <div class="px-2 px-lg-3 d-flex justify-content-between">
                             <? if ($USER->IsAuthorized()) { ?>
                                <p class="mb-0 like followThisItem" data-ad_id="<?=$item['ID'];?>">
                                    <svg id="iconLike" class="iconLike" viewBox="0 0 612 792"><path d="M562.413,284.393c-9.68,41.044-32.121,78.438-64.831,108.07L329.588,542.345l-165.11-149.843 c-32.771-29.691-55.201-67.076-64.892-108.12c-6.965-29.484-4.103-46.14-4.092-46.249l0.147-0.994 c6.395-72.004,56.382-124.273,118.873-124.273c46.111,0,86.703,28.333,105.965,73.933l9.061,21.477l9.061-21.477 c18.958-44.901,61.694-73.922,108.896-73.922c62.481,0,112.478,52.27,119,125.208C566.517,238.242,569.379,254.908,562.413,284.393z"/></svg>
                                </p>
                             <?} else { ?>
                                 <a data-toggle="modal" data-target="#logInModal" class="d-flex align-items-center mr-3"
                                    href="#">
                                     <p class="mb-0 like followThisItem" data-ad_id="">
                                         <svg class="iconLike" viewBox="0 0 612 792">
                                             <path d="M562.413,284.393c-9.68,41.044-32.121,78.438-64.831,108.07L329.588,542.345l-165.11-149.843 c-32.771-29.691-55.201-67.076-64.892-108.12c-6.965-29.484-4.103-46.14-4.092-46.249l0.147-0.994 c6.395-72.004,56.382-124.273,118.873-124.273c46.111,0,86.703,28.333,105.965,73.933l9.061,21.477l9.061-21.477 c18.958-44.901,61.694-73.922,108.896-73.922c62.481,0,112.478,52.27,119,125.208C566.517,238.242,569.379,254.908,562.413,284.393z"/>
                                         </svg>
                                     </p>
                                 </a>
                             <?} ?>
                            <p class="mb-0 price"><?=ICON_CURRENCY;?> <?=number_format($item['PROPERTIES']['PRICE']['VALUE'], 0, '.', ' ');?></p>
                        </div>

                        <div class="px-2 px-lg-3 content-block">
                            <div class="text-right">
                                <a href="<?=$item['DETAIL_PAGE_URL'];?>" class="mb-2 mb-lg-3 title"><?=$item['NAME'];?></a>
                            </div>

                            <div class="border-top py-2 py-lg-3 d-flex justify-content-between align-items-center text-nowrap">
                                <span class="mr-0 mr-lg-2 views"><span><?=$item['SHOW_COUNTER'];?></span> <i class="icon-visibility"></i></span>
                                <?
                                $strDate = getStringDate($item['DATE_CREATE']);
                                ?>
                                <span class="date"><?=($strDate['MES']) ? GetMessage($strDate['MES']).', '.$strDate['HOURS'] : $strDate['HOURS'];?></span>
                            </div>
                        </div>
                    </div>
                </div>
            <?}?>
        </div>
        <div style="padding-bottom: 30px;">
            <?=$arResult['NAV_STRING'];?>
        </div>
    </div>
<?}else{?>
    <div class="container">
        <div class="mb-5 row d-flex align-items-center">
            <h1 class="h2 mb-4" >לא נמצאו תוצאות חיפוש מתאימות</h1>
        </div>
    </div>
<?}?>
