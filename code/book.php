<?php session_start();?>
<?php ob_start();?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php

function addDayswithdate($date,$days){
    $date = strtotime("+".$days." days", strtotime($date));
    return  date("Y-m-d", $date);
}
if($_SESSION['id']!=NULL){
    $getdate= date("Y-m-d");
    $id=$_SESSION['id'];
    $house_id=$_GET['id'];
    include("connect.php");
    $checkin=$_POST['checkin'];
    $checkout=$_POST['checkout'];
    
    if($checkin>$getdate&&$checkout>$getdate){
        if($checkin>=$checkout){
            echo "<script type='text/javascript'>";
            echo "alert('Check-out date should be later than Check-in date');";
            echo "window.location.href='bookpage?id=$id.php'";
            echo "</script>";
        }
        else{
            $check="SELECT * FROM book WHERE checkin<:checkout AND checkout>:checkin AND house_id=:id";
            $checkresult=$pdo->prepare($check);
            $checkresult->execute(array(":checkin"=>$checkin,":checkout"=>$checkout,":id"=>$house_id));
            $count=$checkresult->rowcount();
            if($count==0){
                $sql="INSERT INTO  book(checkin,checkout,house_id,visitor_id) values(?,?,?,?)";
                $result=$pdo->prepare($sql);
                $result->execute(array($checkin,$checkout,$house_id,$id));
                echo "<script type='text/javascript'>";
                echo "alert('Reservation success');";
                echo "window.location.href='book_manage.php'";
                echo "</script>";
            }
            else{
                $message="";
                $t=$checkin;
                for($t;$t<$checkout;$t=date("Y-m-d",strtotime("+1 day",strtotime($t))))
                {
                    $T=date("Y-m-d",strtotime("+1 day",strtotime($t)));
                    $check="SELECT * FROM book WHERE checkin<:checkout AND checkout>:checkin AND house_id=:id";
                    $checkresult=$pdo->prepare($check);
                    $checkresult->execute(array(":checkin"=>$t,":checkout"=>$T,":id"=>$house_id));
                    $count=$checkresult->rowcount();
                    if($count!=0)
                    {   
                        $message=$message.$t." ";
                    }
                }
                echo "<script type='text/javascript'>";
                echo "alert('$message'+' cannot be reserved');";
                echo "window.location.href='bookpage.php?id=$house_id'";
                echo "</script>";
            }
        } 
    }
    else{
        echo "<script type='text/javascript'>";
        echo "alert('Check-in date and Check-out date should be later than today');";
        echo "window.location.href='bookpage.php?id=$house_id'";
        echo "</script>";
    }
}
else
{
    header("Location: index.php");
}
?>