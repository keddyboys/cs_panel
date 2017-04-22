<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) PHP-Fusion Inc
| https://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: stats.php
| Author: xPaw/
| Source: https://github.com/xPaw/PHP-Source-Query  
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
if (file_exists(INFUSIONS."cs_panel/locale/".$settings['locale'].".php")) {
	include INFUSIONS."cs_panel/locale/".$settings['locale'].".php";
} else {
	include INFUSIONS."cs_panel/locale/English.php";
}
include INFUSIONS."cs_panel/infusion_db.php";

require_once("../../maincore.php");

require_once INFUSIONS."cs_panel/includes/GameQ.php"; 
 

error_reporting(~E_ALL); 
$server_ip = trim(stripslashes($_GET['ip']));
$server_port = trim(stripslashes($_GET['port']));

$page = "full";

if($page != "include") {
echo "<html><head><title>".$locale['csp_130']."</title>";

echo '<style type="text/css">
<!--
body, td {
	background-color:black;
	bgcolor:#424242;
	color: red;
	font-family: Tahoma, Arial, Helvetica, sans-serif;
	font-size: 11px;
	margin: 0;
}
.margins {
	border-top:1px solid #222222;
	border-right:1px solid #222222;
	border-left:1px solid #222222;
	border-bottom:1px solid #222222;
}
.style1 {color: red}
.style2 {
	color: red;
	font-weight: bold;
}
-->
</style>';

echo "</head><body link='red' vlink='red'>";

}
function gameTime($time, $units) {
    if ($time >= 86400) {
        return intval($time / 86400) . $units['days'] . gameTime($time % 86400, $units);
    } elseif ($time >= 3600) {
        return intval($time / 3600) . $units['hours'] . gameTime($time % 3600, $units);
    } elseif ($time >= 60) {
        return intval($time / 60) . $units['minutes'] . gameTime($time % 60, $units);
    } else {
        return intval($time) . $units['seconds'];
    }
}
$servers = array(
	'server' => array('cs', $server_ip, $server_port)
);
$gq = new GameQ();
$gq->addServers($servers);

    
// You can optionally specify some settings
$gq->setOption('timeout', 200);


// You can optionally specify some output filters,
// these will be applied to the results obtained.
$gq->setFilter('normalise');
$gq->setFilter('sortplayers');

// Send requests, and parse the data
$results = $gq->requestData();
$server= $results['server'];
        	echo "<table border='0' class='margins' cellspacing='1' cellpadding='0' align='center'>\n";
            echo "<tr><td valign='top'>\n";
            echo "<table class='cqall'>\n";
            echo "<tr><td valign='top'>\n";
            echo "<table border='0' class='margins' cellspacing=1 cellpadding=0 align=center>\n<tr>\n";
            echo "<td align=center>\n";
            echo "<table border='0' width='458'>\n<tr>\n";
	        echo "<td align='center'>\n<font size='3'>".$locale['csp_130']."</font></td>\n</tr>\n";
            echo "</table>";
	       // $adresa = $server['hostname'];
if (!$server['gq_online']) {
        	echo "<center>".$locale['csp_140']."</center>";
} else {
            echo "<table width='100%' cellspacing=1 cellpadding=0 align='center'>\n<tr>\n";
		    echo "<td class='margins'>\n<span class='style1'><font face='Tahoma' size='2'>".$locale['csp_120']."</font></span></td>\n";
		    echo "<td class='margins'>\n". $server['hostname']."</td>\n";
		    echo "<td rowspan='10' align='center'>\n<font align='' face='Tahoma' size='2'>";
		
	if (file_exists(INFUSIONS."cs_panel/img/maps/".$server['map'].".jpg")) {
		    echo "<img src='".INFUSIONS."cs_panel/img/maps/".$server['map'].".jpg' width=200 height=180>";
	} else { 
	      
	        echo "<img src=img/no.gif width=200 height=180>"; 
	}
		    echo "</td>\n</tr>\n<tr>\n";
		    echo "<td class='margins'>\n<span class='style1'><font face='Tahoma' size='2'>".$locale['csp_121']."</font></span></td>\n";
		    echo "<td class='margins'>\n".(isNum($server_ip) ? $server_ip : gethostbyname($server_ip))."</td>\n"; 
            echo "</tr>\n<tr>\n";
		    echo "<td class='margins'>\n<span class='style1'><font face='Tahoma' size='2'>".$locale['csp_122']."</font></span></td>\n";
		    echo "<td class='margins'>\n".$server['game_descr']."</td>\n";
	        echo "</tr>\n<tr>\n";
		    echo "<td class='margins'>\n<span class='style1'><font face='Tahoma' size='2'>".$locale['csp_123']."</font></span></td>\n";
		    echo "<td class='margins'>\n".$server['map']."</td>\n";
	        echo "</tr>\n<tr>\n";
	        echo "<td class='margins'>\n<span class='style1'><font face='Tahoma' size='2'>".$locale['csp_124']."</font></span></td>\n";
	        echo "<td class='margins'>\n".$server['num_players']." / ".$server['max_players']."</td>\n";
	        echo "</tr>\n<tr>\n";
		    echo "<td class='margins'>\n<span class='style1'><font face='Tahoma' size='2'>".$locale['csp_125']."</font></span></td>\n";
		    echo "<td class='margins'>\n".(($server['secure'] == "1") ? $locale['csp_134'] : $locale['csp_135'])."</td>\n";
	        echo "</tr>\n<tr>\n";
		    echo "<td class='margins'>\n<span class='style1'><font face='Tahoma' size='2'>".$locale['csp_126']."</font></span></td>\n";
		    echo "<td class='margins'>\n".(($server['os'] == "w") ? $locale['csp_136'] : $locale['csp_137'])."</td>\n";
	        echo "</tr>\n<tr>\n";
		    echo "<td class='margins'>\n<span class='style1'><font face='Tahoma' size='2'>".$locale['csp_127']."</font></span></td>\n";
		    echo "<td class='margins'>\n".(($server['dedicated'] == "d") ? $locale['csp_138'] : $locale['csp_139'])."</td>\n";
	        echo "</tr>\n<tr>\n";
	        echo "<td class='margins'>\n<span class='style1'><font face='Tahoma' size='2'>".$locale['csp_128']."</font></span></td>\n";
	        echo "<td class='margins'>\n".(($server['gq_password'] == "false") ? $locale['csp_134'] : $locale['csp_135'])."</td>\n";
	        echo "</tr>\n<tr>\n";
	        echo "<td class='margins'>\n<span class='style1'><font face='Tahoma' size='2'>".$locale['csp_129']."</font></span></td>\n";
	        echo "<td class='margins'>\n".$server['protocol']."</td>\n";
	        echo "</tr>\n</table>\n";
            echo "</td>\n</tr>\n</table>\n";
            echo "<table cellpadding='0' cellaspacing='0'>\n<tr>\n<td>\n";

           echo "<table border='0'>\n<tr align='center'>\n";
           echo "<td height='24' style='background-image:url(cellpic1.gif)' align='center'>\n";
           echo "<span class='style1'><strong><font face='Tahoma'>".$locale['csp_124']."</font></strong></span></td>\n";
           echo "</tr>\n</table>\n";

           echo "<table cellpadding=0 cellspacing=0 width='458' align='center'>\n";
           echo "<tr>\n<td align=center valign=top>\n";
           echo "<table width='100%' cellspacing=1 cellpadding=1>\n<tr>\n";
		
	       echo "<td class='margins' align=center>\n<span class='style1'><strong><font face='Tahoma'>".$locale['csp_101']."</font></strong></span></td>\n";	
           echo "<td class='margins' align=center>\n<span class='style1'><strong><font face='Tahoma'>".$locale['csp_105']."</font></strong></span></td>\n";
           echo "<td class='margins' align=center>\n<span class='style2'><strong><font face='Tahoma'>".$locale['csp_131']."</font></strong></span></td>\n";
           echo "<td class='margins' align=center>\n<span class='style1'><strong><font face='Tahoma'>".$locale['csp_132']."</font></strong></span></td>\n";
           echo "</tr>\n";

    $ii=1;
    foreach( $server['players'] as $player ) {
						echo "<tr>\n";
						echo "<td align='center'>".($ii++)."</td>";
						echo "<td align='center'>".htmlspecialchars($player['gq_name'])."</td>";
						echo "<td align='center'>".$player['gq_score']."</td>";
						echo "<td align='center'>".gameTime($player['time'], $locale['csp_timeUnits'])."</td>";
}    
		echo "</table>\n";
        echo "</td>\n</tr>\n</table>\n";
        echo "<br /><center>\n<font color='red' size='2'>Copyright &copy; 2016 <a href='http://dev.kmods.ro' target='_black'>Keddy</a>";
        
} 
        echo "<br /><a href='#' onClick='window.location.reload();'>Refresh</a>&nbsp;&nbsp;&nbsp;";
        echo "<a href='#'onclick='javascript:self.close()'>Inchide</a></center></font>\n";
        echo "</body></html>";

?>
