<?php session_start();?>
<?php ob_start();?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php
if($_SESSION['id']!=NULL){
    $getdate= date("Y-m-d");
    $book_id=$_GET['id'];
    include("connect.php");
    $checkin=$_POST['checkin'];
    $checkout=$_POST['checkout'];
    if($checkin>$getdate&&$checkout>$getdate){
        if($checkin>=$checkout){
            echo "<script type='text/javascript'>";
            echo "alert('Check-out date should be later than Check-in date');";
            echo "window.location.href='book_updatepage?id=$book_id.php'";
            echo "</script>";
        }
        else{
            $sql="SELECT house_id FROM book WHERE id=?";
            $result=$pdo->prepare($sql);
            $result->execute(array($book_id));
            foreach($result as $row){
                $house_id=$row[0];
            }

            $check="SELECT book.id FROM book WHERE book.house_id=:house_id AND checkin<:checkout AND  checkout>:checkin AND book.id!=:book_id";
            $checkresult=$pdo->prepare($check);
            $checkresult->execute(array(":checkin"=>$checkin,":checkout"=>$checkout,"house_id"=>$house_id,":book_id"=>$book_id));
            $count=$checkresult->rowcount();
            if($count==0){
                $sql="UPDATE book SET checkin=?,checkout=? WHERE id=?";
                $result=$pdo->prepare($sql);
                $result->execute(array($checkin,$checkout,$book_id));
                echo "<script type='text/javascript'>";
                echo "alert('Update success');";
                echo "window.location.href='book_manage.php'";
                echo "</script>";
            }
            else{
                $message="";
                $t=$checkin;
                for($t;$t<$checkout;$t=date("Y-m-d",strtotime("+1 day",strtotime($t))))
                {
                    $T=date("Y-m-d",strtotime("+1 day",strtotime($t)));
                    $check="SELECT * FROM book WHERE checkin<:checkout AND checkout>:checkin AND house_id=:id AND book.id!=:book_id";
                    $checkresult=$pdo->prepare($check);
                    $checkresult->execute(array(":checkin"=>$t,":checkout"=>$T,":id"=>$house_id,":book_id"=>$book_id));
                    $count=$checkresult->rowcount();
                    if($count!=0)
                    {   
                        $message=$message.$t." ";
                    }
                }
                echo "<script type='text/javascript'>";
                echo "alert('$message'+' cannot be reserved');";
                echo "window.location.href='book_updatepage.php?id=$book_id'";
                echo "</script>";
            }
        }
    }
    else{
        echo "<script type='text/javascript'>";
        echo "alert('Check-in date and Check-out date should be later than today');";
        echo "window.location.href='book_updatepage.php?id=$book_id'";
        echo "</script>";
    }
}
else
{
    header("Location: index.php");
}
?>