<?php session_start();?>
<?php ob_start();?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<?php
if($_SESSION["type"]=="admin"){
    include("connect.php");
    $location=trim($_GET['location']);
    if($location!=NULL){
        $sql1="SELECT location FROM location WHERE location=?";
        $result1=$pdo->prepare($sql1);
        $result1->execute(array($location));
        if($result1->rowcount()==0){
            $sql2="INSERT INTO location(location) values(?)";
            $result2=$pdo->prepare($sql2);
            $result2->execute(array($location));
            echo "<script type='text/javascript'>";
            echo "alert('Addition success');";
            echo "window.location.href='location.php'";
            echo "</script>";
        }
        else{
            echo "<script type='text/javascript'>";
            echo "alert('Location has been existed');";
            echo "window.location.href='location_addpage.php'";
            echo "</script>";
        }
    }
    else{
        echo "<script type='text/javascript'>";
        echo "alert('Location cannot be null');";
        echo "window.location.href='location_addpage.php'";
        echo "</script>";
    }
    
}
else
{
    header("Location: index.php");
}
?>