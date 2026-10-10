<?php

require_once
    __DIR__ .
    "/../config/config.php";

admin_required();


$query = "

SELECT

    l.*,

    u.nama,

    k.nama_kategori

FROM laporan l

LEFT JOIN users u
    ON l.id_user = u.id_user

LEFT JOIN kategori k
    ON l.id_kategori =
       k.id_kategori

ORDER BY
    l.created_at DESC

";


$result =
    $conn->query($query);


$pageTitle =
    "Kelola Laporan";

require_once
    __DIR__ .
    "/../includes/header.php";

?>


<div class="container py-5">

    <h2>
        Kelola Laporan
    </h2>


    <div class="card shadow p-3 mt-4">

        <div class="table-responsive">

            <table class="table">

                <thead>

                    <tr>

                        <th>ID</th>

                        <th>Pelapor</th>

                        <th>Judul</th>

                        <th>Deteksi</th>

                        <th>Status</th>

                        <th>Aksi</th>

                    </tr>

                </thead>


                <tbody>

                <?php while (
                    $row =
                    $result->fetch_assoc()
                ): ?>

                    <tr>

                        <td>
                            #<?= $row['id_laporan'] ?>
                        </td>

                        <td>
                            <?= clean(
                                $row['nama']
                            ) ?>
                        </td>

                        <td>
                            <?= clean(
                                $row['judul']
                            ) ?>
                        </td>

                        <td>

                            <?= clean(
                                $row['hasil_deteksi']
                            ) ?>

                            <br>

                            <small>
                                <?= $row['nilai_deteksi'] ?>%
                            </small>

                        </td>

                        <td>

                            <?= statusBadge(
                                $row['status']
                            ) ?>

                        </td>

                        <td>

                            <a
                                href="<?= BASE_URL ?>/admin/verifikasi.php?id=<?= $row['id_laporan'] ?>"
                                class="btn btn-sm btn-primary"
                            >
                                Periksa
                            </a>

                        </td>

                    </tr>

                <?php endwhile; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>


<?php

require_once
    __DIR__ .
    "/../includes/footer.php";

?>