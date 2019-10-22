<?php require_once('config.php'); ?>

<?php
	session_destroy();
	header('Location: index.php');
?>
