<?php
/* SVN FILE: $Id: css.php 4853 2007-04-12 08:59:09Z phpnut $ */
/**
 * Short description for file.
 *
 * Long description for file
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework <http://www.cakephp.org/>
 * Copyright 2005-2007, Cake Software Foundation, Inc.
 *								1785 E. Sahara Avenue, Suite 490-204
 *								Las Vegas, Nevada 89104
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright		Copyright 2005-2007, Cake Software Foundation, Inc.
 * @link				http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package			cake
 * @subpackage		cake.app.webroot
 * @since			CakePHP(tm) v 0.2.9
 * @version			$Revision: 4853 $
 * @modifiedby		$LastChangedBy: phpnut $
 * @lastmodified	$Date: 2007-04-12 03:59:09 -0500 (Thu, 12 Apr 2007) $
 * @license			http://www.opensource.org/licenses/mit-license.php The MIT License
 */
if (!defined('CAKE_CORE_INCLUDE_PATH')) {
	header('HTTP/1.1 404 Not Found');
	exit('File Not Found');
}
/**
 * Enter description here...
 */
	uses('file');
/**
 * Enter description here...
 *
 * @param unknown_type $path
 * @param unknown_type $name
 * @return unknown
 */
	function make_clean_css($path, $name) {
		require(VENDORS . 'csspp' . DS . 'csspp.php');
		$data = file_get_contents($path);
		$csspp = new csspp();
		$output = $csspp->compress($data);
		$ratio = 100 - (round(strlen($output) / strlen($data), 3) * 100);
		$output = " /* file: $name, ratio: $ratio% */ " . $output;
		return $output;
	}
/**
 * Enter description here...
 *
 * @param unknown_type $path
 * @param unknown_type $content
 * @return unknown
 */
	function write_css_cache($path, $content) {
		if (!is_dir(dirname($path))) {
			mkdir(dirname($path));
		}
		$cache = new File($path);
		return $cache->write($content);
	}
	
	$urls = explode(',', $url);
	$output = '';
	$templateModified = null;
	foreach ($urls as $url)
	{
		if (preg_match('|\.\.|', $url) || !preg_match('|^ccss/(.+)$|i', $url, $regs)) {
			$regs = array(1 => $url);
		}
		if ( '.css' !== substr($regs[1], -4) ) {
			$regs[1] .= '.css';
		}
	
		$filename = 'css/' . $regs[1];
		$filepath = CSS . $regs[1];
		$cachepath = CACHE . 'css' . DS . str_replace(array('/','\\'), '-', $regs[1]);
	
		if (!file_exists($filepath)) {
			die('Wrong file path: ' . $filepath);
		}
		
		if ( !Configure::read('Asset.compress.css') ) {
			$file = file_get_contents($filepath);
			$output .= $file;
			$templateModified = max($templateModified, filemtime($filepath));
			continue;
		}
	
		if (file_exists($cachepath)) {
			$templateModified = filemtime($filepath);
			$cacheModified = filemtime($cachepath);
	
			if ($templateModified > $cacheModified) {
				$file = make_clean_css($filepath, $filename);
				write_css_cache($cachepath, $file);
			} else {
				$file = file_get_contents($cachepath);
			}
		} else {
			$file = make_clean_css($filepath, $filename);
			write_css_cache($cachepath, $file);
			$templateModified = time();
		}
		$output .= $file;
	}

	header("Date: " . date("D, j M Y G:i:s ", $templateModified) . 'GMT');
	header("Content-Type: text/css");
	header("Expires: " . gmdate("D, j M Y H:i:s", time() + DAY) . " GMT");
	header("Cache-Control: cache"); // HTTP/1.1
	header("Pragma: cache");        // HTTP/1.0
	print $output;
?>