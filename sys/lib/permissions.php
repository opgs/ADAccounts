<?php

$PERMISSIONS = [];

$permissionsini = parse_ini_file('permissions.ini', true);

foreach($permissionsini as $user => $entries)
{
	$PERMISSIONS[strtolower($user)] = new stdClass();
	
	foreach($permissionsini[$user] as $entry => $ou)
	{
		$PERMISSIONS[strtolower($user)]->$entry = $ou;
	}
}

?>
