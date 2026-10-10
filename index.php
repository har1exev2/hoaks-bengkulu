<?php

$pageTitle =
    "Beranda - Hoaks Bengkulu";

require_once
    __DIR__ .
    "/includes/header.php";


// Statistik

$total = $conn
    ->query(
        "SELECT COUNT(*) AS total
         FROM laporan"
    )
    ->fetch_assoc()['total'];


$hoaks = $conn
    ->query(
        "SELECT COUNT(*) AS total
         FROM laporan
         WHERE status='Hoaks'"
    )
    ->fetch_assoc()['total'];


$fakta = $conn
    ->query(
        "SELECT COUNT(*) AS total
         FROM laporan
         WHERE status='Fakta'"
    )
    ->fetch_assoc()['total'];


$proses = $conn
    ->query(
        "SELECT COUNT(*) AS total
         FROM laporan
         WHERE status IN
         ('Baru','Diproses')"
    )
    ->fetch_assoc()['total'];

?>

<div class="container">

    <!-- HERO -->

    <section class="hero">

        <div class="row align-items-center">

            <div class="col-md-7">

                <span class="badge bg-light text-primary mb-3">
                    Kota Bengkulu
                </span>

                <h1>
                    Waspadai Informasi
                    Sebelum Menyebarkannya
                </h1>

                <p class="lead">

                    Laporkan informasi yang
                    diduga hoaks dan bantu
                    masyarakat mendapatkan
                    informasi yang lebih terpercaya.

                </p>


                <?php if (
                    isset($_SESSION['user'])
                ): ?>

                    <a
                        href="<?= BASE_URL ?>/user/lapor.php"
                        class="btn btn-light btn-lg"
                    >
                        Laporkan Informasi
                    </a>

                <?php else: ?>

                    <a
                        href="<?= BASE_URL ?>/auth/login.php"
                        class="btn btn-light btn-lg"
                    >
                        Mulai Melapor
                    </a>

                <?php endif; ?>

            </div>

        </div>

    </section>


    <!-- STATISTIK -->

    <div class="row g-4 mt-3">

        <div class="col-md-3">

            <div class="card stat-card p-4">

                <small>Total Laporan</small>

                <h2>
                    <?= $total ?>
                </h2>

            </div>

        </div>


        <div class="col-md-3">

            <div class="card stat-card p-4">

                <small>Hoaks</small>

                <h2 class="text-danger">
                    <?= $hoaks ?>
                </h2>

            </div>

        </div>


        <div class="col-md-3">

            <div class="card stat-card p-4">

                <small>Fakta</small>

                <h2 class="text-success">
                    <?= $fakta ?>
                </h2>

            </div>

        </div>


        <div class="col-md-3">

            <div class="card stat-card p-4">

                <small>Dalam Proses</small>

                <h2 class="text-warning">
                    <?= $proses ?>
                </h2>

            </div>

        </div>

    </div>


    <!-- INFORMASI -->

    <div class="card shadow-sm mt-5 p-4">

        <h3>
            Bagaimana Sistem Bekerja?
        </h3>

        <div class="row mt-4">

            <div class="col-md-3 text-center">

                <h1>1</h1>

                <h5>Laporkan</h5>

                <p>
                    Masyarakat mengirimkan
                    informasi yang dicurigai.
                </p>

            </div>


            <div class="col-md-3 text-center">

                <h1>2</h1>

                <h5>Deteksi Awal</h5>

                <p>
                    Sistem melakukan analisis
                    awal terhadap informasi.
                </p>

            </div>


            <div class="col-md-3 text-center">

                <h1>3</h1>

                <h5>Verifikasi</h5>

                <p>
                    Admin memeriksa laporan
                    dan bukti pendukung.
                </p>

            </div>


            <div class="col-md-3 text-center">

                <h1>4</h1>

                <h5>Hasil</h5>

                <p>
                    Hasil verifikasi dapat
                    dilihat masyarakat.
                </p>

            </div>

        </div>

    </div>

</div>


<?php

require_once
    __DIR__ .
    "/includes/footer.php";

?>