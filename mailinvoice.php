<?php
session_start();
$id_pesanan = $_SESSION['id_pesanan'];

require 'function.php';

// query data pesanan berdasarkan id
$pesanan = query("SELECT * FROM tb_pesanan JOIN tb_user ON tb_pesanan.id_user=tb_user.id_user WHERE id_pesanan=$id_pesanan")[0];

$cari = query("SELECT * FROM tb_pesanan WHERE id_pesanan=$id_pesanan");
foreach($cari as $row){
    $total=$row['total_harga'];
}

$detail_pesanan = query("SELECT * FROM tb_sub_pesanan JOIN tb_menu ON tb_sub_pesanan.id_produk=tb_menu.id_produk
WHERE tb_sub_pesanan.id_pesanan=$id_pesanan");

$table1 = '<table style="max-width:60%">
          <tr>
            <th>Nama Produk</th> 
            <th>Harga</th>
            <th>Jumlah</th>
            <th>Sub Harga</th>
          </tr>';
foreach($detail_pesanan as $val){
    $subharga = $val['harga_produk']*$val['jumlah'];
    $table1 .= '<tr>
                    <td>'.$val['nama_produk'].'</td> 
                    <td>'.$val['harga_produk'].'</td>
                    <td>'.$val['jumlah'].'</td>
                    <td>'.$subharga.'</td>
              </tr>';
}
$table1 .= '<tr>
                <th colspan="5">Total Harga</th>
                <th>'.$total.'</th>
            </tr>';
$table1 .= '</table>';

$email_pembeli =  $pesanan["email"];

if($pesanan["status_pemesanan"] == "Makan Di Tempat") {
    $isibody = nl2br("Pembayaranmu sudah kami konfirmasi. Berikut adalah rincian pembelian yang telah kamu selesaikan :
    \nID Pesanan: " . $pesanan["id_pesanan"] . "\nNama : " . $pesanan["nama"] . "\nEmail : " . $pesanan["email"] .
    "\nNo.Telp : " . $pesanan["no_telp"] . "\nPesanan : " . $table1 .
    "\nTerimakasih sudah melakukan pembelian di website Angkringan Kuy. 
    Kamu bisa melakukan rating produk setelah kamu menyelesaikan pesananmu pada website Angkringan Kuy pada halaman Riwayat Pesanan Anda."
);
} else {
    $isibody = nl2br("Pembayaranmu sudah kami konfirmasi. Terimakasih sudah melakukan pembelian di website Angkringan Kuy. Berikut adalah rincian pembelian yang telah kamu selesaikan :
    \nID Pesanan: " . $pesanan["id_pesanan"] . "\nNama : " . $pesanan["nama"] . "\nEmail : " . $pesanan["email"] .
    "\nNo.Telp : " . $pesanan["no_telp"] . "\nAlamat : " . $pesanan["alamat"] . "\nPesanan : " . $table1 .
    "\nTerimakasih sudah melakukan pembelian di website Angkringan Kuy. 
    Kamu bisa melakukan rating produk setelah kamu menyelesaikan pesananmu pada website Angkringan Kuy pada halaman Riwayat Pesanan Anda."
);
}

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'includes/PHPMailer.php';
require 'includes/SMTP.php';
require 'includes/Exception.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';
    $mail->Port = '587';
    $mail->Username = 'noreplydesignby@gmail.com';
    $mail->Password = 'Googleteros17';

    //Recipients
    $mail->setFrom('noreplydesignby@gmail.com', 'Angkringan Kuy');
    $mail->addAddress($email_pembeli);     //Add a recipient


    //Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Pembayaran Terkonfirmasi';
    $mail->Body    = $isibody;

    $mail->send();
    echo "<script>
                alert('Invoice Akan Dikirimkan Kepada Email Pembeli');
                document.location.href='daftar_pesanan.php';
            </script>
        ";
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
