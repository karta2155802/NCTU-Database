<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
$db_server="dbhome.cs.nctu.edu.tw";
$db_user="fusy1019_cs";
$db_password="yf8177919";
$db_name="fusy1019_cs_hw3";
$pdo=new PDO("mysql:host=$db_server;dbname=$db_name",$db_user,$db_password);
$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
$pdo->query('SET NAMES "utf8"');
?>