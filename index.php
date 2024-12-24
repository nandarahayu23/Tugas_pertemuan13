<div class="border-bottom py-3">
    <h4>Penjualan</h4>
</div>
<div class="row justify-content-center mt-3">
    <div class="col-7 bg-light-subtle me-3 p-3 shadow-sm">
        <div class="table-responsive">
            <table class="table table-striped" id="tabelPenjualan">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama Barang</th>
                        <th scope="col">Jumlah</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Total Harga</th>
                   </tr>
                </thead>
            <tbody>

            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-between bg-warning-subtle p-3 shadow-sm mb-3">
        <h3>Total</h3>
        <h3 id="totalBayar"></h3>
    </div>
    <div class="d-flex justify-content-end">
        <button type="button" class="btn btn-secondary me-2" onclick="resetPenjualan()">Reset</button>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalBayar">Bayar</button>
        <!-- buat modal -->
         <div class="modal fade" id="modalBayar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 clas="modal-title fs-5" id="exampleModalLabel">Bayar</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="totalbayar" class="form-label">Total Bayar</label>
                            <input type="number" class="form-control" id="modalTotalBayar"readonly>
                        </div>
                        <div class="mb-3">
                            <label for="bayar" class="form-label">Bayar</label>
                            <input type="number" class="form-control" id="bayar"oninput="hitungKembalian()">
                        </div>
                        <div class="mb-3">
                            <label for="kembalian" class="form-label">Kembalian</label>
                            <input type="number" class="form-control" id="kembalian" readonly>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="simpanPenjualan()">Proses</button>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-4 bg-light-subtle p-3 shadow-sm">
        <div class="mb-3">
            <label for="barang" class="form-label">Barang</label>
            <select class="form-select" name="barang" id="barang"onchange="pilihBarang()">
                <option disabled selected>Pilih Barang</option>
                <?php
                $sql_barang = "SELECT * FROM barang INNER JOIN persediaan ON barang.id_barang=persediaan.id_barang";
                $result_barang = $mysqli->query($sql_barang);
                while($row_barang = $result_barang->fetch_assoc()){
                ?>
                  <option
                    value="<?= $row_barang['id_barang'];?>"
                    nama-barang="<?= $row_barang['nama_barang'];?>"
                    data-stok="<?= $row_barang['stok_akhir'];?>"
                    data-harga="<?= $row_barang['harga_jual'];?>"
                 >
                  <? =$row_barang['nama_barang'];?>
                </option>
                <?php      
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="stok" class="form-label">Stok</label>
            <input type="number" class="form-control" id="stok" readonly>
        </div>
        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah</label>
            <input type="number" class="form-control" id="jumlah" oninput ="hitungtotalharga()">
        </div>
        <div class="mb-3">
            <label for="harga" class="form-label">Harga</label>
            <input type="number" class="form-control" id="harga" readonly>
            </div>
        <div class="mb-3">
            <label for="totalharga" class="form-label">TotalHarga</label>
            <input type="number" class="form-control" id="totalharga" readonly>
        </div>
        <div class="mb-3">
            <button type="button" class="btn btn-primary w-100" onclik="tambahItem()">Tambah Item</button>
            </div>
        </div>
    </div>
    <div class="row mt-3 shadow-sm">
        <div class="col-12">
            <div class="border-bottom py-3">
                <h4>Data Penjualan</h4>
            </div>
            <table class="table table-striped" id="tableDataPenjualan">
              <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Jumlah</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Total Harga</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql_penjualan = "SELECT * FROM penjualan";
                $result_penjualan = $mysqli->query($sql_penjualan);
                $no = 1;
                while($row_penjualan = $result_penjualan->fetch_assoc()){
                  ?>
                  <tr>
                    <td><?= $no;?></td>
                    <td>
                        <?= $row_penjualan['tanggal_penjualan'];?>
                    </td>
                    <td>
                        <div class="d-flex justify-content-between">
                            <span>Rp.</span>
                            <span>
                             <?= number_format($row_penjualan['totalbayar'],0,',','.');?>
                              </span>
                            </div>
                        </td>
                        <td>
                        <div class="d-flex justify-content-between">
                            <span>Rp.</span>
                            <span>
                                <?= number_format($row_penjualan['totalbayar'],0,',','.');?>
                              </span>
                            </div> 
                        </td>
                        <td>
                          <div class="d-flex justify-control-between">
                            <span>Rp.</span>
                            <span>
                               <?= number_format($row_penjualan['kembalian'],0,',','.');?> 
                               </span>
                            </div> 
                        </td>
                        <td>
                            <a class="btn btn-primary btn-sm" href="? modul=penjualan&aksi=detail&id=<?= $row_penjualan['id_penjualan'];?>">
                                <i class="bi bi-search"></i>
                                Detail 
                            </a>
                        </td> 
                    </tr>
                    <?php
                     $no++;
                }  
                ?>
            </tbody>
          </table>
      </div>
    </div>
    <?php
    if(isset($_GET['aksi']) && $_GET['aksi']=="detail"){
    ?>
    <div class="row mt-3 shadow-sm">
        <div class="col-12">
          <div class="border-bottom py-3">
            <h4>Detail Penjualan</h4>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                  <th scope="col">No</th>
                  <th scope="col">Nama Barang</th>
                  <th scope="col">Jumlah</th>
                  <th scope="col">Harga</th>
                  <th scope="col">Total Harga</th>
                </tr>
            </thead>
            <tbody>
               <?php
               $sql_detailpenjualan = "SELECT * FROM detail_penjualan INNER JOIN barang ON detail_penjualan.id_barang = barang.id_barang WHERE id_penjualan = '$_GET[id]'";
               $result_detailpenjualan = $mysqli->query($sql_detailpenjualan);
               $no = 1;
               while($row_detailpenjulan = $result_detailpenjualan->fetch_assoc()){
                ?>
                  <tr>
                    <td><?= $no;?></td>
                    <td><?= $row_detailpenjualan['nama_barang'];?></td>
                    <td><?= $row_detailpenjualan['jumlah'];?></td>
                    <td>
                        <div class="d-flex justify-content-between">
                            <span>Rp.</span>
                            <span>
                                <?=number_format($row_detailpenjualan['harga'],0,',','.');?>
                            </span>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex justify-content-between">
                        <span>Rp.</span>
                            <span>
                                <?=number_format($row_detailpenjualan['totalharga'],0,',','.');?>
                            </span>
                        </div>
                    </td>
               </tr>
            <?php
            $no++;
               }
               ?>
               </tbody>
            </table>
        </div>
    </div>
    <?php
    }
    ?>
    <script src="modul/penjualan/index.js"></script>











            




