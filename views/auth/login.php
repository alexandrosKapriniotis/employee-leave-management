<?php
/** @var $model \app\models\User */
?>
<div class="d-flex align-items-center justify-content-center w-100">
    <div class="row justify-content-center w-100">
        <div class="col-md-8 col-lg-6 col-xxl-3">
            <div class="card mb-0">
                <div class="card-body">
                    <p class="text-center">Login</p>
                    <?php $form = app\core\form\Form::begin('', "post"); ?>
                        <?php echo $form->field($model, 'email')->emailField(); ?>
                        <?php echo $form->field($model, 'password')->passwordField(); ?>
                        <?php if(isset($_GET['redirect'])) { ?>
                            <input name='redirect' type='hidden' value='<?php echo $_GET['redirect'] ?>' />
                        <?php } ?>
                        <button class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Login</button>
                    <?php echo app\core\form\Form::end() ?>
                </div>
            </div>
        </div>
    </div>
</div>