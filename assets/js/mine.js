$(document).ready(function () {
//Delete Confirm and multy select checkboxes
    $('#selectall').click(function () {
        if (this.checked) {
            $('.check').each(function () {
                this.checked = true;
            });
        } else {
            $('.check').each(function () {
                this.checked = false;
            });
        }
    });

    $(".delete").click(function () {
        if (!confirm('Are you sure you want to delete that?')) {
            return false;
        }
    });
});

