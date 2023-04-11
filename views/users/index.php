<?php
/** @var $model \app\models\User */
?>
<div class="container">
    <div class="table-wrapper mt-5">
        <div class="table-title">
            <div class="row">
                <div class="col-sm-6">
                    <h2>Manage Employees</h2>
                </div>
                <div class="col-sm-6">
                    <a href="/users/new" class="btn btn-success">
                        <span>Add New Employee</span>
                    </a>
                    <a href="#deleteEmployeeModal" class="btn btn-danger" data-toggle="modal">
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
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($users as $user) { ?>
                    <tr>
                        <td>
                            <span class="custom-checkbox">
                                <input type="checkbox" id="checkbox<?= $user['id'] ?>" name="options[]" value="<?= $user['id'] ?>">
                                <label for="checkbox<?= $user['id'] ?>"></label>
                            </span>
                        </td>
                        <td>
                            <?= $user['first_name'] ?>
                        </td>
                        <td>
                            <?= $user['last_name'] ?>
                        </td>
                        <td>
                            <?= $user['email'] ?>
                        </td>
                        <td>
                            <?= $user['user_type'] ?>
                        </td>
                        <td>
                            <a href="#editEmployeeModal" class="edit" data-toggle="modal">
                                <i class="material-icons" data-toggle="tooltip" title="" data-original-title="Edit"></i>
                            </a>
                            <a href="#deleteEmployeeModal" class="delete" data-toggle="modal">
                                <i class="material-icons" data-toggle="tooltip" title="" data-original-title="Delete"></i>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
