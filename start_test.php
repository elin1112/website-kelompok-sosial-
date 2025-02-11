<?php
include('header.php');

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Silakan login terlebih dahulu!'); window.location.href='login.php';</script>";
    exit;
}

$userId = $_SESSION['user_id'];

// Ambil hasil terakhir user
$queryHasil = "SELECT kategori FROM jawab_soal WHERE user_id = ? ORDER BY created_at DESC LIMIT 1";
$stmtHasil = $conn->prepare($queryHasil);
$stmtHasil->bind_param("i", $userId);
$stmtHasil->execute();
$resultHasil = $stmtHasil->get_result();
$hasilTerakhir = $resultHasil->fetch_assoc();
$stmtHasil->close();

// Ambil pertanyaan dari database
$query = "SELECT * FROM soal_mbti";
$result = $conn->query($query);
?>

<style>
    .question-container {
        background: #f9f9f9;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }

    .custom-radio {
        display: flex;
        align-items: center;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 8px;
        cursor: pointer;
        transition: 0.2s;
        background: white;
        margin-top: 10px;
    }

    .custom-radio input {
        display: none;
    }

    .custom-radio .radio-mark {
        height: 20px;
        width: 20px;
        border-radius: 50%;
        border: 2px solid #007bff;
        display: inline-block;
        margin-right: 10px;
        position: relative;
    }

    .custom-radio input:checked+.radio-mark {
        background-color: #007bff;
    }

    .custom-radio input:checked+.radio-mark::after {
        content: "";
        width: 10px;
        height: 10px;
        background: white;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        border-radius: 50%;
    }

    .custom-radio:hover {
        background: #e9ecef;
    }
</style>

<div class="container" style="margin-top: 150px;">
    <h2 class="text-center">Tes Kelompok Sosial</h2>
    <p class="text-center">Jawablah pertanyaan berikut dengan "Ya" atau "Tidak".</p>

    <?php if ($hasilTerakhir) : ?>
        <div class="alert alert-info text-center">
            <strong>Hasil Tes Terakhir Anda:</strong> <?= htmlspecialchars($hasilTerakhir['kategori']); ?>
        </div>
    <?php endif; ?>

    <form action="proses_mbti.php" method="POST">
        <?php
        $no = 1;
        while ($row = $result->fetch_assoc()) : ?>
            <div class="question-container">
                <p><strong><?= $no++; ?>. <?= htmlspecialchars($row['pertanyaan']); ?></strong></p>

                <label class="custom-radio">
                    <input type="radio" name="jawaban[<?= $row['id']; ?>]" value="ya" required>
                    <span class="radio-mark"></span> Ya
                </label>

                <label class="custom-radio">
                    <input type="radio" name="jawaban[<?= $row['id']; ?>]" value="tidak" required>
                    <span class="radio-mark"></span> Tidak
                </label>
            </div>
        <?php endwhile; ?>

        <button type="submit" class="btn btn-primary btn-block">Selesai</button>
    </form>
</div>

<?php include('footer.php'); ?>
