<?php
ob_start();
?>
<!DOCTYPE html>
<html>
<head>
<title><?php echo $SITE->title; ?></title>
<link rel="stylesheet" type="text/css" href="<?php echo $SITE->path ?>/theme/css/opgs.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $SITE->path ?>/js/jquery-ui.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo $SITE->path ?>/js/jquery.tree-multiselect.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo $SITE->path; ?>/theme/css/<?php echo htmlspecialchars(isset($_GET['page']) ? ($_GET['page']) : "") ?>.css" />
<script type="text/javascript" src="<?php echo $SITE->path ?>/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="<?php echo $SITE->path ?>/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo $SITE->path ?>/js/jquery.tree-multiselect.min.js"></script>
<script type="text/javascript" src="<?php echo $SITE->path ?>/js/loadingoverlay.min.js"></script>
<script type="text/javascript" src="<?php echo $SITE->path ?>/js/loadingoverlay_progress.min.js"></script>
</head>
<body>
<div id="container"><div id="topLinks">
</div><div id="content">
<?php
$header = ob_get_clean();
?>
