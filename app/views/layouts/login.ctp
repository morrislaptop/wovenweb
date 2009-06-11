<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xml:lang="en" xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>  
    <?php echo $html->charset(); ?>
    <title><?php echo $title_for_layout; ?></title>
    <noscript>
    	<?php echo $html->meta('refresh', array('controller' => 'pages', 'action' => 'display', 'javascript')); ?>
    </noscript>
    <?php echo $html->meta('description', 'Connect your web apps with APIs'); ?>
    <?php echo $javascript->link('jquery'); ?>
    <?php echo $html->css('login'); ?>
    <?php echo $scripts_for_layout; ?>
</head>
<body> 
	<div class="container">
    	<div id="content">
			<?php echo $content_for_layout; ?>
		</div>
		<div id="footer">
    		<ul class="menu">
    			<li><?php echo $html->link('Blog', '/blog/'); ?></li>
    			<li><?php echo $html->link('Terms of Use', array('controller' => 'pages', 'action' => 'display', 'terms')); ?></li>
    			<li><?php echo $html->link('Privacy Policy', array('controller' => 'pages', 'action' => 'display', 'privacy')); ?></li>
    			<li><?php echo $html->link('Help', array('controller' => 'pages', 'action' => 'display', 'help')); ?></li>
    		</ul>
    		<p id="copyright">Copyright &copy; 2009 <?php echo $html->link('WAWW', 'http://waww.com.au'); ?>. All rights reserved.</p>
  		</div>
	</div>
</body>
</html>