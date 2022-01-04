<?php
session_start();
include('connect.php');
if(isset($_POST["Submit"])){
    $username = $_POST["username"];
    $password = $_POST["password"];
    if(empty($_POST["username"]) && !empty($_POST["password"])){
        $_SESSION['error'] = "กรุณากรอกUsername";
        header("Location: loginadmin.php");
    }
    else if(empty($_POST["password"]) && !empty($_POST["username"])){
        $_SESSION['error'] = "กรุณากรอกPassword";
        header("Location: loginadmin.php");
    }
    else if(empty($_POST["username"] && $_POST["password"])){
        $_SESSION['error'] = "กรุณากรอกUsernameและPassword";
        header("Location: loginadmin.php");
    }
    else{
        $sql =  "SELECT * FROM admin WHERE admin_username='$username' AND admin_password = '$password'";
        $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result)==1){
            $_SESSION['username'] = $username;
            $_SESSION['success'] = "เข้าสู่ระบบสำเร็จ";
            header("Location: ./admin/statistics/stat.php");
        }
        else{
            $_SESSION['error'] = "UsernameหรือPasswordผิด!!";
            header('Location: loginadmin.php');
        }
    }
}
?>