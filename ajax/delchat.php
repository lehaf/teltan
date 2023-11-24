<?php if(!$_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') die();
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$error = ['TYPE' => 'ERROR'];
if (!empty($_POST) && !empty($_POST['adId']) && !empty($_POST['recipientId'])) {
    $userId = \Bitrix\Main\Engine\CurrentUser::get()->getId();
    $adId = (int)$_POST['adId'];
    $recipientId = (int)$_POST['recipientId'];

    if (\Bitrix\Main\Loader::includeModule("highloadblock") && defined('USERS_CHAT_MESSAGES_HL_ID')) {
        $hlblock = \Bitrix\Highloadblock\HighloadBlockTable::getById(USERS_CHAT_MESSAGES_HL_ID)->fetch();
        $entityClass = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock)->getDataClass();
        $messages = $entityClass::getList([
            'select' => array(
                'ID',
                'UF_AUTOR_ID',
                'UF_ID_USER',
                'UF_DEL_AUTOR',
                'UF_DEL_USER'
            ),
            'filter' => array(
                'LOGIC' => 'OR',
                array('UF_AUTOR_ID' => $userId, 'UF_ID_AD' => $adId, 'UF_ID_USER' => $recipientId),
                array('UF_AUTOR_ID' => $recipientId, 'UF_ID_AD' => $adId, 'UF_ID_USER' => $userId),
            ),
        ])->fetchCollection();

        foreach ($messages as $mess) {
            if ($mess->getUfAutorId() == $userId) {
                $mess->setUfDelAutor(true);
            } else {
                if ($mess->getUfIdUser() == $userId) {
                    $mess->setUfDelUser(true);
                }
            }
        }

        $res = $messages->save();
        if ($res->isSuccess()) $error['TYPE'] = 'OK';
    }
}

header('Content-type: application/json; charset=utf-8');
echo json_encode($error);

