<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
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
$count = 0;
foreach ($arResult['SECTIONS'] as $arSection) {
    if ($count < 31){
        $arShow[] = $arSection;
    }else{
        $arHide[] = $arSection;
    }
}
?>
<script>console.log(<?=json_encode($arResult)?>)</script>
<div class="mb-5 card auto-mark-list">
    <ul class="mb-3 nav text-right">
        <? foreach ($arShow as $item) {
            $count = CIBlockSection::GetSectionElementsCount($item['ID'], Array("CNT_ACTIVE"=>"Y"));
            if($count < 1){
                continue;
            }
            ?>
            <li><a href="<?=$item['SECTION_PAGE_URL']?>/"><?=$item['NAME']?> <span class="counter"><?=$count;?></span></a></li>
        <?}?>

        <!-- Collapse ALL CAR -->
        <ul class="nav collapse" id="moreCars" style="">
            <? foreach ($arHide as $item) {
                $count = CIBlockSection::GetSectionElementsCount($item['ID'], Array("CNT_ACTIVE"=>"Y"));
                if($count < 1){
                    continue;
                }
                ?>
                <li><a href="<?=$item['SECTION_PAGE_URL']?>/"><?=$item['NAME']?> <span class="counter"><?=$count;?></span></a></li>
            <?}?>
        </ul>
        <!-- Collapse ALL CAR  END-->
    </ul>
    <a class="d-flex justify-content-end text-right collapsed" data-toggle="collapse" href="#moreCars" role="button" aria-expanded="false" aria-controls="moreCars">
        <i class="mr-2 d-flex justify-content-center align-items-center icon-arrow-down-sign-to-navigate-3"></i> All
    </a>
</div>
