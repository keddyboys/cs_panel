<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) PHP-Fusion Inc
| https://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: cs_panel.php
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

if (file_exists(INFUSIONS."cs_panel/locale/".$settings['locale'].".php")) {
	include INFUSIONS."cs_panel/locale/".$settings['locale'].".php";
} else {
	include INFUSIONS."cs_panel/locale/English.php";
}
include INFUSIONS."cs_panel/infusion_db.php";
if (!isset($_GET['rowstart']) || !isNum($_GET['rowstart'])) $_GET['rowstart'] = 0;
$page = 10;
$num = dbcount("(id)", DB_SERVER);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
if ($num > 0) { 
    openside($locale['csp_100']);
        echo "<div align='center'><table border ='1' align='center'><tr>\n";
        echo "<td height=23 style=background-image:url(img/bar.png) align=center>\n<b>".$locale['csp_101']."</b></td>\n";
        echo "<td height=23 style=background-image:url(img/bar.png) align=center>\n<b>".$locale['csp_102']."</b></td>\n";
        echo "<td height=23 style=background-image:url(img/bar.png) align=center>\n<b>".$locale['csp_103']."</b></td>\n";
        echo "<td height=23 style=background-image:url(img/bar.png) align=center>\n<b>".$locale['csp_104']."</b></td>\n";
        echo "<td height=23 style=background-image:url(img/bar.png) align=center>\n<b>".$locale['csp_105']."</b></td>\n";
        echo "<td height=23 style=background-image:url(img/bar.png) align=center>\n<b>".$locale['csp_106']."</b></td>\n";
        echo "<td height=23 style=background-image:url(img/bar.png) align=center>\n<b>".$locale['csp_107']."</b></td>\n";
        echo "</tr>\n";
    $result = dbquery("SELECT * FROM ".DB_SERVER." ORDER BY id desc  LIMIT ".$_GET['rowstart'].",".$page); 
    $i = 1; 
    while ($data=dbarray($result)) {

        echo "<tr align=center>\n<td  height=23>\n".($i+$_GET['rowstart'])."</td>\n"; 
        echo "<td  height=23>\n<a href='#' onclick=window.open('".INFUSIONS."cs_panel/stats.php?ip=".$data['ip']."&port=".$data['port']. "','','scrollbars=yes,width=600,height=600')>\n";
        echo "<img src='".INFUSIONS."cs_panel/img/verifica.gif' alt=''/></a>\n</td>\n";
        echo "<td width=135 height=23>\n".$data['ip']."</td>\n";
        echo "<td height=23 width=45>\n".$data['port']."</td>\n";
        echo "<td height=23 width=45>\n".$data['player']."</td>\n";
        echo "<td height=23 width=75>\n".$cod[$data['cod']]."</td>\n";
		echo "<td height=23 width=45>\n".$modul[$data['modul']]."</td>\n";
        echo "</tr>\n";
		$i++;
	}
        echo "</table>\n</div>\n";
        echo "<div style='text-align:center'>".$locale['csp_115'] ."&nbsp;".$num."&nbsp;".$locale['csp_116']."</div>";
        echo "<div align='center' style='margin-top:5px;'>\n".(($num > $page) ? makePageNav($_GET['rowstart'], $page, $num, 3, INFUSIONS."cs_panel/cs.php?") : "")."\n</div>\n";
closeside();
}
?>