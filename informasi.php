<?php

require_once
    __DIR__ .
    "/config/config.php";


$query = "

SELECT

    l.*,

    k.nama_kategori

FROM laporan l

LEFT JOIN kategori k
    ON l.id_kategori =
       k.id_kategori

WHERE l.status
IN ('Hoaks','Fakta')

ORDER BY
    l.updated_at DESC

";


$result =
    $conn->query($query);


$pageTitle =
    "Informasi Terverifikasi";

require_once
    __DIR__ .
    "/includes/header.php";

?>


<div class="container py-5">

    <h1>
        Informasi Terverifikasi
    </h1>

    <p class="text-muted">

        Informasi yang telah diperiksa
        dan diverifikasi oleh admin.

    </p>


    <div class="row g-4 mt-3">

    <?php while (
        $row =
        $result->fetch_assoc()
    ): ?>

        <div class="col-md-6">

            <div
                class="card shadow p-4 h-100"
            >

                <div
                    class="d-flex
                           justify-content-between"
                >

                    <h4>
                        <?= clean(
                            $row['judul']
                        ) ?>
                    </h4>

                    <?= statusBadge(
                        $row['status']
                    ) ?>

                </div>


                <small class="text-muted">

                    <?= clean(
                        $row[
                            'nama_kategori'
                        ]
                    ) ?>

                </small>


                <hr>


                <p>

                    <?= nl2br(
                        clean(
                            mb_strimwidth(
                                $row[
                                    'isi_informasi'
                                ],
                                0,
                                300,
                                "..."
                            )
                        )
                    ) ?>

                </p>

            </div>

        </div>

    <?php endwhile; ?>

    </div>

</div>


<?php

require_once
    __DIR__ .
    "/includes/footer.php";

?>