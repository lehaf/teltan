<?use Bitrix\Main\Localization\Loc;?>
<?
Loc::loadMessages(__FILE__);
$count_mess = getCountUnreadMessages($IDUser);
require($_SERVER["DOCUMENT_ROOT"]."/vendor/autoload.php");
$detect = new Mobile_Detect;
?>
<div class="mr-2 mb-1 d-flex">
    <a<?if (!$detect->isMobile()) {echo ' href="/personal/"';}?> type="button" class="d-flex align-items-center mr-3 btnUserMenuProfile">
        <span class="d-none d-lg-block mr-2"><?=Loc::getMessage('MY_PROFILE');?></span>
        <i class="icon-user-1"></i>
    </a>

    <ul class="mb-0 user-profile-menu user-profile-menu__header">
        <li class="pt-0 user-profile-menu__list active"><a href="/personal/"><?=Loc::getMessage('CABINET');?></a></li>

        <li class="user-profile-menu__list ">
            <a class="d-flex justify-content-end align-items-center" href="/personal/messages/">
                <div class="d-inline-block counter-user-message">
                    <span><?=($count_mess > 99) ? '99+' : $count_mess;?></span>
                </div>
                <span class="ml-3"><?=Loc::getMessage('MESSAGES');?></span>
            </a>
        </li>

        <li class="user-profile-menu__list"><a href="/personal/wallet/"><?=Loc::getMessage('BUY_HISTORY');?></a></li>

        <li class="user-profile-menu__list"><a href="/personal/rate/"><?=Loc::getMessage('BUY_TARIF');?></a></li>

        <li class="user-profile-menu__list"><a href="/personal/favorites/"><?=Loc::getMessage('TRACKED');?></a></li>

        <?/*?><li class="user-profile-menu__list"><a href="/personal/wallet/"><?=Loc::getMessage('BUY_HISTORY');?></a></li> <?*/?>

        <li class="user-profile-menu__list"><a href="/personal/edit/"><?=Loc::getMessage('DATA_CHANGE');?></a></li>
        <li class="user-profile-menu__list"><a href="/personal/change_pass/"><?=Loc::getMessage('CHANGE_PASS');?></a></li>

        <li class="pb-0 border-bottom-0 user-profile-menu__list"><a href="/?<?="logout=yes&".bitrix_sessid_get()?>"><?=Loc::getMessage('LOG_OUT');?></a></li>
    </ul>
</div>

<a href="/personal/messages/" class="mr-4 user-message">
    <i class="icon-chat-1"></i>
    <div class="user-message__counter counter-message<?=($count_mess) ? ' not-empty' : '';?>">
        <span><?=($count_mess > 99) ? 99 : $count_mess;?></span>
    </div>
</a>


<a href="#" style="display: none" class="mr-4 user-basket">
    <svg width="21" height="19" viewBox="0 0 21 19" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M7.36401 19C8.16642 19 8.81689 18.3495 8.81689 17.5471C8.81689 16.7447 8.16642 16.0942 7.36401 16.0942C6.56161 16.0942 5.91113 16.7447 5.91113 17.5471C5.91113 18.3495 6.56161 19 7.36401 19Z" fill="#1E1E1E"/>
        <path d="M16.1902 19C16.9926 19 17.6431 18.3495 17.6431 17.5471C17.6431 16.7447 16.9926 16.0942 16.1902 16.0942C15.3878 16.0942 14.7373 16.7447 14.7373 17.5471C14.7373 18.3495 15.3878 19 16.1902 19Z" fill="#1E1E1E"/>
        <path d="M20.1167 1.80435C20.0566 1.73028 19.9808 1.67044 19.8949 1.62912C19.8089 1.58781 19.7148 1.56606 19.6195 1.56543H6.17547L6.59519 2.85688H18.7736L17.0495 10.6056H7.3636L4.41264 1.26194C4.38072 1.1628 4.32529 1.07284 4.25108 0.999758C4.17687 0.926672 4.08608 0.872623 3.98646 0.842221L1.33899 0.0286077C1.25759 0.00359236 1.17205 -0.00514392 1.08727 0.00289759C1.00249 0.0109391 0.920119 0.035601 0.844868 0.0754751C0.692891 0.156004 0.579129 0.293608 0.528609 0.458015C0.478088 0.622421 0.494947 0.800163 0.575476 0.95214C0.656005 1.10412 0.793609 1.21788 0.958016 1.2684L3.27617 1.9787L6.24004 11.3417L5.18105 12.207L5.09711 12.2909C4.83516 12.5928 4.68669 12.9766 4.67726 13.3761C4.66783 13.7757 4.79804 14.166 5.04545 14.4799C5.22145 14.694 5.4451 14.8638 5.6985 14.976C5.9519 15.0881 6.22803 15.1393 6.50479 15.1256H17.2819C17.4532 15.1256 17.6174 15.0576 17.7385 14.9365C17.8596 14.8154 17.9277 14.6512 17.9277 14.4799C17.9277 14.3087 17.8596 14.1444 17.7385 14.0233C17.6174 13.9022 17.4532 13.8342 17.2819 13.8342H6.40147C6.32712 13.8317 6.25467 13.81 6.19113 13.7713C6.1276 13.7326 6.07512 13.6781 6.03877 13.6132C6.00241 13.5483 5.98342 13.4751 5.98361 13.4007C5.9838 13.3263 6.00318 13.2532 6.03987 13.1885L7.59606 11.897H17.566C17.7153 11.9007 17.8612 11.8525 17.979 11.7606C18.0967 11.6688 18.179 11.539 18.2118 11.3934L20.2587 2.35322C20.2784 2.25695 20.2758 2.15747 20.2511 2.06236C20.2265 1.96724 20.1805 1.879 20.1167 1.80435Z" fill="#1E1E1E"/>
    </svg>

    <div class="user-basket__counter">
        <span>0</span>
    </div>
</a>

<a href="/personal/favorites/" class="user-follows">
    <i class="icon-love-2"></i>
    <?$count_f = (int)count($favorites);?>
    <div class="user-follows__counter<?=($count_f) ? ' not-empty' : '';?>">
        <span><?=$count_f;?></span>
    </div>
</a>