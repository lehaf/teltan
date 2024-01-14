<?php
if ($_SERVER['HTTP_X_REQUESTED_WITH'] !== 'XMLHttpRequest') die();
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

if ($userId = \Bitrix\Main\Engine\CurrentUser::get()->getId()) {
    if (!empty($_POST['id']) && !empty($_POST['del'])) {
        $res = array();
        if ($_POST['del'] === 'N' && (int)$_POST['id'] > 0) {
            $dataToAdd = array(
                'UF_ID_AD' => (int)$_POST['id'],
                'UF_ID_USER' => $userId
            );
            addHLItem(PERSONAL_FAVORITE_HL_ID, $dataToAdd);
            $res['OK'] = 'Y';

        } elseif ($_POST['del'] == 'Y') {
            // Находим ID записи для удаления
            $idToDel = getHLData(
                PERSONAL_FAVORITE_HL_ID,
                ['*'],
                ['UF_ID_AD' => (int)$_POST['id'],'UF_ID_USER' => $userId]
            )[0]['ID'];

            if (!empty($idToDel)) {
                delHlItem(PERSONAL_FAVORITE_HL_ID, $idToDel);
                $res['OK'] = 'Y';
            }
        }

        if (isset($res['OK'])) {
            // чистим кэш
            $taggedCache = \Bitrix\Main\Application::getInstance()->getTaggedCache();
            $taggedCache->clearByTag('favorite_user_'.$userId);
        }

        header('Content-type: application/json; charset=utf-8');
        echo json_encode($res);
    }
}else{
    $res['success'] = 0;
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($res);
}
