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
    include("connect.php"); 
    $name=trim($_GET['name']);
    $price=trim($_GET['price']);
    $location_id=trim($_GET['location']); 
    $time=$_GET['time'];
    $owner=trim($_GET['owner']);

    if($name!=NULL&&$price!=NULL&&$location_id!=NULL&&$time!=NULL&&$owner!=NULL){
        $sql_name="SELECT name FROM house WHERE name=?";
        $stmt=$pdo->prepare($sql_name);
        $stmt->execute(array($name));
        if($stmt->rowcount()==0){
            if(is_date($time,$retype=0)){
                if(is_numeric($price)){
                    $sql1="SELECT id FROM user WHERE name=?";
                    $result1=$pdo->prepare($sql1);
                    $result1->execute(array($owner));
                    foreach($result1 as $row){
                        $owner_id=$row[0];
                    }
                    if(empty($owner_id)){
                        echo "<script type='text/javascript'>";
                        echo "alert('No such user');";
                        echo "window.location.href='house_manage_addpage.php'";
                        echo "</script>";
                    }
                    else{                        
                        $sql2="INSERT INTO house(name,price,location,time,owner_id) values(?,?,?,?,?)";
                        $result2=$pdo->prepare($sql2);
                        $result2->execute(array($name,$price,$location_id,$time,$owner_id));
                        $sql3="SELECT id FROM house WHERE name=? AND price=? AND location=? AND time=? AND owner_id=?";
                        $result3=$pdo->prepare($sql3);
                        $result3->execute(array($name,$price,$location_id,$time,$owner_id));
                        foreach($result3 as $row3){
                            $house_id=$row3[0];
                        }
            
                        $sql4="SELECT * FROM data";
                        $result4=$pdo->prepare($sql4);
                        $result4->execute();
                        foreach($result4 as $row4){
                            if(!empty($_GET[$row4[0]])){
                                $sql5="INSERT INTO information(information,house_id) values(?,?)";
                                $result5=$pdo->prepare($sql5);
                                $result5->execute(array($row4[0],$house_id));
                            }
                        }
                        echo "<script type='text/javascript'>";
                        echo "alert('Addition success');";
                        echo "window.location.href='house_manage.php'";
                        echo "</script>";
                    }
                }
                else{
                    echo "<script type='text/javascript'>";
                    echo "alert('Price should be integer');";
                    echo "window.location.href='house_manage_addpage.php'";
                    echo "</script>";
                }
            }
            else{
                echo "<script type='text/javascript'>";
                echo "alert('Wrong time format');";
                echo "window.location.href='house_manage_addpage.php'";
                echo "</script>";
            }
        }
        else{
            echo "<script type='text/javascript'>";
            echo "alert('duplicate house name');";
            echo "window.location.href='house_manage_addpage.php'";
            echo "</script>";
        }
    }
    else{
        echo "<script type='text/javascript'>";
        echo "alert('All field are required');";
        echo "window.location.href='house_manage_addpage.php'";
        echo "</script>";
    }
}
else{
    header("Location: index.php");
}
?>