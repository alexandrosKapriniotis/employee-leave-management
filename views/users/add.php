<?php
/** @var $model \app\models\User */
?>
<div class="p-4 md:py-8 md:px-12 lg:ml-60 space-y-8">
    <div class="position-relative addUser">
        <h3>Add User</h3>
        <?php $form = app\core\form\Form::begin('/users/new', "post"); ?>
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
        <div class="d-flex justify-content-end align-items-baseline mt-4">
            <a href="/users" class="text-dark me-2">Cancel</a>
            <button type="submit" class="btn btn-primary mb-4 rounded-2">Create user</button>
        </div>
        <?php echo app\core\form\Form::end() ?>
    </div>
</div>
