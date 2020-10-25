<?php
  require("usersession.php");
 
  $username = "Mait Jurask";
  $fullTimeNow = date("H:i:s");
  $hourNow = date("H");
  $partofday = "lihtsalt aeg";
  require("../../config.php");


  $weekdayNamesET = ["esmaspäev", "teisipäev", "kolmapäev", "neljapäev", "reede", "laupäev", "pühapäev"];
  $monthNamesET = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];

  $weekdaynow = date("N");
  $monthnow = date("n");

  require("fnc_filmrelations.php");

  $personinputerror = "";
  $filminputerror = "";
  $positioninputerror = "";
  $roleinputerror = "";
  $moviestudioselecterror = "";
  $quoteinputerror = "";

  $personinputvalue = 0;
  $filminputvalue = 0;
  $positioninputvalue = 0;
  $roleinputvalue = "";
  $studionotice = "";
  $genrenotice = "";
  $filminput2value = "";

  $selectedstudio = "";
  $selectedgenre = "";
  $selected = "";

  $notice = "";
  



  if (isset($_POST["relationsubmit"])) {
    if (empty($_POST["personinput"])) {
      $personinputerror = "Vali inimene.";
    }
    else {
      $personinputvalue = intval($_POST["personinput"]);
    }

    if (empty($_POST["filminput"])) {
      $filminputerror = "Vali film.";
    }
    else {
      $filminputvalue = intval($_POST["filminput"]);
    }

    if (empty($_POST["positioninput"])) {
      $positioninputerror = "Vali positsioon!";
    }
    else {
      $positioninputvalue = intval($_POST["positioninput"]);
    }

    if (empty($_POST["roleinput"])) {
      $roleinputerror = "Vali roll!";
    }
    else {
      $roleinputvalue = $_POST["roleinput"];
    }

    if (empty($personinputerror) and empty($filminputerror) and empty($positioninputerror) and empty($roleinputerror)) {
      $notice = storenewrelation($personinputvalue, $filminputvalue, $positioninputvalue, $roleinputvalue);
    }

  }
  
  $personoptionhtml = readpersonoptionshtml($personinputvalue);
  $filmoptionhtml = readfilmoptionshtml($filminputvalue);
  $positionoptionhtml = readpositionoptionshtml($positioninputvalue);
  $moviestudioselecthtml = readstudiotoselect($selectedstudio);
  $filmoptionhtml2 = readfilmoptionshtml($filminput2value);
  $moviegenreselecthtml = readgenre($selectedgenre);
  $quoteselecthtml = "";

  $filminput2value = 0;
  $filminput2error = "";
  $filmgenrevalue = 0;
  $filmgenreerror = "";
  $notice2 = 0;

  /*if (isset($_POST["filmgenrerelationsubmit"])) and !empty($_POST["relationsubmitgenre"])) {

    if (!empty($_POST["filminput2"])) {
      $filminput2value = $_POST["filminput2"];
    }
    else {
      $filminput2error = "Vali film";
    }

    if (!empty($_POST["filmgenreinput"])) {
     $filmgenrevalue = $_POST["filmgenreinput"];
    }
    else {
      $filmgenreerror = "Vali zanr";
    }

    if (!empty($filminput2value) and !empty($filmgenreinput)) {
      $notice2 = storenewgenrerelation($selectedmovie, $selectedgenre);  //POOLELI
    }
  } */

  if(isset($_POST["filmgenrerelationsubmit"])){
    if(!empty($_POST["filminput"])){
      $selectedmovie = intval($_POST["filminput"]);
    } else {
      $genrenotice = " Vali film!";
    }

    if(!empty($_POST["filmgenreinput"])){
      $selectedgenre = intval($_POST["filmgenreinput"]);
    } else {
      $genrenotice .= " Vali žanr!";
    }

    if(!empty($selectedmovie) and !empty($selectedgenre)){
      $genrenotice = storenewgenrerelation($selectedmovie, $selectedgenre);
    }
  }
  
  

  if(isset($_POST["filmstudiorelationsubmit"])) {
    if(!empty($_POST["filminput"])){
      $selectedmovie = intval($_POST["filminput"]);
    } else {
        $studionotice = " Vali film!";
    }
  
    if(!empty($_POST["filmstudioinput"])){
      $selectedstudio = intval($_POST["filmstudioinput"]);
    } else {
      $studionotice = " Vali stuudio!";
    }
  
    if (!empty($selectedmovie) and !empty($selectedstudio)) {
      $studionotice = storenewstudiorelation($selectedmovie, $selectedstudio);
    }
  }

  /*if (isset($_POST["relationsubmitgenre"]) and !empty($_POST["relationsubmitgenre"])) {

    if (!empty($_POST["filminput2"])) {
      $filminput2value = $_POST["filminput2"];
    }
    else {
      $filminput2error = "Vali film";
    }

    if (!empty($_POST["filmgenreinput"])) {
     $filmgenrevalue = $_POST["filmgenreinput"];
    }
    else {
      $filmgenreerror = "Vali zanr";
    }

    if (!empty($filminput2value) and !empty($filmgenrevalue)) {
      $notice2 = storenewgenrerelation($selectedmovie, $selectedgenre);
    }
  } */

  
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
    <h4>Inimeste ja filmide kirje loomine</h4>
    <form id="registerform" method="POST">
      <label for="personinput">Inimene: </label>
      <select name="personinput" id="personinput">
        <?php echo $personoptionhtml; ?> 
      </select>
      <span><?php echo $personinputerror;?></span>
      <label for="filminput">Film: </label>
      <select name="filminput" id="filminput">
        <?php echo $filmoptionhtml; ?>
      </select>
      <span><?php echo $filminputerror; ?></span>
      <label for="positioninput">Positsioon: </label>
      <select name="positioninput" id="positioninput">
        <?php echo $positionoptionhtml; ?>
      </select>
      <span><?php echo $positioninputerror; ?></span>
      <label for="roleinput">Roll: </label>
      <input type="text" name="roleinput" id="roleinput" placeholder="Sisesta roll">
      <span><?php echo $roleinputerror; ?></span>
      <input type="submit" name="relationsubmit" value="Loo seos"><span><?php echo $notice; ?></span>
    </form>
    <hr>
    <h4>Filmi zanri kirje loomine</h4>
    <form method="POST" id="registerform">
    <label for="filminput">Filmi nimi:</label>
    <select name="filminput" id="filminput">
      <?php echo $filmoptionhtml2; ?>
    </select>
    <span><?php echo $filminput2error; ?></span>
    <label for="filmgenreinput">Filmi zanr:</label>
      <?php echo $moviegenreselecthtml; ?>
    <span><?php echo $filmgenreerror; ?></span>
<<<<<<< HEAD
    <input type="submit" name="filmgenrerelationsubmit" value="Loo seos"><span><?php echo $genrenotice; ?></span>
    </form>
    <h4>Filmi stuudio kirje loomine</h4>
    <form method="POST" id="registerform">
    <label for="filminput">Filmi nimi:</label>
    <select name="filminput" id="filminput">
      <?php echo $filmoptionhtml2; ?>
    </select>
    <span><?php echo $filminput2error; ?></span>
    <label for="filmstudioinput">Stuudio:</label>
      <?php echo $moviestudioselecthtml; ?>
    <span><?php echo $moviestudioselecterror; ?></span>
    <input type="submit" name="filmstudiorelationsubmit" value="Loo seos"><span><?php echo $studionotice; ?></span>
    </form>
    <h4>Näitleja tsitaadi kirje loomine</h4>
    <form method="POST" id="registerform">
    <label for="filminput2">Filmi nimi:</label>
    <select name="filminput2" id="filminput2">
      <?php echo $filmoptionhtml2; ?>
    </select>
    <span><?php echo $filminput2error; ?></span>
    <label for="personinput">Inimene: </label>
      <select name="personinput" id="personinput">
        <?php echo $personoptionhtml; ?> 
      </select>
      <span><?php echo $personinputerror;?></span>
    <label for="quoteinput">Tsitaat:</label>
    <input type="text" name="quoteinput" id="quoteinput" placeholder="Sisesta tsitaat">
    <span><?php echo $quoteinputerror; ?></span>
    <input type="submit" name="quoterelationsubmit" value="Loo seos">
=======
    <input type="submit" name="relationsubmitgenre" value="Loo seos">
    <p><?php echo $notice2; ?></p>
    <br>
>>>>>>> 4e8f09403c2b1b8a21b1ee07e7841554f3040e84
    </form>
    </div>
    <footer>
      <h4>See veebileht on tehtud Mait Jurask'i poolt.</h4>
      <?php echo $notice; ?>
      <h4><?php echo "Parajasti on " .$partofday ."." ?></h4>
    </footer>
 </div>
</body>
</html>
