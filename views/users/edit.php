<?php
/** @var $model \app\models\User */
?>
<div class="p-4 md:py-8 md:px-12 lg:ml-60 space-y-8">
    <div class="position-relative" id="editUserTable">
        <h3>Update User</h3>
        <?php $form = app\core\form\Form::begin('/users/'.$model->id.'/update', "post"); ?>
        <div class="row">
            <div class="col">
                <?= $form->field($model, 'first_name', $model->first_name); ?>
            </div>
            <div class="col">
                <?= $form->field($model, 'last_name', $model->last_name); ?>
            </div>
        </div>
        <?php
        echo $form->field($model, 'email', $model->email)->emailField();
        echo $form->selectField($model, 'user_type', ['employee', 'admin'], $model->getUserType());
        ?>
        <div class="d-flex justify-content-end align-items-baseline mt-4">
            <a href="/users" class="text-dark me-2">Cancel</a>
            <button type="submit" class="btn btn-primary mb-4 rounded-2">Update user</button>
        </div>
        <?php echo app\core\form\Form::end() ?>
    </div>
</div>