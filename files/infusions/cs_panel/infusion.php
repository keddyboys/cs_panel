<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: infusion.php
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
if (!defined("IN_FUSION")) { die("Access Denied"); }

include INFUSIONS."cs_panel/infusion_db.php";

// Check if locale file is available matching the current site locale setting.
if (file_exists(INFUSIONS."cs_panel/locale/".$settings['locale'].".php")) {
	// Load the locale file matching the current site locale setting.
	include INFUSIONS."cs_panel/locale/".$settings['locale'].".php";
} else {
	// Load the infusion's default locale file.
	include INFUSIONS."cs_panel/locale/English.php";
}

// Infusion general information
$inf_title = $locale['csp_title'];
$inf_description = $locale['csp_desc'];
$inf_version = "2.21";
$inf_developer = "keddy <br /><a href='http://www.phpfusion.ro/'>PHP-Fusion Rom&#226;nia</a>";
$inf_email = "kmodsro@gmail.com";
$inf_weburl = "http://dev.kmods.ro";

$inf_folder = "cs_panel"; // The folder in which the infusion resides.

// Delete any items not required below.
$inf_newtable[1] = DB_SERVER." (
id smallint(5) unsigned NOT NULL auto_increment,
ip varchar(45) NOT NULL DEFAULT '' ,
port varchar(5) NOT NULL DEFAULT '' ,
player varchar(2) NOT NULL DEFAULT '' ,
cod varchar(25) NOT NULL DEFAULT '' ,
modul varchar(25) NOT NULL DEFAULT '' ,
type varchar(25) NOT NULL DEFAULT '',
sorder SMALLINT(5) UNSIGNED NOT NULL,
PRIMARY KEY (ip),
UNIQUE id (id)
)ENGINE=MyISAM;";

//$inf_insertdbrow[1] = DB_SERVER."(id, ip, port, player, cod, modul, type, order) VALUES(`NULL`, `ip`, `port`, `player`, `cod`, `modul`, `type`, `order`) ";
$inf_insertdbrow[2] = DB_PANELS." (panel_name, panel_filename, panel_content, panel_side, panel_order, panel_type, panel_access, panel_display, panel_status) VALUES('".$locale['csp_title']."', 'cs_panel', '', '2', '3', 'file', '0', '0', '0')";

$inf_insertdbrow[3] = DB_SETTINGS_INF."(settings_name, settings_value, settings_inf) VALUES ('servers_per_page', '10', '".$inf_folder."')";
$inf_insertdbrow[4] = DB_SETTINGS_INF."(settings_name, settings_value, settings_inf) VALUES ('servers_in_panel', '10', '".$inf_folder."')";
$inf_insertdbrow[5] = DB_SETTINGS_INF."(settings_name, settings_value, settings_inf) VALUES ('show_players', '1', '".$inf_folder."')";

$inf_droptable[1] = DB_SERVER;

$inf_deldbrow[1] = DB_PANELS." WHERE panel_filename='".$inf_folder."'";

$inf_adminpanel[1] = array(
	"title" => $locale['csp_admin1'],
	"image" => "cs.png",
	"panel" => "cs_panel_admin.php",
	"rights" => "csp"
);

$inf_sitelink[1] = array(
	"title" => $locale['csp_link1'],
	"url" => "add_server.php",
	"visibility" => "101"
);
?>