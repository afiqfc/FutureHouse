<!doctype html>
<html lang="zxx">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Keranjang - FutureHouse </title>
  <link rel="icon" href="img/favicon.png">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <!-- animate CSS -->
  <link rel="stylesheet" href="css/animate.css">
  <!-- owl carousel CSS -->
  <link rel="stylesheet" href="css/owl.carousel.min.css">
  <!-- nice select CSS -->
  <link rel="stylesheet" href="css/nice-select.css">
  <!-- font awesome CSS -->
  <link rel="stylesheet" href="css/all.css">
  <!-- flaticon CSS -->
  <link rel="stylesheet" href="css/flaticon.css">
  <link rel="stylesheet" href="css/themify-icons.css">
  <!-- font awesome CSS -->
  <link rel="stylesheet" href="css/magnific-popup.css">
  <!-- swiper CSS -->
  <link rel="stylesheet" href="css/slick.css">
  <link rel="stylesheet" href="css/price_rangs.css">
  <!-- style CSS -->
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <!--::header part start::-->
    <header class="main_menu home_menu">
      <div class="container">
          <div class="row align-items-center">
              <div class="col-lg-12">
                  <nav class="navbar navbar-expand-lg navbar-light">
                      <a class="navbar-brand" href="beranda.php"> <h2>FutureHouse</h2> </a>
                      <button class="navbar-toggler" type="button" data-toggle="collapse"
                          data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                          aria-expanded="false" aria-label="Toggle navigation">
                          <span class="menu_icon"><i class="fas fa-bars"></i></span>
                      </button>

                      <div class="collapse navbar-collapse main-menu-item" id="navbarSupportedContent">
                          <ul class="navbar-nav">
                              <li class="nav-item">
                                  <a class="nav-link" href="beranda.php">Beranda</a>
                              </li>
                              <li class="navbar-nav">
                                  <a class="nav-link" href="belanja.php">
                                      Belanja
                                  </a>
                                  <div class="dropdown-menu" aria-labelledby="navbarDropdown_2">
                                  </div>
                              </li>

                              <li class="nav-item">
                                  <a class="nav-link" href="contact.php">Hubungi Kami</a>
                              </li>
                          </ul>
                      </div>
                      <?php session_start(); ?>
                        <?php if (isset($_SESSION['username'])) : ?>
                        <div class="header_icon d-flex">
                            <!-- cart link -->
                             <?php
                             include 'admin/koneksi.php';

                             $user_id = $_SESSION['id_user'] ?? null;

                             if ($user_id) {
                                $query = "SELECT COUNT(*) as total FROM tb_pesanan WHERE id_user = '$user_id'";
                                $result = mysqli_query($koneksi, $query);
                                $data = mysqli_fetch_assoc($result);
                                $jumlah_item = $data['total'] ?? 0;
                                } else {
                                    $jumlah_item = 0;
                             }
                             ?>

                             <!-- user dropdown -->
                            <div class="dropdown user">
                                <a class="dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-user"></i>
                                    <span class="ml-2 text-dark"><?= htmlspecialchars($_SESSION['username']); ?></span> <!-- mennampilkan username dari session -->
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                                    <a class="dropdown-item" href="logout.php">Logout</a>
                                </div>
                                <!-- <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <div class="single_product">
    
                                    </div>
                                </div> -->

                            </div>
                        </div>

                        <?php else : ?>
                            <a href="login.php" class="btn"><b>Login</b></a>
                        <?php endif; ?>
                  </nav>
              </div>
          </div>
      </div>
  </header>
<!--::END header part start::-->


  <!--================Home Banner Area =================-->
  <!-- breadcrumb start-->
  <section class="breadcrumb breadcrumb_bg">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="breadcrumb_iner">
            <div class="breadcrumb_iner_item">
              <h2>Keranjang</h2>
              <p>Beranda <span>-</span>Keranjang </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- breadcrumb start-->

 <!--================Cart Area =================-->
 <section class="cart_area padding_top">
        <div class="container">
            <div class="cart_inner">
                <div class="table-responsive">
                    <?php
                    include 'admin/koneksi.php'; //pastikan koneksi ke database sudah benar

                    if (isset($_SESSION['id'])) {
                        echo "<script>alert('Silahkan login terlebih dahulu!'); window.location='login.php';</script>";
                        exit;
                    }

                    $id_user = $_SESSION['id_user'];// Ambil user id dari sesi
                    $query = "SELECT p.id_pesanan, pr.nm_produk, pr.harga, p.qty, (pr.harga * p.qty) AS total, pr.gambar
                              FROM tb_pesanan p
                              JOIN tb_produk pr ON p.id_produk = pr.id_produk
                              JOIN tb_user u ON p.id_user = u.id_user
                              WHERE p.id_user = '$id_user'";

                    $result = mysqli_query($koneksi, $query);

                    if (!$result) {
                        die("Query Error: " . mysqli_error($koneksi));
                    }

                    //inisialisasi
                    $subtotal = 0;
                    $diskon = 0;
                    $total_bayar = 0;

                    ?>

                    <form action="update_cart.php" method="POST">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="width: 40%;">Produk</th>
                                    <th style="width: 20%;">Harga</th>
                                    <th style="width: 20%;">Jumlah</th>
                                    <th style="width: 15%;">Total</th>
                                    <th style="width: 5%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $subtotal = 0;
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $subtotal += $row['total'];
                                ?>
                                    <tr>
                                        <td>
                                            <div class="media d-flex align-items-center">
                                                <img src="admin/produk_img/<?php echo $row['gambar']; ?>" 
                                                alt="" width="80px" class="me-3" />
                                                <p class="mb-0 p-3"></p><?php echo $row['nm_produk']; ?></p>
                                                </div>
                                        </td>
                                        <td>
                                            <h5>Rp.<?php echo number_format($row['harga'], 0, ',', '.'); ?></h5>
                                        </td>
                                        <td>
                                            <div class="product_count">
                                                <span class="input-number-decrement"><i class="ti-angle-down"></i></span>
                                                <input class="input-number" type="number" name="qty[<?php echo $row['id_pesanan']; ?>]" value="<?php echo $row['qty']; ?>" min="1">
                                                <span class="input-number-increment"><i class="ti-angle-up"></i></span>
                                            </div>
                                        </td>
                                        <td>
                                            <h5>Rp.<?php echo number_format($row['total'], 0, ',', '.'); ?></h5>
                                        </td>
                                        <td>
                                            <a href="hapus_cart.php?id_pesanan=<?php echo $row['id_pesanan']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus item ini?'); ">
                                                <i class="ti-close"></i>
                                            </a>
                                        </td>

                                    </tr>
                                <?php } ?>

                                <!-- Diskon -->
                                 <?php
                                $diskon = 0;
                                if ($subtotal > 700000 && $subtotal <= 1500000) {
                                    $diskon = 0.05;  $subtotal;
                                } elseif ($subtotal > 1500000) {
                                    $diskon = 0.08 * $subtotal;
                                }
                                $total_bayar = $subtotal - $diskon;
                                ?>

                                <tr class="bottom_button">
                                    <td colspan="5">
                                        <button type="submit" class="btn_1">Update Cart</button>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="3"></td>
                                    <td>
                                        <h5>Subtotal</h5>
                                    </td>
                                    <td style="text-align: right;">
                                        <h5 style="white-space: nowrap;">Rp. <?php echo number_format($subtotal, 0, ',', '.'); ?></h5>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3"></td>
                                    <td>
                                        <h5>Diskon</h5>
                                    </td>
                                    <td style="text-align: right;">
                                        <h5 style="display: flex; justify-content: flex-start; gap: 5px;">Rp. <?php echo number_format($diskon, 0, ',', '.'); ?></h5>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3"></td>
                                    <td>
                                        <h5>Total Bayar</h5>
                                    </td>
                                    <td style="text-align: right;">
                                        <h5>Rp. <?php echo number_format($total_bayar, 0, ',', '.'); ?></h5>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </form>

                    <div class="checkout_btn_inner float-right">
                        <a class="btn_1" href="belanja.php">Lanjutkan Belanja</a>
                        <a class="btn_1 checkout_btn_1" id="checkoutBtn" href="#">Proses Pembayaran</a>
                    </div>
                </div>
            </div>
        <section>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                document.getElementById("checkoutBtn").addEventListener("click", function()
                {
                    fetch("checkout.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({})
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert("Checkout berhasil!");
                            window.location.href = "belanja.php"; // redirect ke halaman riwayat transaksi
                        } else {
                            alert("Checkout gagal: " + data.message);
                        }
                    })
                    .catch(error => console.error("Error:", error));
                });
            });
        </script>
        
    <!--================End Cart Area =================-->

  <!--::footer_part start::-->
  <footer class="footer_part">
    <div class="container">
      <div class="row justify-content-around">
        <div class="col-sm-6 col-lg-2">
      </div>

    </div>
    <div class="copyright_part">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="copyright_text">
                        <P><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | by FutureHouse<a href="https://instagram.com/afiqfc21" target="_blank"> OnlyTeamFc</a>
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></P>
                        </div>
          </div>
          <div class="col-lg-4">
            <div class="footer_icon social_icon">
              <ul class="list-unstyled">
                <li><a href="https://instagram.com/afiqfc21" target="_blank" class="single_social_icon"><i class="fab fa-instagram"></i></a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </footer>
  <!--::footer_part end::-->

  <!-- jquery plugins here-->
  <!-- jquery -->
  <script src="js/jquery-1.12.1.min.js"></script>
  <!-- popper js -->
  <script src="js/popper.min.js"></script>
  <!-- bootstrap js -->
  <script src="js/bootstrap.min.js"></script>
  <!-- easing js -->
  <script src="js/jquery.magnific-popup.js"></script>
  <!-- swiper js -->
  <script src="js/swiper.min.js"></script>
  <!-- swiper js -->
  <script src="js/masonry.pkgd.js"></script>
  <!-- particles js -->
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.nice-select.min.js"></script>
  <!-- slick js -->
  <script src="js/slick.min.js"></script>
  <script src="js/jquery.counterup.min.js"></script>
  <script src="js/waypoints.min.js"></script>
  <script src="js/contact.js"></script>
  <script src="js/jquery.ajaxchimp.min.js"></script>
  <script src="js/jquery.form.js"></script>
  <script src="js/jquery.validate.min.js"></script>
  <script src="js/mail-script.js"></script>
  <script src="js/stellar.js"></script>
  <script src="js/price_rangs.js"></script>
  <!-- custom js -->
  <script src="js/custom.js"></script>
</body>

</html>