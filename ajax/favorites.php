<?if(!$_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') die();
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
if($USER->IsAuthorized()) {
    if (isset($_POST) && !empty($_POST)) {

        $res = array();
        global $USER;
        $IDUser = $USER->GetID();


        if ($_POST['del'] == 'N' && (int)$_POST['id'] > 0) {
           
            $arrData = array(
                'UF_ID_AD' => (int)$_POST['id'],
                'UF_ID_USER' => $IDUser
            );
            addHLItem(5, $arrData);
            $res['OK'] = 'Y';

        } elseif ($_POST['del'] == 'Y') {
            
            // Находим ID записи для удаления
            $IDDel = getHighloadInfo(5, array(
                    'select' => array('*'),
                    'filter' => array(
                        'UF_ID_AD' => (int)$_POST['id'],
                        'UF_ID_USER' => $IDUser
                    )
                )
            )[0];
            if ($IDDel['ID']) {
                delHlItem(5, $IDDel['ID']);
                $res['OK'] = 'Y';
            }

        }


        header('Content-type: application/json; charset=utf-8');
        print json_encode($res);
    }
}else{
    $res['success'] = 0;
    header('Content-type: application/json; charset=utf-8');
    print json_encode($res);
}
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>