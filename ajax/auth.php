<?if(!$_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') die();
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

if(isset($_POST) && !empty($_POST)) {

    global $USER;

    $error = array();

    $user_login = $_POST['userEmail'];
    $user_password = $_POST['userPasword'];

    if(isset($_POST['rememberUser']) && $_POST['rememberUser'] == "Y"){
        $user_remember = "Y";
    } else {
        $user_remember = "N";
    }

    $error = $USER->Login($user_login, $user_password, $user_remember);


    echo json_encode($error);
}
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>