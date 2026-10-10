<?php
session_start();

$forwardedProto = $_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '';
$scheme = ($forwardedProto === 'https' || (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')) ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost:8000';
define("BASE_URL", $scheme . "://" . $host);

require_once __DIR__ . "/database.php";
require_once __DIR__ . "/../includes/functions.php";
?>
