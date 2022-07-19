<?php
require 'function.php';

if (isset($_POST["register"])) {
  if (registrasi($_POST) > 0) {
    echo "<script>
            alert('Registrasi Berhasil!');
            document.location.href='login.php';
            </script>";
  } else {
    echo "<script>
            alert('Registrasi Gagal!');
            document.location.href='registrasi.php';
            </script>";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <script src="https://kit.fontawesome.com/5be3928c9f.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" type="text/css" href="css/style.css">

  <title>Halaman Registrasi</title>
  <style>
    label {
      display: block;
    }
  </style>
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
                            <a class="nav-link js-scroll-trigger" href="index.php">Home <span class="sr-only">(current)</span></a>
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
                        <li class="nav-item active">
                            <a class="nav-link js-scroll-trigger" href="registrasi.php">Registrasi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link js-scroll-trigger" href="login.php">Login</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

  <br><br>
  <div class="container bg-light" style="min-width: 350px; max-width: 800px">
    <h2 class="text-center">Registrasi</h2>
    <form action="" method="post">
      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" class="form-control" placeholder="" required autocomplete="off" onkeypress="return /[a-z ]/i.test(event.key)">
      </div>
      <div class="form-group">
        <label for="email">Email </label>
        <input type="email" name="email" id="email" class="form-control" placeholder="" required autocomplete="off">
      </div>
      <div class=" form-group">
          <label for="password">Password </label>
          <input type="password" name="password" id="password" class="form-control" placeholder="" required pattern=".{6,15}" title="Password Harus 6 Karakter Sampai 15 Karakter">
        </div>
        <div class="form-group">
            <label for="password2">Konfirmasi Password </label>
            <input type="password" name="password2" id="password2" class="form-control" placeholder="" required pattern=".{6,15}" title="Password Harus 6 Karakter Sampai 15 Karakter">
        </div>
        <div class="form-group">
          <label for="nama">Nama</label>
          <input type="text" name="nama" id="nama" class="form-control" placeholder="" required autocomplete="off">
        </div>
        <div class="form-group">
          <label for="alamat">Alamat</label>
          <textarea rows="4" type="text" name="alamat" id="alamat" class="form-control" placeholder="" autocomplete="off" required></textarea>
        </div>
        <div class="form-group">
          <label for="no_telp">Nomor Telepon</label>
          <input type="text" name="no_telp" id="no_telp" class="form-control" placeholder="" required autocomplete="off" onkeypress="return /[0-9]/i.test(event.key)">
        </div>
      <button type="submit" name="register" class="btn btn-warning">Register</button>
    </form>
    <p>
      Sudah Punya Akun ? <a href="login.php">Masuk</a>
    </p>
    <!-- Footer -->
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