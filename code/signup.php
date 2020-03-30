<?php ob_start();?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php
include("connect.php");
    
$account=$_POST['account'];
$pwd=$_POST['pwd'];
$pwd2=$_POST['pwd2']; 
$name=$_POST['name'];
$email=$_POST['email'];      

if($account!=null&&$pwd!=null&&$pwd2!=null&&$name!=null&&$email!=null){
    if($pwd==$pwd2){
      if(!preg_match("/ /",$account)&&!preg_match("/ /",$pwd)&&!preg_match("/ /",$email)){
            if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                $sql1="SELECT account FROM user WHERE account=:account LIMIT 1";
                $result=$pdo->prepare($sql1);
                $result->execute(array('account'=>$account));
                $flag=$result->fetch(PDO::FETCH_OBJ);
                if($flag){
                    echo "<script type='text/javascript'>";
                    echo "alert('Account has been used');";
                    echo "window.location.href='register.php'";
                    echo "</script>";
                 }
                else{
                        
                    $hashpwd=hash('sha256',$pwd);
                    $sql2="INSERT INTO user(account,pwd,name,email)
                    values('$account','$hashpwd','$name','$email')";
                    $statement2=$pdo->prepare($sql2);                           
                    $statement2->execute(array($account,$hashpwd,$name,$email));
                    echo "<script type='text/javascript'>";
                    echo "alert('Sign up success');";
                    echo "window.location.href='index.php'";
                    echo "</script>";
                }
            } 
             else{
                echo "<script type='text/javascript'>";
                echo "alert('Wrong email format');";
                echo "window.location.href='register.php'";
                echo "</script>";
            }
        }
        else{
            echo "<script type='text/javascript'>";
            echo "alert('Cannot have any space');";
            echo "window.location.href='register.php'";
            echo "</script>";
        }
    }
     else{
        echo "<script type='text/javascript'>";
        echo "alert(Password not confirm');";
        echo "window.location.href='register.php'";
        echo "</script>";
    }
}
else{
     echo "<script type='text/javascript'>";
     echo "alert('All field are required');";
     echo "window.location.href='register.php'";
     echo "</script>";
 }
?>