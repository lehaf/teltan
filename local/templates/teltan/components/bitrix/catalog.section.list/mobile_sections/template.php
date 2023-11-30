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
