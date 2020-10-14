<?php
  require("usersession.php");
 
  $username = "Mait Jurask";
  $fullTimeNow = date("H:i:s");
  $hourNow = date("H");
  $partofday = "lihtsalt aeg";

  $database = "if20_mait_ju_1";
 
  require("../../config.php");
  if (isset($_POST["ideasubmit"]) and !empty($_POST["ideainput"])) {
	//Loome andmebaasiga yhenduse
	$conn = new mysqli($serverhost, $serverusername, $serverpassword, $database);	
	//Valmistan ette sql k2su andmete kirjutamiseks
	$stmt = $conn->prepare("INSERT INTO myideas (idea) VALUES (?)");
	echo $conn->error;

	//i - integer, d -decimal, s -string
	$stmt->bind_param("s", $_POST["ideainput"]);
	$stmt->execute();
	$stmt->close();
	$conn->close();
  }
 
  //Loen andmebaasist senised m6tted

  $ideahtml = "";
  $conn = new mysqli($serverhost, $serverusername, $serverpassword, $database);	
  $stmt = $conn->prepare("SELECT idea FROM myideas");
  //Seon tulemuse muutujaga
  $stmt->bind_result($ideafromdb);
  $stmt->execute();
  while ($stmt->fetch()) {
	$ideahtml .= "<p>" . $ideafromdb . "</p>";
  }
  $stmt->close();
  $conn->close();


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
  

  // selgitage välja nende vahe ehk erinevus
  // $semesterDuration = $semesterStart->diff($semesterEnd);

  // leiame selle p2evade arvu
  // $semesterDurationDays = $semesterDuration->format("%r%a");

  
  // if ($fromsemesterstartdays < 0) { semester ple alanud }
  // if ($semesterstartdays >= $semesterDurationDays)
  // mitu % õppetööst on tehtud



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
    </div>
    <?php echo $ideahtml;?> 
    <footer>
      <h4>See veebileht on tehtud Mait Jurask'i poolt.</h4>
      <h4><?php echo "Parajasti on " .$partofday ."." ?></h4>
    </footer>
 </div>
</body>
</html>
