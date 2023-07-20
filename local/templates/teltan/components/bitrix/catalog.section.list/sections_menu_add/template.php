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
<div class="mb-5 row flex-column-reverse flex-lg-row">
    <div class="col-12 col-lg">
        <div class="fleamarket catalog-categories fleamarket-mobile">
            <div class="tab-content" id="v-pills-tabDescriptionContent">
                <!-- mobile back menu btn -->
                <button type="button" class="d-flex d-lg-none justify-content-end btn w-100 border-bottom btn-back">
                    <span class="mr-5 btn-back-arrow"><svg width="5" height="9" viewBox="0 0 5 9" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M0.999999 8L4 4.5L1 1" stroke="#3FB465" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
</span>
                    Назад
                </button>
                <!-- Flea market on click content link-->

                <?
                $isi = 0;
                $i = 0;
                $depth_level = 1;
                foreach($arResult['SECTIONS'] as $k => $section)
                {
                    if($_GET['ids'] == $section['ID'])
                    {

                       $idParenActive = $section['IBLOCK_SECTION_ID'];
                    }
                }
                foreach ($arResult['SECTIONS'] as $k => $section){
                    if ($section['ID'] == $idParenActive){
                        $arResult['SECTIONS'][$k]['ACTIVE_BLOCK'] = 'Y' ;
                    }

                }?>
                <script>console.log(<?=json_encode($arResult)?>)</script>
                <?

                foreach($arResult['SECTIONS'] as $k => $section)
                {

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
                if($section['DEPTH_LEVEL'] == 1)
                {
                if($i > 0)
                {?>
                </ul>
            </div>
            <?}
            ?>

            <div class="tab-pane fade show <?if($section['ACTIVE_BLOCK'] == 'Y'){echo ' active';}?>" id="ad_<?=$section['CODE'];?>" role="tabpanel" aria-labelledby="ad_<?=$section['CODE'];?>-tab">
                <ul>

                    <?

                    }?>
                    <?
                    if($section['DEPTH_LEVEL'] == 2)
                    {?>

                        <li><a data-id_section="<?=$section['ID']?>" class="section_id_a<?if($_GET['ids'] == $section['ID']){echo ' activeSection'; $idParenActive = $section['IBLOCK_SECTION_ID'];}?>"><?=$section['~NAME'];?></a></li>
                        <?
                    }
                    $depth_level = $section['DEPTH_LEVEL'];
                    $i++;
                    }
                    ?>
                </ul>
            </div>
        </div>

        <!-- Flea market categories links-->
        <div class="nav flex-column nav-pills border-left" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <?
            $j = 0;
            foreach($arResult['SECTIONS'] as $k => $section){

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
                if($section['DEPTH_LEVEL'] > 1)
                    continue;
                ?>

                <a class="nav-link  <?if($idParenActive == $section['ID']){echo 'active';}?>" id="ad_<?=$section['CODE'];?>-tab" data-toggle="pill" href="#ad_<?=$section['CODE'];?>" role="tab" aria-controls="ad_<?=$section['CODE'];?>" aria-selected="true">
                    <?=$section['~NAME'];?>
                    <img style=" height: 20px; width: auto; position: absolute;top: 6px;right: 0;" src="<?=CFile::GetPath($section['UF_SVG_ICON_URL']);?>" alt="">
                </a>
                <?$j++;}?>
        </div>
    </div>
</div>

<div class="col-12 col-lg-2">
    <p class="font-weight-bold label-name">Select section</p>
</div>
</div>
