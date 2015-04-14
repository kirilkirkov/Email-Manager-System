<div class="container">
    <div class="col-sm-6">
        <h2>Add / Update User</h2>
        <?php if (validation_errors()) { ?>
            <hr>  <div class="alert alert-info" role="alert"><?= validation_errors() ?></div>
        <?php } ?>
        <?php if ($this->session->flashdata('message') != null) { ?>
            <hr> <div class="alert alert-info" role="alert"><?= $this->session->flashdata('message') ?></div>
        <?php } ?>
        <?php echo form_open(); ?>
        <div class="form-group">
            <label for="usr">Name:</label>
            <input type="text" class="form-control" id="usr" name="name" value="<?= $_POST['name'] ?>">
        </div>
        <div class="form-group">
            <label for="usr">Username:</label>
            <input type="text" class="form-control" id="usr" name="login" value="<?= $_POST['login'] ?>">
        </div>
        <div class="form-group">
            <label for="pwd">Password:</label>
            <input type="text" class="form-control" id="pwd" value="<?= $_POST['decrypt'] ?>" name="decrypt">
            <span>Password Strength:</span>
            <div class="progress">
  			<div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 0;">
			  </div>
			</div>
            <button type="button" id="GeneratePwd" class="btn btn-default">Generate Password</button> 
            <p id="demo"></p>
        </div>
        <div class="form-group">
            <label for="sel1">Domain:</label>
            <?php echo form_dropdown('domain', $domains, $_POST['domain'], 'class="form-control"'); ?>
        </div>
        <button type="submit" name="submit" class="btn btn-primary btn-md">Submit</button>
        <a href="<?= base_url('users') ?>" class="btn btn-primary btn-md">Cancel</a>
        <?= form_close() ?>
    </div> 
</div>
<script type="text/javascript" src="<?= base_url('assets/js/zxcvbn.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/js/zxcvbn_bootstrap3.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/js/pGenerator.jquery.js') ?>"></script>
<script type="text/javascript">
$(document).ready(function () {
	//PassStrength 
	checkPass();
	 $("#pwd").on('keyup', function() {
		 checkPass();
	 });
	 var edit = '<?= $this->uri->segment(3); ?>';
	 $("form").submit(function() {
		 if(edit == '') {
		 if(checkPass()==false) {
			 $("#pwd").parent('div').addClass('has-error');
		 	return checkPass();
		 }
		 }
	});

	//PassGenerator
    $('#GeneratePwd').pGenerator({
        'bind': 'click',
        'passwordLength': 9,
        'uppercase': true,
        'lowercase': true,
        'numbers':   true,
        'specialChars': false,
        'onPasswordGenerated': function(generatedPassword) {
        	$("#pwd").val(generatedPassword);
        	checkPass();
        }
    });
});
</script>
