<div class="container">
    <div class="row">
        <div class="col-sm-6">
            <h2>Add Domain</h2>
            <?php echo form_open('domains'); ?>
            <div class="form-group">
                <label for="domainname">Domain name:</label>
                <input type="text" class="form-control" name="domain" id="domainname">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-default" id="adddomain">Add To Database <span class="glyphicon glyphicon-plus"></span></button>
            </div>
            <?= form_close() ?>
        </div>
    </div>
    <hr>
    <?php if (validation_errors()) { ?>
        <div class="alert alert-info" role="alert"><?= validation_errors() ?></div> <hr> 
    <?php } ?>
    <?php if ($this->session->flashdata('message') != null) { ?>
        <div class="alert alert-info" role="alert"><?= $this->session->flashdata('message') ?></div> <hr>
    <?php } ?>

    <h2>Domain List</h2>
    <?php echo form_open('domains/deldomain/'); ?>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th><input type="checkbox" id="selectall" value=""></th>
                <th>Domain</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($domains)) {
                foreach ($domains as $val) {
                    ?>
                    <tr>
                        <td class="col-xs-1"><input type="checkbox" class="check" name="check_list[]" value="<?= $val ?>"></td>
                        <td><?= $val ?></td>
                    </tr>
                    <?php
                }
            } else {
                ?>
                <tr>
                    <td colspan="3">No domains in database</td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
    <button type="submit" name="delete" class="btn btn-default delete">Remove Selected <span class="glyphicon glyphicon-trash"></span></button>
        <?= form_close() ?>
</div>