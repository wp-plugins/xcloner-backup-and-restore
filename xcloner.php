<?php
/*
Plugin Name:  XCloner
Plugin URI: http://www.xcloner.com
Description: XCloner is a tool that will help you manage your website backups, generate/restore/move so your website will be always secured! With XCloner you will be able to clone your site to any other location with just a few clicks
Version: 2.1
Author: Liuta Ovidiu
Author URI: http://www.xcloner.com
*/


// no direct access
#defined( '_JEXEC' ) or die( 'Restricted access' );

function xcloner_show(){

print "<iframe src='../wp-content/plugins/xcloner-backup-and-restore/index.php' width='100%' height='900' frameborder=0 marginWidth=0 frameSpacing=0 marginHeight=110 ></iframe>";

}
function xcloner_install(){

}

function xcloner_page(){

	if ( function_exists('add_submenu_page') )
		add_submenu_page('plugins.php', XCloner, XCloner, 'manage_options', 'xcloner_show', 'xcloner_show');



}

#add_action('admin_head', 'xcloner');
add_action('admin_menu', 'xcloner_page');

#add_options_page('XCloner Options', 'XCloner', 9, 'index.php', 'xcloner_options');

if (isset($_GET['activate']) && $_GET['activate'] == 'true')
 {
   add_action('init', 'xcloner_install');
 }

?>
