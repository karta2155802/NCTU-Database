<?php session_start();?>
<?php ob_start();?>
<?php
include("connect.php");
if($_SESSION['id']!=NULL){
    $house_id=$_GET['id'];
?>
    <html>
     <head>
        <link rel="stylesheet" href="style.css" media="screen">
        <link rel="stylesheet" href="http://fonts.googleapis.com/earlyaccess/cwtexfangsong.css">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    </head>
    <body>
        <div class="big_title">
        <h1>訂&nbsp;房&nbsp;</h1>
        </div>
        <div>
            <a href="house_home.php?id!=0" class="add_user">首頁</a>
            <a href="house_manage.php" class="add_user">房屋管理</a>
            <a href="book_manage.php" class="add_user">訂房管理</a><br><br><br>
<?php
            $sql="SELECT name,price,location.location FROM house INNER JOIN location on location.id=house.location WHERE house.id=?";
            $result=$pdo->prepare($sql);
            $result->execute(array($house_id));
            foreach($result as $row){
?>
            <font size=4>House name: <?php echo $row[0]; ?> </font><br>
            <font size=4>Price: <?php echo $row[1]; ?> </font><br>
            <font size=4>Location: <?php echo $row[2]; ?> </font><br>
            <div class="typeforregister";>
                <form action="book.php?id=<?php echo $house_id;?>" method="post">
                    <font size=4>Check-in Date</font>&nbsp;&nbsp;<input class="input" type="date" name="checkin" required><br>
                    <font size=4>Check-out Date</font><input class="input" type="date" name="checkout" required><br>
                    <input class="input submit" type="submit" value="確認">
                </form>
                <a href="house_home.php">取消</a>
            </div>
<?php  
            }   
}
else{
    header("Location: index.php");
}