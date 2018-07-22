<?php session_start();?>
<?php ob_start();?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<?php

if($_SESSION["type"]=='admin'){
    include("connect.php");
    $account=trim($_POST['account']);
    $pwd=$_POST['pwd'];
    $pwd2=$_POST['pwd2'];
    $name=trim($_POST['name']);
    $email=trim($_POST['email']);      
    if($account!=null&&$pwd!=null&&$pwd2!=null&&$name!=null&&$email!=null&&isset($_POST['identity'])){
        $identity=$_POST['identity'];
        if($pwd==$pwd2){
            if(!preg_match("/ /",$account)&&!preg_match("/ /",$pwd)&&!preg_match("/ /",$email)){
                if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                    $sql1="SELECT account FROM user WHERE account=? LIMIT 1";
                    $result=$pdo->prepare($sql1);
                    $result->execute(array($account));
                    $flag=$result->fetch(PDO::FETCH_OBJ);
                    if($flag){
                        echo "<script type='text/javascript'>";
                        echo "alert('Account has been used');";
                        echo "window.location.href='ad_register.php'";
                        echo "</script>";
                    }
                    else{
                        $hashpwd=hash('sha256',$pwd);
                        $sql2="INSERT INTO user(account,pwd,name,email,identity)
                        values(?,?,?,?,?)";
                        $statement2=$pdo->prepare($sql2);
                        $statement2->execute(array($account,$hashpwd,$name,$email,$identity));
                        echo "<script type='text/javascript'>";
                        echo "alert('Sign up success');";
                        echo "window.location.href='admin.php'";
                        echo "</script>";
                    }
                }
                else{
                    echo "<script type='text/javascript'>";
                    echo "alert('Wrong email format');";
                    echo "window.location.href='ad_register.php'";
                    echo "</script>";
                }
            }
            else{
                echo "<script type='text/javascript'>";
                echo "alert('Cannot have any space');";
                echo "window.location.href='ad_register.php'";
                echo "</script>";
            }
         }
        else{
            echo "<script type='text/javascript'>";
            echo "alert('Password not confirm');";
            echo "window.location.href='ad_register.php'";
            echo "</script>";
        }
    }
    else{
        echo "<script type='text/javascript'>";
        echo "alert('All field are required');";
        echo "window.location.href='ad_register.php'";
        echo "</script>";
    }
}
else
{
    header("Location: index.php");
}
?>