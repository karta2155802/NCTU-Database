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
        <h1>房&nbsp;屋&nbsp;管&nbsp;理</h1>
        </div>
        <div>
            
                <a href="house_home.php?id!=0" class="add_user">首頁</a>
                <a href="house_manage_addpage.php" class="add_user">新增房子</a>
                <a href="landlord.php" class="add_user">房東管理</a>
<?php
                if($_SESSION["type"]=='admin'){
?>
                    <a href="location.php" class="add_user">地點清單</a>
                    <a href="data.php" class="add_user">資料清單</a>
<?php           }
?>     
                <a href="logout.php" class="logout" onClick="return confirm('Confirm Logout？');">登出</a>
         </div><br>
            <div>
                <table class="admin_table">
                <tr>
                    <th>House_ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Location</th>
                    <th>Time</th>
                    <th>Owner</th>
                    <th>Information </th>
                    <th>Option</th>
                </tr>
                <tr>
<?php 
                    $sql2="SELECT house.id, house.name, house.price, location.location, house.time, user.account FROM (house LEFT JOIN user ON house.owner_id = user.id)LEFT JOIN location on house.location=location.id WHERE owner_id=? ORDER BY id ASC";
                    $result2=$pdo->prepare($sql2);
                    $result2->execute(array($id));
                    $num=$result2->rowcount();
                    if($num==0){
                        echo "<br><br>您尚未擁有任何房子";
                    }
                    foreach($result2 as $row){
?>
                        <td><?php echo $row[0]?></td>                               
                        <td><?php echo $row[1]?></td>
                        <td><?php echo $row[2]?></td>
                        <td><?php if($row[3]==""){echo "unknown";}else{echo $row[3];} ?></td> 
                        <td><?php echo $row[4]?></td> 
                        <td><?php echo $row[5]?></td> 
                        <td>
<?php
                        $sql3="SELECT data FROM (data LEFT JOIN information on information.information=data.id)LEFT JOIN house ON house.id=information.house_id WHERE information.house_id=?";
                        $result3=$pdo->prepare($sql3);
                        $result3->execute(array($row[0]));
                        foreach($result3 as $rows){
                            echo $rows[0];
                            echo "<br>";
                        };
?>
                        </td>
                        <td><a href="house_manage_updatepage.php?id=<?php echo $row[0];?>" >編輯</a><br>
                        <a href="house_manage_delete.php?id=<?php echo $row[0];?>" onClick="return confirm('Confirm delete？');">Delete</a></td></tr>
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