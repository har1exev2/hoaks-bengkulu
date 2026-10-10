# Sistem Informasi Pelaporan dan Deteksi Awal Informasi Hoaks Kota Bengkulu

Versi ini menggunakan **PHP + SQLite**.

## Jalankan lokal tanpa XAMPP

Syarat:
- PHP 8 atau lebih baru
- Ekstensi `PDO SQLite` aktif

Di terminal VS Code:

```bash
php -m
php -S localhost:8000
```

Buka:

```text
http://localhost:8000
```

Database dibuat otomatis oleh aplikasi.

Akun demo:
- Admin: `admin@gmail.com` / `password`
- User: `user@gmail.com` / `password`

## Upload ke GitHub

GitHub berfungsi sebagai tempat menyimpan source code. **GitHub Pages tidak menjalankan PHP dan database.**

Untuk menjalankan aplikasi online:
1. Push folder project ini ke GitHub.
2. Hubungkan repository GitHub ke layanan hosting yang mendukung Docker/PHP, misalnya Railway atau Render.
3. Deploy menggunakan `Dockerfile` yang sudah disediakan.

## Database online

Aplikasi memakai SQLite. Untuk hosting, database harus diletakkan pada **persistent volume/disk** supaya data laporan tidak hilang ketika container dibuat ulang.

Atur:
- `DB_FILE=/data/hoaks_bengkulu.sqlite`
- `UPLOAD_DIR=/data/uploads`

Mount persistent volume ke:

```text
/data
```

Jika memakai Railway, buat Volume dan mount ke `/data`.
Jika memakai provider lain, gunakan persistent disk/volume dengan prinsip yang sama.

## Catatan penting

Jangan commit file `database/*.sqlite` yang berisi data pengguna ke repository publik. File tersebut berpotensi berisi email, laporan, atau bukti unggahan.

Sistem "deteksi awal" pada project ini adalah **rule-based scoring**, bukan machine learning. Hasilnya merupakan indikasi awal dan keputusan akhir tetap melalui verifikasi admin.
