<?php session_start();?>
<?php ob_start();?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<?php
if($_SESSION["id"]!=NULL){
    $user_id=$_SESSION["id"];
    include("connect.php");
    $house_id=$_GET['id'];
    $sql1="SELECT favorite_id FROM favorite WHERE favorite_id=? AND user_id=?";
    $result1=$pdo->prepare($sql1);
    $result1->execute(array($house_id,$user_id));
    $flag=$result1->fetch(PDO::FETCH_OBJ);
    $sql2="INSERT INTO favorite(user_id,favorite_id)values (?,?)";
    $result2=$pdo->prepare($sql2);
    $result2->execute(array($user_id,$house_id));
    header("Location: house_home.php");
    
}
else
{
    header("Location: index.php");
}
?>