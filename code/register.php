<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="style.css" media="screen">
        <link rel="stylesheet" href="http://fonts.googleapis.com/earlyaccess/cwtexfangsong.css">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    </head>
    <body>
        <div class="big_title">
            <h1>註&nbsp;冊</h1>
        </div>
         <div class="typeforregister";>
            <form action="signup.php" method="post">
            <input class="input" type="text" name="account" placeholder="Account"><br>
            <input class="input" type="password" name="pwd" placeholder="Password"><br>
            <input class="input" type="password" name="pwd2" placeholder="Confirm Password"><br>
            <input class="input" type="text" name="name" placeholder="Name"><br>
            <input class="input" type="text" name="email" placeholder="Email"><br>
            <input class="input submit" type="submit" value="註冊">
            </form>
            <p>已經有帳號了?</p>
            <a href="index.php">登入</a>
        </div>
    </body>
</html>