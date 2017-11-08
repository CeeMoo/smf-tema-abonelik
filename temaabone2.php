<?php
/*
Theme System
Version 1
by:ceemoo
http://www.smf.konusal.com
*/
if (!defined('SMF'))
	die('Hacking attempt...');

function temaaboneMain()
{
	global $boardurl, $modSettings, $boarddir, $currentVersion, $context;
	$currentVersion = '2.0';

	if (loadlanguage('temaabone') == false)
		loadLanguage('temaabone','english');
   loadtemplate('temaabone2');

   $context['html_headers'] .='<link rel="stylesheet" type="text/css" href="'. $boardurl. '/Themes/default/css/temaabone.css" />';
	$subActions = array(
		'adminbak' => 'temaabone_adminbak',
		'gndermisise' => 'temaabone_gndermisise',
		'abonegnder' => 'abonegnder',
		'yolla' => 'yolla',
		'basvurusil' => 'basvurusil',
	);

	if (isset($_GET['sa']))
		$sa = $_GET['sa'];
	else
		$sa = '';
		
	if (!empty($subActions[$sa]))
		$subActions[$sa]();
	else
		temaabone_gel();

}

function temaabone_gel(){
	global $context, $scripturl, $mbname, $txt, $modSettings, $user_info, $smcFunc,$sourcedir;

	if(isset($_SESSION)){
		$uye_id = $_SESSION['mc']['id'];
	}

	$abonemi = $smcFunc['db_query']('', "SELECT
		s.id_member, s.status
		FROM {db_prefix}log_subscribed as s
		 LEFT JOIN {db_prefix}members as m ON (m.id_member = s.id_member)
		WHERE s.id_member = $uye_id AND s.status = 1");
	$abone = $smcFunc['db_fetch_assoc']($abonemi);
	$smcFunc['db_free_result']($abonemi);

	if($abone){
		tema_abone();
	}else{
		$dbresult = $smcFunc['db_query']('', "SELECT id_member FROM {db_prefix}temaabone WHERE id_member = '$uye_id'");
		$row = $smcFunc['db_fetch_assoc']($dbresult);
		$smcFunc['db_free_result']($dbresult);

		if($row){
			temaabone_gndermisise();
		}else{
			temaabone_MainView();
		}
	}

}
function tema_abone(){
	global $context, $scripturl, $mbname, $txt, $modSettings, $user_info, $smcFunc,$sourcedir;

	$uye_id = $user_info['id'];

	$abonemi = $smcFunc['db_query']('', "SELECT
		s.id_member, m.real_name, su.name, s.end_time
		FROM {db_prefix}log_subscribed as s
		 LEFT JOIN {db_prefix}members as m ON (s.id_member = m.id_member)
		 LEFT JOIN {db_prefix}subscriptions as su ON (s.id_subscribe = su.id_subscribe)
		WHERE s.id_member = $uye_id AND s.status = 1");
	$abone = $smcFunc['db_fetch_assoc']($abonemi);

	$context['abonemi'] = array(
		'real_name' => $abone['real_name'],
		'name' => $abone['name'],
		'end_date' => $abone['end_time'] == 0 ? 'N/A' : timeformat($abone['end_time'], false),
	);

	$smcFunc['db_free_result']($abonemi);


	$context['page_title'] = $mbname . ' - ' . $txt['temaabone_text_title'];
	$context['sub_template']  = 'abone';
	
}
function temaabone_MainView()
{
	global $context, $scripturl, $mbname, $txt, $modSettings, $user_info, $smcFunc,$sourcedir;

	$context['page_title'] = $mbname . ' - ' . $txt['temaabone_text_title'];
	$context['sub_template']  = 'mainview';

}
function temaabone_adminbak(){
	global $boardurl, $modSettings, $mbname, $boarddir, $currentVersion, $context, $txt, $smcFunc, $user_info;

	if($user_info['is_admin'] == 1){
		$dbresult = $smcFunc['db_query']('', "
		SELECT
			p.id_member, p.id_temaabone, m.real_name, p.temaabonetakim
		FROM {db_prefix}temaabone as p
			LEFT JOIN {db_prefix}members AS m ON  (p.id_member = m.id_member)");

	    $context['temaabone'] = array();

		while($row = $smcFunc['db_fetch_assoc']($dbresult)){
			$context['temaabone'][] = array(
				'id_member' => $row['id_member'],
				'id_temaabone' => $row['id_temaabone'],
				'real_name' => $row['real_name'],
				'temaabonetakim' => $row['temaabonetakim'],
			);
		}
		$smcFunc['db_free_result']($dbresult);


		$dbresult2 = $smcFunc['db_query']('', "
		SELECT s.name, s.id_subscribe FROM {db_prefix}subscriptions as s");

	    $context['subscriptions'] = array();

		while($row = $smcFunc['db_fetch_assoc']($dbresult2)){
			$context['subscriptions'][] = array(
				'id_subscribe' => $row['id_subscribe'],
				'name' => $row['name'],
			);
		}
		$smcFunc['db_free_result']($dbresult2);


		$context['page_title'] = $mbname . ' - ' . $txt['temaabone_text_title'];
		$context['sub_template']  = 'adminbak';
	}else{
		redirectexit('');
	}

}
function yolla(){
	global $boardurl, $modSettings, $mbname, $boarddir, $currentVersion, $context, $txt, $smcFunc;

	$context['page_title'] = $mbname . ' - ' . $txt['temaabone_text_title'];
	$context['sub_template']  = 'yolla';

	if(isset($_REQUEST['subscribe'])){
		$yolla = (int) $_REQUEST['subscribe'];
	}

	redirectexit('action=admin;area=paidsubscribe;sa=modifyuser;sid='.$yolla);
}
function basvurusil(){
	global $boardurl, $modSettings, $mbname, $boarddir, $currentVersion, $context, $txt, $smcFunc;

	$context['page_title'] = $mbname . ' - ' . $txt['temaabone_text_title'];
	$context['sub_template']  = 'basvurusil';

	if(isset($_REQUEST['temaabone'])){
		$sil = (int) $_REQUEST['temaabone'];
	}

	$smcFunc['db_query']('', "DELETE FROM {db_prefix}temaabone WHERE id_temaabone = $sil LIMIT 1");

	redirectexit('action=temaabone;sa=adminbak');
}
function temaabone_gndermisise(){
	global $boardurl, $modSettings, $boarddir, $mbname, $currentVersion, $context, $user_info, $smcFunc, $txt;

	loadlanguage('temaabone');

	$uye_id = $user_info['id'];

	$dbresult = $smcFunc['db_query']('', "
	SELECT
		p.id_member, m.real_name, p.temaabonetakim
	FROM {db_prefix}temaabone as p
		LEFT JOIN {db_prefix}members AS m ON  (p.id_member = m.id_member)
	WHERE p.id_member = $uye_id");

    $row = $smcFunc['db_fetch_assoc']($dbresult);

	// Download information
	$context['temaabone'] = array(
		'id_member' => $row['id_member'],
		'real_name' => $row['real_name'],
		'temaabonetakim' => $row['temaabonetakim'],
	);
	$smcFunc['db_free_result']($dbresult);


	$context['page_title'] = $mbname . ' - ' . $txt['temaabone_text_yatir'];
	$context['sub_template']  = 'gndermisise';
}

function abonegnder(){
	global $txt, $scripturl, $modSettings, $sourcedir, $gd2, $user_info, $smcFunc;

	if(isset($_SESSION)){
		$uye_id = $_SESSION['mc']['id'];
	}

	if(isset($_REQUEST['takim']) & isset($uye_id)){
		$time = time();
		$temaabonetakim = $smcFunc['htmlspecialchars']($_REQUEST['takim'],ENT_QUOTES);
		$id_member = $uye_id;

		// Insert the category
		$smcFunc['db_query']('', "INSERT INTO {db_prefix}temaabone
				(id_member,date,temaabonetakim)
			VALUES ($id_member,$time,'$temaabonetakim')");

		redirectexit('action=temaabone');
	}else{
		redirectexit('action=temaabone');
	}
}


?>
