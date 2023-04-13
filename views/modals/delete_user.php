<div id="deleteUserModal" class="modal fade" style="display: none;" tabindex="-1" aria-labelledby="deleteUserModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/users/delete" method="post">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Employee</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this User?</p>
                    <p class="text-danger">This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" data-bs-dismiss="modal" aria-label="Cancel">Cancel</button>
                    <input type="submit" class="btn btn-danger" value="Delete">
                </div>
                <input type="hidden" class="form-control" id="user_id" name="user_id" value="" />
            </form>
        </div>
    </div>
</div>