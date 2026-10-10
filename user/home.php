<?php

require_once
    __DIR__ .
    "/../config/config.php";

login_required();

$pageTitle =
    "Dashboard User";

require_once
    __DIR__ .
    "/../includes/header.php";

?>


<div class="container py-5">

    <div class="card shadow p-5">

        <h1>
            Selamat Datang,
            <?= clean(
                $_SESSION['user']['nama']
            ) ?>
        </h1>

        <p class="lead">

            Selamat datang di Sistem
            Informasi Pelaporan dan
            Deteksi Awal Informasi Hoaks
            Kota Bengkulu.

        </p>


        <div class="mt-3">

            <a
                href="<?= BASE_URL ?>/user/lapor.php"
                class="btn btn-primary"
            >
                Laporkan Informasi
            </a>


            <a
                href="<?= BASE_URL ?>/user/laporan.php"
                class="btn btn-outline-primary"
            >
                Lihat Laporan Saya
            </a>

        </div>

    </div>

</div>


<?php

require_once
    __DIR__ .
    "/../includes/footer.php";

?>