<?php
/** @var $model \app\models\Application */
?>
<div class="p-4 md:py-8 md:px-12 lg:ml-60 space-y-8">
    <div class="position-relative addUser">
        <h3>Add Application</h3>
        <?php $form = app\core\form\Form::begin('/applications/new', "post"); ?>
        <div class="row">
            <div class="col">
                <?= $form->field($model, 'date_from')->dateField(); ?>
            </div>
            <div class="col">
                <?= $form->field($model, 'date_to')->dateField(); ?>
            </div>
        </div>
        <?php echo $form->textAreaField($model, 'reason'); ?>
        <?= $form->field($model, 'user_id', \app\core\Application::$app->user->id)->hiddenField(); ?>
        <div class="d-flex justify-content-end align-items-baseline mt-4">
            <a href="/applications" class="text-dark me-2">Cancel</a>
            <button type="submit" class="btn btn-primary mb-4 rounded-2">Create application</button>
        </div>
        <?php echo app\core\form\Form::end() ?>
    </div>
</div>

