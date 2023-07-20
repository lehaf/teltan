<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
use Bitrix\Highloadblock\HighloadBlockTable as HLBT;


global $mapArray;
$mapArray = [
    "type" => "FeatureCollection"
];
global $mapArrayVip;
$mapArrayVip = [
    "type" => "FeatureCollection"
];
foreach ($arResult['ITEMS'] as $arItem) {
    $counterJson = 0;

    $res = CIBlockElement::GetByID($arItem["ID"]);
    if($ar_res = $res->GetNext())
        $counterJson =  $ar_res['SHOW_COUNTER'];

    $nameSection = '';
    $res = CIBlockSection::GetByID($_GET["GID"]);
    if($ar_res = $res->GetNext())
        $nameSection =  $ar_res['NAME'];

    // $arItem['PROPERTIES']['MAP_LATLNG']['VALUE'] = str_replace('&quot;', '"', $arItem['PROPERTIES']['MAP_LATLNG']['VALUE']);
    $mapLatlnt = json_decode($arItem['PROPERTIES']['MAP_LATLNG']['~VALUE'], true);
    if($arItem['PROPERTIES']['VIP_DATE']['VALUE'] && strtotime($arItem['PROPERTIES']['VIP_DATE']['VALUE']) > time()) {
        $mapArrayVip['features'][] = [
            'type' => 'Feature',
            'properties' => [
                'href' => $arItem['DETAIL_PAGE_URL'],
                'image' => $arItem['PREVIEW_PICTURE']['SAFE_SRC'] ?? '/no-image.svg',
                'title' => $arItem['NAME'],
                'price' => $arItem['PROPERTIES']['PRICE']['VALUE'],
                'addres' => $arItem['NAME'],
                'category' => $nameSection,
                'views' => $counterJson,
                'date' => $arItem['DATE_CREATE'],
                'isVipCard' => false,
            ],
            'geometry' => [
                'type' => 'Point',
                'coordinates' =>
                    [$mapLatlnt['lng'], $mapLatlnt['lat']]
            ]
        ];
    }else{
        $mapArray['features'][] = [
            'type' => 'Feature',
            'properties' => [
                'href' => $arItem['DETAIL_PAGE_URL'],
                'image' => $arItem['PREVIEW_PICTURE']['SAFE_SRC'] ?? '/no-image.svg',
                'title' => $arItem['NAME'],
                'price' => $arItem['PROPERTIES']['PRICE']['VALUE'],
                'addres' => $arItem['NAME'],
                'category' => $nameSection,
                'views' => $counterJson,
                'date' => $arItem['DATE_CREATE'],
                'isVipCard' => false,
            ],
            'geometry' => [
                'type' => 'Point',
                'coordinates' =>
                    [$mapLatlnt['lng'], $mapLatlnt['lat']]
            ]
        ];
    }

}

?><div class="container">
    <h1 class="h2 mb-4 subtitle">
        PROPERTY MAP VIEW
    </h1>
</div>
<div class="property-full-map">
    <div class="d-block">
        <div class="map-box">
            <div class="mapboxgl-map" id="map" style="width: 100%; height: 100%"><div class="mapboxgl-canary" style="visibility: hidden;"></div><div class="mapboxgl-canvas-container mapboxgl-interactive mapboxgl-touch-drag-pan mapboxgl-touch-zoom-rotate"><canvas class="mapboxgl-canvas" tabindex="0" aria-label="Map" role="region" width="979" height="785" style="width: 979px; height: 785px;"></canvas></div><div class="mapboxgl-control-container"><div class="mapboxgl-ctrl-top-left"></div><div class="mapboxgl-ctrl-top-right"></div><div class="mapboxgl-ctrl-bottom-left"><div class="mapboxgl-ctrl" style="display: block;"><a class="mapboxgl-ctrl-logo" target="_blank" rel="noopener nofollow" href="https://www.mapbox.com/" aria-label="Mapbox logo"></a></div></div><div class="mapboxgl-ctrl-bottom-right"><div class="mapboxgl-ctrl mapboxgl-ctrl-attrib"><button class="mapboxgl-ctrl-attrib-button" type="button" title="Toggle attribution" aria-label="Toggle attribution"></button><div class="mapboxgl-ctrl-attrib-inner" role="list"><a href="https://www.mapbox.com/about/maps/" target="_blank" title="Mapbox" aria-label="Mapbox" role="listitem">© Mapbox</a> <a href="https://www.openstreetmap.org/about/" target="_blank" title="OpenStreetMap" aria-label="OpenStreetMap" role="listitem">© OpenStreetMap</a> <a class="mapbox-improve-map" href="https://apps.mapbox.com/feedback/?owner=mapbox&amp;id=streets-v11&amp;access_token=pk.eyJ1IjoiYS1rbGltb2YiLCJhIjoiY2themVqYzI4MGlrZDJxbWlvaDBlMzF6MyJ9.QXFKypM1BnCkQaUZKTuP0g" target="_blank" title="Map feedback" aria-label="Map feedback" role="listitem" rel="noopener nofollow">Improve this map</a></div></div></div></div></div>
        </div>

        <div class="d-flex justify-content-end">
            <div class="d-flex justify-content-between justify-content-lg-end products-sort">
                <button onclick="window.location.href = document.location.pathname" class="d-block d-lg-none btn btn-closer">
                    <i class="mr-1 mr-lg-3 icon-clear"></i>
                </button>

                <div class="d-flex align-items-center py-3">
                    <a id="icon-sirting_block" type="button" class="mr-2 d-none d-lg-flex justify-content-center align-items-center products-sort__button">
                        <i class="icon-sirting_block"></i>
                    </a>

                    <a id="icon-sirting_line" type="button" class="mr-2 d-none d-lg-flex justify-content-center align-items-center products-sort__button">
                        <i class="icon-sirting_line"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="cord-container" id="rendorMapItemCard">
            <div class="preloader">
                <div class="preloader__row">
                    <div class="preloader__item"></div>
                    <div class="preloader__item"></div>
                </div>
            </div>
<?if(count($arResult['ITEMS']) < 1){?>
    <h1 class="h2 mb-4 subtitle">המדור ריק</h1>
<?}else{?>
            <?
            $arNotVip = [];
              $count = 0;
            foreach ($arResult['ITEMS'] as $arItem){
                if ($arItem['PROPERTIES']['VIP_DATE']['VALUE'] && strtotime($arItem['PROPERTIES']['VIP_DATE']['VALUE']) > time()) {
                    $arResult['VIPS'][] = $arItem;
                }
            }

           /* usort($arResult['VIPS'], function ($arr1, $arr2) {
                return $arr1['PROPERTIES']['TIME_RAISE']['VALUE'] < $arr2['PROPERTIES']['TIME_RAISE']['VALUE'];
            });*/
            foreach($arResult['VIPS'] as $arItem){?>
                <?
                $color = '';
                $vip = '';
                if($arItem['PROPERTIES']['COLOR_DATE']['VALUE'] && strtotime($arItem['PROPERTIES']['COLOR_DATE']['VALUE']) > time()) {
                    $color = '#FFF5D9';
                };
                if($arItem['PROPERTIES']['VIP_DATE']['VALUE'] && strtotime($arItem['PROPERTIES']['VIP_DATE']['VALUE']) > time()) {
                    $vip = 'product-line-vip';
                } ?>

                <?if($vip != ''){?>
                    <div class="row row-cols-1 <?if($count == 0){?> databefore<?}?>">

                        <div class="mb-3 col ">
                            <?$count++?>
                            <div class="card product-card product-line <?=$vip;?>" style="background-color: <?=$color;?>">
                                <div class="card-link">
                                    <div class="image-block">
                                        <div class="i-box">
                                            <a href="#"><img src="<?=$arItem['PREVIEW_PICTURE']['SAFE_SRC'] ?? '/no-image.svg'?>" alt="no-img"></a>
                                        </div>
                                    </div>

                                    <div class="px-2 px-lg-3 d-flex justify-content-between like-price">
                                        <p class="mb-0 like followThisItem" data-ad_id="<?=$arItem['ID'];?>>
                        <svg id="iconLike" class="iconLike" viewBox="0 0 612 792"><path d="M562.413,284.393c-9.68,41.044-32.121,78.438-64.831,108.07L329.588,542.345l-165.11-149.843 c-32.771-29.691-55.201-67.076-64.892-108.12c-6.965-29.484-4.103-46.14-4.092-46.249l0.147-0.994 c6.395-72.004,56.382-124.273,118.873-124.273c46.111,0,86.703,28.333,105.965,73.933l9.061,21.477l9.061-21.477 c18.958-44.901,61.694-73.922,108.896-73.922c62.481,0,112.478,52.27,119,125.208C566.517,238.242,569.379,254.908,562.413,284.393z"/></svg>
                                        </p>
                                        <?if($arItem['PROPERTIES']['PRICE']['VALUE'] != null){?>
                                            <p class="mb-0 price"><?=ICON_CURRENCY;?> <?=number_format($arItem['PROPERTIES']['PRICE']['VALUE'], 0, '.', ' ');?></p>
                                        <?}?>
                                        <?if ($vip != ''){?>
                                            <div class="vip-marker">
                                                <div class="mr-2 icon">
                                                    <svg width="14" height="13" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1.01141 2.346L3.74531 4.23405L6.4701 0.282625C6.53032 0.195214 6.60981 0.123964 6.70197 0.0748055C6.79413 0.0256466 6.8963 0 6.99996 0C7.10362 0 7.20578 0.0256466 7.29794 0.0748055C7.39011 0.123964 7.4696 0.195214 7.52982 0.282625L10.2546 4.23405L12.9885 2.346C13.092 2.27468 13.213 2.23555 13.3372 2.23321C13.4615 2.23087 13.5838 2.26542 13.6897 2.33279C13.7956 2.40016 13.8807 2.49753 13.9349 2.61338C13.989 2.72923 14.0101 2.85874 13.9955 2.98658L12.926 12.4046C12.9074 12.5686 12.8312 12.7198 12.7121 12.8296C12.593 12.9393 12.4391 13 12.2796 13H1.72027C1.56084 13 1.40695 12.9393 1.28781 12.8296C1.16867 12.7198 1.09255 12.5686 1.0739 12.4046L0.0044209 2.98591C-0.0100298 2.85812 0.0111158 2.72871 0.0653613 2.61296C0.119607 2.49722 0.204688 2.39996 0.31056 2.33268C0.416433 2.26541 0.538677 2.23091 0.662862 2.23327C0.787047 2.23563 0.907988 2.27474 1.01141 2.346ZM6.99996 8.95417C7.34523 8.95417 7.67637 8.81209 7.92051 8.55918C8.16466 8.30626 8.30182 7.96324 8.30182 7.60557C8.30182 7.24789 8.16466 6.90487 7.92051 6.65196C7.67637 6.39904 7.34523 6.25696 6.99996 6.25696C6.65468 6.25696 6.32355 6.39904 6.07941 6.65196C5.83526 6.90487 5.6981 7.24789 5.6981 7.60557C5.6981 7.96324 5.83526 8.30626 6.07941 8.55918C6.32355 8.81209 6.65468 8.95417 6.99996 8.95417Z" fill="#F50000"></path>
                                                    </svg>

                                                </div>

                                                <span class="text">vip</span>
                                            </div>
                                        <?}?>
                                    </div>

                                    <div class="px-2 px-lg-3 content-block">
                                        <div class="text-right">
                                            <a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="mb-2 mb-lg-3 title"><?=$arItem['NAME']?></a>
                                            <p class="mb-2 mb-lg-3 location">
                                                <span class="addres"><?=$arItem['PROPERTIES']['MAP_LAYOUT']['VALUE'];?> <?=(!empty($arItem['PROPERTIES']['MAP_LAYOUT']['VALUE']))? ',' : ''?> <?=$arItem['PROPERTIES']['MAP_LAYOUT_BIG']['VALUE'];?></span>
                                                <svg class="icon-local" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 513.597 513.597" xml:space="preserve">
              <g>
                  <path d="M263.278,0.107C158.977-3.408,73.323,80.095,73.323,183.602c0,117.469,112.73,202.72,175.915,325.322
                c3.208,6.225,12.169,6.233,15.388,0.009c57.16-110.317,154.854-184.291,172.959-290.569
                C456.331,108.387,374.776,3.866,263.278,0.107z M256.923,279.773c-53.113,0-96.171-43.059-96.171-96.171
                s43.059-96.171,96.171-96.171c53.113,0,96.172,43.059,96.172,96.171S310.036,279.773,256.923,279.773z"></path>
              </g>
            </svg>
                                            </p>
                                            <a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="mb-2 mb-lg-4 category"><?=mb_strimwidth($arItem['PREVIEW_TEXT'], 0, 300, " ...");?></a>
                                        </div>

                                        <div class="border-top py-2 d-flex justify-content-between align-items-center text-nowrap product-line__data-viwe">
                                            <div class="d-flex">
                            <span class="mr-0 mr-lg-2 views"><span><?$res = CIBlockElement::GetByID($arItem["ID"]);
                                    if($ar_res = $res->GetNext())
                                        echo $ar_res['SHOW_COUNTER'];
                                    ?></span> <i class="icon-visibility"></i></span>

                                                <? if ($USER->IsAuthorized()) { ?>
                                                    <span data-ad_id="<?= $arItem['ID']; ?>" class="product-line__like">To favorites
            <svg id="iconLike" class="iconLike" viewBox="0 0 612 792"><path
                        d="M562.413,284.393c-9.68,41.044-32.121,78.438-64.831,108.07L329.588,542.345l-165.11-149.843 c-32.771-29.691-55.201-67.076-64.892-108.12c-6.965-29.484-4.103-46.14-4.092-46.249l0.147-0.994 c6.395-72.004,56.382-124.273,118.873-124.273c46.111,0,86.703,28.333,105.965,73.933l9.061,21.477l9.061-21.477 c18.958-44.901,61.694-73.922,108.896-73.922c62.481,0,112.478,52.27,119,125.208C566.517,238.242,569.379,254.908,562.413,284.393z"/></svg>
          </span>
                                                <? } else { ?>
                                                    <a data-toggle="modal" data-target="#logInModal"
                                                       class="d-flex align-items-center mr-3"
                                                    <span data-ad_id="<?= $arItem['ID']; ?>" class="product-line__like">To favorites
            <svg id="iconLike" class="iconLike" viewBox="0 0 612 792"><path
                        d="M562.413,284.393c-9.68,41.044-32.121,78.438-64.831,108.07L329.588,542.345l-165.11-149.843 c-32.771-29.691-55.201-67.076-64.892-108.12c-6.965-29.484-4.103-46.14-4.092-46.249l0.147-0.994 c6.395-72.004,56.382-124.273,118.873-124.273c46.111,0,86.703,28.333,105.965,73.933l9.061,21.477l9.061-21.477 c18.958-44.901,61.694-73.922,108.896-73.922c62.481,0,112.478,52.27,119,125.208C566.517,238.242,569.379,254.908,562.413,284.393z"/></svg>
          </span>
                                                    </a>
                                                <? } ?>
                                            </div>
                                            <?
                                            $strDate = getStringDate($arItem['DATE_CREATE']);
                                            ?>
                                            <span class="date"><?=($strDate['MES']) ? GetMessage($strDate['MES']).', '.$strDate['HOURS'] : $strDate['HOURS'];?></span>
                                        </div>
                                    </div>
                                </div>
                                <?if($arItem['PROPERTIES']['LENTA_DATE']['VALUE'] && strtotime($arItem['PROPERTIES']['LENTA_DATE']['VALUE']) > time()){?>
                                    <div class="d-flex marker">

                                        <?
                                        if ($arItem['PROPERTIES']['TYPE_TAPE']['VALUE'] != null){

                                            $entity_data_class = GetEntityDataClass(6);
                                            $rsData = $entity_data_class::getList(array(
                                                'select' => array('*'),
                                                'filter' => array('UF_XML_ID'=> $arItem['PROPERTIES']['TYPE_TAPE']['VALUE'])
                                            ));
                                            while ($arTypesRise = $rsData->fetch()) {?>
                                                <div class="d-flex flex-column decor-rec" style="border-color: <?=$arTypesRise['UF_COLOR']?>;">
                                                    <div class="rec-top"></div>
                                                    <div class="rec-bottom"></div>
                                                </div>
                                                <div class="text" style="background-color: <?=$arTypesRise['UF_COLOR']?>;"><?=$arTypesRise['UF_NAME_RU']?></div>
                                            <? }

                                            ?>

                                        <?}?>
                                    </div>
                                <?}?>
                            </div>
                        </div>
                    </div>
                <?}else{
                    $arNotVip[] = $arItem;
                }}?>
            <div class="row row-cols-2 row-cols-lg-2">
                <?
                $countNotVip = 0;
                foreach($arResult['ITEMS'] as $arItem) {
                    $color = '';
                    if($arItem['PROPERTIES']['COLOR_DATE']['VALUE'] && strtotime($arItem['PROPERTIES']['COLOR_DATE']['VALUE']) > time()) {
                        $color = '#FFF5D9';
                    }
                    ?>
                    <div class="mb-4 col<?if($count <1 and $countNotVip < 1){?> databefore<?}?>">
                        <?$countNotVip++?>
                        <div class="card product-card" style="background-color: <?=$color;?>">
                            <div class="image-block">
                                <div class="i-box">
                                    <a href="<?=$arItem['DETAIL_PAGE_URL']?>"><img src="<?=$arItem['PREVIEW_PICTURE']['SAFE_SRC'] ?? '/no-image.svg'?>" alt="no-img"></a>
                                </div>
                            </div>

                            <div class="px-2 px-lg-3 d-flex justify-content-between">
                                <? if ($USER->IsAuthorized()) { ?>
                                    <p class="mb-0 like followThisItem" data-ad_id="<?= $arItem['ID']; ?>">
                                        <svg id="iconLike" class="iconLike" viewBox="0 0 612 792">
                                            <path d="M562.413,284.393c-9.68,41.044-32.121,78.438-64.831,108.07L329.588,542.345l-165.11-149.843 c-32.771-29.691-55.201-67.076-64.892-108.12c-6.965-29.484-4.103-46.14-4.092-46.249l0.147-0.994 c6.395-72.004,56.382-124.273,118.873-124.273c46.111,0,86.703,28.333,105.965,73.933l9.061,21.477l9.061-21.477 c18.958-44.901,61.694-73.922,108.896-73.922c62.481,0,112.478,52.27,119,125.208C566.517,238.242,569.379,254.908,562.413,284.393z"/>
                                        </svg>
                                    </p>
                                    <?
                                } else { ?>
                                    <a data-toggle="modal" data-target="#logInModal" class="d-flex align-items-center mr-3"
                                       href="#">
                                        <p class="mb-0 like followThisItem" data-ad_id="">
                                            <svg class="iconLike" viewBox="0 0 612 792">
                                                <path d="M562.413,284.393c-9.68,41.044-32.121,78.438-64.831,108.07L329.588,542.345l-165.11-149.843 c-32.771-29.691-55.201-67.076-64.892-108.12c-6.965-29.484-4.103-46.14-4.092-46.249l0.147-0.994 c6.395-72.004,56.382-124.273,118.873-124.273c46.111,0,86.703,28.333,105.965,73.933l9.061,21.477l9.061-21.477 c18.958-44.901,61.694-73.922,108.896-73.922c62.481,0,112.478,52.27,119,125.208C566.517,238.242,569.379,254.908,562.413,284.393z"/>
                                            </svg>
                                        </p>
                                    </a>
                                    <?
                                } ?>
                                <?if($arItem['PROPERTIES']['PRICE']['VALUE'] != null){?>
                                    <p class="mb-0 price"><?=ICON_CURRENCY;?> <?=number_format($arItem['PROPERTIES']['PRICE']['VALUE'], 0, '.', ' ');?></p>
                                <?}?>
                            </div>


                            <div class="px-2 px-lg-3 content-block">
                                <div class="text-right">
                                    <a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="mb-2 mb-lg-3 title"><?=$arItem['NAME']?></a>
                                    <p class="mb-2 mb-lg-3 location">
                                        <span class="addres"><?=$arItem['PROPERTIES']['MAP_LAYOUT']['VALUE'];?> <?=(!empty($arItem['PROPERTIES']['MAP_LAYOUT']['VALUE']))? ',' : ''?> <?=$arItem['PROPERTIES']['MAP_LAYOUT_BIG']['VALUE'];?></span>
                                        <svg class="icon-local" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 513.597 513.597" xml:space="preserve">
              <g>
                  <path d="M263.278,0.107C158.977-3.408,73.323,80.095,73.323,183.602c0,117.469,112.73,202.72,175.915,325.322
                c3.208,6.225,12.169,6.233,15.388,0.009c57.16-110.317,154.854-184.291,172.959-290.569
                C456.331,108.387,374.776,3.866,263.278,0.107z M256.923,279.773c-53.113,0-96.171-43.059-96.171-96.171
                s43.059-96.171,96.171-96.171c53.113,0,96.172,43.059,96.172,96.171S310.036,279.773,256.923,279.773z"></path>
              </g>
            </svg>
                                    </p>
                                </div>

                                <div class="border-top py-2 py-lg-3 d-flex justify-content-between align-items-center text-nowrap">
                                    <span class="mr-0 mr-lg-2 views"><span><?$res = CIBlockElement::GetByID($arItem["ID"]);
                                            if($ar_res = $res->GetNext())
                                                echo $ar_res['SHOW_COUNTER'];
                                            ?></span> <i
                                                class="icon-visibility"></i></span>
                                    <?
                                    $strDate = getStringDate($arItem['DATE_CREATE']);
                                    ?>
                                    <span class="date"><?=($strDate['MES']) ? GetMessage($strDate['MES']).', '.$strDate['HOURS'] : $strDate['HOURS'];?></span>
                                </div>
                            </div>

                            <?if($arItem['PROPERTIES']['LENTA_DATE']['VALUE'] && strtotime($arItem['PROPERTIES']['LENTA_DATE']['VALUE']) > time()){?>
                                <div class="d-flex marker">

                                    <?
                                    if ($arItem['PROPERTIES']['TYPE_TAPE']['VALUE'] != null){

                                        $entity_data_class = GetEntityDataClass(6);
                                        $rsData = $entity_data_class::getList(array(
                                            'select' => array('*'),
                                            'filter' => array('UF_XML_ID'=> $arItem['PROPERTIES']['TYPE_TAPE']['VALUE'])
                                        ));
                                        while ($arTypesRise = $rsData->fetch()) {?>
                                            <div class="d-flex flex-column decor-rec" style="border-color: <?=$arTypesRise['UF_COLOR']?>;">
                                                <div class="rec-top"></div>
                                                <div class="rec-bottom"></div>
                                            </div>
                                            <div class="text" style="background-color: <?=$arTypesRise['UF_COLOR']?>;"><?=$arTypesRise['UF_NAME_RU']?></div>
                                        <? }

                                        ?>

                                    <?}?>
                                </div>
                            <?}?>
                        </div>
                    </div>
                <?}} ?>
            </div>


            <div class="cord_pagination">
                <?=$arResult['NAV_STRING']?>
            </div>
        </div>
    </div>
</div>
</div>
<? require_once $_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH .'/map3.php';?>