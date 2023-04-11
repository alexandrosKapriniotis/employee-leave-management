<div id="deleteEmployee" class="modal fade" style="display: none;">
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