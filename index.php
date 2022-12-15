<?php
session_start();

// if (!isset($_SESSION["login"])) {
//     header("Location: login.php");
//     exit;
// }

require 'function.php';

$barang = query("SELECT * FROM barang");

$katagori = query("SELECT * FROM katagori");
if (isset($_SESSION["login"])) {

    $id = $_SESSION["id"];

    $keranjang = query("SELECT * from keranjang inner join  barang on keranjang.idbarang = barang.id where keranjang.user = $id and status='cart'");
}

$result = mysqli_query($conn, "SELECT * from keranjang inner join  barang on keranjang.idbarang = barang.id where keranjang.user = $id");

$keranjang1 = mysqli_fetch_array($result);
// var_dump(count($keranjang1["user"]));
// exit;
// $cart1 = query("SELECT * FROM keranjang");


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warung Nasi Uduk</title>

    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">

    <!-- custom bootstrap file link -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

</head>

<body>

    <!-- header section starts  -->

    <header class="header">

        <a href="#" class="logo text-decoration-none"> <i class="fas fa-shopping-basket"></i> Nasi Uduk </a>

        <nav class="navbar">
            <a href="#home" class="text-decoration-none">home</a>
            <!-- <a href="#features">features</a> -->
            <a href="#products" class="text-decoration-none">products</a>
            <a href="#categories" class="text-decoration-none">categories</a>
            <!-- <a href="#review">review</a> -->
            <!-- <a href="#blogs">blogs</a> -->
        </nav>

        <div class="icons">
            <div class="fas fa-bars" id="menu-btn"></div>
            <div class="fas fa-search" id="search-btn"></div>
            <div class="fas fa-shopping-cart" id="cart-btn"></div>
            <div class="fas fa-user" id="login-btn"></div>
        </div>

        <form action="" class="search-form">
            <input type="search" id="search-box" placeholder="search here...">
            <label for="search-box" class="fas fa-search"></label>
        </form>

        <div class="shopping-cart">
            <?php if (isset($_SESSION["login"])) { ?>
                <?php foreach ($keranjang as $cart) : ?>
                    <div class="box">
                        <a href="hapus.php?id=<?= $cart["idkeranjang"] ?>" class="fas fa-trash"></a>
                        <img src="admin/img/<?= $cart["imagekeranjang"] ?>" alt="<?= $cart["imagekeranjang"] ?>">
                        <div class="content">
                            <h3><?= $cart["namakeranjang"] ?></h3>
                            <span class="price">Rp. <?= $cart["harga"] ?></span>
                        </div>
                    </div>
                    <?php  ?>
                    <a href="beli.php" class="btn">checkout</a>
                <?php endforeach; ?>
            <?php } else { ?>
                <p>Tidak Ada Keranjang Silahkan login</p>
            <?php } ?>
        </div>

        <div class="login-form">
            <ul class="list-group">
                <?php if (!isset($_SESSION["login"])) { ?>
                    <li class="list-group-item"><a href="register.php">Registrasi</a></li>
                    <li class="list-group-item"><a href="login.php">Login</a></li>

                    <?php } else {
                    if ($_SESSION['status'] > 0) { ?>
                        <li class="list-group-item">Hallo, <?= $_SESSION['nama'] ?></li>
                        <li class="list-group-item"><a href="admin">admin</a></li>
                        <li class="list-group-item"><a href="logout.php">Logout</a></li>

                    <?php } else { ?>
                        <li class="list-group-item"> Hallo, <?= $_SESSION['nama'] ?></li>
                        <li class="list-group-item"><a href="logout.php">Logout</a></li>
                    <?php } ?>
                <?php } ?>
            </ul>

        </div>


    </header>

    <!-- header section ends -->

    <!-- home section starts  -->

    <section class="home" id="home">

        <div class="content">
            <h3>Nasi Uduk products for your</h3>
            <a href="#" class="btn">shop now</a>
        </div>

    </section>

    <!-- home section ends -->

    <!-- features section starts  -->

    <!-- <section class="features" id="features">

        <h1 class="heading"> our <span>features</span> </h1>

        <div class="box-container">

            <div class="box">
                <img src="image/feature-img-1.png" alt="">
                <h3>fresh and organic</h3>
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Deserunt, earum!</p>
                <a href="#" class="btn">read more</a>
            </div>

            <div class="box">
                <img src="image/feature-img-2.png" alt="">
                <h3>free delivery</h3>
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Deserunt, earum!</p>
                <a href="#" class="btn">read more</a>
            </div>

            <div class="box">
                <img src="image/feature-img-3.png" alt="">
                <h3>easy payments</h3>
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Deserunt, earum!</p>
                <a href="#" class="btn">read more</a>
            </div>

        </div>

    </section> -->

    <!-- features section ends -->

    <!-- products section starts  -->

    <section class="products" id="products">

        <h1 class="heading"> our <span>products</span> </h1>

        <div class="swiper product-slider">

            <div class="swiper-wrapper">

                <?php foreach ($barang as $row) : ?>
                    <div class="swiper-slide box">
                        <img src="admin/img/<?= $row["gambar"] ?>" alt="<?= $row["gambar"] ?>">
                        <h3><?= $row["nama"] ?></h3>
                        <div class="price"><?= $row["harga"] ?></div>
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                        <a href="lihat.php?id=<?= $row["id"] ?>" class="btn text-decoration-none">Order</a>
                    </div>
                <?php endforeach; ?>

            </div>

        </div>


    </section>

    <!-- products section ends -->

    <!-- categories section starts  -->

    <section class="categories" id="categories">

        <h1 class="heading"> product <span>categories</span> </h1>

        <div class="box-container">

            <?php foreach ($katagori as $row) : ?>
                <div class="box">
                    <img src="https://source.unsplash.com/500x400?<?= $row["nama"] ?>" alt="<?= $row["nama"] ?>">
                    <h3><?= $row["nama"] ?></h3>
                    <a href="katagori.php?id=" class="btn">shop now</a>
                </div>
            <?php endforeach; ?>

        </div>

    </section>

    <!-- categories section ends -->

    <!-- review section starts  -->

    <!-- <section class="review" id="review">

        <h1 class="heading"> customer's <span>review</span> </h1>

        <div class="swiper review-slider">

            <div class="swiper-wrapper">

                <div class="swiper-slide box">
                    <img src="image/pic-1.png" alt="">
                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Unde sunt fugiat dolore ipsum id est maxime ad tempore quasi tenetur.</p>
                    <h3>john deo</h3>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>

                <div class="swiper-slide box">
                    <img src="image/pic-2.png" alt="">
                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Unde sunt fugiat dolore ipsum id est maxime ad tempore quasi tenetur.</p>
                    <h3>john deo</h3>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>

                <div class="swiper-slide box">
                    <img src="image/pic-3.png" alt="">
                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Unde sunt fugiat dolore ipsum id est maxime ad tempore quasi tenetur.</p>
                    <h3>john deo</h3>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>

                <div class="swiper-slide box">
                    <img src="image/pic-4.png" alt="">
                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Unde sunt fugiat dolore ipsum id est maxime ad tempore quasi tenetur.</p>
                    <h3>john deo</h3>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>

            </div>

        </div>

    </section> -->

    <!-- review section ends -->

    <!-- footer section starts  -->

    <section class="footer">

        <div class="box-container">

            <div class="box">
                <h3> Nasi Uduk <i class="fas fa-shopping-basket"></i> </h3>
                <p>Nasi uduk adalah hidangan yang dibuat dari nasi putih yang diaron dan dikukus dengan santan, serta dibumbui dengan pala, kayu manis, jahe, daun serai dan merica. Hidangan ini kini adalah salah satu Hidangan Betawi yang populer>
                <div class="share">
                    <a href="#" class="fab fa-facebook-f"></a>
                    <a href="#" class="fab fa-twitter"></a>
                    <a href="#" class="fab fa-instagram"></a>
                    <a href="#" class="fab fa-linkedin"></a>
                </div>
            </div>

            <div class="box">
                <h3>contact info</h3>
                <a href="wa.me/6282122138825" class="links text-decoration-none"> <i class="fas fa-phone"></i> WhatsApp </a>
                <a href="#" class="links text-decoration-none"> <i class="fas fa-envelope "></i> Email </a>
                <a href="https://maps.app.goo.gl/oSqVoBv4rrYxRvtTA" class="links text-decoration-none"> <i class="fas fa-map-marker-alt"></i> Lokasi </a>
            </div>

            <div class="box">
                <h3>newsletter</h3>
                <p>subscribe for latest updates</p>
                <input type="email" placeholder="your email" class="email">
                <input type="submit" value="subscribe" class="btn">
                <img src="image/payment.png" class="payment-img" alt="">
            </div>

        </div>

        <div class="credit"> created by <span> Warung Nasi Uduk </span> | all rights reserved </div>

    </section>

    <!-- footer section ends -->

    <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>

    <!-- custom js file link  -->
    <script src="js/script.js"></script>

</body>

</html>