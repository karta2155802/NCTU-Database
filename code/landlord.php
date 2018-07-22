<?php session_start();?>
<?php ob_start();?>
<?php
include("connect.php");
if($_SESSION['id']!=NULL){
    $id=$_SESSION['id'];
?>
    <html>
     <head>
        <link rel="stylesheet" href="style.css" media="screen">
        <link rel="stylesheet" href="http://fonts.googleapis.com/earlyaccess/cwtexfangsong.css">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    </head>
    <body>
        <div class="big_title">
            <h1>房&nbsp;東&nbsp;管&nbsp;理</h1>
        </div>
        <div>
            <table class="admin_table">
                <a href="house_home.php?id!=0" class="add_user">首頁</a>
                <a href="house_manage.php" class="add_user">房屋管理</a>
                <a href="logout.php" class="logout" onClick="return confirm('Confirm Logout？');">登出</a><br><br>
                <tr>
                    <th>House</th>
                    <th>Check-in</th>
                    <th>Check-out</th>
                    <th>Visitor</th>
                </tr>
                <tr>
<?php
                $sql="SELECT house.name,book.checkin,book.checkout,user.name FROM (house INNER JOIN book on house.id=book.house_id) INNER JOIN user on book.visitor_id=user.id WHERE house.owner_id=?";
                $result=$pdo->prepare($sql);
                $result->execute(array($id));
                foreach($result as $row){
?>
                    <td><?php echo $row[0]?></td>
                    <td><?php echo $row[1]?></td>
                    <td><?php echo $row[2]?></td>
                    <td><?php echo $row[3]?></td>
                </tr>                   
<?php
                }
?>
                
            </table>
        </div>
<?php
    }
    else{
        header("Location: index.php");
    }
?> 