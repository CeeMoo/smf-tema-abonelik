<?php
/*
Theme System
Version 1
by:ceemoo
http://www.smf.konusal.com
*/
if (!defined('SMF'))
	die('Hacking attempt...');



// Hook Add Action
function temaabone_actions(&$actionArray)
{
	global $sourcedir, $modSettings;

    // Load the language files
    if (loadlanguage('temaabone') == false)
        loadLanguage('temaabone','english');
   
  $actionArray += array('temaabone' => array('temaabone2.php', 'temaaboneMain'));
  
}

function temaabone_menu_buttons(&$menu_buttons)
{
	global $txt, $user_info, $context, $modSettings, $scripturl;
   	loadLanguage('temaabone');

	#You can use these settings to move the button around or even disable the button and use a sub button
	#Main menu button options
	
	#Where the button will be shown on the menu
	$button_insert = 'mlist';
	
	#before or after the above
	$button_pos = 'before';
	#default is before the memberlist
    
    temaabone_array_insert($menu_buttons, $button_insert,
		     array(
                    'temaabone' => array(
    				'title' => $txt['temaabone_menu'],
    				'href' => $scripturl . '?action=temaabone',
    				'show' => true,
    				'icon' => 'temaaboneicon.png',
			    )	
		    )
	    ,$button_pos);
        
 


}

function temaabone_array_insert(&$input, $key, $insert, $where = 'before', $strict = false)
{
	$position = array_search($key, array_keys($input), $strict);
	
	// Key not found -> insert as last
	if ($position === false)
	{
		$input = array_merge($input, $insert);
		return;
	}
	
	if ($where === 'after')
		$position += 1;

	// Insert as first
	if ($position === 0)
		$input = array_merge($insert, $input);
	else
		$input = array_merge(
			array_slice($input, 0, $position),
			$insert,
			array_slice($input, $position)
		);
}


?>