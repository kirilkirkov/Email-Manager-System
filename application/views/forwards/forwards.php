<div class="container">
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <a href="<?= base_url('forwards/add_edit_forward') ?>" class="btn btn-primary btn-lg">Add Forward</a>
            </div>
        </div>
        <div class="col-sm-6">
            <form method="get" action="forwards">
                <div class="form-group">
                    <div class="input-group">
                        <input type="text" class="form-control" name="serachforwards" placeholder="Search in forwards addresses.." value="<?= $this->input->get('serachforwards') ?>">
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
    <h1>Forwards:</h1>
    <?php echo form_open('forwards/delforward'); ?>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th><input type="checkbox" id="selectall" value=""></th>
                    <th>Forward</th>
                    <th>Recipients</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($allforwards)) {
                    foreach ($allforwards as $val) {
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
                            <td><a href="<?= base_url('forwards/add_edit_forward/' . $val['domain'] . '/' . $val['local_part'] . '') ?>">Edit</a></td>
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <tr><td colspan="6">No Forwards</td></tr>
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