<?php

$conn = mysqli_connect("localhost", "root", "", "toko");

function query($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}



function register($data)
{

    global $conn;

    $nama = htmlspecialchars(stripslashes($data["nama"]));
    if (empty($nama)) {
        echo "<script>
                alert('Silahkan masukkan nama!');
            </script>";

        return false;
    }

    $email = htmlspecialchars(strtolower(stripslashes($data["email"])));
    if (empty($email)) {
        echo "<script>
                alert('Silahkan masukkan nama!');
            </script>";

        return false;
    }

    $alamat = htmlspecialchars($data["alamat"]);
    if (empty($alamat)) {
        echo "<script>
                alert('Silahkan masukkan alamat!');
            </script>";

        return false;
    }

    $no_telp = htmlspecialchars($data["notelp"]);
    if (empty($no_telp)) {
        echo "<script>
                alert('Silahkan masukkan No. telp!');
            </script>";

        return false;
    }

    $password = mysqli_real_escape_string($conn, $data["password"]);
    if (empty($password)) {
        echo "<script>
                alert('Silahkan masukkan password!');
            </script>";

        return false;
    }

    $password2 = mysqli_real_escape_string($conn, $data["password2"]);
    if (empty($password2)) {
        echo "<script>
                alert('Silahkan masukkan konfirmasi password!');
            </script>";

        return false;
    }



    //cek konfirmasi password
    if ($password !== $password2) {
        echo "<script>
                alert('konfirmasi password tidak sesuai!');
            </script>";

        return false;
    }

    //enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    //Tambahkan pelanggan ke database
    mysqli_query($conn, "INSERT INTO users VALUE ('', '$nama', '$email','$alamat', '$no_telp', '$password', '')");

    return mysqli_affected_rows($conn);
}

function katagori($data)
{
    global $conn;

    $nama = htmlspecialchars(stripslashes($data['nama']));
    if (empty($nama)) {
        echo "<script>
                alert('Silahkan masukkan nama!');
            </script>";
    }

    mysqli_query($conn, "INSERT INTO katagori VALUE ('', '$nama')");

    return mysqli_affected_rows($conn);
}

function hapusKatagori($id)
{
    global $conn;

    mysqli_query($conn, "DELETE FROM katagori WHERE id = $id");

    return mysqli_affected_rows($conn);
}

function ubahKatagori($data)
{
    global $conn;

    $id = $data["id"];
    $nama = htmlspecialchars($data["nama"]);

    $query = "UPDATE katagori SET
            nama = '$nama'
            WHERE id = $id";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function barang($data)
{
    global $conn;

    $nama = htmlspecialchars(stripslashes($data["nama"]));
    if (empty($nama)) {
        echo "<script>
                alert('Silahkan masukkan nama!');
            </script>";
    }

    $jumlah = htmlspecialchars($data["jumlah"]);
    if (empty($jumlah)) {
        echo "<script>
                alert('Silahkan masukkan jumlah!');
            </script>";
    }
    $harga = htmlspecialchars($data["harga"]);
    if (empty($harga)) {
        echo "<script>
                alert('Silahkan masukkan harga!');
            </script>";
    }

    $katagori = $data["id"];
    if (empty($katagori)) {

        echo "<script>
                alert('Silahkan pilih katagori!');
            </script>";
    }

    $deskripsi = $data["deskripsi"];

    $gambar = upload();

    if (!$gambar) {
        return false;
    }

    $query = "INSERT INTO barang VALUE('', '$nama', '$katagori', '$jumlah', '$gambar', '$deskripsi', '$harga')";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function upload()
{

    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    //cek apakah gambar ada gambar yang diupload
    if ($error === 4) {
        echo "<script>
                alert('pilih gambar terlebih dahulu!');
            </script>";
        return false;
    }

    //cek apakah yang diupload adalah gambar
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "<script>
                alert('Yang anda upload bukan gambar!');
            </script>";
        return false;
    }

    if ($ukuranFile > 5000000) {
        echo "<script>
                alert('Ukuran gambar terlaku besar!');
            </script>";
        return false;
    }

    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;

    $file = 'C:/xampp/htdocs/project/admin/img/';
    move_uploaded_file($tmpName, $file . $namaFileBaru);

    return $namaFileBaru;
}

function ubahBarang($data)
{
    global $conn;

    $id = $data["id"];
    $nama = htmlspecialchars(stripslashes($data["nama"]));
    $jumlah = htmlspecialchars($data["jumlah"]);
    $katagori = $data["id"];

    $gambarLama = $data["gambarLama"];

    if ($_FILES['gambar']['error'] === 4) {
        $gambar = $gambarLama;
    } else {
        $gambar = upload();
    }

    $query = "UPDATE barang SET nama = $nama, katagori = $katagori, jumlah = $jumlah, gambar = $gambar WHERE id = $id";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function keranjang($data)
{
    global $conn;

    $orderid = $data["orderid"];
    $gambar = $data["gambar"];
    $nama = $data["nama"];
    $harga = $data["harga"];

    $query = "INSERT INTO keranjang VALUE ('', '$orderid', '$nama', '$harga', '1', '$gambar')";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}
