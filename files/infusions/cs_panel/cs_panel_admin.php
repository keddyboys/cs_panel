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
include INCLUDES."infusions_include.php";

if (isset($_GET['status']) && !isset($message)) {
	if ($_GET['status'] == "su") {
		$message = $locale['csp_161'];
	} elseif ($_GET['status'] == "del") {
		$message = $locale['csp_162'];
	} elseif ($_GET['status'] == "sn") {
		$message = $locale['csp_160'];
	}
	if ($message) {	echo "<div id='close-message'><div class='admin-message'>".$message."</div></div>\n"; }
}

if (!isset($_GET['rowstart']) || !isNum($_GET['rowstart'])) $_GET['rowstart'] = 0;
//if (!isset($_GET['page']) || !$_GET['page']) $_GET['page'] = "";
$nav = "<table cellpadding='0' cellspacing='0' class='tbl-border' align='center' style='width:300px; margin-bottom:20px; text-align:center;'>\n<tr>\n";
$nav .= "<td class='".(!isset($_GET['page']) || $_GET['page'] != "settings" ? "tbl2" : "tbl1")."'><a href='".FUSION_SELF.$aidlink."'>".$locale['csp_110']."</a></td>\n";
$nav .= "<td class='".(isset($_GET['page']) && $_GET['page'] == "settings" ? "tbl2" : "tbl1")."'><a href='".FUSION_SELF.$aidlink."&amp;page=settings'>".$locale['csp_109']."</a></td>\n";
$nav .= "</tr>\n</table>\n";

$page=10;
$num = dbcount("(id)", DB_SERVER);
if (!isset($_GET['page']) || $_GET['page'] != "settings") {

    if ((isset($_GET['action']) && $_GET['action'] == "delete") && (isset($_GET['id']) && isnum($_GET['id']))) {
                
            $result = dbquery("DELETE FROM ".DB_SERVER." WHERE id='".$_GET['id']."'");
			redirect(FUSION_SELF.$aidlink."&status=del");
        
		
    } elseif ((isset($_GET['action']) && $_GET['action'] == "mu") && (isset($_GET['id']) && isnum($_GET['id'])) && (isset($_GET['sorder']) && isnum($_GET['sorder']))) {
        $data = dbarray(dbquery("SELECT id FROM ".DB_SERVER." WHERE sorder='".$_GET['sorder']."'"));
		    $result = dbquery("UPDATE ".DB_SERVER." SET sorder=sorder+1 WHERE id='".$data['id']."'");
		    $result = dbquery("UPDATE ".DB_SERVER." SET sorder=sorder-1 WHERE id='".$_GET['id']."'");
			redirect(FUSION_SELF.$aidlink);

    } elseif ((isset($_GET['action']) && $_GET['action'] == "md") && (isset($_GET['id']) && isnum($_GET['id'])) && (isset($_GET['sorder']) && isnum($_GET['sorder']))) {
		    $data = dbarray(dbquery("SELECT id FROM ".DB_SERVER." WHERE sorder='".$_GET['sorder']."'"));
		    $result = dbquery("UPDATE ".DB_SERVER." SET sorder=sorder-1 WHERE id='".$data['id']."'");
		    $result = dbquery("UPDATE ".DB_SERVER." SET sorder=sorder+1 WHERE id='".$_GET['id']."'");
		    redirect(FUSION_SELF.$aidlink);

    } else {
     
        if (isset($_POST['save'])) {
        	$ip = stripinput(trim($_POST['ip']));
            $port = isset($_POST['port']) && isNum($_POST['port'])  ? $_POST['port'] : "27015";
            $player = isset($_POST['player']) && isNum($_POST['player']) ? $_POST['player'] : "20";
            $cod = isset($_POST['cod']) && isNum($_POST['cod']) ? $_POST['cod'] : "0";
            $modul = isset($_POST['modul']) && isNum($_POST['modul']) ? $_POST['modul'] : "0";
			$type = isset($_POST['type']) && isNum($_POST['type']) ? $_POST['type'] : "0";
			$sorder = isset($_POST['sorder']) && isNum($_POST['sorder']) ? $_POST['sorder'] : "";
    		$result = dbquery("UPDATE ".DB_SERVER." SET ip='$ip', port='$port', player='$player', cod='$cod', modul='$modul', type='$type', sorder='$sorder' WHERE id='".$_GET['id']."'");
			redirect(FUSION_SELF.$aidlink."&status=su");
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
		    $type = $data['type'];
		    $sorder = $data['sorder'];
		    $formaction = FUSION_SELF.$aidlink."&amp;action=edit&amp;id=".$_GET['id'];
		    openside($locale['csp_114']);
		    
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
                echo "<option value='$player'>".$play[$player]."</option>\n";
			  foreach($play as $key => $value){
                echo '<option value="'.$key.'">'.$value.'</option>';
			  }
			    echo "</select>\n</td>\n";
                echo "</tr>\n<tr>\n";
                echo "<td align='right'>\n".$locale['csp_106']."</td>\n";
                echo "<td>\n<select class=textbox name='cod' id='cod'  value='".$cod."'>\n";
                echo "<option value='$cod'>".$code[$cod]."</option>\n";
			  foreach($code as $key => $value){
                echo '<option value="'.$key.'">'.$value.'</option>';
			  }
	    		echo "</select>\n</td>\n";
                echo "</tr>\n<tr>\n";
                echo "<td align='right'>\n".$locale['csp_107']."</td>\n";
			    echo "<td>\n<select class=textbox name='modul' id='modul' value='".$modul."'>\n";
			    echo "<option value='$modul'>".$mod[$modul]."</option>\n";
			  foreach($mod as $key => $value){
                echo '<option value="'.$key.'">'.$value.'</option>';
			  }
			    echo "</select>\n</td>\n";
			    echo "</tr>\n<tr>\n";
			    echo "<td align='right'>\n".$locale['csp_108']."</td>\n";
			    echo "<td>\n<select class=textbox name='type' id='type' value='".$type."'>\n";
			    echo "<option value='$type'>".$typ[$type]."</option>\n";
			  foreach($typ as $key => $value){
                echo '<option value="'.$key.'">'.$value.'</option>';
			  }
		    	echo "</select>\n</td>\n";
			    echo "</tr>\n<tr>\n";
			    echo "<td width='42%' align='right'>\n".$locale['csp_164']."</td>\n";
		     	echo "<td>\n<input type='text' name='sorder' value='".$sorder."' class='textbox' style='width:45px;' /></td>\n";
		    	echo "</tr>\n<tr>\n";
		    	echo "<td colspan='2' align='center'>\n<input type='submit' name='save' value='".$locale['csp_155']."' class='button'></td>\n";
			    echo "</tr>\n</table>\n</form>\n";
			closeside();
			
		    }	
        }
    
    openside($locale['csp_113']);
	       echo $nav;
		   
	$result2 = dbquery("SELECT * FROM ".DB_SERVER." ORDER BY `sorder` ASC  LIMIT ".$_GET['rowstart'].",".$page);		
	        echo "<table width='400' border='0' cellspacing='1' cellpadding='0' align='center'>\n<tr>\n";
	        echo "<tr>\n";
            echo "<td align='center' bgcolor='#FFFFFF'>\n#</td>\n";
            echo "<td bgcolor='#FFFFFF' align='center'>\n".$locale['csp_101']."</td>\n";
			echo "<td bgcolor='#FFFFFF' align='center'>\n".$locale['csp_103']."</td>\n";
            echo "<td bgcolor='#FFFFFF' align='center'>\n".$locale['csp_104']."</td>\n";
			echo "<td bgcolor='#FFFFFF' align='center'>\n".$locale['csp_164']."</td>\n";
		    echo "<td align='center' bgcolor='#FFFFFF'>\n<strong>".$locale['csp_151']."</strong></td>\n";
		    echo "</tr>\n";
			echo "<form name='form1' method='post' action=''>\n";
			$i = 1;$j = 1;
    while($data2 = dbarray($result2)){
		    $up = $data2['sorder'] - 1;	$down = $data2['sorder'] + 1;
            echo "<tr>\n";
            echo "<td align='center' bgcolor='#FFFFFF'>\n<input type='checkbox' name='checkbox[]' id='checkbox[]' value=".$data2['id'].">\n</td>\n";
            echo "<td bgcolor='#FFFFFF' align='center'>\n".$j."</td>\n";
            echo "<td bgcolor='#FFFFFF' align='center'>\n".$data2['ip']."</td>\n";
			echo "<td bgcolor='#FFFFFF' align='center'>\n".$data2['port']."</td>\n";
			echo "<td bgcolor='#FFFFFF' align='center'>\n".$data2['sorder'];
			if ($i == 1) {
					echo "<a href='".FUSION_SELF.$aidlink."&amp;action=md&amp;sorder=$down&amp;id=".$data2['id']."'><img src='".get_image("down")."' alt='".$locale['csp_166']."' title='".$locale['csp_168']."' style='border:0px;' /></a>\n";
				} elseif ($i < dbrows($result2)) {
					echo "<a href='".FUSION_SELF.$aidlink."&amp;action=mu&amp;sorder=$up&amp;id=".$data2['id']."'><img src='".get_image("up")."' alt='".$locale['csp_165']."' title='".$locale['csp_167']."' style='border:0px;' /></a>\n";
					echo "<a href='".FUSION_SELF.$aidlink."&amp;action=md&amp;sorder=$down&amp;id=".$data2['id']."'><img src='".get_image("down")."' alt='".$locale['csp_166']."' title='".$locale['csp_168']."' style='border:0px;' /></a>\n";
				} else {
					echo "<a href='".FUSION_SELF.$aidlink."&amp;action=mu&amp;sorder=$up&amp;id=".$data2['id']."'><img src='".get_image("up")."' alt='".$locale['csp_165']."' title='".$locale['csp_167']."' style='border:0px;' /></a>\n";
				}
		    		
            echo "</td>\n";
		    
		    echo "<td align='center' bgcolor='#FFFFFF'>\n<strong><a href='".FUSION_SELF.$aidlink."&amp;action=edit&amp;id=".$data2['id']."'>".$locale['csp_151']."</a> -\n";
		    echo "<a href='".FUSION_SELF.$aidlink."&amp;action=delete&amp;id=".$data2['id']."' onclick=\"return confirm('".$locale['csp_154']."');\">".$locale['csp_152']."</a></td>\n";
		    echo "</strong></td>\n";
		    echo "</tr>\n";
            $i++;$j++;
    }
            echo "<tr>\n";
			
		    echo "<td colspan='5' align='center' bgcolor='#FFFFFF'>\n<input name='del' type='submit' id='del' value='".$locale['csp_153']."'>\n</td>\n";
            echo "</form>\n</tr>\n</table>\n";
        	closeside();

            echo "<div align='center' style='margin-top:5px;'>\n".(($num > $page) ? makePageNav($_GET['rowstart'], $page, $num, 3, FUSION_SELF."?") : "")."\n</div>\n";
    closeside();
    }		
    if (isset($_POST['del'])){
        for($i=0;$i<$num;$i++){
            $del_id = isset($_POST['checkbox'][$i]) ? $_POST['checkbox'][$i] : "";
			$result = dbquery("DELETE FROM ".DB_SERVER." WHERE id='".$del_id."'");
        
        }
	        redirect(FUSION_SELF.$aidlink);
	}  
closeside();
} else {
    if (isset($_POST['cs_settings'])) {
		if (isset($_POST['servers_in_panel']) && isnum($_POST['servers_in_panel'])) {
			$setting = set_setting("servers_in_panel", $_POST['servers_in_panel'], "cs_panel");
		}
		if (isset($_POST['servers_per_page']) && isnum($_POST['servers_per_page'])) {
			$setting = set_setting("servers_per_page", $_POST['servers_per_page'], "cs_panel");
		}
		if (isset($_POST['show_players']) && ($_POST['show_players'] == 1 || $_POST['show_players'] == 0)) {
			$setting = set_setting("show_players", $_POST['show_players'], "cs_panel");
		}
		redirect(FUSION_SELF.$aidlink."&status=sn");
	}	
	$inf_settings = get_settings("cs_panel");
	openside($locale['csp_109']);
	        echo $nav;
	
            echo "<table width='100%' cellspacing=1 cellpadding=0 align='center'>\n";
            echo "<tr align=center>\n<td align=center>\n";
            
            echo "<table width='600' border='0' align='center' cellpadding='2' cellspacing='0'>\n";
            echo "<form  method='post' action='".FUSION_SELF.$aidlink."&amp;page=settings'>\n";

            echo "<tr>\n<td width='42%' align='right'>\n".$locale['csp_145']."</td>\n";
            echo "<td width='58%'>\n<input class=textbox name='servers_in_panel' type='textbox' size='7' id='servers_in_panel' value='".$inf_settings['servers_in_panel']."'></td>\n";
            echo "</tr>\n<tr>\n";
			echo "<tr>\n<td width='42%' align='right'>\n".$locale['csp_146']."</td>\n";
            echo "<td width='58%'>\n<input class=textbox name='servers_per_page' type='textbox' size='7' id='servers_per_page' value='".$inf_settings['servers_per_page']."'></td>\n";
            echo "</tr>\n<tr>\n";
			echo "<td width='42%' align='right'>\n".$locale['csp_147']."</td>\n";
			echo "<td class='tbl1'><select name='show_players' size='1' class='textbox'>";
	        echo "<option value='1' ".($inf_settings['show_players'] == 1 ? "selected='selected'" : "").">".$locale['csp_134']."</option>\n";
	        echo "<option value='0'".($inf_settings['show_players'] == 0 ? "selected='selected'" : "").">".$locale['csp_135']."</option>\n";
	        echo "</select></td>\n";
            echo "</tr>\n<tr>\n";
			echo "<td colspan='2' align='center'>\n<input type='submit' name='cs_settings' value='".$locale['csp_155']."' class='button'></td>\n";
			echo "</tr>\n</table>\n</form>\n";
			
 	
	
    closeside();	
}
closeside();
require_once THEMES."templates/footer.php";
?>