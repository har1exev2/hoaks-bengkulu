<?php

require_once
    __DIR__ .
    "/../config/config.php";

login_required();


if (
    $_SESSION['user']['role']
    !== 'user'
) {

    die("Halaman ini hanya untuk user.");

}


$error = "";


/*
|--------------------------------------------------------------------------
| AMBIL KATEGORI
|--------------------------------------------------------------------------
*/

$kategori =
    $conn->query(
        "SELECT *
         FROM kategori
         ORDER BY nama_kategori"
    );


/*
|--------------------------------------------------------------------------
| PROSES FORM
|--------------------------------------------------------------------------
*/

if (
    $_SERVER['REQUEST_METHOD']
    === 'POST'
) {

    $judul =
        trim($_POST['judul']);

    $isi =
        trim($_POST['isi']);

    $sumber =
        trim($_POST['sumber']);

    $url =
        trim($_POST['url']);

    $id_kategori =
        intval(
            $_POST['id_kategori']
        );


    /*
    |--------------------------------------------------------------------------
    | DETEKSI AWAL
    |--------------------------------------------------------------------------
    */

    $deteksi =
        deteksiAwal(
            $judul,
            $isi,
            $sumber,
            $url
        );


    /*
    |--------------------------------------------------------------------------
    | UPLOAD BUKTI
    |--------------------------------------------------------------------------
    */

    $namaFile = "";


    if (
        isset($_FILES['bukti'])
        &&
        $_FILES['bukti']['error']
        === UPLOAD_ERR_OK
    ) {

        $file =
            $_FILES['bukti'];


        $ext =
            strtolower(
                pathinfo(
                    $file['name'],
                    PATHINFO_EXTENSION
                )
            );


        $allowed = [

            "jpg",
            "jpeg",
            "png",
            "webp",
            "pdf"

        ];


        if (
            !in_array(
                $ext,
                $allowed
            )
        ) {

            $error =
                "Format file tidak didukung.";

        } else {

            $namaFile =
                uniqid(
                    "bukti_"
                ) .
                "." .
                $ext;


            $uploadDir = getenv("UPLOAD_DIR") ?: (__DIR__ . "/../uploads");

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0775, true);
            }

            move_uploaded_file(
                $file['tmp_name'],
                rtrim($uploadDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $namaFile
            );
        }
    }


    if (!$error) {

        $stmt =
            $conn->prepare(

                "INSERT INTO laporan
                (
                    id_user,
                    id_kategori,
                    judul,
                    isi_informasi,
                    sumber,
                    url,
                    bukti,
                    nilai_deteksi,
                    hasil_deteksi,
                    status,
                    alasan
                )

                VALUES
                (
                    ?,?,?,?,?,?,?,?,?,?,?
                )"

            );


        $userId =
            $_SESSION['user']['id_user'];


        $status =
            "Baru";


        $stmt->bind_param(

            "iisssssiiss",

            $userId,

            $id_kategori,

            $judul,

            $isi,

            $sumber,

            $url,

            $namaFile,

            $deteksi['nilai'],

            $deteksi['hasil'],

            $status,

            $deteksi['alasan']

        );


        if ($stmt->execute()) {

            redirect(
                "/user/laporan.php"
            );

        } else {

            $error =
                "Gagal menyimpan laporan.";
        }
    }

}


$pageTitle =
    "Laporkan Informasi";

require_once
    __DIR__ .
    "/../includes/header.php";

?>


<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-8">

            <div class="card shadow p-4">

                <h2>
                    Laporkan Informasi
                </h2>

                <p class="text-muted">

                    Masukkan informasi yang
                    Anda anggap mencurigakan.

                </p>


                <?php if ($error): ?>

                    <div class="alert alert-danger">
                        <?= clean($error) ?>
                    </div>

                <?php endif; ?>


                <form
                    method="POST"
                    enctype="multipart/form-data"
                >

                    <div class="mb-3">

                        <label>
                            Judul Informasi *
                        </label>

                        <input
                            type="text"
                            name="judul"
                            class="form-control"
                            required
                        >

                    </div>


                    <div class="mb-3">

                        <label>
                            Isi Informasi *
                        </label>

                        <textarea
                            name="isi"
                            class="form-control"
                            rows="7"
                            required
                        ></textarea>

                    </div>


                    <div class="mb-3">

                        <label>
                            Sumber Informasi
                        </label>

                        <input
                            type="text"
                            name="sumber"
                            class="form-control"
                        >

                    </div>


                    <div class="mb-3">

                        <label>
                            URL / Link
                        </label>

                        <input
                            type="url"
                            name="url"
                            class="form-control"
                            placeholder="https://..."
                        >

                    </div>


                    <div class="mb-3">

                        <label>
                            Kategori *
                        </label>

                        <select
                            name="id_kategori"
                            class="form-select"
                            required
                        >

                            <option value="">
                                Pilih kategori
                            </option>


                            <?php while (
                                $row =
                                $kategori->fetch_assoc()
                            ): ?>

                                <option
                                    value="<?= $row['id_kategori'] ?>"
                                >

                                    <?= clean(
                                        $row['nama_kategori']
                                    ) ?>

                                </option>

                            <?php endwhile; ?>

                        </select>

                    </div>


                    <div class="mb-3">

                        <label>
                            Bukti / Screenshot
                        </label>

                        <input
                            type="file"
                            name="bukti"
                            id="bukti"
                            class="form-control"
                            accept=".jpg,.jpeg,.png,.webp,.pdf"
                        >

                        <small
                            id="fileName"
                            class="text-muted"
                        >
                            Belum ada file
                        </small>

                    </div>


                    <button
                        type="submit"
                        class="btn btn-primary"
                    >

                        Kirim Laporan

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