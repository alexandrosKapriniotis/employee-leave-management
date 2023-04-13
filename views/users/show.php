<?php
/** @var $model \app\models\User */
?>
<div class="p-4 md:py-8 md:px-12 lg:ml-60 space-y-8">
    <div class="position-relative showUser">
        <h4>User Details: <?= $model ->getDisplayName(); ?></h4>
        <div class="bg-white rounded-2 mt-3 shadow">
            <div class="d-flex flex-column flex-md-row px-6 py-2 py-md-0 border border-1 border-gray">
                <div class="w-25 py-md-3">
                    <h4>
                        <span>First Name</span>
                    </h4>
                </div>

                <div class="w-75 py-md-3">
                    <span><?= $model->first_name ?></span>
                </div>
            </div>
            <div class="d-flex flex-column flex-md-row px-6 py-2 py-md-0border border-1 border-gray">
                <div class="w-25 py-md-3">
                    <h4>
                        <span>Last Name</span>
                    </h4>
                </div>

                <div class="w-75 py-md-3">
                    <span><?= $model->last_name ?></span>
                </div>
            </div>
            <div class="d-flex flex-column flex-md-row px-6 py-2 py-md-0 border border-1 border-gray">
                <div class="w-25 py-md-3">
                    <h4>
                        <span>Email</span>
                    </h4>
                </div>

                <div class="w-75 py-md-3">
                    <span><?= $model->email ?></span>
                </div>
            </div>
            <div class="d-flex flex-column flex-md-row px-6 py-2 py-md-0">
                <div class="w-25 py-md-3">
                    <h4>
                        <span>User type</span>
                    </h4>
                </div>

                <div class="w-75 py-md-3">
                    <span><?= $model->getUserType() ?></span>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end align-items-baseline mt-4">
            <a href="/users" class="text-dark me-2">Back to users</a>
        </div>
        <?php echo app\core\form\Form::end() ?>
    </div>
</div>