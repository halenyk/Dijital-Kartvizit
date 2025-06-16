<?php
include 'db.php'; // Veritabanı bağlantısı
include '../qr/qrlib.php'; // QR kod kütüphanesi

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['url'])) {
    $url = $_POST['url'];
    
    if (empty($url)) {
        $message = 'URL girilmedi!';
    } else {
        // Geçici ve QR dosya dizinleri
        $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'qrlars'.DIRECTORY_SEPARATOR;
        $PNG_WEB_DIR = 'qrlars/';

        // Geçici dizini oluştur
        if (!file_exists($PNG_TEMP_DIR) && !mkdir($PNG_TEMP_DIR, 0755, true)) {
            $message = 'QR kodları için geçici dizin oluşturulamadı!';
        } else {
            // Dosya adını oluştur
            $filename = $PNG_TEMP_DIR.md5($url).'.png';
            
            // QR kodunu oluştur ve dosyaya kaydet
            $errorCorrectionLevel = 'L';
            $matrixPointSize = 8; // QR kod boyutunu artırmak için değer yükseltildi
            QRcode::png($url, $filename, $errorCorrectionLevel, $matrixPointSize, 2);

            // Veritabanına kaydet
            $qr_resim = $PNG_WEB_DIR.basename($filename);
            try {
                $stmt = $db->prepare("INSERT INTO qr_kodlar (qr_resim) VALUES (:qr_resim)");
                $stmt->bindParam(':qr_resim', $qr_resim);
                $stmt->execute();
                $message = '<h1>QR Kodu Oluşturuldu</h1><img src="'.$qr_resim.'" /><p>QR kodu başarıyla oluşturuldu ve veritabanına kaydedildi.</p>';
            } catch (PDOException $e) {
                $message = 'Veritabanına kaydedilemedi: ' . $e->getMessage();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Kodu Oluştur</title>
</head>
<body>
    <h1>QR Kodu Oluştur</h1>
    <form action="qr.php" method="post">
        URL: <input type="text" name="url" required>
        <input type="submit" value="QR Kodu Oluştur">
    </form>
    <?php
    if (!empty($message)) {
        echo '<hr/>' . $message;
    }
    ?>
</body>
</html>
