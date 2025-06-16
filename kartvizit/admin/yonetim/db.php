<?php

$host = "localhost"; // Sunucu adresi
$dbname = "haleyumu_kartvizit"; // Database adı
$username = "haleyumu_kartvizituser"; // Database kullanıcı adı
$password = "01adana01"; // Database şifre

try {

    $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    

    $db->exec("SET NAMES 'utf8'");
} catch(PDOException $e) {

    die("Veritabanı bağlantısı başarısız: " . $e->getMessage());
}
?>
