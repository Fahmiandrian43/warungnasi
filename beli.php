<?php
session_start();

// if (!isset($_SESSION["login"])) {
//     header("Location: login.php");
//     exit;
// }

require 'function.php';



$query = "SELECT * FROM barang";
$result = mysqli_query($conn, $query);
$barang = mysqli_fetch_assoc($result);

$katagori = query("SELECT * FROM katagori");
if (isset($_SESSION["login"])) {

    $idd = $_SESSION["id"];
    // $result = mysqli_query($conn, "SELECT * from keranjang inner join  barang on keranjang.idbarang = barang.id where keranjang.user = $idd and status='cart'");
    // $keranjang = mysqli_fetch_assoc($result);
    $keranjang = query("SELECT * from keranjang inner join barang  on keranjang.idbarang = barang.id where keranjang.user = $idd and status='cart'");
}

if (isset($_POST["updatejml"])) {
    $id = $_POST["idkeranjang"];
    $qty = $_POST["qty"];

    mysqli_query($conn, "UPDATE keranjang SET jumlahkeranjang = $qty WHERE idkeranjang = $id");

    return header("Location:beli.php");
}

// $caricart = mysqli_query($conn, "select * from keranjang where user='$id' and status='Cart'");
// $fetc = mysqli_fetch_array($caricart);
// $idd = $fetc['idkeranjang'];

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



    <!-- products section starts  -->

    <div class="container-md mt-5">
        <div class="row">
            <div class="col-md-12 align-items-center">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Gambar</th>
                            <th>Nama</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        $subtotal = 0;
                        foreach ($keranjang as $row) : ?>
                            <tr>
                                <td>
                                    <h3><?= $i ?></h3>
                                </td>
                                <td>
                                    <h3><img src="admin/img/<?= $row["imagekeranjang"] ?>" alt="<?= $row["imagekeranjang"] ?>" width="100"></h3>
                                </td>
                                <td>
                                    <h3><?= $row["namakeranjang"] ?></h3>
                                </td>
                                <td>
                                    <h3>
                                        <form action="" method="post">
                                            <input type="hidden" name="idkeranjang" value="<?= $row["idkeranjang"] ?>">
                                            <input type="number" class="col-2" name="qty" id="qty" value="<?= $row["jumlahkeranjang"] ?>">
                                            <button type="submit" class="btn btn-primary col-2 mt-0" name="updatejml">Update</button>
                                        </form>
                                    </h3>
                                </td>
                                <td>
                                    <h3>Rp. <?php
                                            $jumlah = $row["jumlahkeranjang"];
                                            $harga = $barang["harga"];
                                            $total = $jumlah * $harga;
                                            echo number_format($total);
                                            ?></h3>
                                </td>
                                <td>
                                    <h3><a href="hapuskrjg.php?=id<?= $row["idkeranjang"] ?>" class="btn btn-danger">Hapus</a></h3>
                                </td>
                            </tr>
                        <?php
                            $i++;
                            $subtotal += $total;
                        endforeach; ?>
                        <tr>
                            <h4>
                                <td>subtotal</td>
                                <td>Rp. <?= number_format($subtotal);
                                        ?>
                                </td>
                            </h4>
                        </tr>
                    </tbody>
                </table>

                <form action="" method="post" class="row g-3">
                    <div class="col-auto">
                        <label for="staticEmail2" class="visually-hidden">Pembayaran</label>
                        <input type="text" readonly class="form-control-plaintext mt-2" id="staticEmail2" value="Pembayaran" disabled>
                    </div>
                    <div class="col-auto">
                        <label for="inputPassword2" class="visually-hidden">Pembayaran</label>
                        <select class="form-select mt-2" name="pembayaran" aria-label="Default select example">
                            <?php
                            $det = mysqli_query($conn, "SELECT * FROM pembayaran ORDER BY nama ASC");
                            while ($d = mysqli_fetch_array($det)) {
                            ?>
                                <option value="<?= $d['nama'] ?>"><?= $d['nama'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary mt-2 mb-3" name="beli">Beli</button>
                    </div>
                </form>
                <?php

                $result = mysqli_query($conn, "SELECT * FROM keranjang WHERE status='cart'");
                $cart1 = mysqli_fetch_assoc($result);
                $cart2 = $cart1["status"];



                if (isset($_POST["beli"])) {

                    $pembayaran = $_POST["pembayaran"];
                    mysqli_query($conn, "UPDATE keranjang set status='Payment', pembayaran = $pembayaran where status = '$cart2'");
                }

                ?>
                <td><?= $cart2 ?></td>
                <a href="index.php?" class="btn text-decoration-none">Kembali</a>
            </div>
        </div>
    </div>

    <!-- products section ends -->

    <!-- footer section starts  -->

    <section class="footer mt-5">

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