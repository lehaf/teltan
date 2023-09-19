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
<div class="row">
    <div class="col-12 col-lg-8 col-xl-9">
        <div class="row row-cols-2 row-cols-md-1">
            <?foreach($arResult['ITEMS'] as $item){?>

                <div class="mb-4 col">
                    <div class="card product-card product-line">
                        <div class="card-link">
                            <div class="image-block">
                                <div class="i-box">
                                    <a href="<?=$item['DETAIL_PAGE_URL'];?>"><img src="./img/iphoneX-flea.png" alt="no-img"></a>
                                </div>
                            </div>

                            <div class="px-2 px-lg-3 d-flex justify-content-between like-price">
                                <p class="mb-0 like followThisItem">
                                    <svg id="iconLike" class="iconLike" viewBox="0 0 612 792"><path d="M562.413,284.393c-9.68,41.044-32.121,78.438-64.831,108.07L329.588,542.345l-165.11-149.843 c-32.771-29.691-55.201-67.076-64.892-108.12c-6.965-29.484-4.103-46.14-4.092-46.249l0.147-0.994 c6.395-72.004,56.382-124.273,118.873-124.273c46.111,0,86.703,28.333,105.965,73.933l9.061,21.477l9.061-21.477 c18.958-44.901,61.694-73.922,108.896-73.922c62.481,0,112.478,52.27,119,125.208C566.517,238.242,569.379,254.908,562.413,284.393z"/></svg>
                                </p>

                                <p class="mb-0 price">$27 600</p>
                            </div>

                            <div class="px-2 px-lg-3 content-block">
                                <div class="text-right">
                                    <a href="<?=$item['DETAIL_PAGE_URL'];?>" class="mb-2 mb-lg-3 title"><?=$item['NAME'];?></a>
                                </div>

                                <div class="border-top py-2 d-flex justify-content-between align-items-center text-nowrap product-line__data-viwe">
                                    <div class="d-flex">
                                        <span class="mr-0 mr-lg-2 views"><span>2531</span> <i class="icon-visibility"></i></span>

                                        <span class="product-line__like">To favorites
                <svg id="iconLike" class="iconLike" viewBox="0 0 612 792"><path d="M562.413,284.393c-9.68,41.044-32.121,78.438-64.831,108.07L329.588,542.345l-165.11-149.843 c-32.771-29.691-55.201-67.076-64.892-108.12c-6.965-29.484-4.103-46.14-4.092-46.249l0.147-0.994 c6.395-72.004,56.382-124.273,118.873-124.273c46.111,0,86.703,28.333,105.965,73.933l9.061,21.477l9.061-21.477 c18.958-44.901,61.694-73.922,108.896-73.922c62.481,0,112.478,52.27,119,125.208C566.517,238.242,569.379,254.908,562.413,284.393z"/></svg>
              </span>
                                    </div>

                                    <span class="date">Yesterday, 20:28</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?}?>
            <div class="mb-4 col">
                <div class="card product-card product-line property-product-line" style="background-color: @@bg-color">
                    <div class="card-link">
                        <div class="image-block">
                            <div class="i-box">
                                <a href="#"><img src="./img/room_01.png" alt="no-img"></a>
                            </div>
                        </div>

                        <div class="px-2 px-lg-3 d-flex justify-content-between like-price">
                            <p class="mb-0 like followThisItem">
                                <svg id="iconLike" class="iconLike" viewBox="0 0 612 792"><path d="M562.413,284.393c-9.68,41.044-32.121,78.438-64.831,108.07L329.588,542.345l-165.11-149.843 c-32.771-29.691-55.201-67.076-64.892-108.12c-6.965-29.484-4.103-46.14-4.092-46.249l0.147-0.994 c6.395-72.004,56.382-124.273,118.873-124.273c46.111,0,86.703,28.333,105.965,73.933l9.061,21.477l9.061-21.477 c18.958-44.901,61.694-73.922,108.896-73.922c62.481,0,112.478,52.27,119,125.208C566.517,238.242,569.379,254.908,562.413,284.393z"/></svg>
                            </p>

                            <p class="mb-0 price">$27 600</p>
                        </div>

                        <div class="px-2 px-lg-3 content-block">
                            <div class="text-right">
                                <a href="#" class="mb-2 mb-lg-3 title">Concert tickets for Alisher Morgenstern</a>
                                <p class="mb-2 mb-lg-3 location">
                                    <span class="addres">Tel Aviv-Yafo, Tel Aviv District, Israel</span>
                                    <svg class="icon-local" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                         xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 513.597 513.597" xml:space="preserve">
              <g>
                  <path d="M263.278,0.107C158.977-3.408,73.323,80.095,73.323,183.602c0,117.469,112.73,202.72,175.915,325.322
                c3.208,6.225,12.169,6.233,15.388,0.009c57.16-110.317,154.854-184.291,172.959-290.569
                C456.331,108.387,374.776,3.866,263.278,0.107z M256.923,279.773c-53.113,0-96.171-43.059-96.171-96.171
                s43.059-96.171,96.171-96.171c53.113,0,96.172,43.059,96.172,96.171S310.036,279.773,256.923,279.773z"/>
              </g>
            </svg>
                                </p>
                                <p class="mb-2 mb-lg-3 category">Sale of apartaments</p>
                            </div>

                            <div class="border-top py-2 d-flex justify-content-between align-items-center text-nowrap product-line__data-viwe">
                                <div class="d-flex">
                                    <span class="mr-0 mr-lg-2 views"><span>2531</span> <i class="icon-visibility"></i></span>

                                    <span class="product-line__like">To favorites
            <svg id="iconLike" class="iconLike" viewBox="0 0 612 792"><path d="M562.413,284.393c-9.68,41.044-32.121,78.438-64.831,108.07L329.588,542.345l-165.11-149.843 c-32.771-29.691-55.201-67.076-64.892-108.12c-6.965-29.484-4.103-46.14-4.092-46.249l0.147-0.994 c6.395-72.004,56.382-124.273,118.873-124.273c46.111,0,86.703,28.333,105.965,73.933l9.061,21.477l9.061-21.477 c18.958-44.901,61.694-73.922,108.896-73.922c62.481,0,112.478,52.27,119,125.208C566.517,238.242,569.379,254.908,562.413,284.393z"/></svg>
          </span>
                                </div>

                                <span class="date">Yesterday, 20:28</span>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex marker">
                        <div class="d-flex flex-column decor-rec" style="border-color: #F71A3F;">
                            <div class="rec-top"></div>
                            <div class="rec-bottom"></div>
                        </div>

                        <div class="text" style="background-color: #F71A3F;">Акция</div>
                    </div>
                </div>
            </div>
            <div class="mb-4 col">
                <div
                        class="card product-card product-line auto-product-line"
                        style="background-color: @@bg-color"
                >
                    <div class="card-link">
                        <div class="image-block">
                            <a href="#">
                                <div class="i-box">
                                    <img src="./img/civic-auto.png" alt="no-img" />
                                </div>
                            </a>
                        </div>

                        <div class="px-2 px-lg-3 d-flex justify-content-between like-price">
                            <p class="mb-0 like followThisItem">
                                <svg id="iconLike" class="iconLike" viewBox="0 0 612 792">
                                    <path
                                            d="M562.413,284.393c-9.68,41.044-32.121,78.438-64.831,108.07L329.588,542.345l-165.11-149.843 c-32.771-29.691-55.201-67.076-64.892-108.12c-6.965-29.484-4.103-46.14-4.092-46.249l0.147-0.994 c6.395-72.004,56.382-124.273,118.873-124.273c46.111,0,86.703,28.333,105.965,73.933l9.061,21.477l9.061-21.477 c18.958-44.901,61.694-73.922,108.896-73.922c62.481,0,112.478,52.27,119,125.208C566.517,238.242,569.379,254.908,562.413,284.393z"
                                    />
                                </svg>
                            </p>

                            <p class="mb-0 price">$27 600</p>
                        </div>

                        <div class="px-2 px-lg-3 content-block">
                            <div class="text-right">
                                <a class="mb-2 mb-lg-3 title">Civic V, 2002</a>

                                <div class="row flex-column-reverse flex-lg-row">
                                    <div class="col-12 col-xl">
                                        <p class="d-none d-xl-inline-block">
                                            <span>310 h.p Gas / Petrol, 4.8 l.</span>
                                            <i class="icon-engine"></i>
                                        </p>
                                        <p class="mb-2 mb-lg-3 location">
                                            <span class="addres">Tel Aviv-Yafo, Tel Aviv District, Israel</span>
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
                                        <p class="mb-2 mileage">286 000 km<i class="ml-2 icon-download-speed"></i></p>
                                        <p class="d-none d-xl-inline-block"><span>Manual</span> <i class="ml-2 icon-manual-transmission"></i></p>
                                    </div>
                                </div>
                            </div>

                            <div class="border-top py-2 d-flex justify-content-between align-items-center text-nowrap product-line__data-viwe">
                                <div class="d-flex">
                                    <span class="mr-0 mr-lg-2 views"><span>2531</span> <i class="icon-visibility"></i></span>

                                    <span class="d-none d-lg-flex product-line__like">
            To favorites
            <svg id="iconLike" class="iconLike" viewBox="0 0 612 792">
              <path
                      d="M562.413,284.393c-9.68,41.044-32.121,78.438-64.831,108.07L329.588,542.345l-165.11-149.843 c-32.771-29.691-55.201-67.076-64.892-108.12c-6.965-29.484-4.103-46.14-4.092-46.249l0.147-0.994 c6.395-72.004,56.382-124.273,118.873-124.273c46.111,0,86.703,28.333,105.965,73.933l9.061,21.477l9.061-21.477 c18.958-44.901,61.694-73.922,108.896-73.922c62.481,0,112.478,52.27,119,125.208C566.517,238.242,569.379,254.908,562.413,284.393z"
              />
            </svg>
          </span>
                                </div>

                                <span class="date">Yesterday, 20:28</span>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex marker">
                        <div class="d-flex flex-column decor-rec" style="border-color: #F71A3F;">
                            <div class="rec-top"></div>
                            <div class="rec-bottom"></div>
                        </div>

                        <div class="text" style="background-color: #F71A3F;">Акция</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?include $_SERVER['DOCUMENT_ROOT'].'/personal/left.php'?>

</div>