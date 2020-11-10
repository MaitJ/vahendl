<?php
  require("usersession.php");
  require("../../config.php");
  require("fnc_photo.php");
  require("fnc_common.php");
  require("classes/Photoupload_class.php");	
  require("config/config_photo.php");
  
  //kas vajutati salvestusnuppu
  if(isset($_POST["photosubmit"])){
	//var_dump($_POST);
	//var_dump($_FILES);
	$privacy = intval($_POST["privinput"]);
	$alttext = test_input($_POST["altinput"]);
	
	$myphoto = new Photoupload($_FILES["photoinput"], $allowed_photo_types, $fileuploadsizelimit);

	//kas on üldse pilt
	$inputerror .= $myphoto->setImageType();
	
	//ega pole liiga suur fail
	$inputerror .= $myphoto->checkSize();
	
	//genereerime failinime
	$myphoto->generateFileName($filenameprefix);
	
	//kas fail on olemas
	$inputerror .= $myphoto->exists($fileuploaddir_orig);
	
	if(empty($inputerror)){
		//votame kasutusele photoupload klassi

		$myphoto->createImageFromFile();


		//teen väiksemaks
		//loome image objekti ehk pikslikogumi
		//muudame suurust
		//$mynewimage = resizePhoto($mytempimage, $photomaxw, $photomaxh, true);
		$myphoto->resizePhoto($photomaxw, $photomaxh, true);
		$myphoto->addWatermark($watermark);
		//salvestame vähendatud pildi faili
		$result = $myphoto->savePhotoFile($fileuploaddir_normal); 

		if($result == 1){
			$notice .= "Vähendatud pildi salvestamine õnnestus!";
		} else {
			$inputerror .= "Vähendatud pildi salvestamisel tekkis tõrge!";
		}
		
		//pisipilt
		$myphoto->resizePhoto($thumbsize, $thumbsize);
		$result = $myphoto->savePhotoFile($fileuploaddir_thumb);
		if($result == 1){
			$notice .= "Pisipildi salvestamine õnnestus!";
		} else {
			$inputerror .= "Pisipildi salvestamisel tekkis tõrge!";
		}
		

		//kui vigu pole, salvestame originaalpildi
		if(empty($inputerror)){
			if($myphoto->saveOriginalPhoto($fileuploaddir_orig)){
				$notice .= " Originaalpildi salvestamine õnnestus!";
			} else {
				$inputerror .= " Originaalpildi salvestamisel tekkis viga!";
			}
		}
		
		//kui vigu pole, salvestame info andmebaasi
		if(empty($inputerror)){
			$result = $myphoto->storePhotoData($alttext, $privacy);
			if($result == 1){
				$notice .= " Pildi info lisati andmebaasi!";
				$privacy = 1;
				$alttext = null;
			} else {
				$inputerror .= " Pildi info andmebaasi salvestamisel tekkis tõrge!";
			}
		} else {
			$inputerror .= " Tekkinud vigade tõttu pildi andmeid ei salvestatud!";
		}
	}
  }
  
  require("header.php");
?>
  <h1><?php echo $_SESSION["userfirstname"] ." " .$_SESSION["userlastname"]; ?></h1>
  <p>See veebileht on loodud õppetöö käigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
  <p>Leht on loodud veebiprogrammeerimise kursuse raames <a href="http://www.tlu.ee">Tallinna Ülikooli</a> Digitehnoloogiate instituudis.</p>
  <ul>
   <li><a href="home.php">Avalehele</a></li>
   <li><a href="?logout=1">Logi välja</a>!</li>
  </ul>
  <hr>
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
    <label for="photoinput">Vali pildifail!</label>
	<input id="photoinput" name="photoinput" type="file" required>
	<br>
	<label for="altinput">Lisa pildi lühikirjeldus (alternatiivtekst)</label>
	<input id="altinput" name="altinput" type="text" placeholder="Pildi lühikirjeldus ..." value="<?php echo $alttext; ?>">
	<br>
	<label>Määra privaatsustase</label>
	<br>
	<input id="privinput1" name="privinput" type="radio" value="1" <?php if($privacy == 1){echo " checked";} ?>>
	<label for="privinput1">Privaatne (ise näed)</label>
	<input id="privinput2" name="privinput" type="radio" value="2" <?php if($privacy == 2){echo " checked";} ?>>
	<label for="privinput2">Sisseloginud kasutajatele</label>
	<input id="privinput3" name="privinput" type="radio" value="3" <?php if($privacy == 3){echo " checked";} ?>>
	<label for="privinput3">Avalik</label>
	
	<br>
	<input type="submit" name="photosubmit" value="Lae pilt üles">
  </form>
  <p>
  <?php
	echo $inputerror;
	echo $notice;
  ?>
	</p>
  
  <hr>  
</body>
</html>