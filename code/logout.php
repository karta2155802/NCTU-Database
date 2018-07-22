<?php session_start(); ?>
<?php ob_start();?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
session_unset();
session_destroy();
header("Location: index.php");
?>