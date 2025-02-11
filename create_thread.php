<?php
include('./header.php');

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id']; // Ambil ID user yang sedang login

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $conn->real_escape_string($_POST['title']);
    $content = $conn->real_escape_string($_POST['content']);
    $categories = isset($_POST['categories']) ? $_POST['categories'] : [];

    if (!empty($title) && !empty($content) && !empty($categories)) {
        // Insert thread ke tabel threads
        $query = "INSERT INTO threads (user_id, title, content, created_at) VALUES ('$user_id', '$title', '$content', NOW())";
        if ($conn->query($query)) {
            $thread_id = $conn->insert_id;

            // Insert kategori ke thread_categories
            foreach ($categories as $category_id) {
                $conn->query("INSERT INTO thread_categories (thread_id, category_id) VALUES ('$thread_id', '$category_id')");
            }

            // Redirect ke halaman thread yang baru dibuat
            header("Location: forum.php?");
            exit();
        } else {
            $error = "Gagal membuat thread. Coba lagi.";
        }
    } else {
        $error = "Semua bidang harus diisi.";
    }
}

// Ambil daftar kategori dari database
$result_categories = $conn->query("SELECT * FROM categories");
?>

<div class="container" style="margin-top: 150px; margin-bottom:50px">
    <h2>Buat Thread Baru</h2>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="create_thread.php" method="POST">
        <div class="mb-3">
            <label for="title" class="form-label">Judul Thread</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Masukkan judul topik" required>
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">Isi Thread</label>
            <textarea class="form-control" id="content" name="content" rows="5" placeholder="Masukkan isi thread" required></textarea>
        </div>

        <div class="mb-3">
            <label for="categories" class="form-label">Kategori</label>
            <select class="form-control" id="categories" name="categories[]" multiple required>
                <?php while ($row = $result_categories->fetch_assoc()): ?>
                    <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['name']) ?></option>
                <?php endwhile; ?>
            </select>
            <small class="text-muted">Tekan <b>Ctrl</b> (Windows) atau <b>Cmd</b> (Mac) untuk memilih lebih dari satu kategori.</small>
        </div>

        <button type="submit" class="btn btn-primary">Buat Thread</button>
    </form>
</div>

<?php include('./footer.php'); ?>