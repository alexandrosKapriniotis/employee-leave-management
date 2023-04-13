<?php
/** @var $model \app\models\Application */
?>
<div class="container">
    <div class="table-wrapper mt-5">
        <div class="table-title">
            <div class="row">
                <div class="col-sm-6">
                    <h2>Applications</h2>
                </div>
                <div class="col-sm-6">
                    <a href="/applications/new" class="btn btn-success">
                        <span>Submit Request</span>
                    </a>

                </div>
            </div>
        </div>
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th>Date submitted</th>
                <th>Dates Requested</th>
                <th>Days requested</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($applications as $application) { ?>
                <tr>
                    <td>
                        <?= date("d/m/Y", strtotime($application['created_at'])) ?>
                    </td>
                    <td>
                        <?php echo date("d/m/Y", strtotime($application['date_from']))."-".date("d/m/Y", strtotime($application['date_to'])) ?>
                    </td>
                    <td>
                        <?php echo \app\models\Application::getDaysRequested($application['date_from'], $application['date_to']) ?>
                    </td>
                    <td>
                        <?= $application['status'] ?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>

