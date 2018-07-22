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
        $getdate= date("Y-m-d");
        $id="";$name="";$price="";$location="";$time="";$owner="";
        if(!empty($_GET['order'])){
            $order=$_GET['order'];
           if($order==1){
                $seq="order by price asc";
            }
           elseif($order==2){
               $seq="order by price desc";
           }
           elseif($order==3){
               $seq="order by time asc";
           }
           elseif($order==4){
               $seq="order by time desc";
           }
        }
        else{
            $seq="order by id";
        }
           
        if(!empty($_GET['id'])){
            $id=$_GET['id'];
        }
        else{$id="";}
        if(!empty($_GET['name'])){
            $name=$_GET['name'];
        }
        else{$name="";}
        if(!empty($_GET['price'])){
            $price=$_GET['price'];
        }
        else{$price="";}
        if(!empty($_GET['location'])){
            $location=$_GET['location'];
        }
        else{$location="";}
        if(!empty($_GET['time'])){
            $time=$_GET['time'];
        }
        else{$time="";}
        if(!empty($_GET['owner'])){
            $owner=$_GET['owner'];
        }
        else{$owner="";}
        if(!empty($_GET['checkin'])){
            $checkin=$_GET['checkin'];
        }
        else{$checkin="";}
        if(!empty($_GET['checkout'])){
            $checkout=$_GET['checkout'];
        }
        else{$checkout="";}
        
        if($checkin!=NULL&&$checkout!=NULL){
            if($checkin<$getdate||$checkout<$getdate){
                echo "<script type='text/javascript'>";
                echo "alert('Check-in date and Check-out date should be later than today');";
                echo "window.location.href='house_home'";
                echo "</script>";
            }
            if($checkin>=$checkout){
                echo "<script type='text/javascript'>";
                echo "alert('Check-out date should be later than Check-in date');";
                echo "window.location.href='house_home.php'";
                echo "</script>";
            }
        }
?>
        <div class="big_title">
        <h1>Home&nbsp;Page&nbsp;</h1>
        </div>
        <div class="typeforregister";>
            <a href="house_home.php?id!=0" class="add_user">首頁</a>
<?php
            if($_SESSION["type"]=="admin"){
?>
                <a href="admin.php" class="add_user">會員管理</a>
<?php
            }
            if($_SESSION["type"]=="normal"){
?>
                <a href="member.php" class="add_user">我的資料</a>
<?php
            }
?>
                <a href="house_manage.php" class="add_user">房屋管理</a>
                <a href="book_manage.php" class="add_user">訂房管理</a>
                <a href="myfavorite.php" class="add_user">我的最愛</a>
                <a href="logout.php" class="logout" onClick="return confirm('Confirm Logout？');">登出</a><br><br>
                <table class="admin_table">
                
                <tr>
                    <form action="house_home.php?" method="get">
                    <input class="home_input" id="id" type="text" name="id" value="<?php echo $id ?>" placeholder="ID">
                    <input class="home_input" id="name" type="text" name="name" value="<?php echo $name ?>" placeholder="Name">
                    <select class="home_input" id="price" size=1 name="price" >
                        <option value="" >Price</option>
                        <option value="0~500" <?php if($price=="0~500"){ ?>selected<?php } ?>>0~500</option>
                        <option value="501~1000" <?php if($price=="501~1000"){ ?>selected<?php } ?>>501~1000</option>
                        <option value="1001~1500" <?php if($price=="1001~1500"){ ?>selected<?php } ?>>1001~1500</option>
                        <option value="1501~" <?php if($price=="1501~"){ ?>selected<?php } ?>>1501~</option>
                    </select>
                    <input class="home_input" id="location" type="text" name="location" value="<?php echo $location ?>" placeholder="Location">
                    <input class="home_input" id="time" type="text" name="time" value="<?php echo $time ?>" placeholder="Time">
                    <input class="home_input" id="owner" type="text" name="owner" value="<?php echo $owner ?>" placeholder="Owner"><br>
                    <font size=2>Check-in Date</font><input class="home_input" type="date" name="checkin" required value="<?php echo $checkin ?>"> &emsp;
                    <font size=2>Check-out Date</font><input class="home_input" type="date" name="checkout" required value="<?php echo $checkout ?>"><br>
                        
                    
<?php
                    $data="SELECT * from data";
                    $info="SELECT id FROM house";
                    $dataresult=$pdo->prepare($data);
                    $dataresult->execute();
                    foreach($dataresult as $row){                        
?>
                        <div class="input_checkbox"><input type="checkbox" value="<?php echo $row[0]; ?>" name="<?php echo $row[0]; ?>"
<?php
                                                
                        if(!empty($_GET[$row[0]])){ ?> checked <?php } ?> ><?php echo $row[1] ?>&nbsp;</div>
<?php               
                        
                        if(!empty($_GET[$row[0]])){
                            $info="SELECT house_id FROM information WHERE information='".$row[0]."' AND house_id in (".$info.")";
                        }      
                    }
?>
                    
                    <br><input class="input submit" type="submit" value="Search"><br>
                    <font size=1>(設定搜尋時間後方可訂房)</font>
                    </form>
                </tr>
                
                <tr>
                    <th>House_ID</th>
                    <th>Name</th>
                    <th>
                        <a href="<?php echo $_SERVER['REQUEST_URI']; ?>&&order=1" >&darr;</a>Price<a href="<?php echo $_SERVER['REQUEST_URI']; ?>&&order=2" >&uarr;</a>
                    </th>
                    <th>Location</th>
                    <th>
                        <a href="<?php echo $_SERVER['REQUEST_URI']; ?>&&order=3">&darr;</a>Time<a href="<?php echo $_SERVER['REQUEST_URI']; ?>&&order=4">&uarr;</a>
                    </th>
                    <th>Owner</th>
                    <th>Information</th>
                    <th>Option</th>
                </tr>

                
<?php
                    $sql="SELECT house.id FROM (house LEFT JOIN user ON house.owner_id=user.id)LEFT JOIN location on house.location=location.id
                    WHERE (CASE WHEN :id='' THEN 1 ELSE house.id=:id END)
                    AND (CASE WHEN :name='' THEN 1 ELSE house.name like CONCAT('%',:name,'%') END)
                    AND (CASE WHEN :price='' THEN 1 
                        WHEN :price='0~500' THEN house.price between 0 and 500 
                        WHEN :price='501~1000' THEN house.price between 501 and 1000
                        WHEN :price='1001~1500' THEN house.price between 1001 and 1500
                        WHEN :price='1500~' THEN house.price>=1501 END)
                    AND (CASE WHEN :location='' THEN 1 ELSE location.location like CONCAT('%',:location,'%') END) 
                    AND (CASE WHEN :time='' THEN 1 ELSE house.time like CONCAT('%',:time,'%')  END)
                    AND (CASE WHEN :owner='' THEN 1 ELSE user.account like CONCAT('%',:owner,'%') END) ";
                    
                    $check="SELECT house.id FROM house LEFT JOIN book on house.id=book.house_id 
                    WHERE (CASE WHEN :checkin='' THEN 1 ELSE checkin<:checkout END)
                    AND (CASE WHEN :checkout='' THEN 1 ELSE checkout>:checkin END)";
                    
                    

                    $atr="SELECT  house.id, house.name, house.price, location.location, house.time, user.account FROM (house LEFT JOIN user ON house.owner_id = user.id)LEFT JOIN location on house.location=location.id WHERE house.id in ($sql) AND (CASE WHEN :checkin='' THEN house.id in ($check) ELSE house.id not in ($check) END) AND house.id in ($info) $seq";
                    $result=$pdo->prepare($atr);
                    $result->execute(array(":id"=>$id,":name"=>$name,":price"=>$price,":location"=>$location,":time"=>$time,":owner"=>$owner,":checkin"=>$checkin,":checkout"=>$checkout));
                    $per=5;
                    $data_num=$result->rowcount();
                    $pages=ceil($data_num/$per);
                    if(!isset($_GET["page"])){
                        $page=1;
                    }
                    else{
                        $page=$_GET["page"];
                    }
                    $start=($page-1)*$per;
 
                    if($data_num!=0){
                        $result=$pdo->prepare($atr.' LIMIT '.$start.', '.$per);
                        $result->execute(array(":id"=>$id,":name"=>$name,":price"=>$price,":location"=>$location,":time"=>$time,":owner"=>$owner,":checkin"=>$checkin,":checkout"=>$checkout));
?>
                <tr>
<?php

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
                            $sql2="SELECT data FROM (data LEFT JOIN information on information.information=data.id)LEFT JOIN house ON house.id=information.house_id WHERE information.house_id=?";
                            $result2=$pdo->prepare($sql2);
                            $result2->execute(array($row[0]));
                            foreach($result2 as $rows){
                                echo $rows[0];
                                echo "<br>";
                            }
 ?>
                            </td>
                            <td>
<?php
                            $sql_fa="SELECT id FROM favorite WHERE favorite.favorite_id=? AND favorite.user_id =(SELECT id FROM user WHERE id=?)";
                            $stmt=$pdo->prepare($sql_fa);
                            $stmt->execute(array($row[0],$_SESSION["id"]));
                            if($stmt->rowcount()==1){
?>
                                <font size="1">已經在我的最愛</font><br>
<?php                                
                            }
                            else{
?>
                                <a href="myfavorite_add.php?id=<?php echo $row['id'];?>" onClick="return confirm('Add into your favorite？');">加入我的最愛</a><br>                            
<?php
                                }
                            if($checkin!=""){
?>
                                <a href="bookpage.php?id=<?php echo $row['id'];?>" >訂房</a><br>
<?php
                            }

                            if($_SESSION["type"]=="admin"){
?>
                                <a href="home_delete.php?id=<?php echo $row[0];?>" onClick="return confirm('Confirm delete？');">刪除</a>
<?php
                            }
?>
                        </td>
                    </tr>
<?php 
                        }
                    }
                    else{
                        echo "<br><br>沒有搜尋結果";
                    }
?>
             </table>
<?php
        echo '共 '.$data_num.' 筆-在 '.$page.' 頁-共 '.$pages.' 頁';
        echo "<br /><a href=".$_SERVER['REQUEST_URI']."&page=1>首頁</a> ";
        echo "第 ";
        for( $i=1 ; $i<=$pages ; $i++ ) {
            if ( $page-3 < $i && $i < $page+3 ) {
                echo "<a href=".$_SERVER['REQUEST_URI']."&page=".$i.">".$i."</a> ";
            }
        } 
        echo " 頁 <a href=".$_SERVER['REQUEST_URI']."&page=".$pages.">末頁</a><br /><br />";
    } 
    else{
        header("Location: index.php");
    }
?>
        </div>
</body>
</html>