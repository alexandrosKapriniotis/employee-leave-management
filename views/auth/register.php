<div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
    <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
            <div class="col-md-8 col-lg-6 col-xxl-3">
                <div class="card mb-0">
                    <div class="card-body">
                        <?php $form = app\core\form\Form::begin('', "post"); ?>
                        <div class="row">
                            <div class="col">
                                <?= $form->field($model, 'firstName'); ?>
                            </div>
                            <div class="col">
                                <?= $form->field($model, 'lastName'); ?>
                            </div>
                        </div>
                        <?php
                            echo $form->field($model, 'email')->emailField();
                            echo $form->field($model, 'password')->passwordField();
                            echo $form->field($model, 'confirmPassword')->passwordField();
                        ?>
                        <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Register</button>
                        <?php    echo app\core\form\Form::end() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

