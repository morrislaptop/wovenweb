<?php
class Bridge extends AppModel
{
	var $belongsTo = array(
		'FromApp' => array(
			'className' => 'Application',
			'foreignKey' => 'app1_id'
		),
		'ToApp' => array(
			'className' => 'Application',
			'foreignKey' => 'app2_id'
		)
	);
}
?>
