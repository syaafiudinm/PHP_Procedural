<?php
session_start();

if ( !isset($_SESSION["login"]) ){
    header("location: login.php");
}

require 'functions.php';

$dataPerHalaman = 2;
$totalData = count(query("SELECT * FROM mahasiswa"));
$totalHalaman = ceil($totalData / $dataPerHalaman);

$halamanAktif = ( isset($_GET["halaman"]) ) ? $_GET["halaman"] : 1;


$awalData = ( $dataPerHalaman * $halamanAktif ) - $dataPerHalaman;


// if ( isset($_GET["halaman"]) ){

//     $halamanAktif = $_GET["halaman"];

// } else{

//     $halamanAktif = 1;

// }





$mahasiswa = query("SELECT * FROM mahasiswa LIMIT $awalData, $dataPerHalaman");

if ( isset($_POST["keyword"]) > 0 ){
    $mahasiswa = cari($_POST["keyword"]);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Admin</title>
    <style>
        h1{
            text-align: center;
        }

        .halAktif{
            color: red;
            font-weight: bolder;
        }
    </style>
</head>
<body>

    <h1>Daftar Mahasiswa</h1>
    
    <a href="tambah.php">Tambah data mahasiswa</a>
    <br>
    <a href="logout.php">Logout</a>
    <br>
    <br>

    <form action="" method="post">
        <input type="text" name="keyword" size="30" autofocus placeholder="masukkan keyword anda" autocomplete="off">
        <button type="submit" name="cari" >terawang!</button>
        <br>
        <br>
        <br>

    </form>

    <br><br>


    <?php if( $halamanAktif > 1 ) : ?>
    <a href="?halaman=<?= $halamanAktif - 1 ?>">&laquo;</a>
    <?php endif; ?>

    <?php for( $i = 1; $i <= $totalHalaman; $i++ ) : ?>

        <?php if ( $i == $halamanAktif ) : ?>

        <a href="?halaman=<?= $i; ?>" class="halAktif"><?= $i ?></a>

        <?php else : ?>

        <a href="?halaman=<?= $i; ?>"><?= $i ?></a>

        <?php endif ; ?>

    <?php endfor; ?>


    <?php if ( $halamanAktif < $totalHalaman ) : ?>
    <a href="?halaman=<?= $halamanAktif + 1 ?>">&raquo;</a>
    <?php endif; ?>

    




    
    <table border="1" cellpadding="10" cellspacing="0">

        <tr>
            <th>No.</th>
            <th>Aksi</th>
            <th>Nim</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Prodi</th>
            <th>gambar</th>
        </tr>
        <?php $i =1; ?>
        <?php foreach( $mahasiswa as $row ) : ?>
        <tr>
            <td><?php echo $i+$awalData ?></td>
            <td>
                <a href="ubah.php?NIM=<?= $row["NIM"]; ?>">Ubah</a> |
                <a href="delete.php?NIM=<?= $row["NIM"]; ?>" onclick="return confirm('apakah ingin menghapus data?');">Hapus </a>
            </td>
            <td><?php echo $row["NIM"]; ?></td>
            <td><?php echo $row["Nama"]; ?></td>
            <td><?php echo $row["email"]; ?></td>
            <td><?php echo $row["Prodi"]; ?></td>
            <td><img src="img/<?= $row["gambar"]; ?>" width="50"></td>
        </tr>
        <?php $i++; ?>
        <?php endforeach; ?>

    </table>

</body>
</html>