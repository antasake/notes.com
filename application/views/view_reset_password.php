<h5> Reset Password</h5>
<div id="reset_password_form">
	<form action="/login/reset_password" method="POST">
	<div>
		<label for="email">Email: </label>
		<input type="email" value="<?php echo set_value('email'); ?>" name="email"/>
	</div>
	<div>
		<input type="submit" name="submit" value="Reset my Password" />
	</div>
	</form>
	<?php
		echo validation_errors('<p class="error">');
		if(isset($error))
		{
			echo '<p class="error">'. $error . '</p>';
		}
	?>
</div> 