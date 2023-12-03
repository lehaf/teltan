<div class="col-12 col-xl-6 justify-content-center">
    <div class="d-flex justify-content-between justify-content-xl-end products-sort">
        <div class="d-flex">
            <a href="#" class="mr-2 d-flex d-lg-none justify-content-center align-items-center products-sort__button filterTogglerMobile">
                <img src="<?=SITE_TEMPLATE_PATH?>/assets/settings.svg" alt="">
            </a>
            <a href="" class="mr-2 d-none d-lg-flex justify-content-center align-items-center products-sort__button">
                <i class="icon-sirting_block"></i>
            </a>
            <a href="" class="mr-2 d-none d-lg-flex justify-content-center align-items-center products-sort__button">
                <i class="icon-sirting_line"></i>
            </a>
        </div>
        <?php
        $text = 'Date: High to Low';
        if($_GET['SORT'] == 'property_PRICE' and $_GET['ORDER'] == 'ASC')
            $text = 'Price: Low to High';
        if($_GET['SORT'] == 'property_PRICE' and $_GET['ORDER'] == 'DESC')
            $text = 'Price: High to Low';
        if($_GET['SORT'] == 'property_TIME_RAISE' and $_GET['ORDER'] == 'ASC')
            $text = 'Date: Low to High';
        if($_GET['SORT'] == 'property_TIME_RAISE' and $_GET['ORDER'] == 'DESC')
            $text = 'Date: High to Low';
        ?>
        <div class="d-flex dropdown">
            <button class="btn bg-white d-flex justify-content-between align-items-center" href="#" role="a" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="icon-arrow-down-sign-to-navigate-3"></i>
                <span class="text-right"><?=$text;?></span>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                <a class="dropdown-item" href="?SORT=property_PRICE&ORDER=ASC">Price: Low to High</a>
                <a class="dropdown-item" href="?SORT=property_PRICE&ORDER=DESC">Price: High to Low</a>
                <a class="dropdown-item" href="?SORT=property_TIME_RAISE&ORDER=ASC">Date: Low to High</a>
                <a class="dropdown-item" href="?SORT=property_TIME_RAISE&ORDER=DESC">Date: High to Low</a>
            </div>
        </div>
    </div>
</div>