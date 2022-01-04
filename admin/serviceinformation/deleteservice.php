<?php
session_start();
include('../../connect.php');
if (!isset($_SESSION["username"])) {
    header("Location: ../../loginadmin.php");
    $_SESSION["error"] = "กรุณาloginเพื่อเข้าสู่ระบบ";
} elseif (!isset($_GET["ID"])) {
    header("Location: ./serviceinformation.php");
} else {
    $id = $_GET["ID"];
    $deletesql = "DELETE FROM service WHERE service_ID = $id";
    $result = mysqli_query($conn, $deletesql);
    if ($result) {
        $_SESSION["success"] = "ลบID $id เรียบร้อย";
        header("Location: ./serviceinformation.php");
    } else {
        $_SESSION["error"] = "ลบข้อมูลไม่สำเร็จกรุณาลองอีกครั้ง";
        header("Location: ./serviceinformation.php");
    }
}
?>