<?php
require_once dirname(__DIR__) . '/config/config.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sistem Deteksi Hoaks Bengkulu</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">

    <div class="container">

        <a
            class="navbar-brand fw-bold"
            href="<?= BASE_URL ?>/index.php"
        >
            DETEKSI INFORMASI HOAKS
        </a>


        <button
            class="navbar-toggler"
            data-bs-toggle="collapse"
            data-bs-target="#navbar"
        >
            <span class="navbar-toggler-icon"></span>
        </button>


        <div
            class="collapse navbar-collapse"
            id="navbar"
        >

            <ul class="navbar-nav ms-auto">

                <li class="nav-item">
                    <a
                        class="nav-link"
                        href="<?= BASE_URL ?>/index.php"
                    >
                        Beranda
                    </a>
                </li>


                <li class="nav-item">
                    <a
                        class="nav-link"
                        href="<?= BASE_URL ?>/informasi.php"
                    >
                        Informasi
                    </a>
                </li>


                <?php if (isset($_SESSION['user'])): ?>

                    <?php if (
                        $_SESSION['user']['role']
                        === 'admin'
                    ): ?>

                        <li class="nav-item">
                            <a
                                class="nav-link"
                                href="<?= BASE_URL ?>/admin/dashboard.php"
                            >
                                Dashboard
                            </a>
                        </li>

                    <?php else: ?>

                        <li class="nav-item">
                            <a
                                class="nav-link"
                                href="<?= BASE_URL ?>/user/lapor.php"
                            >
                                Laporkan
                            </a>
                        </li>

                        <li class="nav-item">
                            <a
                                class="nav-link"
                                href="<?= BASE_URL ?>/user/laporan.php"
                            >
                                Laporan Saya
                            </a>
                        </li>

                    <?php endif; ?>


                    <li class="nav-item">
                        <a
                            class="nav-link"
                            href="<?= BASE_URL ?>/auth/logout.php"
                        >
                            Keluar
                        </a>
                    </li>

                <?php else: ?>

                    <li class="nav-item">
                        <a
                            class="nav-link"
                            href="<?= BASE_URL ?>/auth/login.php"
                        >
                            Login
                        </a>
                    </li>

                <?php endif; ?>

            </ul>

        </div>

    </div>

</nav>

<main>
