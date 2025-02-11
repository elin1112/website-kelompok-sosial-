<?php
include('header.php') ?>

<?php

$queryMateri = "select * from materi";
$result = $conn->query($queryMateri);

?>


<div class="popular_causes_area pt-120">
    <h1 class="text-center my-3">Materi Yang Dapat Membantu Test Kamu</h1>
    <div class="container">
        <div class="row">
            <?php
            while ($row = $result->fetch_assoc()) {
            ?>
                <div class="col-lg-4 col-md-6">
                    <div class="single_cause">
                        <div class="thumb">
                            <img src="<?= $baseUrl; ?>img/<?= $row['foto']; ?>" alt="">
                        </div>
                        <div class="causes_content">
                            <div class="balance d-flex justify-content-between align-items-center">
                                <span class="badge bg-primary text-white"><?= $row['kategori']; ?> </span>
                            </div>
                            <a href="<?= $baseUrl; ?>detail-materi.php?id=<?= $row['id']; ?>">
                                <h4><?= $row['judul']; ?></h4>
                            </a>
                            <a class="read_more" href="<?= $baseUrl; ?>detail-materi.php?id=<?= $row['id']; ?>">Read More</a>
                        </div>
                    </div>
                </div>
            <?php }; ?>
        </div>
    </div>
</div>
<?php include('footer.php') ?>