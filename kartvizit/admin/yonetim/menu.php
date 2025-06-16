<?php

$files = [
    'banka_duzenle.php',
    'banka_ekle.php',
    'banka_hesaplari.php',
    'banka_sil.php',
    'bilgilerim.php',
    'girisbilgilerim.php',
    'index.php',
    'kart_duzenle.php',
    'kart_ekle.php',
    'kart_sil.php',
    'kartlar.php',
    'qr_kodlar.php',
    'qr_olustur.php'
];

$qrMenu = <<<HTML
<li class="menu-header small text-uppercase">
    <span class="menu-header-text">QR Kodlar</span>
</li>
<li class="menu-item">
    <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-qr"></i>
        <div data-i18n="QR Kodlar">QR Kodlar</div>
    </a>
    <ul class="menu-sub">
        <li class="menu-item">
            <a href="qr_olustur.php" class="menu-link">
                <div data-i18n="QR Oluştur">QR Oluştur</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="qr_kodlar.php" class="menu-link">
                <div data-i18n="Tüm QR'lar">Tüm QR'lar</div>
            </a>
        </li>
    </ul>
</li>
HTML;

foreach ($files as $file) {
    // Dosya içeriğini oku
    $content = file_get_contents($file);

    // Banka Hesapları menüsünün sonunu bul
    $search = '<span class="menu-header-text">Banka Hesapları</span>';
    $position = strpos($content, $search);
    
    if ($position !== false) {
        // Banka Hesapları menüsünün sonunu bul
        $menuEnd = '</ul>';
        $menuEndPos = strpos($content, $menuEnd, $position);
        if ($menuEndPos !== false) {
            // QR Kod menüsünü Banka Hesapları menüsünün sonuna ekle
            $newContent = substr($content, 0, $menuEndPos + strlen($menuEnd)) . "\n" . $qrMenu . "\n" . substr($content, $menuEndPos + strlen($menuEnd));

            // Dosyaya yeni içeriği yaz
            file_put_contents($file, $newContent);
        }
    }
}

echo "QR Kod menüleri başarıyla eklendi.";

?>
