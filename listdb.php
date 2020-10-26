<?php
  require("usersession.php");
 
  $username = "Mait Jurask";
  $fullTimeNow = date("H:i:s");
  $hourNow = date("H");
  $partofday = "lihtsalt aeg";
  require("../../config.php");
  require("fnc_filmrelations.php");
  require("fnc_displayrelations.php");


  $weekdayNamesET = ["esmaspäev", "teisipäev", "kolmapäev", "neljapäev", "reede", "laupäev", "pühapäev"];
  $monthNamesET = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];

  $weekdaynow = date("N");
  $monthnow = date("n");

  $sortby = 0;
  $sortorder = 0;
  $selectorvalue = 0;

  if (isset($_GET["selectorsubmit"]) and !empty($_GET["selectorsubmit"])) {
     $selectorvalue = intval($_GET["selector"]); 
  }

  function readcontent($selectorvalue, $sortby, $sortorder) {
    $pagecontent = "";

    if (isset($_GET["sortby"]) and isset($_GET["sortorder"])) {
        if ($_GET["sortby"] >= 1 and $_GET["sortby"] <= 4) {
        $sortby = intval($_GET["sortby"]); 
        }
        if ($_GET["sortorder"] == 1 or $_GET["sortorder"] == 2) {
        $sortorder = intval($_GET["sortorder"]);
        }
    }

    if ($selectorvalue == 1) { 
        $pagecontent = readpersonfromdb($selectorvalue, $sortby, $sortorder);
    }
    else if ($selectorvalue == 2) {
        $pagecontent = readpersoninmovie($selectorvalue, $sortby, $sortorder);
    }
    else if ($selectorvalue == 3) {
        $pagecontent = readquotefromdb($selectorvalue, $sortby, $sortorder);
    }
    else if ($selectorvalue == 4) {
        $pagecontent = readpositionfromdb($selectorvalue, $sortby, $sortorder);
    }
    else if ($selectorvalue == 5) {
        $pagecontent = readmoviefromdb($selectorvalue, $sortby, $sortorder);
    }
    else if ($selectorvalue == 6) {
        $pagecontent = readmoviegenrefromdb($selectorvalue, $sortby, $sortorder);
    }
    else if ($selectorvalue == 7) {
        $pagecontent = readgenrefromdb($selectorvalue, $sortby, $sortorder);
    }
    else if ($selectorvalue == 8) {
        $pagecontent = readmoviebyproductionfromdb($selectorvalue, $sortby, $sortorder);
    }
    else if ($selectorvalue == 9) {
        $pagecontent = readproductioncompanyfromdb($selectorvalue, $sortby, $sortorder);
    }

    return $pagecontent;
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
      <form method="GET">  
        <label for="selector">Kirje valimine</label>
        <select name="selector" id="selector">
            <option value="" disabled selected>Vali kirje</option>
            <option value="1">Person</option>
            <option value="2">Person_in_movie</option>
            <option value="3">Quote</option>
            <option value="4">Position</option>
            <option value="5">Movie</option>
            <option value="6">Movie_genre</option>
            <option value="7">Genre</option>
            <option value="8">Movie_by_production_company</option>
            <option value="9">Production_company</option>
        </select>  
        <input type="submit" name="selectorsubmit" id="selectorsubmit" value="Lae kirje">
      </form>

      <?php echo readcontent($selectorvalue, $sortorder, $sortby);?>  
    </div>
    <footer>
      <h4>See veebileht on tehtud Mait Jurask'i poolt.</h4>
      <h4><?php echo "Parajasti on " .$partofday ."." ?></h4>
    </footer>
 </div>
</body>
</html>
