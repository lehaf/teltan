<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Localization\Loc;

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
<?php if (!empty($arResult['ITEMS'])):?>
    <?php foreach ($arResult['ITEMS'] as $arItem):?>
        <div class="mb-4 card product-card product-line user-product">
            <div class="card-link" href="<?= $arItem['DETAIL_PAGE_URL'] ?>">
                <div onclick="window.location.href='<?= $arItem['DETAIL_PAGE_URL'] ?>'" style="cursor: pointer" class="image-block">
                    <div class="i-box">
                        <img src="<?=$arItem["PREVIEW_PICTURE"]['SRC']?>"
                             title="<?=$arItem["NAME"]?>"
                             alt="<?=$arItem["NAME"]?>"
                        >
                    </div>
                </div>
                <div class="px-2 px-lg-3 content-block">
                    <div class="d-flex flex-column h-100 justify-content-between text-right">
                        <div class="mb-3 mb-lg-5 d-flex flex-column-reverse flex-lg-row justify-content-between align-items-end">
                            <p class="price"><?= ICON_CURRENCY; ?> <?= number_format($arItem['PROPERTY']['PRICE']['VALUE'], 0, '.', ' '); ?></p>
                            <a href="<?= $arItem['DETAIL_PAGE_URL'] ?>"
                               class="title"><?= $arItem['NAME'] ?></a>
                        </div>
                        <div class="mb-4 d-flex flex-column flex-lg-row">
                            <div class="edit-user-item">
                                <button
                                    id="text-uppercase<?= $arItem['ID'] ?>"
                                    class="mr-lg-4 mb-3 mb-lg-0 btn user-product__btn-edit text-uppercase">
                                    <?= Loc::getMessage('UP_EDIT'); ?>
                                </button>
                                <script>
                                    $('#text-uppercase<?= $arItem['ID'] ?>').on('click', (e) => {
                                        e.preventDefault()
                                        $('#edit-item-menu_item<?= $arItem['ID'] ?>').toggleClass('active')
                                    })
                                </script>
                                <ul id="edit-item-menu_item<?= $arItem['ID'] ?>"
                                    class="flex-column edit-item-menu_item">
                                    <li class="border-bottom">
                                        <div class="custom-control custom-switch activateItem">
                                            <input type="checkbox" class="custom-control-input"
                                                   id="activateItem<?= $arItem['ID'] ?>">
                                            <label id="activateItemText<?= $arItem['ID'] ?>"
                                                   data-iblock-id="<?= $arItem['IBLOCK_ID'] ?>"
                                                   data-item-id="<?= $arItem['ID'] ?>"
                                                   class="custom-control-label"
                                                   for="activateItem<?= $arItem['ID'] ?>"><?= Loc::getMessage('DELETE_UN'); ?></label>
                                        </div>
                                    </li>
                                    <script>
                                        $('#activateItemText<?= $arItem['ID'] ?>').click(function () {
                                            var attе = '';
                                            if ($('#activateItem<?= $arItem['ID'] ?>').is(':checked')) {
                                                var tte = 'green';
                                            } else {
                                                var tte = 'red';
                                            }

                                            $.ajax({
                                                url: '/ajax/active_item.php',
                                                method: 'post',
                                                async: false,
                                                data: {data: $(this).data(), value: tte},
                                                success: function (data) {
                                                    $('.allert__text').html(data);

                                                    $('.del_all_in_chat').html('ok');
                                                    $('.alert-confirmation').addClass('show');
                                                }
                                            });
                                        })
                                    </script>
                                    <li class="border-bottom">
                                        <a class="mr-3" href="/add/fm/?ID=<?= $arItem['ID'] ?>&EDIT=Y"><?= Loc::getMessage('UP_EDIT'); ?></a>
                                        <span class="mr-2">
                                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M15.4042 3.28224L12.6642 0.542241C12.3066 0.206336 11.838 0.0135995 11.3475 0.000692758C10.8571 -0.012214 10.379 0.15561 10.0042 0.472241L1.0042 9.47224C0.680969 9.79821 0.479707 10.2254 0.434203 10.6822L0.00420295 14.8522C-0.00926809 14.9987 0.00973728 15.1463 0.0598642 15.2846C0.109991 15.4229 0.190005 15.5484 0.294203 15.6522C0.387643 15.7449 0.498459 15.8182 0.620297 15.868C0.742134 15.9178 0.872596 15.943 1.0042 15.9422H1.0942L5.2642 15.5622C5.721 15.5167 6.14824 15.3155 6.4742 14.9922L15.4742 5.99224C15.8235 5.62321 16.0123 5.13075 15.9992 4.62278C15.9861 4.1148 15.7721 3.63275 15.4042 3.28224ZM12.0042 6.62224L9.3242 3.94224L11.2742 1.94224L14.0042 4.67224L12.0042 6.62224Z" fill="#3FC5FF"/>
                                            </svg>
                                        </span>
                                    </li>
                                    <li class="px-3">
                                        <button id="alertConfirmation<?= $arItem['ID'] ?>"
                                                type="button"
                                                class="btn p-0 text-secondary">
                                            <span class="mr-2"><?= Loc::getMessage('DELETE'); ?></span>

                                            <i class="mr-2 icon-clear"></i>
                                        </button>
                                    </li>
                                </ul>

                                <div id="alert-confirmationIdView<?= $arItem['ID'] ?>"
                                     class="allert alert-confirmation flex-column card">
                                    <button type="button" class="close" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>

                                    <div class="d-flex justify-content-center allert__text">
                                        <?= Loc::getMessage('CT_BNL_ELEMENT_DELETE_CONFIRM'); ?></div>


                                    <div class="d-flex justify-content-center mt-4">
                                        <button data-item="<?= $arItem['ID'] ?>"
                                                id="delItemId<?= $arItem['ID'] ?>"
                                                class="btn border-primary text-uppercase font-weight-bold text-primary py-3 px-5">
                                            <?= Loc::getMessage('DELETE'); ?></button>

                                    </div>
                                </div>
                            </div>
                            <script>
                                $('#alertConfirmation<?=$arItem['ID']?>').on('click', function () {
                                    $('#alert-confirmationIdView<?=$arItem['ID']?>').addClass('show');
                                })
                                $('#delItemId<?=$arItem['ID']?>').click(function () {
                                    $.ajax({
                                        url: '/ajax/del_item.php',
                                        method: 'post',
                                        async: false,
                                        data: $(this).data(),
                                        success: function (data) {
                                        }
                                    });
                                    window.location.reload();
                                })
                            </script>

                            <div class="userItemSettings">
                                <button class="btn btn-accelerate-sale text-uppercase font-weight-bold btn-accelerate-sale"
                                        href="#" role="button"
                                        id="dropdownMenuLink<?= $arItem['ID'] ?>"
                                        data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                      <span>
                                          <svg width="31" height="18" viewBox="0 0 31 18" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                            <path d="M29.4417 3.27725H14.2853L14.06 0.734453C14.0231 0.318623 13.6792 0 13.2671 0H11.6496C11.2099 0 10.8535 0.361101 10.8535 0.806543C10.8535 1.25198 11.2099 1.61309 11.6496 1.61309H12.5393C13.0254 7.10073 11.7689 -7.08279 13.4549 11.9479C13.5199 12.6928 13.9171 13.5011 14.6014 14.0503C13.3676 15.6466 14.495 18 16.502 18C18.1678 18 19.3427 16.3168 18.7715 14.7226H23.1286C22.558 16.3147 23.7304 18 25.398 18C26.7289 18 27.8116 16.9031 27.8116 15.5548C27.8116 14.2064 26.7289 13.1095 25.398 13.1095H16.5074C15.9026 13.1095 15.3757 12.7399 15.1482 12.2013L27.8708 11.4438C28.2181 11.4231 28.512 11.1763 28.5964 10.8343L30.214 4.2794C30.3394 3.77113 29.9597 3.27725 29.4417 3.27725ZM16.502 16.3869C16.0491 16.3869 15.6806 16.0136 15.6806 15.5548C15.6806 15.0959 16.0491 14.7226 16.502 14.7226C16.9549 14.7226 17.3234 15.0959 17.3234 15.5548C17.3234 16.0136 16.9549 16.3869 16.502 16.3869ZM25.398 16.3869C24.9451 16.3869 24.5766 16.0136 24.5766 15.5548C24.5766 15.0959 24.9451 14.7226 25.398 14.7226C25.8509 14.7226 26.2194 15.0959 26.2194 15.5548C26.2194 16.0136 25.8509 16.3869 25.398 16.3869ZM27.1936 9.86828L14.9339 10.5982L14.4282 4.8903H28.4221L27.1936 9.86828Z"
                                                  fill="white"/>
                                            <path d="M10.509 8.05168C10.6904 8.02447 10.8535 8.16495 10.8535 8.34836V10.6516C10.8535 10.8351 10.6904 10.9755 10.509 10.9483L2.83139 9.79668C2.49072 9.74558 2.49072 9.25442 2.83139 9.20332L10.509 8.05168Z"
                                                  fill="white"/>
                                            <path d="M10.5111 5.04892C10.6918 5.0231 10.8535 5.16334 10.8535 5.3459V6.6541C10.8535 6.83666 10.6918 6.9769 10.5111 6.95108L5.93241 6.29698C5.58898 6.24792 5.58898 5.75208 5.93241 5.70302L10.5111 5.04892Z"
                                                  fill="white"/>
                                            <path d="M10.5111 12.0489C10.6918 12.0231 10.8535 12.1633 10.8535 12.3459V13.6541C10.8535 13.8367 10.6918 13.9769 10.5111 13.9511L5.93241 13.297C5.58898 13.2479 5.58898 12.7521 5.93241 12.703L10.5111 12.0489Z"
                                                  fill="white"/>
                                          </svg>
                                    </span>
                                    <?= Loc::getMessage('UP_SPEED_SALE'); ?>
                                </button>
                                <script>
                                    $('#dropdownMenuLink<?=$arItem['ID']?>').on('click', (e) => {
                                        e.preventDefault()
                                        $('#accordionUserItemWrap<?=$arItem['ID']?>').toggleClass('active')
                                    })
                                </script>
                                <div class="accardion-wrap"
                                     id="accordionUserItemWrap<?= $arItem['ID'] ?>">
                                    <!-- ID "accordionUserItem<?= $arItem['ID'] ?>" shold be UNIC for every product card -->
                                    <div class="accordion user-promote-menu"
                                         id="accordionUserItem<?= $arItem['ID'] ?>">
                                        <div class="promote-card">
                                            <!-- ID "headingRiseItem" shold be UNIC for every product card -->
                                            <div class="card-header" id="headingRiseItem">
                                                <button class="btn btn-link btn-block text-right collapsed"
                                                        type="button" data-toggle="collapse"
                                                        data-target="#riseItem<?= $arItem['ID'] ?>"
                                                        aria-expanded="false"
                                                        aria-controls="riseItem">
                                                    <div class="pr-4 d-flex justify-content-between align-items-center">
                                                        <span class="plus"></span>
                                                        <span class="card-header__title"><?= Loc::getMessage('RISE_PAKET'); ?></span>

                                                    </div>
                                                </button>
                                                <span class="text-uppercase font-weight-bold up card-header__icon">UP</span>
                                            </div>

                                            <!-- data-parent depend on "accordionUserItem<?= $arItem['ID'] ?>" -->
                                            <!-- aria-labelledby depend on "headingRiseItem" -->
                                            <div id="riseItem<?= $arItem['ID'] ?>" class="collapse"
                                                 aria-labelledby="headingRiseItem"
                                                 data-parent="#accordionUserItem<?= $arItem['ID'] ?>">
                                                <div class="p-3 bg-lightgray">
                                                    <div class="mb-4 p-3 card">
                                                        <p class="mb-3 font-weight-bold content-subtitle">
                                                            Что дает поднятие объявления?</p>

                                                        <ul>
                                                            <li class="mb-3">Объявление поднимется в
                                                                начало списка в категории и на
                                                                главной
                                                                Куфара
                                                            </li>
                                                            <li class="mb-3">Минимум в 3 раза больше
                                                                просмотров и откликов
                                                            </li>
                                                            <li>Обновление срока размещения</li>
                                                        </ul>
                                                    </div>

                                                    <p class="mb-3 font-weight-bold content-subtitle">
                                                        Выберите тип поднятия:</p>

                                                    <div class="mb-4 px-3 card">
                                                        <div class="py-3 border-bottom d-flex justify-content-between">
                                                            <span class="font-weight-bold">2,09 ₪</span>

                                                            <label class="custom-radio-btn">
                                                                <input type="radio"
                                                                       name="riseProduct">
                                                                <span>1 поднятие</span>
                                                                <span class="checkbox"></span>
                                                            </label>
                                                        </div>

                                                        <div class="py-3 border-bottom d-flex justify-content-between">
                                                            <span class="font-weight-bold">3,50 ₪</span>

                                                            <label class="custom-radio-btn">
                                                                <input type="radio"
                                                                       name="riseProduct">
                                                                <span>2 поднятие</span>
                                                                <span class="checkbox"></span>
                                                            </label>
                                                        </div>

                                                        <div class="py-3 d-flex justify-content-between">
                                                            <span class="font-weight-bold">5,00 ₪</span>

                                                            <label class="custom-radio-btn">
                                                                <input type="radio"
                                                                       name="riseProduct">
                                                                <span>4 поднятие</span>
                                                                <span class="checkbox"></span>
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <p class="mb-3 font-weight-bold content-subtitle">
                                                        <?= Loc::getMessage('PAY_CHOISE'); ?>
                                                        :</p>

                                                    <div class="d-flex flex-column justify-content-end align-items-end">
                                                        <button type="button"
                                                                class="mb-3 btn btn-primary btn-paid"><span
                                                                    class="mr-2"><svg width="17"
                                                                                      height="17"
                                                                                      viewBox="0 0 17 17"
                                                                                      fill="none"
                                                                                      xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M11.8169 0.00066338C8.95442 0.00066338 6.63389 1.28034 6.63389 2.8612C6.63389 4.44205 8.95508 5.72239 11.8169 5.72239C14.6795 5.72239 17 4.44205 17 2.8612C17 1.28034 14.6788 0 11.8169 0V0.00066338ZM17 3.711C16.9987 5.29185 14.6795 6.57219 11.8169 6.57219C8.96238 6.57219 6.64716 5.30578 6.63389 3.73223V4.85136C6.63389 5.52669 7.06642 6.14497 7.77492 6.63455C8.49138 6.82959 9.12956 7.10025 9.66093 7.44256C10.3197 7.60973 11.0441 7.71189 11.8169 7.71189C14.6795 7.71189 17 6.43222 17 4.85136V3.711ZM17 5.70116C17 7.28202 14.6795 8.56236 11.8169 8.56236C11.4687 8.56236 11.1303 8.53649 10.8013 8.5C11.0609 8.84969 11.2381 9.25361 11.3194 9.6815C11.4846 9.69078 11.6478 9.70206 11.8169 9.70206C14.6795 9.70206 17 8.42238 17 6.84153V5.70116ZM5.18306 7.29728C2.32053 7.29728 0 8.57762 0 10.1585C0 11.7393 2.3212 13.0197 5.18306 13.0197C8.04558 13.0197 10.3661 11.7393 10.3661 10.1585C10.3661 8.57762 8.04492 7.29728 5.18306 7.29728ZM17 7.69133C16.9987 9.27219 14.6795 10.5525 11.8169 10.5525C11.6504 10.5525 11.4819 10.5406 11.3194 10.5313C11.3121 10.5811 11.3081 10.6474 11.2988 10.6971C11.332 10.7973 11.3605 10.8962 11.3605 11.0089V11.6723C11.5111 11.6796 11.6624 11.6922 11.8169 11.6922C14.6795 11.6922 17 10.4125 17 8.83169V7.69133ZM17 9.6815C16.9987 11.2624 14.6795 12.5427 11.8169 12.5427C11.6504 12.5427 11.4819 12.5308 11.3194 12.5215C11.3121 12.5712 11.3081 12.6376 11.2988 12.6873C11.332 12.7868 11.3605 12.8863 11.3605 12.9991V13.6625C11.5111 13.6698 11.6624 13.6824 11.8169 13.6824C14.6795 13.6824 17 12.4027 17 10.8219V9.6815ZM10.3661 11.0083C10.3648 12.5891 8.04558 13.8695 5.18306 13.8695C2.32849 13.8695 0.0132678 12.6031 0 11.0288V12.1486C0 13.7295 2.31987 15.0098 5.18306 15.0098C8.04624 15.0098 10.3661 13.7295 10.3661 12.1486V11.0083ZM10.3661 12.9984C10.3648 14.5793 8.04558 15.8596 5.18306 15.8596C2.32849 15.8596 0.0132678 14.5932 0 13.019V14.1388C0 15.7197 2.31987 17 5.18306 17C8.04624 17 10.3661 15.7197 10.3661 14.1388V12.9984Z"
                                                                  fill="white"/>
                                                            </svg>
                                                            </span> <?= Loc::getMessage('PAY_T_COINS'); ?>

                                                        </button>
                                                        <button type="button"
                                                                class="btn btn-primary btn-paid"><span
                                                                    class="mr-2"><svg width="17"
                                                                                      height="14"
                                                                                      viewBox="0 0 17 14"
                                                                                      fill="none"
                                                                                      xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M16.3929 0H0.607143C0.271317 0 0 0.284375 0 0.636364V3.81818H17V0.636364C17 0.284375 16.7287 0 16.3929 0ZM0 13.3636C0 13.7156 0.271317 14 0.607143 14H16.3929C16.7287 14 17 13.7156 17 13.3636V5.56818H0V13.3636ZM10.9855 9.70455C10.9855 9.61705 11.0538 9.54545 11.1373 9.54545H14.2679C14.3513 9.54545 14.4196 9.61705 14.4196 9.70455V11.1364C14.4196 11.2239 14.3513 11.2955 14.2679 11.2955H11.1373C11.0538 11.2955 10.9855 11.2239 10.9855 11.1364V9.70455Z"
                                                                  fill="white"/>
                                                            </svg>
                                                            </span> <?= Loc::getMessage('PAY_CARD'); ?>

                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="promote-card">
                                            <!-- ID "headingVipItem" shold be UNIC for every product card -->
                                            <div class="card-header" id="headingVipItem">
                                                <!-- data-target="#vipItem" depend on "accordionUserItem<?= $arItem['ID'] ?>" -->
                                                <!-- aria-controls="vipItem" depend on "headingRiseItem" -->
                                                <button class="btn btn-link btn-block text-right collapsed"
                                                        type="button" data-toggle="collapse"
                                                        data-target="#vipItem" aria-expanded="false"
                                                        aria-controls="vipItem">
                                                    <div class="pr-4 d-flex justify-content-between align-items-center">
                                                        <span class="plus"></span>
                                                        <span class="card-header__title"><?= Loc::getMessage('VIP_PAKET'); ?></span>

                                                    </div>

                                                    <span class="card-header__icon"><svg width="22"
                                                                                         height="19"
                                                                                         viewBox="0 0 22 19"
                                                                                         fill="none"
                                                                                         xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M1.58936 3.42876L5.88549 6.18822L10.1673 0.413067C10.2619 0.285313 10.3868 0.181179 10.5317 0.109331C10.6765 0.0374835 10.837 0 10.9999 0C11.1628 0 11.3234 0.0374835 11.4682 0.109331C11.613 0.181179 11.7379 0.285313 11.8326 0.413067L16.1144 6.18822L20.4105 3.42876C20.5731 3.32454 20.7633 3.26734 20.9585 3.26392C21.1538 3.2605 21.346 3.31101 21.5124 3.40947C21.6788 3.50793 21.8125 3.65023 21.8976 3.81956C21.9828 3.98888 22.0159 4.17815 21.9929 4.36501L20.3123 18.1298C20.283 18.3695 20.1634 18.5905 19.9762 18.7509C19.7889 18.9113 19.5471 19 19.2966 19H2.70328C2.45274 19 2.21093 18.9113 2.0237 18.7509C1.83648 18.5905 1.71687 18.3695 1.68755 18.1298L0.00694712 4.36402C-0.015761 4.17725 0.0174677 3.98811 0.102711 3.81895C0.187954 3.64978 0.321652 3.50764 0.488023 3.40931C0.654394 3.31098 0.846492 3.26056 1.04164 3.26401C1.23679 3.26745 1.42684 3.32462 1.58936 3.42876ZM10.9999 13.0869C11.5425 13.0869 12.0629 12.8792 12.4465 12.5096C12.8302 12.1399 13.0457 11.6386 13.0457 11.1158C13.0457 10.5931 12.8302 10.0917 12.4465 9.72209C12.0629 9.35245 11.5425 9.14479 10.9999 9.14479C10.4574 9.14479 9.93701 9.35245 9.55335 9.72209C9.16969 10.0917 8.95416 10.5931 8.95416 11.1158C8.95416 11.6386 9.16969 12.1399 9.55335 12.5096C9.93701 12.8792 10.4574 13.0869 10.9999 13.0869Z"
                                                          fill="#F50000"/>
                                                    </svg>
                                                    </span>
                                                </button>
                                            </div>

                                            <!-- ID "vipItem" shold be UNIC for every product card -->
                                            <!-- aria-labelledby="headingVipItem" data-parent="#accordionUserItem<?= $arItem['ID'] ?>" -->
                                            <div id="vipItem" class="collapse"
                                                 aria-labelledby="headingVipItem"
                                                 data-parent="#accordionUserItem<?= $arItem['ID'] ?>">
                                                <div class="p-3 bg-lightgray">
                                                    <div class="mb-4 p-3 card">
                                                        <p class="mb-3 font-weight-bold content-subtitle">
                                                            Что дает поднятие объявления?</p>

                                                        <ul>
                                                            <li class="mb-3">Объявление поднимется в
                                                                начало списка в категории и на
                                                                главной
                                                                Куфара
                                                            </li>
                                                            <li class="mb-3">Минимум в 3 раза больше
                                                                просмотров и откликов
                                                            </li>
                                                            <li>Обновление срока размещения</li>
                                                        </ul>
                                                    </div>

                                                    <p class="mb-3 font-weight-bold content-subtitle">
                                                        Выберите тип поднятия:</p>

                                                    <div class="mb-4 px-3 card">
                                                        <div class="py-3 border-bottom d-flex justify-content-between">
                                                            <span class="font-weight-bold">2,09 ₪</span>

                                                            <label class="custom-radio-btn">
                                                                <input type="radio"
                                                                       name="riseProduct">
                                                                <span>1 поднятие</span>
                                                                <span class="checkbox"></span>
                                                            </label>
                                                        </div>

                                                        <div class="py-3 border-bottom d-flex justify-content-between">
                                                            <span class="font-weight-bold">3,50 ₪</span>

                                                            <label class="custom-radio-btn">
                                                                <input type="radio"
                                                                       name="riseProduct">
                                                                <span>2 поднятие</span>
                                                                <span class="checkbox"></span>
                                                            </label>
                                                        </div>

                                                        <div class="py-3 d-flex justify-content-between">
                                                            <span class="font-weight-bold">5,00 ₪</span>

                                                            <label class="custom-radio-btn">
                                                                <input type="radio"
                                                                       name="riseProduct">
                                                                <span>4 поднятие</span>
                                                                <span class="checkbox"></span>
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <p class="mb-3 font-weight-bold content-subtitle">
                                                        <?= Loc::getMessage('PAY_CHOISE'); ?>
                                                        :</p>

                                                    <div class="d-flex flex-column justify-content-end align-items-end">
                                                        <button type="button"
                                                                class="mb-3 btn btn-primary btn-paid"><span
                                                                    class="mr-2"><svg width="17"
                                                                                      height="17"
                                                                                      viewBox="0 0 17 17"
                                                                                      fill="none"
                                                                                      xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M11.8169 0.00066338C8.95442 0.00066338 6.63389 1.28034 6.63389 2.8612C6.63389 4.44205 8.95508 5.72239 11.8169 5.72239C14.6795 5.72239 17 4.44205 17 2.8612C17 1.28034 14.6788 0 11.8169 0V0.00066338ZM17 3.711C16.9987 5.29185 14.6795 6.57219 11.8169 6.57219C8.96238 6.57219 6.64716 5.30578 6.63389 3.73223V4.85136C6.63389 5.52669 7.06642 6.14497 7.77492 6.63455C8.49138 6.82959 9.12956 7.10025 9.66093 7.44256C10.3197 7.60973 11.0441 7.71189 11.8169 7.71189C14.6795 7.71189 17 6.43222 17 4.85136V3.711ZM17 5.70116C17 7.28202 14.6795 8.56236 11.8169 8.56236C11.4687 8.56236 11.1303 8.53649 10.8013 8.5C11.0609 8.84969 11.2381 9.25361 11.3194 9.6815C11.4846 9.69078 11.6478 9.70206 11.8169 9.70206C14.6795 9.70206 17 8.42238 17 6.84153V5.70116ZM5.18306 7.29728C2.32053 7.29728 0 8.57762 0 10.1585C0 11.7393 2.3212 13.0197 5.18306 13.0197C8.04558 13.0197 10.3661 11.7393 10.3661 10.1585C10.3661 8.57762 8.04492 7.29728 5.18306 7.29728ZM17 7.69133C16.9987 9.27219 14.6795 10.5525 11.8169 10.5525C11.6504 10.5525 11.4819 10.5406 11.3194 10.5313C11.3121 10.5811 11.3081 10.6474 11.2988 10.6971C11.332 10.7973 11.3605 10.8962 11.3605 11.0089V11.6723C11.5111 11.6796 11.6624 11.6922 11.8169 11.6922C14.6795 11.6922 17 10.4125 17 8.83169V7.69133ZM17 9.6815C16.9987 11.2624 14.6795 12.5427 11.8169 12.5427C11.6504 12.5427 11.4819 12.5308 11.3194 12.5215C11.3121 12.5712 11.3081 12.6376 11.2988 12.6873C11.332 12.7868 11.3605 12.8863 11.3605 12.9991V13.6625C11.5111 13.6698 11.6624 13.6824 11.8169 13.6824C14.6795 13.6824 17 12.4027 17 10.8219V9.6815ZM10.3661 11.0083C10.3648 12.5891 8.04558 13.8695 5.18306 13.8695C2.32849 13.8695 0.0132678 12.6031 0 11.0288V12.1486C0 13.7295 2.31987 15.0098 5.18306 15.0098C8.04624 15.0098 10.3661 13.7295 10.3661 12.1486V11.0083ZM10.3661 12.9984C10.3648 14.5793 8.04558 15.8596 5.18306 15.8596C2.32849 15.8596 0.0132678 14.5932 0 13.019V14.1388C0 15.7197 2.31987 17 5.18306 17C8.04624 17 10.3661 15.7197 10.3661 14.1388V12.9984Z"
                                                                  fill="white"/>
                                                            </svg>
                                                            </span> <?= Loc::getMessage('PAY_T_COINS'); ?>

                                                        </button>
                                                        <button type="button"
                                                                class="btn btn-primary btn-paid"><span
                                                                    class="mr-2"><svg width="17"
                                                                                      height="14"
                                                                                      viewBox="0 0 17 14"
                                                                                      fill="none"
                                                                                      xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M16.3929 0H0.607143C0.271317 0 0 0.284375 0 0.636364V3.81818H17V0.636364C17 0.284375 16.7287 0 16.3929 0ZM0 13.3636C0 13.7156 0.271317 14 0.607143 14H16.3929C16.7287 14 17 13.7156 17 13.3636V5.56818H0V13.3636ZM10.9855 9.70455C10.9855 9.61705 11.0538 9.54545 11.1373 9.54545H14.2679C14.3513 9.54545 14.4196 9.61705 14.4196 9.70455V11.1364C14.4196 11.2239 14.3513 11.2955 14.2679 11.2955H11.1373C11.0538 11.2955 10.9855 11.2239 10.9855 11.1364V9.70455Z"
                                                                  fill="white"/>
                                                            </svg>
                                                            </span> <?= Loc::getMessage('PAY_CARD'); ?>

                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="promote-card">
                                            <!-- ID "headingSelectColorItem" shold be UNIC for every product card -->
                                            <div class="card-header" id="headingSelectColorItem">
                                                <!-- Change for every button "data-target", "aria-controls" data value "#ID under section"-->
                                                <button class="btn btn-link btn-block text-right collapsed"
                                                        type="button" data-toggle="collapse"
                                                        data-target="#selectColorItem"
                                                        aria-expanded="false"
                                                        aria-controls="selectColorItem">
                                                    <div class="pr-4 d-flex justify-content-between align-items-center">
                                                        <span class="plus"></span>
                                                        <span class="card-header__title"><?= Loc::getMessage('LENT_PAKET'); ?></span>

                                                    </div>
                                                    <span class="card-header__icon"><svg width="16"
                                                                                         height="16"
                                                                                         viewBox="0 0 16 16"
                                                                                         fill="none"
                                                                                         xmlns="http://www.w3.org/2000/svg">
                                                    <rect width="9.40476" height="6.83184" rx="0.5"
                                                          transform="matrix(0.977206 -0.212292 0.118541 0.992949 0.503906 9.04102)" fill="#FB2BFF"/>
                                                    <rect width="10.4788" height="6.83184" rx="0.5" transform="matrix(0.977206 -0.212292 0.118541 0.992949 4.87109 3.15161)"
                                                          fill="#FB2BFF"/>
                                                    <path d="M5.58984 9.95654L9.93666 9.01223L10.4706 13.4847L5.58984 9.95654Z" fill="#961299"/>
                                                    </svg>
                                                    </span>
                                                </button>
                                            </div>

                                            <!-- ID "selectColorItem" shold be UNIC for every product card -->
                                            <!-- data-parent = MAIN ID data-parent="#accordionUserItem<?= $arItem['ID'] ?>" -->
                                            <div id="selectColorItem" class="collapse"
                                                 aria-labelledby="headingSelectColorItem"
                                                 data-parent="#accordionUserItem<?= $arItem['ID'] ?>">
                                                <div class="p-3 bg-lightgray">
                                                    <div class="mb-4 p-3 card">
                                                        <p class="mb-3 font-weight-bold content-subtitle">
                                                            Что дает поднятие объявления?</p>

                                                        <ul>
                                                            <li class="mb-3">Объявление поднимется в
                                                                начало списка в категории и на
                                                                главной
                                                                Куфара
                                                            </li>
                                                            <li class="mb-3">Минимум в 3 раза больше
                                                                просмотров и откликов
                                                            </li>
                                                            <li>Обновление срока размещения</li>
                                                        </ul>
                                                    </div>

                                                    <p class="mb-3 font-weight-bold content-subtitle">
                                                        Выберите тип поднятия:</p>

                                                    <div class="mb-4 px-3 card">
                                                        <div class="py-3 border-bottom d-flex justify-content-between">
                                                            <span class="font-weight-bold">2,09 ₪</span>

                                                            <label class="custom-radio-btn">
                                                                <input type="radio"
                                                                       name="riseProduct">
                                                                <span>1 поднятие</span>
                                                                <span class="checkbox"></span>
                                                            </label>
                                                        </div>

                                                        <div class="py-3 border-bottom d-flex justify-content-between">
                                                            <span class="font-weight-bold">3,50 ₪</span>

                                                            <label class="custom-radio-btn">
                                                                <input type="radio"
                                                                       name="riseProduct">
                                                                <span>2 поднятие</span>
                                                                <span class="checkbox"></span>
                                                            </label>
                                                        </div>

                                                        <div class="py-3 d-flex justify-content-between">
                                                            <span class="font-weight-bold">5,00 ₪</span>

                                                            <label class="custom-radio-btn">
                                                                <input type="radio"
                                                                       name="riseProduct">
                                                                <span>4 поднятие</span>
                                                                <span class="checkbox"></span>
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <p class="mb-3 font-weight-bold content-subtitle">
                                                        <?= Loc::getMessage('PAY_CHOISE'); ?>
                                                        :</p>

                                                    <div class="d-flex flex-column justify-content-end align-items-end">
                                                        <button type="button" class="mb-3 btn btn-primary btn-paid">
                                                            <span class="mr-2">
                                                                <svg width="17"
                                                                      height="17"
                                                                      viewBox="0 0 17 17"
                                                                      fill="none"
                                                                      xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M11.8169 0.00066338C8.95442 0.00066338 6.63389 1.28034 6.63389 2.8612C6.63389 4.44205 8.95508 5.72239 11.8169 5.72239C14.6795 5.72239 17 4.44205 17 2.8612C17 1.28034 14.6788 0 11.8169 0V0.00066338ZM17 3.711C16.9987 5.29185 14.6795 6.57219 11.8169 6.57219C8.96238 6.57219 6.64716 5.30578 6.63389 3.73223V4.85136C6.63389 5.52669 7.06642 6.14497 7.77492 6.63455C8.49138 6.82959 9.12956 7.10025 9.66093 7.44256C10.3197 7.60973 11.0441 7.71189 11.8169 7.71189C14.6795 7.71189 17 6.43222 17 4.85136V3.711ZM17 5.70116C17 7.28202 14.6795 8.56236 11.8169 8.56236C11.4687 8.56236 11.1303 8.53649 10.8013 8.5C11.0609 8.84969 11.2381 9.25361 11.3194 9.6815C11.4846 9.69078 11.6478 9.70206 11.8169 9.70206C14.6795 9.70206 17 8.42238 17 6.84153V5.70116ZM5.18306 7.29728C2.32053 7.29728 0 8.57762 0 10.1585C0 11.7393 2.3212 13.0197 5.18306 13.0197C8.04558 13.0197 10.3661 11.7393 10.3661 10.1585C10.3661 8.57762 8.04492 7.29728 5.18306 7.29728ZM17 7.69133C16.9987 9.27219 14.6795 10.5525 11.8169 10.5525C11.6504 10.5525 11.4819 10.5406 11.3194 10.5313C11.3121 10.5811 11.3081 10.6474 11.2988 10.6971C11.332 10.7973 11.3605 10.8962 11.3605 11.0089V11.6723C11.5111 11.6796 11.6624 11.6922 11.8169 11.6922C14.6795 11.6922 17 10.4125 17 8.83169V7.69133ZM17 9.6815C16.9987 11.2624 14.6795 12.5427 11.8169 12.5427C11.6504 12.5427 11.4819 12.5308 11.3194 12.5215C11.3121 12.5712 11.3081 12.6376 11.2988 12.6873C11.332 12.7868 11.3605 12.8863 11.3605 12.9991V13.6625C11.5111 13.6698 11.6624 13.6824 11.8169 13.6824C14.6795 13.6824 17 12.4027 17 10.8219V9.6815ZM10.3661 11.0083C10.3648 12.5891 8.04558 13.8695 5.18306 13.8695C2.32849 13.8695 0.0132678 12.6031 0 11.0288V12.1486C0 13.7295 2.31987 15.0098 5.18306 15.0098C8.04624 15.0098 10.3661 13.7295 10.3661 12.1486V11.0083ZM10.3661 12.9984C10.3648 14.5793 8.04558 15.8596 5.18306 15.8596C2.32849 15.8596 0.0132678 14.5932 0 13.019V14.1388C0 15.7197 2.31987 17 5.18306 17C8.04624 17 10.3661 15.7197 10.3661 14.1388V12.9984Z" fill="white"/>
                                                                </svg>
                                                            </span>
                                                            <?= Loc::getMessage('PAY_T_COINS'); ?>
                                                        </button>
                                                        <button type="button" class="btn btn-primary btn-paid">
                                                            <span class="mr-2">
                                                                <svg width="17"
                                                                      height="14"
                                                                      viewBox="0 0 17 14"
                                                                      fill="none"
                                                                      xmlns="http://www.w3.org/2000/svg">
                                                                     <path d="M16.3929 0H0.607143C0.271317 0 0 0.284375 0 0.636364V3.81818H17V0.636364C17 0.284375 16.7287 0 16.3929 0ZM0 13.3636C0 13.7156 0.271317 14 0.607143 14H16.3929C16.7287 14 17 13.7156 17 13.3636V5.56818H0V13.3636ZM10.9855 9.70455C10.9855 9.61705 11.0538 9.54545 11.1373 9.54545H14.2679C14.3513 9.54545 14.4196 9.61705 14.4196 9.70455V11.1364C14.4196 11.2239 14.3513 11.2955 14.2679 11.2955H11.1373C11.0538 11.2955 10.9855 11.2239 10.9855 11.1364V9.70455Z" fill="white"/>
                                                                </svg>
                                                            </span>
                                                            <?= Loc::getMessage('PAY_CARD'); ?>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="promote-card">
                                            <!-- ID "headingSelectRiddonItem" shold be UNIC for every product card -->
                                            <div class="card-header" id="headingSelectRiddonItem">
                                                <!-- data-target="#selectRiddonItem" depend on "accordionUserItem<?= $arItem['ID'] ?>" -->
                                                <!-- aria-controls="selectRiddonItem" depend on "headingRiseItem" -->
                                                <button class="btn btn-link btn-block text-right collapsed"
                                                        type="button" data-toggle="collapse"
                                                        data-target="#selectRiddonItem"
                                                        aria-expanded="false"
                                                        aria-controls="selectRiddonItem">
                                                    <div class="pr-4 d-flex justify-content-between align-items-center">
                                                        <span class="plus"></span>
                                                        <span class="card-header__title"><?= Loc::getMessage('COLOUR_PAKET'); ?></span>

                                                    </div>
                                                    <span class="card-header__icon">
                                                        <svg width="16"
                                                             height="17"
                                                             viewBox="0 0 16 17"
                                                             fill="none"
                                                             xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M8.20189 0.934761C8.20189 0.779763 8.14032 0.631114 8.03072 0.521514C7.92112 0.411914 7.77247 0.350342 7.61747 0.350342C7.46247 0.350342 7.31382 0.411914 7.20422 0.521514C7.09462 0.631114 7.03305 0.779763 7.03305 0.934761V1.90879C6.78643 1.99564 6.56248 2.13677 6.37772 2.32178L1.01743 7.68285C0.854624 7.84566 0.725478 8.03894 0.637367 8.25165C0.549256 8.46437 0.503906 8.69236 0.503906 8.9226C0.503906 9.15284 0.549256 9.38083 0.637367 9.59355C0.725478 9.80626 0.854624 9.99954 1.01743 10.1623L4.82005 13.9634C4.98286 14.1262 5.17613 14.2554 5.38885 14.3435C5.60157 14.4316 5.82956 14.4769 6.0598 14.4769C6.29004 14.4769 6.51803 14.4316 6.73075 14.3435C6.94346 14.2554 7.13674 14.1262 7.29955 13.9634L12.6598 8.60312C12.8226 8.44031 12.9518 8.24703 13.0399 8.03432C13.128 7.8216 13.1734 7.59361 13.1734 7.36337C13.1734 7.13313 13.128 6.90514 13.0399 6.69242C12.9518 6.47971 12.8226 6.28643 12.6598 6.12362L8.85644 2.32178C8.67191 2.13687 8.44823 1.99574 8.20189 1.90879V0.934761ZM7.03305 3.31919V4.44127C7.03305 4.59627 7.09462 4.74492 7.20422 4.85452C7.31382 4.96412 7.46247 5.02569 7.61747 5.02569C7.77247 5.02569 7.92112 4.96412 8.03072 4.85452C8.14032 4.74492 8.20189 4.59627 8.20189 4.44127V3.31919L11.8323 6.95038C11.9417 7.05996 12.0032 7.2085 12.0032 7.36337C12.0032 7.51824 11.9417 7.66678 11.8323 7.77636L11.0765 8.53221H1.82159L1.84419 8.50883L7.03305 3.31919Z"
                                                                  fill="#6633F5"/>
                                                            <path d="M14.063 9.78046C14.0049 9.67162 13.9183 9.5806 13.8125 9.51714C13.7067 9.45369 13.5856 9.42017 13.4622 9.42017C13.3388 9.42017 13.2177 9.45369 13.1119 9.51714C13.0061 9.5806 12.9195 9.67162 12.8614 9.78046L11.2967 12.715C10.4232 14.3498 11.6092 16.3244 13.4622 16.3244C15.3152 16.3244 16.4996 14.3498 15.6284 12.715L14.063 9.78046Z"
                                                                  fill="#6633F5"/>
                                                        </svg>
                                                    </span>
                                                </button>
                                            </div>

                                            <!-- ID "selectRiddonItem" shold be UNIC for every product card -->
                                            <!-- aria-labelledby="headingSelectRiddonItem" data-parent="#accordionUserItem<?= $arItem['ID'] ?>" -->
                                            <div id="selectRiddonItem" class="collapse"
                                                 aria-labelledby="headingSelectRiddonItem"
                                                 data-parent="#accordionUserItem<?= $arItem['ID'] ?>">
                                                <div class="p-3 bg-lightgray">
                                                    <div class="mb-4 p-3 card">
                                                        <p class="mb-3 font-weight-bold content-subtitle">
                                                            Что дает поднятие объявления?</p>

                                                        <ul>
                                                            <li class="mb-3">Объявление поднимется в
                                                                начало списка в категории и на
                                                                главной
                                                                Куфара
                                                            </li>
                                                            <li class="mb-3">Минимум в 3 раза больше
                                                                просмотров и откликов
                                                            </li>
                                                            <li>Обновление срока размещения</li>
                                                        </ul>
                                                    </div>

                                                    <p class="mb-3 font-weight-bold content-subtitle">
                                                        Выберите тип поднятия:</p>

                                                    <div class="mb-4 px-3 card">
                                                        <div class="py-3 border-bottom d-flex justify-content-between">
                                                            <span class="font-weight-bold">2,09 ₪</span>

                                                            <label class="custom-radio-btn">
                                                                <input type="radio"
                                                                       name="productMarkerAdd">
                                                                <div class="d-flex marker">
                                                                    <div class="d-flex flex-column decor-rec"
                                                                         style="border-color: #F71A3F;">
                                                                        <div class="rec-top"></div>
                                                                        <div class="rec-bottom"></div>
                                                                    </div>

                                                                    <div class="text"
                                                                         style="background-color: #F71A3F;">
                                                                        Акция
                                                                    </div>
                                                                </div>
                                                                <span class="checkbox"></span>
                                                            </label>
                                                        </div>

                                                        <div class="py-3 border-bottom d-flex justify-content-between">
                                                            <span class="font-weight-bold">3,50 ₪</span>

                                                            <label class="custom-radio-btn">
                                                                <input type="radio"
                                                                       name="productMarkerAdd">
                                                                <div class="d-flex marker">
                                                                    <div class="d-flex flex-column decor-rec"
                                                                         style="border-color: #3FD1FF;">
                                                                        <div class="rec-top"></div>
                                                                        <div class="rec-bottom"></div>
                                                                    </div>

                                                                    <div class="text"
                                                                         style="background-color: #3FD1FF;">
                                                                        Выгодная цена
                                                                    </div>
                                                                </div>
                                                                <span class="checkbox"></span>
                                                            </label>
                                                        </div>

                                                        <div class="py-3 border-bottom d-flex justify-content-between">
                                                            <span class="font-weight-bold">5,00 ₪</span>

                                                            <label class="custom-radio-btn">
                                                                <input type="radio"
                                                                       name="productMarkerAdd">
                                                                <div class="d-flex marker">
                                                                    <div class="d-flex flex-column decor-rec"
                                                                         style="border-color: #B637F2;">
                                                                        <div class="rec-top"></div>
                                                                        <div class="rec-bottom"></div>
                                                                    </div>

                                                                    <div class="text"
                                                                         style="background-color: #B637F2;">
                                                                        Бомба
                                                                    </div>
                                                                </div>
                                                                <span class="checkbox"></span>
                                                            </label>
                                                        </div>

                                                        <div class="py-3 d-flex justify-content-between">
                                                            <span class="font-weight-bold">5,00 ₪</span>

                                                            <label class="custom-radio-btn">
                                                                <input type="radio"
                                                                       name="productMarkerAdd">
                                                                <div class="d-flex marker">
                                                                    <div class="d-flex flex-column decor-rec"
                                                                         style="border-color: #FF862F;">
                                                                        <div class="rec-top"></div>
                                                                        <div class="rec-bottom"></div>
                                                                    </div>

                                                                    <div class="text"
                                                                         style="background-color: #FF862F;">
                                                                        Срочная продажа
                                                                    </div>
                                                                </div>
                                                                <span class="checkbox"></span>
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <p class="mb-3 font-weight-bold content-subtitle">
                                                        <?= Loc::getMessage('PAY_CHOISE'); ?>:</p>

                                                    <div class="d-flex flex-column justify-content-end align-items-end">
                                                        <button type="button" class="mb-3 btn btn-primary btn-paid">
                                                            <span class="mr-2">
                                                                <svg width="17"
                                                                      height="17"
                                                                      viewBox="0 0 17 17"
                                                                      fill="none"
                                                                      xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M11.8169 0.00066338C8.95442 0.00066338 6.63389 1.28034 6.63389 2.8612C6.63389 4.44205 8.95508 5.72239 11.8169 5.72239C14.6795 5.72239 17 4.44205 17 2.8612C17 1.28034 14.6788 0 11.8169 0V0.00066338ZM17 3.711C16.9987 5.29185 14.6795 6.57219 11.8169 6.57219C8.96238 6.57219 6.64716 5.30578 6.63389 3.73223V4.85136C6.63389 5.52669 7.06642 6.14497 7.77492 6.63455C8.49138 6.82959 9.12956 7.10025 9.66093 7.44256C10.3197 7.60973 11.0441 7.71189 11.8169 7.71189C14.6795 7.71189 17 6.43222 17 4.85136V3.711ZM17 5.70116C17 7.28202 14.6795 8.56236 11.8169 8.56236C11.4687 8.56236 11.1303 8.53649 10.8013 8.5C11.0609 8.84969 11.2381 9.25361 11.3194 9.6815C11.4846 9.69078 11.6478 9.70206 11.8169 9.70206C14.6795 9.70206 17 8.42238 17 6.84153V5.70116ZM5.18306 7.29728C2.32053 7.29728 0 8.57762 0 10.1585C0 11.7393 2.3212 13.0197 5.18306 13.0197C8.04558 13.0197 10.3661 11.7393 10.3661 10.1585C10.3661 8.57762 8.04492 7.29728 5.18306 7.29728ZM17 7.69133C16.9987 9.27219 14.6795 10.5525 11.8169 10.5525C11.6504 10.5525 11.4819 10.5406 11.3194 10.5313C11.3121 10.5811 11.3081 10.6474 11.2988 10.6971C11.332 10.7973 11.3605 10.8962 11.3605 11.0089V11.6723C11.5111 11.6796 11.6624 11.6922 11.8169 11.6922C14.6795 11.6922 17 10.4125 17 8.83169V7.69133ZM17 9.6815C16.9987 11.2624 14.6795 12.5427 11.8169 12.5427C11.6504 12.5427 11.4819 12.5308 11.3194 12.5215C11.3121 12.5712 11.3081 12.6376 11.2988 12.6873C11.332 12.7868 11.3605 12.8863 11.3605 12.9991V13.6625C11.5111 13.6698 11.6624 13.6824 11.8169 13.6824C14.6795 13.6824 17 12.4027 17 10.8219V9.6815ZM10.3661 11.0083C10.3648 12.5891 8.04558 13.8695 5.18306 13.8695C2.32849 13.8695 0.0132678 12.6031 0 11.0288V12.1486C0 13.7295 2.31987 15.0098 5.18306 15.0098C8.04624 15.0098 10.3661 13.7295 10.3661 12.1486V11.0083ZM10.3661 12.9984C10.3648 14.5793 8.04558 15.8596 5.18306 15.8596C2.32849 15.8596 0.0132678 14.5932 0 13.019V14.1388C0 15.7197 2.31987 17 5.18306 17C8.04624 17 10.3661 15.7197 10.3661 14.1388V12.9984Z"
                                                                      fill="white"/>
                                                                </svg>
                                                            </span>
                                                            <?= Loc::getMessage('PAY_T_COINS'); ?>
                                                        </button>
                                                        <button type="button" class="btn btn-primary btn-paid">
                                                            <span class="mr-2">
                                                                <svg width="17"
                                                                      height="14"
                                                                      viewBox="0 0 17 14"
                                                                      fill="none"
                                                                      xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M16.3929 0H0.607143C0.271317 0 0 0.284375 0 0.636364V3.81818H17V0.636364C17 0.284375 16.7287 0 16.3929 0ZM0 13.3636C0 13.7156 0.271317 14 0.607143 14H16.3929C16.7287 14 17 13.7156 17 13.3636V5.56818H0V13.3636ZM10.9855 9.70455C10.9855 9.61705 11.0538 9.54545 11.1373 9.54545H14.2679C14.3513 9.54545 14.4196 9.61705 14.4196 9.70455V11.1364C14.4196 11.2239 14.3513 11.2955 14.2679 11.2955H11.1373C11.0538 11.2955 10.9855 11.2239 10.9855 11.1364V9.70455Z" fill="white"/>
                                                                </svg>
                                                            </span>
                                                            <?= Loc::getMessage('PAY_CARD'); ?>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="promote-card">
                                            <!-- ID "headingBustPack" shold be UNIC for every product card -->
                                            <div class="card-header" id="headingBustPack">
                                                <!-- Change for every button "data-target", "aria-controls" data value "#ID under section"-->
                                                <button class="btn btn-link btn-block text-right collapsed"
                                                        type="button" data-toggle="collapse"
                                                        data-target="#bustPack"
                                                        aria-expanded="false"
                                                        aria-controls="bustPack">
                                                    <div class="pr-4 d-flex justify-content-between align-items-center">
                                                        <span class="plus"></span>
                                                        <span class="card-header__title"><?= Loc::getMessage('UP_COMPLEX'); ?></span>
                                                    </div>
                                                    <span class="card-header__icon">
                                                        <svg width="16"
                                                             height="18"
                                                             viewBox="0 0 16 18"
                                                             fill="none"
                                                             xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M10.7811 0.968714C10.7811 0.792056 10.7264 0.619732 10.6246 0.475353C10.5228 0.330975 10.3789 0.221608 10.2125 0.16224C10.0461 0.102871 9.86545 0.0964054 9.69525 0.143729C9.52505 0.191053 9.37365 0.289851 9.26179 0.426584L0.697334 9.84749C0.594729 9.97297 0.529841 10.125 0.510211 10.2859C0.49058 10.4468 0.517013 10.61 0.586437 10.7564C0.655861 10.9029 0.765426 11.0267 0.902399 11.1133C1.03937 11.2 1.19813 11.246 1.36022 11.2461H5.64245V16.3847C5.64248 16.5614 5.69714 16.7337 5.79894 16.8781C5.90074 17.0225 6.04469 17.1318 6.21107 17.1912C6.37746 17.2506 6.55813 17.257 6.72833 17.2097C6.89853 17.1624 7.04993 17.0636 7.16179 16.9269L15.7262 7.50596C15.8288 7.38048 15.8937 7.22845 15.9134 7.06755C15.933 6.90666 15.9066 6.74349 15.8371 6.59702C15.7677 6.45054 15.6582 6.32678 15.5212 6.24011C15.3842 6.15343 15.2254 6.10741 15.0634 6.10739H10.7811V0.968714Z" fill="#FF6B00"/>
                                                        </svg>
                                                    </span>
                                                </button>
                                            </div>

                                            <!-- ID "bustPack" shold be UNIC for every product card -->
                                            <!-- data-parent = MAIN ID data-parent="#accordionUserItem<?= $arItem['ID'] ?>" -->
                                            <div id="bustPack" class="collapse"
                                                 aria-labelledby="headingBustPack"
                                                 data-parent="#accordionUserItem<?= $arItem['ID'] ?>">
                                                <div class="p-3 bg-lightgray">
                                                    <div class="mb-4 p-3 card">
                                                        <p class="mb-3 font-weight-bold content-subtitle">
                                                            Что дает поднятие объявления?</p>

                                                        <ul>
                                                            <li class="mb-3">Объявление поднимется в
                                                                начало списка в категории и на
                                                                главной
                                                                Куфара
                                                            </li>
                                                            <li class="mb-3">Минимум в 3 раза больше
                                                                просмотров и откликов
                                                            </li>
                                                            <li>Обновление срока размещения</li>
                                                        </ul>
                                                    </div>

                                                    <p class="mb-3 font-weight-bold content-subtitle">
                                                        Выберите тип поднятия:</p>

                                                    <!-- ID "accordionSection" shold be UNIC for every product card -->
                                                    <div class="mb-4 px-3 card"
                                                         id="accordionSection">
                                                        <!-- ID "tipe1" shold be UNIC for every product card -->
                                                        <div class="py-3 border-bottom d-flex justify-content-between"
                                                             id="tipe1">
                                                            <span class="font-weight-bold">2,09 ₪</span>

                                                            <label class="custom-radio-btn">
                                                                <!-- Change for every button "data-target", "aria-controls" data value "#ID under section"-->
                                                                <input type="radio"
                                                                       name="riseProduct"
                                                                       data-toggle="collapse"
                                                                       data-target="#collapseOne"
                                                                       aria-expanded="true"
                                                                       aria-controls="collapseOne">
                                                                <span>Турбо-продажа</span>
                                                                <span class="checkbox"></span>
                                                            </label>
                                                        </div>

                                                        <!-- ID "collapseOne" shold be UNIC for every product card -->
                                                        <!-- data-parent = MAIN ID data-parent="#accordionSection" -->
                                                        <div id="collapseOne" class="collapse"
                                                             aria-labelledby="tipe1"
                                                             data-parent="#accordionSection">
                                                            <div class="p-3 d-flex flex-column new-collapse">
                                                                <p class="mb-4 text-uppercase font-weight-bold">
                                                                    на 15 просмотров больше
                                                                </p>

                                                                <p class="text-right">Неделя
                                                                    поднятий с
                                                                    ярким выделением - привлекайте
                                                                    как
                                                                    можно больше внимания к своему
                                                                    товару.</p>

                                                                <div class="d-flex position-relative justify-content-end pr-5">
                                                                    <p class="text-right">1 поднятие
                                                                        в
                                                                        день - на <span
                                                                                class="font-weight-bold">7</span>
                                                                        дней <span
                                                                                class="font-weight-bold">(первое - завтра)</span>
                                                                    </p>

                                                                    <div class="circle-icon">
                                                                        <div class="d-flex justify-content-center align-items-center user-product__up-product">
                                                                                                        <span data-id="<?= $arItem['ID'] ?>"
                                                                                                              class="text-uppercase font-weight-bold upRise">UP</span>

                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="d-flex position-relative justify-content-end pr-5">
                                                                    <p class="text-right">Выделение
                                                                        - на
                                                                        <span class="font-weight-bold">7</span>
                                                                        дней</p>

                                                                    <div class="circle-icon">
                                                                        <svg width="16" height="16"
                                                                             viewBox="0 0 16 16"
                                                                             fill="none"
                                                                             xmlns="http://www.w3.org/2000/svg">
                                                                            <rect width="9.40476"
                                                                                  height="6.83184"
                                                                                  rx="0.5"
                                                                                  transform="matrix(0.977206 -0.212292 0.118541 0.992949 0.503906 9.04102)"
                                                                                  fill="#FB2BFF"/>
                                                                            <rect width="10.4788"
                                                                                  height="6.83184"
                                                                                  rx="0.5"
                                                                                  transform="matrix(0.977206 -0.212292 0.118541 0.992949 4.87109 3.15161)"
                                                                                  fill="#FB2BFF"/>
                                                                            <path d="M5.58984 9.95654L9.93666 9.01223L10.4706 13.4847L5.58984 9.95654Z"
                                                                                  fill="#961299"/>
                                                                        </svg>

                                                                    </div>
                                                                </div>

                                                                <div class="d-flex position-relative justify-content-end pr-5">
                                                                    <p class="text-right">VIP -
                                                                        закрепление - на <span
                                                                                class="font-weight-bold">3</span>
                                                                        дня</p>

                                                                    <div class="circle-icon">
                                                                        <svg width="22" height="19"
                                                                             viewBox="0 0 22 19"
                                                                             fill="none"
                                                                             xmlns="http://www.w3.org/2000/svg">
                                                                            <path d="M1.58936 3.42876L5.88549 6.18822L10.1673 0.413067C10.2619 0.285313 10.3868 0.181179 10.5317 0.109331C10.6765 0.0374835 10.837 0 10.9999 0C11.1628 0 11.3234 0.0374835 11.4682 0.109331C11.613 0.181179 11.7379 0.285313 11.8326 0.413067L16.1144 6.18822L20.4105 3.42876C20.5731 3.32454 20.7633 3.26734 20.9585 3.26392C21.1538 3.2605 21.346 3.31101 21.5124 3.40947C21.6788 3.50793 21.8125 3.65023 21.8976 3.81956C21.9828 3.98888 22.0159 4.17815 21.9929 4.36501L20.3123 18.1298C20.283 18.3695 20.1634 18.5905 19.9762 18.7509C19.7889 18.9113 19.5471 19 19.2966 19H2.70328C2.45274 19 2.21093 18.9113 2.0237 18.7509C1.83648 18.5905 1.71687 18.3695 1.68755 18.1298L0.00694712 4.36402C-0.015761 4.17725 0.0174677 3.98811 0.102711 3.81895C0.187954 3.64978 0.321652 3.50764 0.488023 3.40931C0.654394 3.31098 0.846492 3.26056 1.04164 3.26401C1.23679 3.26745 1.42684 3.32462 1.58936 3.42876ZM10.9999 13.0869C11.5425 13.0869 12.0629 12.8792 12.4465 12.5096C12.8302 12.1399 13.0457 11.6386 13.0457 11.1158C13.0457 10.5931 12.8302 10.0917 12.4465 9.72209C12.0629 9.35245 11.5425 9.14479 10.9999 9.14479C10.4574 9.14479 9.93701 9.35245 9.55335 9.72209C9.16969 10.0917 8.95416 10.5931 8.95416 11.1158C8.95416 11.6386 9.16969 12.1399 9.55335 12.5096C9.93701 12.8792 10.4574 13.0869 10.9999 13.0869Z"
                                                                                  fill="#F50000"/>
                                                                        </svg>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- ID "tipe2" shold be UNIC for every product card -->
                                                        <div class="py-3 border-bottom d-flex justify-content-between"
                                                             id="tipe2">
                                                            <span class="font-weight-bold">3,50 ₪</span>

                                                            <label class="custom-radio-btn">
                                                                <!-- Change for every button "data-target", "aria-controls" data value "#ID under section"-->
                                                                <input type="radio"
                                                                       name="riseProduct"
                                                                       data-toggle="collapse"
                                                                       data-target="#collapseTwo"
                                                                       aria-expanded="true"
                                                                       aria-controls="collapseTwo">
                                                                <span>Экспресс-продажа</span>
                                                                <span class="checkbox"></span>
                                                            </label>
                                                        </div>

                                                        <!-- ID "collapseTwo" shold be UNIC for every product card -->
                                                        <!-- data-parent = MAIN ID data-parent="#accordionSection" -->
                                                        <div id="collapseTwo" class="collapse"
                                                             aria-labelledby="tipe2"
                                                             data-parent="#accordionSection">
                                                            <div class="p-3 d-flex flex-column new-collapse">
                                                                <p class="mb-4 text-uppercase font-weight-bold">
                                                                    на 15 просмотров больше
                                                                </p>

                                                                <p class="text-right">Неделя
                                                                    поднятий с
                                                                    ярким выделением - привлекайте
                                                                    как
                                                                    можно больше внимания к своему
                                                                    товару.</p>

                                                                <div class="d-flex position-relative justify-content-end pr-5">
                                                                    <p class="text-right">1 поднятие
                                                                        в
                                                                        день - на <span
                                                                                class="font-weight-bold">7</span>
                                                                        дней <span
                                                                                class="font-weight-bold">(первое - завтра)</span>
                                                                    </p>

                                                                    <div class="circle-icon">
                                                                        <div class="d-flex justify-content-center align-items-center user-product__up-product">
                                                                                                        <span data-id="<?= $arItem['ID'] ?>"
                                                                                                              class="text-uppercase font-weight-bold upRise">UP</span>

                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="d-flex position-relative justify-content-end pr-5">
                                                                    <p class="text-right">Выделение
                                                                        - на
                                                                        <span class="font-weight-bold">7</span>
                                                                        дней</p>

                                                                    <div class="circle-icon">
                                                                        <svg width="16" height="16"
                                                                             viewBox="0 0 16 16"
                                                                             fill="none"
                                                                             xmlns="http://www.w3.org/2000/svg">
                                                                            <rect width="9.40476"
                                                                                  height="6.83184"
                                                                                  rx="0.5"
                                                                                  transform="matrix(0.977206 -0.212292 0.118541 0.992949 0.503906 9.04102)"
                                                                                  fill="#FB2BFF"/>
                                                                            <rect width="10.4788"
                                                                                  height="6.83184"
                                                                                  rx="0.5"
                                                                                  transform="matrix(0.977206 -0.212292 0.118541 0.992949 4.87109 3.15161)"
                                                                                  fill="#FB2BFF"/>
                                                                            <path d="M5.58984 9.95654L9.93666 9.01223L10.4706 13.4847L5.58984 9.95654Z"
                                                                                  fill="#961299"/>
                                                                        </svg>

                                                                    </div>
                                                                </div>

                                                                <div class="d-flex position-relative justify-content-end pr-5">
                                                                    <p class="text-right">VIP -
                                                                        закрепление - на <span
                                                                                class="font-weight-bold">3</span>
                                                                        дня</p>

                                                                    <div class="circle-icon">
                                                                        <svg width="22" height="19"
                                                                             viewBox="0 0 22 19"
                                                                             fill="none"
                                                                             xmlns="http://www.w3.org/2000/svg">
                                                                            <path d="M1.58936 3.42876L5.88549 6.18822L10.1673 0.413067C10.2619 0.285313 10.3868 0.181179 10.5317 0.109331C10.6765 0.0374835 10.837 0 10.9999 0C11.1628 0 11.3234 0.0374835 11.4682 0.109331C11.613 0.181179 11.7379 0.285313 11.8326 0.413067L16.1144 6.18822L20.4105 3.42876C20.5731 3.32454 20.7633 3.26734 20.9585 3.26392C21.1538 3.2605 21.346 3.31101 21.5124 3.40947C21.6788 3.50793 21.8125 3.65023 21.8976 3.81956C21.9828 3.98888 22.0159 4.17815 21.9929 4.36501L20.3123 18.1298C20.283 18.3695 20.1634 18.5905 19.9762 18.7509C19.7889 18.9113 19.5471 19 19.2966 19H2.70328C2.45274 19 2.21093 18.9113 2.0237 18.7509C1.83648 18.5905 1.71687 18.3695 1.68755 18.1298L0.00694712 4.36402C-0.015761 4.17725 0.0174677 3.98811 0.102711 3.81895C0.187954 3.64978 0.321652 3.50764 0.488023 3.40931C0.654394 3.31098 0.846492 3.26056 1.04164 3.26401C1.23679 3.26745 1.42684 3.32462 1.58936 3.42876ZM10.9999 13.0869C11.5425 13.0869 12.0629 12.8792 12.4465 12.5096C12.8302 12.1399 13.0457 11.6386 13.0457 11.1158C13.0457 10.5931 12.8302 10.0917 12.4465 9.72209C12.0629 9.35245 11.5425 9.14479 10.9999 9.14479C10.4574 9.14479 9.93701 9.35245 9.55335 9.72209C9.16969 10.0917 8.95416 10.5931 8.95416 11.1158C8.95416 11.6386 9.16969 12.1399 9.55335 12.5096C9.93701 12.8792 10.4574 13.0869 10.9999 13.0869Z"
                                                                                  fill="#F50000"/>
                                                                        </svg>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- ID "tipe3" shold be UNIC for every product card -->
                                                        <div class="py-3 border-bottom d-flex justify-content-between"
                                                             id="tipe3">
                                                            <span class="font-weight-bold">5,00 ₪</span>

                                                            <label class="custom-radio-btn">
                                                                <!-- Change for every button "data-target", "aria-controls" data value "#ID under section"-->
                                                                <input type="radio"
                                                                       name="riseProduct"
                                                                       data-toggle="collapse"
                                                                       data-target="#collapseThre"
                                                                       aria-expanded="true"
                                                                       aria-controls="collapseThre">
                                                                <span>Экспресс-продажа</span>
                                                                <span class="checkbox"></span>
                                                            </label>
                                                        </div>

                                                        <!-- ID "collapseThre" shold be UNIC for every product card -->
                                                        <!-- data-parent = MAIN ID data-parent="#accordionSection" -->
                                                        <div id="collapseThre" class="collapse"
                                                             aria-labelledby="tipe3"
                                                             data-parent="#accordionSection">
                                                            <div class="p-3 d-flex flex-column new-collapse">
                                                                <p class="mb-4 text-uppercase font-weight-bold">
                                                                    на 15 просмотров больше
                                                                </p>

                                                                <p class="text-right">Неделя
                                                                    поднятий с
                                                                    ярким выделением - привлекайте
                                                                    как
                                                                    можно больше внимания к своему
                                                                    товару.</p>

                                                                <div class="d-flex position-relative justify-content-end pr-5">
                                                                    <p class="text-right">1 поднятие
                                                                        в
                                                                        день - на <span
                                                                                class="font-weight-bold">7</span>
                                                                        дней <span
                                                                                class="font-weight-bold">(первое - завтра)</span>
                                                                    </p>

                                                                    <div class="circle-icon">
                                                                        <div class="d-flex justify-content-center align-items-center user-product__up-product">
                                                                                                        <span data-id="<?= $arItem['ID'] ?>"
                                                                                                              class="text-uppercase font-weight-bold upRise">UP</span>

                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="d-flex position-relative justify-content-end pr-5">
                                                                    <p class="text-right">Выделение
                                                                        - на
                                                                        <span class="font-weight-bold">7</span>
                                                                        дней</p>

                                                                    <div class="circle-icon">
                                                                        <svg width="16" height="16"
                                                                             viewBox="0 0 16 16"
                                                                             fill="none"
                                                                             xmlns="http://www.w3.org/2000/svg">
                                                                            <rect width="9.40476"
                                                                                  height="6.83184"
                                                                                  rx="0.5"
                                                                                  transform="matrix(0.977206 -0.212292 0.118541 0.992949 0.503906 9.04102)"
                                                                                  fill="#FB2BFF"/>
                                                                            <rect width="10.4788"
                                                                                  height="6.83184"
                                                                                  rx="0.5"
                                                                                  transform="matrix(0.977206 -0.212292 0.118541 0.992949 4.87109 3.15161)"
                                                                                  fill="#FB2BFF"/>
                                                                            <path d="M5.58984 9.95654L9.93666 9.01223L10.4706 13.4847L5.58984 9.95654Z"
                                                                                  fill="#961299"/>
                                                                        </svg>

                                                                    </div>
                                                                </div>

                                                                <div class="d-flex position-relative justify-content-end pr-5">
                                                                    <p class="text-right">VIP -
                                                                        закрепление - на <span
                                                                                class="font-weight-bold">3</span>
                                                                        дня</p>

                                                                    <div class="circle-icon">
                                                                        <svg width="22" height="19"
                                                                             viewBox="0 0 22 19"
                                                                             fill="none"
                                                                             xmlns="http://www.w3.org/2000/svg">
                                                                            <path d="M1.58936 3.42876L5.88549 6.18822L10.1673 0.413067C10.2619 0.285313 10.3868 0.181179 10.5317 0.109331C10.6765 0.0374835 10.837 0 10.9999 0C11.1628 0 11.3234 0.0374835 11.4682 0.109331C11.613 0.181179 11.7379 0.285313 11.8326 0.413067L16.1144 6.18822L20.4105 3.42876C20.5731 3.32454 20.7633 3.26734 20.9585 3.26392C21.1538 3.2605 21.346 3.31101 21.5124 3.40947C21.6788 3.50793 21.8125 3.65023 21.8976 3.81956C21.9828 3.98888 22.0159 4.17815 21.9929 4.36501L20.3123 18.1298C20.283 18.3695 20.1634 18.5905 19.9762 18.7509C19.7889 18.9113 19.5471 19 19.2966 19H2.70328C2.45274 19 2.21093 18.9113 2.0237 18.7509C1.83648 18.5905 1.71687 18.3695 1.68755 18.1298L0.00694712 4.36402C-0.015761 4.17725 0.0174677 3.98811 0.102711 3.81895C0.187954 3.64978 0.321652 3.50764 0.488023 3.40931C0.654394 3.31098 0.846492 3.26056 1.04164 3.26401C1.23679 3.26745 1.42684 3.32462 1.58936 3.42876ZM10.9999 13.0869C11.5425 13.0869 12.0629 12.8792 12.4465 12.5096C12.8302 12.1399 13.0457 11.6386 13.0457 11.1158C13.0457 10.5931 12.8302 10.0917 12.4465 9.72209C12.0629 9.35245 11.5425 9.14479 10.9999 9.14479C10.4574 9.14479 9.93701 9.35245 9.55335 9.72209C9.16969 10.0917 8.95416 10.5931 8.95416 11.1158C8.95416 11.6386 9.16969 12.1399 9.55335 12.5096C9.93701 12.8792 10.4574 13.0869 10.9999 13.0869Z"
                                                                                  fill="#F50000"/>
                                                                        </svg>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- ID "tipe4" shold be UNIC for every product card -->
                                                        <div class="py-3 border-bottom d-flex justify-content-between"
                                                             id="tipe4">
                                                            <span class="font-weight-bold">3,50 ₪</span>

                                                            <label class="custom-radio-btn">
                                                                <!-- Change for every button "data-target", "aria-controls" data value "#ID under section"-->
                                                                <input type="radio"
                                                                       name="riseProduct"
                                                                       data-toggle="collapse"
                                                                       data-target="#collapseFour"
                                                                       aria-expanded="true"
                                                                       aria-controls="collapseFour">
                                                                <span>Скорая продажа</span>
                                                                <span class="checkbox"></span>
                                                            </label>
                                                        </div>

                                                        <!-- ID "collapseFour" shold be UNIC for every product card -->
                                                        <!-- data-parent = MAIN ID data-parent="#accordionSection" -->
                                                        <div id="collapseFour" class="collapse"
                                                             aria-labelledby="tipe4"
                                                             data-parent="#accordionSection">
                                                            <div class="p-3 d-flex flex-column new-collapse">
                                                                <p class="mb-4 text-uppercase font-weight-bold">
                                                                    на 15 просмотров больше
                                                                </p>

                                                                <p class="text-right">Неделя
                                                                    поднятий с
                                                                    ярким выделением - привлекайте
                                                                    как
                                                                    можно больше внимания к своему
                                                                    товару.</p>

                                                                <div class="d-flex position-relative justify-content-end pr-5">
                                                                    <p class="text-right">1 поднятие
                                                                        в
                                                                        день - на <span
                                                                                class="font-weight-bold">7</span>
                                                                        дней <span
                                                                                class="font-weight-bold">(первое - завтра)</span>
                                                                    </p>

                                                                    <div class="circle-icon">
                                                                        <div class="d-flex justify-content-center align-items-center user-product__up-product">
                                                                                                        <span data-id="<?= $arItem['ID'] ?>"
                                                                                                              class="text-uppercase font-weight-bold upRise">UP</span>

                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="d-flex position-relative justify-content-end pr-5">
                                                                    <p class="text-right">Выделение
                                                                        - на
                                                                        <span class="font-weight-bold">7</span>
                                                                        дней</p>

                                                                    <div class="circle-icon">
                                                                        <svg width="16" height="16"
                                                                             viewBox="0 0 16 16"
                                                                             fill="none"
                                                                             xmlns="http://www.w3.org/2000/svg">
                                                                            <rect width="9.40476"
                                                                                  height="6.83184"
                                                                                  rx="0.5"
                                                                                  transform="matrix(0.977206 -0.212292 0.118541 0.992949 0.503906 9.04102)"
                                                                                  fill="#FB2BFF"/>
                                                                            <rect width="10.4788"
                                                                                  height="6.83184"
                                                                                  rx="0.5"
                                                                                  transform="matrix(0.977206 -0.212292 0.118541 0.992949 4.87109 3.15161)"
                                                                                  fill="#FB2BFF"/>
                                                                            <path d="M5.58984 9.95654L9.93666 9.01223L10.4706 13.4847L5.58984 9.95654Z"
                                                                                  fill="#961299"/>
                                                                        </svg>

                                                                    </div>
                                                                </div>

                                                                <div class="d-flex position-relative justify-content-end pr-5">
                                                                    <p class="text-right">VIP -
                                                                        закрепление - на <span
                                                                                class="font-weight-bold">3</span>
                                                                        дня</p>

                                                                    <div class="circle-icon">
                                                                        <svg width="22" height="19"
                                                                             viewBox="0 0 22 19"
                                                                             fill="none"
                                                                             xmlns="http://www.w3.org/2000/svg">
                                                                            <path d="M1.58936 3.42876L5.88549 6.18822L10.1673 0.413067C10.2619 0.285313 10.3868 0.181179 10.5317 0.109331C10.6765 0.0374835 10.837 0 10.9999 0C11.1628 0 11.3234 0.0374835 11.4682 0.109331C11.613 0.181179 11.7379 0.285313 11.8326 0.413067L16.1144 6.18822L20.4105 3.42876C20.5731 3.32454 20.7633 3.26734 20.9585 3.26392C21.1538 3.2605 21.346 3.31101 21.5124 3.40947C21.6788 3.50793 21.8125 3.65023 21.8976 3.81956C21.9828 3.98888 22.0159 4.17815 21.9929 4.36501L20.3123 18.1298C20.283 18.3695 20.1634 18.5905 19.9762 18.7509C19.7889 18.9113 19.5471 19 19.2966 19H2.70328C2.45274 19 2.21093 18.9113 2.0237 18.7509C1.83648 18.5905 1.71687 18.3695 1.68755 18.1298L0.00694712 4.36402C-0.015761 4.17725 0.0174677 3.98811 0.102711 3.81895C0.187954 3.64978 0.321652 3.50764 0.488023 3.40931C0.654394 3.31098 0.846492 3.26056 1.04164 3.26401C1.23679 3.26745 1.42684 3.32462 1.58936 3.42876ZM10.9999 13.0869C11.5425 13.0869 12.0629 12.8792 12.4465 12.5096C12.8302 12.1399 13.0457 11.6386 13.0457 11.1158C13.0457 10.5931 12.8302 10.0917 12.4465 9.72209C12.0629 9.35245 11.5425 9.14479 10.9999 9.14479C10.4574 9.14479 9.93701 9.35245 9.55335 9.72209C9.16969 10.0917 8.95416 10.5931 8.95416 11.1158C8.95416 11.6386 9.16969 12.1399 9.55335 12.5096C9.93701 12.8792 10.4574 13.0869 10.9999 13.0869Z"
                                                                                  fill="#F50000"/>
                                                                        </svg>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <p class="mb-3 font-weight-bold content-subtitle">
                                                        <?= Loc::getMessage('PAY_CHOISE'); ?>
                                                        :</p>

                                                    <div class="d-flex flex-column justify-content-end align-items-end">
                                                        <button type="button" class="mb-3 btn btn-primary btn-paid">
                                                            <span class="mr-2">
                                                                <svg width="17"
                                                                  height="17"
                                                                  viewBox="0 0 17 17"
                                                                  fill="none"
                                                                  xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M11.8169 0.00066338C8.95442 0.00066338 6.63389 1.28034 6.63389 2.8612C6.63389 4.44205 8.95508 5.72239 11.8169 5.72239C14.6795 5.72239 17 4.44205 17 2.8612C17 1.28034 14.6788 0 11.8169 0V0.00066338ZM17 3.711C16.9987 5.29185 14.6795 6.57219 11.8169 6.57219C8.96238 6.57219 6.64716 5.30578 6.63389 3.73223V4.85136C6.63389 5.52669 7.06642 6.14497 7.77492 6.63455C8.49138 6.82959 9.12956 7.10025 9.66093 7.44256C10.3197 7.60973 11.0441 7.71189 11.8169 7.71189C14.6795 7.71189 17 6.43222 17 4.85136V3.711ZM17 5.70116C17 7.28202 14.6795 8.56236 11.8169 8.56236C11.4687 8.56236 11.1303 8.53649 10.8013 8.5C11.0609 8.84969 11.2381 9.25361 11.3194 9.6815C11.4846 9.69078 11.6478 9.70206 11.8169 9.70206C14.6795 9.70206 17 8.42238 17 6.84153V5.70116ZM5.18306 7.29728C2.32053 7.29728 0 8.57762 0 10.1585C0 11.7393 2.3212 13.0197 5.18306 13.0197C8.04558 13.0197 10.3661 11.7393 10.3661 10.1585C10.3661 8.57762 8.04492 7.29728 5.18306 7.29728ZM17 7.69133C16.9987 9.27219 14.6795 10.5525 11.8169 10.5525C11.6504 10.5525 11.4819 10.5406 11.3194 10.5313C11.3121 10.5811 11.3081 10.6474 11.2988 10.6971C11.332 10.7973 11.3605 10.8962 11.3605 11.0089V11.6723C11.5111 11.6796 11.6624 11.6922 11.8169 11.6922C14.6795 11.6922 17 10.4125 17 8.83169V7.69133ZM17 9.6815C16.9987 11.2624 14.6795 12.5427 11.8169 12.5427C11.6504 12.5427 11.4819 12.5308 11.3194 12.5215C11.3121 12.5712 11.3081 12.6376 11.2988 12.6873C11.332 12.7868 11.3605 12.8863 11.3605 12.9991V13.6625C11.5111 13.6698 11.6624 13.6824 11.8169 13.6824C14.6795 13.6824 17 12.4027 17 10.8219V9.6815ZM10.3661 11.0083C10.3648 12.5891 8.04558 13.8695 5.18306 13.8695C2.32849 13.8695 0.0132678 12.6031 0 11.0288V12.1486C0 13.7295 2.31987 15.0098 5.18306 15.0098C8.04624 15.0098 10.3661 13.7295 10.3661 12.1486V11.0083ZM10.3661 12.9984C10.3648 14.5793 8.04558 15.8596 5.18306 15.8596C2.32849 15.8596 0.0132678 14.5932 0 13.019V14.1388C0 15.7197 2.31987 17 5.18306 17C8.04624 17 10.3661 15.7197 10.3661 14.1388V12.9984Z" fill="white"/>
                                                                </svg>
                                                            </span>
                                                            <?= Loc::getMessage('PAY_T_COINS'); ?>
                                                        </button>
                                                        <button type="button" class="btn btn-primary btn-paid">
                                                            <span class="mr-2">
                                                                <svg width="17"
                                                                      height="14"
                                                                      viewBox="0 0 17 14"
                                                                      fill="none"
                                                                      xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M16.3929 0H0.607143C0.271317 0 0 0.284375 0 0.636364V3.81818H17V0.636364C17 0.284375 16.7287 0 16.3929 0ZM0 13.3636C0 13.7156 0.271317 14 0.607143 14H16.3929C16.7287 14 17 13.7156 17 13.3636V5.56818H0V13.3636ZM10.9855 9.70455C10.9855 9.61705 11.0538 9.54545 11.1373 9.54545H14.2679C14.3513 9.54545 14.4196 9.61705 14.4196 9.70455V11.1364C14.4196 11.2239 14.3513 11.2955 14.2679 11.2955H11.1373C11.0538 11.2955 10.9855 11.2239 10.9855 11.1364V9.70455Z" fill="white"/>
                                                                </svg>
                                                            </span>
                                                            <?= Loc::getMessage('PAY_CARD'); ?>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="border-top py-3 d-flex justify-content-between align-items-center text-nowrap product-line__data-viwe">
                        <div class="d-flex">
                            <span class="mr-0 mr-lg-2 views">
                                <span><?= $arItem['SHOW_COUNTER'] ?></span>
                                <i class="icon-visibility"></i>
                            </span>
                            <div class="d-none d-lg-flex justify-content-end align-items-center ml-5 product-line__up-date">
                                <div class="mr-2 d-flex justify-content-center align-items-center user-product__up-product">
                                    <span data-id="<?= $arItem['ID'] ?>" class="text-uppercase font-weight-bold upRise">UP</span>
                                </div>
                                <? $strDate = getStringDate($arItem['PROPERTY']['TIME_RAISE']['VALUE']); ?>
                                <span class="up-date"><?= ($strDate['MES']) ? GetMessage($strDate['MES']) . ', ' . $strDate['HOURS'] : $strDate['HOURS']; ?></span>
                            </div>
                        </div>
                        <? $strDate2 = getStringDate($arItem['DATE_CREATE']); ?>
                        <span class="date"><?= ($strDate2['MES']) ? GetMessage($strDate2['MES']) . ', ' . $strDate2['HOURS'] : $strDate2['HOURS']; ?></span>
                    </div>
                </div>
            </div>
            <?php if ($arItem['PROPERTY']['COUNT_RAISE']['VALUE'] != '' && $arItem['PROPERTY']['COUNT_RAISE']['VALUE'] > 0):?>
                <div type="button"
                     data-id="<?= $arItem['ID'] ?>" data-iblock-id="<?= $arItem['IBLOCK_ID'] ?>"
                     class="b-none d-lg-flex justify-content-center align-items-center rise-btn">
                    <span data-id="<?= $arItem['ID'] ?>" class="mr-1 text-uppercase font-weight-bold up">UP</span>
                    <p class="m-0"><?= Loc::getMessage('UP_RISE'); ?>
                        (<span><?= $arItem['PROPERTY']['COUNT_RAISE']['VALUE'] ?></span>)</p>
                </div>
            <?php endif;?>
            <div class="d-flex flex-column controls-rise-item">
                <?php if ($arItem['PROPERTY']['VIP_DATE']['VALUE'] && strtotime($arItem['PROPERTY']['VIP_DATE']['VALUE']) > time()):?>
                    <div class="d-flex justify-content-center align-items-center item">
                        <svg width="22" height="19" viewBox="0 0 22 19" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path d="M1.58936 3.42876L5.88549 6.18822L10.1673 0.413067C10.2619 0.285313 10.3868 0.181179 10.5317 0.109331C10.6765 0.0374835 10.837 0 10.9999 0C11.1628 0 11.3234 0.0374835 11.4682 0.109331C11.613 0.181179 11.7379 0.285313 11.8326 0.413067L16.1144 6.18822L20.4105 3.42876C20.5731 3.32454 20.7633 3.26734 20.9585 3.26392C21.1538 3.2605 21.346 3.31101 21.5124 3.40947C21.6788 3.50793 21.8125 3.65023 21.8976 3.81956C21.9828 3.98888 22.0159 4.17815 21.9929 4.36501L20.3123 18.1298C20.283 18.3695 20.1634 18.5905 19.9762 18.7509C19.7889 18.9113 19.5471 19 19.2966 19H2.70328C2.45274 19 2.21093 18.9113 2.0237 18.7509C1.83648 18.5905 1.71687 18.3695 1.68755 18.1298L0.00694712 4.36402C-0.015761 4.17725 0.0174677 3.98811 0.102711 3.81895C0.187954 3.64978 0.321652 3.50764 0.488023 3.40931C0.654394 3.31098 0.846492 3.26056 1.04164 3.26401C1.23679 3.26745 1.42684 3.32462 1.58936 3.42876ZM10.9999 13.0869C11.5425 13.0869 12.0629 12.8792 12.4465 12.5096C12.8302 12.1399 13.0457 11.6386 13.0457 11.1158C13.0457 10.5931 12.8302 10.0917 12.4465 9.72209C12.0629 9.35245 11.5425 9.14479 10.9999 9.14479C10.4574 9.14479 9.93701 9.35245 9.55335 9.72209C9.16969 10.0917 8.95416 10.5931 8.95416 11.1158C8.95416 11.6386 9.16969 12.1399 9.55335 12.5096C9.93701 12.8792 10.4574 13.0869 10.9999 13.0869Z"
                                  fill="#F50000"/>
                        </svg>
                    </div>
                <?php endif;?>
                <?php if ($arItem['PROPERTY']['COLOR_DATE']['VALUE'] && strtotime($arItem['PROPERTY']['COLOR_DATE']['VALUE']) > time()):?>
                    <div class="d-flex justify-content-center align-items-center item">
                        <svg width="16" height="17" viewBox="0 0 16 17" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path d="M8.20189 0.934761C8.20189 0.779763 8.14032 0.631114 8.03072 0.521514C7.92112 0.411914 7.77247 0.350342 7.61747 0.350342C7.46247 0.350342 7.31382 0.411914 7.20422 0.521514C7.09462 0.631114 7.03305 0.779763 7.03305 0.934761V1.90879C6.78643 1.99564 6.56248 2.13677 6.37772 2.32178L1.01743 7.68285C0.854624 7.84566 0.725478 8.03894 0.637367 8.25165C0.549256 8.46437 0.503906 8.69236 0.503906 8.9226C0.503906 9.15284 0.549256 9.38083 0.637367 9.59355C0.725478 9.80626 0.854624 9.99954 1.01743 10.1623L4.82005 13.9634C4.98286 14.1262 5.17613 14.2554 5.38885 14.3435C5.60157 14.4316 5.82956 14.4769 6.0598 14.4769C6.29004 14.4769 6.51803 14.4316 6.73075 14.3435C6.94346 14.2554 7.13674 14.1262 7.29955 13.9634L12.6598 8.60312C12.8226 8.44031 12.9518 8.24703 13.0399 8.03432C13.128 7.8216 13.1734 7.59361 13.1734 7.36337C13.1734 7.13313 13.128 6.90514 13.0399 6.69242C12.9518 6.47971 12.8226 6.28643 12.6598 6.12362L8.85644 2.32178C8.67191 2.13687 8.44823 1.99574 8.20189 1.90879V0.934761ZM7.03305 3.31919V4.44127C7.03305 4.59627 7.09462 4.74492 7.20422 4.85452C7.31382 4.96412 7.46247 5.02569 7.61747 5.02569C7.77247 5.02569 7.92112 4.96412 8.03072 4.85452C8.14032 4.74492 8.20189 4.59627 8.20189 4.44127V3.31919L11.8323 6.95038C11.9417 7.05996 12.0032 7.2085 12.0032 7.36337C12.0032 7.51824 11.9417 7.66678 11.8323 7.77636L11.0765 8.53221H1.82159L1.84419 8.50883L7.03305 3.31919Z"
                                  fill="#6633F5"/>
                            <path d="M14.063 9.78046C14.0049 9.67162 13.9183 9.5806 13.8125 9.51714C13.7067 9.45369 13.5856 9.42017 13.4622 9.42017C13.3388 9.42017 13.2177 9.45369 13.1119 9.51714C13.0061 9.5806 12.9195 9.67162 12.8614 9.78046L11.2967 12.715C10.4232 14.3498 11.6092 16.3244 13.4622 16.3244C15.3152 16.3244 16.4996 14.3498 15.6284 12.715L14.063 9.78046Z"
                                  fill="#6633F5"/>
                        </svg>
                    </div>
                <?php endif;?>
                <?php if ($arItem['PROPERTY']['LENTA_DATE']['VALUE'] && strtotime($arItem['PROPERTY']['LENTA_DATE']['VALUE']) > time()):?>
                    <div class="d-flex justify-content-center align-items-center item">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <rect width="9.40476" height="6.83184" rx="0.5"
                                  transform="matrix(0.977206 -0.212292 0.118541 0.992949 0.503906 9.04102)"
                                  fill="#FB2BFF"/>
                            <rect width="10.4788" height="6.83184" rx="0.5"
                                  transform="matrix(0.977206 -0.212292 0.118541 0.992949 4.87109 3.15161)"
                                  fill="#FB2BFF"/>
                            <path d="M5.58984 9.95654L9.93666 9.01223L10.4706 13.4847L5.58984 9.95654Z"
                                  fill="#961299"/>
                        </svg>
                    </div>
                <?php endif?>
                <?php if ($arItem['PROPERTY']['PAKET_DATE']['VALUE'] && strtotime($arItem['PROPERTY']['PAKET_DATE']['VALUE']) > time()):?>
                    <div class="d-flex justify-content-center align-items-center item">
                        <svg width="16" height="18" viewBox="0 0 16 18" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M10.7811 0.968714C10.7811 0.792056 10.7264 0.619732 10.6246 0.475353C10.5228 0.330975 10.3789 0.221608 10.2125 0.16224C10.0461 0.102871 9.86545 0.0964054 9.69525 0.143729C9.52505 0.191053 9.37365 0.289851 9.26179 0.426584L0.697334 9.84749C0.594729 9.97297 0.529841 10.125 0.510211 10.2859C0.49058 10.4468 0.517013 10.61 0.586437 10.7564C0.655861 10.9029 0.765426 11.0267 0.902399 11.1133C1.03937 11.2 1.19813 11.246 1.36022 11.2461H5.64245V16.3847C5.64248 16.5614 5.69714 16.7337 5.79894 16.8781C5.90074 17.0225 6.04469 17.1318 6.21107 17.1912C6.37746 17.2506 6.55813 17.257 6.72833 17.2097C6.89853 17.1624 7.04993 17.0636 7.16179 16.9269L15.7262 7.50596C15.8288 7.38048 15.8937 7.22845 15.9134 7.06755C15.933 6.90666 15.9066 6.74349 15.8371 6.59702C15.7677 6.45054 15.6582 6.32678 15.5212 6.24011C15.3842 6.15343 15.2254 6.10741 15.0634 6.10739H10.7811V0.968714Z"
                                  fill="#FF6B00"/>
                        </svg>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach;?>
<?php endif;?>