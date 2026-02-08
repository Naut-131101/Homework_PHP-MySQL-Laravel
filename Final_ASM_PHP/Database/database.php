<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$conn = new mysqli("localhost", "root", "", "bear_shop");
if ($conn->connect_error) {
    die("Kết nối thất bại");
}