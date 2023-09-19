<?if(!$_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') die();
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

if(isset($_POST) && isset($_POST['ad']) && isset($_POST['au'])) {

    global $USER;
    $error = array();

    $IDUser = $USER->GetID();
    $IDAd = (int)$_POST['ad'];
    $IDAu = (int)$_POST['au'];

    if($IDAd && $IDAu)
    {
        $block = blockMessageID($IDAd, $IDUser)[0];

        if($block['ID'])
        {
            // Разблокируем
            if($block['UF_AUTOR_ID'] == $IDUser)
            {
                UpdateHlItem(7, $block['ID'], array('UF_BLOCK_AUTOR' => 0, 'UF_DATE_BLOCK' => ''));
                $error['TYPE'] = 'RESET';
            }
            elseif($block['UF_ID_USER'] == $IDUser)
            {
                UpdateHlItem(7, $block['ID'], array('UF_BLOCK_USER' => 0, 'UF_DATE_BLOCK' => ''));
                $error['TYPE'] = 'RESET';
            }
        }
        else
        {
            $messages = getMessagesChat($IDAd, $IDUser, $IDAu);
            $id = 0;

            $count = count($messages);
            if($count)
            {
                $tr = $count - 1;
                $id = $messages[$tr]['ID'];
            }

            if($id)
            {
                if($messages[$tr]['UF_AUTOR_ID'] == $IDUser)
                {
                    UpdateHlItem(7, $id, array('UF_BLOCK_AUTOR' => 1, 'UF_DATE_BLOCK' => date('d.m.Y H:i:s')));
                    $error['TYPE'] = 'OK';
                }
                elseif($messages[$tr]['UF_ID_USER'] == $IDUser)
                {
                    UpdateHlItem(7, $id, array('UF_BLOCK_USER' => 1, 'UF_DATE_BLOCK' => date('d.m.Y H:i:s')));
                    $error['TYPE'] = 'OK';
                }

            }
        }



    }

    header('Content-type: application/json; charset=utf-8');
    print json_encode($error);
}
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>