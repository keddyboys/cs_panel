<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) PHP-Fusion Inc
| https://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: cs.php
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
if (file_exists(INFUSIONS."cs_panel/locale/".$settings['locale'].".php")) {
	include INFUSIONS."cs_panel/locale/".$settings['locale'].".php";
} else {
	include INFUSIONS."cs_panel/locale/English.php";
}

include INFUSIONS."cs_panel/infusion_db.php";
include_once INCLUDES."infusions_include.php";

$cs_settings = get_settings("cs_panel");

if (!isset($_GET['rowstart']) || !isNum($_GET['rowstart'])) $_GET['rowstart'] = 0;

$num = dbcount("(id)", DB_SERVER);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
openside($locale['csp_100']);
            echo "<div align='center'><table class='tbl-border' align='center'>\n<tr>\n";
            echo "<th height=23  class='tbl2'><b>".$locale['csp_101']."</b></td>\n";
            echo "<th height=23 class='tbl2'><b>".$locale['csp_102']."</b></td>\n";
            echo "<th height=23 class='tbl2'><b>".$locale['csp_103']."</b></td>\n";
            echo "<th height=23 class='tbl2'><b>".$locale['csp_104']."</b></td>\n";
            echo "<th height=23 class='tbl2'><b>".$locale['csp_105']."</b></td>\n";
            echo "<th height=23 class='tbl2'><b>".$locale['csp_106']."</b></td>\n";
            echo "<th height=23 class='tbl2'><b>".$locale['csp_107']."</b></td>\n";
			echo "<th height=23 class='tbl2'><b>".$locale['csp_108']."</b></td>\n";
			echo "</tr>\n";
        $result = dbquery("SELECT * FROM ".DB_SERVER." ORDER BY `sorder`  LIMIT ".$_GET['rowstart'].", ".$cs_settings['servers_per_page']); 
        
        $i = 1;
    while ($data=dbarray($result)) {
            $tbl = "tbl".($i % 2 == 0 ? 2 : 1);
            echo "<tr align=center><td height=23 class='$tbl'>".($i+$_GET['rowstart'])."</td>\n";
			echo "<td  height=23 class='$tbl'>\n";
            echo "<a href='#' onclick=window.open('".INFUSIONS."cs_panel/stats.php?id=".$data['id']."','Download','scrollbars=yes,width=600,height=600')>\n";
            echo "<img src='".INFUSIONS."cs_panel/img/verifica.gif' alt=''/></center></a></td>\n";
            echo "<td width=135 height=23 class='$tbl'>".$data['ip']."</td>\n";
            echo "<td height=23 width=45 class='$tbl'>".$data['port']."</td>\n";
            echo "<td height=23 width=45 class='$tbl'>".$data['player']."</td>\n";
            echo "<td height=23 width=75 class='$tbl'>".$code[$data['cod']]."</td>\n";
            echo "<td height=23 width=45 class='$tbl'>".$mod[$data['modul']]."</td>\n";
			echo "<td height=23 class='$tbl' width=45>\n".$typ[$data['type']]."</td>\n";
            echo"</tr>\n";
			$i++;     
    }
        echo "</table></div>";
        echo "<div style='text-align:center'>".$locale['csp_115'] ."&nbsp;".$num."&nbsp;".$locale['csp_116']."</div>";
    
echo "<div align='center' style='margin-top:5px;'>\n".(($num > $cs_settings['servers_per_page']) ? makePageNav($_GET['rowstart'], $cs_settings['servers_per_page'], $num, 3, FUSION_SELF."?") : "")."\n</div>\n";
closeside();
require_once THEMES."templates/footer.php";
?>