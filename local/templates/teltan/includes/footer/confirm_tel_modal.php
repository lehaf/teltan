<?
use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);
?>
<div class="modal fade modal-confirm-code" id="confirmCode" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <h3 class="subtitle" id="exampleModalLabel">
                    <?=Loc::getMessage('mess');?>
                </h3>

                <p class="modal-confirm-code__text text-right"> <?=Loc::getMessage('we');?></p>

                <form class="form-confirm-code" id="confirmCodeForm">
                    <div class="form-group code-group">
                        <input type="hidden" name="type_confirm" value="">
                        <input type="hidden" name="id_user" value="">
                        <input class="form-control code-group__data" name="codeplace1" maxlength="1" type="text" placeholder="X" id="codeplace1" required>
                        <input class="form-control code-group__data" name="codeplace2" maxlength="1" type="text" placeholder="X" id="codeplace2" required>
                        <input class="form-control code-group__data" name="codeplace3" maxlength="1" type="text" placeholder="X" id="codeplace3" required>
                        <input class="form-control code-group__data" name="codeplace4" maxlength="1" type="text" placeholder="X" id="codeplace4" required>
                    </div>
                </form>

                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                    <div class="mb-4 mb-md-0 d-flex justify-content-between w-100 align-items-center">
                        <a href="#" id="sendagainregister" class="text-primary btn-refresh"><i class="icon-replay"></i> <?=Loc::getMessage('new');?></a>
                        <button type="button" class="btn btn-transparent btn-close" data-dismiss="modal"> <?=Loc::getMessage('close');?></button>
                    </div>
                    <span class="error"></span>
                    <button form="confirmCodeForm" type="submit" class="btn btn-primary text-uppercase btn-confirm-code"> <?=Loc::getMessage('confirm');?></button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade modal-confirm-code" id="confirmRise" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <h3 class="subtitle" id="exampleModalLabel">
                    <?=Loc::getMessage('want');?>
                </h3>


                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                    <div class="mb-4 mb-md-0 d-flex justify-content-between w-100 align-items-center">
                        <button type="button" class="btn btn-transparent btn-close" data-dismiss="modal"><?=Loc::getMessage('close');?></button>
                    </div>
                    <button data-dismiss="modal" class="btn btn-primary text-uppercase"><?=Loc::getMessage('confirm');?></button>
                </div>
            </div>
        </div>
    </div>
</div>