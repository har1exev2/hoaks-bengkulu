<?php
/**
 * SQLite database for the VS Code standalone version.
 * No XAMPP / MySQL / phpMyAdmin required.
 */

class DBResult
{
    private $rows;
    private $index = 0;

    public function __construct($rows)
    {
        $this->rows = $rows;
    }

    public function fetch_assoc()
    {
        if ($this->index >= count($this->rows)) {
            return null;
        }
        return $this->rows[$this->index++];
    }

    public function num_rows()
    {
        return count($this->rows);
    }
}

class DBStatement
{
    private $pdo;
    private $sql;
    private $stmt;
    private $params = [];

    public function __construct($pdo, $sql)
    {
        $this->pdo = $pdo;
        $this->sql = $sql;
        $this->stmt = $pdo->prepare($sql);
    }

    public function bind_param($types, &...$values)
    {
        $this->params = [];
        foreach ($values as $i => &$value) {
            $this->params[$i + 1] = &$value;
        }
        return true;
    }

    public function execute()
    {
        foreach ($this->params as $key => &$value) {
            $this->stmt->bindValue(
                $key,
                $value,
                is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR
            );
        }
        return $this->stmt->execute();
    }

    public function get_result()
    {
        $rows = $this->stmt->fetchAll(PDO::FETCH_ASSOC);
        return new DBResult($rows);
    }
}

class Database
{
    private $pdo;

    public function __construct($file)
    {
        if (!extension_loaded("pdo_sqlite")) {
            die("Ekstensi PDO SQLite belum aktif. Aktifkan pdo_sqlite pada PHP yang digunakan.");
        }

        $dir = dirname($file);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        $this->pdo = new PDO("sqlite:" . $file);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $this->pdo->exec("PRAGMA foreign_keys = ON");

        $this->initialize();
    }

    private function initialize()
    {
        $this->pdo->exec("
            CREATE TABLE IF NOT EXISTS users (
                id_user INTEGER PRIMARY KEY AUTOINCREMENT,
                nama TEXT NOT NULL,
                email TEXT NOT NULL UNIQUE,
                password TEXT NOT NULL,
                role TEXT NOT NULL DEFAULT 'user',
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );

            CREATE TABLE IF NOT EXISTS kategori (
                id_kategori INTEGER PRIMARY KEY AUTOINCREMENT,
                nama_kategori TEXT NOT NULL
            );

            CREATE TABLE IF NOT EXISTS laporan (
                id_laporan INTEGER PRIMARY KEY AUTOINCREMENT,
                id_user INTEGER NOT NULL,
                id_kategori INTEGER,
                judul TEXT NOT NULL,
                isi_informasi TEXT NOT NULL,
                sumber TEXT,
                url TEXT,
                bukti TEXT,
                nilai_deteksi INTEGER DEFAULT 0,
                hasil_deteksi TEXT DEFAULT 'Rendah',
                status TEXT DEFAULT 'Baru',
                alasan TEXT,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE CASCADE,
                FOREIGN KEY (id_kategori) REFERENCES kategori(id_kategori) ON DELETE SET NULL
            );

            CREATE TABLE IF NOT EXISTS verifikasi (
                id_verifikasi INTEGER PRIMARY KEY AUTOINCREMENT,
                id_laporan INTEGER NOT NULL,
                id_admin INTEGER NOT NULL,
                hasil TEXT NOT NULL,
                keterangan TEXT,
                tanggal_verifikasi DATETIME DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (id_laporan) REFERENCES laporan(id_laporan) ON DELETE CASCADE,
                FOREIGN KEY (id_admin) REFERENCES users(id_user) ON DELETE CASCADE
            );
        ");

        $count = (int)$this->pdo->query("SELECT COUNT(*) FROM kategori")->fetchColumn();
        if ($count === 0) {
            $kategori = [
                'Pemerintahan','Kesehatan','Pendidikan','Sosial',
                'Ekonomi','Bencana','Keamanan','Lainnya'
            ];
            $stmt = $this->pdo->prepare("INSERT INTO kategori (nama_kategori) VALUES (?)");
            foreach ($kategori as $nama) {
                $stmt->execute([$nama]);
            }
        }

        // Buat akun admin/user demo hanya jika belum ada.
        $passwordHash = password_hash('password', PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("INSERT OR IGNORE INTO users (nama,email,password,role) VALUES (?,?,?,?)");
        $stmt->execute(['Administrator', 'admin@gmail.com', $passwordHash, 'admin']);
        $stmt->execute(['User Demo', 'user@gmail.com', $passwordHash, 'user']);
    }

    public function query($sql)
    {
        $stmt = $this->pdo->query($sql);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return new DBResult($rows);
    }

    public function prepare($sql)
    {
        return new DBStatement($this->pdo, $sql);
    }

    public function close() {}
}

$dbFile = getenv("DB_FILE") ?: (__DIR__ . "/../database/hoaks_bengkulu.sqlite");
$conn = new Database($dbFile);
?>
