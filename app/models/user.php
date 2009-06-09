<?php
class User extends AppModel
{
	var $validate = array(
		'email' => array(
			'email' => array(
				'rule' => 'email',
				'message' => 'Please enter a valid email',
			),
			'isUnique' => array(
				'rule' => 'isUnique',
				'message' => 'Email already registered'
			)
		),
		'password' => array(
			'rule' => 'notEmpty',
			'message' => 'Please enter a password'
		),
		'country' => array(
			'rule' => 'notEmpty',
			'message' => 'Please select your country'
		),
		'timezone' => array(
			'rule' => 'notEmpty',
			'message' => 'Please select your timezone'
		),
		'language' => array(
			'rule' => 'notEmpty',
			'message' => 'Please select your language'
		),
		'confirm_password' => array(
			'rule' => array('equalToField', 'password'),
			'message' => 'Passwords do not match'
		)
	);
	
	function equalToField($data, $field) {
		$value = reset($data);
		if ( $value !== $this->data[$this->alias][$field] ) {
			return false;
		}
		return true;
	}
}
?>
