<?php session_start();?>
<?php ob_start();?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<?php
$account = $_POST['account'];
$pwd = $_POST['pwd'];

if($account!=null&&$pwd!=null&&!preg_match("/ /",$account)&&!preg_match("/ /",$pwd)){
        include("connect.php");
        
        $hashpwd=hash('sha256',$pwd);
        $query="SELECT * FROM user WHERE account=? AND pwd=?";
        $statement=$pdo->prepare($query);
        $statement->execute(array($account,$hashpwd));
        $count=$statement->rowcount();
        if($count==1){
            $sql="SELECT *  FROM `user` WHERE account=?";
            $result=$pdo->prepare($sql);
            $result->execute(array($account));
            foreach($result as $row){
                if($row[5]=='normal'){
                    $_SESSION["id"]=$row[0];
                    $_SESSION["type"]='normal';
                    header("Location: house_home.php?id!=0"); 
                }
                else{
                    $_SESSION["id"]=$row[0];
                    $_SESSION["type"]='admin';
                    header("Location: house_home.php?id!=0");
                } 
            }
        }
        else{
            session_unset();
            session_destroy(); 
            echo "<script type='text/javascript'>";
            echo "alert('Wrong account or password');";
            echo "window.location.href='index.php'";
            echo "</script>";
            }
}
else{
    session_unset();
    session_destroy(); 
    echo "<script type='text/javascript'>";
    echo "alert('Wrong account or password');";
    echo "window.location.href='index.php'";
    echo "</script>";
}
?>
