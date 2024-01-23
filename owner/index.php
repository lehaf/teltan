<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

/** @global object $APPLICATION */

$APPLICATION->SetTitle("כל הודעות המשתמש");

$request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();
$session = \Bitrix\Main\Application::getInstance()->getSession();

$isUserAdsExist = !empty($_GET['user']) && getUserAdsCount($_GET['user']) > 0 ? true : false;
?>
<div class="preloader">
    <div class="preloader__row">
        <div class="preloader__item"></div>
        <div class="preloader__item"></div>
    </div>
</div>
<div class="container">
    <h1 class="h2 mb-4 subtitle"><?=$APPLICATION->ShowTitle();?></h1>
    <?php if ($request->get('isAjax') === 'y') $APPLICATION->RestartBuffer()?>
    <div id="target_container">
        <div class="mb-5 row d-flex align-items-center">
            <?php $APPLICATION->IncludeComponent(
                "webco:sort.panel",
                "",
                array(
                    'ELEMENTS_EXIST' => $isUserAdsExist,
                    'SORTS' => [
                        [
                            'NAME' => 'Price: Low to High',
                            'SORT' => 'property_PRICE',
                            'ORDER' => 'ASC'
                        ],
                        [
                            'NAME' => 'Price: High to Low',
                            'SORT' => 'property_PRICE',
                            'ORDER' => 'DESC'
                        ],
                        [
                            'NAME' => 'Date: Low to High',
                            'SORT' => 'property_TIME_RAISE',
                            'ORDER' => 'ASC'
                        ],
                        [
                            'NAME' => 'Date: High to Low',
                            'SORT' => 'property_TIME_RAISE',
                            'ORDER' => 'DESC'
                        ]
                    ],
                    'VIEWS' => [
                        'list' => [
                            'CLASS' => 'icon-sirting_line'
                        ],
                        'tile' => [
                            'CLASS' => 'icon-sirting_block'
                        ],
                    ]
                )
            );?>
        </div>
        <?php
        $APPLICATION->IncludeComponent(
            "webco:owner.ads.list",
            $session->get('view'),
            array(
                'MAX_PAGE_ELEMENTS' => 5,
                'CACHE_TIME' => 360000000,
            )
        ); ?>
    </div>
    <?php if ($request->get('isAjax') === 'y') die()?>
</div>
<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>