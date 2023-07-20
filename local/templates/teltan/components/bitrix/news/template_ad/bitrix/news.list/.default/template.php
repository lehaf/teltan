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

<h1 class="h2 mb-4 subtitle">
    <?=$arResult['SECTION']['PATH'][0]['NAME'];?>
</h1>

<div class="row row-cols-1 row-cols-lg-2">
    <div class="col col-lg-9">
        <div class="mb-5 row d-flex align-items-center">
            <?=$arResult["NAV_STRING"]?>

            <div class="col-12 col-xl-6 justify-content-center"><div class="d-flex justify-content-between justify-content-xl-end products-sort">
                    <div class="d-flex">
                        <a href="#" class="mr-2 d-flex d-lg-none justify-content-center align-items-center products-sort__button filterTogglerMobile">
                            <img src="<?=SITE_TEMPLATE_PATH;?>/assets/settings.svg" alt="">
                        </a>

                        <a href="?display=block" class="mr-2 d-none d-lg-flex justify-content-center align-items-center products-sort__button">
                            <i class="icon-sirting_block"></i>
                        </a>

                        <a href="?display=list" class="mr-2 d-none d-lg-flex justify-content-center align-items-center products-sort__button">
                            <i class="icon-sirting_line"></i>
                        </a>
                    </div>

                    <div class="d-flex dropdown">
                        <button class="btn bg-white d-flex justify-content-between align-items-center" href="#" role="a" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="icon-arrow-down-sign-to-navigate-3"></i>
                            <span class="text-right">Price: Low to High</span>
                        </button>

                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="?sort_p=asc">Price: Low to High</a>
                            <a class="dropdown-item" href="?sort_p=desc">Price: High to Low</a>
                            <a class="dropdown-item" href="?sort_d=asc">Date: Low to High</a>
                            <a class="dropdown-item" href="?sort_d=desc">Date: High to Low</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?
        $now = time();
        foreach($arResult["ITEMS"] as $arItem)
        {
            if(strtotime($arItem['PROPERTIES']['VIP_DATE']['VALUE']) > $now)
            {?>
                <div class="mb-3">
                    <div class="card product-card product-line product-line-vip" style="background-color: @@bg-color">
                        <div class="card-link">
                            <div class="image-block">
                                <div class="i-box">
                                    <a href="#"><img src="<?=SITE_TEMPLATE_PATH;?>/img/earphones.png" alt="no-img"></a>
                                </div>
                            </div>

                            <div class="px-2 px-lg-3 d-flex justify-content-between like-price">
                                <p class="mb-0 like followThisItem">
                                    <svg id="iconLike" class="iconLike" viewBox="0 0 612 792"><path d="M562.413,284.393c-9.68,41.044-32.121,78.438-64.831,108.07L329.588,542.345l-165.11-149.843 c-32.771-29.691-55.201-67.076-64.892-108.12c-6.965-29.484-4.103-46.14-4.092-46.249l0.147-0.994 c6.395-72.004,56.382-124.273,118.873-124.273c46.111,0,86.703,28.333,105.965,73.933l9.061,21.477l9.061-21.477 c18.958-44.901,61.694-73.922,108.896-73.922c62.481,0,112.478,52.27,119,125.208C566.517,238.242,569.379,254.908,562.413,284.393z"/></svg>
                                </p>

                                <p class="mb-0 price">$27 600</p>

                                <div class="vip-marker">
                                    <div class="mr-2 icon">
                                        <svg width="14" height="13" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1.01141 2.346L3.74531 4.23405L6.4701 0.282625C6.53032 0.195214 6.60981 0.123964 6.70197 0.0748055C6.79413 0.0256466 6.8963 0 6.99996 0C7.10362 0 7.20578 0.0256466 7.29794 0.0748055C7.39011 0.123964 7.4696 0.195214 7.52982 0.282625L10.2546 4.23405L12.9885 2.346C13.092 2.27468 13.213 2.23555 13.3372 2.23321C13.4615 2.23087 13.5838 2.26542 13.6897 2.33279C13.7956 2.40016 13.8807 2.49753 13.9349 2.61338C13.989 2.72923 14.0101 2.85874 13.9955 2.98658L12.926 12.4046C12.9074 12.5686 12.8312 12.7198 12.7121 12.8296C12.593 12.9393 12.4391 13 12.2796 13H1.72027C1.56084 13 1.40695 12.9393 1.28781 12.8296C1.16867 12.7198 1.09255 12.5686 1.0739 12.4046L0.0044209 2.98591C-0.0100298 2.85812 0.0111158 2.72871 0.0653613 2.61296C0.119607 2.49722 0.204688 2.39996 0.31056 2.33268C0.416433 2.26541 0.538677 2.23091 0.662862 2.23327C0.787047 2.23563 0.907988 2.27474 1.01141 2.346ZM6.99996 8.95417C7.34523 8.95417 7.67637 8.81209 7.92051 8.55918C8.16466 8.30626 8.30182 7.96324 8.30182 7.60557C8.30182 7.24789 8.16466 6.90487 7.92051 6.65196C7.67637 6.39904 7.34523 6.25696 6.99996 6.25696C6.65468 6.25696 6.32355 6.39904 6.07941 6.65196C5.83526 6.90487 5.6981 7.24789 5.6981 7.60557C5.6981 7.96324 5.83526 8.30626 6.07941 8.55918C6.32355 8.81209 6.65468 8.95417 6.99996 8.95417Z" fill="#F50000"/>
                                        </svg>

                                    </div>

                                    <span class="text">vip</span>
                                </div>
                            </div>

                            <div class="px-2 px-lg-3 content-block">
                                <div class="text-right">
                                    <a href="#" class="mb-2 mb-lg-3 title"><?=$arItem['NAME'];?></a>
                                    <a href="#" class="mb-2 mb-lg-4 category">Sale of apartaments</a>
                                </div>

                                <div class="border-top py-2 d-flex justify-content-between align-items-center text-nowrap product-line__data-viwe">
                                    <div class="d-flex">
                                        <span class="mr-2 views"><span>2531</span> <i class="icon-visibility"></i></span>

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
            <?}
            else
            {

            }
        }
        ?>


        <div class="row row-cols-2 row-cols-lg-1">
            <div class="mb-3 col">
                <div class="card product-card product-line" style="background-color: #FFF5D9">
                    <div class="card-link">
                        <div class="image-block">
                            <div class="i-box">
                                <a href="#"><img src="<?=SITE_TEMPLATE_PATH;?>/img/flea-item-3.png" alt="no-img"></a>
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
                                <a href="#" class="mb-2 mb-lg-4 category">Sale of apartaments</a>
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
            <div class="mb-3 col">
                <div class="card product-card product-line" style="background-color: @@bg-color">
                    <div class="card-link">
                        <div class="image-block">
                            <div class="i-box">
                                <a href="#"><img src="<?=SITE_TEMPLATE_PATH;?>/assets/no-image.svg" alt="no-img"></a>
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
                                <a href="#" class="mb-2 mb-lg-4 category">Sale of apartaments</a>
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
                        <div class="d-flex flex-column decor-rec" style="border-color: #3FD1FF;">
                            <div class="rec-top"></div>
                            <div class="rec-bottom"></div>
                        </div>

                        <div class="text" style="background-color: #3FD1FF;">Выгодная цена</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <div class="card product-card product-line product-line-vip" style="background-color: @@bg-color">
                <div class="card-link">
                    <div class="image-block">
                        <div class="i-box">
                            <a href="#"><img src="<?=SITE_TEMPLATE_PATH;?>/img/earphones.png" alt="no-img"></a>
                        </div>
                    </div>

                    <div class="px-2 px-lg-3 d-flex justify-content-between like-price">
                        <p class="mb-0 like followThisItem">
                            <svg id="iconLike" class="iconLike" viewBox="0 0 612 792"><path d="M562.413,284.393c-9.68,41.044-32.121,78.438-64.831,108.07L329.588,542.345l-165.11-149.843 c-32.771-29.691-55.201-67.076-64.892-108.12c-6.965-29.484-4.103-46.14-4.092-46.249l0.147-0.994 c6.395-72.004,56.382-124.273,118.873-124.273c46.111,0,86.703,28.333,105.965,73.933l9.061,21.477l9.061-21.477 c18.958-44.901,61.694-73.922,108.896-73.922c62.481,0,112.478,52.27,119,125.208C566.517,238.242,569.379,254.908,562.413,284.393z"/></svg>
                        </p>

                        <p class="mb-0 price">$27 600</p>

                        <div class="vip-marker">
                            <div class="mr-2 icon">
                                <svg width="14" height="13" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1.01141 2.346L3.74531 4.23405L6.4701 0.282625C6.53032 0.195214 6.60981 0.123964 6.70197 0.0748055C6.79413 0.0256466 6.8963 0 6.99996 0C7.10362 0 7.20578 0.0256466 7.29794 0.0748055C7.39011 0.123964 7.4696 0.195214 7.52982 0.282625L10.2546 4.23405L12.9885 2.346C13.092 2.27468 13.213 2.23555 13.3372 2.23321C13.4615 2.23087 13.5838 2.26542 13.6897 2.33279C13.7956 2.40016 13.8807 2.49753 13.9349 2.61338C13.989 2.72923 14.0101 2.85874 13.9955 2.98658L12.926 12.4046C12.9074 12.5686 12.8312 12.7198 12.7121 12.8296C12.593 12.9393 12.4391 13 12.2796 13H1.72027C1.56084 13 1.40695 12.9393 1.28781 12.8296C1.16867 12.7198 1.09255 12.5686 1.0739 12.4046L0.0044209 2.98591C-0.0100298 2.85812 0.0111158 2.72871 0.0653613 2.61296C0.119607 2.49722 0.204688 2.39996 0.31056 2.33268C0.416433 2.26541 0.538677 2.23091 0.662862 2.23327C0.787047 2.23563 0.907988 2.27474 1.01141 2.346ZM6.99996 8.95417C7.34523 8.95417 7.67637 8.81209 7.92051 8.55918C8.16466 8.30626 8.30182 7.96324 8.30182 7.60557C8.30182 7.24789 8.16466 6.90487 7.92051 6.65196C7.67637 6.39904 7.34523 6.25696 6.99996 6.25696C6.65468 6.25696 6.32355 6.39904 6.07941 6.65196C5.83526 6.90487 5.6981 7.24789 5.6981 7.60557C5.6981 7.96324 5.83526 8.30626 6.07941 8.55918C6.32355 8.81209 6.65468 8.95417 6.99996 8.95417Z" fill="#F50000"/>
                                </svg>

                            </div>

                            <span class="text">vip</span>
                        </div>
                    </div>

                    <div class="px-2 px-lg-3 content-block">
                        <div class="text-right">
                            <a href="#" class="mb-2 mb-lg-3 title">Concert tickets for Alisher Morgenstern</a>
                            <a href="#" class="mb-2 mb-lg-4 category">Sale of apartaments</a>
                        </div>

                        <div class="border-top py-2 d-flex justify-content-between align-items-center text-nowrap product-line__data-viwe">
                            <div class="d-flex">
                                <span class="mr-2 views"><span>2531</span> <i class="icon-visibility"></i></span>

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

        <div class="mb-3">
            <div class="card product-card product-line product-line-vip" style="background-color: #FFF5D9">
                <div class="card-link">
                    <div class="image-block">
                        <div class="i-box">
                            <a href="#"><img src="<?=SITE_TEMPLATE_PATH;?>/img/gloves.png" alt="no-img"></a>
                        </div>
                    </div>

                    <div class="px-2 px-lg-3 d-flex justify-content-between like-price">
                        <p class="mb-0 like followThisItem">
                            <svg id="iconLike" class="iconLike" viewBox="0 0 612 792"><path d="M562.413,284.393c-9.68,41.044-32.121,78.438-64.831,108.07L329.588,542.345l-165.11-149.843 c-32.771-29.691-55.201-67.076-64.892-108.12c-6.965-29.484-4.103-46.14-4.092-46.249l0.147-0.994 c6.395-72.004,56.382-124.273,118.873-124.273c46.111,0,86.703,28.333,105.965,73.933l9.061,21.477l9.061-21.477 c18.958-44.901,61.694-73.922,108.896-73.922c62.481,0,112.478,52.27,119,125.208C566.517,238.242,569.379,254.908,562.413,284.393z"/></svg>
                        </p>

                        <p class="mb-0 price">$27 600</p>

                        <div class="vip-marker">
                            <div class="mr-2 icon">
                                <svg width="14" height="13" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1.01141 2.346L3.74531 4.23405L6.4701 0.282625C6.53032 0.195214 6.60981 0.123964 6.70197 0.0748055C6.79413 0.0256466 6.8963 0 6.99996 0C7.10362 0 7.20578 0.0256466 7.29794 0.0748055C7.39011 0.123964 7.4696 0.195214 7.52982 0.282625L10.2546 4.23405L12.9885 2.346C13.092 2.27468 13.213 2.23555 13.3372 2.23321C13.4615 2.23087 13.5838 2.26542 13.6897 2.33279C13.7956 2.40016 13.8807 2.49753 13.9349 2.61338C13.989 2.72923 14.0101 2.85874 13.9955 2.98658L12.926 12.4046C12.9074 12.5686 12.8312 12.7198 12.7121 12.8296C12.593 12.9393 12.4391 13 12.2796 13H1.72027C1.56084 13 1.40695 12.9393 1.28781 12.8296C1.16867 12.7198 1.09255 12.5686 1.0739 12.4046L0.0044209 2.98591C-0.0100298 2.85812 0.0111158 2.72871 0.0653613 2.61296C0.119607 2.49722 0.204688 2.39996 0.31056 2.33268C0.416433 2.26541 0.538677 2.23091 0.662862 2.23327C0.787047 2.23563 0.907988 2.27474 1.01141 2.346ZM6.99996 8.95417C7.34523 8.95417 7.67637 8.81209 7.92051 8.55918C8.16466 8.30626 8.30182 7.96324 8.30182 7.60557C8.30182 7.24789 8.16466 6.90487 7.92051 6.65196C7.67637 6.39904 7.34523 6.25696 6.99996 6.25696C6.65468 6.25696 6.32355 6.39904 6.07941 6.65196C5.83526 6.90487 5.6981 7.24789 5.6981 7.60557C5.6981 7.96324 5.83526 8.30626 6.07941 8.55918C6.32355 8.81209 6.65468 8.95417 6.99996 8.95417Z" fill="#F50000"/>
                                </svg>

                            </div>

                            <span class="text">vip</span>
                        </div>
                    </div>

                    <div class="px-2 px-lg-3 content-block">
                        <div class="text-right">
                            <a href="#" class="mb-2 mb-lg-3 title">Concert tickets for Alisher Morgenstern</a>
                            <a href="#" class="mb-2 mb-lg-4 category">Sale of apartaments</a>
                        </div>

                        <div class="border-top py-2 d-flex justify-content-between align-items-center text-nowrap product-line__data-viwe">
                            <div class="d-flex">
                                <span class="mr-2 views"><span>2531</span> <i class="icon-visibility"></i></span>

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

        <div class="row row-cols-2 row-cols-lg-1">
            <div class="mb-3 col">
                <div class="card product-card product-line" style="background-color: @@bg-color">
                    <div class="card-link">
                        <div class="image-block">
                            <div class="i-box">
                                <a href="#"><img src="<?=SITE_TEMPLATE_PATH;?>/img/iphone.jpg" alt="no-img"></a>
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
                                <a href="#" class="mb-2 mb-lg-4 category">Sale of apartaments</a>
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
            <div class="mb-3 col">
                <div class="card product-card product-line" style="background-color: @@bg-color">
                    <div class="card-link">
                        <div class="image-block">
                            <div class="i-box">
                                <a href="#"><img src="<?=SITE_TEMPLATE_PATH;?>/img/iphoneX-flea.png" alt="no-img"></a>
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
                                <a href="#" class="mb-2 mb-lg-4 category">Sale of apartaments</a>
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
        </div>

        <div class="mt-5 mb-5 d-flex justify-content-center">
            <nav class="mb-4 mb-xl-0 justify-content-between justify-content-md-center pagination" aria-label="">
                <button class="prev"><img src="<?=SITE_TEMPLATE_PATH;?>/assets/paginaton-arrow.svg" alt=""></button>

                <div class="mx-3 dots">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>

                <ul class="p-0 m-0 d-flex flex-row-reverse">
                    <li class="d-none d-md-flex pagination__list-item">
                        <a href="#">1</a>
                    </li>

                    <li class="mr-2 pagination__list-item">
                        <a href="#">2</a>
                    </li>

                    <li class="mr-2 pagination__list-item active">
                        <a href="#">3</a>
                    </li>

                    <li class="mr-2 pagination__list-item">
                        <a href="#">4</a>
                    </li>

                    <li class="d-none d-md-flex mr-2 pagination__list-item">
                        <a href="#">5</a>
                    </li>
                </ul>

                <div class="mx-3 dots">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>

                <button class="next"><img src="<?=SITE_TEMPLATE_PATH;?>/assets/paginaton-arrow.svg" alt=""></button>
            </nav>
        </div>

        <div class="flex-column">
            <p class="h1 mb-4 subtitle">
                Computers & Accessories
            </p>

            <p class="text-right">
                Praising has great, loves give chooses who consequences resultant all which resultant expound that — are desires will of
                pain. Produces — pursue fault has pursue to will anyone those who loves procure occur was. Account rejects, desires happiness
                complete painful praising from builder all enjoy not can, take but ever desires there one, do. Truth praising idea,
                him, can of explain fault born not.

                <br><br>

                Consequences this pursue one take example desires annoying — master, pain circumstances extremely,
                but a the do toil. Of right because was, are to complete dislikes with trivial how example, painful a fault: builder,
                mistaken occur that can chooses. Occasionally account rationally pursues fault, of avoids human this fault.
            </p>
        </div>
    </div>
