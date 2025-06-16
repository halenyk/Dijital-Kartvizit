<?php
require_once 'admin/yonetim/db.php';

try {
    $stmt = $db->prepare("SELECT site_basligi, site_favicon FROM ayar WHERE id = 1");
    $stmt->execute();
    $ayar = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Veri çekme başarısız: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="tr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <title><?php echo htmlspecialchars($ayar['site_basligi']); ?></title>

  <!-- favicon -->
  <link rel="shortcut icon" href="<?php echo htmlspecialchars($ayar['site_favicon']); ?>" type="image/x-icon">

  <!--
    - custom css link
  -->
  <link rel="stylesheet" href="./assets/css/style.css">

  <!--
    - google font link
  -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>

<body>

  <!--
    - #MAIN
  -->

  <main>

    <!--
      - #SIDEBAR
    -->

   <?php
include 'admin/yonetim/db.php';

try {
    // Kullanıcı verilerini çekmek için SQL sorgusu
    $stmt = $db->prepare("SELECT isim, meslek, eposta, telefon, konum, profil_resmi, aciklama FROM kullanicilar WHERE id = 1");
    $stmt->execute();
    $kullanici = $stmt->fetch(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Veri çekme başarısız: " . $e->getMessage());
}
?>
<?php
require_once 'admin/yonetim/db.php';

try {
    $stmt_kartlar = $db->prepare("SELECT kart_baslik, kart_icerik, kart_link, kart_resim FROM kartlar1");
    $stmt_kartlar->execute();
    $kartlar = $stmt_kartlar->fetchAll(PDO::FETCH_ASSOC);

    $stmt_banka = $db->prepare("SELECT banka_ad, banka_logo, iban, iban_kisi FROM banka_hesaplari");
    $stmt_banka->execute();
    $banka_hesaplari = $stmt_banka->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Veri çekme başarısız: " . $e->getMessage());
}
?>

<aside class="sidebar" data-sidebar>

      <div class="sidebar-info">

        <figure class="avatar-box">
          <img src="<?php echo htmlspecialchars($kullanici['profil_resmi']); ?>" alt="<?php echo htmlspecialchars($kullanici['isim']); ?>" width="80">
        </figure>

        <div class="info-content">
          <h1 class="name" title="<?php echo htmlspecialchars($kullanici['isim']); ?>"><?php echo htmlspecialchars($kullanici['isim']); ?></h1>

          <p class="title"><?php echo htmlspecialchars($kullanici['meslek']); ?></p>
        </div>

        <button class="info_more-btn" data-sidebar-btn>
          <span>İletişim Bilgileri</span>

          <ion-icon name="chevron-down"></ion-icon>
        </button>

      </div>

      <div class="sidebar-info_more">

        <div class="separator"></div>

        <ul class="contacts-list">

          <li class="contact-item">

            <div class="icon-box">
              <ion-icon name="mail-outline"></ion-icon>
            </div>

            <div class="contact-info">
              <p class="contact-title">E-Posta</p>

              <a href="mailto:<?php echo htmlspecialchars($kullanici['eposta']); ?>" class="contact-link"><?php echo htmlspecialchars($kullanici['eposta']); ?></a>
            </div>

          </li>

          <li class="contact-item">

            <div class="icon-box">
              <ion-icon name="phone-portrait-outline"></ion-icon>
            </div>

            <div class="contact-info">
              <p class="contact-title">Telefon</p>

              <a href="tel:+<?php echo htmlspecialchars($kullanici['telefon']); ?>" class="contact-link"><?php echo htmlspecialchars($kullanici['telefon']); ?></a>
            </div>

          </li>

          <li class="contact-item">

            <div class="icon-box">
              <ion-icon name="location-outline"></ion-icon>
            </div>

            <div class="contact-info">
              <p class="contact-title">Konum</p>

              <address><?php echo htmlspecialchars($kullanici['konum']); ?></address>
            </div>

          </li>

        </ul>

        <div class="separator"></div>

        <ul class="social-list">

          

        </ul>

      </div>

</aside>






    <!--
      - #main-content
    -->

    <div class="main-content">

      <!--
        - #NAVBAR
      -->

      <nav class="navbar">

        
      </nav>





      <!--
        - #ABOUT
      -->

      <article class="about active" data-page="about">
    <header>
        <h2 class="h2 article-title">Hakkımda</h2>
    </header>

    <section class="about-text">
        <p>
            <?php echo nl2br(htmlspecialchars($kullanici['aciklama'])); ?>
        </p>
    </section>


        <!--
          - service
        -->

        <section class="service">
    <ul class="service-list">
        <?php foreach ($kartlar as $kart): ?>
            <li class="service-item">
                <div class="service-icon-box">
                    <img src="<?php echo htmlspecialchars($kart['kart_resim']); ?>" alt="Web development icon" width="40">
                </div>
                <div class="service-content-box">
                    <h4 class="h4 service-item-title"><?php echo htmlspecialchars($kart['kart_baslik']); ?></h4>
                    <p class="service-item-text">
                        <a href="<?php echo htmlspecialchars($kart['kart_link']); ?>" target="_blank" style="text-decoration: none; color: inherit;">
                            <?php echo htmlspecialchars($kart['kart_icerik']); ?>
                        </a>
                    </p>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</section>

<!-- Testimonials Section -->
<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        alert("İBAN kopyalandı: " + text);
    }, function(err) {
        console.error("Kopyalama işlemi başarısız oldu: ", err);
    });
}
</script>

<section class="testimonials">
    <h3 class="h3 testimonials-title">Banka Hesaplarım</h3>
    <ul class="testimonials-list has-scrollbar">
        <?php foreach ($banka_hesaplari as $banka): ?>
            <li class="testimonials-item">
                <div class="content-card" data-testimonials-item>
                    <figure class="testimonials-avatar-box">
                        <img src="<?php echo htmlspecialchars($banka['banka_logo']); ?>" alt="<?php echo htmlspecialchars($banka['banka_ad']); ?>" width="60" data-testimonials-avatar>
                    </figure>
                    <h4 class="h4 testimonials-item-title" data-testimonials-title><?php echo htmlspecialchars($banka['banka_ad']); ?></h4>
                    <div class="testimonials-text" data-testimonials-text>
                        <p><?php echo htmlspecialchars($banka['iban']); ?></p>
                        <p class="account-holder-name"><?php echo htmlspecialchars($banka['iban_kisi']); ?></p>
                        <button class="copy-btn" onclick="copyToClipboard('<?php echo htmlspecialchars($banka['iban']); ?>')">
                            <i class="fa-solid fa-copy fa-2x" style="color: #325185;"></i>
                        </button>
                    </div>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</section>



   






  <!--
    - custom js link
  -->
  <script src="./assets/js/script.js"></script>

  <!--
    - ionicon link
  -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>

</html>
