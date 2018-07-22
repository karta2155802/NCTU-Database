<?php session_start();?>
<?php ob_start();?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<?php
if($_SESSION["id"]!=NULL){
    include("connect.php");
    $book_id=$_GET['id'];
    $sql="DELETE FROM book WHERE id=?";
    $result=$pdo->prepare($sql);
    $result->execute(array($book_id));
    header("Location: book_manage.php");
}
else
{
    header("Location: index.php");
}
?>