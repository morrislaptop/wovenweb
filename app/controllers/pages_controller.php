<?php
/* SVN FILE: $Id: pages_controller.php 7062 2008-05-30 11:29:53Z nate $ */
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
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
 * @subpackage		cake.cake.libs.controller
 * @since			CakePHP(tm) v 0.2.9
 * @version			$Revision: 7062 $
 * @modifiedby		$LastChangedBy: nate $
 * @lastmodified	$Date: 2008-05-30 21:29:53 +1000 (Fri, 30 May 2008) $
 * @license			http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package		cake
 * @subpackage	cake.cake.libs.controller
 */
class PagesController extends AppController {
/**
 * Controller name
 *
 * @var string
 * @access public
 */
	var $name = 'Pages';
/**
 * Default helper
 *
 * @var array
 * @access public
 */
	var $helpers = array('Html', 'NiceHead');
/**
 * This controller does not use a model
 *
 * @var array
 * @access public
 */
	var $uses = array();
/**
 * Set of instruction files. First is key, second is label.
 *
 * @var array
 */
	var $instructions = array(
		'macosx-firefox-3' => array('label' => 'Firefox 3'),
		'ie-6' => array('label' => 'Internet Explorer 6', 'img' => 'ie-6'),
		'ie-7' => array('label' => 'Internet Explorer 7', 'img' => 'ie-7'),
		'safari-3' => array('label' => 'Safari'),
		'opera' => array('label' => 'Opera')
	);
/**
 * Links the os, browser, and version to an instruction element.
 *
 * @var array
 */
	var $browser_to_instructions = array(
		'macosx-firefox-3' => 'macosx-firefox-3',
		'winvista-firefox-3' => 'firefox-3',
		'linux-firefox-3' => 'firefox-3',
		'winxp-ie-6' => 'ie-6',
		'winxp-ie-7' => 'ie-7',
		'winvista-ie-7' => 'ie-7',
		'macosx-safari-3' => 'safari-3',
	);
/**
 * Redirects to the appropriate page
 *
 * @var array
 */
	function home() 
	{
		if ( false ) {
			App::import('Vendor', 'BrowserInfo', array('file' => 'class.browser_info.php'));
			$browser_info = new BrowserInfo($_SERVER["HTTP_USER_AGENT"]);
			$browser_id = strtolower(Inflector::slug($browser_info->OS_Version . ' ' . $browser_info->Browser . ' ' . $browser_info->Browser_Version));
		}
		else if ( true ) {
			App::import('Vendor', 'Browscap' , array('file' => 'Browscap.php'));
			$bc = new Browscap(CACHE);
			$browser_info = $bc->getBrowser();
			$browser_id = strtolower(Inflector::slug($browser_info->Platform . ' ' . $browser_info->Browser . ' ' . $browser_info->MajorVer));
		}
		else {
			$browser_info = get_browser();
			$browser_id = strtolower(Inflector::slug($browser_info->platform . ' ' . $browser_info->browser . ' ' . $browser_info->majorver));
			#debug($browser_info);
		}
		
		if ( !isset($this->browser_to_instructions[$browser_id]) ) {
			$this->redirect('/unknown');
		}
		else {
			$this->redirect('/clear-cache-' . $browser_id);
		}
		exit;
	}
/**
 * Displays a view
 *
 * @param mixed What page to display
 * @access public
 */
	function display() 
	{
		$this->set('browser_to_instructions', $this->browser_to_instructions);
		$this->set('instructions', $this->instructions);
		
		$path = func_get_args();

		if (!count($path)) {
			$this->redirect('/');
		}
		$count = count($path);
		$page = $subpage = $title = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title = Inflector::humanize($path[$count - 1]);
		}
		$this->set(compact('page', 'subpage', 'title'));
		$this->render(join('/', $path));
	}
	
	function _onUnknownBrowser() {
	
	}
}

?>