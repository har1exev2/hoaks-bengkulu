<?php

function redirect($url)
{
    header("Location: " . BASE_URL . $url);
    exit;
}


function login_required()
{
    if (!isset($_SESSION['user'])) {
        redirect("/auth/login.php");
    }
}


function admin_required()
{
    login_required();

    if ($_SESSION['user']['role'] !== 'admin') {
        die("Akses ditolak.");
    }
}


function clean($data)
{
    return htmlspecialchars(
        $data ?? '',
        ENT_QUOTES,
        'UTF-8'
    );
}


/*
|--------------------------------------------------------------------------
| DETEKSI AWAL
|--------------------------------------------------------------------------
|
| Sistem memberikan indikasi awal.
| Bukan keputusan akhir bahwa informasi adalah hoaks.
|
*/

function deteksiAwal(
    $judul,
    $isi,
    $sumber,
    $url
) {

    $text = strtolower(
        $judul . " " .
        $isi . " " .
        $sumber
    );

    $score = 0;
    $alasan = [];

    $kataMencurigakan = [

        "sebarkan" => 10,

        "viralkan" => 10,

        "hadiah gratis" => 10,

        "klik sekarang" => 10,

        "100% benar" => 15,

        "pasti benar" => 15,

        "nomor rekening" => 10,

        "transfer" => 10,

        "undian" => 5,

        "urgent" => 5,

        "penting!!!" => 5

    ];


    foreach (
        $kataMencurigakan
        as $kata => $nilai
    ) {

        if (
            strpos($text, $kata)
            !== false
        ) {

            $score += $nilai;

            $alasan[] =
                "Ditemukan kata/pola: "
                . $kata;
        }
    }


    if (empty($sumber)) {

        $score += 10;

        $alasan[] =
            "Sumber informasi tidak dicantumkan.";
    }


    if (empty($url)) {

        $score += 10;

        $alasan[] =
            "URL sumber tidak dicantumkan.";
    }


    if (strlen($isi) < 100) {

        $score += 5;

        $alasan[] =
            "Isi informasi terlalu singkat.";
    }


    if ($score >= 50) {

        $hasil = "Tinggi";

    } elseif ($score >= 25) {

        $hasil = "Sedang";

    } else {

        $hasil = "Rendah";
    }


    $score = min($score, 100);


    if (empty($alasan)) {

        $alasan[] =
            "Tidak ditemukan pola mencurigakan utama.";
    }


    return [

        "nilai" => $score,

        "hasil" => $hasil,

        "alasan" => implode(
            ", ",
            $alasan
        )
    ];
}


function statusBadge($status)
{
    switch ($status) {

        case "Hoaks":
            return '<span class="badge bg-danger">
                        Hoaks
                    </span>';

        case "Fakta":
            return '<span class="badge bg-success">
                        Fakta
                    </span>';

        case "Diproses":
            return '<span class="badge bg-warning text-dark">
                        Diproses
                    </span>';

        case "Belum Terverifikasi":
            return '<span class="badge bg-secondary">
                        Belum Terverifikasi
                    </span>';

        default:
            return '<span class="badge bg-primary">
                        Baru
                    </span>';
    }
}

?>