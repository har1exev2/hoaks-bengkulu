CREATE DATABASE IF NOT EXISTS hoaks_bengkulu;
USE hoaks_bengkulu;

-- =========================================
-- TABEL USER
-- =========================================

CREATE TABLE users (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('user','admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =========================================
-- TABEL KATEGORI
-- =========================================

CREATE TABLE kategori (
    id_kategori INT AUTO_INCREMENT PRIMARY KEY,
    nama_kategori VARCHAR(100) NOT NULL
);

INSERT INTO kategori (nama_kategori) VALUES
('Pemerintahan'),
('Kesehatan'),
('Pendidikan'),
('Sosial'),
('Ekonomi'),
('Bencana'),
('Keamanan'),
('Lainnya');

-- =========================================
-- TABEL LAPORAN
-- =========================================

CREATE TABLE laporan (
    id_laporan INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    id_kategori INT,
    judul VARCHAR(255) NOT NULL,
    isi_informasi TEXT NOT NULL,
    sumber VARCHAR(255),
    url VARCHAR(500),
    bukti VARCHAR(255),

    nilai_deteksi INT DEFAULT 0,

    hasil_deteksi ENUM(
        'Rendah',
        'Sedang',
        'Tinggi'
    ) DEFAULT 'Rendah',

    status ENUM(
        'Baru',
        'Diproses',
        'Hoaks',
        'Fakta',
        'Belum Terverifikasi'
    ) DEFAULT 'Baru',

    alasan TEXT,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (id_user)
        REFERENCES users(id_user)
        ON DELETE CASCADE,

    FOREIGN KEY (id_kategori)
        REFERENCES kategori(id_kategori)
        ON DELETE SET NULL
);

-- =========================================
-- TABEL VERIFIKASI
-- =========================================

CREATE TABLE verifikasi (
    id_verifikasi INT AUTO_INCREMENT PRIMARY KEY,
    id_laporan INT NOT NULL,
    id_admin INT NOT NULL,
    hasil ENUM(
        'Hoaks',
        'Fakta',
        'Belum Terverifikasi'
    ) NOT NULL,
    keterangan TEXT,
    tanggal_verifikasi TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (id_laporan)
        REFERENCES laporan(id_laporan)
        ON DELETE CASCADE,

    FOREIGN KEY (id_admin)
        REFERENCES users(id_user)
        ON DELETE CASCADE
);

-- =========================================
-- ADMIN DEMO
-- Password: password
-- =========================================

INSERT INTO users
(nama, email, password, role)
VALUES
(
    'Administrator',
    'admin@gmail.com',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEaJ6k2J4yqK2rVvP2oQqg6Q1hG',
    'admin'
);

-- USER DEMO
INSERT INTO users
(nama, email, password, role)
VALUES
(
    'User Demo',
    'user@gmail.com',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEaJ6k2J4yqK2rVvP2oQqg6Q1hG',
    'user'
);