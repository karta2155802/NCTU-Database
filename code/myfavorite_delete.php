<?php session_start();?>
<?php ob_start();?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<?php
if($_SESSION["id"]!=NULL){
    include("connect.php");
    $id=$_GET['id'];
    $sql="DELETE FROM favorite WHERE favorite_id=?";
    $result=$pdo->prepare($sql);
    $result->execute(array($id));
    header("Location: myfavorite.php");
    
}
else
{
    header("Location: index.php");
}
?>