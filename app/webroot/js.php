<?php
/* SVN FILE: $Id: css.php 4852 2007-04-12 08:49:49Z phpnut $ */
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
 * @version			$Revision: 4852 $
 * @modifiedby		$LastChangedBy: phpnut $
 * @lastmodified	$Date: 2007-04-12 03:49:49 -0500 (Thu, 12 Apr 2007) $
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
 
	function make_clean_js($path, $name) {
		$data = file_get_contents($path);
		
		#$csspp = new csspp();
		#$output = $csspp->compress($data);
		$packer = new JavaScriptPacker($data, 'Normal', true, false);
		$packed = $packer->pack();
		
		$ratio = 100 - (round(strlen($packed) / strlen($data), 3) * 100);
		$packed = " /* file: $name, ratio: $ratio% */ " . $packed;
		return $packed;
	}
/**
 * Enter description here...
 *
 * @param unknown_type $path
 * @param unknown_type $content
 * @return unknown
 */
	function write_js_cache($path, $content) {
		if (!is_dir(dirname($path))) {
			mkdir(dirname($path));
		}
		$cache = new File($path);
		return $cache->write($content);
	}
	
	require(VENDORS . 'class.JavaScriptPacker.php');
	$urls = explode(',', $url);
	$output = '';
	$templateModified = null;
	foreach ($urls as $url)
	{
		if (preg_match('|\.\.|', $url) || !preg_match('|^cjs/(.+)$|i', $url, $regs)) {
			$regs = array(1 => $url);
		}
		if ( '.js' !== substr($regs[1], -3) ) {
			$regs[1] .= '.js';
		}
	
		$filename = 'js/' . $regs[1];
		$filepath = JS . $regs[1];
		$cachepath = CACHE . 'js' . DS . str_replace(array('/','\\'), '-', $regs[1]);
	
		if (!file_exists($filepath)) {
			die('Wrong file path: ' . $filepath);
		}
		
		if ( !Configure::read('Asset.compress.js') ) {
			$file = file_get_contents($filepath);
			$output .= $file;
			$templateModified = max($templateModified, filemtime($filepath));
			continue;
		}
	
		if (file_exists($cachepath)) {
			$templateModified = filemtime($filepath);
			$cacheModified = filemtime($cachepath);
	
			if ($templateModified > $cacheModified) {
				$file = make_clean_js($filepath, $filename);
				write_js_cache($cachepath, $file);
			} else {
				$file = file_get_contents($cachepath);
			}
		} else {
			$file = make_clean_js($filepath, $filename);
			write_js_cache($cachepath, $file);
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