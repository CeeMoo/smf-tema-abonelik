<?php
/*
Theme System
Version 1
by:ceemoo
http://www.smf.konusal.com
*/
function template_mainview()
{
	global $scripturl, $txt, $context, $modSettings, $subcats_linktree, $user_info, $boardurl;

	if(!$user_info['is_guest']){
		abonelikritmi();
	}else{
		ziyaretci();
	}
}

function template_abone(){
	global $scripturl, $txt, $context, $modSettings, $subcats_linktree, $user_info, $boardurl;

	echo "
	<div class='up_contain yazicim'>{$txt['substskler']} <strong>{$context['abonemi']['real_name']}</strong> {$txt['subbitis']} <strong>{$context['abonemi']['end_date']}</strong></div>";

}
function template_gndermisise(){
	global $scripturl, $txt, $context, $modSettings, $subcats_linktree, $user_info, $boardurl;

	if($context['temaabone']['temaabonetakim'] == 'elmas'){
		$tematakim = $txt['elmastakim'];
		$temaallink = "<a href='https://iyzi.link/AACKYw'>https://iyzi.link/AACKYw</a>";
	}elseif($context['temaabone']['temaabonetakim'] == 'altin'){
		$tematakim = $txt['altintakim'];
		$temaallink = "<a href='https://iyzi.link/AACKXg'>https://iyzi.link/AACKXg</a>";
	}else{
		$tematakim = $txt['gmstakim'];
		$temaallink = "<a href='https://iyzi.link/AACKaA'>https://iyzi.link/AACKaA</a>";
	}

	echo "
	<div class='cat_bar'><h3 class='catbg'>{$tematakim}</h3></div>
	<div class='up_contain yazicim'><strong>{$context['temaabone']['real_name']}</strong> {$txt['dememesaj']} <p>{$tematakim} {$temaallink}</p></div>";

	echo '
	<div class="ortalan">
		<img src="'.$boardurl.'/Themes/default/images/iyzico.svg" alt="iyzico" />
		<img class="master" src="'.$boardurl.'/Themes/default/images/mastercard.svg" alt="mastercard" />
		<img src="'.$boardurl.'/Themes/default/images/visa.svg" alt="visa" />
		<img src="'.$boardurl.'/Themes/default/images/ssl.svg" alt="ssl" />
	</div>
	';

}
function template_adminbak(){
	global $scripturl, $txt, $context, $modSettings, $subcats_linktree, $user_info, $boardurl;

	echo '<div class="cat_bar"><h3 class="catbg">Başvuruları Onayla</h3></div>';
	foreach($context['temaabone'] as $i => $row){
		echo '
		<form action="', $scripturl, '?action=temaabone&sa=yolla" method="post">
			<div class="up_contain">
				<div class="board_icon">'.$row['id_temaabone'].'</div>
				<div class="info">'.$row['real_name'].'</div>
				<div class="board_stats">'.$row['temaabonetakim'].'</div>
				<div class="lastpost">
				<a class="button" href="' . $scripturl . '?action=temaabone;sa=basvurusil;temaabone='.$row['id_temaabone'].'">Sil</a>
					<select name="subscribe" id="subscribe">';
					foreach($context['subscriptions'] as $i => $row){
						echo '<option value="'.$row['id_subscribe'].'">'.$row['name'].'</option>';					
					}
				echo '
					</select>
				<button class="button" type="submit">Ekle</button>
				</div>
			</div>
		</form>';
	}
}
function template_yolla(){
	global $scripturl, $txt, $context, $modSettings, $subcats_linktree, $user_info, $boardurl;
}
function template_basvurusil(){
	global $scripturl, $txt, $context, $modSettings, $subcats_linktree, $user_info, $boardurl;
}

function abonelikritmi(){
	global $scripturl, $txt, $context, $modSettings, $subcats_linktree, $user_info, $boardurl;

	if($user_info['is_admin'] == 1){
		echo '<a href="', $scripturl, '?action=temaabone;sa=adminbak">Başvurular</a>';
	}

echo '<form method="post" enctype="multipart/form-data" name="abonegnder" id="abonegnder" action="' . $scripturl . '?action=temaabone;sa=abonegnder">';
	echo "
	<div class='progress'>
	  <div class='progress_inner'>
	    <div class='progress_inner__step'>
	      <label for='step-1'>{$txt['takimsec']}</label>
	    </div>
	    <div class='progress_inner__step'>
	      <label for='step-2'>{$txt['szlesmeh1']}</label>
	    </div>
	    <div class='progress_inner__step'>
	      <label for='step-3'>{$txt['bilgionayla']}</label>
	    </div>
	    <input checked='checked' id='step-1' name='step' type='radio'>
	    <input id='step-2' name='step' type='radio'>
	    <input id='step-3' name='step' type='radio'>
	    <input id='step-4' name='step' type='radio'>
	    <input id='step-5' name='step' type='radio'>
	    <div class='progress_inner__bar'></div>
	    <div class='progress_inner__bar--set'></div>
	    <div class='progress_inner__tabs'>
	      <div class='tab tab-0'>
	      	<div class='width33'>
				<div class='cat_bar'><h3 class='catbg'>{$txt['gmstakim']}</h3></div>
				<div class='up_contain'><strong class='para'>20Try</strong></div>
				<div class='up_contain iconuzun'><img src='$boardurl/tema/catimgs/2.png' alt=''></div>
				<div class='up_contain'>{$txt['biray']}</div>
				<div class='up_contain'><label class='takimsec button'><input type='radio' name='takim' value='gümüs' />{$txt['gmstakim']} {$txt['sec']}</label></div>
	      	</div>
	
	      	<div class='width33'>
				<div class='cat_bar'><h3 class='catbg'>{$txt['altintakim']}</h3></div>
				<div class='up_contain'><strong class='para'>30Try</strong></div>
				<div class='up_contain iconuzun'><img src='$boardurl/tema/catimgs/3.png' alt=''></div>
				<div class='up_contain'>{$txt['biray']}</div>
				<div class='up_contain'><label class='takimsec button'><input type='radio' name='takim' value='altin' />{$txt['altintakim']} {$txt['sec']}</label></div>
	      	</div>
	
	      	<div class='width33'>
				<div class='cat_bar'><h3 class='catbg'>{$txt['elmastakim']}</h3></div>
				<div class='up_contain'><strong class='para'>40Try</strong></div>
				<div class='up_contain iconuzun'><img src='$boardurl/tema/catimgs/4.png' alt=''></div>
				<div class='up_contain'>{$txt['biray']}</div>
				<div class='up_contain'><label class='takimsec button'><input type='radio' name='takim' value='elmas' />{$txt['elmastakim']} {$txt['sec']}</label></div>
	      	</div>	
	      </div>
	      <div class='tab tab-1'>
	       	".$txt["szlesme"]." 
	      </div>
	      <div class='tab tab-2'>
	        {$txt["onay"]}
	        <button class='button' type='submit'>".$txt["gnder"]."</button>
	      </div>
	    </div>
	    <div class='progress_inner__status'>
	      <div class='box_base'></div>
	      <div class='box_lid'></div>
	      <div class='box_ribbon'></div>
	      <div class='box_bow'>
	        <div class='box_bow__left'></div>
	        <div class='box_bow__right'></div>
	      </div>
	      <div class='box_item'></div>
	      <div class='box_tag'></div>
	      <div class='box_string'></div>
	    </div>
	  </div>
	</div>
</form>";
}
function ziyaretci(){
	global $txt, $boardurl;

	echo '<div class="ziyaretci">'.$txt['temaabone_kayityap'].'</div>';
	echo "
	<div class='tab tab-0'>
		<div class='width33'>
			<div class='cat_bar'><h3 class='catbg'>{$txt['gmstakim']}</h3></div>
			<div class='up_contain'><strong class='para'>20Try</strong></div>
			<div class='up_contain iconuzun'><img src='$boardurl/tema/catimgs/2.png' alt=''></div>
			<div class='up_contain'>{$txt['biray']}</div>
			<div class='up_contain'>{$txt['temaabone_kayitl']}</div>
		</div>

		<div class='width33'>
			<div class='cat_bar'><h3 class='catbg'>{$txt['altintakim']}</h3></div>
			<div class='up_contain'><strong class='para'>30Try</strong></div>
			<div class='up_contain iconuzun'><img src='$boardurl/tema/catimgs/3.png' alt=''></div>
			<div class='up_contain'>{$txt['biray']}</div>
			<div class='up_contain'>{$txt['temaabone_kayitl']}</div>
		</div>

		<div class='width33'>
			<div class='cat_bar'><h3 class='catbg'>{$txt['elmastakim']}</h3></div>
			<div class='up_contain'><strong class='para'>40Try</strong></div>
			<div class='up_contain iconuzun'><img src='$boardurl/tema/catimgs/4.png' alt=''></div>
			<div class='up_contain'>{$txt['biray']}</div>
			<div class='up_contain'>{$txt['temaabone_kayitl']}</div>
		</div>	
	</div>";
}

?>