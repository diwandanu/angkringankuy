<?php  
session_start();
$username = $_SESSION['username'];
$id_user = $_SESSION['id_user'];

require 'function.php';

// ambil data di URL
$id_user = $_GET["id_user"];

// query data stocks berdasarkan id
$profil = query("SELECT * FROM tb_user WHERE id_user='$id_user'")[0];


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

if (isset($_POST["ubah_data"])) {
    // cek apakah data berhasil diubah atau tidak
    if (ubah_data($_POST) > 0) {
        echo "<script>
                alert('Data Berhasil Diubah');
                document.location.href='index.php';
            </script>
        ";
    } else {
        echo "<script>
        alert('Data Gagal Diubah');
    </script>
    ";
    }
}

if (isset($_POST["ganti_password"])) {
    $password_lama = $_POST["password_lama"];
    
    $result = mysqli_query($conn, "SELECT * FROM tb_user WHERE username = '$username'");
    $row =  mysqli_fetch_assoc($result);

    if (password_verify($password_lama, $row["password"])){
        if (ganti_password($_POST) > 0) {
            echo "<script>
                alert('Password Berhasil Diganti!');
                document.location.href='index.php';
                </script>";
        } else {
            echo mysqli_error($conn);
        }
    } else {
        $error = true;
    }
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
    <script src="https://kit.fontawesome.com/5be3928c9f.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="css/style.css">

    <title>Kelola Akun</title>
  </head>
  <body>

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

                        <li class="nav-item">
                            <a class="nav-link js-scroll-trigger" href="riwayat_pesanan.php">Riwayat Pesanan</a>
                        </li>
                        <li class="nav-item dropdown active">
                            <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" href="">
                                Profil Anda                            
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li>
                                    <a class="dropdown-item" href="">
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


    <div class="container bg-light" style="min-width: 350px; max-width: 800px">
        <h3 class="text-center"><b>KELOLA AKUN ANDA</b></h3>
        <table>
            <tr>
                <div class="form-group">
                    <td style="width:20%">Username</td>
                    <td style="width:600px">
                        <input type="text" name="username" id="username" class="form-control" placeholder="" required autocomplete="off" value="<?= $profil["username"]?>" disabled>
                    </td>  
                </div>
            </tr>
            <tr>
                <div class="form-group">
                    <td>Email</td>   
                    <td>
                        <input type="email" name="email" id="email" class="form-control" placeholder="" required autocomplete="off" value="<?= $profil["email"]?>" disabled>                      
                    </td>                         
                </div>
            </tr>
            <tr>
                <td><br></td>   
            </tr>
            <form action="" method="post" enctype="multipart/form-data">
            <tr>
                <div class=" form-group">
                <td>Nama</td>   
                <td>     
                    <input type="text" name="nama" id="nama" class="form-control" placeholder="" required autocomplete="off" value="<?= $profil["nama"]?>">
                </td>
                </div>
            </tr>
            <tr>
                <div class="form-group">
                <td>Alamat</td>   
                <td>
                    <textarea rows type="text" name="alamat" id="alamat" class="form-control" placeholder="" autocomplete="off" required ><?= $profil["alamat"]?></textarea>
                </td>
                </div>
            </tr>
            <tr>
                <div class="form-group">
                <td>Nomor Telepon</td>
                <td>
                    <input type="text" name="no_telp" id="no_telp" class="form-control" placeholder="" required autocomplete="off" onkeypress="return /[0-9]/i.test(event.key)" value="<?= $profil["no_telp"]?>">
                </td>
                </div>
            </tr>
        </table>
        <br>
        <button type="submit" name="ubah_data" class="btn btn-primary" onclick="return confirm ('Apakah Data Ingin Diubah?');">Ubah Data</button>
        <a class="btn btn-secondary" href="index.php">Batal</a>        
        </form>
        <br><br>

        <h2 class="text-center"><b>Ganti Password</b></h2>
        <?php if (isset($error)) : ?>
            <p style="color: red;">Password Lama Salah</p>
        <?php endif; ?>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label>Password Lama</label>
                <input type="password" name="password_lama" id="password_lama" class="form-control" placeholder="" required autocomplete="off">
            </div>
            <div class="form-group">
                <label >Password Baru</label>
                <input type="password" name="password_baru" id="password_baru" class="form-control" placeholder="" required pattern=".{6,15}" title="Password Harus 6 Karakter Sampai 15 Karakter" autocomplete="off">
            </div>
            <div class="form-group">
                <label>Konfirmasi Password Baru</label>
                <input type="password" name="konfirmasi_password_baru" id="konfirmasi_password_baru" class="form-control" placeholder="" required pattern=".{6,15}" title="Password Harus 6 Karakter Sampai 15 Karakter" autocomplete="off">
            </div>
                <button type="submit" name="ganti_password" class="btn btn-primary">Ganti Password</button>
                <a class="btn btn-secondary" href="index.php">Batal</a>
        </form>
        <br>
        <footer class="py-5">
            <div class="medium text-center text-muted">Copyright &copy; 2021 - Angkringan Kuy</div>
        </footer>
    </div>
        



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