<div id="login_form">
	<?php
	if(isset($account_created))
	{ 
		echo $account_created; 
	} 
	else 
	{ 
		echo "<h5>Login, please.</h5>";
	} ?>
	
	<?php
	echo form_open('login/validate_credentials');
	echo form_input('username','','placeholder="Username" class="username"');
	echo form_password('password','','placeholder="Password" class="password"');
	echo form_submit('submit','Login');
	echo anchor('login/signup','Create Account');
	echo anchor('login/reset_password','</br>Forgot your Password?');
	echo form_close();
	?>
	</div>