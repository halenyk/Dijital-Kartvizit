<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: giris.php');
    exit();
}

require_once 'db.php';

$banka_id = isset($_GET['id']) ? intval($_GET['id']) : null;

if ($banka_id === null) {
    die("Geçersiz banka ID'si.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm']) && $_POST['confirm'] === 'yes') {
    try {
        $stmt = $db->prepare("DELETE FROM banka_hesaplari WHERE banka_id = ?");
        $stmt->execute([$banka_id]);
        header('Location: banka_hesaplari.php?message=success');
        exit();
    } catch (PDOException $e) {
        die("Silme işlemi başarısız: " . $e->getMessage());
    }
}

try {
    $stmt = $db->prepare("SELECT banka_ad FROM banka_hesaplari WHERE banka_id = ?");
    $stmt->execute([$banka_id]);
    $banka = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$banka) {
        die("Banka hesabı bulunamadı.");
    }

    $stmt_user = $db->prepare("SELECT isim, meslek, profil_resmi FROM kullanicilar WHERE id = ?");
    $stmt_user->execute([$_SESSION['user_id']]);
    $kullanici = $stmt_user->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Veri çekme başarısız: " . $e->getMessage());
}
?>


<!DOCTYPE html>
<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>Digi - Yönetim Paneli</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="../assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="../assets/js/config.js"></script>
  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->

        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          <div class="app-brand demo">
            <a href="index.html" class="app-brand-link">
              <span class="app-brand-logo demo">
                
              </span>
              <span class="app-brand-text demo menu-text fw-bolder ms-2">digi</span>
            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
              <i class="bx bx-chevron-left bx-sm align-middle"></i>
            </a>
          </div>

          <div class="menu-inner-shadow"></div>

          <ul class="menu-inner py-1">
            <!-- Dashboard -->
<ul class="sidebar-menu">
    <li class="menu-item">
        <a href="index.php" class="menu-link">
            <i class="menu-icon tf-icons bx bx-home-circle"></i>
            <div data-i18n="Dashboard">Ana Sayfa</div>
        </a>
    </li>
    
    <li class="menu-header small text-uppercase">
        <span class="menu-header-text">Kartlar</span>
    </li>
    <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-card"></i>
            <div data-i18n="Kartlar">Kartlar</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item">
                <a href="kart_ekle.php" class="menu-link">
                    <div data-i18n="Kart Ekle">Kart Ekle</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="kartlar.php" class="menu-link">
                    <div data-i18n="Tüm Kartlar">Tüm Kartlar</div>
                </a>
            </li>
        </ul>
    </li>
    
    <li class="menu-header small text-uppercase">
        <span class="menu-header-text">Banka Hesapları</span>
    </li>
    <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-wallet"></i>
            <div data-i18n="Banka Hesapları">Banka Hesapları</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item">
                <a href="banka_ekle.php" class="menu-link">
                    <div data-i18n="Banka Ekle">Banka Ekle</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="banka_hesaplari.php" class="menu-link">
                    <div data-i18n="Tüm Banka Hesapları">Tüm Banka Hesapları</div>
                </a>
            </li>
        </ul>
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



    </li>
    
    <li class="menu-header small text-uppercase">
        <span class="menu-header-text">Kullanıcı Bilgileri</span>
    </li>
    <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-user"></i>
            <div data-i18n="Kullanıcı Bilgileri">Kullanıcı Bilgileri</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item">
                <a href="bilgilerim.php" class="menu-link">
                    <div data-i18n="Bilgilerim">Bilgilerim</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="girisbilgilerim.php" class="menu-link">
                    <div data-i18n="Giriş Bilgilerim">Giriş Bilgilerim</div>
                </a>
            </li>
        </ul>
    </li>
    
    <li class="menu-header small text-uppercase">
        <span class="menu-header-text">Ayarlar</span>
    </li>
    <li class="menu-item">
        <a href="ayarlar.php" class="menu-link">
            <i class="menu-icon tf-icons bx bx-cog"></i>
            <div data-i18n="Ayarlar">Ayarlar</div>
              </a>
            </li>
          </ul>
        </aside>
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->

          <nav
            class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
            id="layout-navbar"
          >
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
              </a>
            </div>

            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
              <!-- Search -->
              
              <!-- /Search -->

              <ul class="navbar-nav flex-row align-items-center ms-auto">
                <!-- Place this tag where you want the button to render. -->
                <li class="nav-item lh-1 me-3">
              
                  
                </li>

                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
        <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
            <div class="avatar avatar-online">
                <img src="<?php echo htmlspecialchars($kullanici['profil_resmi']); ?>" alt class="w-px-40 h-auto rounded-circle" />
            </div>
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
            <li>
                <a class="dropdown-item" href="#">
                    <div class="d-flex">
                        <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-online">
                                <img src="<?php echo htmlspecialchars($kullanici['profil_resmi']); ?>" alt class="w-px-40 h-auto rounded-circle" />
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <span class="fw-semibold d-block"><?php echo htmlspecialchars($kullanici['isim']); ?></span>
                            <small class="text-muted"><?php echo htmlspecialchars($kullanici['meslek']); ?></small>
                        </div>
                    </div>
                </a>
            </li>
            <li>
                <div class="dropdown-divider"></div>
            </li>
            <li>
                <a class="dropdown-item" href="bilgilerim.php">
                    <i class="bx bx-user me-2"></i>
                    <span class="align-middle">Profilim</span>
                </a>
            </li>
            <li>
                <a class="dropdown-item" href="ayarlar.php">
                    <i class="bx bx-cog me-2"></i>
                    <span class="align-middle">Ayarlar</span>
                </a>
            </li>
            <li>
                <div class="dropdown-divider"></div>
            </li>
            <li>
                <a class="dropdown-item" href="cikis.php">
                    <i class="bx bx-power-off me-2"></i>
                    <span class="align-middle">Çıkış Yap</span>
                      </a>
                    </li>
                  </ul>
                </li>
                <!--/ User -->
              </ul>
            </div>
          </nav>

          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->
 <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Banka Hesapları /</span> Banka Hesabı Sil</h4>
        <div class="row">
            <div class="col-md">
                <div class="card mb-4">
                    <h5 class="card-header">Banka Hesabı Sil</h5>
                    <div class="card-body">
                        <p><?php echo htmlspecialchars($banka['banka_ad']); ?> adlı banka hesabını silmek istediğinizden emin misiniz?</p>
                        <form action="banka_sil.php?id=<?php echo $banka_id; ?>" method="POST">
                            <input type="hidden" name="confirm" value="yes">
                            <button type="submit" class="btn btn-danger">Evet, Sil</button>
                            <a href="banka_hesaplari.php" class="btn btn-secondary">İptal</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
                   
                    <!-- /Account -->
                  
            <!-- / Content -->

            <!-- Footer -->
            

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../assets/vendor/libs/popper/popper.js"></script>
    <script src="../assets/vendor/js/bootstrap.js"></script>
    <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="../assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="../assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="../assets/js/pages-account-settings-account.js"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
  </body>
</html>
