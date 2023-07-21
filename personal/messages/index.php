<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);
global $USER, $APPLICATION;
if (!$USER->GetID()) LocalRedirect('/');
?>

<?

if (isset($_GET['id']) && isset($_GET['au']) && isset($_GET['ref'])) {
    ?>
    <?
    $ref = md5($_GET['au'] . SALT_ID_CHAT . $_GET['id']);

    if ($ref != $_GET['ref']) {
        ?>
        Error!
        <?
    } else {
        readAllMessageInChat($_GET['id'], $_GET['au']);
        $messages = getMessagesChat($_GET['id'], $IDUser, $_GET['au']);

        ?>
        <div class="container container-mes">
            <h2 class="mb-4 subtitle">
                <?= $APPLICATION->ShowTitle(); ?>
            </h2>

            <div class="row">
                <div class="col-12 col-lg-8 col-xl-9">
                    <!-- main chat controls -->
                    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-end">
                        <div class="d-flex justify-content-end justify-content-lg-start">
                            <button type="button" class="mr-3 mb-4 btn btn-delete-all">
                                <i class="mr-2 icon-clear"></i>
                                <span class="btn-delete-all__text del_all_in_chat" data-ad="<?= (int)$_GET['id']; ?>"
                                      data-au="<?= (int)$_GET['au']; ?>"><?= Loc::getMessage('delete_all'); ?></span>
                            </button>


                            <?
                            $blockedAuthor = false;
                            $blockedUser = false;
                            $blocked = false;
                            foreach ($messages as $message) {
                                if ($message['UF_BLOCK_AUTOR']) {
                                    $blockedAuthor = true;
                                    $blocked = true;
                                    if ($message['UF_DATE_BLOCK'])
                                        $blockTime = $message['UF_DATE_BLOCK']->format("d.m.Y");
                                    break;
                                }
                                if ($message['UF_BLOCK_USER']) {
                                    $blockedUser = true;
                                    $blocked = true;
                                    if ($message['UF_DATE_BLOCK'])
                                        $blockTime = $message['UF_DATE_BLOCK']->format("d.m.Y");
                                    break;
                                }
                            }

                            ?>
                            <button type="button"
                                    class="mb-4 btn <?= ($blocked) ? 'btn-unlocked' : 'btn-blocked' ?> border-danger"
                                    data-ad="<?= (int)$_GET['id']; ?>" data-au="<?= (int)$_GET['au']; ?>">
                <span><svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M13.657 2.343C12.146 0.832 10.137 0 8 0C5.863 0 3.854 0.832 2.343 2.343C0.832 3.854 0 5.863 0 8C0 10.137 0.832 12.146 2.343 13.657C3.854 15.168 5.863 16 8 16C10.137 16 12.146 15.168 13.657 13.657C15.168 12.146 16 10.137 16 8C16 5.863 15.168 3.854 13.657 2.343ZM14 8C14.0013 9.24588 13.6129 10.461 12.889 11.475L4.525 3.111C5.53903 2.38714 6.75412 1.99866 8 2C11.308 2 14 4.692 14 8ZM2 8C1.99866 6.75412 2.38714 5.53903 3.111 4.525L11.475 12.889C10.461 13.6129 9.24588 14.0013 8 14C4.692 14 2 11.308 2 8Z"
      fill="#F34747"/>
</svg>
</span>
                                <span class="text-danger btn-delete-all__text block_b"><?= ($blocked) ? 'Unlock' : Loc::getMessage('Block') ?></span>
                            </button>
                        </div>

                        <button style="cursor: pointer" onclick="window.location.href = '/personal/messages/'"
                                type="button"
                                class="mb-4 btn btn-go-back d-flex justify-content-center align-items-center border-primary">
                            <a href="/personal/messages/"><span
                                        class="mr-2 btn-delete-all__text"><?= Loc::getMessage('Back') ?></span></a>
                            <span><svg width="5" height="9" viewBox="0 0 5 9" fill="none"
                                       xmlns="http://www.w3.org/2000/svg">
<path d="M0.999999 8L4 4.5L1 1" stroke="#3FB465" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
</span>
                        </button>
                    </div>

                    <!-- MAIN CHAT WINDOW -->
                    <div style="overflow-y: scroll;height: 600px;"
                         class="chat card card-soket py-4 py-lg-3 px-4 px-lg-5">
                        <div class="chat__title d-flex flex-column align-items-end border-bottom">
                            <p onclick="window.location.href = '<?= getDetailAD((int)$_GET['id']) ?>'"
                               style="cursor: pointer"
                               class="font-weight-bolder text-uppercase"><?= getTitleAD((int)$_GET['id']); ?></p>
                            <p class="font-weight-bold text-primary"><?= ICON_CURRENCY; ?> <?= getPriceAD((int)$_GET['id']); ?></p>
                        </div>

                        <div class="chat__message-window">

                            <?
                            //$blocked = false;
                            // krsort($messages);
                            foreach ($messages as $message) {
                                $userInfo = getUserInfo($message['UF_AUTOR_ID']);
                                $strDate = getStringDate(date('d.m.Y H:i:s', $message['UF_DATE']));
                                ?>
                                <div class="d-flex flex-column text-right message<?= ($message['UF_AUTOR_ID'] == $IDUser) ? ' message-sand' : ''; ?>">
                                    <p class="user-info text-secondary"><span
                                                class="pr-3 mr-3 border-right"><?= ($strDate['MES']) ? Loc::getMessage($strDate['MES']) . ', ' . $strDate['HOURS'] : $strDate['HOURS'] . ' ' . $strDate['MIN']; ?></span>
                                        <span><?= $userInfo['LAST_NAME'] . ' ' . $userInfo['NAME']; ?></span></p>

                                    <p class="text">
                                        <?= $message['UF_MESSAGE']; ?>
                                    </p>
                                    <?
                                    if ($message['UF_FILES'][0]) {
                                        print '<div class="d-flex flex-row-reverse sand-files-box">';
                                        foreach ($message['UF_FILES'] as $file) {
                                            $dataFile = CFile::GetFileArray($file);
                                            ?>
                                            <a class="sand-file" href="<?= $dataFile['SRC']; ?>" target="_blank">
                                                    <span class="mr-2"><svg width="12" height="10" viewBox="0 0 12 10"
                                                                            fill="none"
                                                                            xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M7.50189 7.31659H6.50948V4.0715C6.50948 4.01257 6.46127 3.96436 6.40234 3.96436H5.59877C5.53984 3.96436 5.49162 4.01257 5.49162 4.0715V7.31659H4.50189C4.41216 7.31659 4.36261 7.41971 4.41752 7.48936L5.91752 9.38712C5.92754 9.39993 5.94034 9.41029 5.95496 9.41741C5.96958 9.42453 5.98563 9.42823 6.00189 9.42823C6.01815 9.42823 6.0342 9.42453 6.04882 9.41741C6.06344 9.41029 6.07624 9.39993 6.08627 9.38712L7.58627 7.48936C7.64118 7.41971 7.59162 7.31659 7.50189 7.31659Z"
                                                              fill="black"/>
                                                        <path d="M10.0098 2.7683C9.39643 1.15045 7.83348 0 6.00268 0C4.17188 0 2.60893 1.14911 1.99554 2.76696C0.847768 3.0683 0 4.11429 0 5.35714C0 6.83705 1.19866 8.03571 2.67723 8.03571H3.21429C3.27321 8.03571 3.32143 7.9875 3.32143 7.92857V7.125C3.32143 7.06607 3.27321 7.01786 3.21429 7.01786H2.67723C2.22589 7.01786 1.80134 6.83839 1.48527 6.51295C1.17054 6.18884 1.00312 5.75223 1.01786 5.29955C1.02991 4.94598 1.15045 4.61384 1.36875 4.33393C1.59241 4.04866 1.9058 3.84107 2.25402 3.74866L2.76161 3.61607L2.94777 3.12589C3.06295 2.82054 3.22366 2.53527 3.42589 2.27679C3.62554 2.02059 3.86204 1.79538 4.12768 1.60848C4.67813 1.22143 5.32634 1.01652 6.00268 1.01652C6.67902 1.01652 7.32723 1.22143 7.87768 1.60848C8.1442 1.79598 8.37991 2.02098 8.57946 2.27679C8.7817 2.53527 8.94241 2.82187 9.05759 3.12589L9.24241 3.61473L9.74866 3.74866C10.4746 3.9442 10.9821 4.60446 10.9821 5.35714C10.9821 5.80045 10.8094 6.2183 10.496 6.5317C10.3423 6.68629 10.1595 6.80885 9.95808 6.8923C9.75669 6.97576 9.54076 7.01843 9.32277 7.01786H8.78571C8.72679 7.01786 8.67857 7.06607 8.67857 7.125V7.92857C8.67857 7.9875 8.72679 8.03571 8.78571 8.03571H9.32277C10.8013 8.03571 12 6.83705 12 5.35714C12 4.11562 11.1549 3.07098 10.0098 2.7683Z"
                                                              fill="black"/>
                                                    </svg>
                                                    </span>
                                                <span><?= $dataFile['ORIGINAL_NAME']; ?></span>
                                            </a>
                                            <?
                                        }
                                        print '</div>';
                                    }

                                    if ($message['UF_AUTOR_ID'] == $IDUser) {
                                        ?>
                                        <p class="mb-0 status"><?= ($message['UF_READ']) ? Loc::getMessage('READ') : Loc::getMessage('SEND'); ?></p>
                                        <?
                                    }
                                    ?>
                                </div>
                                <?
                                /*if(($message['UF_BLOCK_AUTOR'] && $message['UF_AUTOR_ID'] == $IDUser) || ($message['UF_BLOCK_USER'] && $message['UF_ID_USER'] == $IDUser))
                                {
                                    $blocked = true;
                                    if($message['UF_DATE_BLOCK'])
                                        $blockTime = $message['UF_DATE_BLOCK']->format("d.m.Y");
                                    break;
                                }*/
                            }

                            ?>

                        </div>

                        <? if (!$blocked) {
                            ?>
                            <div style="padding-top: 15px" class="mb-4 d-flex flex-column">
                                <form id="send_lk_mess" onsubmit="submitForm(event)">
                                    <?= bitrix_sessid_post(); ?>
                                    <input type="hidden" name="IDAd" value="<?= (int)$_GET['id']; ?>" id="IDAd">
                                    <input type="hidden" name="IDau" value="<?= (int)$_GET['au']; ?>" id="IDau">
                                    <div class="mb-4 d-flex justify-content-center align-items-center">
                                        <label class="mr-3 mb-0 d-flex add-file-label" for="addFileChat">
                                                          <span class="mr-2"><svg width="15" height="19"
                                                                                  viewBox="0 0 15 19" fill="none"
                                                                                  xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 3.375V16.375C1 16.806 1.1712 17.2193 1.47595 17.524C1.7807 17.8288 2.19402 18 2.625 18H12.375C12.806 18 13.2193 17.8288 13.524 17.524C13.8288 17.2193 14 16.806 14 16.375V6.90288C14 6.68639 13.9567 6.4721 13.8727 6.27257C13.7887 6.07305 13.6657 5.89232 13.5109 5.741L9.90338 2.21312C9.59979 1.91628 9.19209 1.75005 8.7675 1.75H2.625C2.19402 1.75 1.7807 1.9212 1.47595 2.22595C1.1712 2.5307 1 2.94402 1 3.375V3.375Z"
                                              stroke="#3FB465" stroke-width="2" stroke-linecap="round"
                                              stroke-linejoin="round"/>
                                        <path d="M5.0625 10.6875H9.9375" stroke="#3FB465" stroke-width="2"
                                              stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M5.0625 13.9375H7.5" stroke="#3FB465" stroke-width="2"
                                              stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M9.125 1.75V5C9.125 5.43098 9.29621 5.8443 9.60095 6.14905C9.9057 6.4538 10.319 6.625 10.75 6.625H14"
                                              stroke="#3FB465" stroke-width="2" stroke-linejoin="round"/>
                                        </svg>
                                        </span>
                                            <span class="pt-1 d-none d-md-inline text-primary text-nowrap"><?= Loc::getMessage('Add_file') ?></span>
                                        </label>
                                        <input class="add-file-input" type="file" name="files[]" id="addFileChat">

                                        <div class="mr-3 input-group">
                                            <input type="text" name="messageText" id="messageText" class="form-control"
                                                   placeholder="..." required>
                                        </div>

                                        <button type="submit"
                                                class="btn text-uppercase font-weight-bold btn-send-message">
                                            <span class="d-none d-md-inline"><?= Loc::getMessage('send') ?></span>
                                            <span class="d-inline d-md-none"><svg width="20" height="20"
                                                                                  viewBox="0 0 20 20" fill="none"
                                                                                  xmlns="http://www.w3.org/2000/svg">
                                        <path d="M19.5472 9.25614L1.23565 0.0880238C1.09213 0.0161514 0.930926 -0.0126464 0.77144 0.00509822C0.611954 0.0228428 0.46099 0.0863731 0.336726 0.188039C0.218054 0.287632 0.129478 0.418398 0.080955 0.565636C0.0324321 0.712873 0.0258861 0.870746 0.0620531 1.0215L2.26776 9.16446H11.6815V10.8314H2.26776L0.0287594 18.9493C-0.00517809 19.0752 -0.00913965 19.2074 0.0171934 19.3351C0.0435265 19.4628 0.0994195 19.5825 0.180378 19.6847C0.261336 19.7868 0.365101 19.8685 0.483329 19.9232C0.601557 19.9779 0.730949 20.004 0.861101 19.9995C0.991398 19.9987 1.11969 19.9673 1.23565 19.9078L19.5472 10.7397C19.6835 10.6698 19.7979 10.5635 19.8778 10.4326C19.9577 10.3017 20 10.1513 20 9.99792C20 9.84453 19.9577 9.69411 19.8778 9.56323C19.7979 9.43235 19.6835 9.32608 19.5472 9.25614Z"
                                              fill="#3FB465"/>
                                        </svg>
                                        </span>
                                        </button>
                                    </div>

                                    <div class="d-flex justify-content-end flex-wrap" id="chatUploadFileBox">

                                    </div>
                                </form>
                            </div>
                        <? } else { ?>
                            <div class="d-flex flex-column disableChat">
                                <p class="text-right text-secondary"> <? if ($blockedAuthor) { ?>
                                        <?= Loc::getMessage('Block1') ?>

                                        <?
                                    } ?>
                                    <? if ($blockedUser) { ?>
                                        <?= Loc::getMessage('Block11') ?>

                                        <?
                                    } ?> <?= $blockTime; ?></p>

                                <div class="mb-4 d-flex justify-content-center align-items-center">
                                    <label class="mr-3 mb-0 d-flex add-file-label" for="addFileChat" disabled>
                                                          <span class="mr-2"><svg width="15" height="19"
                                                                                  viewBox="0 0 15 19" fill="none"
                                                                                  xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 3.375V16.375C1 16.806 1.1712 17.2193 1.47595 17.524C1.7807 17.8288 2.19402 18 2.625 18H12.375C12.806 18 13.2193 17.8288 13.524 17.524C13.8288 17.2193 14 16.806 14 16.375V6.90288C14 6.68639 13.9567 6.4721 13.8727 6.27257C13.7887 6.07305 13.6657 5.89232 13.5109 5.741L9.90338 2.21312C9.59979 1.91628 9.19209 1.75005 8.7675 1.75H2.625C2.19402 1.75 1.7807 1.9212 1.47595 2.22595C1.1712 2.5307 1 2.94402 1 3.375V3.375Z"
                                              stroke="#3FB465" stroke-width="2" stroke-linecap="round"
                                              stroke-linejoin="round"/>
                                        <path d="M5.0625 10.6875H9.9375" stroke="#3FB465" stroke-width="2"
                                              stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M5.0625 13.9375H7.5" stroke="#3FB465" stroke-width="2"
                                              stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M9.125 1.75V5C9.125 5.43098 9.29621 5.8443 9.60095 6.14905C9.9057 6.4538 10.319 6.625 10.75 6.625H14"
                                              stroke="#3FB465" stroke-width="2" stroke-linejoin="round"/>
                                        </svg>
                                        </span>
                                        <span class="pt-1 d-none d-md-inline text-secondary text-nowrap"><?= Loc::getMessage('Add_file') ?></span>
                                    </label>
                                    <input class="add-file-input" type="file" name="files[]" id="addFileChat" disabled>

                                    <div class="mr-3 input-group">
                                        <input type="text" name="messageText" id="" class="form-control"
                                               placeholder="Write a message..." disabled>
                                    </div>

                                    <button type="button" class="btn text-uppercase font-weight-bold btn-send-message"
                                            disabled>
                                        <span class="d-none d-md-inline"><?= Loc::getMessage('send') ?></span>
                                        <span class="d-inline d-md-none"><svg width="20" height="20" viewBox="0 0 20 20"
                                                                              fill="none"
                                                                              xmlns="http://www.w3.org/2000/svg">
                                        <path d="M19.5472 9.25614L1.23565 0.0880238C1.09213 0.0161514 0.930926 -0.0126464 0.77144 0.00509822C0.611954 0.0228428 0.46099 0.0863731 0.336726 0.188039C0.218054 0.287632 0.129478 0.418398 0.080955 0.565636C0.0324321 0.712873 0.0258861 0.870746 0.0620531 1.0215L2.26776 9.16446H11.6815V10.8314H2.26776L0.0287594 18.9493C-0.00517809 19.0752 -0.00913965 19.2074 0.0171934 19.3351C0.0435265 19.4628 0.0994195 19.5825 0.180378 19.6847C0.261336 19.7868 0.365101 19.8685 0.483329 19.9232C0.601557 19.9779 0.730949 20.004 0.861101 19.9995C0.991398 19.9987 1.11969 19.9673 1.23565 19.9078L19.5472 10.7397C19.6835 10.6698 19.7979 10.5635 19.8778 10.4326C19.9577 10.3017 20 10.1513 20 9.99792C20 9.84453 19.9577 9.69411 19.8778 9.56323C19.7979 9.43235 19.6835 9.32608 19.5472 9.25614Z"
                                              fill="#3FB465"/>
                                        </svg>
                                        </span>
                                    </button>
                                </div>

                                <div class="d-flex flex-column align-items-end text-danger disableChat__message">
                                    <? if ($blockedAuthor) { ?>
                                        <p class="mb-2"><?= Loc::getMessage('Block1') ?></p>
                                        <p class="mb-0"><?= Loc::getMessage('Block2') ?></p>
                                        <?
                                    } ?>
                                    <? if ($blockedUser) { ?>
                                        <p class="mb-2"><?= Loc::getMessage('Block11') ?></p>
                                        <p class="mb-0"><?= Loc::getMessage('Block22') ?></p>
                                        <?
                                    } ?>
                                    <span class="icon"><svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                    <path d="M13.657 2.343C12.146 0.832 10.137 0 8 0C5.863 0 3.854 0.832 2.343 2.343C0.832 3.854 0 5.863 0 8C0 10.137 0.832 12.146 2.343 13.657C3.854 15.168 5.863 16 8 16C10.137 16 12.146 15.168 13.657 13.657C15.168 12.146 16 10.137 16 8C16 5.863 15.168 3.854 13.657 2.343ZM14 8C14.0013 9.24588 13.6129 10.461 12.889 11.475L4.525 3.111C5.53903 2.38714 6.75412 1.99866 8 2C11.308 2 14 4.692 14 8ZM2 8C1.99866 6.75412 2.38714 5.53903 3.111 4.525L11.475 12.889C10.461 13.6129 9.24588 14.0013 8 14C4.692 14 2 11.308 2 8Z"
                                          fill="#F34747"/>
                                    </svg>
                                    </span>
                                </div>
                            </div>
                            <?
                        } ?>
                    </div>
                    <!-- MAIN CHAT WINDOW -->

                </div>

                <? include $_SERVER['DOCUMENT_ROOT'] . '/personal/left.php' ?>
            </div>
        </div>

        <?
    }
    ?>

    <?
} else {
    ?>
    <div class="container">
        <div class="d-flex flex-column-reverse flex-lg-row justify-content-between">
            <div class="d-flex justify-content-end justify-content-lg-start">
                <button type="button" class="mb-4 btn btn-delete-all del_all_chats">
                    <i class="mr-2 icon-clear"></i>
                    <span class="btn-delete-all__text"><?= Loc::getMessage('delete_all'); ?></span>
                </button>
            </div>

            <h2 class="mb-4 subtitle">
                <?= $APPLICATION->ShowTitle(); ?>
            </h2>
        </div>
        <?
        $chats = getChatsUser($IDUser);
        ?>
        <div class="row">
            <div class="col-12 col-lg-9 block_chats">

                <? if (!$chats) {
                    ?>
                    <div class="mb-4 card d-flex flex-column flex-lg-row w-100 justify-content-around no-message">
                        <div class="mb-3 mb-0 d-flex flex-column align-items-center justify-content-center">
                            <p class="mb-4"><?= Loc::getMessage('no_message'); ?></p>
                            <img src="<?= SITE_TEMPLATE_PATH; ?>/assets/no-message.svg" alt="">
                        </div>
                    </div>
                <? } else {


                    foreach ($chats as $chat) {
                        //$block = blockMessageID($chat['ID_AD'], $chat['ID_AUTOR']);
                        $block = $chat['BLOCK'];

                        $secUserID = ($chat['ID_AUTOR'] == $IDUser) ? $chat['ID_SEC_USER'] : $chat['ID_AUTOR'];
                        $secondUser = getUserInfoByID($secUserID);
                        $adTitle = getTitleAD($chat['ID_AD']);
                        $adPreviewPicture = getPreviewPictAD($chat['ID_AD']);
                        foreach ($chats as $message) {
                            if ($message['UF_BLOCK_AUTOR'] && $message['UF_AUTOR_ID'] == $IDUser) {
                                $blockedAuthor = true;
                                $blocked = true;
                                if ($message['UF_DATE_BLOCK'])
                                    $blockTime = $message['UF_DATE_BLOCK']->format("d.m.Y");
                                break;
                            }
                            if ($message['UF_BLOCK_USER'] && $message['UF_ID_USER'] == $IDUser) {
                                $blockedUser = true;
                                $blocked = true;
                                if ($message['UF_DATE_BLOCK'])
                                    $blockTime = $message['UF_DATE_BLOCK']->format("d.m.Y");
                                break;
                            }
                        }
                        ?>
                        <div class="mb-4 p-3 card user-message-card<?= ($block) ? ' user-blocked' : ''; ?>"<?= ($chat['COUNT_UNREAD'] ? ' style="background-color: #D9E6E4;"' : ''); ?>>
                            <div class="row">
                                <div class="col text-right">
                                    <div class="d-flex justify-content-lg-end message-from">
                                        <div class="w-100 pr-3 pr-lg-0 d-flex flex-column">
                                            <p class="user-message-card__name"><?= $secondUser['LAST_NAME'] . ' ' . $secondUser['NAME'] ?></p>
                                            <a href="?id=<?= $chat['ID_AD']; ?>&au=<?= $secUserID; ?>&ref=<?= md5($secUserID . SALT_ID_CHAT . $chat['ID_AD']) ?>"
                                               class="mb-3 user-message-card__title"><?= $adTitle; ?></a>
                                        </div>
                                    </div>
                                    <?
                                    if ($chat['FILES']) {
                                        ?>
                                        <div class="d-flex flex-column flex-lg-row justify-content-end message-file-box">
                                            <?
                                            foreach ($chat['FILES'] as $file) {
                                                $dataFile = CFile::GetFileArray($file);
                                                ?>

                                                <a href="<?= $dataFile['SRC']; ?>" target="_blank"
                                                   class="mb-3 mb-lg-0 mr-0 mr-lg-4 mb-0 text-primary">
                                                                <span class="file-icon mr-2"><svg width="12" height="10"
                                                                                                  viewBox="0 0 12 10"
                                                                                                  fill="none"
                                                                                                  xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M7.50189 7.31659H6.50948V4.0715C6.50948 4.01257 6.46127 3.96436 6.40234 3.96436H5.59877C5.53984 3.96436 5.49162 4.01257 5.49162 4.0715V7.31659H4.50189C4.41216 7.31659 4.36261 7.41971 4.41752 7.48936L5.91752 9.38712C5.92754 9.39993 5.94034 9.41029 5.95496 9.41741C5.96958 9.42453 5.98563 9.42823 6.00189 9.42823C6.01815 9.42823 6.0342 9.42453 6.04882 9.41741C6.06344 9.41029 6.07624 9.39993 6.08627 9.38712L7.58627 7.48936C7.64118 7.41971 7.59162 7.31659 7.50189 7.31659Z"
                                                          fill="black"/>
                                                    <path d="M10.0098 2.7683C9.39643 1.15045 7.83348 0 6.00268 0C4.17188 0 2.60893 1.14911 1.99554 2.76696C0.847768 3.0683 0 4.11429 0 5.35714C0 6.83705 1.19866 8.03571 2.67723 8.03571H3.21429C3.27321 8.03571 3.32143 7.9875 3.32143 7.92857V7.125C3.32143 7.06607 3.27321 7.01786 3.21429 7.01786H2.67723C2.22589 7.01786 1.80134 6.83839 1.48527 6.51295C1.17054 6.18884 1.00312 5.75223 1.01786 5.29955C1.02991 4.94598 1.15045 4.61384 1.36875 4.33393C1.59241 4.04866 1.9058 3.84107 2.25402 3.74866L2.76161 3.61607L2.94777 3.12589C3.06295 2.82054 3.22366 2.53527 3.42589 2.27679C3.62554 2.02059 3.86204 1.79538 4.12768 1.60848C4.67813 1.22143 5.32634 1.01652 6.00268 1.01652C6.67902 1.01652 7.32723 1.22143 7.87768 1.60848C8.1442 1.79598 8.37991 2.02098 8.57946 2.27679C8.7817 2.53527 8.94241 2.82187 9.05759 3.12589L9.24241 3.61473L9.74866 3.74866C10.4746 3.9442 10.9821 4.60446 10.9821 5.35714C10.9821 5.80045 10.8094 6.2183 10.496 6.5317C10.3423 6.68629 10.1595 6.80885 9.95808 6.8923C9.75669 6.97576 9.54076 7.01843 9.32277 7.01786H8.78571C8.72679 7.01786 8.67857 7.06607 8.67857 7.125V7.92857C8.67857 7.9875 8.72679 8.03571 8.78571 8.03571H9.32277C10.8013 8.03571 12 6.83705 12 5.35714C12 4.11562 11.1549 3.07098 10.0098 2.7683Z"
                                                          fill="black"/>
                                                    </svg>
                                                    </span>
                                                    <span class="file-name"><?= $dataFile['ORIGINAL_NAME']; ?></span>
                                                </a>
                                                <?
                                            }
                                            ?>
                                        </div>
                                        <?
                                    }
                                    ?>

                                    <p class="pt-3 user-message-card__text">
                                        <a href="?id=<?= $chat['ID_AD']; ?>&au=<?= $secUserID; ?>&ref=<?= md5($secUserID . SALT_ID_CHAT . $chat['ID_AD']) ?>">
                                            <?= $chat['MESSAGE']; ?>
                                        </a>
                                    </p>

                                    <div class="border-top pt-3 d-flex justify-content-between">
                                        <span class="deleteChatPopup" data-ad="<?= $chat['ID_AD']; ?>"
                                              data-au="<?= $secUserID; ?>" type="button">
                                          <span class="font-weight-bolder"><?= Loc::getMessage('delete'); ?></span>
                                          <i class="icon-clear"></i>
                                        </span>

                                        <?
                                        $strDate = getStringDate(date('d.m.Y H:i:s', $chat['DATE']));
                                        ?>
                                        <span><?= ($strDate['MES']) ? Loc::getMessage($strDate['MES']) . ', ' . $strDate['HOURS'] : $strDate['HOURS']; ?></span>
                                    </div>
                                </div>

                                <div class="col-4 col-md-3 col-xl-2 d-flex justify-content-center">
                                    <div class="d-block position-relative">
                                        <div class="user-message-card__image">
                                            <a href="<?= getDetailAD((int)$chat['ID_AD']) ?>">
                                                <img src="<?= $adPreviewPicture; ?>" alt="">
                                            </a>
                                        </div>

                                        <? if ($chat['COUNT_UNREAD']) {
                                            ?>
                                            <div class="d-inline-block user-message-card__counter counter-user-message">
                                                <span><?= ($chat['COUNT_UNREAD'] > 99) ? '99+' : $chat['COUNT_UNREAD']; ?></span>
                                            </div>
                                            <?
                                        } ?>
                                    </div>
                                    <? if ($block) {
                                        ?>
                                        <div class="danger-mesage">
                                                      <span><svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                                                 xmlns="http://www.w3.org/2000/svg">
                                            <path d="M13.657 2.343C12.146 0.832 10.137 0 8 0C5.863 0 3.854 0.832 2.343 2.343C0.832 3.854 0 5.863 0 8C0 10.137 0.832 12.146 2.343 13.657C3.854 15.168 5.863 16 8 16C10.137 16 12.146 15.168 13.657 13.657C15.168 12.146 16 10.137 16 8C16 5.863 15.168 3.854 13.657 2.343ZM14 8C14.0013 9.24588 13.6129 10.461 12.889 11.475L4.525 3.111C5.53903 2.38714 6.75412 1.99866 8 2C11.308 2 14 4.692 14 8ZM2 8C1.99866 6.75412 2.38714 5.53903 3.111 4.525L11.475 12.889C10.461 13.6129 9.24588 14.0013 8 14C4.692 14 2 11.308 2 8Z"
                                                  fill="#F34747"/>
                                            </svg>
                                            </span>

                                            <? if ($blockedAuthor) { ?>
                                                <p class="mb-0 text-danger"><?= Loc::getMessage('Block1') ?></p>
                                                <?
                                            } ?>
                                            <? if ($blockedUser) { ?>
                                                <p class="mb-0 text-danger"><?= Loc::getMessage('Block11') ?></p>
                                                <?
                                            } ?>
                                        </div>
                                        <?
                                    } ?>
                                </div>
                            </div>
                        </div>
                        <?
                    }
                } ?>
            </div>
            <? include $_SERVER['DOCUMENT_ROOT'] . '/personal/left.php' ?>
        </div>
    </div>
    <?
}
?>

    <div class="allert alert-confirmation flex-column card">
        <button type="button" class="close" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <div class="d-flex justify-content-center allert__text"></div>
        <div class="d-flex justify-content-center mt-4">
            <button class="btn_confirm btn border-primary text-uppercase font-weight-bold text-primary py-3 px-5"
                    data-pr1="" data-pr2=""><?= Loc::getMessage('delete'); ?></button>
        </div>
    </div>

    <script>
        class FileUploader {
            fileList = null

            template = ''

            templateOptions = {
                name: 'name',
            }

            constructor(renderContainerId, fileListId, template) {

                const self = this
                this.renderContainerId = renderContainerId
                this.fileListId = fileListId
                this.template = template

                $(fileListId).on('change', (e) => {
                    this.addFiles(e.target.files)

                    e.target.value = ''
                })

                $(document).on('click', '[data-file-remove-id]', function () {
                    self.removeFile($(this).data('fileRemoveId'));
                })
                $(document).on('click', '.close', function () {
                    self.removeFile($(this).data('fileRemoveId'));
                })

            }

            readFileAsync = (file) => {
                return new Promise((resolve, reject) => {
                    let reader = new FileReader();

                    reader.onload = () => {
                        resolve(reader.result);
                    };

                    reader.onerror = reject;

                    reader.readAsDataURL(file);
                })
            }

            updateOutputInput = () => {
                const $fileListInput = $(this.fileListId)

                if ($fileListInput && this.fileList) {
                    $fileListInput[0].files = this.fileList;
                }
            }

            addFiles = (files) => {
                const newFilesArr = Array.from(files)
                const allFiles = [...Array.from(this.fileList || []), ...newFilesArr]

                this.fileList = allFiles.reduce((dt, file) => {
                    dt.items.add(file)

                    return dt;
                }, new DataTransfer()).files;

                newFilesArr.forEach(async (file) => {
                    const dataUrl = await this.readFileAsync(file);

                    const filledTemplate = Object.entries(this.templateOptions).reduce((tmp, [key, value]) => {
                        const output = tmp.replaceAll(`{{${key}}}`, file[value])

                        return output
                    }, this.template.replace('{{dataUrl}}', dataUrl))

                    $(this.renderContainerId).prepend(filledTemplate)
                })

                this.updateOutputInput()
            }

            removeFile = (fileId) => {
                const dt = new DataTransfer()
                // const filteredFiles = Array.from(this.fileList).filter((file) => file.name !== fileId)
                // filteredFiles.forEach((file) => dt.items.add(file))

                // this.fileList = dt.files

                // this.updateOutputInput()

                $(`[data-file-id="${fileId}"]`).remove()
            }

        }

        new FileUploader(
            // container where will images rendered (prepend method useing)
            '#chatUploadFileBox',
            // single input file element, all files will be merged there
            '#addFileChat',
            // render image templte
            // {{example}} - placeholders for templateOptions render (dataUrl at lest required)
            // data-file-id - container
            // data-file-remove-id - data for remove btn (whould has the same as container value)
            // .rotate-control button to rotate image
            // .rotate-img - element for rotating
            `<div class="ml-3 d-flex align-items-center justify-content-center upload-file" data-file-id="{{name}}" data-file-remove-id="{{name}}">
                                        <button type="button" class="mr-2 close" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <span class="upload-file__name" data-src='{{dataUrl}}'>{{name}}</span>
                                    </div>`,
        );

        function submitForm(event) {
            event.preventDefault();
            var $data = {};
            $('#send_lk_mess').find('input').each(function () {
                var object = {}
                object.val = $(this).val();
                object.data = $(this).data();
                $data[this.id] = object;
            });
            var a = 0;
            var $imgobject = {};
            var $imgobject_name = {};
            $('#send_lk_mess').find('.upload-file__name').each(function () {
                // console.log($(this));
                $imgobject[a] = $(this).data('src');
                $imgobject_name[a] = $(this).text();
                a++;
            });
            $data['img'] = $imgobject;
            $data['img_name'] = $imgobject_name;
            //$data['img-base64'] = $('.upload-file__name').data('src');

            var deferred = $.ajax({
                type: "POST",
                url: "/ajax/send_lk_mess.php",
                data: $data,
                dataType: 'json'
            });
            deferred.done(function (data) {
                window.location.reload();
            });
        }

        setInterval(function () {
            $.ajax({
                url: window.location.href,
                type: 'GET',
                success: function (data) {
                    $('.chat__message-window').html($(data).find('.chat__message-window').html()); // обновляем содержимое страницы
                }
            });
        }, 10000); // интервал в миллисекундах (30 секунд = 30000 миллисекунд)
    </script>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>