<?php include('header.php'); ?>


<?php $queryMateri = "SELECT COUNT(*) AS total_materi FROM materi";
$resultMateri = $conn->query($queryMateri);
$totalMateri = $resultMateri->fetch_assoc()['total_materi'];

// Query untuk menghitung total tes yang selesai
$queryTest = "SELECT COUNT(DISTINCT user_id) AS total_test FROM jawab_soal";
$resultTest = $conn->query($queryTest);
$totalTest = $resultTest->fetch_assoc()['total_test'];

// Query untuk menghitung total user terdaftar
$queryUser = "SELECT COUNT(*) AS total_user FROM users";
$resultUser = $conn->query($queryUser);
$totalUser = $resultUser->fetch_assoc()['total_user']; ?>
<!-- slider_area_start -->
<div class="slider_area">
    <div class="single_slider d-flex align-items-center slider_bg_1 overlay2">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="slider_text">
                        <span>Temukan Dirimu yang Sebenarnya</span>
                        <h3> Kenali Kepribadianmu
                            dengan Tes Kelompok Sosial</h3>
                        <p>Setiap orang unik. Pahami bagaimana kamu berpikir,
                            berinteraksi, dan mengambil keputusan dengan tes Kelompok sosial yang akurat.</p>
                        <a href="start_test.php" class="boxed-btn3">Mulai Tes Sekarang</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- latest_activites_area_start  -->
<div class="latest_activites_area">
    <div class=" video_bg_1 video_activite  d-flex align-items-center justify-content-center">
        <a class="popup-video" href="https://www.youtube.com/embed/mSP1TedSLbU?si=_xbhsHM0W-4I3DD8">
            <i class="flaticon-ui"></i>
        </a>
    </div>
    <div class="container">
        <div class="row justify-content-end">
            <div class="col-lg-7">
                <div class="activites_info">
                    <div class="section_title">
                        <h3> <span>Pahami Dirimu Lebih Dalam </span><br>
                            dengan Kelompok Sosial</h3>
                    </div>
                    <p class="para_1"> Tes Kelompok Sosial adalah Tes kelompok sosial adalah bentuk evaluasi yang mengukur kemampuan individu dalam berinteraksi dan berkolaborasi dalam sebuah kelompok. 
                        Ini membantu untuk menilai sejauh mana anggota kelompok dapat bekerja sama, berkomunikasi, dan menyelesaikan tugas bersama</p>
                    <p class="para_2">Dengan mengetahui tipe kelompok Sosial, kamu bisa memahami potensi,
                        cara bekerja yang efektif, serta bagaimana berkomunikasi lebih baik dengan orang lain.
                        Tes ini membagi kepribadian menjadi 2 tipe.</p>
                    <a href="<?= $baseUrl; ?>start_test.php" class="boxed-btn4">Mulai Tes Sekarang</a>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- latest_activites_area_end  -->

<!-- popular_causes_area_start  -->
<div class="popular_causes_area section_padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="section_title text-center mb-55">
                    <h3><span>Kenali Kepribadianmu</span></h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="causes_active owl-carousel">
                    <div class="single_cause">
                        <div class="causes_content">
                            <h4>Tipe Kelompok Sosial Formal</h4>
                            <p>Tipe ini terdiri dari organisasi resmi seperti OSIS, Pramuka, dan MPK.  
                                 Mereka memiliki struktur kepemimpinan yang jelas, aturan yang harus diikuti, serta tujuan tertentu.</p>
                        </div>
                    </div>
                    <div class="single_cause">
                        <div class="causes_content">
                            <h4>Tipe Kelompok Sosial Informal</h4>
                            <p>Meliputi kelompok pertemanan, geng belajar, atau komunitas hobi di sekolah.  
                                Kelompok ini terbentuk secara alami, lebih fleksibel, dan berorientasi pada hubungan sosial tanpa aturan baku.</p>
                        </div>
                    </div>
                    <div class="single_cause">
                        <div class="causes_content">
                            <h4>Tipe Kelompok Sosial Primer</h4>
                            <p>Meliputi kelompok teman sebangku, sahabat dekat, dan kelompok belajar kecil.  
                                Mereka memiliki hubungan yang erat, sering berinteraksi, dan saling mendukung dalam kehidupan sekolah.</p>
                        </div>
                    </div>
                    <div class="single_cause">
                        <div class="causes_content">
                            <h4>Tipe Kelompok Sosial Sekunder</h4>
                            <p>Meliputi panitia acara sekolah, klub ekstrakurikuler, dan tim olahraga.  
                                Hubungan dalam kelompok ini lebih bersifat fungsional, dengan tujuan dan kegiatan tertentu yang menyatukan anggotanya.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- popular_causes_area_end  -->

<!-- counter_area_start  -->
<!-- Tambahkan Font Awesome di <head> -->

<div class="counter_area">
    <div class="container">
        <div class="counter_bg overlay">
            <div class="row">
                <!-- Total Materi -->
                <div class="col-lg-4 col-md-12">
                    <div class="single_counter d-flex align-items-center justify-content-center">
                        <div class="icon">
                            <i class="fa fa-book"></i>
                        </div>
                        <div class="events">
                            <h3 class="counter"><?= $totalMateri; ?></h3> <!-- Ganti dengan jumlah materi dinamis -->
                            <p>Total Materi</p>
                        </div>
                    </div>
                </div>
                <!-- Total User yang Sudah Melakukan Tes -->
                <div class="col-lg-4 col-md-12">
                    <div class="single_counter d-flex align-items-center justify-content-center">
                        <div class="icon">
                            <i class="fa fa-edit"></i>
                        </div>
                        <div class="events">
                            <h3 class="counter"><?= $totalTest; ?></h3> <!-- Ganti dengan data dinamis -->
                            <p>Total Test Selesai</p>
                        </div>
                    </div>
                </div>
                <!-- Total User yang Terdaftar -->
                <div class="col-lg-4 col-md-12 ">
                    <div class="single_counter d-flex align-items-center justify-content-center">
                        <div class="icon">
                            <i class="fa fa-user"></i>
                        </div>
                        <div class="events">
                            <h3 class="counter"><?= $totalUser; ?></h3> <!-- Ganti dengan data dinamis -->
                            <p>Total User yang Terdaftar</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- counter_area_end  -->
<?php include('./footer.php'); ?>