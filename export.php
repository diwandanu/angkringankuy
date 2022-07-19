<?php  
    session_start();
    require 'function.php';

    $dari_tgl=$_POST["dari_tgl"];
    $sampai_tgl=$_POST["sampai_tgl"];
    $total_harga=$_POST["total_harga"];

    $table_excel = 'Laporan Penjualan Angkringan Kuy';
    if(isset($_POST["export"])){
        if($dari_tgl==""){
            $query = "SELECT * FROM tb_pesanan";
        } else {
            $table_excel .= ' Dari Tanggal ' . date("d-m-Y", strtotime($dari_tgl)) . ' Sampai Tanggal ' . date("d-m-Y", strtotime($sampai_tgl));
            $query = "SELECT * FROM tb_pesanan WHERE tanggal_pemesanan BETWEEN '$dari_tgl' AND '$sampai_tgl 23:59:59'";
        }
        $result = mysqli_query($conn, $query);
        if(mysqli_num_rows($result)>0){
            $table_excel .= '<table class="table" border="1">  
                            <tr>  
                                <th style="width: 150px;">ID Pesanan</th>  
                                <th style="width: 300px;">Tanggal Pemesanan</th>  
                                <th style="width: 100px;">Harga</th>
                            </tr>
                            ';
            while($row = mysqli_fetch_array($result)){
                $table_excel .= '
                <tr>  
                    <td>'.$row["id_pesanan"].'</td>  
                    <td>'.$row['tanggal_pemesanan'].'</td>  
                    <td>'.$row["total_harga"].'</td>  
                </tr>
                ';
            }
            $table_excel .= '<tr>
                    <th colspan="2">Total Harga</th>
                    <th>'.$total_harga.'</th>
                </tr>';
            $table_excel .= '</table>';
            header('Content-Type: application/xls');
            header('Content-Disposition: attachment; filename=laporan.xls');
            echo $table_excel;
        }
    }
?>

