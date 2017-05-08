<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) PHP-Fusion Inc
| https://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: add_server.php
| Author: Keddy
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/
require_once "../../maincore.php";
require_once THEMES."templates/header.php";

include INFUSIONS."cs_panel/infusion_db.php";

if (file_exists(INFUSIONS."cs_panel/locale/".$settings['locale'].".php")) {
	include INFUSIONS."cs_panel/locale/".$settings['locale'].".php";
} else {
	include INFUSIONS."cs_panel/locale/English.php";
}
if (!iMEMBER) redirect(BASEDIR."index.php");

if (isset($_GET['status']) && !isset($message)) {
	if ($_GET['status'] == "sn") {
		openside($locale['csp_118']);
		$message .= $locale['csp_163'];
		$message .= "<center>".$locale['csp_119a']."</center>";
		$message .= "<center><a href='".FUSION_SELF."'>".$locale['csp_111']."</a>&nbsp;&nbsp;<a href='".BASEDIR."news.php'>".$locale['csp_112']."</a></center>";
	} elseif ($_GET['status'] == "se") {
		openside($locale['csp_118']);
		$message .= "<b><center>".$locale['csp_119b']."</center></B>";
		$message .= "<center><a href='".FUSION_SELF."'>".$locale['csp_111']."</a>&nbsp;&nbsp;<a href='".BASEDIR."news.php'>".$locale['csp_112']."</a></center>";
	}
	
	if ($message) {	echo "<div id='close-message'><div class='admin-message'>".$message."</div></div>\n"; }
}

        

if (isset($_POST['submit']) && !isset($message)) {
		
	
    $ip = stripinput(trim($_POST['ip']));
    $port = isset($_POST['port']) && isNum($_POST['port'])  ? $_POST['port'] : "27015";
    $player = isset($_POST['player']) && isNum($_POST['player']) ? $_POST['player'] : "20";
    $cod = isset($_POST['cod']) && isNum($_POST['cod']) ? $_POST['cod'] : "0";
    $modul = isset($_POST['modul']) && isNum($_POST['modul']) ? $_POST['modul'] : "0";
	$type = isset($_POST['type']) && isNum($_POST['type']) ? $_POST['type'] : "0";
    $sorder = isset($_POST['sorder']) && isNum($_POST['sorder']) ? $_POST['sorder'] : "";
	if(!$sorder) $sorder=dbresult(dbquery("SELECT MAX(sorder) FROM ".DB_SERVER),0)+1;
	$result = dbquery("INSERT INTO ".DB_SERVER." (id, ip, port, player, cod, modul, type, sorder) VALUES (NULL, '$ip', '$port', '$player', '$cod', '$modul', '$type', '$sorder')");
        if ($result) {
			redirect(FUSION_SELF.$aidlink."&status=sn");            	
		} else {
		    redirect(FUSION_SELF.$aidlink."&status=se");            	
		}

} elseif (!isset($message)) {
            openside($locale['csp_118']);  
            echo "<table border='0' class='margins' cellspacing=1 cellpadding=0 align=center>\n";
            echo "<tr align=center><td align=center>\n";
            echo "<table width='100%' cellspacing=1 cellpadding=0 align='center'>\n";
            echo "<tr align=center>\n<td align=center>\n";
            echo "<form name='add_server' action='".FUSION_SELF."' method='post' onSubmit='return ValidateForm(this)'>\n";
            echo "<table width='600' border='0' align='center' cellpadding='2' cellspacing='0'>\n";
            
            echo "<tr>\n<td width='42%' align='right'>\n".$locale['csp_103']."&nbsp;<span style='color:#ff0000'>*</span></td>\n";
            echo "<td width='58%'>\n<input class=textbox name='ip' type='textbox' size='20' id='ip' required></td>\n";
            echo "</tr>\n<tr>\n";
            echo "<td width='42%' align='right'>\n".$locale['csp_104']."&nbsp;<span style='color:#ff0000'>*</span></td>\n";
            echo "<td>\n<input class=textbox name='port' type='text' size='7' id='port' value='27015'></td>\n";
            echo "</tr>\n<tr>\n";
            echo "<td align='right'>\n".$locale['csp_105']."</td>\n";
            echo "<td>\n<select class=textbox name='player' id='player'>\n";
            echo "<option value=''>-----------------</option>\n";
           foreach($play as $key => $value){
            echo '<option value="'.$key.'">'.$value.'</option>';
			}
            echo "</select>\n</td>\n";
            echo "</tr>\n<tr>\n";
            echo "<td align='right'>\n".$locale['csp_106']."</td>\n";
			echo "<td>\n<select class=textbox name='cod' id='cod'>\n";
            echo "<option value=''>-----------------</option>\n";
			foreach($code as $key => $value){
            echo '<option value="'.$key.'">'.$value.'</option>';
			}
			echo "</select>\n</td>\n";
            echo "</tr>\n<tr>\n";
            echo "<td align='right'>\n".$locale['csp_107']."</td>\n";
			echo "<td>\n<select class=textbox name='modul' id='modul'>\n";
			echo "<option value=''>-----------------</option>\n";
			foreach($mod as $key => $value){
            echo '<option value="'.$key.'">'.$value.'</option>';
			}
			echo "</select>\n</td>\n";
			echo "</tr>\n<tr>\n";
            echo "<td align='right'>\n".$locale['csp_108']."</td>\n";
			echo "<td>\n<select class=textbox name='type' id='type'>\n";
			echo "<option value=''>-----------------</option>\n";
			foreach($typ as $key => $value){
            echo '<option value="'.$key.'">'.$value.'</option>';
			}
			echo "</select>\n</td>\n";
			echo "</tr>\n<tr>\n";
			echo "<td width='42%' align='right'>\n".$locale['csp_164']."</td>\n";
            echo "<td>\n<input class=textbox name='sorder' type='text' size='7' id='sorder'></td>\n";
            echo "</tr>\n<tr>\n";
			echo "<td colspan='2' align='center'>\n<input type='submit' name='submit' value='".$locale['csp_118']."' class='button'></td>\n";
			echo "</tr>\n</table>\n</form>\n";
			echo "</td>\n</tr>\n</table>\n";
			
   closeside(); 
	
} 
closeside();
require_once THEMES."templates/footer.php";
?>