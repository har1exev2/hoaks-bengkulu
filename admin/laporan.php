<?php

require_once __DIR__ . "/../config/config.php";

// Pastikan hanya admin yang dapat mengakses halaman ini.
admin_required();

// Membuat token CSRF untuk melindungi aksi hapus.
if (empty($_SESSION['csrf_hapus_laporan'])) {
    $_SESSION['csrf_hapus_laporan'] = bin2hex(random_bytes(32));
}

// Proses penghapusan laporan.
if ($_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_POST['hapus_laporan'])) {

    $token = $_POST['csrf_token'] ?? '';
    $idLaporan = filter_input(
        INPUT_POST,
        'id_laporan',
        FILTER_VALIDATE_INT
    );

    if (
        !is_string($token) ||
        !hash_equals($_SESSION['csrf_hapus_laporan'], $token)
    ) {
        $_SESSION['flash_laporan'] = [
            'type' => 'danger',
            'message' => 'Permintaan tidak valid. Silakan coba lagi.'
        ];
    } elseif (!$idLaporan || $idLaporan < 1) {
        $_SESSION['flash_laporan'] = [
            'type' => 'danger',
            'message' => 'ID laporan tidak valid.'
        ];
    } else {
        try {
            // Periksa apakah laporan tersedia.
            $check = $conn->prepare(
                "SELECT id_laporan
                 FROM laporan
                 WHERE id_laporan = ?"
            );

            $check->bind_param("i", $idLaporan);
            $check->execute();

            $dataLaporan = $check->get_result();

            if ($dataLaporan->num_rows === 0) {
                $_SESSION['flash_laporan'] = [
                    'type' => 'warning',
                    'message' => 'Laporan tidak ditemukan.'
                ];
            } else {
                // Hapus laporan.
                $hapus = $conn->prepare(
                    "DELETE FROM laporan
                     WHERE id_laporan = ?"
                );

                $hapus->bind_param("i", $idLaporan);
                $hapus->execute();

                $_SESSION['flash_laporan'] = [
                    'type' => 'success',
                    'message' => 'Laporan berhasil dihapus.'
                ];
            }
        } catch (Throwable $e) {
            error_log(
                "Gagal menghapus laporan: " . $e->getMessage()
            );

            $_SESSION['flash_laporan'] = [
                'type' => 'danger',
                'message' => 'Laporan gagal dihapus. Silakan periksa log aplikasi.'
            ];
        }
    }

    // Kembali ke halaman Kelola Laporan.
    header("Location: " . BASE_URL . "/admin/laporan.php");
    exit;
}

// Ambil daftar laporan dan nama pelapor.
$query = "
    SELECT
        l.*,
        u.nama,
        k.nama_kategori
    FROM laporan l
    LEFT JOIN users u
        ON l.id_user = u.id_user
    LEFT JOIN kategori k
        ON l.id_kategori = k.id_kategori
    ORDER BY l.created_at DESC
";

$result = $conn->query($query);

$pageTitle = "Kelola Laporan";

require_once __DIR__ . "/../includes/header.php";
?>

<div class="container py-5">

    <h2>Kelola Laporan</h2>

    <?php if (!empty($_SESSION['flash_laporan'])): ?>
        <div class="alert alert-<?= clean(
            $_SESSION['flash_laporan']['type']
        ) ?> alert-dismissible fade show mt-3"
             role="alert">

            <?= clean($_SESSION['flash_laporan']['message']) ?>

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Tutup">
            </button>
        </div>

        <?php unset($_SESSION['flash_laporan']); ?>
    <?php endif; ?>

    <div class="card shadow p-3 mt-4">

        <div class="table-responsive">
            <table class="table align-middle">

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

                <?php
                $adaLaporan = false;

                while ($row = $result->fetch_assoc()):
                    if (!$row) {
                        break;
                    }

                    $adaLaporan = true;
                ?>

                    <tr>
                        <td>
                            #<?= (int) $row['id_laporan'] ?>
                        </td>

                        <td>
                            <?= clean($row['nama'] ?? '-') ?>
                        </td>

                        <td>
                            <?= clean($row['judul'] ?? '-') ?>
                        </td>

                        <td>
                            <?= clean($row['hasil_deteksi'] ?? '-') ?>
                            <br>
                            <small class="text-muted">
                                <?= (int) ($row['nilai_deteksi'] ?? 0) ?>%
                            </small>
                        </td>

                        <td>
                            <?= statusBadge($row['status'] ?? '') ?>
                        </td>

                        <td>
                            <div class="d-flex flex-wrap gap-2">

                                <a
                                    href="<?= BASE_URL ?>/admin/verifikasi.php?id=<?= (int) $row['id_laporan'] ?>"
                                    class="btn btn-sm btn-primary">
                                    Periksa
                                </a>

                                <form
                                    method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Yakin ingin menghapus laporan ini? Penghapusan tidak dapat dibatalkan.');">

                                    <input
                                        type="hidden"
                                        name="csrf_token"
                                        value="<?= clean($_SESSION['csrf_hapus_laporan']) ?>">

                                    <input
                                        type="hidden"
                                        name="id_laporan"
                                        value="<?= (int) $row['id_laporan'] ?>">

                                    <button
                                        type="submit"
                                        name="hapus_laporan"
                                        value="1"
                                        class="btn btn-sm btn-danger">
                                        Hapus
                                    </button>

                                </form>

                            </div>
                        </td>
                    </tr>

                <?php endwhile; ?>

                <?php if (!$adaLaporan): ?>
                    <tr>
                        <td colspan="6"
                            class="text-center text-muted py-4">
                            Belum ada laporan.
                        </td>
                    </tr>
                <?php endif; ?>

                </tbody>
            </table>
        </div>

    </div>
</div>

<?php require_once __DIR__ . "/../includes/footer.php"; ?>
