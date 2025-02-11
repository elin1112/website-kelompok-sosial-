<?php include_once('config.php'); ?>
<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Charifit</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- <link rel="manifest" href="site.webmanifest"> -->
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.png">

    <link rel="stylesheet" href="<?= $baseUrl; ?>/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= $baseUrl; ?>/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?= $baseUrl; ?>/css/magnific-popup.css">
    <link rel="stylesheet" href="<?= $baseUrl; ?>/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= $baseUrl; ?>/css/themify-icons.css">
    <link rel="stylesheet" href="<?= $baseUrl; ?>/css/nice-select.css">
    <link rel="stylesheet" href="<?= $baseUrl; ?>/css/flaticon.css">
    <link rel="stylesheet" href="<?= $baseUrl; ?>/css/gijgo.css">
    <link rel="stylesheet" href="<?= $baseUrl; ?>/css/animate.css">
    <link rel="stylesheet" href="<?= $baseUrl; ?>/css/slicknav.css">
    <link rel="stylesheet" href="<?= $baseUrl; ?>/css/style.css">

    <?php
    $currentPage = basename($_SERVER['PHP_SELF']);
    ?>

    <style>
        #navigation li a {
            color: white;
            /* Warna teks default */
            padding: 10px 15px;
            transition: background 0.3s, color 0.3s;
        }

        /* Saat menu aktif */
        #navigation li a.active,
        #navigation li a:hover,
        #navigation li a:focus {
            background-color: #343a40;
            color: #ffffff;
            border-radius: 5px;
        }

        /* Jika sudah dikunjungi */
        #navigation li a:visited {
            color: #d1d1d1;
            /* Warna sedikit lebih redup */
        }
    </style>

</head>

<body>
    <!-- header-end -->
    <header>
        <div class="header-area">
            <div id="sticky-header" class="main-header-area">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="col-xl-3 col-lg-3">
                            <div class="logo">
                                <a href="<?= $baseUrl ;?>">
                                    <h4 class="text-white">Kelompok Sosial Test</h4>
                                </a>
                            </div>
                        </div>
                        <div class="col-xl-9 col-lg-9">
                            <div class="main-menu">
                                <nav>
                                    <ul id="navigation">
                                        <li><a href="<?= $baseUrl; ?>index.php" class="<?= ($currentPage == 'index.php') ? 'active' : ''; ?>">Home</a></li>
                                        <li><a href="<?= $baseUrl; ?>materi.php" class="<?= ($currentPage == 'materi.php') ? 'active' : ''; ?>">Materi</a></li>
                                        <li><a href="<?= $baseUrl; ?>forum.php" class="<?= ($currentPage == 'forum.php') ? 'active' : ''; ?>">Forum Diskusi</a></li>
                                        <li>
                                            <?php if (isset($userId)) : ?>
                                                <div class="d-lg-block btn-danger btn text-white btn-sm" style="color: white;">
                                                    <a href="<?= $baseUrl; ?>logout.php" class="text-white">Logout</a>
                                                </div>
                                            <?php else : ?>
                                                <div class="d-lg-block btn-sm" style="background-color: white; color: #333333;">
                                                    <a href="<?= $baseUrl; ?>login.php" style="color: #333333;">Login</a>
                                                </div>
                                            <?php endif ?>
                                        </li>
                                    </ul>

                                </nav>

                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mobile_menu d-block d-lg-none"></div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </header>