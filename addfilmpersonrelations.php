<?php
  require("usersession.php");
 
  $username = "Mait Jurask";
  $fullTimeNow = date("H:i:s");
  $hourNow = date("H");
  $partofday = "lihtsalt aeg";
  require("../../config.php");


  $weekdayNamesET = ["esmaspäev", "teisipäev", "kolmapäev", "neljapäev", "reede", "laupäev", "pühapäev"];
  $monthNamesET = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];
  $monthnameset = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];

  $weekdaynow = date("N");
  $monthnow = date("n");

  require("fnc_filmrelations.php");

  $birthyear = 0;
  $birthmonth = 0;
  $birthday = 0;

  $personinputerror = "";
  $filminputerror = "";
  $positioninputerror = "";
  $roleinputerror = "";
  $moviestudioselecterror = "";
  $quoteinputerror = "";
  $andmedinputerror = "";
  $personinputerror = "";
  $birthdateerror = "";
  $birthdayerror = "";
  $birthmontherror = "";
  $birthyearerror = "";
  $moviestudioinputerror = "";



  $personinputvalue = 0;
  $filminputvalue = 0;
  $positioninputvalue = 0;
  $roleinputvalue = "";
  $studionotice = "";
  $genrenotice = "";
  $quotenotice = "";
  $personnotice = "";
  $genreinputnotice = "";
  $positioninputnotice = "";
  $genredescription = "";
  $filminput2value = "";
  $moviestudionotice = "";
  $studioaddressinput = "";

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
  $filmoptionspersoninmoviehtml = readfilmoptionsfrompersoninmoviehtml($selected);
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

  if(isset($_POST["quoterelationsubmit"])) {
    if(!empty($_POST["andmedinput"])){
      $selectedandmed = intval($_POST["andmedinput"]);
    } else {
        $quotenotice = " Vali andmed!";
    }
  
    if(!empty($_POST["quoteinput"])){
      $quotetext = ($_POST["quoteinput"]);
    } else {
      $quotenotice = " Sisesta tsitaat!";
    }
  
    if (!empty($selectedandmed) and !empty($quotetext)) {
      $quotenotice = storenewquoterelation($selectedandmed, $quotetext);
    }
  }

  if(isset($_POST["genresubmit"])) {
    if(!empty($_POST["genreinput"])){
      $genrename = ($_POST["genreinput"]);
    } else {
        $genreinputnotice = " Sisesta žanr!";
    }

    if(!empty($_POST["genredescriptioninput"])) {
      $genredescription = ($_POST["genredescriptioninput"]);
    } 

    if (!empty($genrename)) {
      $genreinputnotice = storenewgenre($genrename, $genredescription);
    }
  }

  if(isset($_POST["positionsubmit"])) {
    if(!empty($_POST["positioninput"])){
      $positionname = ($_POST["positioninput"]);
    } else {
        $positioninputnotice = " Sisesta positsioon!";
    }

    if(!empty($_POST["positiondescriptioninput"])){
      $positiondescription = ($_POST["positiondescriptioninput"]);
    } 

    if (!empty($positionname)) {
      $positioninputnotice = storenewposition($positionname, $positiondescription);
    }
  }

  if(isset($_POST["personsubmit"])) {
    if(!empty($_POST["firstnameinput"])){
      $firstname = ($_POST["firstnameinput"]);
    } else {
        $personnotice = " Sisesta eesnimi!";
    }
  
    if(!empty($_POST["lastnameinput"])){
      $lastname = ($_POST["lastnameinput"]);
    } else {
      $personnotice = " Sisesta perekonnanimi!";
    }

    if (isset($_POST["birthdayinput"])) {
      $birthday = intval($_POST["birthdayinput"]);
    }
    else {
      $birthdayerror = "Palun vali synnikuup2ev";
    }

    if (isset($_POST["birthmonthinput"])) {
      $birthmonth = intval($_POST["birthmonthinput"]);
    }
    else {
      $birthmontherror = "Palun vali synnikuu";
    }

    if (isset($_POST["birthyearinput"])) {
      $birthyear = intval($_POST["birthyearinput"]);
    }
    else {
      $birthyearerror = "Palun vali synniaasta";
    }

    if (empty($birthdayerror) and empty($birthmontherror) and empty($birthyearerror)) {
      if (checkdate($birthmonth, $birthday, $birthyear)) {
        $tempdate = new DateTime($birthyear ."-". $birthmonth ."-" .$birthday);
        $birthdate = $tempdate->format("Y-m-d");
      }
      else {
        $birthdateerror = "Valitud kuup2ev on ebareaalne";
      }
    }

    if (!empty($firstname) and !empty($lastname) and !empty($birthdate)) {
      $personnotice = storenewperson($firstname, $lastname, $birthdate);
    }
  }

  if (isset($_POST["moviestudiosubmit"]) and !empty($_POST["moviestudiosubmit"])) {
    if (empty($_POST["moviestudioinput"])) {
      $moviestudioinputerror = "Filmi stuudio nime ei ole sisestatud!";
    }
    else {
      $moviestudioinput = $_POST["moviestudioinput"];
    }

    if (!empty($_POST["studioaddressinput"])) {
      $studioaddressinput = $_POST["studioaddressinput"];
    }

    if (!empty($moviestudioinput)) {
      $moviestudionotice = storenewproductioncompany($moviestudioinput, $studioaddressinput);
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
    <h4>Filmi žanri lisamine</h4>
    <form method="POST" id="registerform">
    <input type="text" name="genreinput" id="genreinput" placeholder="Sisesta žanri liik">
    <input type="text" name="genredescriptioninput" id="genredescriptioninput" placeholder="Sisesta žanri kirjeldus">
    <input type="submit" name="genresubmit" value="Loo seos"><span><?php echo $genreinputnotice; ?></span>
</form>
    <h4>Inimese info sisestamine</h4>
    <form method="POST" id="registerform">
    <label for="firstnameinput">Inimene:</label>
    <input type="text" name="firstnameinput" id="firstnameinput" placeholder="Sisesta eesnimi">
    <input type="text" name="lastnameinput" id="lastnameinput" placeholder="Sisesta perekonnanimi">
    <label for="birthdayinput">Sünnipäev: </label>
		  <?php
			echo '<select name="birthdayinput" id="birthdayinput">' ."\n";
			echo '<option value="" selected disabled>päev</option>' ."\n";
			for ($i = 1; $i < 32; $i ++){
				echo '<option value="' .$i .'"';
				if ($i == $birthday){
					echo " selected ";
				}
				echo ">" .$i ."</option> \n";
			}
			echo "</select> \n";
		  ?>
	  <label for="birthmonthinput">Sünnikuu: </label>
	  <?php
	    echo '<select name="birthmonthinput" id="birthmonthinput">' ."\n";
		echo '<option value="" selected disabled>kuu</option>' ."\n";
		for ($i = 1; $i < 13; $i ++){
			echo '<option value="' .$i .'"';
			if ($i == $birthmonth){
				echo " selected ";
			}
			echo ">" .$monthnameset[$i - 1] ."</option> \n";
		}
		echo "</select> \n";
	  ?>
	  <label for="birthyearinput">Sünniaasta: </label>
	  <?php
	    echo '<select name="birthyearinput" id="birthyearinput">' ."\n";
		echo '<option value="" selected disabled>aasta</option>' ."\n";
		for ($i = date("Y") - 15; $i >= date("Y") - 110; $i --){
			echo '<option value="' .$i .'"';
			if ($i == $birthyear){
				echo " selected ";
			}
			echo ">" .$i ."</option> \n";
		}
		echo "</select> \n";
	  ?>
	  <br>
	  <span><?php echo $birthdateerror ." " .$birthdayerror ." " .$birthmontherror ." " .$birthyearerror; ?></span>
    <span><?php echo $personinputerror; ?></span>
    <input type="submit" name="personsubmit" value="Loo seos"><span><?php echo $personnotice; ?></span>
  </form>
  <h4>Inimese positsiooni lisamine</h4>
  <form method="POST" id="registerform">
  <input type="text" name="positioninput" id="positioninput" placeholder="Sisesta positsioon">
  <input type="text" name="positiondescriptioninput" id="positiondescriptioninput" placeholder="Sisesta positsiooni kirjeldus">
  <input type="submit" name="positionsubmit" value="Loo seos"><span><?php echo $positioninputnotice; ?></span>
  </form>
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
    <label for="andmedinput">Andmed:</label>
    <select name="andmedinput" id="andmedinput">
      <?php echo $filmoptionspersoninmoviehtml; ?>
    </select>
    <span><?php echo $andmedinputerror; ?></span>
    <label for="quoteinput">Tsitaat:</label>
    <input type="text" name="quoteinput" id="quoteinput" placeholder="Sisesta tsitaat">
    <span><?php echo $quoteinputerror; ?></span>
    <input type="submit" name="quoterelationsubmit" value="Loo seos"><span><?php echo $quotenotice; ?></span>
    </form>
    <h4>Filmi stuudio lisamine lisamine</h4>
    <form method="POST" id="registerform">
      <label for="moviestudioinput">Filmi stuudio nimi:</label>
      <input type="text" name="moviestudioinput" id="moviestudioinput" placeholder="Sisesta filmi stuudio nimi">
      <span><?php echo $moviestudioinputerror;?></span>
      <label for="studioaddressinput">Filmi stuudio aadress:</label>
      <input type="text" name="studioaddressinput" id="studioaddressinput" placeholder="Sisesta filmi stuudio aadress">
      <input type="submit" name="moviestudiosubmit" value="Loo seos"><span><?php echo $moviestudionotice; ?></span>
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
