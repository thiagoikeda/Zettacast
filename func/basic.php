<?php

/**
 * @brief
 */
namespace Basic;

function addfunc($name) {
	
	$fn = FUNC."/{$name}.php";
	$exist = file_exists($fn);
	
	$exist ? include_once $fn : false;
	return $exist;
		
}

function addcss($link, $media = 'all') {

	\Kernel::$data['__css'][] = [\URI::base()."/css/{$link}.css", $media];
	
}

function addjs($link) {

	\Kernel::$data['__js'][] = \URI::base()."/js/{$link}.js";
	
}

function linkcss() {
	
	if(!isset(\Kernel::$data['__css'])):
		return;
	endif;
	
	foreach(\Kernel::$data['__css'] as $css):
		list($link, $media) = $css;
		?><link rel="stylesheet" type="text/css" href="<?= $link ?>" media="<?= $media ?>" /><?php
	endforeach;
	
}

function linkjs() {
	
	if(!isset(\Kernel::$data['__js'])):
		return;
	endif;
	
	foreach(\Kernel::$data['__js'] as $js):
		?><script type="text/javascript" src="<?= $js ?>"></script><?php
	endforeach;
	
}

function registermodule($module, $cssmedia = 'all') {
	
	if($cssmedia):
		addcss($module, $cssmedia);
	endif;
	
	\Kernel::$data['__module'][$module] = true;
	
}

function callmodule($module) {
	
	$fn = \PAGE."/{$module}/module.php";
	
	if(!file_exists($fn)):
		return false;
	endif;
	
	if(@\Kernel::$data['__module'][$module]):
		require_once \PAGE."/{$module}/module.php";
	endif;
	
}