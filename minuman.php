<?php
session_start();

require 'function.php';
$menu = query("SELECT * FROM tb_menu WHERE kategori='Minuman' ORDER BY nama_produk  ");

// Cart Notification
if(empty($_SESSION["pesanan"]))
{
    $jml_keranjang = 0;
}
    else{
    $jml_keranjang = 0;
    foreach ($_SESSION["pesanan"] as $id_produk) :
        $jml_keranjang++;
    endforeach;
}
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/style.css">

    <!-- Link Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/5be3928c9f.js" crossorigin="anonymous"></script>

    <title>Home</title>
</head>

<body id="page-top">

    <!-- Navigation Bar -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-transparent" id="MainNav">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php" style="color : white;">
                    <i class="fas fa-store-alt"></i>
                    Angkringan Kuy
                </a>
                <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link js-scroll-trigger" href="index.php">Home</span></a>
                        </li>
                        <li class="nav-item dropdown active">
                          <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" href="">Kategori</a>
                          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li>
                                <a class="dropdown-item" href="makanan.php">
                                    Makanan
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="minuman.php">
                                    Minuman
                                </a>
                            </li>
                          </ul>
                        </li>
                        <?php
                        if(!isset($_SESSION['level'])) {
                            ?>
                        <li class="nav-item">
                            <a class="nav-link js-scroll-trigger" href="registrasi.php">Registrasi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link js-scroll-trigger" href="login.php">Login</a>
                        </li>
                        <?php } else {?>
                            <li class="nav-item">
                            <a class="nav-link js-scroll-trigger" href="keranjang.php">
                                Keranjang
                                <?php
                                    $username = $_SESSION['username'];
                                    $id_user = $_SESSION['id_user'];
                                    if(empty($_SESSION["pesanan"]))
                                    {
                                        $jml_keranjang = 0;
                                    }
                                    else{
                                ?>
                                    <span class="icon-button__badge"><?= $jml_keranjang ?></span>
                                <?php } ?>
                            </a>                        
                        </li>

                        <li class="nav-item">
                            <a class="nav-link js-scroll-trigger" href="riwayat_pesanan.php">Riwayat Pesanan</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" href="">
                                Profil Anda
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li>
                                    <a class="dropdown-item" href="kelola_akun.php?id_user=<?= $id_user ?>">
                                        Kelola Akun
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="logout.php">
                                        Logout
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <?php } ?>   
                    </ul>
                </div>
            </div>
        </nav>
    </header>



    <div class="container bg-light">
        <br>
        <h2>Minuman</h2>
        <hr>
        <div class="row">
            <?php $i = 1; ?>
                <?php foreach ($menu as $row) :
                    $id = $row["id_produk"];
                    $pilih_stok = mysqli_query($conn, "SELECT jumlah_produk as stok from tb_menu WHERE id_produk = $id"); 
                    $cek_pilih_stok = mysqli_fetch_array($pilih_stok);
                    $stok_produk= $cek_pilih_stok['stok'];
                ?>

                <div class="col-md-3">
                    <br>
                    <div class="card">
                        <img src="gambar/<?= $row["foto_produk"]; ?>" height="200" width="75" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5><?= $row["nama_produk"]; ?></h5>
                            <table>
                                <tr>
                                    <td>
                                        <p>Harga</p>
                                    </td>
                                    <td>
                                        <p>: Rp<?= number_format($row["harga_produk"]);?></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p>Stok</p>
                                    </td>
                                    <td>
                                        <p>: <?=$row["jumlah_produk"]?></p>
                                    </td>
                                </tr>
                            </table>
                            <?php if ($row["rating_produk"] == 0) {?>
                                <p>Belum Ada Rating</p>
                            <?php } else {?>
                                    <?php $rating=$row["rating_produk"];?>
                                    <?php $rating=(int)$rating; ?>
                                    <?php if ($rating == "1") {?>
                                        <i class="fas fa-star fa-lg" style="color: gold;"></i>
                                        <i class="far fa-star fa-lg" style="color: gold;"></i>
                                        <i class="far fa-star fa-lg" style="color: gold;"></i>
                                        <i class="far fa-star fa-lg" style="color: gold;"></i>
                                        <i class="far fa-star fa-lg" style="color: gold;"></i>
                                        <?=$row["rating_produk"];?>
                                        <p></p>
                                    <?php } elseif ($rating == "2"){?>
                                        <i class="fas fa-star fa-lg" style="color: gold;"></i>
                                        <i class="fas fa-star fa-lg" style="color: gold;"></i>
                                        <i class="far fa-star fa-lg" style="color: gold;"></i>
                                        <i class="far fa-star fa-lg" style="color: gold;"></i>
                                        <i class="far fa-star fa-lg" style="color: gold;"></i>
                                        <?=$row["rating_produk"];?>
                                        <p></p>
                                    <?php } elseif ($rating == "3"){?>
                                        <i class="fas fa-star fa-lg" style="color: gold;"></i>
                                        <i class="fas fa-star fa-lg" style="color: gold;"></i>
                                        <i class="fas fa-star fa-lg" style="color: gold;"></i>
                                        <i class="far fa-star fa-lg" style="color: gold;"></i>
                                        <i class="far fa-star fa-lg" style="color: gold;"></i>
                                        <?=$row["rating_produk"];?>
                                        <p></p>
                                    <?php } elseif ($rating == "4"){?>
                                        <i class="fas fa-star fa-lg" style="color: gold;"></i>
                                        <i class="fas fa-star fa-lg" style="color: gold;"></i>
                                        <i class="fas fa-star fa-lg" style="color: gold;"></i>
                                        <i class="fas fa-star fa-lg" style="color: gold;"></i>
                                        <i class="far fa-star fa-lg" style="color: gold;"></i>
                                        <?=$row["rating_produk"];?>
                                        <p></p>
                                    <?php } elseif ($rating == "5"){?>
                                        <i class="fas fa-star fa-lg" style="color: gold;"></i>
                                        <i class="fas fa-star fa-lg" style="color: gold;"></i>
                                        <i class="fas fa-star fa-lg" style="color: gold;"></i>
                                        <i class="fas fa-star fa-lg" style="color: gold;"></i>
                                        <i class="fas fa-star fa-lg" style="color: gold;"></i>
                                        <?=$row["rating_produk"];?>
                                        <p></p>
                                    <?php } ?>
                            <?php } ?>                        <?php if ($stok_produk == 0) {?>
                            <a class="btn btn-sm-secondary btn-sm btn-block" disabled>STOK HABIS</a>
                            <?php } else {?>
                            <a href="beli.php?id_produk=<?=$row["id_produk"];?>" class="btn btn-success btn-sm btn-block ">BELI</a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php $i++; ?>
            <?php endforeach; ?>
        </div>
        <!-- Footer -->
        <br><br><br><br>
        <footer class="py-5">
            <div class="medium text-center text-muted">Copyright &copy; 2021 - Angkringan Kuy</div>
        </footer>
    </div>



    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>

</html>