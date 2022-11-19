<?php
session_start();

if (isset($_SESSION["login"])) {
    header("Location: index.php");
    exit;
}
require 'function.php';

if (isset($_POST["login"])) {

    $email = strtolower($_POST["email"]);
    $password = $_POST["password"];

    $result = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");

    //cek email
    if (mysqli_num_rows($result) === 1) {

        //cek password
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row["password"])) {

            //set session
            $_SESSION['nama'] = $row['nama'];
            $_SESSION['status'] = $row['status'];
            $_SESSION["login"] = true;

            header("Location: index.php");
            exit;
        }
    } else {
        echo "<script>
                alert('Email atau password yang anda masukkan salah!');
            </script>";
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
    <title>Signin Template · Bootstrap v5.0</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/sign-in/">


    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link rel="stylesheet" href="css/signin.css">
</head>

<body class="text-center">

    <main class="form-signin">
        <div class="container">
            <div class="row">
                <div class="col align-self-center">
                    <form action="" method="post">
                        <h1 class="h3 mb-3 fw-normal">Silahkan Login</h1>

                        <div class="form-floating">
                            <input type="email" name="email" class="form-control" id="email" autocomplete="off" autofocus>
                            <label for="email">Email address</label>
                        </div>
                        <div class="form-floating">
                            <input type="password" name="password" class="form-control" id="password">
                            <label for="password">Password</label>
                        </div>

                        <button class="w-100 btn btn-lg btn-primary" type="submit" name="login">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </main>



</body>

</html>