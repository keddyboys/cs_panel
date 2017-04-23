<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) PHP-Fusion Inc
| https://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: stats.php
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
$default_opts = array(
  'http'=>array(
    'method'=>"GET",
    'user_agent'=>'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.81 Safari/537.36'
  )
);
stream_context_set_default($default_opts);
require_once "../../maincore.php";
if (file_exists(INFUSIONS."cs_panel/locale/".$settings['locale'].".php")) {
	include INFUSIONS."cs_panel/locale/".$settings['locale'].".php";
} else {
	include INFUSIONS."cs_panel/locale/English.php";
}
include INFUSIONS."cs_panel/infusion_db.php";
require_once THEMES."templates/header.php";

require_once INFUSIONS."cs_panel/includes/GameQ.php"; 
 

error_reporting(~E_ALL); 
$id = isset($_GET['id']) && isNum($_GET['id']) ? $_GET['id'] : "0";
$data = dbarray(dbquery("SELECT ip, port, type FROM ".DB_SERVER."  WHERE id=".$id));
if ($data !=0) {
$server_ip = $data['ip'];
$server_port = $data['port'];
$server_type = $data['type'] == 1 ? 'cs' : 'cssource';

$page = "full";

if($page != "include") {
echo "<html><head><title>".$locale['csp_130']."</title>";

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
	'server' => array($server_type, $server_ip, $server_port)
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
            echo "<table class='tbl1'>\n";
            echo "<tr><td valign='top'>\n";
            echo "<table border='0' class='margins' cellspacing='1' cellpadding='0' align='center'>\n<tr>\n";
            echo "<td align=center>\n";
            echo "<table border='0' width='100%'>\n<tr>\n";
	        echo "<td align='center'>\n<font size='3'>".$locale['csp_130']."</td>\n</tr>\n";
            echo "</table>";
	
if (!$server['gq_online']) {
        	echo "<center>".$locale['csp_140']."</center>";
} else {
            echo "<table width='100%' cellspacing=1 cellpadding=0 align='center'>\n<tr>\n";
		    echo "<td class='tbl1'>\n".$locale['csp_120']."</td>\n";
		    echo "<td class='tbl1'>\n". $server['hostname']."</td>\n";
		    echo "<td rowspan='10' align='center' class='tbl1'>\n";
		$tbl = "tbl".($i % 2 == 0 ? 2 : 1);
		$type = $server['gq_type'] == 'cs' ? $typ['1'] : $typ['2'];
		$fileUrl = "https://image.gametracker.com/images/maps/160x120/cs/".$server['map'].".jpg";
        $AgetHeaders = @get_headers($fileUrl);
        if (preg_match("|200|", $AgetHeaders[0])) {
            echo "<img src='https://image.gametracker.com/images/maps/160x120/cs/".$server['map'].".jpg' width=160 height=120>";
        } else {
	        echo "<img src=img/no.gif width=160 height=120>"; 
	    }
		    echo "</td>\n</tr>\n<tr>\n";
		    echo "<td class='tbl2'>\n".$locale['csp_121']."</td>\n";
		    echo "<td class='tbl2'>\n".(isNum($server_ip) ? $server_ip : gethostbyname($server_ip))."</td>\n"; 
            echo "</tr>\n<tr>\n";
		    echo "<td class='tbl1'>\n".$locale['csp_122']."</td>\n";
		    echo "<td class='tbl1'>\n".$type."</td>\n";
	        echo "</tr>\n<tr>\n";
		    echo "<td class='tbl2'>\n".$locale['csp_123']."</td>\n";
		    echo "<td class='tbl2'>\n".$server['map']."</td>\n";
	        echo "</tr>\n<tr>\n";
		    echo "<td class='tbl1'>\n".$locale['csp_123b']."</td>\n";
		    echo "<td class='tbl1'>\n".$server['amx_nextmap']."</td>\n";
	        echo "</tr>\n<tr>\n";
	        echo "<td class='tbl2'>\n".$locale['csp_124']."</td>\n";
	        echo "<td class='tbl2'>\n".$server['num_players']." / ".$server['max_players']."</td>\n";
	        echo "</tr>\n<tr>\n";
		    echo "<td class='tbl1'>\n".$locale['csp_125']."</td>\n";
		    echo "<td class='tbl1'>\n".(($server['secure'] == "1") ? $locale['csp_134'] : $locale['csp_135'])."</td>\n";
	        echo "</tr>\n<tr>\n";
		    echo "<td class='tbl2'>\n".$locale['csp_126']."</td>\n";
		    echo "<td class='tbl2'>\n".(($server['os'] == "w") ? $locale['csp_136'] : $locale['csp_137'])."</td>\n";
	        echo "</tr>\n<tr>\n";
		    echo "<td class='tbl1'>\n".$locale['csp_127']."</td>\n";
		    echo "<td class='tbl1'>\n".(($server['dedicated'] == "d") ? $locale['csp_138'] : $locale['csp_139'])."</td>\n";
	        echo "</tr>\n<tr>\n";
	        echo "<td class='tbl2'>\n".$locale['csp_128']."</td>\n";
	        echo "<td class='tbl2'>\n".(($server['gq_password'] == "false") ? $locale['csp_134'] : $locale['csp_135'])."</td>\n";
	        echo "</tr>\n<tr>\n";
	        echo "<td class='tbl1'>\n".$locale['csp_129']."</td>\n";
	        echo "<td class='tbl1'>\n".$server['protocol']."</td>\n";
	        echo "</tr>\n</table>\n";
            echo "</td>\n</tr>\n</table>\n";
            echo "<table cellpadding='0' cellaspacing='0' align='center'>\n<tr>\n<td>\n";

			
           echo "<table border='0' width='458' align='center'>\n<tr>\n";
           echo "<td class='tbl2' align='center'>\n<strong>".$locale['csp_124']."</strong></td>\n";
           echo "</tr>\n</table>\n";

           echo "<table cellpadding=0 cellspacing=0 width='458' align='center'>\n";
           echo "<tr>\n<td align=center valign=top>\n";
           echo "<table width='100%' cellspacing=1 cellpadding=1>\n<tr>\n";
		
	       echo "<th class='tbl2'>\n<strong>".$locale['csp_101']."</strong></td>\n";	
           echo "<th class='tbl2'>\n<strong>".$locale['csp_105']."</strong></td>\n";
           echo "<th class='tbl2'>\n<strong>".$locale['csp_131']."</strong></td>\n";
           echo "<th class='tbl2'>\n<strong>".$locale['csp_132']."</strong></td>\n";
		   //echo "<th class='tbl2'>\n<strong>".$locale['csp_133']."</strong></td>\n";
           echo "</tr>\n";

    $ii=1;
    foreach( $server['players'] as $player ) {
		                $tbl = "tbl".($ii % 2 == 0 ? 2 : 1);
						echo "<tr>\n";
						echo "<td class='$tbl'>".($ii++)."</td>\n";
						echo "<td class='$tbl'>".htmlspecialchars($player['gq_name'])."</td>\n";
						echo "<td class='$tbl' align='right'>".$player['gq_score']."</td>\n";
						echo "<td class='$tbl' align='right'>".gameTime($player['time'], $locale['csp_timeUnits'])."</td>\n";
						//echo "<td class='$tbl'>".$player['gq_ping']."</td>\n";
						echo "</tr>\n";
}    
		echo "</table>\n";
        echo "</td>\n</tr>\n</table>\n";
        echo "<br /><center>\nCopyright &copy; 2016 <a href='http://dev.kmods.ro' target='_black'>Keddy</a>";
        
} 


        echo "<br /><a href='#' onClick='window.location.reload();'>".$locale['csp_156']."</a>&nbsp;&nbsp;&nbsp;";
        echo "<a href='#'onclick='javascript:self.close()'>".$locale['csp_157']."</a>\n";
        echo "</body></html>";
} else {
        echo "<center>".$locale['csp_158'],"<br />\n";
        echo "<a href='#'onclick='javascript:self.close()'>".$locale['csp_157']."</a></center>\n";
}	
?>