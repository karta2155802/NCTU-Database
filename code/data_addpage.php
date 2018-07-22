<?php session_start();?>
<?php ob_start();?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php
if($_SESSION['type']=='admin'){
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
            <h1>資&nbsp;料&nbsp;新&nbsp;增</h1>
        </div>
         <div class="typeforregister";>
            <form action="data_add.php" method="get">
            <input class="input" type="text" name="data" placeholder="Data"><br>
            <input class="input submit" type="submit" value="新增">
            </form>
            <a href="data.php">取消</a>
        </div>
    </body>
</html>
<?php   
}
else{
    header("Location: index.php");
}
?>
