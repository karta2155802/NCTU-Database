<?php
session_start();
ob_start();
include("connect.php");
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<?php 
if($_SESSION["type"]=='admin'){
    $house_id=$_GET['id'];
    $sql2="DELETE FROM house WHERE id=?";
    $result2=$pdo->prepare($sql2);
    $result2->execute(array($house_id));
    header("Location: house_home.php?id!=0");
}
else
{
    header("Location: index.php");
}
?>