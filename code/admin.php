<?php session_start();?>
<?php ob_start();?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<?php
if($_SESSION["type"]=='admin'){
    include("connect.php");
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
            <h1>管&nbsp;理&nbsp;員</h1>
        </div>
        <div>
            <table class="normal_table">
<?php
                    $id=$_SESSION['id'];
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
            <table class="admin_table">
                <tr>
                    <th>Account</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Identity</th>
                    
                </tr>
<?php
                $sql="SELECT * FROM user WHERE 1";
                $result=$pdo->prepare($sql);
                $result->execute();
                foreach($result as $row){
                    if($_SESSION["id"]==$row[0]){
?>
                        <tr style="background-color:#CFD6DE">
                            <td><?php echo $row[1]?></td>
                            <td><?php echo $row[3]?></td>
                            <td><?php echo $row[4]?></td>
                            <td><?php echo $row[5]?></td>
                        </tr>
<?php
                    }
                    else{
?>
                        <tr>
                            <td><?php echo $row[1]?></td>
                            <td><?php echo $row[3]?></td>
                            <td><?php echo $row[4]?></td>
                            <td><?php echo $row[5]?></td> 
                            <td><a href="user_delete.php?id=<?php echo $row[0];?>" onClick="return confirm('Confirm Delete？');">刪除</a></td>
                            <td><a href="user_promote.php?id=<?php echo $row[0];?>" onClick="return confirm('Confirm Promotion？');">升級</a></td>
                        </tr>
<?php
                    }
                }
?>
                <a href="house_home.php?id!=0" class="add_user">首頁</a>
                <a href="ad_register.php" class="add_user">新增使用者</a>
                <a href="logout.php" class="logout" onClick="return confirm('Confirm Logout？');">登出</a>
            </table>
        </div>
    </body>
</html>
    