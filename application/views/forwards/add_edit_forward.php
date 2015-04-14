<div class="container">
    <div class="col-sm-6">
        <h2>Add / Update Forward</h2>
        <?php if (validation_errors()) { ?>
            <hr>  <div class="alert alert-info" role="alert"><?= validation_errors() ?></div>
        <?php } ?>
        <?php if ($this->session->flashdata('message') != null) { ?>
            <hr> <div class="alert alert-info" role="alert"><?= $this->session->flashdata('message') ?></div>
        <?php } ?>
        <?php echo form_open(); ?>
        <div class="form-group">
            <label>Username:</label>
            <input type="text" id="forward-autocomplete" class="form-control" placeholder="Registered user" value="<?= $_POST['local_part'] . @$_POST['domain'] ?>" name="local_part" aria-describedby="sizing-addon2">
        </div>
        <div class="form-group">
            <label>Recipients:</label>
            <div class="input-group">
                <input type="text" class="form-control" id="value_recipient" placeholder="Add recipient">
                <span class="input-group-btn">
                    <button class="btn btn-default" id="add_recipient" type="button"><span class="glyphicon glyphicon-plus"></span></button>
                </span>
            </div> 
        </div>
        <ul class="list-group" id="recipient_list">
            <?php
            if (!empty($_POST['recipients'])) {
                foreach ($_POST['recipients'] as $rec) {
                    ?>
                    <li class="list-group-item">
                        <?= $rec ?>
                        <a href="#" class="glyphicon glyphicon-remove recipient_delete"></a>
                        <input type="hidden" value="<?= $rec ?>" name="recipients[]">
                    </li>
                    <?php
                }
            }
            ?>
        </ul>
        <button type="submit" name="submit" class="btn btn-primary btn-md">Submit</button>
        <a href="<?= base_url('forwards') ?>" class="btn btn-primary btn-md">Cancel</a>
        <?= form_close() ?>
    </div>
</div>
<script>
    function IsEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }
    $(document).ready(function () {
        $("#add_recipient").click(function () {
            var val = $("#value_recipient").val();
            if (IsEmail(val) != false) {
                if ($("input[value='" + val + "']").length == 0) {
                    $("#recipient_list").append($('<li class="list-group-item"></li>').
                            html(val + '<a href="#" class="glyphicon glyphicon-remove recipient_delete"></a>'
                                    + '<input type="hidden" value="' + val + '" name="recipients[]">'));
                } else {
                    alert('Already exists');
                }
            } else {
                alert('Not valid email');
            }
        });
        $("body").on("click", ".recipient_delete", function () {
            $(this).parent().remove();
            return false;
        });
    });
    $("#forward-autocomplete").autocomplete({
        source: "<?= base_url('forwards/autocompleteReturn') ?>"
    });
</script>
