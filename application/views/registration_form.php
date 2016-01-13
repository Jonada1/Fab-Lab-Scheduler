<?php $this->load->view('partials/header'); ?>
 
<?php $this->load->view('partials/menu'); ?>

<script src="<?php echo asset_url();?>js/validator.min.js"></script>

<div class="container registration-form-container">
	<h4 class="modal-title">REGISTRATION</h4>
	<hr/>
	<?php foreach ($errors as $item):?>
		<div style='color:red;'>- <?php echo $item;?></div>
	<?php endforeach;?>
	<form name="registration" method="post" id="registerform" action="<?php echo base_url();?>user/registration" onsubmit="return true;">
		<div class="form-group required has-feedback">
			<label class="control-label" for="username">User name</label>
			<input type="text" data-minlength="5" data-maxlength="100" class="form-control" name="username" id="username" required placeholder="User name" value="<?php echo $username;?>"/>
			<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
			<span class="help-block">Length between 5 and 100 characters.</span>
		</div>	
		<div class="form-group required has-feedback">
			<label class="control-label" for="email">Email address</label>
			<input type="email" class="form-control" name="email" id="email" required placeholder="Email address" value="<?php echo $email;?>" />
			<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
		</div>
		<div class="form-group required has-feedback">
			<label class="control-label">Password</label>
			<div class="row">
				<div class="col-sm-6">
					<input type="password" data-minlength="5" data-maxlength="100" class="form-control" name="first_password" id="first_password" value="" required placeholder="Password" />
					<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
					<span class="help-block">Length between 5 and 20 characters.</span>
				</div>
				<div class="col-sm-6">
					<input type="password" class="form-control" name="second_password" id="second_password" data-match="#first_password" data-match-error="Whoops, these aren't the same" value="" required placeholder="Confirm password" />
					<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
					<div class="help-block with-errors"></div>
				</div>
			</div>
		</div>
		<div class="form-group required has-feedback">
			<label class="control-label">Name</label>
			<div class="row">
				<div class="col-sm-6">
					<input type="text" class="form-control" name="first_name" id="first_name" placeholder="First name" value="<?php echo $first_name;?>" required/>
					<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
				</div>
				<div class="col-sm-6">
					<input type="text" class="form-control" name="surname" id="surname" placeholder="Last name" value="<?php echo $surname;?>" required/>
					<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
				</div>
			</div>
		</div>
		<div class="form-group required has-feedback">
			<label class="control-label" for="phone_number">Phone number</label>
			<input type="tel" class="form-control" name="phone_number" id="phone_number" required placeholder="Phone number" value="<?php echo $phone_number;?>"/>
			<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
		</div>
		<div class="form-group has-feedback">
			<label class="control-label" for="address_street">Address</label>
			<div class="row">
				<div class="col-sm-6">
					<input type="text" class="form-control" name="address_street" id="address_street" placeholder="Address" value="<?php echo $address_street;?>"/>
					<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
				</div>
				<div class="col-sm-6">
					<input type="text" class="form-control" name="address_postal_code" id="address_postal_code" placeholder="Postal code" value="<?php echo $address_postal_code;?>"/>
					<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
				</div>
			</div>
		</div>
		<div class="form-group has-feedback">
			<label class="control-label" for="company">Company</label>
			<input type="text" class="form-control" name="company" id="company" placeholder="Company" value="<?php echo $company;?>"/>
			<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
		</div>
		<div class="form-group has-feedback">
			<label class="control-label" for="student_number">Student number</label>
			<input type="text" class="form-control" name="student_number" id="student_number" placeholder="Student number" value="<?php echo $student_number;?>"/>
			<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
		</div>
		<button type="submit" class='btn btn-primary' text="Register" >Register</button>
	</form>

</div>
<script>
$('#registerform').validator().on('submit', function (e) {
    if (e.isDefaultPrevented()) {
    	alert('form is not valid');
    } else {
        
    }
});
</script>
<?php $this->load->view('partials/footer'); ?>