<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);
$APPLICATION->SetTitle("Персональные данные");
?>
<?
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

if(!$user)
    LocalRedirect('/');


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
                        <?
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
                        <?include $_SERVER['DOCUMENT_ROOT'].'/personal/left.php'?>

        </div>
    </div>
</main>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>