<?php  
session_start();
$username = $_SESSION['username'];
$id_user = $_SESSION['id_user'];

require 'function.php';

// ambil data di URL
$id_pesanan = $_GET["id_pesanan"];

$detail_pesanan = query("SELECT * FROM tb_sub_pesanan JOIN tb_menu ON tb_sub_pesanan.id_produk=tb_menu.id_produk
WHERE tb_sub_pesanan.id_pesanan='$_GET[id_pesanan]'");

$pesanan = query("SELECT * FROM tb_pesanan WHERE id_pesanan='$_GET[id_pesanan]'");

if(!isset($_SESSION['level'])) {
    header("location: login.php");
    }else{



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

if (isset($_POST["submit_rating"])) {
    rating_produk($_POST);
}
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="css/test2.css">
    <script src="https://kit.fontawesome.com/5be3928c9f.js" crossorigin="anonymous"></script>

    <title>Riwayat Pesanan</title>
  </head>
  <body>

    <!-- Navigation Bar -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light" id="MainNav">
            <div class="container-fluid">
                <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link js-scroll-trigger" href="index.php">Home</span></a>
                        </li>
                        <li class="nav-item dropdown">
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

                        <li class="nav-item active">
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


    <div class="container">
    <h3 class="text-center"><b>RATING PRODUK</b></h3>
    <table class="table table-bordered" id="example">
        <thead class="thead-light">
          <tr>
            <th scope="col" style="width: 5%;">No.</th>
            <th scope="col">Foto Produk</th>
            <th scope="col">Nama Produk</th>
            <th scope="col">Harga</th>
            <th scope="col">Rating</th>
          </tr>
        </thead>
        <tbody>
        <?php $i = 1; ?>
        <?php foreach ($detail_pesanan as $row) : ?>
        <?php $subharga1=$row['harga_produk']*$row['jumlah']; ?>
            <tr>
                <td><?= $i; ?></td>
                <td><img src="gambar/<?= $row["foto_produk"];?>" width="100" height="100"></td>
                <td><?= $row["nama_produk"]; ?></td>
                <td>Rp. <?= number_format($row['harga_produk']);?></td>
                <td>
                    <?php if($row["rating"]!=0) { ?>
                        <?php $rating = $row["rating"];?>
                        <?php if ($rating == "1") {?>
                                    <i class="fas fa-star fa-lg" style="color: gold;"></i>
                                    <i class="far fa-star fa-lg" style="color: gold;"></i>
                                    <i class="far fa-star fa-lg" style="color: gold;"></i>
                                    <i class="far fa-star fa-lg" style="color: gold;"></i>
                                    <i class="far fa-star fa-lg" style="color: gold;"></i>
                                    <?=$row["rating"];?>
                                    <p></p>
                                <?php } elseif ($rating == "2"){?>
                                    <i class="fas fa-star fa-lg" style="color: gold;"></i>
                                    <i class="fas fa-star fa-lg" style="color: gold;"></i>
                                    <i class="far fa-star fa-lg" style="color: gold;"></i>
                                    <i class="far fa-star fa-lg" style="color: gold;"></i>
                                    <i class="far fa-star fa-lg" style="color: gold;"></i>
                                    <?=$row["rating"];?>
                                    <p></p>
                                <?php } elseif ($rating == "3"){?>
                                    <i class="fas fa-star fa-lg" style="color: gold;"></i>
                                    <i class="fas fa-star fa-lg" style="color: gold;"></i>
                                    <i class="fas fa-star fa-lg" style="color: gold;"></i>
                                    <i class="far fa-star fa-lg" style="color: gold;"></i>
                                    <i class="far fa-star fa-lg" style="color: gold;"></i>
                                    <?=$row["rating"];?>
                                    <p></p>
                                <?php } elseif ($rating == "4"){?>
                                    <i class="fas fa-star fa-lg" style="color: gold;"></i>
                                    <i class="fas fa-star fa-lg" style="color: gold;"></i>
                                    <i class="fas fa-star fa-lg" style="color: gold;"></i>
                                    <i class="fas fa-star fa-lg" style="color: gold;"></i>
                                    <i class="far fa-star fa-lg" style="color: gold;"></i>
                                    <?=$row["rating"];?>
                                    <p></p>
                                <?php } elseif ($rating == "5"){?>
                                    <i class="fas fa-star fa-lg" style="color: gold;"></i>
                                    <i class="fas fa-star fa-lg" style="color: gold;"></i>
                                    <i class="fas fa-star fa-lg" style="color: gold;"></i>
                                    <i class="fas fa-star fa-lg" style="color: gold;"></i>
                                    <i class="fas fa-star fa-lg" style="color: gold;"></i>
                                    <?=$row["rating"];?>
                                    <p></p>
                                <?php } ?>
                    <?php } else { ?>
                        <?php
                            $id_produk = $row['id_produk'];
                            $rating_database = mysqli_query($conn, "SELECT COUNT(id_produk) AS jumlah_rating FROM tb_sub_pesanan WHERE rating > 0 AND id_produk='$id_produk'");
                            $cek = mysqli_fetch_array($rating_database);
                            $jumlah_rating = $cek['jumlah_rating'];

                            $sum_rating = mysqli_query($conn, "SELECT SUM(rating) AS sum_rating FROM tb_sub_pesanan WHERE rating > 0 AND id_produk='$id_produk'");
                            $cek2 = mysqli_fetch_array($sum_rating);
                            $sum_rating = $cek2['sum_rating'];
                        ?>
                        <form action="" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="sum_rating" value="<?=$sum_rating?>">
                            <input type="hidden" name="jumlah_rating" value="<?=$jumlah_rating?>">
                            <input type="hidden" name="id_pesanan" value="<?=$id_pesanan?>">
                            <input type="hidden" name="id" value="<?=$id_produk?>">
                            <input type="number" name="nilai_rating" style="width: 50px;" min="1" max="5" onkeypress="return /[]/i.test(event.key)" required>
                            <button type="submit" name="submit_rating" class="btn btn-sm btn-success" onclick="return confirm ('Apakah Rating Sudah Benar?');">Rating</button>
                        </form>
                    <?php }?>
                </td>
            </tr>
        <?php $i++; ?>
        <?php endforeach; ?>
      </tbody>
    </table>
    <br>
    </div>

  <br><br>
    <footer class="py-5">
        <div class="medium text-center text-muted">Copyright &copy; 2021 - Angkringan Kuy</div>
    </footer>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/jquery.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script>
      $(document).ready(function() {
          $('#example').DataTable();
      } );
    </script>
  </body>
</html>
<?php } ?>