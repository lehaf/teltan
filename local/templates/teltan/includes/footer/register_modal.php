<?
use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);
?>
<div class="modal fade modal-registration" id="registerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <button type="button" class="m-0 mr-auto close close-modal" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="modal-body">
                <h3 class="subtitle" id="exampleModalLabel">
                    <?=Loc::getMessage('reg');?>

                </h3>

                <div class="mb-4 d-flex flex-column">
                    <a onclick="BX.util.popup('https://accounts.google.com/o/oauth2/auth?client_id=566605738181-9fjhntgtnes18vnj736gsk86g4bco97s.apps.googleusercontent.com&redirect_uri=http%3A%2F%2F650739-cm41399.tmweb.ru%2Fbitrix%2Ftools%2Foauth%2Fgoogle.php&scope=https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.email+https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.profile&response_type=code&access_type=offline&state=provider%3DGoogleOAuth%26site_id%3Ds1%26backurl%3D%252Fnovaya-stranitsa.php%253Fcheck_key%253Dd33589726ca42b6aaea241915b1f12e0%2526clear_cache%253DY%26mode%3Dopener%26redirect_url%3D%252Fnovaya-stranitsa.php%253Fclear_cache%253DY', 580, 400)" class="mb-3 py-3 btn btn-white border-secondary">
                        <span class="mr-4"><?=Loc::getMessage('google');?></span>
                        <img src="<?=SITE_TEMPLATE_PATH;?>/assets/icon-google.svg" class="icon-google">
                    </a>

                    <button type="button" class="py-3 btn btn-white border-secondary">
                        <span class="mr-4"><?=Loc::getMessage('Facebook');?></span>
                        <img src="<?=SITE_TEMPLATE_PATH;?>/assets/icon-facebook.svg" class="icon-facebook">
                    </button>
                </div>

                <h3 class="subtitle">
                    <?=Loc::getMessage('manually');?>
                </h3>

                <form id="register">
                    <div class="form-group">
                        <input id="registerPhone" type="tel" class="form-control" placeholder="<?=Loc::getMessage('number');?>" name="phone" aria-describedby="userPhoneNumber" required>
                        <small id="telHelp" class="form-text text-muted text-right"><?=Loc::getMessage('sent to this phone number');?></small>
                    </div>

                    <div class="form-group">
                        <input type="email" class="form-control mb-3" name="userEmail" placeholder="E-mail" id="" aria-describedby="userEmail" required>

                        <input type="text" class="form-control" placeholder="<?=Loc::getMessage('name');?>" name="name" id="">
                    </div>


                    <div class="form-group">
                        <input type="password" class="form-control mb-3" placeholder="<?=Loc::getMessage('password');?>" name="userPasword" id="userPasword" required>
                        <input type="password" class="form-control" placeholder="<?=Loc::getMessage('repeat_password');?>" name="confirmUserPassword" id="confirmUserPassword">
                    </div>

                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary text-uppercase btn-sand-register-form"><?=Loc::getMessage('create');?></button>
                    </div>
                    <span class="error_auth_mess"></span>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
   // $("#registerPhone").mask("0(999) 999-999");
</script>