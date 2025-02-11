<?php include('./header.php'); ?>
<?php include('./config.php'); // Koneksi database 
?>

<div class="container" style="margin-top: 150px; margin-bottom:50px">
    <form action="forum.php" method="get">
        <div class="row">
            <div class="col-md-6 col-sm-12">

                <div class="mb-3">
                    <label for="judul" class="form-label">Judul</label>
                    <input type="text" class="form-control" id="judul" name="judul" placeholder="Masukkan judul topik"
                        value="<?= isset($_GET['judul']) ? htmlspecialchars($_GET['judul']) : '' ?>">
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <label for="kategori">Kategori</label>
                <select class="form-control" name="kategori" id="kategori" onchange="this.form.submit()">
                    <option value="0">Semua Kategori</option>
                    <?php
                    $query = "SELECT * FROM categories";
                    $result_categories = $conn->query($query);
                    while ($row = $result_categories->fetch_assoc()) :
                        $selected = (isset($_GET['kategori']) && $_GET['kategori'] == $row['id']) ? 'selected' : '';
                    ?>
                        <option value="<?= $row['id'] ?>" <?= $selected ?>><?= htmlspecialchars($row['name']) ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
        </div>

        <!-- Row baru untuk tombol agar lebih rapi di layar kecil -->
        <div class="row mt-3">
            <div class="col-sm-12 d-flex" style="gap: 20px;">
                <button type="submit" class="btn btn-primary w-100">Search</button>
                <a href="<?= $baseUrl; ?>create_thread.php" class="btn btn-secondary w-100">Buat Thread</a>
            </div>
        </div>
    </form>


    <div class="mt-4">
        <h5>Threads</h5>
        <div class="list-group">
            <?php
            $judulFilter = isset($_GET['judul']) ? $conn->real_escape_string($_GET['judul']) : '';
            $kategoriFilter = isset($_GET['kategori']) ? (int)$_GET['kategori'] : 0;

            $sql = "SELECT t.id, t.title, t.content, t.created_at, u.name, GROUP_CONCAT(c.name SEPARATOR ', ') as categories 
                    FROM threads t 
                    JOIN users u ON t.user_id = u.id 
                    LEFT JOIN thread_categories tc ON t.id = tc.thread_id 
                    LEFT JOIN categories c ON tc.category_id = c.id 
                    WHERE 1=1";

            if (!empty($judulFilter)) {
                $sql .= " AND t.title LIKE '%$judulFilter%'";
            }
            if ($kategoriFilter > 0) {
                $sql .= " AND t.id IN (SELECT thread_id FROM thread_categories WHERE category_id = $kategoriFilter)";
            }

            $sql .= " GROUP BY t.id ORDER BY t.created_at DESC";
            $threads = $conn->query($sql);

            if ($threads->num_rows > 0) :
                while ($thread = $threads->fetch_assoc()) :
            ?>
                    <a href="thread.php?id=<?= $thread['id'] ?>" class="list-group-item list-group-item-action my-2">
                        <h5 class="mb-1"><?= htmlspecialchars($thread['title']) ?></h5>
                        <small class="text-muted">Dibuat oleh: <?= htmlspecialchars($thread['name']) ?> | <?= $thread['created_at'] ?></small>
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
                        <p class="mb-1"><?= htmlspecialchars(substr($thread['content'], 0, 100)) ?>...</p>
                    </a>
                <?php
                endwhile;
            else :
                ?>
                <p class="text-muted">Tidak ada topik yang ditemukan.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include('./footer.php'); ?>