<?php
/*
OPGS Accounts v1
OPGS Accounts v2 25/10/2016
	- Change to std opgslib
*/


header("X-UA-Compatible: IE=edge");

$SITE = new stdClass();

session_start();

ob_start();
require('d:\dev\opgslib\opgslib.php');

$SETTINGS = new INI('settings.ini', 'accountssettingsdat', false);
foreach($SETTINGS->getIni()['site'] as $key => $value)
{
	$SITE->$key = htmlspecialchars($value);
}

$LDAP = new LDAP($SITE->ldap, $SITE->ldapuser, $SITE->ldappass, $SITE->ldapDN);
$AD = new ADFS($SITE->simplesamlpath, $SITE->adfsname, $SITE->adfsAdminGroup);
$AD->forceAuth();
if(!($AD->checkGroup('Teachers') || $AD->checkGroup('Support Staff')) && htmlspecialchars($_GET['page']) != 'accessdenied')
{
	header('Location: ' . $SITE->path . '/index.php?page=accessdenied');
	exit();
}

require('sys/lib/permissions.php');
$debug = ob_get_clean();
ob_end_clean();
require('theme/header.php');
require('theme/footer.php');
require('lang/opgs.php');

if(isset($_GET['page']))
{
	if(htmlspecialchars($_GET['page']) == 'do'){include('sys/do.php');}else
	if(htmlspecialchars($_GET['page']) == 'accessdenied'){include('sys/accessdenied.php');}else
	if(htmlspecialchars($_GET['page']) == 'admin-summary'){include('sys/admin/summary.php');}else
	if(htmlspecialchars($_GET['page']) == 'admin-logs'){include('sys/admin/logs.php');}else
	if(htmlspecialchars($_GET['page']) != 'home'){header('Location: ' . $SITE->path . '/index.php?page=home');exit();}
}else{
	header('Location: ' . $SITE->path . '/index.php?page=home');
	exit();
}

?>
