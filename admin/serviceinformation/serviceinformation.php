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
else if(isset($_POST['search'])){
    $valueToSearch = $_POST['valueToSearch'];
    $query = "SELECT * FROM service WHERE CONCAT(service_name) LIKE '%".$valueToSearch."%'";
    $search_result = filterTable($query);
}
else {
    $query = "SELECT * FROM service";
    $search_result = filterTable($query);
}
function filterTable($query){
    $conn = mysqli_connect("thoranin.org", "jrautoparts", "a4s@Ne38", "jrautoparts");
    mysqli_set_charset($conn, "utf8");
    $filter_Result = mysqli_query($conn, $query);
    if(mysqli_num_rows($filter_Result)==0){
        $_SESSION['error'] = "หาข้อมูลไม่พบ";
        return $filter_Result;
    }
    else{
        return $filter_Result;
    }
}
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
    <!--    datatable-->
    <link rel="stylesheet" href="../datatable/datatable.css">
    <script src='https://code.jquery.com/jquery-3.5.1.js'></script>
    <script src='https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js'></script>
</head>
<style>
    table, th, td {
        border:1px solid black;
    }
</style>
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
    <h2>ข้อมูลการบริการ</h2>
    <div>
        <!-- <form method="POST">
            <input type="text" name="valueToSearch" placeholder="กรอกข้อมูลเพื่อค้นหา..." />
            <button  type="submit" name="search">
                <i>submit</i>
            </button>
        </form> -->
        <?php if(isset($_SESSION["success"])) {
            echo "<H1 style=color:green>$_SESSION[success]</H1>";
            unset($_SESSION["success"]);
        }
        elseif (isset($_SESSION["error"])){
            echo "<H1 style=color:red>$_SESSION[error]</H1>";
            unset($_SESSION["error"]);
        }
        ?>
        <button onclick="window.location.href='./addservice.php'">เพิ่มข้อมูล</button>
        <table id="datatable" class="display" style="width:70%">
            <thead>
            <tr>
                <th>ลำดับ</th>
                <th>ชื่อการบริการ</th>
                <th>รูปภาพ</th>
                <th>ลบ</th>
                <th>แก้ไข</th>
            </tr>
            </thead>
            <tbody>
            <?php while($row = mysqli_fetch_array($search_result)):?>
                <tr>
                    <th><?php echo $row["service_ID"]?></th>
                    <th><?php echo $row["service_name"]?></th>
                    <th><img src="../imageupload/service/<?php echo $row["service_image"]?>" alt="ค้นหารูปภาพไม่เจอ" width="120px" height="100px">
                    </th>
                    <th><a href="./deleteservice.php?ID=<?php echo $row["service_ID"]?>">ลบ</a></th>
                    <th><a href="./editservice.php?ID=<?php echo $row["service_ID"]?>">แก้ไข</a></th>
                </tr>
            <?php endwhile;?>
            </tbody>


        </table>
    </div>
    <script>
        $(document).ready(function() {
            $('#datatable').DataTable();
        });
    </script>

    </body>
</section>
<script src="../../js/menu.js"></script>
</body>
</html>


