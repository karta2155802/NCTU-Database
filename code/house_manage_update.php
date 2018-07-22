<?php session_start();?>
<?php ob_start();?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php
function is_date($str,$retype=0){
    $reVal = "";
    $dateArr = explode("-", $str);
    if(count($dateArr) != 3) return false;
    $year  = $dateArr[0];
    $month = $dateArr[1];
    $day   = $dateArr[2];

    switch($retype){
    case 1:
    if(checkdate($month, $day, $year)){$reVal = sprintf("%04d-%02d-%02d",$year,$month,$day);}else{$reVal = false;}
    break;
    default:$reVal = checkdate($month, $day, $year);break;
    }
    return $reVal;
}

if($_SESSION['id']!=NULL){
    $house_id=$_GET['id'];
    include("connect.php"); 
    $name=trim($_POST['name']);
    $price=trim($_POST['price']);
    $location=trim($_POST['location']); 
    $time=$_POST['time'];
    $owner=trim($_POST['owner']);
    
    if($name!=NULL){
        $sql="UPDATE house SET name=? WHERE id=?";
        $result=$pdo->prepare($sql);
        $result->execute(array($name,$house_id));
    }
    if($price!=NULL){
        if(is_numeric($price)){
            $sql="UPDATE house SET price=? WHERE id=?";
            $result=$pdo->prepare($sql);
            $result->execute(array($price,$house_id));
        }
        else{
            echo "<script type='text/javascript'>";
            echo "alert('Price should be integer! Price update fail!');";
            echo "window.location.href='house_manage_updatepage.php?id=$house_id'";
            echo "</script>";
        } 
    }
    if($location!=NULL){
        $sql="UPDATE house SET location=? WHERE id=?";
        $result=$pdo->prepare($sql);
        $result->execute(array($location,$house_id));
    }
    if($time!=NULL){
        if(is_date($time,$retype=0)){
            $sql="UPDATE house SET time=? WHERE id=?";
            $result=$pdo->prepare($sql);
            $result->execute(array($time,$house_id));
        }
        else{
            echo "<script type='text/javascript'>";
            echo "alert('Wrong time format! Time update fail!');";
            echo "window.location.href='house_manage_updatepage.php?id=$house_id'";
            echo "</script>";
        }  
    }
    if($owner!=NULL){
        $sql="SELECT id FROM user WHERE name=?";
        $result=$pdo->prepare($sql);
        $result->execute(array($owner));
        foreach($result as $row){
             $owner_id=$row[0];
        }
        if(empty($owner_id)){
            echo "<script type='text/javascript'>";
            echo "alert('No such user! Update owner fail!');";
            echo "window.location.href='house_manage_updatepage.php?id=$house_id'";
            echo "</script>";
        }
        else{
            $sql1="UPDATE house SET owner_id=? WHERE id=?";
            $result1=$pdo->prepare($sql1);
            $result1->execute(array($owner_id,$house_id));
        }
    }
    $sql="DELETE FROM information WHERE house_id=?";
    $result=$pdo->prepare($sql);
    $result->execute(array($house_id));
    $sql="SELECT * FROM data";
    $result=$pdo->prepare($sql);
    $result->execute();
    foreach($result as $row){
        if(!empty($_POST[$row[0]])){
            $sql1="INSERT INTO information(information,house_id) values(?,?)";
            $result1=$pdo->prepare($sql1);
            $result1->execute(array($row[0],$house_id));
        }
    }
    echo "<script type='text/javascript'>";
    echo "alert('Update success');";
    echo "window.location.href='house_manage.php'";
    echo "</script>";
}
else{
    header("Location: index.php");
}
?>