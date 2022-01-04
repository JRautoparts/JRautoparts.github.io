<?php
session_start();
ob_start();
include('../../connect.php');
if(!isset($_SESSION["username"])){
    header("Location: ../../loginadmin.php");
    $_SESSION["error"] = "กรุณาloginเพื่อเข้าสู่ระบบ";
}
else if(isset($_POST["logout"])){
    session_destroy();
    header("location: ../../loginadmin.php");
    exit();
}
$useradmin = $_SESSION["username"];
$sqladmin = "SELECT admin_ID FROM admin WHERE admin_username = '$useradmin' ";
$resultadmin = mysqli_query($conn, $sqladmin);
$row =  mysqli_fetch_assoc($resultadmin);

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <title>JR Auto Part | Admin page</title>
    <link rel="stylesheet" href="../../css/home.css">
    <link rel="stylesheet" href="../../css/menu.css">
    <!-- Boxiocns CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>
<body>
<div class="sidebar close">
    <div class="logo-details">
        <i class='bx bx-menu'></i>
        <span class="logo_name">JR Auto Parts</span>
    </div>
    <ul class="nav-links">
        <li>
            <a href="../statistics/stat.php">
                <i class='bx bx-grid-alt' ></i>
                <span class="link_name">หน้าหลัก</span>
            </a>
            <ul class="sub-menu blank">
                <li><a class="link_name" href="../statistics/stat.php">หน้าหลัก</a></li>
            </ul>
        </li>
        <li>
            <div class="iocn-link">
                <a href="../userinformation/userinformation.php">
                    <i class='bx bx-group' ></i>
                    <span class="link_name">ลูกค้า</span>
                </a>
                <i class='bx bxs-chevron-down arrow' ></i>
            </div>
            <ul class="sub-menu">
                <li><a class="link_name" href="../userinformation/userinformation.php">ลูกค้า</a></li>
                <li><a href="../userinformation/userinformation.php">ข้อมูลลูกค้า</a></li>
                <li><a href="../customerservice/customerservice.php">การบริการลูกค้า</a></li>
            </ul>
        </li>
        <li>
            <div class="iocn-link">
                <a href="../serviceinformation/serviceinformation.php">
                    <i class='bx bx-cart-alt' ></i>
                    <span class="link_name">บริการ</span>
                </a>
                <i class='bx bxs-chevron-down arrow' ></i>
            </div>
            <ul class="sub-menu">
                <li><a class="link_name" href="../serviceinformation/serviceinformation.php">บริการ</a></li>
                <li><a href="../serviceinformation/serviceinformation.php">การบริการ</a></li>
                <li><a href="../serviceaccess/serviceaccess.php">การเข้ารับบริการ</a></li>
            </ul>
        </li>
        <li>
            <div class="iocn-link">
                <a href="../productinformation/productinformation.php">
                    <i class='bx bx-package' ></i>
                    <span class="link_name">สินค้า</span>
                </a>
                <i class='bx bxs-chevron-down arrow' ></i>
            </div>
            <ul class="sub-menu">
                <li><a class="link_name" href="../productinformation/productinformation.php">สินค้า</a></li>
                <li><a href="../productinformation/productinformation.php">ข้อมูล</a></li>
                <li><a href="../producttype/producttypeinformation.php">ประเภท</a></li>
            </ul>
        </li>
        <li>
            <div class="iocn-link">
                <a href="../news/newsinformation.php">
                    <i class='bx bxs-megaphone' ></i>
                    <span class="link_name">ประชาสัมพันธ์</span>
                </a>
                <i class='bx bxs-chevron-down arrow' ></i>
            </div>
            <ul class="sub-menu">
                <li><a class="link_name" href="../news/newsinformation.php">ประชาสัมพันธ์</a></li>
                <li><a href="../news/newsinformation.php">ข่าวสาร</a></li>
                <li><a href="../promotion/promotioninformation.php">โปรโมชั่น</a></li>
            </ul>
        </li>
        <li>
            <div class="profile-details">
                <div class="profile-content">
                    <img src="../../image/Logo.png" alt="profileImg">
                </div>
                <div class="name-job">
                    <div class="profile_name">Beeba Tester</div>
                    <div class="job">Default profile</div>
                </div>
                <i class='bx bx-log-out' ></i>
            </div>
        </li>
    </ul>
</div>
<section class="home-section">
    <body>
    <h2>เพิ่มข่าวสาร</h2>
    <div>
        <?php if(isset($_SESSION["success"])) {
            echo "<H1 style=color:green>$_SESSION[success]</H1>";
            unset($_SESSION["success"]);
        }
        elseif (isset($_SESSION["error"])){
            echo "<H1 style=color:red>$_SESSION[error]</H1>";
            unset($_SESSION["error"]);
        }
        ?>
    </div>
    <form method="post" enctype="multipart/form-data">
        <div>
            ชื่อข่าว :
            <input type="text" name="newsname">
        </div>
        <div>
            รายละเอียด :
            <input type="text" name="newsdetails">
        </div>
        <div>
            รูปภาพ :
            <input type="file" name="fileToUpload">
        </div>
        <div>
            <input type="submit" value="เพิ่มข้อมูล" name="submit">
        </div>
        <button><a href="./newsinformation.php">ย้อนกลับ</a></button>


    </form>
    <?php
    if(isset($_POST["submit"])){
        $name = $_POST["newsname"];
        $details = $_POST["newsdetails"];
        $newsimg = $_FILES["fileToUpload"]["name"];
        $idadmin = $row['admin_ID'];
        // print_r($_POST);
        $target_file = '../imageupload/news/' . basename($newsimg);
        $sql = "INSERT INTO news (news_name,news_details,news_image,admin_ID) VALUES ('$name','$details','$newsimg','$idadmin')";
        $query = mysqli_query($conn,$sql);
        if($query){
            move_uploaded_file($_FILES['fileToUpload']['tmp_name'],"$target_file");
            header("Location: ./addnews.php");
            $_SESSION["success"] = "เพิ่มข้อมูลเรียบร้อย";
        }
        else{
            header("Location: ./addnews.php");
            $_SESSION["error"] = "เพิ่มข้อมูลผิดพลาดกรุณาลองใหม่";
        }
    }
    ?>
    </body>
</section>
<script src="../../js/menu.js"></script>
</body>
</html>

