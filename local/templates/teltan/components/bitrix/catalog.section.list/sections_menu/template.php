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

        <div class="tab-content" id="v-pills-tabContent">
            <button type="button" class="d-flex d-lg-none justify-content-end btn w-100 border-bottom btn-back"><span class="mr-5 btn-back-arrow"><svg width="5" height="9" viewBox="0 0 5 9" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M0.999999 8L4 4.5L1 1" stroke="#3FB465" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
</span> Назад</button>
            <script>console.log(<?=json_encode($arResult['SECTIONS'][0]['SECTION_PAGE_URL'])?>)</script>
            <script>console.log(<?=json_encode($_SERVER['SCRIPT_URL'])?>)</script>
            <?



            $isi = 0;
            $i = 0;
            $depth_level = 1;
            foreach($arResult['SECTIONS'] as $k => $section)
            {
            $pos = strpos($_SERVER['SCRIPT_URL'], $section['SECTION_PAGE_URL']);
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
                    <div class="tab-pane fade show <?=($pos !== false)? 'active' : ''?>" id="<?=$section['CODE'];?>" role="tabpanel" aria-labelledby="<?=$section['CODE'];?>-tab">
                            <ul>

                <?

                }?>
                <?
                if($section['DEPTH_LEVEL'] == 2)
                {?>
                    <li><a class="<?=($pos !== false)? 'activeSection' : ''?>" href="<?=$section['SECTION_PAGE_URL'];?>"><?=$section['NAME'];?><img tyle="width: auto;" src="<?=CFile::GetPath($section['~UF_SVG_ICON_URL'])?>" alt=""></a></li>
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
                $pos = strpos($_SERVER['SCRIPT_URL'], $section['SECTION_PAGE_URL']);

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
                <a class="nav-link  <?=($pos !== false)? 'active' : ''?>" id="<?=$section['CODE'];?>-tab" data-toggle="pill" href="#<?=$section['CODE'];?>" role="tab" aria-controls="<?=$section['CODE'];?>" aria-selected="true">
                    <?=$section['~NAME'];?>
                    <img style="height: 20px;width: auto; position: absolute;top: 6px;right: 0;" src="<?=CFile::GetPath($section['~UF_SVG_ICON_URL'])?>" alt="">
                </a>
            <?$j++;}?>

        </div>
