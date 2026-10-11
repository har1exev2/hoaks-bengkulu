body {

    background-color: #f5f7fb;

    color: #212529;

    font-family:
        Arial,
        Helvetica,
        sans-serif;
}


.hero {

    background:
        linear-gradient(
            135deg,
            #0d6efd,
            #003d99
        );

    color: white;

    border-radius: 25px;

    padding: 60px 40px;

    margin-top: 30px;
}


.hero h1 {

    font-weight: 700;

}


.card {

    border: none;

    border-radius: 16px;

}


.stat-card {

    transition:
        transform .2s ease,
        box-shadow .2s ease;
}


.stat-card:hover {

    transform:
        translateY(-5px);

    box-shadow:
        0 10px 30px
        rgba(0,0,0,.1);
}


.btn {

    border-radius: 10px;
}


.form-control,
.form-select {

    border-radius: 10px;

    padding: 12px;
}


.report-card {

    transition: .2s;
}


.report-card:hover {

    transform:
        translateY(-3px);
}


.detection-box {

    border-left:
        5px solid #0d6efd;

    background:
        #eef5ff;

    padding: 20px;

    border-radius: 10px;
}


.footer {

    margin-top: 100px;
}


.table {

    background: white;
}


.badge {

    padding: 8px 10px;
}

/* =========================
   STICKY FOOTER
========================= */

html,
body {
    height: 100%;
}

body {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

main {
    flex: 1;
}

/* Footer */
footer {
    width: 100%;
}

/* Responsive */
@media (max-width: 768px) {
    footer {
        font-size: 14px;
    }

    footer p {
        margin-bottom: 5px;
    }
}
/* =========================================
   HALAMAN KELOLA LAPORAN
   ========================================= */

/* Tampilan tabel */
.tabel-kelola-laporan {
    width: 100%;
    vertical-align: middle;
}

.tabel-kelola-laporan th,
.tabel-kelola-laporan td {
    vertical-align: middle;
    padding: 12px 8px;
}

.tabel-kelola-laporan th {
    font-weight: 600;
    white-space: nowrap;
}

/* Kolom aksi */
.tabel-kelola-laporan .kolom-aksi {
    min-width: 175px;
    white-space: nowrap;
}

/* Susunan tombol */
.tombol-aksi {
    display: inline-flex;
    flex-direction: row;
    align-items: center;
    justify-content: flex-start;
    gap: 8px;
}

/* Samakan ukuran tombol Periksa dan Hapus */
.tombol-aksi .btn-aksi {
    display: inline-flex;
    align-items: center;
    justify-content: center;

    width: 76px;
    min-width: 76px;
    height: 32px;

    margin: 0;
    padding: 0 8px;

    font-size: 13px;
    font-weight: 500;
    line-height: 1;

    border-radius: 5px;
    white-space: nowrap;
    box-sizing: border-box;
}

/* Hilangkan margin bawaan pada form */
.form-hapus-laporan {
    display: inline-flex;
    margin: 0;
    padding: 0;
}

/* Pastikan kedua tombol tidak membesar saat hover */
.tombol-aksi .btn-aksi:hover {
    transform: none;
}

/* Tampilan layar kecil */
@media (max-width: 768px) {
    .tabel-kelola-laporan {
        min-width: 700px;
    }

    .tabel-kelola-laporan th,
    .tabel-kelola-laporan td {
        padding: 10px 8px;
    }

    .tombol-aksi {
        gap: 6px;
    }
}
