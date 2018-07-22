<?php
session_start();
ob_start();
include("connect.php");
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<?php 
if($_SESSION["id"]!=NULL){
    $house_id=$_GET['id'];
    $sql="DELETE FROM house WHERE id=?";
    $result=$pdo->prepare($sql);
    $result->execute(array($house_id));
    header("Location: house_manage.php");
}
else
{
    header("Location: index.php");
}
?>