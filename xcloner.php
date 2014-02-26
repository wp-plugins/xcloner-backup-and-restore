<?php
/*
Plugin Name:  XCloner
Plugin URI: http://www.xcloner.com
Description: XCloner is a tool that will help you manage your website backups, generate/restore/move so your website will be always secured! With XCloner you will be able to clone your site to any other location with just a few clicks. Don't forget to create the 'administrator/backups' directory in your Wordpress root and make it fully writeable. <a href="plugins.php?page=xcloner_show">Open XCloner</a> | <a href="http://www.xcloner.com/support/premium-support/">Get Premium Support</a> | <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=info%40xcloner%2ecom&lc=US&item_name=XCloner%20Support&no_note=0&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHostedGuest">Donate</a>
Version: 3.1.0
Author: Liuta Ovidiu
Author URI: http://www.xcloner.com
Plugin URI: http://www.xcloner.com
*/

define("_VALID_MOS", 1);


global $xcloner_db_version;
$xcloner_db_version = "1.0";


function xcloner_show()
{

	include "admin.cloner.php";

}

function xcloner_install()
{
	
}

function xcloner_page()
{

	if ( function_exists('add_submenu_page') )
		add_submenu_page('plugins.php', 'XCloner', 'XCloner', 'manage_options', 'xcloner_show', 'xcloner_show');


}

#add_action('admin_head', 'xcloner');
add_action('admin_menu', 'xcloner_page');

add_action( 'wp_ajax_add_foobar', 'prefix_ajax_add_foobar' );

function prefix_ajax_add_foobar() 
{
    // Handle request then generate response using WP_Ajax_Response
}


if (isset($_GET['activate']) && $_GET['activate'] == 'true')
{
	add_action('init', 'xcloner_install');
}
 
 
 
add_action( 'wp_ajax_json_return', 'json_return' );

function json_return(){

	include "admin.cloner.php";

	die();

} 

add_action( 'wp_ajax_files_xml', 'files_xml' );

function files_xml(){

	set_include_path(__DIR__."/browser/");
	include __DIR__."/browser/files_xml.php";

	die();

} 
?>
