<?php include('header.php'); ?>


<?php

$id = $_GET['id'];
if (isset($id)) {
    $query = "select * from materi where id=?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
}; ?>

<div class="container my-5">
    <?php if ($result->num_rows > 0) : ?>
        <?php $row = $result->fetch_assoc(); ?>
        <!-- TRUE -->
        <div class="popular_causes_area pt-120 cause_details ">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="single_cause">
                            <div class="thumb">
                                <img src="<?= $baseUrl; ?>img/<?= $row['foto']; ?>" alt="">
                            </div>
                            <div class="causes_content">
                                <div class="custom_progress_bar">
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width: 30%;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">
                                            <span class="progres_count">
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="balance d-flex justify-content-between align-items-center">
                                    <span class="badge bg-primary text-white"><?= $row['kategori']; ?> </span>
                                </div>
                                <h4><?= $row['judul']; ?></h4>
                                <h6><?= $row['deskripsi']; ?></h6>
                                <p>
                                    <?= $row['isi_materi']; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php else : ?>
        <div class="text-center">
            <h5>Data materi tidak ditemuakan!</h5>
        </div>
        <!-- FALSE -->
    <?php endif ?>
</div>

<?php include('footer.php'); ?>