<?php
/* SVN FILE: $Id: app_controller.php 7062 2008-05-30 11:29:53Z nate $ */
/**
 * Short description for file.
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework <http://www.cakephp.org/>
 * Copyright 2005-2008, Cake Software Foundation, Inc.
 *								1785 E. Sahara Avenue, Suite 490-204
 *								Las Vegas, Nevada 89104
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright		Copyright 2005-2008, Cake Software Foundation, Inc.
 * @link				http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package			cake
 * @subpackage		cake.app
 * @since			CakePHP(tm) v 0.2.9
 * @version			$Revision: 7062 $
 * @modifiedby		$LastChangedBy: nate $
 * @lastmodified	$Date: 2008-05-30 21:29:53 +1000 (Fri, 30 May 2008) $
 * @license			http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 * Short description for class.
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		cake
 * @subpackage	cake.app
 */
class AppController extends Controller {
	
	var $layout = 'app';
	var $helpers = array('Html', 'Form', 'Javascript');
	var $components = array('Auth', 'RequestHandler', 'DebugKit.Toolbar' => array('history' => false));
	
	/**
	* @var AuthComponent
	*/
	var $Auth;
	
	function beforeFilter() {
		$this->Auth->loginAction = array('plugin' => null, 'controller' => 'users', 'action' => 'login');
	}
	
	function beforeRender() {
		$this->sensitiveDebug();
	}
	
	function sensitiveDebug() {
		$sensitive = array(
			'json',
			'xml'
		);
		if ( $this->RequestHandler->isAjax() || in_array($this->params['url']['ext'], $sensitive) ) {
			Configure::write('debug', 0);
		}
	}
}
?>