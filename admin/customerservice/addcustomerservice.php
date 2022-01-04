<?php
session_start();
ob_start();
include('../../connect.php');
$sqlcustomerjoincustomer_servicecount = "SELECT COUNT(customer.carlicense_num) AS count FROM customer LEFT JOIN customer_services ON customer.carlicense_num = customer_services.carlicense_num WHERE customer_services.carlicense_num IS NULL";
$resultcustomerjoincustomer_servicecount = mysqli_query($conn, $sqlcustomerjoincustomer_servicecount);
$customer_servicecount=mysqli_fetch_assoc($resultcustomerjoincustomer_servicecount);

$sqlcountservice = "SELECT COUNT(*) AS countservice FROM service";
$resultservice = mysqli_query($conn,$sqlcountservice);
$countservice = mysqli_fetch_assoc($resultservice);
if(!isset($_SESSION["username"])){
    header("Location: ../../loginadmin.php");
    $_SESSION["error"] = "กรุณาloginเพื่อเข้าสู่ระบบ";
}
else if(isset($_POST["logout"])){
    session_destroy();
    header("location: ../../loginadmin.php");
    exit();
}
else if($countservice["countservice"] == 0){
    header("Location: ./customerservice.php");
    $_SESSION["error"] = "ยังไม่มีการบริการเพิ่มเข้ามา";
}
else if($customer_servicecount["count"] == 0){
    header("Location: ./customerservice.php");
    $_SESSION["error"] = "ยังไม่มีเลขทะเบียนรถเพิ่มเข้ามา";
}

$useradmin = $_SESSION["username"];
$sqladmin = "SELECT admin_ID FROM admin WHERE admin_username = '$useradmin' ";
$resultadmin = mysqli_query($conn, $sqladmin);
$rowadmin =  mysqli_fetch_assoc($resultadmin);

$sqlservice = "SELECT * FROM  service";
$resultservice = mysqli_query($conn, $sqlservice);

$sqlcustomerjoincustomer_service = "SELECT customer_name,customer.carlicense_num AS customer,customer_services.carlicense_num FROM customer LEFT JOIN customer_services ON customer.carlicense_num = customer_services.carlicense_num WHERE customer_services.carlicense_num IS NULL";
$resultcustomerjoincustomer_service = mysqli_query($conn, $sqlcustomerjoincustomer_service);

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
    <h1>เพิ่มข้อมูลงานบริการลูกค้า</h1>
    <form method="post">
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
                <option value="">เลือกเลขทะเบียน</option>
                <?php while($row = mysqli_fetch_array($resultcustomerjoincustomer_service)):?>
                    <option value="<?php echo $row["customer"]?>"><?php echo $row["customer"]?></option>
                <?php endwhile;?>
            </select>
        </div>
        <div>
        </div>
        <div>
            <input type="text" name="customer_service_details" placeholder="ข้อมูลรายละเอียด">
        </div>
        <div>
            <input type="submit" name="submit">
        </div>
    </form>
    <button><a href="./customerservice.php">ย้อนกลับ</a></button>

    <?php
    if (isset($_POST["submit"])){
        $idadmin = $rowadmin['admin_ID'];
        date_default_timezone_set("Asia/Bangkok");
        $carlicense = $_POST["carlicense"];
        $service_id = $_POST["service_ID"];
        $detail = $_POST["customer_service_details"];
        $price = $_POST["customer_service_price"];
        $date =  date("Y-m-d");
        $time =  date(" H:i:s");
        $sumprice = array_sum($_POST["customer_service_price"]);

        if(count($_POST["service_ID"]) > 0){
            $bdrm =  implode(',',$_POST['service_ID']);
            $array = explode(",", $bdrm);
            $priceaa = implode(',',$_POST["customer_service_price"]);
            $arrayprice = explode(",", $priceaa);
            $sqlcustomerservice = "INSERT INTO customer_services (carlicense_num,service,service_price,customer_services_details,customer_services_date,customer_services_time,customer_services_price,customer_services_edit,admin_ID) VALUES ('$carlicense','$bdrm','$priceaa','$detail','$date','$time','$sumprice',0,'$idadmin')";
            $query = mysqli_query($conn,$sqlcustomerservice);
            if ($query){
                header("Location: ./customerservice.php");
                $_SESSION["success"] = "เพิ่มข้อมูลเรียบร้อย";
            }
            else{
                header("Location: ./addcustomerservice.php");
                $_SESSION["error"] = "เพิ่มข้อมูลผิดพลาดกรุณาลองใหม่";
            }
        }
    }
    ?>
    </body>
</section>
<script src="../../js/menu.js"></script>
</body>
</html>


