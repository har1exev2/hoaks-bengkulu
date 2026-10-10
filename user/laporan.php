<?php

require_once
    __DIR__ .
    "/../config/config.php";

login_required();


$userId =
    $_SESSION['user']['id_user'];


$stmt =
    $conn->prepare(

        "SELECT
            l.*,
            k.nama_kategori

        FROM laporan l

        LEFT JOIN kategori k
            ON l.id_kategori =
               k.id_kategori

        WHERE l.id_user = ?

        ORDER BY
            l.created_at DESC"

    );


$stmt->bind_param(
    "i",
    $userId
);


$stmt->execute();

$result =
    $stmt->get_result();


$pageTitle =
    "Laporan Saya";

require_once
    __DIR__ .
    "/../includes/header.php";

?>


<div class="container py-5">

    <div class="d-flex
                justify-content-between
                mb-4">

        <h2>
            Laporan Saya
        </h2>

        <a
            href="<?= BASE_URL ?>/user/lapor.php"
            class="btn btn-primary"
        >
            + Laporan
        </a>

    </div>


    <div class="card shadow p-3">

        <div class="table-responsive">

            <table class="table">

                <thead>

                    <tr>

                        <th>ID</th>

                        <th>Judul</th>

                        <th>Kategori</th>

                        <th>Deteksi Awal</th>

                        <th>Status</th>

                        <th>Tanggal</th>

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
                                $row['judul']
                            ) ?>
                        </td>

                        <td>
                            <?= clean(
                                $row['nama_kategori']
                            ) ?>
                        </td>

                        <td>
    <span class="badge bg-success">
        <?= htmlspecialchars($row['hasil_deteksi']) ?>
    </span>
    <span class="ms-2">
        Nilai: <?= (int)$row['nilai_deteksi'] ?>%
    </span>
</td>

                        <td>

                            <?= statusBadge(
                                $row['status']
                            ) ?>

                        </td>

                        <td>

                            <?= date(
                                "d-m-Y",
                                strtotime(
                                    $row['created_at']
                                )
                            ) ?>

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