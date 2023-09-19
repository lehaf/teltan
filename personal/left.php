<?

use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);
$count_mess = getCountUnreadMessages($IDUser);
?>
<div class="d-none d-lg-block col-4 col-xl-3">
    <div class="card">
        <ul class="mb-0 user-profile-menu">
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
            <?/*?><li class="user-profile-menu__list"><a href="/personal/wallet/"><?=Loc::getMessage('BUY_HISTORY');?></a></li><?*/?>

            <li class="user-profile-menu__list"><a href="/personal/edit/"><?=Loc::getMessage('DATA_CHANGE');?></a></li>
            <li class="user-profile-menu__list"><a href="/personal/change_pass/"><?=Loc::getMessage('CHANGE_PASS');?></a></li>

            <li class="pb-0 border-bottom-0 user-profile-menu__list"><a href="/?<?="logout=yes&".bitrix_sessid_get()?>"><?=Loc::getMessage('LOG_OUT');?></a></li>

        </ul>
    </div>
</div>