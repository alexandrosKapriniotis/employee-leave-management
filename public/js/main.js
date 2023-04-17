$(document).ready(function(){
    $(".delete-btn").click(function(){
        if ($('#deleteUserModal').length) {
            $("#user_id").val($(this).attr('data-id'));
            $('#deleteUserModal').modal('show');
        }

        if ($('#deleteApplicationModal').length) {
            $("#application_id").val($(this).attr('data-id'));
            $('#deleteApplicationModal').modal('show');
        }
    });

    $("#userTable td").click(function (e) {
        if (!$(e.target).hasClass('actions-cell')) {
            window.location = $(this).parent().find('.edit').attr("href");
        }
    })
});