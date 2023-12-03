<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
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
<?php if (!empty($arResult['SECTIONS'])):?>
    <div class="mb-5 card auto-mark-list">
        <?php if (!empty($arResult['SECTIONS']['SHOW'])):?>
            <ul class="mb-3 nav text-right">
                <?php foreach ($arResult['SECTIONS']['SHOW'] as $item):?>
                    <li>
                        <a href="<?=$item['SECTION_PAGE_URL']?>">
                            <?=$item['NAME']?> <span class="counter"><?=$item['ELEMENT_CNT'];?></span>
                        </a>
                    </li>
                <?php endforeach?>
                 <?php if (!empty($arResult['SECTIONS']['MORE'])):?>
                    <!-- Collapse ALL CAR -->
                    <ul class="nav collapse" id="moreCars" style="">
                        <?php foreach ($arResult['SECTIONS']['MORE'] as $item):?>
                            <li>
                                <a href="<?=$item['SECTION_PAGE_URL']?>">
                                    <?=$item['NAME']?> <span class="counter"><?=$item['ELEMENT_CNT'];?></span>
                                </a>
                            </li>
                        <?php endforeach;?>
                    </ul>
                    <!-- Collapse ALL CAR  END-->
                 <?php endif;?>
            </ul>
        <?php endif;?>
        <?php if (!empty($arResult['SECTIONS']['MORE'])):?>
            <a class="d-flex justify-content-end text-right collapsed" data-toggle="collapse" href="#moreCars" role="button" aria-expanded="false" aria-controls="moreCars">
                <i class="mr-2 d-flex justify-content-center align-items-center icon-arrow-down-sign-to-navigate-3"></i> All
            </a>
        <?php endif;?>
    </div>
<?php endif;?>