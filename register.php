<?php
require 'function.php';

if (isset($_POST["register"])) {
    if (register($_POST) > 0) {
        echo "<script>
                alert('user baru berhasil ditambahkan!');
            </script>";
    } else {
        echo mysqli_error($conn);
    }
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title>Halaman Registrasi</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/sign-in/">


    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link rel="stylesheet" href="css/signin.css">
</head>

<body class="text-center">

    <main class="form-signin">
        <form action="" method="post">
            <h1 class="h3 mb-3 fw-normal">Registrasi</h1>

            <div class="form-floating">
                <input type="text" name="nama" class="form-control" id="nama">
                <label for="nama">Nama</label>
            </div>
            <div class="form-floating">
                <input type="email" name="email" class="form-control" id="email">
                <label for="email">Email address</label>
            </div>
            <div class="form-floating">
                <input type="password" name="password" class="form-control" id="password">
                <label for="password">Password</label>
            </div>
            <div class="form-floating">
                <input type="password" name="password2" class="form-control" id="password2">
                <label for="password2">Konfirmasi Password</label>
            </div>
            <div class="form-floating">
                <input type="text" name="alamat" class="form-control" id="alamat">
                <label for="alamat">Alamat</label>
            </div>
            <div class="form-floating">
                <input type="text" name="notelp" class="form-control" id="notelp">
                <label for="notelp">No. Telp</label>
            </div>
            <button class="w-100 btn btn-lg btn-primary" type="submit" name="register">Sign in</button>
        </form>
        <h4><a href="index.php">Home</a></h4>
    </main>



</body>

</html>