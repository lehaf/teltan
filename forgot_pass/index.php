<?
//define("NEED_AUTH", true);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Восстановление пароля");
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);
?>

    <div class="container">
        <h2 class="mb-4 subtitle"><?=$APPLICATION->ShowTitle();?></h2>


        <div class="change-pass card py-5 px-4">
            <p class="text-right">
                <?$APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    "",
                    Array(
                        "AREA_FILE_SHOW" => "file",
                        "AREA_FILE_SUFFIX" => "inc",
                        "EDIT_TEMPLATE" => "",
                        "PATH" => SITE_TEMPLATE_PATH."/includes/".SITE_ID."/forgot_pass_text.php"
                    )
                );?>
            </p>
            <?
            $APPLICATION->IncludeComponent(
                "bitrix:main.auth.forgotpasswd",
                "forgot_pass",
                Array(
                    "AUTH_AUTH_URL" => "",
                    "AUTH_REGISTER_URL" => ""
                )
            );
            ?>
        </div>
    </div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>