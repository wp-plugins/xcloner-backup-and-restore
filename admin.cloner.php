<?php
  /*
   *      admin.cloner.php
   *
   *      Copyright 2011 Ovidiu Liuta <info@thinkovi.com>
   *
   *      This program is free software; you can redistribute it and/or modify
   *      it under the terms of the GNU General Public License as published by
   *      the Free Software Foundation; either version 2 of the License, or
   *      (at your option) any later version.
   *
   *      This program is distributed in the hope that it will be useful,
   *      but WITHOUT ANY WARRANTY; without even the implied warranty of
   *      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   *      GNU General Public License for more details.
   *
   *      You should have received a copy of the GNU General Public License
   *      along with this program; if not, write to the Free Software
   *      Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
   *      MA 02110-1301, USA.
   */


  @session_start();
  @set_time_limit("3600");
  @error_reporting(E_ALL ^ E_NOTICE);

  define("_VALID_MOS", 1);

  //load configuration
  $config_file = "cloner.config.php";
  require_once($config_file);
  require_once("restore/TAR.php");
  require_once("cloner.functions.php");
  require_once("admin.cloner.html.php");
  require_once("common.php");


  //Doing some basic authentification
  if ((!isset($_SESSION['clone'])) && ($task != 'dologin')) {
      $task = 'login';

      HTML_cloner::header();

      HTML_cloner::Login();

      HTML_cloner::footer();

      exit;
  } elseif ($task == 'dologin') {
      if (($_REQUEST['username'] == $_CONFIG['jcuser']) && (md5($_REQUEST['password']) == $_CONFIG['jcpass'])) {
          if (function_exists('session_register')) {
              @session_register('clone');
          }
          $_SESSION['clone'] = 1;

          mosRedirect('index2.php?option=' . $option, "Welcome to XCloner backend");
      } else {


          mosRedirect('index2.php?option=' . $option, "Incorrect username and/or password");
      }
  }



  //###########GLOBALS in effect
  $GLOBALS['lang_dir'] = $lang_dir;
  //###########
  $lang_array = get_avalaible_langs();


  // retrieve row selection from forms
  $cid = $_REQUEST['cid'];
  if (!is_array($cid)) {
      $cid = array(0);
  }

	if(!$_REQUEST['nohtml'])
	if (($task != 'download') and (($_REQUEST['task']!="refresh") or (!$_CONFIG['refresh_mode'])))
      HTML_cloner::header();


  //########## SETTING THE GLOBALS VARIABLES #########################

  $GLOBALS['joomla_compatible'] = $joomla_compatible;

  $GLOBALS['_CONFIG'] = $_CONFIG;

  $GLOBALS['clonerPath'] = $clonerPath;

  $GLOBALS['baDownloadPath'] = $baDownloadPath;

  $GLOBALS['config_file'] = $config_file;

  $GLOBALS['lang_array'] = $lang_array;

  openXLog();

  // process the workflow selection
  switch ($task) {
      case 'rename_save':
      case 'rename':
          clone_rename($option);
          break;
      case 'action':
          action($option);
          break;


      case 'cancel_lang':
          mosRedirect('index2.php?option=' . $option . "&task=lang");
          break;
      case 'add_lang':
      case 'add_lang_new':
          translator_add($option, $task);
          break;
      case 'save_lang_apply':
      case 'save_lang':
      case 'edit_lang':
          translator_edit($option, $task);
          break;


      case 'del_lang':
      case 'lang':
          translator($option);
          break;

	  case	'recurse_files':
		  goRecurseFiles();
		  break;

      case 'refresh':
		  generateBackuprefresh($cid, $option, $_REQUEST['backup'], $_CONFIG['refresh_mode']);
          break;

      case 'generate':
          generateBackup($cid, $option);
          break;

      case 'confirm':
		  deleteXLog();
          confirmBackup($option);
          break;
      case 'download':
          downloadBackup($_REQUEST[file]);
          break;
      case 'cron':
          HTML_cloner::Cron();
          break;
      case 'about':
      case 'credits':
          showHelp($option);
          break;
      case 'restore':
          HTML_cloner::Restore($option);
          break;

      case 'cron_delete':
          if (unlink($_CONFIG['multiple_config_dir'] . "/" . $_REQUEST['fconfig']))
              $msg = " was deleted";
          else
              $msg = " was not deleted, please delete it manually!";

          mosRedirect('index2.php?option=' . $option . "&task=config", $_REQUEST['fconfig'] . $msg);
          break;

      case 'remove':
          deleteBackups($cid, $option);
          break;
      case 'continue':
      case 'move':
      case 'clone':
          moveBackup($option);
          break;

      case 'cancel':
          mosRedirect('index2.php?option=' . $option);
          break;
      case 'config':
          config($option);
          break;
      case 'rename_cancel':
          mosRedirect('index2.php?option=' . $option . "&task=view");
          break;
      case 'show':
      case 'view':
          showBackups($option);
          break;
      case 'logout':
          doLogout();
          break;
      default:
          fdefault();
          break;
  }

  closeXLog();

  HTML_cloner::footer();
?>
