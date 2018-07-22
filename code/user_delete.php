<?php session_start();?>
<?php ob_start();?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<?php
if($_SESSION["type"]=='admin'){
    include("connect.php");
    $id=$_GET['id'];
    $sql="DELETE FROM user WHERE id=?";
    $result=$pdo->prepare($sql);
    $result->execute(array($id));
    header("Location: admin.php");
}
else
{
    header("Location: index.php");
}
?>