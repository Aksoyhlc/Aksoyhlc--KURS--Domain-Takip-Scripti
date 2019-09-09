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
			<h6>Müşteri Detay</h6>
		</div>
		<div class="card-body">
			<form>
				<div class="form-row">
					<div class="col-md-6 form-group">
						<label>Müşteri isim</label>
						<input disabled="" type="text" class="form-control" name="musteri_isim" value="<?php echo $musteribilgisi['musteri_isim'] ?>">
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-6 form-group">
						<label>Müşteri Telefon</label>
						<input disabled=""  type="text" class="form-control" name="musteri_telefon" value="<?php echo $musteribilgisi['musteri_telefon'] ?>">
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-6 form-group">
						<label>Müşteri E-Mail</label>
						<input disabled=""  type="email" class="form-control" name="musteri_mail" value="<?php echo $musteribilgisi['musteri_mail'] ?>">
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-6 form-group">
						<label>Müşteri Detay</label>
						<textarea id="editor" disabled=""  name="musteri_detay" class="form-control"><?php echo $musteribilgisi['musteri_detay'] ?></textarea>
					</div>
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
