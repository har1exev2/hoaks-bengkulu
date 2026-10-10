<?php

require_once
    __DIR__ .
    "/../config/config.php";

admin_required();


$total =
    $conn->query(
        "SELECT COUNT(*) total
         FROM laporan"
    )->fetch_assoc()['total'];


$baru =
    $conn->query(
        "SELECT COUNT(*) total
         FROM laporan
         WHERE status='Baru'"
    )->fetch_assoc()['total'];


$diproses =
    $conn->query(
        "SELECT COUNT(*) total
         FROM laporan
         WHERE status='Diproses'"
    )->fetch_assoc()['total'];


$hoaks =
    $conn->query(
        "SELECT COUNT(*) total
         FROM laporan
         WHERE status='Hoaks'"
    )->fetch_assoc()['total'];


$fakta =
    $conn->query(
        "SELECT COUNT(*) total
         FROM laporan
         WHERE status='Fakta'"
    )->fetch_assoc()['total'];


$pageTitle =
    "Dashboard Admin";

require_once
    __DIR__ .
    "/../includes/header.php";

?>


<div class="container py-5">

    <h1>
        Dashboard Admin
    </h1>

    <p class="text-muted">
        Sistem Informasi Hoaks Kota Bengkulu
    </p>


    <!-- STATISTIK -->

    <div class="row g-3 mt-3">

        <div class="col-md">

            <div class="card shadow p-4">

                <small>Total Laporan</small>

                <h2>
                    <?= $total ?>
                </h2>

            </div>

        </div>


        <div class="col-md">

            <div class="card shadow p-4">

                <small>Laporan Baru</small>

                <h2 class="text-primary">
                    <?= $baru ?>
                </h2>

            </div>

        </div>


        <div class="col-md">

            <div class="card shadow p-4">

                <small>Diproses</small>

                <h2 class="text-warning">
                    <?= $diproses ?>
                </h2>

            </div>

        </div>


        <div class="col-md">

            <div class="card shadow p-4">

                <small>Hoaks</small>

                <h2 class="text-danger">
                    <?= $hoaks ?>
                </h2>

            </div>

        </div>


        <div class="col-md">

            <div class="card shadow p-4">

                <small>Fakta</small>

                <h2 class="text-success">
                    <?= $fakta ?>
                </h2>

            </div>

        </div>

    </div>


    <!-- MENU ADMIN -->

    <div class="row mt-5 g-4">

        <div class="col-md-4">

            <a
                href="<?= BASE_URL ?>/admin/laporan.php"
                class="text-decoration-none"
            >

                <div class="card shadow p-4">

                    <h4>
                        📋 Kelola Laporan
                    </h4>

                    <p>
                        Melihat semua laporan
                        masyarakat.
                    </p>

                </div>

            </a>

        </div>


        <div class="col-md-4">

            <a
                href="<?= BASE_URL ?>/informasi.php"
                class="text-decoration-none"
            >

                <div class="card shadow p-4">

                    <h4>
                        🔎 Informasi Terverifikasi
                    </h4>

                    <p>
                        Melihat informasi yang
                        sudah diverifikasi.
                    </p>

                </div>

            </a>

        </div>

    </div>

</div>


<?php

require_once
    __DIR__ .
    "/../includes/footer.php";

?>