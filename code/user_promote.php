<?php session_start();?>
<?php ob_start();?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<?php
include("connect.php");
$id=$_GET['id'];
if($_SESSION["type"]=='admin'){
    $sql="SELECT identity FROM user WHERE id=?";
    $result=$pdo->prepare($sql);
    $result->execute(array($id));
    foreach($result as $row){
        if($row[0]=='normal'){
            $sql1="UPDATE user SET identity=? WHERE id=?";
            $result1=$pdo->prepare($sql1);
            $result1->execute(array('admin',$id));
            header("Location: admin.php");
        }
        else{
            echo "<script type='text/javascript'>";
            echo "alert('Cannot promote an admin');";
            echo "window.location.href='admin.php'";
            echo "</script>";
        }
    }    
}
else
{
    header("Location: index.php");
}
?>