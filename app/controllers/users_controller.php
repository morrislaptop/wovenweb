<?php
class UsersController extends AppController {

	var $components = array('Cookie');
	var $uses = array('User', 'Country', 'Timezone');
	var $helpers = array('Advform.Advform');
	
	/**
	* @var AuthComponent
	*/
	var $Auth;
	
	function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('add', 'forgot');
		$this->Auth->fields['username'] = 'email';
		$this->Auth->autoRedirect = false;
		$this->Auth->authenticate = $this;
	}
	
	function hashPasswords($pass) {
		return $pass;
	}
	
	function login() {
		$this->layout = 'login';

		if ($this->Auth->user()) {
			if (!empty($this->data)) {
				$cookie = array();
				$cookie['email'] = $this->data['User']['email'];
				$cookie['password'] = $this->data['User']['password'];
				$this->Cookie->write('Auth.User', $cookie, true, '+2 weeks');
			}
			$this->redirect($this->Auth->redirect());
		}
		if (empty($this->data)) {
			$cookie = $this->Cookie->read('Auth.User');
			if (!is_null($cookie)) {
				if ($this->Auth->login($cookie)) {
					//  Clear auth message, just in case we use it.
					$this->Session->del('Message.auth');
					$this->redirect($this->Auth->redirect());
				}
			}
		}
	}
	
	function logout() {
		$this->Cookie->del('Auth.User');
		$this->redirect($this->Auth->logout());
	}
	
	
	function add() {
		if (!empty($this->data)) {
			$this->User->create();
			if ($this->User->save($this->data)) {
				$this->Auth->login($this->data);
				$this->redirect(array('controller' => 'user_bridges', 'action' => 'select'));
			} else {
				$this->Session->setFlash(__('Sorry, we couldn\'t create your membership.', true), 'default', array('class' => 'error'));
			}
		}
		$this->_setFormData();
	}
	
	function _setFormData() {
		$countries = $this->Country->find('list');
		$timezones = $this->Timezone->find('list');
		$languages = Configure::read('App.languages');
		$this->set(compact('countries', 'timezones', 'languages'));
	}
}
?>
