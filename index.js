$(document).ready(function() {
    $('#tabelDataPenjualan').DataTable();
    updateTablePenjualan();
})
function pilihBarang() {
    var select = document.getElementById('barang');
    var selectedOption = select.options[select.selectedIndex];

    var idBarang = selectedOption.value;
    var stok = selectedOption.getAttribute('data-stok');
    var harga = selectedOption.getAttribute('data-harga');

    document.getElementById('stok').value = stok;
    document.getElementById('harga').value = harga;
}

function hitungTotalHarga() {
    var jumlah = document.getElementById('jumlah').value;
    var harga = document.getElementById('harga').value;

    var totalHarga = jumlah * harga;
    document.getElementById('totalHarga').value = totalHarga;
}
function tambahItem() {
    var barang = document.getElementById('barang');
    var idBarang = barang.options[barang.selectedIndex].value;
    var namaBarang = barang.options[barang.selectedIndex].getAttribute('nama-barang');
    var jumlah = document.getElementById('jumlah').value;
    var harga = document.getElementById('harga').value;
    var totalHarga = document.getElementById('totalHarga').value;

    // simpan ke local storage
    var penjualan = JSON.parse(localStorage.getItem('penjualan')) || [];
penjualan.push({
    idbarang: idbarang,
    namabarang: namabarang,
    jumlah: jumlah,
    harga: harga,
    totalharga: totalharga,
});
localStorage.setItem('penjualan', JSON.stringify(penjualan));

// Update tabel penjualan
updateTablePenjualan();

// Kosongkan form
kosongkanForm();
}

function kosongkanForm() {
    document.getElementById('barang').value = '';
    document.getElementById('stok').value = '';
    document.getElementById('jumlah').value = '';
    document.getElementById('harga').value = '';
    document.getElementById('totalHarga').value = '';
}

function resetPenjualan() {
    // Hapus semua data di local storage
    localStorage.removeItem('penjualan');
    localStorage.removeItem('totalHarga');
    // Reload halaman
    location.reload();
}

    function hitungTotalBayar(){
var penjualan = JSON.parse(localStorage.getItem('penjualan')) || [];
var totalBayar = 0;
for (var i = 0; i < penjualan.length; i++) {
    totalBayar += parseFloat(penjualan[i].totalharga);
}
// simpan total bayar ke local storage
localStorage.setItem('totalbayar', totalBayar);
// konversi ke format rupiah dengan tidak ada digit di belakang koma
totalBayarIDR = totalBayar.toLocaleString('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 });
document.getElementById('totalBayar').textContent = totalBayarIDR;
document.getElementById('modalTotalBayar').value = totalBayar;
    }
function updateTablePenjualan() {
    var penjualan = JSON.parse(localStorage.getItem('penjualan')) || [];
    var tabelPenjualan = $('#tablePenjualan').DataTable();
    tabelPenjualan.clear();
    for (var i = 0; i < penjualan.length; i++) {
        tabelPenjualan.row.add([
            i + 1,
            penjualan[i].namabarang,
            penjualan[i].jumlah,
            penjualan[i].hargasatuan,
            penjualan[i].totalharga
        ]).draw(false);
    }
    hitungTotalBayar();
}

    function simpanPenjualan() {
// simpan ke database
var penjualan = JSON.parse(localStorage.getItem('penjualan')) || [];
var totalbayar = localStorage.getItem('totalbayar');
var bayar = localStorage.getItem('bayar');
    var kembalian = localStorage.getItem('kembalian');
    $.ajax({
        url: 'modul/penjualan/proses.php',
        method: 'POST',
        data: {
            penjualan: JSON.stringify(penjualan),
            totalbayar: totalbayar,
            bayar: bayar,
            kembalian: kembalian
        },
        success: function(response) {
            resetPenjualan();
            location.reload();
        }
    });
}

function hitungKembalian() {
    var bayar = document.getElementById('bayar').value;
    var totalbayar = localStorage.getItem('totalbayar');
    var kembalian = bayar - totalbayar;
    // simpan ke local storage
    localStorage.setItem('bayar', bayar);
    localStorage.setItem('kembalian', kembalian);
    document.getElementById('kembalian').value = kembalian;
}



