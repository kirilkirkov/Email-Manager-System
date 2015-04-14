<div class="container">
    <div class="col-sm-6">
        <h2>Add / Update Alias</h2>
        <?php if (validation_errors()) { ?>
            <hr>  <div class="alert alert-info" role="alert"><?= validation_errors() ?></div>
        <?php } ?>
        <?php if ($this->session->flashdata('message') != null) { ?>
            <hr> <div class="alert alert-info" role="alert"><?= $this->session->flashdata('message') ?></div>
        <?php } ?>
        <?php echo form_open(); ?>
        <div class="form-group">
            <label>Alias:</label>
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Add alias" value="<?= $_POST['local_part'] ?>" name="local_part" aria-describedby="sizing-addon2">
                <span class="input-group-addon" id="sizing-addon2">@</span>
                <?php echo form_dropdown('domain', $domains, $_POST['domain'], 'class="form-control"'); ?>
            </div>
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
                        <a href="javascript:void(0)" class="glyphicon glyphicon-remove recipient_delete"></a>
                        <input type="hidden" value="<?= $rec ?>" name="recipients[]">
                    </li>
                    <?php
                }
            }
            ?>
        </ul>
        <button type="submit" name="submit" class="btn btn-primary btn-md">Submit</button>
        <a href="<?= base_url('aliases') ?>" class="btn btn-primary btn-md">Cancel</a>
        <?php echo form_close(); ?>
    </div>
</div>
<script>
    $(document).ready(function () {
        $("#add_recipient").click(function () {
            var val = $("#value_recipient").val();
            if ($("input[value='" + val + "']").length == 0) {
                $("#recipient_list").append($('<li class="list-group-item"></li>').
                        html(val + '<a href="#" class="glyphicon glyphicon-remove recipient_delete"></a>'
                                + '<input type="hidden" value="' + val + '" name="recipients[]">'));
            } else {
                alert('Already exists');
            }
        });
        $("body").on("click", ".recipient_delete", function () {
            $(this).parent().remove();
            return false;
        });
    });
</script>
