<?php 
  session_start();
  $username = "";
  $fullTimeNow = date("H:i:s");
  $hourNow = date("H");
  $partofday = "lihtsalt aeg";

  require("fnc_film.php");
 
  require("../../config.php");
  require("fnc_user.php");
  $emailinput = "";
  $passwordinput = "";

  $emailinputerror = "";
  $passwordinputerror = "";

  $result = "";
  if (isset($_POST["signinsubmit"]) and !empty($_POST["signinsubmit"])){
    if (empty($_POST["emailinput"])) {
      $emailinputerror = "Emaili pole sisestatud";
    }
    else {
      $emailinput = $_POST["emailinput"];
    }

    if (empty($_POST["passwordinput"])) {
      $passwordinputerror = "Parooli pole sisestatud";
    }
    else if (strlen($_POST["passwordinput"]) < 8) {
      $passwordinputerror = "Parool on lühem kui 8 tähemärki";
    }

    $emailinput = filter_var($_POST["emailinput"], FILTER_SANITIZE_STRING);
    if (filter_var($_POST["emailinput"], FILTER_VALIDATE_EMAIL) === false) {
      $emailinputerror = "Email ei ole korrektses formaadis";
    }
    else {
      $emailinput = filter_var($_POST["emailinput"], FILTER_VALIDATE_EMAIL);
    }

    if (empty($emailinputerror) and empty($passwordinputerror)) {
      
      $result = signin($emailinput, $_POST["passwordinput"]);

    }
  }


  $weekdayNamesET = ["esmaspäev", "teisipäev", "kolmapäev", "neljapäev", "reede", "laupäev", "pühapäev"];
  $monthNamesET = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];

  $weekdaynow = date("N");
  $monthnow = date("n");

  //loeme kataloogist piltide nimekirja
  $allfiles = scandir("vp_pics/");
  //var_dump($allfiles);
  $picfiles = array_slice($allfiles, 2);
  $imghtml = "";
  $piccount = count($picfiles);
  $picnumber = rand(0, ($piccount - 1));

  $imghtml .='<img src="vp_pics/' . $picfiles[$picnumber] . '" alt="Tallinna Ylikool">';

  /* 
  for ($i = 0; $i < $piccount; $i++) {
    $imghtml .= '<img src="vp_pics/' . $picfiles[$i] . '" alt="Tallinna Ylikool">';
  }
  */
  

  $haugiPildiArray = array(
    0 => "../pics/haug.jpeg",
    1 => "../pics/haug2.jpg"
  );


  if ($hourNow < 7) {
    $partofday = "uneaeg";
  }

  if ($hourNow >= 8 && $hourNow < 18) {
    $partofday = "akadeemilise aktiivsuse aeg";
  }

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
      <h3 id="mainHeader">See leht on veebiprogemise kursuse alusel tehtud, midagi t2htsat siin ei ole</h3>
      <h3 id="mainHeader">Lehe avamisel oli hetkel kell: <?php echo $weekdayNamesET[$weekdaynow - 1]. " " . date("j") . ". " . $monthNamesET[$monthnow - 1] . " " . $fullTimeNow?></h3>
      <h4 id="mainHeader"><?php echo $semestriMessage?></h3>
      <img src="img/vp_banner.png" alt="Veebiprogrammeerimise logo">
    </header>
    <?php require('defnavbar.php'); ?>
    <div id="content">
    <form method="POST" id="registerform">
      <label for="emailinput">Email: </label>
      <input type="email" id="emailinput" name="emailinput" placeholder="Sinu email" value="<?php echo $emailinput?>">
      <span><?php echo $emailinputerror; ?></span>
      <label for="passwordinput">Parool: </label>
      <input type="password" id="passwordinput" name="passwordinput" placeholder="Sinu parool">
      <span><?php echo $passwordinputerror; ?></span>
      <input type="submit" name="signinsubmit" value="Logi sisse">
      <span><?php echo $result; ?></span>
    </form>
    </div>
    <footer>
      <h4>See veebileht on tehtud Mait Jurask'i poolt.</h4>
      <h4><?php echo "Parajasti on " .$partofday ."." ?></h4>
    </footer>
 </div>
</body>
</html>
