<h1 id="logo">Woven Web</h1>
<h2>Log in to <?php echo env('HTTP_HOST'); ?></h2>
<?php echo $advform->create('User', array('action' => 'login')); ?>
	<fieldset>
		<?php echo $advform->inputWithDefault('email', 'email', array('label' => false, 'class' => 'text', 'id' => 'username')); ?>
		<?php echo $advform->inputWithDefault('password', 'password', array('label' => false, 'class' => 'text')); ?>
		<?php echo $advform->input('remember', array('type' => 'checkbox', 'label' => 'Keep me logged in for two weeks')); ?>
		<?php echo $advform->submit('Log In'); ?>
		<p id="forgot"><?php echo $html->link('Forgot password?', array('action' => 'forgot')); ?></p>
	</fieldset>
<?php echo $advform->end(); ?>
<p id="notamember">
	<strong>Not a Member?</strong> 
	<?php echo $html->link('Learn more', array('controller' => 'pages', 'action' => 'display', 'features')); ?> or <?php echo $html->link('sign up', array('action' => 'add')); ?>.</span>
</p>
<div class="features">
	<div class="visitor" style="">
		<h2>The simple way to keep everything in sync.</h2>
		<ul>
			<li class="sync">Timesheets, messages, and whatever.  In sync whatever you use.</li>
			<li class="content">Simple, elegant use what the web app was meant to do.</li>
			<li class="everywhere">Open Source. <?php echo $html->link('Create your own bridge', '#'); ?>.</li>
		</ul>
	</div>
</div>
<?php
	echo $javascript->codeBlock('
		$(function() {
			$("#submit").click(function() {
				$("#UserLoginForm").submit();
				return false;
			});
		})
	', array('inline' => false));
?>