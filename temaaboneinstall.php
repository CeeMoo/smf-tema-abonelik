<?php
/*
Theme System
Version 1
by:ceemoo
http://www.smf.konusal.com
*/
// If SSI.php is in the same place as this file, and SMF isn't defined, this is being run standalone.
if (file_exists(dirname(__FILE__) . '/SSI.php') && !defined('SMF'))
  require_once(dirname(__FILE__) . '/SSI.php');
elseif (!defined('SMF'))
  die('<b>Error:</b> Cannot install - please verify you put this in the same place as SMF\'s index.php.');
  
global $smcFunc;
db_extend('Packages');
db_extend('Extra');
$hook_functions = array(
		'integrate_pre_include' => '$sourcedir/temaaboneHooks.php',
	    'integrate_menu_buttons' => 'temaabone_menu_buttons',
		'integrate_actions' => 'temaabone_actions',
);

// Adding or removing them?
if (!empty($context['uninstalling']))
	$call = 'remove_integration_function';
else
	$call = 'add_integration_function';

foreach ($hook_functions as $hook => $function)
	$call($hook, $function);
	
$smcFunc['db_create_table']('{db_prefix}temaabone', array(
	array('name' => 'id_temaabone', 'type' => 'int', 'size' => 11,'null' => false, 'auto' => true),
	array('name' => 'id_member', 'type' => 'mediumint', 'size' => 8,'null' => false, 'default' => 0),
	array('name' => 'date', 'type' => 'int', 'size' => 11,'unsigned' => true,'null' => false, 'default' => 0),
	array('name' => 'temaabonetakim', 'type' => 'varchar', 'size' => 255,),
	),
	array(array('type' => 'primary', 'columns' => array('id_temaabone')),)
);

?>