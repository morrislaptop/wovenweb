<?php
class UserBridge extends AppModel
{
	var $name = 'UserBridge';
	var $belongsTo = array(
		'User',
		'Bridge'
	);
	
	function beforeSave() {
		if ( !empty($this->data['UserBridge']['app1data']) && !is_string($this->data['UserBridge']['app1data']) ) {
			$this->data['UserBridge']['app1data'] = serialize($this->data['UserBridge']['app1data']);
		}
		if ( !empty($this->data['UserBridge']['app2data']) && !is_string($this->data['UserBridge']['app2data']) ) {
			$this->data['UserBridge']['app2data'] = serialize($this->data['UserBridge']['app2data']);
		}
		return parent::beforeSave();
	}
	
	function afterFind($results) {
		foreach ($results as &$result) {
			if ( !empty($result['UserBridge']['app1data']) ) {
				$result['UserBridge']['app1data'] = unserialize($result['UserBridge']['app1data']);
			}
			if ( !empty($result['UserBridge']['app2data']) ) {
				$result['UserBridge']['app2data'] = unserialize($result['UserBridge']['app2data']);
			}
		}
		return $results;
	}
}
?>