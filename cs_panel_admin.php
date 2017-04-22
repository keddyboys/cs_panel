<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) PHP-Fusion Inc
| https://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: cs_panel_admin.php
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
require_once THEMES."templates/admin_header.php";
if (!defined("IN_FUSION")) { die("Access Denied"); }

include INFUSIONS."cs_panel/infusion_db.php";

if (file_exists(INFUSIONS."cs_panel/locale/".$settings['locale'].".php")) {
	include INFUSIONS."cs_panel/locale/".$settings['locale'].".php";
} else {
	include INFUSIONS."cs_panel/locale/English.php";
}
error_reporting(E_ERROR | E_WARNING | E_PARSE);
if (!isset($_GET['rowstart']) || !isNum($_GET['rowstart'])) $_GET['rowstart'] = 0;
$page=10;
$num = dbcount("(id)", DB_SERVER);
//print_r($_POST['ids']); 
/*if (isset($_GET['action']) && $_GET['action'] == "deleteall") {
	for($i=0;$i<$num;$i++){
	$del_id = isset($_POST['checkbox'][$i]) ? $_POST['checkbox'][$i] : "";
	$ids = $_POST['checkbox'][$i]; 
	echo $ids;
	}
} else*/
if ((isset($_GET['action']) && $_GET['action'] == "delete") && (isset($_GET['id']) && isnum($_GET['id']))) {
        //for($i=0;$i<$num;$i++){
			
	        //$del_id = isset($_GET['checkbox'][$i]) ? $_GET['checkbox'][$i] : "";
            $result = dbquery("DELETE FROM ".DB_SERVER." WHERE id='".$_GET['id']."'");
			redirect(FUSION_SELF.$aidlink);
        //}
		
} else {
     
        if (isset($_POST['save'])) {
        	$ip = stripinput(trim($_POST['ip']));
            $port = isset($_POST['port']) && isNum($_POST['port'])  ? $_POST['port'] : "27015";
            $player = isset($_POST['player']) && isNum($_POST['player']) ? $_POST['player'] : "20";
            $cod = isset($_POST['cod']) && isNum($_POST['cod']) ? $_POST['cod'] : "0";
            $modul = isset($_POST['modul']) && isNum($_POST['modul']) ? $_POST['modul'] : "0";
    		$result = dbquery("UPDATE ".DB_SERVER." SET ip='$ip', port='$port', player='$player', cod='$cod', modul='$modul' WHERE id='".$_GET['id']."'");
			redirect(FUSION_SELF.$aidlink);
		}	
		
    if ((isset($_GET['action']) && $_GET['action'] == "edit") && (isset($_GET['id']) && isnum($_GET['id']))) {
		$result = dbquery("SELECT * FROM ".DB_SERVER." WHERE id='".$_GET['id']."'");
		if (dbrows($result)) {
			$data = dbarray($result);
		$ip = $data['ip'];	
		$port = $data['port'];	
		$player = $data['player'];
		$cod = $data['cod'];
		$modul = $data['modul'];
		$formaction = FUSION_SELF.$aidlink."&amp;action=edit&amp;id=".$_GET['id'];
		$open = $locale['csp_114'];
		openside($open);
            echo "<div style='text-align:center'>".$locale['csp_115'] ."&nbsp;".$num."&nbsp;".$locale['csp_116']."</div>\n";
            echo "<table width='100%' cellspacing=1 cellpadding=0 align='center'>\n";
            echo "<tr align=center>\n<td align=center>\n";
            
            echo "<table width='600' border='0' align='center' cellpadding='2' cellspacing='0'>\n";
            echo "<form name='addcat' method='post' action='$formaction'>\n";

            echo "<tr>\n<td width='42%' align='right'>\n".$locale['csp_103']."&nbsp;<span style='color:#ff0000'>*</span></td>\n";
            echo "<td width='58%'>\n<input class=textbox name='ip' type='textbox' size='20' id='ip' value='".$ip."' required></td>\n";
            echo "</tr>\n<tr>\n";
            echo "<td width='42%' align='right'>\n".$locale['csp_104']."&nbsp;<span style='color:#ff0000'>*</span></td>\n";
            echo "<td>\n<input class=textbox name='port' type='text' size='7' id='port' value='".$port."'></td>\n";
            echo "</tr>\n<tr>\n";
            echo "<td align='right'>\n".$locale['csp_105']."</td>\n";
            echo "<td>\n<select class=textbox name='player' id='player' value='".$player."'>\n";
            echo "<option value='20'>20</option>\n";
            echo "<option value='10'>10</option>\n";
            echo "<option value='12'>12</option>\n";
            echo "<option value='14'>14</option>\n";
            echo "<option value='16'>16</option>\n";
            echo "<option value='18'>18</option>\n";
            echo "<option value='22'>22</option>\n";
            echo "<option value='24'>24</option>\n";
            echo "<option value='26'>26</option>\n";
            echo "<option value='28'>28</option>\n";
            echo "<option value='30'>30</option>\n";
            echo "<option value='32'>32</option>\n";
            echo "</select>\n</td>\n";
            echo "</tr>\n<tr>\n";
            echo "<td align='right'>\n".$locale['csp_106']."</td>\n";
            echo "<td>\n<select class=textbox name='cod' id='cod'  value='".$cod."'>\n";
            echo "<option value='1'>Not Secure</option>\n";
            echo "<option value='2'>VAC Secure</option>\n";
            echo "<option value='3'>VAC Secure2</option>\n";
            echo "<option value='4'>HLGuard</option>\n";
            echo "<option value='5'>Cheating-Death</option>\n";
            echo "</select>\n</td>\n";
            echo "</tr>\n<tr>\n";
            echo "<td align='right'>\n".$locale['csp_107']."</td>\n";
			echo "<td>\n<select class=textbox name='modul' id='modul' value='".$modul."'>\n";
			echo "<option value='1'>Normal</option>\n";
			echo "<option value='2'>Respawn</option>\n";
			echo "<option value='3'>WAR3FT</option>\n";
			echo "<option value='4'>Heroes</option>\n";
			echo "<option value='5'>Other</option>\n";
			echo "</select>\n</td>\n";
			echo "</tr>\n<tr>\n";
			echo "<td colspan='2' align='center'>\n<input type='submit' name='save' value='".$locale['csp_155']."' class='button'></td>\n";
			echo "</tr>\n</table>\n</form>\n";
			closeside();
			
		}	
    }








		openside($locale['csp_113']);
	$result2 = dbquery("SELECT * FROM ".DB_SERVER." ORDER BY `id` ASC  LIMIT ".$_GET['rowstart'].",".$page);		
	        echo "<table width='400' border='0' cellspacing='1' cellpadding='0' align='center'>\n<tr>\n";
	        echo "<tr>\n";
            echo "<td align='center' bgcolor='#FFFFFF'>\n".$locale['csp_102']."</td>\n";
            echo "<td bgcolor='#FFFFFF' align='center'>\n".$locale['csp_103']."</td>\n";
            echo "<td bgcolor='#FFFFFF' align='center'>\n".$locale['csp_104']."</td>\n";
		    echo "<td align='center' bgcolor='#FFFFFF'>\n<strong>".$locale['csp_151']."</strong></td>\n";
		    echo "</tr>\n";
			echo "<form name='form1' method='post' action=''>\n";
    while($data2 = dbarray($result2)){
		
            echo "<tr>\n";
            echo "<td align='center' bgcolor='#FFFFFF'>\n<input type='checkbox' name='checkbox[]' id='checkbox[]' value=".$data2['id'].">\n</td>\n";
            echo "<td bgcolor='#FFFFFF' align='center'>\n".$data2['id']."</td>\n";
            echo "<td bgcolor='#FFFFFF' align='center'>\n".$data2['ip']."</td>\n";
		    echo "<td align='center' bgcolor='#FFFFFF'>\n<strong><a href='".FUSION_SELF.$aidlink."&amp;action=edit&amp;id=".$data2['id']."'>".$locale['csp_151']."</a> -\n";
		    echo "<a href='".FUSION_SELF.$aidlink."&amp;action=delete&amp;id=".$data2['id']."' onclick=\"return confirm('".$locale['csp_154']."');\">".$locale['csp_152']."</a></td>\n";
		    echo "</strong></td>\n";
		    echo "</tr>\n";
    }
            echo "<tr>\n";
			
		    echo "<td colspan='5' align='center' bgcolor='#FFFFFF'>\n<input name='del' type='submit' id='del' value='".$locale['csp_153']."'>\n</td>\n";
            echo "</form>\n</tr>\n</table>\n";
        	closeside();
// Check if delete button active, start this
        echo "<div align='center' style='margin-top:5px;'>\n".(($num > $page) ? makePageNav($_GET['rowstart'], $page, $num, 3, FUSION_SELF."?") : "")."\n</div>\n";
closeside();
}		
    if (isset($_POST['del'])){
        for($i=0;$i<$num;$i++){
            $del_id = isset($_POST['checkbox'][$i]) ? $_POST['checkbox'][$i] : "";
			//echo $del_id; 
			$result = dbquery("DELETE FROM ".DB_SERVER." WHERE id='".$del_id."'");
        //
        }
	        redirect(FUSION_SELF.$aidlink);
	}  
closeside();
require_once THEMES."templates/footer.php";
?>
