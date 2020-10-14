<?php
 
  $username = "Mait Jurask";
  $fullTimeNow = date("H:i:s");
  $hourNow = date("H");
  $partofday = "lihtsalt aeg";

  $database = "if20_mait_ju_1";
 
  require("../../config.php");
  require("fnc_common.php");
  require("fnc_user.php");

  //Errori valued
  $firstnameerror = "";
  $lastnameerror = "";
  $emailerror = "";
  $passworderror ="";
  $gendererror = "";
  $passwordsecondaryerror = "";

  //Salvestatud valued
  $firstnamevalue = "";
  $lastnamevalue = "";
  $emailvalue= "";
  $gender = "";

  
  $birthdateerror = null;
  $birthdayerror = null;
  $birthyearerror = null;
  $birthmontherror = null;

  $birthday = null;
  $birthmonth = null;
  $birthyear = null;
  $birthdate = null;

  $result = null;
  $notice = null;
  if (isset($_POST["registersubmit"]) and !empty($_POST["registersubmit"])){

    if (!empty($_POST["firstnameinput"])) {
      $firstnamevalue = test_input($_POST["firstnameinput"]);
    }
    else {
      $firstnameerror = "Sisesta eesnimi!";
    }

    if (!empty($_POST["lastnameinput"])) {
      $lastnamevalue = test_input($_POST["lastnameinput"]);
    }
    else {
      $lastnameerror = "Sisesta perekonnanimi!";
    }

    if (isset($_POST["genderinput"])) {
      $gender = intval($_POST["genderinput"]);
    }
    else {
      $gendererror = "Sisesta sugu!";
    }

    if (!empty($_POST["emailinput"])) {
      $emailvalue = test_input($_POST["emailinput"]);
    }
    else {
      $emailerror = "Sisesta email!";
    }

    if (strlen($_POST["passwordinput"]) < 8) {
      $passworderror = "Parool on liiga lyhike (v2hemalt 8 t2hem2rki";
    }
    else if (empty($_POST["passwordinput"])) {
      $passworderror = "Sisesta parool!";
    }

    if ($_POST["passwordinput"] != $_POST["passwordsecondaryinput"]) {
      $passwordsecondaryerror = "Sisesta sama parool!";
    }
    else if (empty($_POST["passwordsecondaryinput"])) {
      $passwordsecondaryerror = "Sisesta parool!";
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

    if (empty($firstnameerror) and empty($lastnameerror) and empty($gendererror) and empty($birthdayerror) and empty($birthmontherror) and empty($birthyearerror) and empty($birthdateerror) and empty($emailerror) and empty($passworderror) and empty($passwordsecondaryerror)) {

      $result = signup($firstnamevalue, $lastnamevalue, $emailvalue, $gender, $birthdate, $_POST["passwordinput"]);
      //$notice = "K6ik korras!";
      if ($result == "ok") {
        $notice = "Kasutaja on edukalt loodud!";
        $firstnamevalue = "";
        $lastnamevalue = "";
        $gender = "";
        $emailvalue = "";
        $birthday = null;
        $birthmonth = null;
        $birthyear = null;
      }
      else {
        $notice = "Kahjuks tekkis tehniline viga" . $result;
      }

    }
  }
  





  $weekdayNamesET = ["esmaspäev", "teisipäev", "kolmapäev", "neljapäev", "reede", "laupäev", "pühapäev"];
  $monthnameset = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];


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
      <h3 id="mainHeader">See leht on veebiprogemise kursuse alusel tehtud, midagi t2htsat siin ei ole</h3>
      <h3 id="mainHeader">Lehe avamisel oli hetkel kell: <?php echo $weekdayNamesET[$weekdaynow - 1]. " " . date("j") . ". " . $monthnameset[$monthnow - 1] . " " . $fullTimeNow?></h3>
      <h4 id="mainHeader"><?php echo $semestriMessage?></h3>
      <img src="img/vp_banner.png" alt="Veebiprogrammeerimise logo">
    </header>
    <?php require('defnavbar.php'); ?>
    <div id="content">
      <form method="POST" id="registerform" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="fistnameinput">Eesnimi</label>
        <input type="text" name="firstnameinput" id="firstnameinput" placeholder="Eesnimi" value="<?php echo $firstnamevalue;?>"><span><?php echo $firstnameerror; ?></span>
        <label for="lastnameinput">Perekonnanimi</label>
        <input type="text" name="lastnameinput" id="lastnameinput" placeholder="Perekonnanimi" value="<?php echo $lastnamevalue;?>"><span><?php echo $lastnameerror; ?></span>
        <label for="genderinput">Sugu</label>
        <input type="radio" name="genderinput" id="gendermale" value="1" <?php if($gender == "1") {echo " checked";}?>><label for="gendermale">Mees</label>
        <input type="radio" name="genderinput" id="genderfemale" value="2" <?php if($gender == "2") {echo " checked";}?> ><label for="genderfemale">Naine</label>
        <span><?php echo $gendererror;?></span>
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
        <label for="emailinput">Email</label>
        <input type="email" name="emailinput" id="emailinput" placeholder="Email" value="<?php echo $emailvalue;?>"><span><?php echo $emailerror;?></span>
        <label for="passwordinput">Password</label>
        <input type="password" name="passwordinput" id="passwordinput"><span><?php echo $passworderror;?></span>
        <label for="passwordsecondaryinput">Enter your password again</label>
        <input type="password" name="passwordsecondaryinput" id="passwordsecondaryinput"><span><?php echo $passwordsecondaryerror;?></span>
        <br>

        <input type="submit" name="registersubmit" value="Registreeri">
        <p><?php echo $notice;?></p>
      </form>
    </div>
    <footer>
      <h4>See veebileht on tehtud Mait Jurask'i poolt.</h4>
      <h4><?php echo "Parajasti on " .$partofday ."." ?></h4>
    </footer>
 </div>
</body>
</html>
