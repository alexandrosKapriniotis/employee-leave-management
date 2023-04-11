<div id="editEmployee" class="modal fade" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <?php $form = app\core\form\Form::begin('', "post"); ?>
            <div class="modal-header">
                <h4 class="modal-title">Edit Employee</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <?= $form->field($model, 'first_name'); ?>
                    </div>
                    <div class="col">
                        <?= $form->field($model, 'last_name'); ?>
                    </div>
                </div>
                <?php
                echo $form->field($model, 'email')->emailField();
                echo $form->selectField($model, 'user_type',['employee','admin']);
                echo $form->field($model, 'password')->passwordField();
                echo $form->field($model, 'confirmPassword')->passwordField();
                ?>
            </div>
            <?php echo app\core\form\Form::end() ?>
        </div>
    </div>
</div>