<?php
include('./header.php');
include('./config.php');

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<div class='container mt-5'><p class='alert alert-danger'>Thread tidak ditemukan.</p></div>";
    include('./footer.php');
    exit();
}

$threadId = (int) $_GET['id'];

// Ambil data thread berdasarkan ID
$sql = "SELECT t.id, t.title, t.content, t.created_at, u.name AS author, GROUP_CONCAT(c.name SEPARATOR ', ') AS categories 
        FROM threads t
        JOIN users u ON t.user_id = u.id
        LEFT JOIN thread_categories tc ON t.id = tc.thread_id
        LEFT JOIN categories c ON tc.category_id = c.id
        WHERE t.id = ? GROUP BY t.id";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $threadId);
$stmt->execute();
$result = $stmt->get_result();
$thread = $result->fetch_assoc();

if (!$thread) {
    echo "<div class='container mt-5'><p class='alert alert-danger'>Thread tidak ditemukan.</p></div>";
    include('./footer.php');
    exit();
}

// Ambil komentar untuk thread ini
$commentQuery = "SELECT c.id, c.content, c.created_at, u.name 
                 FROM comments c
                 JOIN users u ON c.user_id = u.id
                 WHERE c.thread_id = ? 
                 ORDER BY c.created_at ASC";

$stmt = $conn->prepare($commentQuery);
$stmt->bind_param("i", $threadId);
$stmt->execute();
$comments = $stmt->get_result();

// Tambah komentar baru
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['content'])) {
    if (!isset($_SESSION['user_id'])) {
        echo "<script>alert('Anda harus login untuk memberikan komentar!');</script>";
    } else {
        $userId = $_SESSION['user_id'];
        $content = htmlspecialchars($_POST['content']);

        if (!empty($content)) {
            $insertComment = "INSERT INTO comments (thread_id, user_id, content, created_at) VALUES (?, ?, ?, NOW())";
            $stmt = $conn->prepare($insertComment);
            $stmt->bind_param("iis", $threadId, $userId, $content);
            $stmt->execute();
            echo "<script>window.location.href='thread.php?id=$threadId';</script>";
        } else {
            echo "<script>alert('Komentar tidak boleh kosong!');</script>";
        }
    }
}
?>

<div class="container" style="margin-top: 150px;">
    <div class="card">
        <div class="card-body">
            <h3 class="card-title"><?= htmlspecialchars($thread['title']) ?></h3>
            <p class="text-muted">Dibuat oleh: <?= htmlspecialchars($thread['author']) ?> | <?= $thread['created_at'] ?></p>
            <p class="text-muted"><strong>Kategori:</strong>
                <?php
                $categories = explode(', ', $thread['categories']); // Pecah string kategori menjadi array
                $colors = ['primary', 'secondary', 'success', 'danger', 'warning', 'info', 'dark']; // Warna badge

                foreach ($categories as $category) {
                    $randomColor = $colors[array_rand($colors)]; // Pilih warna acak
                    echo "<span class='badge bg-$randomColor me-1 mx-1 text-white'>" . htmlspecialchars($category) . "</span>";
                }
                ?>
            </p>
            <hr>
            <p><?= nl2br(htmlspecialchars($thread['content'])) ?></p>
        </div>
    </div>

    <h5 class="mt-4">Komentar</h5>
    <div class="list-group">
        <?php if ($comments->num_rows > 0) : ?>
            <?php while ($comment = $comments->fetch_assoc()) : ?>
                <div class="list-group-item my-2">
                    <strong><?= htmlspecialchars($comment['name']) ?></strong>
                    <small class="text-muted"> | <?= $comment['created_at'] ?></small>
                    <p><?= nl2br(htmlspecialchars($comment['content'])) ?></p>
                </div>
            <?php endwhile; ?>
        <?php else : ?>
            <p class="text-muted">Belum ada komentar.</p>
        <?php endif; ?>
    </div>

    <!-- Form Tambah Komentar -->
    <?php if (isset($_SESSION['user_id'])) : ?>
        <form action="thread.php?id=<?= $threadId ?>" method="post" class="mt-4">
            <div class="mb-3">
                <label for="content" class="form-label">Tambahkan Komentar:</label>
                <textarea class="form-control" id="content" name="content" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Kirim Komentar</button>
        </form>
    <?php else : ?>
        <p class="text-danger mt-3">Anda harus <a href="login.php">login</a> untuk memberikan komentar.</p>
    <?php endif; ?>
</div>

<?php include('./footer.php'); ?>