<div class="container"> 
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <a href="<?= base_url('users/add_edit_user') ?>" class="btn btn-primary btn-lg">Add New User</a>
            </div>
        </div>
        <div class="col-sm-6">
            <form method="get" action="users">
                <div class="form-group">
                    <div class="input-group">
                        <input type="text" class="form-control" name="searchuser" placeholder="Search in users names and usernames.." value="<?= $this->input->get('searchuser') ?>">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="submit">Go!</button>
                        </span>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <hr>
    <h2>Users List:</h2>
    <?php if ($this->session->flashdata('message')) { ?>
        <hr> <div class="alert alert-info" role="alert"><?= $this->session->flashdata('message') ?></div>
    <?php } ?>
    <?php echo form_open('users/deluser') ?>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th><input type="checkbox" id="selectall" value=""></th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Domain</th>
                    <th>Password</th>
                    <th>More</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($getusers)) {
                    foreach ($getusers as $info) {
                        ?>
                        <tr>
                            <td><input type="checkbox" class="check" name="check_list[]" value="<?= $info['login'].'@'.$info['domain'] ?>"></td>
                            <td><?= $info['name'] ?></td>
                            <td><?= $info['login'] ?></td>
                            <td><?= $info['domain'] ?></td>
                            <td><?= $info['decrypt'] ?></td>
                            <td><a href="<?= base_url('users/add_edit_user/' . $info['domain'] . '/' . $info['login'] . '') ?>">Edit</a></td>
                        </tr>

                        <?php
                    }
                } else {
                    ?>
                    <tr> <td colspan="9">No users in Database</td></tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
    <button type="submit" name="delete" class="btn btn-default delete">Remove Selected <span class="glyphicon glyphicon-trash"></span></button>
        <?= $links_pagination ?>
        <?= form_close() ?>
</div>