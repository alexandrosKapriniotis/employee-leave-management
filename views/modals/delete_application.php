<div id="deleteApplicationModal" class="modal fade" style="display: none;" tabindex="-1" aria-labelledby="deleteApplicationModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/applications/delete" method="post">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Employee</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this Application?</p>
                    <p class="text-warning"><small>This action cannot be undone.</small></p>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                    <input type="submit" class="btn btn-danger" value="Delete">
                </div>
                <input type="hidden" class="form-control" id="application_id" name="application_id" value="" />
            </form>
        </div>
    </div>
</div>