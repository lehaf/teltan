<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);
$APPLICATION->SetTitle("Изменение пароля");
?>
<?php
// Данные пользователя
$user = getUserInfoByID();

if(!$user)
    LocalRedirect('/');
?>
<div class="container">
    <h2 class="mb-4 subtitle">
        <?=$APPLICATION->ShowTitle();?>
    </h2>
    <div class="row full-height">
        <div class="col-12 col-lg-8 col-xl-9">
            <form class="card change-personal-data" id="change_pass">
                <?=bitrix_sessid_post()?>
                <div class="d-flex flex-column flex-xl-row-reverse align-items-end form-group">
                    <label for="userPhone"> <?=Loc::getMessage('CURRENT_PASS');?></label>
                    <input type="password" class="form-control" id="old_pass" value="" name="old_pass" placeholder="<?=Loc::getMessage('CURRENT_PASS');?>" style="margin-right:165px;">
                </div>

                <div class="d-flex flex-column flex-xl-row-reverse align-items-end form-group">
                    <label for="userEmail"><?=Loc::getMessage('NEW_PASS');?></label>
                    <input type="password" class="form-control" id="new_pass" value="" name="new_pass" aria-describedby="emailHelp" placeholder="<?=Loc::getMessage('NEW_PASS');?>" style="margin-right:165px;">
                </div>

                <div class="d-flex flex-column flex-xl-row-reverse align-items-end form-group">
                    <label for="userName"><?=Loc::getMessage('CHECK_PASS');?></label>
                    <input type="password" class="form-control" id="confirm_pass" value="" name="confirm_pass" placeholder="<?=Loc::getMessage('CHECK_PASS');?>" style="margin-right:165px;">
                </div>
                <span class="error_auth_mess"></span>
                <button type="submit" id="updatePasswordSendButton" class="btn btn-primary"><?=Loc::getMessage('UPDATE');?></button>
            </form>
        </div>
        <?php $APPLICATION->IncludeComponent(
            "bitrix:menu",
            "personal",
            array(
                "ALLOW_MULTI_SELECT" => "N",
                "CHILD_MENU_TYPE" => "",
                "DELAY" => "N",
                "MAX_LEVEL" => "1",
                "MENU_CACHE_GET_VARS" => array(""),
                "MENU_CACHE_TIME" => "360000",
                "MENU_CACHE_TYPE" => "A",
                "MENU_CACHE_USE_GROUPS" => "N",
                "ROOT_MENU_TYPE" => "personal",
                "USE_EXT" => "N"
            )
        ); ?>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        $(document).on("submit", "#change_pass", function (e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "/ajax/change_password.php",
                data: $(this).serialize(),
                success: function (msg) {
                    if (msg['TYPE'] == "ERROR") {
                        $('.pop-up').addClass('active');
                        $('.pop-up__text').html(msg['MESSAGE']);
                        $('span.error_auth_mess').empty().append(msg['MESSAGE']);
                    }
                    if (msg['TYPE'] == "OK") {
                        $('.pop-up').addClass('active');
                        $('.pop-up__text').html('שינוי הסיסמה יתבצע בהצלחה');
                    }

                }
            });
        });
    });
</script>
<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>