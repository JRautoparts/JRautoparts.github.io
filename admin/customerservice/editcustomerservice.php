<?php
session_start();
ob_start();
include('../../connect.php');
if(!isset($_GET["ID"])){
    header("Location: ./customerservice.php");
    $_SESSION["error"] = "กรุณาเลือกลำดับการแก้ไข";

}
else if(!isset($_SESSION["username"])){
    header("Location: ../../loginadmin.php");
    $_SESSION["error"] = "กรุณาloginเพื่อเข้าสู่ระบบ";
}
else{
    $ID = $_GET["ID"];
    $sql = "SELECT * FROM customer_services WHERE customer_services_ID = '$ID' ";
    $query = mysqli_query($conn,$sql);
    $result = mysqli_fetch_assoc($query);
    if(mysqli_num_rows($query)==0){
        header("Location: ./customerservice.php");
        $_SESSION["error"] = "ไม่พบข้อมูลที่เลือกกรุณาลองใหม่";
    }
}
$sqlservice = "SELECT * FROM  service";
$resultservice = mysqli_query($conn, $sqlservice);

$sqlcustomerjoincustomer_service = "SELECT customer_name,customer.carlicense_num AS customer,customer_services.carlicense_num FROM customer LEFT JOIN customer_services ON customer.carlicense_num = customer_services.carlicense_num WHERE customer_services.carlicense_num IS NULL";
$resultcustomerjoincustomer_service = mysqli_query($conn, $sqlcustomerjoincustomer_service);

$useradmin = $_SESSION["username"];
$sqladmin = "SELECT admin_ID FROM admin WHERE admin_username = '$useradmin' ";
$resultadmin = mysqli_query($conn, $sqladmin);
$rowadmin =  mysqli_fetch_assoc($resultadmin);
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
    <form method="post" enctype="multipart/form-data">
        <h2>แก้ไขข้อมูลการบริการ</h2>
        <h2>Admin:<?php echo $_SESSION["username"];?></h2>
        <div>
            <label>ID:<?php echo $result["customer_services_ID"]?></label>
        </div>
        <div>
            <label for="service_ID">เลือกการบริการ:</label><br>
            <?php while($row = mysqli_fetch_array($resultservice)):?>
                <input type="checkbox" name="service_ID[]" value="<?php echo $row["service_ID"]?>">
                <label for="vehicle1"><?php echo $row["service_name"]?></label>
                <input type="number" name="customer_service_price[]" placeholder="ราคา"><br>
            <?php endwhile;?>
        </div>
        <div>
            <label for="carlicense_num">เลือกเลขทะเบียนรถ:</label>
            <select name="carlicense">
                <option value="<?php echo $result["carlicense_num"]?>">เลือกเลขทะเบียน</option>
                <?php while($row = mysqli_fetch_array($resultcustomerjoincustomer_service)):?>
                    <option value="<?php echo $row["customer"]?>"><?php echo $row["customer"]?></option>
                <?php endwhile;?>
            </select>
        </div>
        <div>
            <input type="text" value="<?php echo $result["customer_services_details"]?>" name="customer_service_details" placeholder="ข้อมูลรายละเอียด">
        </div>
        <div>
            <input type="submit" value="ยืนยัน" name="Submit">
        </div>
        <button><a href="./customerservice.php">ย้อนกลับ</a></button>
    </form>
    <?php
    if(isset($_POST["Submit"])){
        date_default_timezone_set("Asia/Bangkok");
        $carlicense = $_POST["carlicense"];
        $service = implode(',',$_POST["service_ID"]);
        $customer_service_details = $_POST["customer_service_details"];
        $date =  date("Y-m-d");
        $time =  date(" H:i:s");
        $price = implode(',',$_POST["customer_service_price"]);
        $idadmin = $rowadmin['admin_ID'];
        $sumprice = array_sum($_POST["customer_service_price"]);
        $updatesql = "UPDATE customer_services SET carlicense_num='$carlicense',service = '$service',service_price = '$price',customer_services_details = '$customer_service_details',customer_services_date = '$date',customer_services_time = '$time',admin_ID = '$idadmin',customer_services_price = '$sumprice',customer_services_edit = 1 WHERE customer_services_ID = '$ID' ";
        $query = mysqli_query($conn,$updatesql);
        if($query){
            header("Location: ./customerservice.php");
            $_SESSION["success"] = "แก้ไขข้อมูลเรียบร้อย";
        }
        else{
            header("Location: ./editcustomerservice.php?ID=$ID");
            $_SESSION["error"] = "แก้ไขข้อมูลผิดพลาดกรุณาลองใหม่";
        }
    }
    ?>
    </body>
</section>
<script src="../../js/menu.js"></script>
</body>
</html>

