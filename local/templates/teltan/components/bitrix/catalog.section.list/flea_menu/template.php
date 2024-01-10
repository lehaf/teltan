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
$activeMainSectionId = array_key_first($arResult['SECTIONS']);
?>
<?php if (!empty($arResult['SECTIONS'])):?>
    <div class="tab-content" id="v-pills-tabContent">
        <button type="button" class="d-flex d-lg-none justify-content-end btn w-100 border-bottom btn-back">
            <span class="mr-5 btn-back-arrow">
                <svg width="5" height="9" viewBox="0 0 5 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0.999999 8L4 4.5L1 1" stroke="#3FB465" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </span>
            Назад
        </button>
        <!-- Flea market on click content link-->
        <?php foreach ($arResult['SECTIONS'] as $key => $sectionMain):?>
            <div class="tab-pane fade show <?=$key === $activeMainSectionId ? ' active' : ''?>"
                 id="menu_<?=$sectionMain['CODE'];?>"
                 role="tabpanel"
                 aria-labelledby="ad_<?=$sectionMain['CODE'];?>-tab"
            >
                <ul>
                    <?foreach ($sectionMain['ITEMS'] as $subKey => $subsection):?>
                        <li>
                            <a href="<?=$subsection['SECTION_PAGE_URL']?>"
                               data-id_section="<?=$subsection['ID']?>"
                               class="section_id_a"
                            >
                                <?=$subsection['NAME'];?>
                            </a>
                        </li>
                    <?endforeach;?>
                </ul>
            </div>
        <?endforeach;?>
    </div>
    <!-- Flea market categories links-->
    <div class="nav flex-column nav-pills border-left" id="v-pills-tab" role="tablist" aria-orientation="vertical">
        <?php foreach ($arResult['SECTIONS'] as $key => $sectionMain):?>
            <?if (empty($sectionMain['ITEMS'])) continue;?>
            <a class="nav-link  <?=$activeMainSectionId == $key ? 'active' : ''?>"
               id="menu_<?=$sectionMain['CODE'];?>-tab"
               data-toggle="pill"
               href="#menu_<?=$sectionMain['CODE'];?>"
               role="tab"
               aria-controls="ad_<?=$sectionMain['CODE'];?>"
               aria-selected="true"
            >
                <?=$sectionMain['NAME'];?>
                <img style=" height: 20px; width: auto; position: absolute;top: 6px;right: 0;"
                     src="<?=CFile::GetPath($sectionMain['UF_SVG_ICON_URL']);?>"
                     alt="<?=$sectionMain['NAME']?>"
                     title="<?=$sectionMain['NAME']?>"
                >
            </a>
        <?endforeach;?>
    </div>
<?php endif;?>