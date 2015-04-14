<div class="container">
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <a href="<?= base_url('vacation/add_edit_vacation') ?>" class="btn btn-primary btn-lg">Add Auto-Reply</a>
            </div>
        </div>
        <div class="col-sm-6">
            <form method="get" action="vacation">
                <div class="form-group">
                    <div class="input-group">
                        <input type="text" class="form-control" name="searchvacation" placeholder="Search user.." value="<?= $this->input->get('searchvacation') ?>">
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
    <h1>Auto-Reply Messages</h1>
    <?php echo form_open('vacation/delvacation'); ?>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th><input type="checkbox" id="selectall" value=""></th>
                    <th>User</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Create</th>
                    <th>Active</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($allmessages)) {
                    foreach ($allmessages as $row) {
                        ?>
                        <tr>
                            <td><input type="checkbox" class="check" name="check_list[]" value="<?= $row['email'] . '@' . $row['domain'] ?>"></td>
                            <td><?= $row['email'] . '@' . $row['domain'] ?></td>
                            <td><?= date('m/d/Y', $row['startdate']) ?></td>
                            <td><?= date('m/d/Y', $row['enddate']) ?></td>
                            <td><?= $row['subject'] ?></td>
                            <td><?= character_limiter($row['message'],100) ?></td>
                            <td><?= $row['created'] ?></td>
                            <td><?= $row['active'] ?></td>
                            <td><a href="<?= base_url('vacation/add_edit_vacation/' . $row['domain'] . '/' . $row['email'] . '') ?>">Edit</a></td>
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <tr><td colspan="9">No Messages</td></tr>
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