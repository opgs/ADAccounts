<?php
ob_start();

$account = htmlspecialchars($_POST['acc']);
$action = htmlspecialchars($_POST['act']);

if($LDAP->enableDisableUser($account, $action))
{
	echo "1";
}else{
	echo "0";
}

if($action)
{
	$logAction = "enabled";
}else{
	$logAction = "disabled";
}

$body = ob_get_clean();

$noheader = true;
$nofooter = true;
?>
