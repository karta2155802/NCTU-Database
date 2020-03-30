<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="style.css" media="screen" />
        <link rel="stylesheet" href="http://fonts.googleapis.com/earlyaccess/cwtexfangsong.css">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>資料庫作業</title>
    </head>
    <body>
        <div class="big_title">
            <h1>登&nbsp;入</h1>
        </div>
         <div class="typeforindex";>
            <form action="login.php" method="post">
            <input class="input" type="text" name="account" placeholder="Account"><br>
            <input class="input" type="password" name="pwd" placeholder="Password"><br>
            <input class="input submit" type="submit" value="登入">
            </form>
            <p>還沒有帳號?</p>
            <a href="register.php">註冊</a>
        </div>
    </body>
</html>