<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);
$APPLICATION->SetTitle("Персональные данные");
?>
<?php
// Смена email
if($_GET['update_email'] && $_GET['update_email'] == 'Y')
{
    global $USER;
    if($_GET['email'] && $_GET['str'] == md5('54h7ghrt'.$USER->GetID().$_GET['email']))
    {
        $user = new CUser;
        $fields = Array(
            "EMAIL"             => $_GET['email'],
            "LOGIN"             => $_GET['email'],
        );
        $check = $user->Update($USER->GetID(), $fields);

        if($check)
            LocalRedirect('/personal/edit/');
    }
}

// Данные пользователя
$user = getUserInfoByID();

if(!$user) LocalRedirect('/');


?>

<div class="container">
    <h2 class="mb-4 subtitle">
        <?=$APPLICATION->ShowTitle();?>
    </h2>

    <div class="row">
        <div class="col-12 col-lg-8 col-xl-9">
            <form class="card change-personal-data" id="update_user">
                <?=bitrix_sessid_post()?>
                <div class="d-flex flex-column flex-xl-row-reverse align-items-end form-group">
                    <label for="userPhone"><?=Loc::getMessage('phone');?></label>
                    <input type="tel" class="form-control" id="userPhone" value="<?=$user['PERSONAL_PHONE'];?>" name="userPhone" placeholder="<?=Loc::getMessage('phone');?>">
                </div>

                <div class="d-flex flex-column flex-xl-row-reverse align-items-end form-group">
                    <label for="userEmail">Email</label>
                    <input type="email" class="form-control" id="userEmail" value="<?=$user['EMAIL'];?>" name="userEmail" aria-describedby="emailHelp" placeholder="email">
                </div>

                <div class="d-flex flex-column flex-xl-row-reverse align-items-end form-group">
                    <label for="userName"><?=Loc::getMessage('name');?></label>
                    <input type="text" class="form-control" id="userName" value="<?=$user['NAME'];?>" name="userName" placeholder="<?=Loc::getMessage('name');?>">
                </div>

                <div class="d-flex flex-column flex-xl-row-reverse align-items-end form-group">
                    <?php
                    if(!$user['PERSONAL_PHONE'])
                        $er_mess = 'Для размещения объявлений, необходимо заполнить номер телефона';
                    ?>
                    <span class="error_auth_mess"><?=$er_mess;?></span>
                </div>

                <button id="fdge45" type="submit" class="btn btn-primary"><?=Loc::getMessage('UPDATE');?></button>
            </form>
        </div>
        <script>
            $('#fdge45').click(function () {

            })
        </script>
        <div class="allert alert-confirmation flex-column card">
            <button onclick="window.location.reload();" type="button" class="close" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="d-flex justify-content-center allert__text"></div>
            <div class="d-flex justify-content-center mt-4">
                <button onclick="window.location.reload();" class="btn_confirm btn border-primary text-uppercase font-weight-bold text-primary py-3 px-5">
                    <?=Loc::getMessage('ok')?>
                </button>
            </div>
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
        $(document).on("submit", "#update_user", function (e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "/ajax/update_user.php",
                data: $(this).serialize(),
                success: function (msg) {
                    if (msg['TYPE'] == "ERROR") {
                        $('span.error_auth_mess').empty().append(msg['MESSAGE']);
                        $('.allert__text').html('השינויים התבצעו בהצלחה  </br>' + msg['MESSAGE']);

                        $('.del_all_in_chat').html('ok');
                        $('.alert-confirmation').addClass('show');
                    } else {
                        $('.alert-confirmation').addClass('show');
                    }
                }
            });
        });

        $('button.btn_confirm').click(() => {
            $('.alert-confirmation').removeClass('show');
        });
    });
</script>
    <div class="allert alert-confirmation flex-column card">
        <button type="button" class="close" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        <div class="d-flex justify-content-center allert__text">Данные успешно обновлены!</div>
        <div class="d-flex justify-content-center mt-4">
            <button class="btn_confirm btn border-primary text-uppercase font-weight-bold text-primary py-3 px-5">Ok</button>
        </div>
    </div>
<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>