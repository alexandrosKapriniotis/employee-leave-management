<?php
/** @var $model \app\models\User */
?>
<div class="container">
    <div class="table-wrapper">
        <div class="table-title">
            <div class="row">
                <div class="col-sm-6">
                    <h2>Manage Employees</h2>
                </div>
                <div class="col-sm-6">
                    <a href="#addEmployeeModal" class="btn btn-success" data-toggle="modal">
                        <i class="bi bi-person-plus-fill"></i>
                        <span>Add New Employee</span>
                    </a>
                    <a href="#deleteEmployeeModal" class="btn btn-danger" data-toggle="modal">
                        <i class="bi bi-trash"></i>
                        <span>Delete</span>
                    </a>
                </div>
            </div>
        </div>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>
                        <span class="custom-checkbox">
                            <input type="checkbox" id="selectAll">
                            <label for="selectAll"></label>
                        </span>
                    </th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>User Type</th>
                </tr>
            </thead>
            <tbody>
                <tr></tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Add Modal HTML -->
<div id="addEmployeeModal" class="modal fade" style="display:none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <?php $form = app\core\form\Form::begin('', "post"); ?>
            <div class="modal-header">
                <h4 class="modal-title">Add Employee</h4>
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
<!-- Edit Modal HTML -->
<div id="editEmployeeModal" class="modal fade" style="display: none;">
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
<!-- Delete Modal HTML -->
<div id="deleteEmployeeModal" class="modal fade" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <?php $form = app\core\form\Form::begin('', "post"); ?>
            <div class="modal-header">
                <h4 class="modal-title">Delete Employee</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete these Record(s)?</p>
                <p class="text-warning"><small>This action cannot be undone.</small></p>
            </div>
            <div class="modal-footer">
                <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                <input type="submit" class="btn btn-danger" value="Delete">
            </div>
            <?php echo app\core\form\Form::end() ?>
        </div>
    </div>
</div>