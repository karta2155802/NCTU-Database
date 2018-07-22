<?php session_start();?>
<?php ob_start();?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php
include("connect.php");
if($_SESSION['id']==NULL){
    header("Location: index.php");
}
else{
    $house_id=$_GET['id'];
    $sql="SELECT location.location FROM location INNER JOIN house on location.id=house.location WHERE house.id=?";
    $result=$pdo->prepare($sql);
    $result->execute(array($house_id));
    $location="";
    foreach($result as $row){
        $location=$row[0];
    };
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
                <h1>房&nbsp;屋&nbsp;編&nbsp;輯</h1>
            </div>
             <div class="typeforregister";>
                <form action="house_manage_update.php?id=<?php echo $house_id;?>" method="post">
                
                <input class="input" type="text" name="name" placeholder="Name"><br>
                
                <input class="input" type="text" name="price" placeholder="Price"><br>
                <font size=4>Location &emsp;&nbsp;&nbsp;</font><select class="input" name="location" >
                
<?php
                $sql="SELECT * FROM location";
                $result=$pdo->prepare($sql);
                $result->execute();
                foreach($result as $row){
?>
                    <option value="<?php echo $row[0]; ?>"<?php if($location==$row[1]){?>selected<?php }?> ><?php echo $row[1]; ?></option>
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
                    <input type="checkbox" value="<?php echo $row[1]; ?>" name="<?php echo $row[0]; ?>" 
             <?php
                    $sql1="SELECT data.id FROM (data INNER JOIN information on information.information=data.id)INNER JOIN house on house.id=information.house_id WHERE house.id=?";
                    $result1=$pdo->prepare($sql1);
                    $result1->execute(array($house_id));
                    foreach($result1 as $row1){
                        if($row1[0]==$row[0]){?> checked <?php }
                    } 
            ?>
                           ><?php echo $row[1] ?> &nbsp;
<?php
                    $i++;
                    if($i%5==0){echo "<br>";}
                }
?>
                <br><br><p>(未填欄位即不更新)</p><br>
                <input class="input submit" type="submit" value="更新">
                </form>
                <a href="house_manage.php">取消</a>
            </div>
        </body>
    </html>
<?php
}
?>