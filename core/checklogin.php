<?php
@session_start();
// ตรวจสอบว่าผู้ใช้ได้เข้าสู่ระบบแล้วหรือไม่
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    header('Location: login.php');
    exit();
}