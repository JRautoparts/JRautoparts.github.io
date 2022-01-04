<?php
session_start();
if(isset($_SESSION["username"])){
    echo "user";
    header("Location: ./admin/stat.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" /></head>
<body class="background_login">
<div class="logo">
    <img src="image/Logo.png" class="img_logo"><h1>JR auto parts</h1>
</div>
<div class="retanglelogin">
    <div class="background_login">
        <img src="image/login-img.png">
    </div>
    <form action="login_pc.php" method="POST" class="blockinput">
            <div class="head">
                <i class="fas fa-users">Login</i>
            </div>
            <div>
                <h1><?php if(isset($_SESSION["error"])) {echo $_SESSION["error"];unset($_SESSION["error"]);} ?></h1>
            </div>
            <div class="icon_user">
                <i class="fas fa-user"></i>
                <input class="username" type="text" placeholder="ผู้ดูแล" name="username">
            </div>
            <div class="icon_password">
                <i class="fas fa-lock"></i>
                <input class="password" type="password" placeholder="รหัสผ่าน" name="password">
            </div>
            <div class="icon_submit">
                <i class="fas fa-sign-in"></i>
                <input class="submit" type="submit" value="เข้าสู่ระบบ" name="Submit">
            </div>
    </form>
</div>


</body>
</html>