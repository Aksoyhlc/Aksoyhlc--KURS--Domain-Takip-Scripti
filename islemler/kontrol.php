<?php 
require 'baglan.php';
$host_adresi=$ayarcek['site_mail_host'];
$mail_adresiniz=$ayarcek['site_mail_mail'];
$port_numarasi=$ayarcek['site_mail_port'];
$mail_sifreniz=$ayarcek['site_mail_sifre'];


require_once 'PHPMailer/Exception.php';
require_once 'PHPMailer/PHPMailer.php';
require_once 'PHPMailer/SMTP.php';

$mailbasligi="Domain Hatırlatma Maili";
$isim=$ayarcek['site_baslik'];

$username   = '000000000';
$password   = '123456789';
$orgin_name = 'APITEST';

function sendRequest($site_name,$send_xml,$header_type) {

    	//die('SITENAME:'.$site_name.'SEND XML:'.$send_xml.'HEADER TYPE '.var_export($header_type,true));
    	$ch = curl_init();
    	curl_setopt($ch, CURLOPT_URL,$site_name);
    	curl_setopt($ch, CURLOPT_POST, 1);
    	curl_setopt($ch, CURLOPT_POSTFIELDS,$send_xml);
    	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,1);
    	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    	curl_setopt($ch, CURLOPT_HTTPHEADER,$header_type);
    	curl_setopt($ch, CURLOPT_HEADER, 0);
    	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    	curl_setopt($ch, CURLOPT_TIMEOUT, 120);

    	$result = curl_exec($ch);

    	return $result;
}

$mail = new PHPMailer\PHPMailer\PHPMailer(); 
$mail->IsSMTP(); 
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'ssl'; 
$mail->Host = $host_adresi;
$mail->Port = $port_numarasi; 
$mail->IsHTML(true);
$mail->Username = $mail_adresiniz;
$mail->Password = $mail_sifreniz; 
$mail->SetFrom($mail->Username, $isim);	
$mail->Subject = $mailbasligi;
$mail->CharSet = 'UTF-8';

$sorgu=$db->prepare("SELECT * FROM domain");
$sorgu->execute();

while ($domaincek=$sorgu->fetch(PDO::FETCH_ASSOC)) {
	$tarih1=strtotime(date("d.m.Y"));
	$tarih2=strtotime($domaincek['domain_bitis']);
	$fark=$tarih2-$tarih1;
	$sonuc= floor($fark / (60*60*24));


	if ($sonuc=="-1" OR $sonuc==1 OR $sonuc==2 OR $sonuc==3 OR $sonuc==4  OR $sonuc==5  OR $sonuc==6  OR $sonuc==7  OR $sonuc==15  OR $sonuc==30) {	
		$domain_id=$domaincek['domain_id'];
		$bitis_tarihi=$domaincek['domain_bitis'];
		$kalangun=$sonuc;

		$sorgu=$db->prepare("SELECT * FROM musteri WHERE musteri_id=:musteri_id");
		$sorgu->execute(array(
			'musteri_id' => $domaincek['domain_musteri']
		));
		$mustericek=$sorgu->fetch(PDO::FETCH_ASSOC);

		$musteri_mail=$mustericek['musteri_mail'];
		$musteri_telefon=$mustericek['musteri_telefon'];

		$mailicerigi="Sayın ".$mustericek['musteri_isim']." ".$domaincek['domain_adi']." isimli alan adınızın kullanım süresi ".$kalangun." gün içerisinde dolacaktır. Alan adınızı kullanmak istiyorsanız yenilemeyi unutmayın";
		$mail->Body = $mailicerigi;

		$mail->AddAddress($ayarcek['site_sahip_mail']);
		$mail->AddAddress($mustericek['musteri_mail']);

		if ($mail->send()) {
			echo "Başarılı";
		} else {
			echo "Başarısız<br>";
			echo $mail->ErrorInfo;
		}

	}


	if ($sonuc=="-1" OR $sonuc==1 OR $sonuc==7  OR $sonuc==15) {	
		$numara=$mustericek['musteri_telefon'];
		$mesajdetayi="Sayın ".$mustericek['musteri_isim']." ".$domaincek['domain_adi']." domaininizin kullanım süresi ".$kalangun." gün içerisinde dolacaktır. Yenilemeyi unutmayın";



$xml = <<<EOS
   		 <request>
   			 <authentication>
   				 <username>{$username}</username>
   				 <password>{$password}</password>
   			 </authentication>

   			 <order>
   	    		 <sender>{$orgin_name}</sender>
   	    		 <message>
   	        		 <text>{$mesajdetayi}</text>
   	        		 <receipents>
   	            		 <number>{$numara}</number>
   	        		 </receipents>
   	    		 </message>
   			 </order>
   		 </request>
EOS;


$result = sendRequest('http://api.iletimerkezi.com/v1/send-sms',$xml,array('Content-Type: text/xml'));
die('<pre>'.var_export($result,1).'</pre>');
//Donen xml degerini sisteminizde parse etmek icin
//http://www.lalit.org/lab/convert-xml-to-array-in-php-xml2array/
//adresindeki kutuphaneyi oneririz
	}
}



?>