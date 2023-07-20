<?php
define('STOP_STATISTICS', true);
define('NO_KEEP_STATISTIC', 'Y');
define('NO_AGENT_STATISTIC','Y');
define('DisableEventsCheck', true);
define('BX_SECURITY_SHOW_MESSAGE', true);
define('NOT_CHECK_PERMISSIONS', true);

require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
require_once $_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/include/classes/AuctionParticipation.php';

Bitrix\Main\Loader::includeModule("iblock");

$bShowResult = false;

$request = Bitrix\Main\Application::getInstance()->getContext()->getRequest();
$ID = $request->getQuery('ID');

$USER_ID = \Bitrix\Main\Engine\CurrentUser::get()->getId();
if (!$USER_ID) die('error');

$AUCTION_ID = $request->getPost('AUCTION_ID');
$send = $request->getPost('send');
if (check_bitrix_sessid() && !empty($AUCTION_ID) && $send == 'Y')
{
    $AuctionParticipation = new AuctionParticipation();
	list($USER_SEND_PARTICIPATION) = $AuctionParticipation->getUserParticipation($AUCTION_ID, IBLOCK_ID_AUCTIONS_APPS_PARTICIPATION, $USER_ID);
    if ($USER_SEND_PARTICIPATION == 'N')
    {
	    if ($APP_ID = $AuctionParticipation->add($AUCTION_ID, IBLOCK_ID_AUCTIONS_APPS_PARTICIPATION, $USER_ID))
	    {
		    $bShowResult = true;
	    }
    }
}

if ($bShowResult)
{
    ?>
    <div class="form-popup">
        <div class="form-popup--wrp js-popup">
            <div class="form-popup__content js-popup-inner">
                <div class="form-popup--zag">
                    <span>Заявка на участие</span>
                </div>
                <span class="text">Заявка на участие успешно отправлена</span>
                <button class="btn btn-blue btn-arrow" onclick="$('#apply-for-participation').remove(); $.magnificPopup.close()">Закрыть</button>
            </div>
        </div>
    </div>
    <?
}
else
{
    ?>
    <div class="form-popup">
        <div class="form-popup--wrp js-popup">
            <div class="form-popup__content js-popup-inner">
                <div class="form-popup--zag">
                    <span>Заявка на участие</span>
                </div>
                <? //pr($_SERVER['SCRIPT_NAME']); ?>
                <span class="text">Отравка заявки на участие в аукционе</span>
                <form action="<?= $_SERVER['SCRIPT_NAME'] ?>" method="post" class="js-form-popup">
					<?= bitrix_sessid_post() ?>
                    <input type="hidden" name="send" value="Y">
                    <input type="hidden" name="AUCTION_ID" value="<?= $ID ?>">

                    <button class="btn btn-blue btn-arrow required--sbmt" type="submit">
                        Отправить
                        <svg class="icon icon-btn-arrow ">
                            <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/img/svg/symbol/sprite.svg#btn-arrow"></use>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
    <?
}
?>