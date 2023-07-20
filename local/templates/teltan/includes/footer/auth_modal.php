<?
use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);
?>
<div class="modal fade modal-log-in" id="logInModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <button type="button" class="m-0 mr-auto close close-modal" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="modal-body">
                <h3 class="subtitle">
                    <?=Loc::getMessage('LOG_INTO');?>

                </h3>

                <form method="post" id="signInUser" class="form-sign-in">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="E-mail" id="userEmail" name="userEmail" required>
                    </div>

                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="<?=Loc::getMessage('PASSWORD');?>" id="userPasword" name="userPasword" required>
                    </div>

                    <div class="mb-4 d-flex justify-content-between">
                        <a href="/forgot_pass/" class="text-primary">
                            <?=Loc::getMessage('FORGOT_PASS');?>

                        </a>

                        <div class="d-flex align-items-center remeber-me">
                            <span class="pr-3"><?=Loc::getMessage('REMEMBER');?></span>
                            <input class="d-none" id="rememberUserData" type="checkbox" name="rememberUser" value="Y">
                            <label class="remeber-me__label" for="rememberUserData"></label>
                        </div>
                    </div>

                    <div class="d-flex flex-column align-items-center">
                        <span id="errorLogInMessContainer" class="error_auth_mess"></span>
                        <button id="loginButton" type="submit" class="mb-4 btn btn-primary text-uppercase btn-sign-in"><?=Loc::getMessage('SIGN_IN');?></button>
                        <a href="#" data-toggle="modal" data-target="#registerModal" class="text-primary text-center"><?=Loc::getMessage('DONT_HAVE_ACC');?></a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).on("submit", "#signInUser", function(e){
        e.preventDefault();
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "/ajax/auth.php",
            data: $(this).serialize(),
            success: function(msg){
                if(msg.TYPE == "ERROR"){
                    $('#errorLogInMessContainer').text('Wrong login or password.');

                }else {
window.location.reload();
                }
            }
        });


    });
</script>