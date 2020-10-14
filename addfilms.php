<?php
  require("usersession.php");
 
  $username = "Mait Jurask";
  $fullTimeNow = date("H:i:s");
  $hourNow = date("H");
  $partofday = "lihtsalt aeg";
  require("../../config.php");
  require("fnc_film.php");
  
  $inputerror = "";
  $filmhtml = "";
  //Kas vajutati submit nuppu
  if (isset($_POST["filmsubmit"])) {
	if (empty($_POST["titleinput"]) or empty($_POST["genreinput"]) or empty($_POST["studioinput"]) or empty($_POST["directorinput"])){
	$inputerror .= "Osa infost on sisestamata!";
   } 	
  if ($_POST["yearinput"] < 1895 or $_POST["yearinput"] > date("Y")){
	$inputerror .= "Ebareaalne valmimisaasta";
   }
   if (empty($inputerror)) {
	$storeinfo = storefilminfo($_POST["titleinput"], $_POST["yearinput"], $_POST["durationinput"], $_POST["genreinput"], $_POST["studioinput"], $_POST["directorinput"]);
	
   if ($storeinfo == 1) {
	$filmhtml = readfilms(1);
    } else {
	$filmhtml = "<p>Kahjuks filmi info salvestamine seekord eba6nnestus</p>";
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
	<form method="POST" id="filmiform">
		<label for="titleinput">Filmi pealkiri</label>
		<input type="text" name="titleinput" id="titleinput" placeholder="Pealkiri"> 
		<label for="yearinput">Filmi aasta</label>
		<input type="number" name="yearinput" id="yearinput" value="<?php echo date("Y")?>"> 
		<label for="durationinput">Filmi kestus</label>
		<input type="number" name="durationinput" id="durationinput" value="90"> 
		<label for="genreinput">Filmi zanr</label>
		<input type="text" name="genreinput" id="genreinput" placeholder="Filmi zanr"> 
		<label for="studioinput">Filmi tootja</label>
		<input type="text" name="studioinput" id="studioinput" placeholder="Filmi tootja"> 
		<label for="direcotrinput">Filmi lavastaja</label>
		<input type="text" name="directorinput" id="directorinput" placeholder="Filmi lavastaja"> 
		<br>
		<input type="submit" name="filmsubmit" value="Salvesta filmi info">
	</form>
    </div>
    <?php echo $inputerror;?>
    <footer>
      <h4>See veebileht on tehtud Mait Jurask'i poolt.</h4>
      <h4><?php echo "Parajasti on " .$partofday ."." ?></h4>
    </footer>
 </div>
</body>
</html>
