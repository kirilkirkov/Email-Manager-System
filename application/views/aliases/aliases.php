<div class="container">
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <a href="<?= base_url('aliases/add_edit_alias') ?>" class="btn btn-primary btn-lg">Add Alias</a>
            </div>
        </div>
        <div class="col-sm-6">
            <form method="get" action="aliases">
                <div class="form-group">
                    <div class="input-group">
                        <input type="text" class="form-control" name="serachaliases" placeholder="Search in alias name.." value="<?= $this->input->get('serachaliases') ?>">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="submit">Go!</button>
                        </span>
                    </div>
                </div>
            </form>
        </div>
    </div> 
    <hr>
    <?php if ($this->session->flashdata('message')) { ?>
        <div class="alert alert-info" role="alert"><?= $this->session->flashdata('message') ?></div>
        <hr>
    <?php } ?>
    <h1>Aliases:</h1>
    <?php echo form_open('aliases/delalias'); ?>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th><input type="checkbox" id="selectall" value=""></th>
                    <th>Alias</th>
                    <th>Recipients</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($allaliases)) {
                    foreach ($allaliases as $val) {
                        ?>
                        <tr>
                            <td><input type="checkbox" class="check" name="check_list[]" value="<?= $val['local_part'] . '@' . $val['domain'] ?>"></td>
                            <td><?= $val['local_part'] . '@' . $val['domain'] ?></td>
                            <td><?php
                                foreach ($val['recipients'] as $rec) {
                                    ?>
                                    <div><?= $rec ?></div>
                                <?php }
                                ?></td>
                            <td><a href="<?= base_url('aliases/add_edit_alias/' . $val['domain'] . '/' . $val['local_part'] . '') ?>">Edit</a></td>
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <tr><td colspan="6">No Aliases</td></tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
    <button type="submit" class="btn btn-default delete">Remove Selected <span class="glyphicon glyphicon-trash"></span></button>
        <?= $links_pagination ?>
        <?= form_close() ?>
</div>