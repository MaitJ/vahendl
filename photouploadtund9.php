<?php
  require("usersession.php");
 
  $username = "Mait Jurask";
  $fullTimeNow = date("H:i:s");
  $hourNow = date("H");
  $partofday = "lihtsalt aeg";
  require("../../config.php");
  require("fnc_film.php");
  
  $inputerror = "";
  $notice = "";
  $fileuploadsizelimit = 1048576;
  $filename = "";
  $filenameprefix = "vp_";
  $fileuploaddir_orig = "photoupload_orig/";
  $fileuploaddir_normal = "photoupload_normal/";
  $photomaxw = 600;
  $photomaxh = 400;
  
  //Kas vajutati submit nuppu
  if (isset($_POST["photosubmit"])) {
    $check = getimagesize($_FILES["photoinput"]["tmp_name"]);

    if ($check !== false) {
      if ($check["mime"] == "image/jpeg") {
        $filetype = "jpg";
      }
      else if ($check["mime"] == "image/png") {
        $filetype = "png";
      }
      else if ($check["mime"] == "image/gif") {
        $filetype = "gif";
      }
    }
    else {
      $inputerror .= "Valitud fail ei ole pilt";
    }

    //Ega pole liiga suur fail
    if ($_FILES["photoinput"]["size"] > $fileuploadsizelimit) {
      $inputerror .= " Valitud fail on liiga suur";
    }

    //Genereerime failinime
    $timestamp = microtime(1) * 10000;
    $filename = $filenameprefix . $timestamp . "." . $filetype;


    //Kas fail on olemas
    if (file_exists("photoupload_orig/" . $filename)) {
      $inputerror .= " Selline fail on olemas";
    }

    if (empty($inputerror)) {
      //Teen pildi v2iksemaks
      //Loome image objekti ehk pikslikogumi

      if ($filetype == "jpg") {
        $mytempimg = imagecreatefromjpeg($_FILES["photoinput"]["tmp_name"]);
      }
      if ($filetype == "png") {
        $mytempimg = imagecreatefrompng($_FILES["photoinput"]["tmp_name"]);
      }
      if ($filetype == "gif") {
        $mytempimg = imagecreatefromgif($_FILES["photoinput"]["tmp_name"]);
      }
      //Pildi originaal suurus
      $imagew = imagesx($mytempimg);
      $imageh = imagesy($mytempimg);

      //Kas l2htuda laiusest v6i k6rgusest
      if ($imagew / $photomaxw > $imageh / $photomaxh) {
        $photosizeratio = $imagew / $photomaxw;
      }
      else {
        $photosizeratio = $imageh / $photomaxh;
      }

      $neww = round($imagew / $photosizeratio);
      $newh = round($imageh / $photosizeratio);

      //Loon uue suurusega pildi objekti

      $mynewtempimage = imagecreatetruecolor($neww, $newh);
      //S2ilitamaks png piltide l2bipaistvat osa
      imagesavealpha($mynewtempimage, true);
      $transparentcolor = imagecolorallocatealpha($mynewtempimage, 0,0,0,127);
      imagefill($mynewtempimage, 0, 0, $transparentcolor);

      imagecopyresampled($mynewtempimage, $mytempimg, 0, 0, 0, 0, $neww, $newh, $imagew, $imageh);

      //V2hendatud pilt faili
      if ($filetype == "jpg") {
        if (imagejpeg($mynewtempimage, $fileuploaddir_normal . $filename, 90)) {
          $notice .= " V2hendatud pildi salvestamine 6nnestus";
        }
        else {
          $notice .= "V2hendatud pildi salvestamine eba6nnestus";
        }
      }
      if ($filetype == "png") {
        if (imagepng($mynewtempimage, $fileuploaddir_normal . $filename, 6)) {
          $notice .= " V2hendatud pildi salvestamine 6nnestus";
        }
        else {
          $notice .= "V2hendatud pildi salvestamine eba6nnestus";
        }
      }
      if ($filetype == "gif") {
        if (imagegif($mynewtempimage, $fileuploaddir_normal . $filename)) {
          $notice .= " V2hendatud pildi salvestamine 6nnestus";
        }
        else {
          $notice .= "V2hendatud pildi salvestamine eba6nnestus";
        }
      }
      imagedestroy($mynewtempimage);
      imagedestroy($mytempimg);



      if (move_uploaded_file($_FILES["photoinput"]["tmp_name"], $fileuploaddir_orig . $filename)) {
        $notice .= " originaalpildi yleslaadimine 6nnestus!";
      }
      else {
        $notice .= " originaalpildi yleslaadimisel tekkis viga!";
      }
    }
  } 



  $weekdayNamesET = ["esmaspäev", "teisipäev", "kolmapäev", "neljapäev", "reede", "laupäev", "pühapäev"];
  $monthNamesET = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];

  $weekdaynow = date("N");
  $monthnow = date("n");


  //vaatame semestri kulgemist
  $semesterStart = new DateTime("2020-08-31");
  $semesterEnd = new DateTime("2020-12-13");
  $today = new DateTime("now");

  $semesterStartToToday = $semesterStart->diff($today);
  $toSemesterEnd = $today->diff($semesterEnd);
  $semesterDuration = $semesterStart->diff($semesterEnd);

  // Alati formati vahe 2ra, muidu ei teki numbri tyypi, millega v6rrelda
  $semesterStartDays = $semesterStartToToday->format("%r%a");
  $semesterDurationDays = $semesterDuration->format("%r%a");
  $daysToSemesterEnd = $toSemesterEnd->format("%r%a");


  if ($hourNow < 7) {
    $partofday = "uneaeg";
  }

  if ($hourNow >= 8 && $hourNow < 18) {
    $partofday = "akadeemilise aktiivsuse aeg";
  }

  $semestriMessage = 0;

  if ($semesterStartDays < 0) {
      $semestriMessage =  "Semester pole veel alanud";
  } else if ($semesterStartDays <= $semesterDurationDays) {
      $percentToEnd = ($semesterStartDays * 100) / $semesterDurationDays;
      $semestriMessage = "Semestri l6puni on: " . $daysToSemesterEnd . " p2eva " . " 6ppet88st on tehtud: " . round($percentToEnd, 1) . "%";
  } else {
      $semestriMessage =  "Semester on l6ppenud";
  }
  
 require("header.php");
 ?>

  <div id="contentLocker">
    <header>
      <h1 id="mainHeader">Gheto Kalawiki</h1>
      <h3 id="mainHeader">Tere tulemast <?php echo $_SESSION["userfirstname"] . " " . $_SESSION["userlastname"] ?></h3>
      <h3 id="mainHeader">See leht on veebiprogemise kursuse alusel tehtud, midagi t2htsat siin ei ole</h3>
      <h3 id="mainHeader">Lehe avamisel oli hetkel kell: <?php echo $weekdayNamesET[$weekdaynow - 1]. " " . date("j") . ". " . $monthNamesET[$monthnow - 1] . " " . $fullTimeNow?></h3>
      <h4 id="mainHeader"><?php echo $semestriMessage?></h3>
      <img src="img/vp_banner.png" alt="Veebiprogrammeerimise logo">
    </header>
    <?php require('navbar.php'); ?>
    <div id="content">
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
    <label for="photoinput">Vali pildi fail</label>
    <input id="photoinput" name="photoinput" type="file" required>
    <br>
    <label for="altinput">Lisa pildi lyhikirjeldus (alternatiivtekst)</label>
    <input id="altinput" name="altinput" type="text" placeholder="Pildi lyhikirjeldus">
		<br>
    <label>M22ra privaatsustase:</label>
    <br>
    <input id="privinput1" name="privinput" type="radio" value=1>
    <label for="privinput1">Privaatne (Ainult sinule n2htav)</label>
    <br>
    <input id="privinput2" name="privinput" type="radio" value=2>
    <label for="privinput2">Privaatne (Ainult sisselogitud kasutajatele)</label>
    <br>
    <input id="privinput3" name="privinput" type="radio" value=3>
    <label for="privinput3">Avalik</label>
    <br>
		<input type="submit" name="photosubmit" value="Lae pilt yles">
	</form>
  <p><?php echo $inputerror;
           echo $notice;
      ?></p>

    </div>
    <footer>
      <h4>See veebileht on tehtud Mait Jurask'i poolt.</h4>
      <h4><?php echo "Parajasti on " .$partofday ."." ?></h4>
    </footer>
 </div>
</body>
</html>
