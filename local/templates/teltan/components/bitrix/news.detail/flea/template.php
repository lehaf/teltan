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
use Bitrix\Main\Localization\Loc;
$this->setFrameMode(true);
?>
<?global $arSetting;?>
<?if($_GET['TEST'] == 'Y'){?>
<pre>
    <?=var_dump($arResult)?>
</pre>
<?}?>
    <div class="container">
        <div class="row flex-column-reverse flex-lg-row mb-4">
            <div class="col-12 col-lg-4 flex-column">
                <div class="d-none d-lg-block">

                    <?if(!$arParams['USER_ID']){?>
                        <div class="mb-4 card connection-with-seller text-right">
                            <h1 class="mb-4 connection-with-seller__title"><?=$arResult['NAME'];?></h1>

                            <p class="mb-4 connection-with-seller__price text-primary">
                                <?=number_format($arResult['PROPERTIES']['PRICE']['VALUE'], 0, '.', ' ');?> <?=ICON_CURRENCY;?>
                            </p>

                            <?if($arResult['PROPERTIES']['LOCALITY']['VALUE']){?>
                                <p class="pb-3 border-bottom">
                                    <span class="mr-1"><?=$arResult['PROPERTIES']['LOCALITY']['VALUE'];?></span>
                                    <svg class="icon-local" style="position: relative; width: 16px; top: -2px; fill: #747474" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 513.597 513.597" xml:space="preserve">
                                      <g>
                                          <path d="M263.278,0.107C158.977-3.408,73.323,80.095,73.323,183.602c0,117.469,112.73,202.72,175.915,325.322
                                        c3.208,6.225,12.169,6.233,15.388,0.009c57.16-110.317,154.854-184.291,172.959-290.569
                                        C456.331,108.387,374.776,3.866,263.278,0.107z M256.923,279.773c-53.113,0-96.171-43.059-96.171-96.171
                                        s43.059-96.171,96.171-96.171c53.113,0,96.172,43.059,96.172,96.171S310.036,279.773,256.923,279.773z"></path>
                                      </g>
                                    </svg>
                                </p>
                            <?}?>

                            <div class="mb-4 row no-gutters">
                                <button class="mr-2 col btn btn-show-phone text-uppercase font-weight-bold" disabled>Show Phone</button>
                                <button class="ml-2 col btn btn-primary text-uppercase font-weight-bold" disabled>Send Message</button>
                            </div>

                            <p class="text-unaurh-user">To view a phone number or send a message, you must enter your
                                personal account</p>

                            <div class="row">
                                <div class="col">
                                    <ul class="nav justify-content-end font-weight-bold">
                                        <li class="mr-4 justify-content-center">
                                            <a class="" href="#" data-toggle="modal" data-target="#registerModal">
                                                <span class="mr-2">Register</span>
                                                <i class="icon-user-1"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="" href="#" data-toggle="modal" data-target="#logInModal">
                                                <span class="mr-2">Sign In</span>
                                                <i class="icon-log-in"></i>
                                            </a>
                                        </li>
                                    </ul>
                                    <?include $_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH."/includes/footer/register_modal.php";?>
                                    <?include $_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH."/includes/footer/auth_modal.php";?>
                                </div>
                            </div>
                        </div>

                    <?} elseif($arParams['USER_ID'] == $arResult['PROPERTIES']['ID_USER']['VALUE']){?>

                        <div class="mb-4 card connection-with-seller text-right">
                            <h1 class="mb-4 connection-with-seller__title"><?=$arResult['NAME'];?></h1>

                            <p class="mb-4 connection-with-seller__price text-primary">
                                <?=number_format($arResult['PROPERTIES']['PRICE']['VALUE'], 0, '.', ' ');?> <?=ICON_CURRENCY;?>
                            </p>

                            <?if($arResult['PROPERTIES']['LOCALITY']['VALUE']){?>
                                <p class="pb-3 border-bottom">
                                    <span class="mr-1"><?=$arResult['PROPERTIES']['LOCALITY']['VALUE'];?></span>
                                    <svg class="icon-local" style="position: relative; width: 16px; top: -2px; fill: #747474" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 513.597 513.597" xml:space="preserve">
                                      <g>
                                          <path d="M263.278,0.107C158.977-3.408,73.323,80.095,73.323,183.602c0,117.469,112.73,202.72,175.915,325.322
                                        c3.208,6.225,12.169,6.233,15.388,0.009c57.16-110.317,154.854-184.291,172.959-290.569
                                        C456.331,108.387,374.776,3.866,263.278,0.107z M256.923,279.773c-53.113,0-96.171-43.059-96.171-96.171
                                        s43.059-96.171,96.171-96.171c53.113,0,96.172,43.059,96.172,96.171S310.036,279.773,256.923,279.773z"></path>
                                      </g>
                                    </svg>
                                </p>
                            <?}?>

                            <div class="flex-column">
                                <button class="mb-3 w-100 btn btn-primary text-uppercase font-weight-bold">Edit</button>
                                <button class="w-100 btn btn-accelerate-sale text-uppercase font-weight-bold btn-accelerate-sale"><span><svg width="31" height="18" viewBox="0 0 31 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M29.4417 3.27725H14.2853L14.06 0.734453C14.0231 0.318623 13.6792 0 13.2671 0H11.6496C11.2099 0 10.8535 0.361101 10.8535 0.806543C10.8535 1.25198 11.2099 1.61309 11.6496 1.61309H12.5393C13.0254 7.10073 11.7689 -7.08279 13.4549 11.9479C13.5199 12.6928 13.9171 13.5011 14.6014 14.0503C13.3676 15.6466 14.495 18 16.502 18C18.1678 18 19.3427 16.3168 18.7715 14.7226H23.1286C22.558 16.3147 23.7304 18 25.398 18C26.7289 18 27.8116 16.9031 27.8116 15.5548C27.8116 14.2064 26.7289 13.1095 25.398 13.1095H16.5074C15.9026 13.1095 15.3757 12.7399 15.1482 12.2013L27.8708 11.4438C28.2181 11.4231 28.512 11.1763 28.5964 10.8343L30.214 4.2794C30.3394 3.77113 29.9597 3.27725 29.4417 3.27725ZM16.502 16.3869C16.0491 16.3869 15.6806 16.0136 15.6806 15.5548C15.6806 15.0959 16.0491 14.7226 16.502 14.7226C16.9549 14.7226 17.3234 15.0959 17.3234 15.5548C17.3234 16.0136 16.9549 16.3869 16.502 16.3869ZM25.398 16.3869C24.9451 16.3869 24.5766 16.0136 24.5766 15.5548C24.5766 15.0959 24.9451 14.7226 25.398 14.7226C25.8509 14.7226 26.2194 15.0959 26.2194 15.5548C26.2194 16.0136 25.8509 16.3869 25.398 16.3869ZM27.1936 9.86828L14.9339 10.5982L14.4282 4.8903H28.4221L27.1936 9.86828Z" fill="white"/>
                                    <path d="M10.509 8.05168C10.6904 8.02447 10.8535 8.16495 10.8535 8.34836V10.6516C10.8535 10.8351 10.6904 10.9755 10.509 10.9483L2.83139 9.79668C2.49072 9.74558 2.49072 9.25442 2.83139 9.20332L10.509 8.05168Z" fill="white"/>
                                    <path d="M10.5111 5.04892C10.6918 5.0231 10.8535 5.16334 10.8535 5.3459V6.6541C10.8535 6.83666 10.6918 6.9769 10.5111 6.95108L5.93241 6.29698C5.58898 6.24792 5.58898 5.75208 5.93241 5.70302L10.5111 5.04892Z" fill="white"/>
                                    <path d="M10.5111 12.0489C10.6918 12.0231 10.8535 12.1633 10.8535 12.3459V13.6541C10.8535 13.8367 10.6918 13.9769 10.5111 13.9511L5.93241 13.297C5.58898 13.2479 5.58898 12.7521 5.93241 12.703L10.5111 12.0489Z" fill="white"/>
                                    </svg>
                                    </span> Ускорить продажу</button>
                            </div>
                        </div>


                    <?} else {?>

                        <div class="mb-4 card connection-with-seller text-right">
                            <h1 class="mb-4 connection-with-seller__title"><?=$arResult['NAME'];?></h1>

                            <p class="mb-4 connection-with-seller__price text-primary">
                                <?=number_format($arResult['PROPERTIES']['PRICE']['VALUE'], 0, '.', ' ');?> <?=ICON_CURRENCY;?>
                            </p>

                            <?if($arResult['PROPERTIES']['LOCALITY']['VALUE']){?>
                                <p class="pb-3 border-bottom">
                                    <span class="mr-1"><?=$arResult['PROPERTIES']['LOCALITY']['VALUE'];?></span>
                                    <svg class="icon-local" style="position: relative; width: 16px; top: -2px; fill: #747474" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 513.597 513.597" xml:space="preserve">
                                      <g>
                                          <path d="M263.278,0.107C158.977-3.408,73.323,80.095,73.323,183.602c0,117.469,112.73,202.72,175.915,325.322
                                        c3.208,6.225,12.169,6.233,15.388,0.009c57.16-110.317,154.854-184.291,172.959-290.569
                                        C456.331,108.387,374.776,3.866,263.278,0.107z M256.923,279.773c-53.113,0-96.171-43.059-96.171-96.171
                                        s43.059-96.171,96.171-96.171c53.113,0,96.172,43.059,96.172,96.171S310.036,279.773,256.923,279.773z"></path>
                                      </g>
                                    </svg>
                                </p>
                            <?}?>
                            <div class="row no-gutters">
                                <button class="mr-2 col btn btn-show-phone text-uppercase font-weight-bold" data-toggle="collapse" href="#showContactPhone" role="button" aria-expanded="false" aria-controls="showContactPhone">Show Phone</button>

                                <button class="ml-2 col btn btn-primary text-uppercase font-weight-bold" data-toggle="modal" data-target="#modalSandMessage">Send Message</button>
                            </div>

                            <ul class="text-right collapse contact-list" id="showContactPhone">
                                <li class="d-flex justify-content-end">
                                    <p class="mb-0 d-flex align-items-center time">
                                        to <span class="mx-2">9:00</span> from <span class="mx-2">20:00</span>
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9.99 0C4.47 0 0 4.48 0 10C0 15.52 4.47 20 9.99 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 9.99 0ZM10 18C5.58 18 2 14.42 2 10C2 5.58 5.58 2 10 2C14.42 2 18 5.58 18 10C18 14.42 14.42 18 10 18ZM9.78 5H9.72C9.32 5 9 5.32 9 5.72V10.44C9 10.79 9.18 11.12 9.49 11.3L13.64 13.79C13.98 13.99 14.42 13.89 14.62 13.55C14.6702 13.469 14.7036 13.3788 14.7182 13.2846C14.7328 13.1905 14.7283 13.0943 14.705 13.002C14.6817 12.9096 14.64 12.8229 14.5824 12.7469C14.5249 12.671 14.4526 12.6074 14.37 12.56L10.5 10.26V5.72C10.5 5.32 10.18 5 9.78 5Z" fill="#555555"/>
                                        </svg>

                                    </p>
                                </li>
                                <li><a href="tel:+74956751020">+7 495 675 10 20</a></li>
                                <li><a href="tel:+74956751020">+7 495 675 10 20</a></li>
                                <li><a href="tel:+74956751020">+7 495 675 10 20</a></li>
                            </ul>
                        </div>

                    <?}?>

                </div>
                <div class="mb-4 card seller-card text-right">
                    <p class="text-uppercase seller-card__title"><?=Loc::getMessage('SELLER');?></p>

                    <div class="mb-4 d-flex justify-content-end align-items-center">
                        <div class="seller-card__data">
                            <span class="name"><?=$arResult['USER']['NAME'];?></span>
                            <p class="m-0 d-flex justify-content-end align-items-center<?=(!$arResult['USER']['IS_ONLINE']) ? ' offline' : '';?>">
                                <span class="status">Online</span>
                                <span class="status_dot"></span>
                            </p>

                            <span class="date-registration">Registered: <?=$arResult['USER']['DATE_REGISTER'];?></span>
                        </div>
                        <div class="seller-card__photo">
                            <img src="<?=SITE_TEMPLATE_PATH;?>/img/seller-photo.png" alt="">
                        </div>
                    </div>

                    <button class="w-100 btn btn-primary text-uppercase btn-author-add">All author's ads</button>
                </div>
            </div>

            <div class="col-12 col-lg-8">
                <div class="item-slider">
                  <span class="add-item-favorite">
                    <svg id="iconLike" class="iconLike" viewBox="0 0 612 792"><path d="M562.413,284.393c-9.68,41.044-32.121,78.438-64.831,108.07L329.588,542.345l-165.11-149.843 c-32.771-29.691-55.201-67.076-64.892-108.12c-6.965-29.484-4.103-46.14-4.092-46.249l0.147-0.994 c6.395-72.004,56.382-124.273,118.873-124.273c46.111,0,86.703,28.333,105.965,73.933l9.061,21.477l9.061-21.477 c18.958-44.901,61.694-73.922,108.896-73.922c62.481,0,112.478,52.27,119,125.208C566.517,238.242,569.379,254.908,562.413,284.393z"/></svg>
                  </span>

                    <div class="slider-for">
                        <?
                        foreach($arResult['PHOTOS'] as $k => $item)
                        {?>
                            <div class="slide" data-toggle="modal" data-target="#modalFullSize" data-current-slider="<?=$k;?>">
                                <img src="<?=$item['BIG'];?>" alt="">
                            </div>
                        <?}
                        ?>
                    </div>

                    <div class="dots slider-nav">
                        <?
                        $count = count($arResult['PHOTOS']);
                        foreach($arResult['PHOTOS'] as $k => $item)
                        {?>
                            <?
                            if($count > 10 && $k == 9)
                            {?>
                                <div class="dot all-photo" data-toggle="modal" data-target="#modalFullSize">
                                    <img src="<?=$item['SMALL'];?>" alt="">
                                        <span class="text">Еще <?=($count - 10);?> фото</span>
                                   </div>
                            <?break;}
                            else
                            {?>
                                <div class="dot" data-slide="<?=$k;?>">
                                    <img src="<?=$item['SMALL'];?>" alt="">
                                </div>
                            <?}

                            ?>
                        <?}
                        ?>

                    </div>

                    <div class="modal fade" id="modalFullSize" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                        <div class="modal-dialog m-0 mw-100" role="document">
                            <div class="modal-content bg-transparent">
                                <div class="fullScreenItemModal">
                                    <button type="button" class="m-0 mr-auto close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>

                                    <div class="slider-counter-mobile">
                                    </div>

                                    <div class="fullScreenItemModal__content">
                                        <div class="row h-100">
                                            <div class="col-3 seller-cards">
                                                <div class="mb-4 card connection-with-seller text-right">
                                                    <h1 class="mb-4 connection-with-seller__title"><?=$arResult['NAME'];?></h1>

                                                    <p class="mb-4 connection-with-seller__price text-primary">
                                                        <?=number_format($arResult['PROPERTIES']['PRICE']['VALUE'], 0, '.', ' ');?> <?=ICON_CURRENCY;?>
                                                    </p>

                                                    <?if($arResult['PROPERTIES']['LOCALITY']['VALUE']){?>
                                                        <p class="pb-3 border-bottom">
                                                            <span class="mr-1"><?=$arResult['PROPERTIES']['LOCALITY']['VALUE'];?></span>
                                                            <svg class="icon-local" style="position: relative; width: 16px; top: -2px; fill: #747474" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 513.597 513.597" xml:space="preserve">
                                                              <g>
                                                                  <path d="M263.278,0.107C158.977-3.408,73.323,80.095,73.323,183.602c0,117.469,112.73,202.72,175.915,325.322
                                                                c3.208,6.225,12.169,6.233,15.388,0.009c57.16-110.317,154.854-184.291,172.959-290.569
                                                                C456.331,108.387,374.776,3.866,263.278,0.107z M256.923,279.773c-53.113,0-96.171-43.059-96.171-96.171
                                                                s43.059-96.171,96.171-96.171c53.113,0,96.172,43.059,96.172,96.171S310.036,279.773,256.923,279.773z"></path>
                                                              </g>
                                                            </svg>
                                                        </p>
                                                    <?}?>

                                                    <div class="row no-gutters">
                                                        <button class="mr-2 col btn btn-show-phone text-uppercase font-weight-bold" data-toggle="collapse" href="#showContactPhone" role="button" aria-expanded="false" aria-controls="showContactPhone">Show Phone</button>

                                                        <button class="ml-2 col btn btn-primary text-uppercase font-weight-bold" data-toggle="modal" data-target="#modalSandMessage">Send Message</button>
                                                    </div>

                                                    <ul class="text-right collapse contact-list" id="showContactPhone">
                                                        <li class="d-flex justify-content-end">
                                                            <p class="mb-0 d-flex align-items-center time">
                                                                to <span class="mx-2">9:00</span> from <span class="mx-2">20:00</span>
                                                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M9.99 0C4.47 0 0 4.48 0 10C0 15.52 4.47 20 9.99 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 9.99 0ZM10 18C5.58 18 2 14.42 2 10C2 5.58 5.58 2 10 2C14.42 2 18 5.58 18 10C18 14.42 14.42 18 10 18ZM9.78 5H9.72C9.32 5 9 5.32 9 5.72V10.44C9 10.79 9.18 11.12 9.49 11.3L13.64 13.79C13.98 13.99 14.42 13.89 14.62 13.55C14.6702 13.469 14.7036 13.3788 14.7182 13.2846C14.7328 13.1905 14.7283 13.0943 14.705 13.002C14.6817 12.9096 14.64 12.8229 14.5824 12.7469C14.5249 12.671 14.4526 12.6074 14.37 12.56L10.5 10.26V5.72C10.5 5.32 10.18 5 9.78 5Z" fill="#555555"/>
                                                                </svg>

                                                            </p>
                                                        </li>
                                                        <li><a href="tel:+74956751020">+7 495 675 10 20</a></li>
                                                        <li><a href="tel:+74956751020">+7 495 675 10 20</a></li>
                                                        <li><a href="tel:+74956751020">+7 495 675 10 20</a></li>
                                                    </ul>
                                                </div>
                                                <div class="mb-4 card connection-with-seller text-right">
                                                    <h1 class="mb-4 connection-with-seller__title"><?=$arResult['NAME'];?></h1>

                                                    <p class="mb-4 connection-with-seller__price text-primary">
                                                        <?=number_format($arResult['PROPERTIES']['PRICE']['VALUE'], 0, '.', ' ');?> <?=ICON_CURRENCY;?>
                                                    </p>

                                                    <?if($arResult['PROPERTIES']['LOCALITY']['VALUE']){?>
                                                        <p class="pb-3 border-bottom">
                                                            <span class="mr-1"><?=$arResult['PROPERTIES']['LOCALITY']['VALUE'];?></span>
                                                            <svg class="icon-local" style="position: relative; width: 16px; top: -2px; fill: #747474" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 513.597 513.597" xml:space="preserve">
                                                              <g>
                                                                  <path d="M263.278,0.107C158.977-3.408,73.323,80.095,73.323,183.602c0,117.469,112.73,202.72,175.915,325.322
                                                                c3.208,6.225,12.169,6.233,15.388,0.009c57.16-110.317,154.854-184.291,172.959-290.569
                                                                C456.331,108.387,374.776,3.866,263.278,0.107z M256.923,279.773c-53.113,0-96.171-43.059-96.171-96.171
                                                                s43.059-96.171,96.171-96.171c53.113,0,96.172,43.059,96.172,96.171S310.036,279.773,256.923,279.773z"></path>
                                                              </g>
                                                            </svg>
                                                        </p>
                                                    <?}?>

                                                    <div class="flex-column">
                                                        <button class="mb-3 w-100 btn btn-primary text-uppercase font-weight-bold">Edit</button>
                                                        <button class="w-100 btn btn-accelerate-sale text-uppercase font-weight-bold btn-accelerate-sale"><span><svg width="31" height="18" viewBox="0 0 31 18" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M29.4417 3.27725H14.2853L14.06 0.734453C14.0231 0.318623 13.6792 0 13.2671 0H11.6496C11.2099 0 10.8535 0.361101 10.8535 0.806543C10.8535 1.25198 11.2099 1.61309 11.6496 1.61309H12.5393C13.0254 7.10073 11.7689 -7.08279 13.4549 11.9479C13.5199 12.6928 13.9171 13.5011 14.6014 14.0503C13.3676 15.6466 14.495 18 16.502 18C18.1678 18 19.3427 16.3168 18.7715 14.7226H23.1286C22.558 16.3147 23.7304 18 25.398 18C26.7289 18 27.8116 16.9031 27.8116 15.5548C27.8116 14.2064 26.7289 13.1095 25.398 13.1095H16.5074C15.9026 13.1095 15.3757 12.7399 15.1482 12.2013L27.8708 11.4438C28.2181 11.4231 28.512 11.1763 28.5964 10.8343L30.214 4.2794C30.3394 3.77113 29.9597 3.27725 29.4417 3.27725ZM16.502 16.3869C16.0491 16.3869 15.6806 16.0136 15.6806 15.5548C15.6806 15.0959 16.0491 14.7226 16.502 14.7226C16.9549 14.7226 17.3234 15.0959 17.3234 15.5548C17.3234 16.0136 16.9549 16.3869 16.502 16.3869ZM25.398 16.3869C24.9451 16.3869 24.5766 16.0136 24.5766 15.5548C24.5766 15.0959 24.9451 14.7226 25.398 14.7226C25.8509 14.7226 26.2194 15.0959 26.2194 15.5548C26.2194 16.0136 25.8509 16.3869 25.398 16.3869ZM27.1936 9.86828L14.9339 10.5982L14.4282 4.8903H28.4221L27.1936 9.86828Z" fill="white"/>
<path d="M10.509 8.05168C10.6904 8.02447 10.8535 8.16495 10.8535 8.34836V10.6516C10.8535 10.8351 10.6904 10.9755 10.509 10.9483L2.83139 9.79668C2.49072 9.74558 2.49072 9.25442 2.83139 9.20332L10.509 8.05168Z" fill="white"/>
<path d="M10.5111 5.04892C10.6918 5.0231 10.8535 5.16334 10.8535 5.3459V6.6541C10.8535 6.83666 10.6918 6.9769 10.5111 6.95108L5.93241 6.29698C5.58898 6.24792 5.58898 5.75208 5.93241 5.70302L10.5111 5.04892Z" fill="white"/>
<path d="M10.5111 12.0489C10.6918 12.0231 10.8535 12.1633 10.8535 12.3459V13.6541C10.8535 13.8367 10.6918 13.9769 10.5111 13.9511L5.93241 13.297C5.58898 13.2479 5.58898 12.7521 5.93241 12.703L10.5111 12.0489Z" fill="white"/>
</svg>
</span> Ускорить продажу</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="main-contetnt col-12 col-xl-9">
                                                <div class="row h-100">
                                                    <div class="col-12 col-xl-10">
                                                        <div class="mainItemSlider">
                                                            <div class="slide">
                                                                <div class="h-100 d-flex justify-content-center align-items-center" style="background: #EEEDED">
                                                                    <svg width="182" height="148" viewBox="0 0 182 148" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <rect width="182" height="148" fill="#EEEDED"/>
                                                                        <path d="M125 43.434L121.566 40L57 104.566L60.434 108L65.2911 103.143H115.286C116.573 103.141 117.808 102.629 118.718 101.718C119.629 100.808 120.141 99.5733 120.143 98.2857V48.2911L125 43.434ZM115.286 98.2857H70.1483L89.0741 79.3599L94.8517 85.1374C95.7626 86.048 96.9978 86.5595 98.2857 86.5595C99.5737 86.5595 100.809 86.048 101.72 85.1374L105.571 81.2857L115.286 90.9927V98.2857ZM115.286 84.1223L109.005 77.842C108.095 76.9314 106.859 76.4199 105.571 76.4199C104.283 76.4199 103.048 76.9314 102.137 77.842L98.2857 81.6937L92.513 75.921L115.286 53.1483V84.1223Z" fill="#C6C6C6"/>
                                                                        <path d="M66.7146 88.5715V81.2857L78.8574 69.1502L82.1918 72.487L85.6307 69.0482L82.2914 65.7089C81.3806 64.7983 80.1454 64.2868 78.8574 64.2868C77.5695 64.2868 76.3343 64.7983 75.4234 65.7089L66.7146 74.4177V49.7143H105.572V44.8572H66.7146C65.4268 44.8585 64.1921 45.3706 63.2815 46.2812C62.3709 47.1918 61.8587 48.4265 61.8574 49.7143V88.5715H66.7146Z" fill="#C6C6C6"/>
                                                                    </svg>

                                                                </div>
                                                            </div>

                                                            <?
                                                            foreach($arResult['PHOTOS'] as $k => $item)
                                                            {?>
                                                                <div class="slide">
                                                                    <img src="<?=$item['ORIG'];?>" alt="">
                                                                </div>
                                                            <?}
                                                            ?>
                                                        </div>
                                                    </div>

                                                    <div class="d-none d-xl-flex col-xl-2">
                                                        <div class="dots navMainItemSlider">

                                                            <?
                                                            foreach($arResult['PHOTOS'] as $k => $item)
                                                            {?>
                                                                <div class="dots__dot">
                                                                    <img src="<?=$item['SMALL_2'];?>" alt="">
                                                                </div>
                                                            <?}
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="info-and-coll-btn">
                                        <div class="d-flex flex-column">
                                            <p class="price"><?=number_format($arResult['PROPERTIES']['PRICE']['VALUE'], 0, '.', ' ');?> <?=ICON_CURRENCY;?></p>
                                            <p class="mb-0 title"><?=$arResult['NAME'];?></p>
                                        </div>

                                        <div class="d-flex justify-content-center align-items-center call-item">
                                            <a href="tel:+375293069433" class="btn"><svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M11.3239 12.0618L12.7799 10.6058C12.976 10.4122 13.2242 10.2796 13.4942 10.2242C13.7642 10.1688 14.0444 10.193 14.3009 10.2938L16.0754 11.0023C16.3347 11.1076 16.5569 11.2872 16.7143 11.5185C16.8716 11.7498 16.9569 12.0226 16.9594 12.3023V15.5523C16.9579 15.7426 16.9179 15.9307 16.8418 16.1051C16.7657 16.2795 16.6551 16.4368 16.5167 16.5673C16.3782 16.6979 16.2148 16.7991 16.0362 16.8648C15.8576 16.9306 15.6675 16.9595 15.4774 16.9498C3.04294 16.1763 0.533938 5.64633 0.0594376 1.61633C0.037411 1.41843 0.0575361 1.21811 0.118489 1.02854C0.179442 0.838978 0.279841 0.664466 0.413081 0.51649C0.546322 0.368513 0.709384 0.250424 0.89154 0.169993C1.0737 0.0895611 1.27082 0.0486092 1.46994 0.0498313H4.60944C4.88959 0.0506605 5.1631 0.135285 5.39476 0.29282C5.62643 0.450356 5.80568 0.673597 5.90944 0.933831L6.61794 2.70833C6.7221 2.96383 6.74868 3.24435 6.69434 3.51486C6.64001 3.78537 6.50718 4.03387 6.31244 4.22933L4.85644 5.68533C4.85644 5.68533 5.69494 11.3598 11.3239 12.0618Z" fill="white"/>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-block d-lg-none">

                    <?if(!$arParams['USER_ID']){?>
                        <div class="mb-4 card connection-with-seller text-right">
                            <h1 class="mb-4 connection-with-seller__title"><?=$arResult['NAME'];?></h1>

                            <p class="mb-4 connection-with-seller__price text-primary">
                                <?=number_format($arResult['PROPERTIES']['PRICE']['VALUE'], 0, '.', ' ');?> <?=ICON_CURRENCY;?>
                            </p>

                            <?if($arResult['PROPERTIES']['LOCALITY']['VALUE']){?>
                                <p class="pb-3 border-bottom">
                                    <span class="mr-1"><?=$arResult['PROPERTIES']['LOCALITY']['VALUE'];?></span>
                                    <svg class="icon-local" style="position: relative; width: 16px; top: -2px; fill: #747474" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 513.597 513.597" xml:space="preserve">
                                      <g>
                                          <path d="M263.278,0.107C158.977-3.408,73.323,80.095,73.323,183.602c0,117.469,112.73,202.72,175.915,325.322
                                        c3.208,6.225,12.169,6.233,15.388,0.009c57.16-110.317,154.854-184.291,172.959-290.569
                                        C456.331,108.387,374.776,3.866,263.278,0.107z M256.923,279.773c-53.113,0-96.171-43.059-96.171-96.171
                                        s43.059-96.171,96.171-96.171c53.113,0,96.172,43.059,96.172,96.171S310.036,279.773,256.923,279.773z"></path>
                                      </g>
                                    </svg>
                                </p>
                            <?}?>

                            <div class="mb-4 row no-gutters">
                                <button class="mr-2 col btn btn-show-phone text-uppercase font-weight-bold" disabled>Show Phone</button>
                                <button class="ml-2 col btn btn-primary text-uppercase font-weight-bold" disabled>Send Message</button>
                            </div>

                            <p class="text-unaurh-user">To view a phone number or send a message, you must enter your
                                personal account</p>

                            <div class="row">
                                <div class="col">
                                    <ul class="nav justify-content-end font-weight-bold">
                                        <li class="mr-4 justify-content-center">
                                            <a class="" href="#" data-toggle="modal" data-target="#registerModal">
                                                <span class="mr-2">Register</span>
                                                <i class="icon-user-1"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="" href="#" data-toggle="modal" data-target="#logInModal">
                                                <span class="mr-2">Sign In</span>
                                                <i class="icon-log-in"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?} elseif($arParams['USER_ID'] == $arResult['PROPERTIES']['ID_USER']['VALUE']){?>
                        <div class="mb-4 card connection-with-seller text-right">
                            <h1 class="mb-4 connection-with-seller__title"><?=$arResult['NAME'];?></h1>

                            <p class="mb-4 connection-with-seller__price text-primary">
                                <?=number_format($arResult['PROPERTIES']['PRICE']['VALUE'], 0, '.', ' ');?> <?=ICON_CURRENCY;?>
                            </p>

                            <?if($arResult['PROPERTIES']['LOCALITY']['VALUE']){?>
                                <p class="pb-3 border-bottom">
                                    <span class="mr-1"><?=$arResult['PROPERTIES']['LOCALITY']['VALUE'];?></span>
                                    <svg class="icon-local" style="position: relative; width: 16px; top: -2px; fill: #747474" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 513.597 513.597" xml:space="preserve">
                                      <g>
                                          <path d="M263.278,0.107C158.977-3.408,73.323,80.095,73.323,183.602c0,117.469,112.73,202.72,175.915,325.322
                                        c3.208,6.225,12.169,6.233,15.388,0.009c57.16-110.317,154.854-184.291,172.959-290.569
                                        C456.331,108.387,374.776,3.866,263.278,0.107z M256.923,279.773c-53.113,0-96.171-43.059-96.171-96.171
                                        s43.059-96.171,96.171-96.171c53.113,0,96.172,43.059,96.172,96.171S310.036,279.773,256.923,279.773z"></path>
                                      </g>
                                    </svg>
                                </p>
                            <?}?>

                            <div class="flex-column">
                                <button class="mb-3 w-100 btn btn-primary text-uppercase font-weight-bold">Edit</button>
                                <button class="w-100 btn btn-accelerate-sale text-uppercase font-weight-bold btn-accelerate-sale"><span><svg width="31" height="18" viewBox="0 0 31 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M29.4417 3.27725H14.2853L14.06 0.734453C14.0231 0.318623 13.6792 0 13.2671 0H11.6496C11.2099 0 10.8535 0.361101 10.8535 0.806543C10.8535 1.25198 11.2099 1.61309 11.6496 1.61309H12.5393C13.0254 7.10073 11.7689 -7.08279 13.4549 11.9479C13.5199 12.6928 13.9171 13.5011 14.6014 14.0503C13.3676 15.6466 14.495 18 16.502 18C18.1678 18 19.3427 16.3168 18.7715 14.7226H23.1286C22.558 16.3147 23.7304 18 25.398 18C26.7289 18 27.8116 16.9031 27.8116 15.5548C27.8116 14.2064 26.7289 13.1095 25.398 13.1095H16.5074C15.9026 13.1095 15.3757 12.7399 15.1482 12.2013L27.8708 11.4438C28.2181 11.4231 28.512 11.1763 28.5964 10.8343L30.214 4.2794C30.3394 3.77113 29.9597 3.27725 29.4417 3.27725ZM16.502 16.3869C16.0491 16.3869 15.6806 16.0136 15.6806 15.5548C15.6806 15.0959 16.0491 14.7226 16.502 14.7226C16.9549 14.7226 17.3234 15.0959 17.3234 15.5548C17.3234 16.0136 16.9549 16.3869 16.502 16.3869ZM25.398 16.3869C24.9451 16.3869 24.5766 16.0136 24.5766 15.5548C24.5766 15.0959 24.9451 14.7226 25.398 14.7226C25.8509 14.7226 26.2194 15.0959 26.2194 15.5548C26.2194 16.0136 25.8509 16.3869 25.398 16.3869ZM27.1936 9.86828L14.9339 10.5982L14.4282 4.8903H28.4221L27.1936 9.86828Z" fill="white"/>
                                    <path d="M10.509 8.05168C10.6904 8.02447 10.8535 8.16495 10.8535 8.34836V10.6516C10.8535 10.8351 10.6904 10.9755 10.509 10.9483L2.83139 9.79668C2.49072 9.74558 2.49072 9.25442 2.83139 9.20332L10.509 8.05168Z" fill="white"/>
                                    <path d="M10.5111 5.04892C10.6918 5.0231 10.8535 5.16334 10.8535 5.3459V6.6541C10.8535 6.83666 10.6918 6.9769 10.5111 6.95108L5.93241 6.29698C5.58898 6.24792 5.58898 5.75208 5.93241 5.70302L10.5111 5.04892Z" fill="white"/>
                                    <path d="M10.5111 12.0489C10.6918 12.0231 10.8535 12.1633 10.8535 12.3459V13.6541C10.8535 13.8367 10.6918 13.9769 10.5111 13.9511L5.93241 13.297C5.58898 13.2479 5.58898 12.7521 5.93241 12.703L10.5111 12.0489Z" fill="white"/>
                                    </svg>
                                    </span> Ускорить продажу</button>
                            </div>
                        </div>
                    <?} else {?>

                        <div class="mb-4 card connection-with-seller text-right">
                            <h1 class="mb-4 connection-with-seller__title"><?=$arResult['NAME'];?></h1>

                            <p class="mb-4 connection-with-seller__price text-primary">
                                <?=number_format($arResult['PROPERTIES']['PRICE']['VALUE'], 0, '.', ' ');?> <?=ICON_CURRENCY;?>
                            </p>

                            <?if($arResult['PROPERTIES']['LOCALITY']['VALUE']){?>
                                <p class="pb-3 border-bottom">
                                    <span class="mr-1"><?=$arResult['PROPERTIES']['LOCALITY']['VALUE'];?></span>
                                    <svg class="icon-local" style="position: relative; width: 16px; top: -2px; fill: #747474" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 513.597 513.597" xml:space="preserve">
                                      <g>
                                          <path d="M263.278,0.107C158.977-3.408,73.323,80.095,73.323,183.602c0,117.469,112.73,202.72,175.915,325.322
                                        c3.208,6.225,12.169,6.233,15.388,0.009c57.16-110.317,154.854-184.291,172.959-290.569
                                        C456.331,108.387,374.776,3.866,263.278,0.107z M256.923,279.773c-53.113,0-96.171-43.059-96.171-96.171
                                        s43.059-96.171,96.171-96.171c53.113,0,96.172,43.059,96.172,96.171S310.036,279.773,256.923,279.773z"></path>
                                      </g>
                                    </svg>
                                </p>
                            <?}?>

                            <div class="row no-gutters">
                                <button class="mr-2 col btn btn-show-phone text-uppercase font-weight-bold" data-toggle="collapse" href="#showContactPhone" role="button" aria-expanded="false" aria-controls="showContactPhone">Show Phone</button>

                                <button class="ml-2 col btn btn-primary text-uppercase font-weight-bold" data-toggle="modal" data-target="#modalSandMessage">Send Message</button>
                            </div>

                            <ul class="text-right collapse contact-list" id="showContactPhone">
                                <li class="d-flex justify-content-end">
                                    <p class="mb-0 d-flex align-items-center time">
                                        to <span class="mx-2">9:00</span> from <span class="mx-2">20:00</span>
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9.99 0C4.47 0 0 4.48 0 10C0 15.52 4.47 20 9.99 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 9.99 0ZM10 18C5.58 18 2 14.42 2 10C2 5.58 5.58 2 10 2C14.42 2 18 5.58 18 10C18 14.42 14.42 18 10 18ZM9.78 5H9.72C9.32 5 9 5.32 9 5.72V10.44C9 10.79 9.18 11.12 9.49 11.3L13.64 13.79C13.98 13.99 14.42 13.89 14.62 13.55C14.6702 13.469 14.7036 13.3788 14.7182 13.2846C14.7328 13.1905 14.7283 13.0943 14.705 13.002C14.6817 12.9096 14.64 12.8229 14.5824 12.7469C14.5249 12.671 14.4526 12.6074 14.37 12.56L10.5 10.26V5.72C10.5 5.32 10.18 5 9.78 5Z" fill="#555555"/>
                                        </svg>

                                    </p>
                                </li>
                                <li><a href="tel:+74956751020">+7 495 675 10 20</a></li>
                                <li><a href="tel:+74956751020">+7 495 675 10 20</a></li>
                                <li><a href="tel:+74956751020">+7 495 675 10 20</a></li>
                            </ul>
                        </div>
                    <?}?>

                </div>

                <div class="mb-4 card text-right">
                    <div class="about-item">
                        <div class="about-item__characteristics">
                            <div class="btn characteristics-item">Condition: Used</div>
                            <div class="btn characteristics-item">Product type: Mobile phones / smartphones</div>
                            <div class="btn characteristics-item">Ads from Private person</div>
                            <div class="btn characteristics-item">Operating system: iOS</div>
                            <div class="btn characteristics-item">Screen diagonal: 5.55 "-6"</div>
                            <div class="btn characteristics-item">Phone brand: Apple</div>
                        </div>

                        <p class="about-item__text">
                            <?=$arResult['PREVIEW_TEXT'];?>
                        </p>
                        <div class="d-flex justify-content-between">
                            <div class="viewers">
                                <span class="mr-3"><?=$arResult['SHOW_COUNTER'];?></span>
                                <i class="icon-visibility"></i>
                            </div>

                            <?
                            $strDate = getStringDate($arResult['DATE_CREATE']);
                            ?>
                            <div class="date"><?=($strDate['MES']) ? GetMessage($strDate['MES']).', '.$strDate['HOURS'] : $strDate['HOURS'];?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?if($arResult['SIMILAR']){?>
            <h2 class="mb-4 subtitle">
                Similar products
            </h2>
            <div class="similar-products-slider">
                <?foreach($arResult['SIMILAR'] as $arItem){?>
                    <?
                    $color = '';
                    if($arItem['PROPERTY_COLOR_DATE_VALUE'] && strtotime($arItem['PROPERTY_COLOR_DATE_VALUE']) > time())
                        $color = '#FFF5D9';
                    ?>
                    <div class="card product-card" style="background-color: <?=$color;?>">
                        <div class="image-block">
                            <div class="i-box">
                                
                                <a href="<?=$arItem['DETAIL_PAGE_URL'];?>"><img src="<?=SITE_TEMPLATE_PATH;?>/img/flea-item-3.png" alt="no-img"></a>
                            </div>
                        </div>

                        <div class="px-2 px-lg-3 d-flex justify-content-between">
                            <p class="mb-0 like followThisItem" data-ad_id="<?=$arItem['ID'];?>">
                                <svg id="iconLike" class="iconLike" viewBox="0 0 612 792"><path d="M562.413,284.393c-9.68,41.044-32.121,78.438-64.831,108.07L329.588,542.345l-165.11-149.843 c-32.771-29.691-55.201-67.076-64.892-108.12c-6.965-29.484-4.103-46.14-4.092-46.249l0.147-0.994 c6.395-72.004,56.382-124.273,118.873-124.273c46.111,0,86.703,28.333,105.965,73.933l9.061,21.477l9.061-21.477 c18.958-44.901,61.694-73.922,108.896-73.922c62.481,0,112.478,52.27,119,125.208C566.517,238.242,569.379,254.908,562.413,284.393z"/></svg>
                            </p>

                            <p class="mb-0 price"><?=ICON_CURRENCY;?> <?=number_format($arItem['PROPERTY_PRICE_VALUE'], 0, '.', ' ');?></p>
                        </div>

                        <div class="px-2 px-lg-3 content-block">
                            <div class="text-right">
                                <a class="mb-2 mb-lg-3 title"><?=$arItem['NAME'];?></a>
                            </div>

                            <div class="border-top py-2 py-lg-3 d-flex justify-content-between align-items-center text-nowrap">
                                <?if($arItem['SHOW_COUNTER']){?>
                                    <span class="mr-0 mr-lg-2 views"><span><?=$arItem['SHOW_COUNTER'];?></span> <i class="icon-visibility"></i></span>
                                <?}?>
                                <?
                                $strDate = getStringDate($arItem['DATE_CREATE']);
                                ?>
                                <span class="date"><?=($strDate['MES']) ? GetMessage($strDate['MES']).', '.$strDate['HOURS'] : $strDate['HOURS'];?></span>
                            </div>
                        </div>
                        <?
                        if($arItem['TAPE'] && (strtotime($arItem['PROPERTY_LENTA_DATE_VALUE']) > time()))
                        {?>
                            <div class="d-flex marker">
                                <div class="d-flex flex-column decor-rec" style="border-color: <?=$arItem['TAPE']['UF_COLOR'];?>;">
                                    <div class="rec-top"></div>
                                    <div class="rec-bottom"></div>
                                </div>
                                <div class="text" style="background-color: <?=$arItem['TAPE']['UF_COLOR'];?>;"><?=$arItem['TAPE']['UF_NAME_'.mb_strtoupper($arSetting[SITE_ID]['lang'])];?></div>
                            </div>
                        <?}
                        ?>
                    </div>
                <?}?>
            </div>
        <?}?>
    </div>

    <div class="mobile-block-show-contacts">
        <ul class="list-unstyled">
            <button type="button" class="close" id="closeNumberList">
                <span aria-hidden="true">&times;</span>
            </button>

            <li class="justify-content-end">
                <p class="mb-0 d-flex align-items-center time">
                    to <span class="mx-2">9:00</span> from <span class="mx-2">20:00</span>
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9.99 0C4.47 0 0 4.48 0 10C0 15.52 4.47 20 9.99 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 9.99 0ZM10 18C5.58 18 2 14.42 2 10C2 5.58 5.58 2 10 2C14.42 2 18 5.58 18 10C18 14.42 14.42 18 10 18ZM9.78 5H9.72C9.32 5 9 5.32 9 5.72V10.44C9 10.79 9.18 11.12 9.49 11.3L13.64 13.79C13.98 13.99 14.42 13.89 14.62 13.55C14.6702 13.469 14.7036 13.3788 14.7182 13.2846C14.7328 13.1905 14.7283 13.0943 14.705 13.002C14.6817 12.9096 14.64 12.8229 14.5824 12.7469C14.5249 12.671 14.4526 12.6074 14.37 12.56L10.5 10.26V5.72C10.5 5.32 10.18 5 9.78 5Z" fill="#555555"/>
                    </svg>

                </p>
            </li>

            <li><a href="tel:+375293062655">+37529 306-26-55</a></li>
            <li><a href="tel:+375293062655">+37529 306-26-55</a></li>
            <li><a href="tel:+375293062655">+37529 306-26-55</a></li>
        </ul>

        <div class="button-wrap d-flex">
            <button class="btn btn-show-phone w-100 text-uppercase font-weight-bold" id="showListUserNumber">Show phone</button>
            <button class="btn btn-primary btn-sand-message w-100 text-uppercase font-weight-bold" data-toggle="modal" data-target="#modalSandMessage">Send message</button>
        </div>
    </div>
    <div class="modal fade modal-sand-message" id="modalSandMessage" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="p-4 modal-body">
                    <h3 class="subtitle">
                        <?=$arResult['NAME'];?>
                    </h3>

                    <form class="mb-0 form-group" name="send_message" action="/">
                        <?=bitrix_sessid_post()?>
                        <input type="hidden" value="<?=$arResult['ID'];?>" name="IDAd">
                        <textarea name="message" class="mb-4 form-control" id="messageContent" rows="5" placeholder="Text message" required></textarea>

                        <!-- BOX add upload file -->
                        <div id="fileUploaderRenderMessageContainer" class="mb-4 d-flex justify-content-end flex-wrap fileUploaderRenderMessageContainer">
                            <input id="fileUploaderMessageFiles" class="d-none" type="file" name="files[]" multiple>
                        </div>
                        <!-- BOX add upload file END-->

                        <div class="d-flex justify-content-between align-items-center">
                            <!-- BUTTON add upload file -->
                            <div class="d-block">
                                <label for="fileUploaderMessageFiles" class="mb-0 text-primary labelAddFileMessage"><i class="mr-2 icon-add-file"></i>Add file</label>
                            </div>
                            <!-- BUTTON add upload file END-->

                            <div>
                                <button type="button" class="btn btn-transparent" data-dismiss="modal">Close</button>
                                <button type="submit" class="py-2 px-4 btn btn-primary">Send message</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<div class="allert alert-confirmation flex-column card">
    <button type="button" class="close" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
    <div class="d-flex justify-content-center allert__text">
        Сообщение отправлено
    </div>
</div>
