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
        <h1>我&nbsp;的&nbsp;最&nbsp;愛</h1>
        </div>
        <div>
            <table class="admin_table">
                <a href="house_home.php?id!=0" class="add_user">首頁</a>
                <a href="logout.php" class="logout" onClick="return confirm('Confirm Logout？');">登出</a>
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
                    $sql="SELECT house.id, house.name, house.price, location.location, house.time, user.account FROM ((favorite INNER JOIN house ON favorite.favorite_id=house.id) LEFT JOIN user ON house.owner_id=user.id) LEFT JOIN location on house.location=location.id WHERE favorite.user_id=? ORDER BY favorite_id ASC";
                    $result=$pdo->prepare($sql);
                    $result->execute(array($id));
                    $num=$result->rowCount();
                    if($num==0){
                        echo "<br><br>您尚未擁有我的最愛";
                    }
                    foreach($result as $row){
?>
                        <td><?php echo $row[0]?></td>                               
                        <td><?php echo $row[1]?></td>
                        <td><?php echo $row[2]?></td>
                        <td><?php if($row[3]==""){echo "unknown";}else{echo $row[3];}?></td> 
                        <td><?php echo $row[4]?></td> 
                        <td><?php echo $row[5]?></td> 
                        <td>
<?php
                        $sql1="SELECT data FROM (data LEFT JOIN information on information.information=data.id)LEFT JOIN house ON house.id=information.house_id WHERE information.house_id=?";
                        $result1=$pdo->prepare($sql1);
                        $result1->execute(array($row[0]));
                        foreach($result1 as $row1){
                            echo $row1[0];
                            echo "<br>";
                        }
?>
                        </td> 
                        <td><a href="myfavorite_delete.php?id=<?php echo $row[0];?>" onClick="return confirm('Confirm delete？');">Delete</a></td></tr>
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