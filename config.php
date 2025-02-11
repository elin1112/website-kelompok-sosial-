<?php
$baseUrl = 'http://localhost/sosial/';


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$userId = $_SESSION['user_id'] ?? null;

$host = "localhost";
$username = "root";
$password = "";
$database = "mbti_test_db";

// Membuat koneksi
$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
