<?php session_start(); ?>
<?php ob_start();?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php
include("connect.php");

if($_SESSION["type"]=='normal'){
    $id=$_SESSION['id'];
}
else{
    header("Location: index.php");
}
?>

<html>
    <head>
        <link rel="stylesheet" href="style.css" media="screen">
        <link rel="stylesheet" href="http://fonts.googleapis.com/earlyaccess/cwtexfangsong.css">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    </head>
    <body>
        <div class="big_title">
            <h1>一&nbsp;般&nbsp;使&nbsp;用&nbsp;者</h1>
           
        </div>
        <div>
             <table class="normal_table">
<?php
                    $sql="SELECT * FROM user WHERE id=?";
                    $result=$pdo->prepare($sql);
                    $result->execute(array($id));
                    foreach($result as $row){
?>
                    <tr>
                        <td>帳號</td>
                        <td><?php echo "$row[1]"?></td>
                    </tr>
                    <tr style="background-color:#CFD6DE">
                        <td>名稱</td>
                        <td><?php echo "$row[3]"?></td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td><?php echo "$row[4]"?></td>
                    </tr>
            </table>
<?php
                    }
?>
            <a href="house_home.php?id!=0" class="add_user">首頁</a>
            <a href="logout.php" class="logout" onClick="return confirm('Confirm Logout？');">登出</a>
        </div>
    </body>
</html>