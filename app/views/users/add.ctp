<?php
	echo $html->css('forms', false, false, false);
?>
<?php echo $advform->create('User'); ?>
	<h1>Signup for WovenWeb</h1>

	<table width="100%" cellpadding="0" cellspacing="0">
		<tr>
			<td colspan="2"><h2>Email and Password</h2></td>
		</tr>
		<tr>
			<td width="50%">
				<?php echo $advform->input('email', array('style' => 'width: 320px;', 'label' => 'Email Address')); ?>
			</td>
			<td width="50%">
				<?php echo $advform->input('password', array('style' => 'width: 320px;', 'label' => 'Password')); ?>
				<?php echo $advform->input('confirm_password', array('style' => 'width: 320px;', 'label' => 'Re-type Password', 'type' => 'password')); ?>
			</td>
		</tr>
	</table>
	
	<table width="100%" cellpadding="0" cellspacing="0">
		<tr>
			<td colspan="2"><h2>Account Setup</h2></td>
		</tr>
		<tr>
			<td width="50%">
				<?php echo $advform->input('country', array('style' => 'width: 320px;')); ?>
			</td>
			<td width="50%">
				<?php echo $advform->input('timezone_id', array('style' => 'width: 320px;')); ?>
				<?php echo $advform->input('language', array('style' => 'width: 100px;')); ?>
			</td>
		</tr>
		<tr>
			<td></td>
		</tr>
	</table>

	<?php echo $advform->submit('Sign Up'); ?>
<?php echo $advform->end(); ?>