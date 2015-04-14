<div class="container">
    <div class="col-sm-6">
        <h2>Add / Update Auto-Reply</h2>
        <?php if (validation_errors()) { ?>
            <hr>  <div class="alert alert-info" role="alert"><?= validation_errors() ?></div>
        <?php } ?>
        <?php if ($this->session->flashdata('message') != null) { ?>
            <hr> <div class="alert alert-info" role="alert"><?= $this->session->flashdata('message') ?></div>
        <?php } ?>
        <?php echo form_open(); ?>
        <div class="form-group">
            <div class="checkbox"> 
                <label><input type="checkbox" name="active" <?= @$_POST['active'] === '0' ? '' : 'checked' ?> >Active</label>
            </div>
        </div>
        <div class="form-group">
            <label>Username:</label>
            <?php if ($this->uri->segment(4)) { ?>
                <input type="hidden" name="email" value="<?= $_POST['email'] . @$_POST['domain'] ?>">
            <?php } ?>
            <input type="text" id="vacation-autocomplete" class="form-control" placeholder="Registered user" name="email" <?= $this->uri->segment(4) ? 'disabled' : '' ?> value="<?= $_POST['email'] . @$_POST['domain'] ?>" aria-describedby="sizing-addon2">
        </div>
        <div class="form-group">
            <label>Start Date:</label>
            <input type="text" id="startdate" class="form-control" placeholder="Start date"  name="startdate" value="<?= $_POST['startdate'] == false ? date('m/d/Y') : $_POST['startdate'] ?>" aria-describedby="sizing-addon2">
        </div>
        <div class="form-group">
            <label>End Date:</label>
            <input type="text" id="enddate" class="form-control" name="enddate" placeholder="End date" value="<?= $_POST['enddate'] == false ? date('m/d/Y', strtotime('+1 month')) : $_POST['enddate'] ?>" aria-describedby="sizing-addon2">
        </div>
        <div class="form-group">
            <label>Subject:</label>
            <input type="text" class="form-control" placeholder="Subject" name="subject" value="<?= $_POST['subject'] ?>" aria-describedby="sizing-addon2">
        </div>
        <div class="form-group">
            <label>Message:</label>
            <textarea class="form-control" name="message" rows="5"><?= $_POST['message'] ?></textarea>
        </div>
        <button type="submit" name="submit" class="btn btn-primary btn-md">Submit</button>
        <a href="<?= base_url('vacation') ?>" class="btn btn-primary btn-md">Cancel</a>
        <?= form_close() ?>
    </div>
</div>
<script>
    $("#vacation-autocomplete").autocomplete({
        source: "<?= base_url() ?>vacation/autocompleteReturn"
    });
    $(function () {
        $("#startdate").datepicker();
    });
    $(function () {
        $("#enddate").datepicker();
    });
</script>