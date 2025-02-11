<?php
include('config.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Silakan login terlebih dahulu!'); window.location.href='login.php';</script>";
    exit;
}

$userId = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['jawaban'])) {
    $jawaban = $_POST['jawaban'];
    $jumlah_ya = 0;
    $jumlah_tidak = 0;

    // Hitung jumlah jawaban "Ya" dan "Tidak"
    foreach ($jawaban as $id_soal => $jawab) {
        if ($jawab == "ya") {
            $jumlah_ya++;
        } else {
            $jumlah_tidak++;
        }
    }

    // Tentukan kategori berdasarkan jumlah jawaban "Ya" dan "Tidak"
    $kategori = ($jumlah_ya > $jumlah_tidak) ? "Formal" : "Non-Formal";

    // Simpan ke `jawab_soal`
    $stmt = $conn->prepare("INSERT INTO jawab_soal (user_id, jumlah_ya, jumlah_tidak, kategori) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiis", $userId, $jumlah_ya, $jumlah_tidak, $kategori);
    $stmt->execute();
    $jawab_soal_id = $stmt->insert_id; // Ambil ID hasil penyimpanan
    $stmt->close();

    // Simpan ke `jawab_soal_detail`
    $stmt_detail = $conn->prepare("INSERT INTO jawab_soal_detail (jawab_soal_id, soal_id, jawaban) VALUES (?, ?, ?)");
    foreach ($jawaban as $id_soal => $jawab) {
        $stmt_detail->bind_param("iis", $jawab_soal_id, $id_soal, $jawab);
        $stmt_detail->execute();
    }
    $stmt_detail->close();

    echo "<script>alert('Tes selesai! Anda termasuk kategori: $kategori'); window.location.href='hasil_mbti.php';</script>";
} else {
    echo "<script>alert('Terjadi kesalahan, coba lagi!'); window.location.href='mbti_test.php';</script>";
}
