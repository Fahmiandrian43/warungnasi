<?php
session_start();

// if (!isset($_SESSION["login"])) {
//     header("Location: login.php");
//     exit;
// }

require 'function.php';

$barang = query("SELECT * FROM barang");
if (isset($_SESSION["login"])) {

    $id = $_SESSION["id"];
    $keranjang = query("SELECT * from keranjang inner join barang on keranjang.idbarang = barang.id where keranjang.user = $id");
    // $keranjang = query("SELECT * from keranjang d, barang p where keranjang.idbarang = barang and d.idproduk=p.idproduk order by d.idproduk ASC");
}

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
                        <a href="hapus.php?id=<?= $cart["id"] ?>" class="fas fa-trash"></a>
                        <img src="admin/img/<?= $cart["image"] ?>" alt="<?= $cart["image"] ?>">
                        <div class="content">
                            <h3><?= $cart["nama"] ?></h3>
                            <span class="price">Rp. <?= $cart["harga"] ?></span>
                        </div>
                    </div>
                    <?php  ?>
                    <a href="beli.php?id=<?= $cart["id"] ?>" class="btn">checkout</a>
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
    <div class="breadcrumbs">
        <div class="container">
            <ol class="breadcrumb breadcrumb1">
                <li><a href="index.php"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>Home</a></li>
                <li class="active">Checkout</li>
            </ol>
        </div>
    </div>
    <!-- //breadcrumbs -->
    <!-- checkout -->
    <div class="checkout">
        <div class="container">
            <h2>Dalam keranjangmu ada : <span><?= $keranjang["id"] ?> barang</span></h2>
            <div class="checkout-right">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Produk</th>
                            <th scope="col">Nama Produk</th>
                            <th scope="col">Jumlah</th>
                            <th scope="col">Harga Satuan</th>
                            <th scope="col">Hapus</th>
                        </tr>
                    </thead>

                    <?php
                    // $brg = mysqli_query($conn, "SELECT * from keranjang k, barang b where idbarang=$id and k.id=b.id order by k.id ASC");
                    $no = 1;
                    foreach ($keranjang as $b) {
                    ?>
                        <tr class="">
                            <form method="post">
                                <td><?php echo $no++ ?></td>
                                <td><a href="product.php?id=<?php echo $b['id'] ?>"><img src="<?= $b['image'] ?>" width="100px" height="100px" /></a></td>
                                <td><?php echo $b['nama'] ?></td>
                                <td>
                                    <div class="quantity">
                                        <div class="quantity-select">
                                            <input type="number" name="jumlah" class="form-control" height="100px" value="<?php echo $b['jumlah'] ?>" \>
                                        </div>
                                    </div>
                                </td>

                                <td class="invert">Rp<?php echo number_format($b['harga']) ?></td>
                                <td class="invert">
                                    <div class="rem">

                                        <input type="hidden" name="idproduknya" value="<?php echo $b['idproduk'] ?>" \>
                                        <input type="submit" name="update" class="form-control" value="Update" \>
                                        <input type="submit" name="hapus" class="form-control" value="Hapus" \>
                            </form>
            </div>
            <script>
                $(document).ready(function(c) {
                    $('.close1').on('click', function(c) {
                        $('.rem1').fadeOut('slow', function(c) {
                            $('.rem1').remove();
                        });
                    });
                });
            </script>
            </td>
            </tr>
        <?php
                    }
        ?>

        <!--quantity-->
        <script>
            $('.value-plus').on('click', function() {
                var divUpd = $(this).parent().find('.value'),
                    newVal = parseInt(divUpd.text(), 10) + 1;
                divUpd.text(newVal);
            });

            $('.value-minus').on('click', function() {
                var divUpd = $(this).parent().find('.value'),
                    newVal = parseInt(divUpd.text(), 10) - 1;
                if (newVal >= 1) divUpd.text(newVal);
            });
        </script>
        <!--quantity-->
        </table>
        </div>
        <div class="checkout-left">
            <div class="checkout-left-basket">
                <h4>Total Harga</h4>
                <ul>
                    <!-- <?php
                            // $brg = mysqli_query($conn, "SELECT * from detailorder d, produk p where orderid='$orderidd' and d.idproduk=p.idproduk order by d.idproduk ASC");
                            // $no = 1;
                            $subtotal = 10000;
                            while ($b = $keranjang) {
                                $hrg = $b['harga'];
                                $qtyy = $b['jumlah'];
                                $totalharga = $hrg * $qtyy;
                                $subtotal += $totalharga
                            ?>
                        <li><?php echo $b['nama'] ?><i> - </i> <span>Rp<?php echo number_format($totalharga) ?> </span></li>
                    <?php
                            }
                    ?>
                    <li>Total (inc. 10k Ongkir)<i> - </i> <span>Rp<?php echo number_format($subtotal) ?></span></li> -->
                </ul>
            </div>
            <div class="checkout-right-basket">
                <a href="index.php"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>Continue Shopping</a>
                <a href="checkout.php"><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>Checkout</a>
            </div>
            <div class="clearfix"> </div>
        </div>
    </div>
    </div>
    <!-- //checkout -->

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