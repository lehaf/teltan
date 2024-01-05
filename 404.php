<?php include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
CHTTP::SetStatus("404 Not Found");
@define("ERROR_404","Y");
$APPLICATION->SetTitle('לא נמצא');
?>
<h1 style="padding-left: 450px;padding-bottom: 200px;padding-top: 100px;">404 לא נמצא</h1>
<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");

