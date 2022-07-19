<?php
$conn = mysqli_connect("localhost", "root", "", "db_angkringankuy");
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

function registrasi($data)
{
    global $conn;

    $username = stripslashes($data["username"]);
    $email = strtolower(stripcslashes($data["email"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);
    $nama = $data["nama"];
    $alamat = $data["alamat"];
    $no_telp = $data["no_telp"];

    //email double check
    $result = mysqli_query($conn, "SELECT email FROM tb_user
     WHERE email='$email'");

    if (mysqli_fetch_assoc($result)) {
        echo "<script>
                alert('Email Telah Digunakan!')
              </script>";
        return false;
    }

    $cek_username = mysqli_query($conn, "SELECT email FROM tb_user
     WHERE username='$username'");
    
    if (mysqli_fetch_assoc($cek_username)) {
        echo "<script>
                alert('Username Telah Digunakan!')
              </script>";
        return false;
    }

    //confirmation password check
    if ($password !== $password2) {
        echo "<script>
            alert('Konfirmasi Password Tidak Cocok!');
            </script>";
        return false;
    }
    
    //this is for passsword encription
    $password = password_hash($password, PASSWORD_DEFAULT);

    //insert to database "databasephp"
    mysqli_query($conn, "INSERT INTO tb_user (username, email, password, nama, alamat, no_telp, role) 
    VALUES('$username', '$email', '$password', '$nama', '$alamat', '$no_telp', 'user')");
     
     

    return mysqli_affected_rows($conn);
}

function tambah_produk($data)
{
    global $conn;
    $nama_produk = htmlspecialchars($data["nama_produk"]);
    $kategori = $data["kategori"];
    $harga_produk = htmlspecialchars($data["harga_produk"]);
    $jumlah_produk = htmlspecialchars($data["jumlah_produk"]);

    // upload foto produk
    $foto_produk = upload();
    if (!$foto_produk) {
        return false;
    }


    $query = "INSERT INTO tb_menu (nama_produk, kategori, harga_produk, jumlah_produk, foto_produk, rating_produk) 
    VALUES ('$nama_produk', '$kategori','$harga_produk', '$jumlah_produk', '$foto_produk', '0')";
    

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function upload()
{
    $nameFile = $_FILES['foto_produk']['name'];
    $sizeFile = $_FILES['foto_produk']['size'];
    $error = $_FILES['foto_produk']['error'];
    $tmpName = $_FILES['foto_produk']['tmp_name'];

    // cek ekstensi gambar
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $nameFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "<script>
            alert('Harap Masukkan Ekstensi Seperti JPG, JPEG atau PNG!');
        </script>";
        return false;
    }

    // setelah pengecekan beberapa kali, gambar(preview) siap upload
    $nameNewFile = uniqid();
    $nameNewFile .= '.';
    $nameNewFile .= $ekstensiGambar;
    move_uploaded_file($tmpName, 'gambar/' . $nameNewFile);

    return $nameNewFile;
}

//hapus data di tabel tb_menu
function hapus_produk($id_produk)
{
    global $conn;
    mysqli_query($conn, "DELETE FROM tb_menu WHERE id_produk=$id_produk");
    return mysqli_affected_rows($conn);
}

// untuk ubah produk
function ubah_produk($data)
{
    global $conn;
    $id_produk = $data["id_produk"];
    $nama_produk = htmlspecialchars($data["nama_produk"]);
    $harga_produk = htmlspecialchars($data["harga_produk"]);
    $jumlah_produk = htmlspecialchars($data["jumlah_produk"]);
    $oldfoto_produk = htmlspecialchars($data["oldfoto_produk"]);
    $kategori = $data["kategori"];


    // cek apakah foto produk ditambahkan baru atau tidak
    if ($_FILES['foto_produk']['error'] === 4) {
        $foto_produk = $oldfoto_produk;
    };

    $foto_produk = upload();
    if (!$foto_produk) {
        return false;
    };

    $query = "UPDATE tb_menu SET
                nama_produk = '$nama_produk', harga_produk='$harga_produk', jumlah_produk='$jumlah_produk',
                kategori = '$kategori', foto_produk = '$foto_produk' WHERE id_produk=$id_produk";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}


function makan_di_tempat($data)
{
    global $conn;
    $tgl_pemesanan = date("dmy");
    $total_harga = $data["totalharga"];
    $id_user = $_SESSION['id_user'];

    foreach ($_SESSION["pesanan"] as $id_produk => $jumlah)
    {
        $hasil = mysqli_query($conn, "SELECT * FROM tb_menu WHERE id_produk = '$id_produk' AND jumlah_produk < $jumlah ");
        $cek_stok = mysqli_num_rows($hasil);

        $pilih_stok = mysqli_query($conn, "SELECT jumlah_produk as stok_produk from tb_menu WHERE id_produk = '$id_produk'");
        $cek_pilih_stok = mysqli_fetch_array($pilih_stok);

        $data_stok_produk = $cek_pilih_stok['stok_produk'];

        if ($cek_stok > 0) {
            echo "<script>
                alert('Stok Produk Tidak Mencukupi, Harap Cek Stok Produk Kembali');
                </script>";
            return false;
        }  
    }    

    foreach ($_SESSION["pesanan"] as $id_produk => $jumlah)
    {
        $pilih_stok = mysqli_query($conn, "SELECT jumlah_produk as stok_produk from tb_menu WHERE id_produk = '$id_produk'");
        $cek_pilih_stok = mysqli_fetch_array($pilih_stok);
        $data_stok_produk = $cek_pilih_stok['stok_produk'];
        $data_stok_produk = $data_stok_produk - $jumlah;
        $ubah_stok = "UPDATE tb_menu SET jumlah_produk = $data_stok_produk WHERE id_produk = '$id_produk'";
        mysqli_query($conn, $ubah_stok);
    }    

    
    //penambahan id pesanan baru
    $id_asli = $id_user . $tgl_pemesanan;
    $id_pesanan = $id_asli . "0";
    $id_pesanan = (int)$id_pesanan;

    // Menyimpan data ke tb_pesanan
    $hasilcari = mysqli_query($conn, "SELECT * FROM tb_pesanan WHERE id_pesanan = '$id_pesanan'");
    $cekcari = mysqli_num_rows($hasilcari);
    if ($cekcari > 0) {
        $data = mysqli_fetch_assoc($hasilcari);
        $hasilmax = mysqli_query($conn, "SELECT max(id_pesanan) as maxID from tb_pesanan WHERE id_pesanan LIKE '$id_asli%'");
        $cekmax = mysqli_fetch_array($hasilmax);

        $penambahan_id = $cekmax['maxID'];
        $penambahan_id++;

        $query = "INSERT INTO tb_pesanan (id_pesanan, id_user, total_harga, status_pemesanan, pembayaran) VALUES('$penambahan_id','$id_user', '$total_harga', 
        'Makan Di Tempat', 'Belum Dibayar')";
        mysqli_query($conn, $query);
    } else {
        $data = mysqli_fetch_assoc($hasilcari);
        $query = "INSERT INTO tb_pesanan (id_pesanan, id_user, total_harga, status_pemesanan, pembayaran) VALUES('$id_pesanan','$id_user', '$total_harga', 
        'Makan Di Tempat', 'Belum Dibayar')";
        mysqli_query($conn, $query);
    }

    // Mendapatkan ID barusan
    $id_terbaru = $conn->insert_id;

    // Menyimpan data ke tb_sub_pesanan      
    foreach ($_SESSION["pesanan"] as $id_produk => $jumlah)
    {
      $insert = mysqli_query($conn, "INSERT INTO tb_sub_pesanan (id_pesanan, id_produk, jumlah) 
        VALUES ('$id_terbaru', '$id_produk', '$jumlah') ");
    }          

    unset($_SESSION["pesanan"]);

    echo "<script>
    alert('Silahkan Lakukan Pembayaran Sesuai Dengan Total Harga Yang Tertera');
    document.location.href='riwayat_pesanan.php';
    </script>
";
}

function antar_ke_rumah($data)
{
    global $conn;
    $tgl_pemesanan = date("dmy");
    $total_harga = $data["totalharga"];
    $id_user = $_SESSION['id_user'];

    foreach ($_SESSION["pesanan"] as $id_produk => $jumlah)
    {
        $hasil = mysqli_query($conn, "SELECT * FROM tb_menu WHERE id_produk = '$id_produk' AND jumlah_produk < $jumlah ");
        $cek = mysqli_num_rows($hasil);

        if ($cek > 0) {
        echo "<script>
            alert('Stok Produk Tidak Mencukupi, Harap Cek Stok Produk Kembali');
            </script>";
        return false;
        }  
    }    

    foreach ($_SESSION["pesanan"] as $id_produk => $jumlah)
    {
        $pilih_stok = mysqli_query($conn, "SELECT jumlah_produk as stok_produk from tb_menu WHERE id_produk = '$id_produk'");
        $cek_pilih_stok = mysqli_fetch_array($pilih_stok);
        $data_stok_produk = $cek_pilih_stok['stok_produk'];
        $data_stok_produk = $data_stok_produk - $jumlah;
        $ubah_stok = "UPDATE tb_menu SET jumlah_produk = $data_stok_produk WHERE id_produk = '$id_produk'";
        mysqli_query($conn, $ubah_stok);
    }  

    //penambahan id pesanan baru
    $id_asli = $id_user . $tgl_pemesanan;
    $id_pesanan = $id_asli . "0";
    $id_pesanan = (int)$id_pesanan;

    // Menyimpan data ke tb_pesanan
    $hasilcari = mysqli_query($conn, "SELECT * FROM tb_pesanan WHERE id_pesanan = '$id_pesanan'");
    $cekcari = mysqli_num_rows($hasilcari);
    if ($cekcari > 0) {
        $data = mysqli_fetch_assoc($hasilcari);
        $hasilmax = mysqli_query($conn, "SELECT max(id_pesanan) as maxID from tb_pesanan WHERE id_pesanan LIKE '$id_asli%'");
        $cekmax = mysqli_fetch_array($hasilmax);

        $penambahan_id = $cekmax['maxID'];
        $penambahan_id++;

        $query = "INSERT INTO tb_pesanan (id_pesanan, id_user, total_harga, status_pemesanan, pembayaran) VALUES('$penambahan_id','$id_user', '$total_harga', 
        'Antar Ke Rumah', 'Belum Dibayar')";
        mysqli_query($conn, $query);
    } else {
        $data = mysqli_fetch_assoc($hasilcari);
        $query = "INSERT INTO tb_pesanan (id_pesanan, id_user, total_harga, status_pemesanan, pembayaran) VALUES('$id_pesanan','$id_user', '$total_harga', 
        'Antar Ke Rumah', 'Belum Dibayar')";
        mysqli_query($conn, $query);
    }

    // Mendapatkan ID barusan
    $id_terbaru = $conn->insert_id;

    // Menyimpan data ke tb_sub_pesanan      
    foreach ($_SESSION["pesanan"] as $id_produk => $jumlah)
    {
      $insert = mysqli_query($conn, "INSERT INTO tb_sub_pesanan (id_pesanan, id_produk, jumlah) 
        VALUES ('$id_terbaru', '$id_produk', '$jumlah') ");
    }          

    unset($_SESSION["pesanan"]);

    echo "<script>
    alert('Silahkan Lakukan Pembayaran Sesuai Dengan Total Harga Yang Tertera');
    document.location.href='riwayat_pesanan.php';
    </script>
";
}

date_default_timezone_set("Asia/Jakarta");
$waktu_lengkap = date('N j/n/Y H:i:s');
function tanggal_indonesia($waktu_lengkap)
{
    $nama_hari = array(1 => 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu');
    $nama_bulan = array(1 => 'Januari', 'Febuari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');

    $pisah_waktu = explode(" ", $waktu_lengkap);
    $hari = $pisah_waktu[0];
    $tanggal = $pisah_waktu[1];
    $jam = $pisah_waktu[2];

    $hari_baru = $nama_hari[$hari];
    $pisah_tanggal = explode("/", $tanggal);
    $tanggal_baru = $pisah_tanggal[0] . " " . $nama_bulan[$pisah_tanggal[1]] . " " . $pisah_tanggal[2];

    return $hari_baru . ", " . $tanggal_baru . " - Jam " . $jam . " WIB";
}

function pembayaran($data)
{
    global $conn;
    $id_pesanan = $data["id_pesanan"];

    // upload bukti pembayaran
    $bukti_pembayaran = upload_pembayaran();
    if (!$bukti_pembayaran) {
        return false;
    }


    $query = "UPDATE tb_pesanan SET pembayaran = '$bukti_pembayaran' WHERE id_pesanan='$id_pesanan'";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function upload_pembayaran()
{
    $nameFile = $_FILES['bukti']['name'];
    $tmpName = $_FILES['bukti']['tmp_name'];

    // cek ekstensi gambar
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $nameFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "<script>
            alert('Harap Masukan File Dengan Ekstensi Yang Sesuai!');
        </script>";
        return false;
    }



    // setelah pengecekan beberapa kali, gambar(preview) siap upload
    $nameNewFile = uniqid();
    $nameNewFile .= '.';
    $nameNewFile .= $ekstensiGambar;
    move_uploaded_file($tmpName, 'pembayaran/' . $nameNewFile);

    return $nameNewFile;
}

function ubah_data($data)
{
    global $conn;
    $id_user = $_SESSION['id_user'];
    $nama = htmlspecialchars($data["nama"]);
    $alamat = htmlspecialchars($data["alamat"]);
    $no_telp = htmlspecialchars($data["no_telp"]);

    $query = "UPDATE tb_user SET nama = '$nama', alamat='$alamat', no_telp='$no_telp' WHERE id_user='$id_user'";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function ganti_password($data)
{
    global $conn;
    $username = $_SESSION['username'];
    $password_baru = mysqli_real_escape_string($conn, $data["password_baru"]);
    $konfirmasi_password_baru = mysqli_real_escape_string($conn, $data["konfirmasi_password_baru"]);

    $result = mysqli_query($conn, "SELECT password FROM tb_user
        WHERE username='$username'");

    //old password check
    if ($password_baru !== $konfirmasi_password_baru) {
        echo "<script>
            alert('Konfirmasi Password Tidak Cocok!');
            </script>";
        return false;
    }

    $password_baru = password_hash($password_baru, PASSWORD_DEFAULT);
    mysqli_query($conn, "UPDATE tb_user SET password='$password_baru' WHERE username='$username' ");

    return mysqli_affected_rows($conn);
}

function konfirmasi($data)
{
    global $conn;
    $id_pesanan = $data["id_pesanan"];
    $konfirmasi = 1;

    $query = "UPDATE tb_pesanan SET konfirmasi = $konfirmasi WHERE id_pesanan='$id_pesanan'";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

//rating produk di tabel tb_menu
function rating_produk($data)
{
    global $conn;
    $id_pesanan = $data["id_pesanan"];
    $id_produk = $data["id"];
    $jumlah_rating = $data["jumlah_rating"];
    $sum_rating = $data["sum_rating"];
    $rating_pembeli = $data["nilai_rating"];
    mysqli_query($conn, "UPDATE tb_sub_pesanan SET rating = $rating_pembeli WHERE id_pesanan='$id_pesanan' AND id_produk='$id_produk'");

    $hasil = mysqli_query($conn, "SELECT rating_produk as rating from tb_menu WHERE id_produk='$id_produk'");
    $ambil = mysqli_fetch_array($hasil);
    $rating_di_database = $ambil['rating'];

    if ($rating_di_database == 0) {
        mysqli_query($conn, "UPDATE tb_menu SET rating_produk = $rating_pembeli WHERE id_produk='$id_produk'");
    } else{
        $jumlah_rating = $jumlah_rating + 1;
        $hasil_rating = round(($sum_rating+$rating_pembeli)/$jumlah_rating, 2);
        mysqli_query($conn, "UPDATE tb_menu SET rating_produk = $hasil_rating WHERE id_produk='$id_produk'");
    }

    echo "<script>
            alert('Rating Produk Berhasil');
            document.location.href='rating_produk.php?id_pesanan=$id_pesanan';
        </script>
    ";
}