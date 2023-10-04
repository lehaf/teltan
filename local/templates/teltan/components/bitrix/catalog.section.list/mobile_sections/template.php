<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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

<div class="mobile-menu" id="mainMobileMenu">
    <div class="menu">
        <div class="menu__header">
            <span class="menu-name">Category</span>
            <button class="btn closer">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M2 2L14.5 14.5" stroke="#B4B4B4" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M14.5 2L2 14.5" stroke="#B4B4B4" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>

            </button>
        </div>

        <div class="menu__nav">
            <button type="button" class="nav-item" data-menu-btn="catalog">
                <div class="icon-menu-list"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22.3556 12.0919H18.3488V7.20703C18.3488 6.30234 17.6128 5.56641 16.7081 5.56641H13.2754V2.10914C13.2754 0.946172 12.3292 0 11.1662 0H7.18256C6.01959 0 5.07342 0.946172 5.07342 2.10914V5.56641H1.64063C0.735938 5.56641 0 6.30234 0 7.20703V22.3594C0 23.2641 0.735938 24 1.64063 24C13.1446 24 21.8296 23.9963 22.3556 23.9963C23.2603 23.9963 23.9963 23.2603 23.9963 22.3556V13.732C23.9963 12.8273 23.2603 12.0919 22.3556 12.0919ZM7.18256 1.40625H11.1662C11.5538 1.40625 11.8691 1.72158 11.8691 2.10914V5.56641H6.47967V2.10914C6.47967 1.72158 6.795 1.40625 7.18256 1.40625ZM1.64063 22.5938C1.51125 22.5938 1.40625 22.4888 1.40625 22.3594V7.20703C1.40625 7.07766 1.51125 6.97266 1.64063 6.97266H5.07342V9.04542C5.07342 9.43373 5.38824 9.74855 5.77655 9.74855C6.16486 9.74855 6.47967 9.43373 6.47967 9.04542V6.97266H11.8691V9.04542C11.8691 9.43373 12.1839 9.74855 12.5723 9.74855C12.9606 9.74855 13.2754 9.43373 13.2754 9.04542V6.97266H16.7081C16.8375 6.97266 16.9425 7.07766 16.9425 7.20703V12.0919H10.1156C9.21094 12.0919 8.475 12.8273 8.475 13.732V22.3556C8.475 22.4367 8.4811 22.5159 8.49234 22.5938H1.64063ZM22.59 22.3556C22.59 22.4845 22.485 22.59 22.3556 22.59C21.9663 22.59 10.6801 22.59 10.1156 22.59C9.98672 22.59 9.88125 22.4845 9.88125 22.3556V13.732C9.88125 13.6031 9.98672 13.4981 10.1156 13.4981H22.3556C22.485 13.4981 22.59 13.6031 22.59 13.732V22.3556Z" fill="#2A2A2A"/>
                        <path d="M19.376 15.1378C18.9879 15.1378 18.6729 15.4528 18.6729 15.8409V17.9269C18.6729 18.1748 18.5435 18.3928 18.349 18.518C18.1121 18.6715 18.2753 18.6295 14.502 18.6295C14.1143 18.6295 13.7988 18.3141 13.7988 17.9269V15.8409C13.7988 15.4528 13.4843 15.1378 13.0957 15.1378C12.7076 15.1378 12.3926 15.4528 12.3926 15.8409V17.9269C12.3926 19.0898 13.339 20.0358 14.502 20.0358C18.3048 20.0358 18.0909 20.0487 18.349 20.0016C19.332 19.8225 20.0791 18.9605 20.0791 17.9269V15.8409C20.0791 15.4528 19.7641 15.1378 19.376 15.1378Z" fill="#2A2A2A"/>
                    </svg>
                </div>
                <span class="item-name">Catalog</span>
            </button>

            <a type="button" href="#" class="nav-item">
                <div class="icon-menu-list"><i class="icon-giftbox-1"></i></div>
                <span class="item-name">Draws</span>
            </a>

            <button type="button" class="nav-item" data-menu-btn="fleaMarket">
                <div class="icon-menu-list"><i class="icon-free"></i></div>
                <span class="item-name">Flea Market</span>
                <div class="arrow-list"><?='<?xml version="1.0" encoding="iso-8859-1"?>';?>
                    <!-- Generator: Adobe Illustrator 19.0.0, SVG Export Plug-In . SVG Version: 6.00 Build 0)  -->
                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                         viewBox="0 0 492.004 492.004" style="enable-background:new 0 0 492.004 492.004;" xml:space="preserve">
<g>
    <g>
        <path d="M382.678,226.804L163.73,7.86C158.666,2.792,151.906,0,144.698,0s-13.968,2.792-19.032,7.86l-16.124,16.12
			c-10.492,10.504-10.492,27.576,0,38.064L293.398,245.9l-184.06,184.06c-5.064,5.068-7.86,11.824-7.86,19.028
			c0,7.212,2.796,13.968,7.86,19.04l16.124,16.116c5.068,5.068,11.824,7.86,19.032,7.86s13.968-2.792,19.032-7.86L382.678,265
			c5.076-5.084,7.864-11.872,7.848-19.088C390.542,238.668,387.754,231.884,382.678,226.804z"/>
    </g>
</g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
</svg>
                </div>
            </button>

            <a type="button" href="/property/zhilaya/snyat-j/" class="nav-item">
                <div class="icon-menu-list"><i class="icon-home"></i></div>
                <span class="item-name">Property</span>
            </a>

            <a type="button" href="/auto/" class="nav-item">
                <div class="icon-menu-list"><i class="icon-steering"></i></div>
                <span class="item-name">Auto</span>
            </a>

            <a type="button" href="/moto/" class="nav-item">
                <div class="icon-menu-list"><i class="icon-steering"></i></div>
                <span class="item-name">Moto</span>
            </a>

            <a type="button" href="/scooters/" class="nav-item">
                <div class="icon-menu-list"><i class="icon-steering"></i></div>
                <span class="item-name">Scooters</span>
            </a>
        </div>
    </div>



    <div class="menu submenu" data-submenu="fleaMarket">
        <div class="menu__header">
            <button class="btn back-menu"><svg width="11" height="8" viewBox="0 0 11 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0.1498 3.42321L3.42322 0.14979C3.62294 -0.0499299 3.94684 -0.0499299 4.14656 0.14979C4.34632 0.34955 4.34632 0.673373 4.14656 0.873134L1.74629 3.27341H10.4885C10.771 3.27341 11 3.50243 11 3.78488C11 4.0673 10.771 4.29635 10.4885 4.29635H1.74629L4.14648 6.69663C4.34624 6.89639 4.34624 7.22021 4.14648 7.41997C4.04664 7.51977 3.91571 7.56977 3.78481 7.56977C3.65391 7.56977 3.52302 7.51977 3.42314 7.41997L0.1498 4.14655C-0.0499601 3.94679 -0.0499601 3.62297 0.1498 3.42321Z" fill="white"/>
                </svg>
            </button>
            <span class="menu-name">Flea Market</span>
            <button class="btn closer"><svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M2 2L14.5 14.5" stroke="#B4B4B4" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M14.5 2L2 14.5" stroke="#B4B4B4" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </div>

        <div class="menu__nav">

            <?foreach($arResult['SECTIONS'] as $section){
                switch (LANGUAGE_ID){
                    case 'en':
                        $section['NAME'] = $section['UF_NAME_EN'];
                        $section['~NAME'] = $section['~UF_NAME_EN'];
                        break;
                    case 'he':
                        $section['NAME'] = $section['UF_NAME_HEB'];
                        $section['~NAME'] = $section['~UF_NAME_HEB'];
                        break;
                }

                if(!$section['IBLOCK_SECTION_ID']){

                    if($subsection)
                    {
                        foreach($subsection as $k => $subItem)
                        {?>
                            <div class="collapse" id="<?=$k;?>">
                                <?foreach($subItem as $item){?>
                                    <a href="<?=$item['SECTION_PAGE_URL'];?>" class="nav-item link">
                                        <span><?=$item['NAME'];?></span>
                                    </a>
                                <?}?>
                            </div>
                        <?}
                    }
                    unset($subsection);
                ?>
                    <button type="button" class="nav-item collapsed" data-toggle="collapse" data-target="#subMenuCatalog_<?=$section['ID'];?>" aria-expanded="false" aria-controls="subMenuCatalog_<?=$section['ID'];?>">

                            <div class="icon-menu-list">
                                <img src="<?=CFile::GetPath($section['UF_SVG_ICON_URL']);?>" alt="">
                            </div>

                        <span class="item-name"><?=$section['NAME'];?></span>
                        <div class="arrow-list"><?='<?xml version="1.0" encoding="iso-8859-1"?>';?>
                            <!-- Generator: Adobe Illustrator 19.0.0, SVG Export Plug-In . SVG Version: 6.00 Build 0)  -->
                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                 viewBox="0 0 492.004 492.004" style="enable-background:new 0 0 492.004 492.004;" xml:space="preserve">
    <g>
        <g>
            <path d="M382.678,226.804L163.73,7.86C158.666,2.792,151.906,0,144.698,0s-13.968,2.792-19.032,7.86l-16.124,16.12
                c-10.492,10.504-10.492,27.576,0,38.064L293.398,245.9l-184.06,184.06c-5.064,5.068-7.86,11.824-7.86,19.028
                c0,7.212,2.796,13.968,7.86,19.04l16.124,16.116c5.068,5.068,11.824,7.86,19.032,7.86s13.968-2.792,19.032-7.86L382.678,265
                c5.076-5.084,7.864-11.872,7.848-19.088C390.542,238.668,387.754,231.884,382.678,226.804z"/>
        </g>
    </g>
                                <g>
                                </g>
                                <g>
                                </g>
                                <g>
                                </g>
                                <g>
                                </g>
                                <g>
                                </g>
                                <g>
                                </g>
                                <g>
                                </g>
                                <g>
                                </g>
                                <g>
                                </g>
                                <g>
                                </g>
                                <g>
                                </g>
                                <g>
                                </g>
                                <g>
                                </g>
                                <g>
                                </g>
                                <g>
                                </g>
    </svg>
                        </div>
                    </button>
                <?} else {
                    $subsection['subMenuCatalog_'.$section['IBLOCK_SECTION_ID']][] = $section;
                }?>
            <?}?>
        </div>
    </div>
</div>
