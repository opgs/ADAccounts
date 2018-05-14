<?php
ob_start();
?>

<h1>Access Denied</h1>

<p>
Only students and staff at OPGS have access to this system
</p>

<?php
$body = ob_get_clean();
?>
