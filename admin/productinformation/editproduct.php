<?php
session_start();
ob_start();
include('../../connect.php');
$ID = $_GET["ID"];
$sql = "SELECT * FROM product WHERE product_ID = $ID";
$query = mysqli_query($conn,$sql);
$sql1 = "SELECT * FROM product_type WHERE product_ID = $ID";
$query1 = mysqli_query($conn,$sql1);
$result = mysqli_fetch_assoc($query);
$result1 = mysqli_fetch_assoc($query);
$id = $result["product_ID"];
if(!isset($_GET["ID"])){
    header("Location: ./productinformation.php");
}
else if(!isset($_SESSION["username"])){
    header("Location: ../../loginadmin.php");
    $_SESSION["error"] = "กรุณาloginเพื่อเข้าสู่ระบบ";
}
// print_r($result);
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
    <form method="post"enctype="multipart/form-data">
        <h2>ข้อมูลสินค้า</h2>
        <h2>Admin:<?php echo $_SESSION["username"];?></h2>
        <div>
            <H1 style="color:green"><?php if(isset($_SESSION["success"])){
                    echo $_SESSION["success"];
                    unset($_SESSION["success"]);
                }
                elseif (isset($_SESSION["error"])){
                    echo $_SESSION["error"];
                    unset($_SESSION["error"]);
                }
                ?></H1>
        </div>
        <div>
            <img src="../imageupload/product/<?php echo $result['product_image'];?>" width="120px" height="100px"><br>
            <label>ID:<?php echo $result["product_ID"]?></label>
        </div>
        <div>
            <label>ชื่อสินค้า :</label>
            <input type="text" value="<?php echo $result["product_name"]?>" name="nameproduct" required>
        </div>
        <div>
            <label>รูปภาพ :</label>
            <input type="file" name="productimage" required>
        </div>
        <div>
            <label>ราคา :</label>
            <input type="text" value="<?php echo $result["product_price"]?>" name="productprice" pattern="[0-9]{}" required>
        </div>

        <div>
            <input type="submit" value="ยืนยัน" name="Submit">
        </div>
        <button><a href="./productinformation.php">ย้อนกลับ</a></button>
    </form>
    <?php
    if(isset($_POST["Submit"])){
        $name = $_POST["nameproduct"];
        $productprice = $_POST["productprice"];
        $imageproduct = $_FILES["productimage"]["name"];
        $updatesql = "UPDATE product SET product_name='$name',product_image = '$imageproduct',product_price = '$productprice' WHERE product_ID = $ID";
        $query = mysqli_query($conn,$updatesql);
        $target_file = '../imageupload/product/' . basename($imageproduct);
        if($query){
            move_uploaded_file($_FILES['productimage']['tmp_name'],"$target_file");
            header("Location: ./editproduct.php?ID=$ID");
            $_SESSION["success"] = "แก้ไขข้อมูลเรียบร้อย";
        }
        else{
            header("Location: ./editproduct.php?ID=$ID");
            $_SESSION["error"] = "แก้ไขข้อมูลผิดพลาดกรุณาลองใหม่";
        }
    }
    ?>
    </body>
</section>
<script src="../../js/menu.js"></script>
</body>
</html>


