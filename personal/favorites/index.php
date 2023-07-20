<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Избранные объявления");
?>

    <div class="container">
        <h2 class="mb-4 subtitle">
            <?=$APPLICATION->ShowTitle();?>
        </h2>
        <div class="row">
            <div class="col-12 col-lg-8 col-xl-9">
                <div class="row row-cols-2 row-cols-md-1">
                    <?
                    global $USER;
                    global $result;

                    $IDs = getFavoritesUser($USER->GetID());
                   
                    if(!empty($IDs)){
                    $arSelect = Array("ID", "IBLOCK_ID", "NAME", "DETAIL_PAGE_URL", "SHOW_COUNTER", "DATE_CREATE", "PREVIEW_PICTURE");
                    $arFilter = Array("ID"=> $IDs, "ACTIVE"=>"Y");
                    $res = CIBlockElement::GetList(Array("ID" => $IDs), $arFilter, false, false, $arSelect);
                    while($ob = $res->GetNextElement()){
                        $arFields = $ob->GetFields();
                        $arFields['PROPERTIES'] = $ob->GetProperties();
                        $result[] = $arFields;
                    }
                    krsort($result);
                    foreach($result as $item)
                    {?>
                        <div class="mb-4 col">
                            <div class="card product-card product-line">
                                <div class="card-link">
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

                                            <a href="<?=$item['DETAIL_PAGE_URL'];?>"><img src="<?=$image?>" alt="<?=$item['NAME'];?>"></a>
                                        </div>
                                    </div>

                                    <div class="px-2 px-lg-3 d-flex justify-content-between like-price">
                                        <p class="mb-0 like followThisItem active" data-ad_id="<?=$item['ID'];?>">
                                            <svg id="iconLike" class="iconLike" viewBox="0 0 612 792"><path d="M562.413,284.393c-9.68,41.044-32.121,78.438-64.831,108.07L329.588,542.345l-165.11-149.843 c-32.771-29.691-55.201-67.076-64.892-108.12c-6.965-29.484-4.103-46.14-4.092-46.249l0.147-0.994 c6.395-72.004,56.382-124.273,118.873-124.273c46.111,0,86.703,28.333,105.965,73.933l9.061,21.477l9.061-21.477 c18.958-44.901,61.694-73.922,108.896-73.922c62.481,0,112.478,52.27,119,125.208C566.517,238.242,569.379,254.908,562.413,284.393z"/></svg>
                                        </p>

                                        <p class="mb-0 price"><?=ICON_CURRENCY;?> <?=number_format($item['PROPERTIES']['PRICE']['VALUE'], 0, '.', ' ');?></p>
                                    </div>

                                    <div class="px-2 px-lg-3 content-block">
                                        <div class="text-right">
                                            <a href="<?=$item['DETAIL_PAGE_URL'];?>" class="mb-2 mb-lg-3 title"><?=$item['NAME'];?></a>
                                            <?if($item['IBLOCK_ID'] == 2)
                                            {?>
                                                <p class="mb-2 mb-lg-3 location">
                                                    <span class="addres"><?=$item['PROPERTIES']['LOCATION']['VALUE'];?></span>
                                                    <svg class="icon-local" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 513.597 513.597" xml:space="preserve">
                                                      <g>
                                                          <path d="M263.278,0.107C158.977-3.408,73.323,80.095,73.323,183.602c0,117.469,112.73,202.72,175.915,325.322
                                                        c3.208,6.225,12.169,6.233,15.388,0.009c57.16-110.317,154.854-184.291,172.959-290.569
                                                        C456.331,108.387,374.776,3.866,263.278,0.107z M256.923,279.773c-53.113,0-96.171-43.059-96.171-96.171
                                                        s43.059-96.171,96.171-96.171c53.113,0,96.172,43.059,96.172,96.171S310.036,279.773,256.923,279.773z"></path>
                                                      </g>
                                                    </svg>
                                                </p>
                                            <?}?>

                                            <?if($item['IBLOCK_ID'] == 3 || $item['IBLOCK_ID'] == 7 || $item['IBLOCK_ID'] == 8)
                                            {?>
                                                <div class="row flex-column-reverse flex-lg-row">
                                                    <div class="col-12 col-xl">
                                                        <p class="d-none d-xl-inline-block">
                                                            <span>310 h.p Gas / Petrol, 4.8 l.</span>
                                                            <i class="icon-engine"></i>
                                                        </p>
                                                        <p class="mb-2 mb-lg-3 location">
                                                            <span class="addres"><?=$item['PROPERTIES']['LOCATION']['VALUE'];?></span>
                                                            <svg
                                                                    class="icon-local"
                                                                    version="1.1"
                                                                    id="Capa_1"
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                    x="0px"
                                                                    y="0px"
                                                                    viewBox="0 0 513.597 513.597"
                                                                    xml:space="preserve"
                                                            >
                                                            <g>
                                                                <path
                                                                        d="M263.278,0.107C158.977-3.408,73.323,80.095,73.323,183.602c0,117.469,112.73,202.72,175.915,325.322
                                                              c3.208,6.225,12.169,6.233,15.388,0.009c57.16-110.317,154.854-184.291,172.959-290.569
                                                              C456.331,108.387,374.776,3.866,263.278,0.107z M256.923,279.773c-53.113,0-96.171-43.059-96.171-96.171
                                                              s43.059-96.171,96.171-96.171c53.113,0,96.172,43.059,96.172,96.171S310.036,279.773,256.923,279.773z"
                                                                />
                                                            </g>
                                                          </svg>
                                                        </p>
                                                    </div>
                                                    <div class="col-12 col-xl-4">
                                                        <p class="mb-2 mileage"><?=$item['PROPERTIES']['PROBEG']['VALUE'];?> <?=$item['PROPERTIES']['KM_ML']['VALUE']?><i class="ml-2 icon-download-speed"></i></p>
                                                        <p class="d-none d-xl-inline-block"><span>Manual</span> <i class="ml-2 icon-manual-transmission"></i></p>
                                                    </div>
                                                </div>
                                            <?}?>
                                        </div>

                                        <div class="border-top py-2 d-flex justify-content-between align-items-center text-nowrap product-line__data-viwe">
                                            <div class="d-flex">
                                                <span class="mr-0 mr-lg-2 views"><span><?=$item['SHOW_COUNTER'];?></span> <i class="icon-visibility"></i></span>

                                                <span class="product-line__like active like_f" data-ad_id="<?=$item['ID'];?>">Из избранного
                                                    <svg id="iconLike" class="iconLike" viewBox="0 0 612 792"><path d="M562.413,284.393c-9.68,41.044-32.121,78.438-64.831,108.07L329.588,542.345l-165.11-149.843 c-32.771-29.691-55.201-67.076-64.892-108.12c-6.965-29.484-4.103-46.14-4.092-46.249l0.147-0.994 c6.395-72.004,56.382-124.273,118.873-124.273c46.111,0,86.703,28.333,105.965,73.933l9.061,21.477l9.061-21.477 c18.958-44.901,61.694-73.922,108.896-73.922c62.481,0,112.478,52.27,119,125.208C566.517,238.242,569.379,254.908,562.413,284.393z"/></svg>
                                                  </span>
                                            </div>

                                            <?
                                            $strDate = getStringDate($item['DATE_CREATE']);
                                            ?>
                                            <span class="date"><?=($strDate['MES']) ? GetMessage($strDate['MES']).', '.$strDate['HOURS'] : $strDate['HOURS'];?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?}
                    }
                    if (count($result) <1){
                        ?>
                        <h1>עדיין לא הוספת כלום</h1>
                        <?
                    }
                    ?>

                </div>
            </div>

            <?include $_SERVER['DOCUMENT_ROOT'].'/personal/left.php'?>

        </div>
    </div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>