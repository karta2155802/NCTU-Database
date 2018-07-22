<?php session_start();?>
<?php ob_start();?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<?php
if($_SESSION["type"]=='admin'){
}
else{
    header("Location: index.php");
}
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
            <h1>新&nbsp;增&nbsp;使&nbsp;用&nbsp;者</h1>
        </div>
         <div class="typeforregister";>
            <form action="ad_signup.php" method="post">
            <input class="input" type="text" name="account" placeholder="Account"><br>
            <input class="input" type="password" name="pwd" placeholder="Password"><br>
            <input class="input" type="password" name="pwd2" placeholder="Confirm Password"><br>
            <input class="input" type="text" name="name" placeholder="Name"><br>
            <input class="input" type="text" name="email" placeholder="Email"><br>
            <input class="input" type="radio" name="identity" value="admin"><label>admin</label>
            <input class="input" type="radio" name="identity" value="normal"><label>normal</label><br>
            <input class="input submit" type="submit" value="新增">
            </form>
            <a href="admin.php">回管理者介面</a>
        </div>
    </body>
</html>