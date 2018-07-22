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
    if($_SESSION["id"]!=NULL){
        $id=$_SESSION["id"];
        
?>
        <div class="big_title">
        <h1>訂&nbsp;房&nbsp;管&nbsp;理</h1>
        </div>
        <div>
            <a href="house_home.php?id!=0" class="add_user">首頁</a>
            <a href="house_manage.php" class="add_user">房屋管理</a>
            <a href="myfavorite.php" class="add_user">我的最愛</a>
            <a href="logout.php" class="logout" onClick="return confirm('Confirm Logout？');">登出</a><br><br>
            <table class="admin_table">
                <!--------------->                
                <tr>
                    <th>House_ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Location</th>
                    <th>Time</th>
                    <th>Owner</th>
                    <th>Check-in</th>
                    <th>Check-out</th>
                    <th>Information</th>
                    <th>Option</th>
                </tr>
                <tr>
<?php
        
                $all="SELECT house.id, house.name, house.price, location.location, house.time, user.account,book.checkin,book.checkout,book.id FROM ((house LEFT JOIN user ON house.owner_id = user.id)LEFT JOIN location on house.location=location.id)INNER JOIN book on book.house_id=house.id WHERE visitor_id=?";
                $allresult=$pdo->prepare($all);
                $allresult->execute(array($id));
                foreach($allresult as $row){
?>
                    <td><?php echo $row[0]?></td>                               
                    <td><?php echo $row[1]?></td>
                    <td><?php echo $row[2]?></td>
                    <td><?php if($row[3]==""){echo "unknown";}else{echo $row[3];}?></td> 
                    <td><?php echo $row[4]?></td> 
                    <td><?php echo $row[5]?></td>
                    <td><?php echo $row[6]?></td>
                    <td><?php echo $row[7]?></td>
                    <td>
<?php
                    $sql="SELECT data FROM (data LEFT JOIN information on information.information=data.id)LEFT JOIN house ON house.id=information.house_id WHERE information.house_id=?";
                    $result=$pdo->prepare($sql);
                    $result->execute(array($row[0]));
                    foreach($result as $rows){
                        echo $rows[0];
                        echo "<br>";
                    }
?>
                    </td>
                    <td>
                        <a href="book_updatepage.php?id=<?php echo $row[8];?>">修改時間</a><br>
                        <a href="book_delete.php?id=<?php echo $row[8];?>" onClick="return confirm('Confirm delete？');">刪除訂房</a>
                    </td>
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
</body>
</html>