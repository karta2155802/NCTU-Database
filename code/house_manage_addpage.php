<?php session_start();?>
<?php ob_start();?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php
if($_SESSION['id']!=NULL){
include("connect.php");
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="style.css" media="screen">
        <link rel="stylesheet" href="http://fonts.googleapis.com/earlyaccess/cwtexfangsong.css">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    </head>
    <body>
        <div class="big_title">
            <h1>房&nbsp;屋&nbsp;新&nbsp;增</h1>
        </div>
        <div class="typeforregister";>
            <form action="house_manage_add.php" method="get">                
            <input class="input" type="text" name="name" placeholder="Name"><br>                
            <input class="input" type="text" name="price" placeholder="Price"><br> 
            <font size=4>Location &emsp;&nbsp;&nbsp;</font><select class="input" name="location" >
<?php
            $sql="SELECT * FROM location";
            $result=$pdo->prepare($sql);
            $result->execute();
            foreach($result as $row){
?>
                   <option value="<?php echo $row[0]; ?>" ><?php echo $row[1]; ?></option>
<?php
            }
?>
            </select><br>
            <font size=4>Date</font><input class="input" type="date" name="time"><br>
                           
            <input class="input" type="text" name="owner" placeholder="Owner"><br><br>                
<?php
            $sql="SELECT * from data";
            $result=$pdo->prepare($sql);
            $result->execute();
            $i=0;
            foreach($result as $row){
?>
                <input type="checkbox" value="<?php echo $row[1]; ?>" name="<?php echo $row[0]; ?>" ><?php echo $row[1] ?> &nbsp;
<?php
                $i++;
                    if($i%5==0){echo "<br>";}
            }
?>
            <br><input class="input submit" type="submit" value="新增">
            </form>
            <a href="house_manage.php">取消</a>
        </div>
    </body>
</html>
<?php
}
else{
    header("Location: index.php");
}
?>