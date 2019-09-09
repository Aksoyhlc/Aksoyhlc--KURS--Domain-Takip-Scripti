<?php require 'header.php'; ?>

<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h5 class="font-weight-bold text-primary">Domain Ekle</h5>
				</div>
				<div class="card-body">			
					<form action="islemler/ajax.php" method="POST" accept-charset="utf-8">
						<div class="form-row">
							<div class="col-md-4 form-group">
								<label>Domain Adı</label>
								<input type="text" name="domain_adi" class="form-control" placeholder="Domain Adı">
							</div>
							<div class="col-md-4 form-group">
								<label>Domain Müşteri</label>
								<select name="domain_musteri" class="form-control" id="musterilistesi" onchange="musterisecme()">
									<?php 
									$sorgu=$db->prepare("SELECT * FROM musteri");
									$sorgu->execute();
									while ($musteri=$sorgu->fetch(PDO::FETCH_ASSOC)) { ?>
										<option value="<?php echo $musteri['musteri_id'] ?>"><?php echo $musteri['musteri_isim'] ?></option>
									<?php }	?>
									<option value="musteri_ekle">Müşteri Ekle</option>
								</select>
							</div>
							<div class="col-md-4 form-group">
								<label>Domain Başlangıç Tarihi</label>
								<input type="date" name="domain_baslangic" class="form-control" placeholder="Domain Başlangıç Tarihi">
							</div>
						</div>

						<div class="form-row">
							<div class="col-md-4 form-group">
								<label>Kayıt Firması</label>
								<input type="text" name="domain_kayit_firmasi" class="form-control" placeholder="Kayıt Firması">
							</div>
							<div class="col-md-4 form-group">
								<label>Domain Bitiş Tarihi</label>
								<input type="date" name="domain_bitis" class="form-control" placeholder="Domain Bitiş Tarihi">
							</div>
							<div class="col-md-4 form-group">
								<label>Domain Fiyat</label>
								<input type="text" name="domain_fiyat" class="form-control" placeholder="Domain Fiyat">
							</div>
						</div>
						<button type="submit" class="btn btn-primary" name="domainekle">Kaydet</button>
					</form>		
				</div>
			</div>
		</div>
	</div>
</div>

<?php require 'footer.php'; ?>

<script type="text/javascript">
	function musterisecme() {
		var musterilistesi=document.getElementById("musterilistesi");
		var secilendeger=musterilistesi.options[musterilistesi.selectedIndex].value;
		if (secilendeger=="musteri_ekle") {
			Swal.fire({
				title:"Emin Misiniz?",
				text:"Müşteri Ekleme Sayfasına Yönlendirilmek İstediğinize Emin Misiniz? Bu sayfada ki veriler kaybolacaktır.",
				type: "warning",
				showCancelButton:true,
				confirmButtonColor:"green",
				cancelButtonColor:"red",
				confirmButtonText:"Evet,Yönlendir",
				cancelButtonText:"Hayır, Bekle"

			}).then((result) => {
				if (result.value) {
					window.location="musteriekle.php"
				}
			}

			)
		}
	}
</script>