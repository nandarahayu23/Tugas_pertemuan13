<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    include "../../koneksi.php";
    $penjualan = json_decode($_POST['penjualan'], true);
    $totalbayar = json_decode($_POST['totalbayar'], true);
    $bayar = json_decode($_POST['bayar'], true);
    $kembalian = json_decode($_POST['kembalian'], true);
    $sql = "INSERT INTO penjualan (tanggal_penjualan, totalbayar, bayar, kembalian)VALUES (NOW(), '$totalbayar', '$bayar', '$kembalian')";
    $mysqli->query($sql);
    // simpan ke detail penjualan
    $sql = "SELECT id_penjualan FROM penjualan ORDER BY id_penjualan DESC LIMIT 1";
    $result = $mysqli->query($sql);
    $row = $result->fetch_assoc();
    $id_penjualan = $row['id_penjualan'];
    foreach($penjualan as $item){
        $sql = "INSERT INTO detail_penjualan 
                (id_penjualan, id_barang, jumlah, harga, totalharga)
                VALUES ('$id_penjualan', '$item['idbarang']', '$item['jumlah']', '$item['harga']', '$item['totalharga']')";
        $mysqli->query($sql);
        
        // update stok barang
        $sql = "SELECT * FROM persediaan WHERE id_barang = '$item['idbarang']' ORDER BY id_persediaan DESC LIMIT 1";
        $result = $mysqli->query($sql);
        $row = $result->fetch_assoc();
        $sql = "UPDATE persediaan SET 
                stok_awal = '$row['stok_akhir']', 
                stok_masuk = 0, 
                stok_keluar = '$item['jumlah']', 
                stok_akhir = '$row['stok_akhir']' - '$item['jumlah']', 
                deskripsi_persediaan = 'Penjualan' 
                WHERE id_barang = '$item['idbarang']'";
        $mysqli->query($sql);
    }
}
?>