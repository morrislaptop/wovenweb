<?php
class UserBridgesController extends AppController {

	var $name = 'UserBridges';
	
	/**
	* @var UserBridge
	*/
	var $UserBridge;
	
	function select() {
		// get all bridges installed.
		$contain = array('FromApp', 'ToApp');
		$bridges = $this->UserBridge->Bridge->find('all', compact('contain'));
		
		// for each bridge add the user's instances of these bridges.
		foreach ($bridges as &$bridge)
		{
			$conditions = array(
				'bridge_id' => $bridge['Bridge']['id'],
				'user_id' => $this->Auth->user('id')
			);
			$contain = array();
			$bridge['UserBridge'] = $this->UserBridge->find('all', compact('conditions', 'contain'));
		}
		
		$this->set(compact('bridges'));
	}
	
	function delete($id)
	{
		if ( $this->UserBridge->delete($id) ) {
			$this->redirect(array('action' => 'select'));
		}
	}
	
	/**
	* Creates a user bridge record then redirects to the plugin with the new id
	* to configure the rest.
	* 
	* @param mixed $bridge_id
	*/
	function add($bridge_id) {
		// 1. Save
		$data = array(
			'bridge_id' => $bridge_id,
			'user_id' => $this->Auth->user('id'),
		);
		$this->UserBridge->save($data);
		
		// 2. Redirect to configure
		$this->redirect(array_merge($this->_getPluginRedirectArray($this->UserBridge->id), array('action' => 'configure', $id)));
	}
	
	function configure($id) {
		$this->redirect(array_merge($this->_getPluginRedirectArray($id), array('action' => 'configure', $id)));
	}
	
	function view_log($id) {
		$this->redirect(array_merge($this->_getPluginRedirectArray($id), array('action' => 'view_log', $id)));
	}
	
	function _getPluginRedirectArray($user_bridge_id)
	{
		$this->UserBridge->contain(array('Bridge' => array('FromApp', 'ToApp')));
		$user_bridge = $this->UserBridge->read(null, $user_bridge_id);
		$plugin = strtolower($user_bridge['Bridge']['FromApp']['name'] . '_' . $user_bridge['Bridge']['ToApp']['name']);
		$url = array(
			'plugin' => $plugin,
			'controller' => $plugin . '_logs',
		);
		return $url;
	}

}
?>