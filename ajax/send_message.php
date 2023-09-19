<?
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
if(isset($_POST) && !empty($_POST)) {

    global $USER;
    $files_type = array(
        'image/jpeg' => '.jpeg',
        'image/png' => '.png',
        'text/plain' => '.txt',
        'application/msword' => '.doc',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => '.docx',
        'application/pdf' => '.pdf',
        'application/rtf' => '.rtf',
        'image/bmp' => '.bmp',
        'application/vnd.ms-excel' => '.xls',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => '.xlsx',
    );

    foreach ($_POST['files'] as $k => $item) {
        $type_f = explode(':', explode(';', $item)[0])[1];

        $data = base64_decode(preg_replace('#^data:'.$type_f.';base64,#i', '', $item));

        $rand = randString(10) . $files_type[$type_f];
        $log = date('Y-m-d H:i:s') . $type_f;
        file_put_contents(__DIR__ . '/logSend_message.txt', $log . PHP_EOL, FILE_APPEND);
        file_put_contents(__DIR__ . '/logSend_message.txt', $rand . PHP_EOL, FILE_APPEND);

        file_put_contents($_SERVER["DOCUMENT_ROOT"] . '/upload/chat/' . $rand, $data);

        $arFile[] = CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"] . '/upload/chat/' . $rand);

    }
    $error = array();
    $IDMess = 0;

    $IDUser = $USER->GetID();
    $IDAd = (int)$_POST['idAd'];

    if($IDAd)
        $IDAutor = getIDAutorAd($_POST['idAd']);

    $message = ($_POST['messageContent'])?: ' ';
    $files = $arFile;

    if($IDUser && $IDAd && $IDAutor && $message)
    {
        $IDMess = addMessage($IDUser, $IDAutor, $IDAd, $message, $files);
    }

    if(!$IDMess)
    {
        $error['TYPE'] = 'ERROR';
        $error['MESSAGE'] = 'ERROR';
    }
    else
        $error['TYPE'] = 'OK';

    header('Content-type: application/json; charset=utf-8');
    print json_encode($error);
}
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>