<?php include 'header.php'; 

if (isset($_POST['musteri_id'])) {
  $sorgu=$db->prepare("SELECT * FROM musteri WHERE musteri_id=:musteri_id");
  $sorgu->execute(array(
    'musteri_id' => $_POST['musteri_id']
  ));
  $musteribilgisi=$sorgu->fetch(PDO::FETCH_ASSOC);
} else {
  header("location:musteriler.php");
  exit;
}


?>

<div class="container">
  <div class="card">
    <div class="card-header">
      <h6>Müşteri Düzenle</h6>
    </div>
    <div class="card-body">
      <form action="islemler/ajax.php" method="POST" accept-charset="utf-8">
        <div class="form-row">
          <div class="col-md-6 form-group">
            <label>Müşteri isim</label>
            <input type="text" class="form-control" name="musteri_isim" value="<?php echo $musteribilgisi['musteri_isim'] ?>">
          </div>
        </div>
        <div class="form-row">
          <div class="col-md-6 form-group">
            <label>Müşteri Telefon</label>
            <input type="text" class="form-control" name="musteri_telefon" value="<?php echo $musteribilgisi['musteri_telefon'] ?>">
          </div>
        </div>
        <div class="form-row">
          <div class="col-md-6 form-group">
            <label>Müşteri E-Mail</label>
            <input type="email" class="form-control" name="musteri_mail" value="<?php echo $musteribilgisi['musteri_mail'] ?>">
          </div>
        </div>
        <div class="form-row">
          <div class="col-md-6 form-group">
            <label>Müşteri Detay</label>
            <textarea id="editor" name="musteri_detay" class="form-control"><?php echo $musteribilgisi['musteri_detay'] ?></textarea>
          </div>
        </div>
        <input type="hidden" name="musteri_id" value="<?php echo $musteribilgisi['musteri_id']?>">
        <div class="form-row">
          <button type="submit" class="btn btn-primary" name="musteriguncelle">Kaydet</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php include 'footer.php' ?>

<script src="vendor/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
  CKEDITOR.replace("editor")
</script>
