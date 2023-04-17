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
                </div>
            </div>
        </div>
        <table class="table table-striped table-hover" id="userTable">
            <thead>
                <tr>
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
                        <td class="d-flex justify-content-center align-items-center actions-cell">
                            <a class="show" href="/users/<?= $user['id'] ?>">
                                <i class="material-icons" data-toggle="tooltip" title="" data-original-title="Show">
                                    visibility
                                </i>
                            </a>
                            <a href="/users/<?= $user['id'] ?>/edit" class="edit">
                                <i class="material-icons" data-toggle="tooltip" title="" data-original-title="Edit"></i>
                            </a>
                            <button data-id="<?= $user['id'] ?>" data-bs-target="#deleteUserModal" data-bs-toggle="modal" class="btn delete delete-btn">
                                <i class="material-icons" data-toggle="tooltip" title="" data-original-title="Delete"></i>
                            </button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<?php include_once __DIR__."/../modals/delete_user.php"?>


