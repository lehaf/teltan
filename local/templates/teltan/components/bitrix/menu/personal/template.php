<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Localization\Loc;

if (!empty($arResult)):?>
    <div class="d-none d-lg-block col-4 col-xl-3">
        <div class="card">
            <ul class="mb-0 user-profile-menu">
                <?php foreach($arResult as $k => $item):?>
                    <li class="user-profile-menu__list <?=!empty($item['CLASS']) ? $item['CLASS'] : ''?> <?=!empty($item['SELECTED']) ? 'active' : ''?>"
                        <?=!empty($item['PARAMS']['COUNTER_MESSAGES']) ? 'id="message_counter"' : ''?>
                    >
                        <?php if (empty($item['SELECTED'])):?>
                            <a href="<?=$item["LINK"]?>"
                                <?=!empty($item['PARAMS']['COUNTER_MESSAGES']) ? "class='d-flex justify-content-end align-items-center'" : ''?>
                            >
                                <?php if (!empty($item['PARAMS']['COUNTER_MESSAGES'])):?>
                                    <div class="d-inline-block counter-user-message hide">
                                        <span id="count_user_messages"></span>
                                    </div>
                                    <span class="ml-3"><?=$item["TEXT"]?></span>
                                <?php else:?>
                                    <?=$item["TEXT"]?>
                                <?php endif;?>
                            </a>
                        <?php else:?>
                            <?php if (!empty($item['PARAMS']['COUNTER_MESSAGES'])):?>
                                <span class="d-flex justify-content-end align-items-center">
                                    <div class="d-inline-block counter-user-message hide">
                                        <span id="count_user_messages"></span>
                                    </div>
                                    <span class="ml-3"><?=$item["TEXT"]?></span>
                                </span>
                            <?php else:?>
                                <span><?=$item["TEXT"]?></span>
                            <?php endif;?>
                        <?php endif?>
                    </li>
                <?php endforeach?>
                <li class="pb-0 border-bottom-0 user-profile-menu__list">
                    <a href="/?<?="logout=yes&".bitrix_sessid_get()?>">
                        <?=Loc::getMessage('LOG_OUT')?>
                    </a>
                </li>
            </ul>
        </div>
    </div>
<?php endif?>
