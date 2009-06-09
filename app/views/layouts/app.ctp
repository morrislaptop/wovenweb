<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<?php echo $html->charset(); ?>
	<title><?php echo $title_for_layout; ?></title>
	<?php echo $html->css('wovenweb'); ?>
	<?php echo $html->css('debug'); ?>
	<?php echo $javascript->link('jquery'); ?>
	<?php echo $scripts_for_layout; ?>
</head>
<body>
<div class="container">
	<div id="header">
		<h1 id="logo">Woven Web</h1>
	</div>
	<div id="content">
		<?php $session->flash(); ?>
		<?php echo $content_for_layout; ?>
	</div>
	<div id="footer">
		<p id="copyright">Copyright &copy; 2009 <?php echo $html->link('WAWW', 'http://waww.com.au'); ?>. All rights reserved.</p>
	</div>
</div>
</body>
</html>