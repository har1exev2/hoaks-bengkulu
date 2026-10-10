<?php

require_once
    __DIR__ .
    "/../config/config.php";

admin_required();


$id =
    intval(
        $_GET['id'] ?? 0
    );


$stmt =
    $conn->prepare(

        "SELECT
            l.*,
            u.nama,
            k.nama_kategori

        FROM laporan l

        LEFT JOIN users u
            ON l.id_user =
               u.id_user

        LEFT JOIN kategori k
            ON l.id_kategori =
               k.id_kategori

        WHERE l.id_laporan = ?"

    );


$stmt->bind_param(
    "i",
    $id
);

$stmt->execute();


$laporan =
    $stmt
        ->get_result()
        ->fetch_assoc();


if (!$laporan) {

    die(
        "Laporan tidak ditemukan."
    );
}


if (
    $_SERVER['REQUEST_METHOD']
    === 'POST'
) {

    $status =
        $_POST['status'];

    $keterangan =
        trim(
            $_POST['keterangan']
        );


    $allowed = [

        "Hoaks",
        "Fakta",
        "Belum Terverifikasi"

    ];


    if (
        in_array(
            $status,
            $allowed
        )
    ) {

        /*
        UPDATE LAPORAN
        */

        $update =
            $conn->prepare(

                "UPDATE laporan

                 SET status = ?, updated_at = CURRENT_TIMESTAMP

                 WHERE id_laporan = ?"

            );


        $update->bind_param(
            "si",
            $status,
            $id
        );


        $update->execute();


        /*
        INSERT VERIFIKASI
        */

        $adminId =
            $_SESSION['user']['id_user'];


        $insert =
            $conn->prepare(

                "INSERT INTO verifikasi
                (
                    id_laporan,
                    id_admin,
                    hasil,
                    keterangan
                )

                VALUES
                (?, ?, ?, ?)"

            );


        $insert->bind_param(

            "iiss",

            $id,

            $adminId,

            $status,

            $keterangan

        );


        $insert->execute();


        redirect(
            "/admin/laporan.php"
        );
    }

}


$pageTitle =
    "Verifikasi Laporan";

require_once
    __DIR__ .
    "/../includes/header.php";

?>


<div class="container py-5">

    <div class="row">

        <div class="col-lg-8">

            <div class="card shadow p-4">

                <h2>
                    <?= clean(
                        $laporan['judul']
                    ) ?>
                </h2>


                <hr>


                <p>

                    <strong>
                        Pelapor:
                    </strong>

                    <?= clean(
                        $laporan['nama']
                    ) ?>

                </p>


                <p>

                    <strong>
                        Kategori:
                    </strong>

                    <?= clean(
                        $laporan['nama_kategori']
                    ) ?>

                </p>


                <p>

                    <strong>
                        Sumber:
                    </strong>

                    <?= clean(
                        $laporan['sumber']
                    ) ?>

                </p>


                <p>

                    <strong>
                        URL:
                    </strong>

                    <?= clean(
                        $laporan['url']
                    ) ?>

                </p>


                <hr>


                <h5>
                    Isi Informasi
                </h5>

                <p>

                    <?= nl2br(
                        clean(
                            $laporan[
                                'isi_informasi'
                            ]
                        )
                    ) ?>

                </p>


                <hr>


                <div
                    class="detection-box"
                >

                    <h5>
                        Hasil Deteksi Awal
                    </h5>

                    <h2>
                        <?= $laporan[
                            'nilai_deteksi'
                        ] ?>%
                    </h2>

                    <p>

                        Indikasi:

                        <strong>

                            <?= clean(
                                $laporan[
                                    'hasil_deteksi'
                                ]
                            ) ?>

                        </strong>

                    </p>


                    <p>

                        <?= clean(
                            $laporan[
                                'alasan'
                            ]
                        ) ?>

                    </p>

                </div>

            </div>

        </div>


        <div class="col-lg-4">

            <div class="card shadow p-4">

                <h4>
                    Verifikasi
                </h4>


                <form method="POST">

                    <div class="mb-3">

                        <label>
                            Hasil Verifikasi
                        </label>

                        <select
                            name="status"
                            class="form-select"
                            required
                        >

                            <option value="">
                                Pilih hasil
                            </option>

                            <option value="Hoaks">
                                Hoaks
                            </option>

                            <option value="Fakta">
                                Fakta
                            </option>

                            <option
                                value="Belum Terverifikasi"
                            >
                                Belum Terverifikasi
                            </option>

                        </select>

                    </div>


                    <div class="mb-3">

                        <label>
                            Keterangan
                        </label>

                        <textarea
                            name="keterangan"
                            class="form-control"
                            rows="6"
                            required
                        ></textarea>

                    </div>


                    <button
                        class="btn btn-primary w-100"
                    >
                        Simpan Verifikasi
                    </button>

                </form>

            </div>

        </div>

    </div>

</div>


<?php

require_once
    __DIR__ .
    "/../includes/footer.php";

?>