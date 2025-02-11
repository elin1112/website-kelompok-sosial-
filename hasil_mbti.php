<?php
include('header.php');
include('config.php');

if (!isset($userId)) {
    echo "<script>alert('Silakan login terlebih dahulu!'); window.location.href='login.php';</script>";
    exit;
}

// Ambil hasil terbaru user
$query = "SELECT * FROM jawab_soal WHERE user_id = ? ORDER BY created_at DESC LIMIT 1";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$hasil = $result->fetch_assoc();
$stmt->close();

// Ambil detail jawaban
$queryDetail = "SELECT s.pertanyaan, j.jawaban 
                FROM jawab_soal_detail j
                JOIN soal_mbti s ON j.soal_id = s.id
                WHERE j.jawab_soal_id = ?";
$stmtDetail = $conn->prepare($queryDetail);
$stmtDetail->bind_param("i", $hasil['id']);
$stmtDetail->execute();
$detailResult = $stmtDetail->get_result();
$stmtDetail->close();
?>

<style>
    .result-container {
        max-width: 800px;
        margin: auto;
        background: #f8f9fa;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }

    .result-header {
        text-align: center;
        margin-bottom: 20px;
    }

    .card {
        background: white;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 10px;
        box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
    }

    .question {
        font-weight: bold;
    }

    .answer {
        color: #007bff;
        font-weight: bold;
    }
</style>

<div class="container" style="margin-top: 150px;margin-bottom: 20px;">
    <div class="result-container">
        <div class="result-header">
            <h2>Hasil Tes MBTI</h2>
            <p><strong>Kategori:</strong> <?= htmlspecialchars($hasil['kategori']) ?></p>
            <p><strong>Jumlah Ya:</strong> <?= $hasil['jumlah_ya'] ?></p>
            <p><strong>Jumlah Tidak:</strong> <?= $hasil['jumlah_tidak'] ?></p>
        </div>

        <h3>Detail Jawaban</h3>
        <?php $no = 1;; ?>
        <?php while ($row = $detailResult->fetch_assoc()) : ?>
            <div class="card">
                <p class="question"> <?= $no; ?>. <?= htmlspecialchars($row['pertanyaan']) ?> </p>
                <p class="answer"> <?= ucfirst(htmlspecialchars($row['jawaban'])) ?> </p>
            </div>
        <?php $no++;
        endwhile; ?>
    </div>
</div>

<?php include('footer.php'); ?>