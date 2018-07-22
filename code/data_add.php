<?php session_start();?>
<?php ob_start();?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<?php
if($_SESSION["type"]=="admin"){
    include("connect.php");
    $data=trim($_GET['data']);
    if($data!=NULL){
        $sql1="SELECT data FROM data WHERE data=?";
        $result1=$pdo->prepare($sql1);
        $result1->execute(array($data));
        if($result1->rowcount()==0){
            $sql2="INSERT INTO data(data) values(?)";
            $result2=$pdo->prepare($sql2);
            $result2->execute(array($data));
            echo "<script type='text/javascript'>";
            echo "alert('Addition success');";
            echo "window.location.href='data.php'";
            echo "</script>";
        }
        else{
            echo "<script type='text/javascript'>";
            echo "alert('Data has been existed');";
            echo "window.location.href='data_addpage.php'";
            echo "</script>";
        }
    }
    else{
        echo "<script type='text/javascript'>";
            echo "alert('Data cannot be null');";
            echo "window.location.href='data_addpage.php'";
            echo "</script>";
    }
}
else
{
    header("Location: index.php");
}
?>