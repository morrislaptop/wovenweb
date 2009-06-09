<?php
class UserBridge extends AppModel
{
	var $name = 'UserBridge';
	var $belongsTo = array(
		'User',
		'Bridge'
	);
}
?>