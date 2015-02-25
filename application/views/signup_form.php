<div id="register_form">
	<h5>Create an Account!</h5>
		<?php
		echo form_open('login/create_member');
		
		echo form_label('First Name');
		echo form_input('first_name',set_value('first_name'));
		
		echo form_label('Last Name');
		echo form_input('last_name',set_value('last_name'));
		
		echo form_label('Email Address');
		echo form_input('email',set_value('email'));
		
		echo form_label('Username');
		echo form_input('username',set_value('username'));
		
		echo form_label('Password');
		echo form_password('password',set_value('password'));
		
		echo form_label('Confirm Password');
		echo form_password('password_confirm',set_value('password_confirm'));
		
		echo form_submit('submit','Create Account');
		?>
		<?php echo validation_errors('<p class="error">'); ?>
</div>