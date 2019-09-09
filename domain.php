<?php require 'header.php'; 
$sorgu=$db->prepare("SELECT * FROM domain WHERE domain_id=:domain_id");
$sorgu->execute(array(
	'domain_id' => $_POST['domain_id']
));
$domain=$sorgu->fetch(PDO::FETCH_ASSOC);

?>

<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h5 class="font-weight-bold text-primary">Domain Detay</h5>
				</div>
				<div class="card-body">			
					<form>
						<div class="form-row">
							<div class="col-md-4 form-group">
								<label>Domain Adı</label>
								<input disabled="" type="text" name="domain_adi" class="form-control" placeholder="Domain Adı" value="<?php echo $domain['domain_adi'] ?>">
							</div>
							<div class="col-md-4 form-group">
								<label>Domain Müşteri</label>
								<select disabled="" name="domain_musteri" class="form-control">
									<?php 
									$sorgu=$db->prepare("SELECT * FROM musteri");
									$sorgu->execute();
									while ($musteri=$sorgu->fetch(PDO::FETCH_ASSOC)) { ?>
										<option <?php if($domain['domain_musteri']==$musteri['musteri_id']){echo "selected";} ?> value="<?php echo $musteri['musteri_id'] ?>"><?php echo $musteri['musteri_isim'] ?></option>
									<?php }	?>
									
								</select>
							</div>
							<div class="col-md-4 form-group">
								<label>Domain Başlangıç Tarihi</label>
								<input disabled="" type="date" name="domain_baslangic" class="form-control" placeholder="Domain Başlangıç Tarihi" value="<?php echo $domain['domain_baslangic'] ?>">
							</div>
						</div>

						<div class="form-row">
							<div class="col-md-4 form-group">
								<label>Kayıt Firması</label>
								<input disabled="" type="text" name="domain_kayit_firmasi" class="form-control" placeholder="Kayıt Firması" value="<?php echo $domain['domain_kayit_firmasi'] ?>">
							</div>
							<div class="col-md-4 form-group">
								<label>Domain Bitiş Tarihi</label>
								<input disabled="" type="date" name="domain_bitis" class="form-control" placeholder="Domain Bitiş Tarihi" value="<?php echo $domain['domain_bitis'] ?>">
							</div>
							<div class="col-md-4 form-group">
								<label>Domain Fiyat</label>
								<input disabled="" type="text" name="domain_fiyat" class="form-control" placeholder="Domain Fiyat" value="<?php echo $domain['domain_fiyat'] ?>">
							</div>
						</div>
					</form>		
				</div>
			</div>
		</div>
	</div>
</div>

<?php require 'footer.php'; ?>