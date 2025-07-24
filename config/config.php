<?php
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = 'Nuxt@it2025';
$dbname = 'php_lms';

try {
    $pdo = new PDO("mysql:host={$dbhost};dbname={$dbname}", $dbuser, $dbpass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

/* Base URL */
define("BASE_URL", "http://localhost:8000/");
define("ADMIN_URL", BASE_URL . "admin/");
define("APP_NAME", "Leaning Management System");

/* SMTP Configuration */
define("SMTP_HOST", "sandbox.smtp.mailtrap.io");
define("SMTP_PORT", "587");
define("SMTP_USERNAME", "f8ddae3483ea0b");
define("SMTP_PASSWORD", "975d4f12136959");
define("SMTP_ENCRYPTION", "tls");
define("SMTP_FROM", "contact@lms.com");