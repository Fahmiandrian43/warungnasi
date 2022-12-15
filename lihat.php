<?php
session_start();

// if (!isset($_SESSION["login"])) {
//     header("Location: login.php");
//     exit;
// }

require 'function.php';

$id = $_GET["id"];

$barang = query("SELECT * FROM barang WHERE id = $id")[0];

$katagori = query("SELECT * FROM katagori");

if (isset($_SESSION["login"])) {

    $idd = $_SESSION["id"];
    // $result = mysqli_query($conn, "SELECT * from keranjang inner join  barang on keranjang.idbarang = barang.id where keranjang.user = $idd");
    // $keranjang = mysqli_fetch_assoc($result);
    $keranjang = query("SELECT * from keranjang inner join  barang on keranjang.idbarang = barang.id where keranjang.user = $idd");
}

$result = mysqli_query($conn, "SELECT idbarang FROM keranjang WHERE idbarang = $id and user = $idd");


if (isset($_POST["submit"])) {
    if (!mysqli_fetch_assoc($result)) {
        if (keranjang($_POST) > 0) {
            echo "<script>
                alert('Anda menambahkan Barang!');
            </script>";
        } else {
            echo "<script>
                alert('Gagal menambahkan barang!');
            </script>";
        }
    } else {
        echo
        "<script>
            alert('barang sudah ada dikeranjang!');
        </script>
        ";
    }
}


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
            <a href="index.php" class="text-decoration-none">home</a>
            <!-- <a href="#features">features</a> -->
            <a href="index.php" class="text-decoration-none">products</a>
            <a href="index.php" class="text-decoration-none">categories</a>
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
                    <a href="beli.php?id=<?= $cart["idkeranjang"] ?>" class="btn">checkout</a>
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

    <!-- product -->

    <section class="product">
        <div class="container">
            <div class="row">
                <div class="col align-self-center">
                    <div class="card mb-3">
                        <img src="admin/img/<?= $barang["gambar"] ?>" class="card-img-top" alt="<?= $barang["gambar"] ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= $barang["nama"] ?></h5>
                            <p class="card-text"><?= $barang["nama"] ?></p>
                            <?php if (isset($_SESSION["login"])) { ?>
                                <form action="" method="post">
                                    <input type="hidden" name="idkeranjang" value="">
                                    <input type="hidden" name="idbarang" value="<?= $barang["id"] ?>">
                                    <input type="hidden" name="image" value="<?= $barang["gambar"] ?>">
                                    <input type="hidden" name="nama" value="<?= $barang["nama"] ?>">
                                    <input type="hidden" name="user" value="<?= $_SESSION['id'] ?>">
                                    <button type="submit" name="submit" class="btn btn-outline-primary">Keranjang</button>
                                </form>
                                <a href="beli.php" type="button" class="btn btn-outline-primary">Beli</a>
                            <?php } ?>
                        </div>
                    </div>


                </div>
            </div>
        </div>
        </div>
    </section>

    <!-- product -->


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