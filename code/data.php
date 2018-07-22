<?php
session_start();
ob_start();
include("connect.php");
?>
<html>
 <head>
    <link rel="stylesheet" href="style.css" media="screen">
    <link rel="stylesheet" href="http://fonts.googleapis.com/earlyaccess/cwtexfangsong.css">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
    <body>
 <?php
    if($_SESSION["type"]=='admin'){
    ?>
     <div class="big_title">
        <h1>資&nbsp;料&nbsp;清&nbsp;單</h1>
        </div>
        <div>
            <table class="admin_table">
                <a href="house_home.php?id!=0" class="add_user">首頁</a>
                <a href="house_manage.php" class="add_user">房屋管理</a>
                <a href="location.php" class="add_user">地點清單</a>
                <a href="logout.php" class="logout" onClick="return confirm('Confirm Logout？');">登出</a><br><br>
                <a href="data_addpage.php" class="add_user">新增資料</a>
                <tr><br><br>
<?php
                $sql="SELECT * FROM data ORDER BY id";
                $result=$pdo->prepare($sql);
                $result->execute();
                foreach($result as $row){
?>
                <td><?php echo $row[1]?></td>
                <td><a href="data_delete.php?id=<?php echo $row[0];?>" onClick="return confirm('Confirm delete？');">Delete</a></td></tr>
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
    </body>
</html>