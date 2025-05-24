<!doctype html>
<html lang="zxx">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Belanja - FutureHouse</title>
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

    <style>
        .single_product_item {
            text-align: center;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background: #fff;
        }

        .product_img_wrapper {
            width: 100%;
            height: 200px;
            /* Sesuaikan tinggi gambar */
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        .product_img_wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            /* Crop gambar agar tetap proporsional */
            border-radius: 10px;
        }

        .cart-badge {
            position: absolute;
            top: -5px;
            right: -8px;
            background: #f72a74;
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 10px;
            font-weight: bold;
            line-height: 1;
            min-width: 16px;
            text-align: center;
            z-index: 10;
        }
    </style>

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

                             <a href="cart.php" id="cartlink" style="position: relative; display: inline-block;">
                                <i class="fas fa-cart-plus" style="font-size: 16px;"></i>
                                <span class="cart-badge"><?= $jumlah_item ?></span>
                             </a>

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
                            <h2>Belanja</h2>
                            <p>Beranda <span>-</span> Belanja</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb start-->

   <!--================Category Product Area =================-->
    <section class="cat_product_area section_padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="left_sidebar_area">
                        <aside class="left_widgets p_filter_widgets">
                            <div class="l_w_title">
                                <h3>Kategori Produk</h3>
                            </div>
                            <?php
                            include 'admin/koneksi.php'; // Pastikan file koneksi ada

                            // Ambil kategori yang dipilih dari URL
                            $id_kategori = isset($_GET['id_kategori']) ? mysqli_real_escape_string($koneksi, $_GET['id_kategori']) : null;

                            // Ambil semua kategori beserta jumlah produknya
                            $query_kategori = "
    SELECT k.id_kategori, k.nm_kategori, COUNT(p.id_produk) AS jumlah_produk 
    FROM tb_kategori k
    LEFT JOIN tb_produk p ON k.id_kategori = p.id_kategori
    GROUP BY k.id_kategori
";
                            $result_kategori = mysqli_query($koneksi, $query_kategori);
                            ?>

                            <!-- Sidebar Kategori -->
                            <div class="widgets_inner">
                                <ul class="list">
                                    <li>
                                        <a href="?" <?php echo is_null($id_kategori) ? 'style="font-weight:bold;"' : ''; ?>>Semua Kategori</a>
                                    </li>
                                    <?php while ($row_kategori = mysqli_fetch_assoc($result_kategori)) { ?>
                                        <li>
                                            <a href="?id_kategori=<?php echo $row_kategori['id_kategori']; ?>" <?php echo ($id_kategori == $row_kategori['id_kategori']) ? 'style="font-weight:bold;"' : ''; ?>>
                                                <?php echo htmlspecialchars($row_kategori['nm_kategori']); ?>
                                            </a>
                                            <span>(<?php echo $row_kategori['jumlah_produk']; ?>)</span>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </aside>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="product_top_bar d-flex justify-content-between align-items-center">
                                <div class="single_product_menu d-flex">
                                    <form method="GET" action="">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="search" placeholder="Cari produk..." value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                                            <div class="input-group-prepend">
                                                <button type="submit" class="input-group-text"><i class="ti-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                    // Tentukan jumlah produk per halaman
                    $limit = 6;
                    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                    $start = ($page - 1) * $limit;

                    // Ambil kata kunci pencarian jika ada
                    $search = isset($_GET['search']) ? mysqli_real_escape_string($koneksi, $_GET['search']) : "";

                    // Query produk berdasarkan kategori & pencarian
                    $where_clause = "1=1"; // Default menampilkan semua produk
                    if (!empty($search)) {
                        $where_clause .= " AND nm_produk LIKE '%$search%'";
                    }
                    if (!empty($id_kategori)) {
                        $where_clause .= " AND id_kategori = '$id_kategori'"; // Perhatikan tanda kutip untuk string
                    }

                    // Query produk dengan filter kategori dan pencarian
                    $query_produk = "SELECT * FROM tb_produk WHERE $where_clause LIMIT $start, $limit";
                    $query_total = "SELECT COUNT(*) AS total FROM tb_produk WHERE $where_clause";

                    $result_produk = mysqli_query($koneksi, $query_produk);
                    $total_result = mysqli_query($koneksi, $query_total);
                    $total_row = mysqli_fetch_assoc($total_result);
                    $total_products = $total_row['total'];
                    $total_pages = ceil($total_products / $limit);
                    ?>

                    <!-- Produk List -->
                    <div class="row align-items-center latest_product_inner">
                        <?php while ($row_produk = mysqli_fetch_assoc($result_produk)) { ?>
                            <div class="col-lg-4 col-sm-6">
                                <div class="single_product_item">
                                    <div class="product_img_wrapper">
                                        <img src="admin/produk_img/<?php echo htmlspecialchars($row_produk['gambar']); ?>" alt="">
                                    </div>
                                    <div class="single_product_text">
                                        <h4><?php echo htmlspecialchars($row_produk['nm_produk']); ?></h4>
                                        <h3>Rp <?php echo number_format($row_produk['harga'], 0, ',', '.'); ?></h3>
                                        <a href="detail_produk.php?id=<?php echo $row_produk['id_produk']; ?>" class="add_cart">+ keranjang</a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>

                    <?php if (mysqli_num_rows($result_produk) == 0) { ?>
                        <div class="col-lg-12 text-center">
                            <p>Produk tidak ditemukan.</p>
                        </div>
                    <?php } ?>

                    <!-- Pagination -->
                    <?php if ($total_pages > 1) { ?>
                        <div class="col-lg-12">
                            <div class="pageination">
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination justify-content-center">
                                        <?php if ($page > 1) { ?>
                                            <li class="page-item">
                                                <a class="page-link" href="?id_kategori=<?php echo $id_kategori; ?>&search=<?php echo $search; ?>&page=<?php echo ($page - 1); ?>" aria-label="Previous">
                                                    <i class="ti-angle-double-left"></i>
                                                </a>
                                            </li>
                                        <?php } ?>

                                        <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                                            <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                                <a class="page-link" href="?id_kategori=<?php echo $id_kategori; ?>&search=<?php echo $search; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                            </li>
                                        <?php } ?>

                                        <?php if ($page < $total_pages) { ?>
                                            <li class="page-item">
                                                <a class="page-link" href="?id_kategori=<?php echo $id_kategori; ?>&search=<?php echo $search; ?>&page=<?php echo ($page + 1); ?>" aria-label="Next">
                                                    <i class="ti-angle-double-right"></i>
                                                </a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    <?php } ?>

                </div>
            </div>
        </div>
    </section>
    <!--================End Category Product Area =================-->

    <!--::footer_part start::-->
    <footer class="footer_part">
        </div>
        <div class="copyright_part">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="copyright_text">
                            <P><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | by FutureHouse <a href="https://www.instagram.com/afiqfc21/"target="blank"> OnlyTeamFc</a>
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
        </div>
    </footer>
    <!--::footer_part end::-->

    <!-- jquery plugins here-->
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