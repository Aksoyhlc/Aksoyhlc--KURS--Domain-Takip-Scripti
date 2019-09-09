<?php include 'header.php' ?>
<link rel="stylesheet" type="text/css" href="vendor/datatables/dataTables.bootstrap4.min.css">

<div class="container-fluid">
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Müşteriler</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive mt-3">
        <table class="table table-bordered" id="musteritablosu">
          <thead>
            <tr>
              <th>No</th>
              <th>Müşteri İsim</th>
              <th>Müşteri Mail</th>
              <th>Müşteri Telefon</th>
              <th>İşlemler</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            $sayi=0;
            $sorgu=$db->prepare("SELECT * FROM musteri");
            $sorgu->execute();
            while ($musteribilgisi=$sorgu->fetch(PDO::FETCH_ASSOC)) { 
              $sayi++;
              ?>
              <tr>
                <td><?php echo $sayi; ?></td>
                <td><?php echo $musteribilgisi['musteri_isim']; ?></td>
                <td><?php echo $musteribilgisi['musteri_mail']; ?></td>
                <td><?php echo $musteribilgisi['musteri_telefon']; ?></td>
                <td>
                  <div class="row justify-content-center">
                    <form action="musteriduzenle.php" method="POST" accept-charset="utf-8">
                      <input type="hidden" name="musteri_id" value="<?php echo $musteribilgisi['musteri_id']?>">
                      <button type="submit" name="duzenleme" class="btn btn-success btn-sm btn-icon-split">
                        <span class="icon text-white-60">
                          <i class="fas fa-edit"></i>
                        </span>
                      </button>
                    </form>
                    <form class="mx-1" action="islemler/ajax.php" method="POST" accept-charset="utf-8">
                      <input type="hidden" name="musteri_id" value="<?php echo $musteribilgisi['musteri_id']?>">
                      <button type="submit" name="musterisilme" class="btn btn-danger btn-sm btn-icon-split">
                        <span class="icon text-white-60">
                          <i class="fas fa-trash"></i>
                        </span>
                      </button>
                    </form>
                    <form action="musteri.php" method="POST" accept-charset="utf-8">
                      <input type="hidden" name="musteri_id" value="<?php echo $musteribilgisi['musteri_id']?>">
                      <button type="submit" name="duzenleme" class="btn btn-primary btn-sm btn-icon-split">
                        <span class="icon text-white-60">
                          <i class="fas fa-eye"></i>
                        </span>
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            <?php } ?>            
          </tbody>
        </table>
      </div>
    </div>
  </div>


  <hr>


  <!-- DataTales Giriş -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Domainler</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive mt-3">
        <table class="table table-bordered" id="domaintablosu">
          <thead>
            <tr>
              <th>No</th>
              <th>Domain Adı</th>
              <th>Domain Müşteri</th>
              <th>Bitiş Tarihi</th>
              <th>Fiyat</th>
              <th>Kalan Gün</th>
              <th>İşlemler</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            $sayi=0;
            $sorgu=$db->prepare("SELECT * FROM domain LEFT JOIN musteri ON domain.domain_musteri=musteri.musteri_id");
            $sorgu->execute();
            while ($domain=$sorgu->fetch(PDO::FETCH_ASSOC)) { 
              $sayi++;
              ?>
              <tr>
                <td><?php echo $sayi; ?></td>
                <td><?php echo $domain['domain_adi']; ?></td>
                <td><?php echo $domain['musteri_isim']; ?></td>
                <td><?php echo $domain['domain_bitis']; ?></td>
                <td><?php echo $domain['domain_fiyat']; ?></td>
                <td><?php 
                $bugununtarihi=strtotime(date('d.m.Y'));
                $domainbitis=strtotime($domain['domain_bitis']);
                $sonuc=$domainbitis-$bugununtarihi;
                echo $fark=floor($sonuc / (60*60*24));

                ?></td>
                <td>
                  <div class="row justify-content-center">


                   <form class="mr-1" action="domainyenile.php" method="POST" accept-charset="utf-8">
                    <input type="hidden" name="domain_id" value="<?php echo $domain['domain_id']?>">
                    <button type="submit" name="yenile" class="btn btn-info btn-sm btn-icon-split">
                      <span class="icon text-white-60">
                        <i class="fas fa-sync-alt"></i>
                      </span>
                    </button>
                  </form>
                  <form action="domainduzenle.php" method="POST" accept-charset="utf-8">
                    <input type="hidden" name="domain_id" value="<?php echo $domain['domain_id']?>">
                    <button type="submit" name="duzenleme" class="btn btn-success btn-sm btn-icon-split">
                      <span class="icon text-white-60">
                        <i class="fas fa-edit"></i>
                      </span>
                    </button>
                  </form>
                  <form class="mx-1" action="islemler/ajax.php" method="POST" accept-charset="utf-8">
                    <input type="hidden" name="domain_id" value="<?php echo $domain['domain_id']?>">
                    <button type="submit" name="domainsilme" class="btn btn-danger btn-sm btn-icon-split">
                      <span class="icon text-white-60">
                        <i class="fas fa-trash"></i>
                      </span>
                    </button>
                  </form>
                  <form action="domain.php" method="POST" accept-charset="utf-8">
                    <input type="hidden" name="domain_id" value="<?php echo $domain['domain_id']?>">
                    <button type="submit" name="duzenleme" class="btn btn-primary btn-sm btn-icon-split">
                      <span class="icon text-white-60">
                        <i class="fas fa-eye"></i>
                      </span>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          <?php } ?>            
        </tbody>
      </table>
    </div>
  </div>
</div>
<!--Datatables çıkış-->
</div>

<?php include 'footer.php' ?>
<script src="vendor/datatables/jquery.dataTables.min.js"></script>
<script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

<script>
  $("#musteritablosu").DataTable();
  $("#domaintablosu").DataTable();
</script>
<?php 
if (@$_GET['durum']=="ok") { ?>
  <script type="text/javascript">
    Swal.fire({
      type: 'success',
      title: 'İşlem Başarılı',
      text: 'İşleminiz Başarıyla Gerçekleştirildi',
      confirmButtonText: "Tamam"
    })
  </script>
<?php } ?>


<?php 
if (@$_GET['durum']=="no") { ?>
  <script type="text/javascript">
   Swal.fire({
    type: 'error',
    title: 'Hata',
    text: 'İşleminiz Başarısız Oldu Lütfen Tekrar Deneyin',
    confirmButtonText: "Tamam"
  })
</script>
<?php } ?>