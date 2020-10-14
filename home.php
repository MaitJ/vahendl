<?php 

  require("usersession.php");
  $username = $_SESSION["userfirstname"] + " " + $_SESSION["userlastname"];
  $fullTimeNow = date("H:i:s");
  $hourNow = date("H");
  $partofday = "lihtsalt aeg";

  require("fnc_film.php");
 
  require("../../config.php");


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
      <h1 id="mainHeader">Gheto Filmibaas</h1>
      <h3 id="mainHeader">Tere tulemast <?php echo $_SESSION["userfirstname"] . " " . $_SESSION["userlastname"] ?></h3>
      <h3 id="mainHeader">See leht on veebiprogemise kursuse alusel tehtud, midagi t2htsat siin ei ole</h3>
      <h3 id="mainHeader">Lehe avamisel oli hetkel kell: <?php echo $weekdayNamesET[$weekdaynow - 1]. " " . date("j") . ". " . $monthNamesET[$monthnow - 1] . " " . $fullTimeNow?></h3>
      <h4 id="mainHeader"><?php echo $semestriMessage?></h3>
      <img src="img/vp_banner.png" alt="Veebiprogrammeerimise logo">
    </header>
    <?php require('navbar.php'); ?>
    <div id="content">
      <h2>Haugi poiss</h2>
      <img src="<?php echo $haugiPildiArray[0]?>">
      <p>Haug ehk harilik haug ehk havi (Esox lucius) on hauglaste sugukonda haugi perekonda kuuluv röövkala.

        Haug elab Euraasia ja Põhja-Ameerika põhjaosa sisevetes. Ta on üks kõige laiemalt levinud mageveekala. Venemaal puudub ta vaid Amuuri jõgikonnas, kus elab amuuri haug. Ukrainas puudub haug ainult Krimmis.[1]
        
        Haugil on nooljas keha, mis on natuke külgedel lamenenud. Seljauim on keha tagaosas, suurendades saba tõukepinda. See võimaldab välkkiireid kohaltsööste saagi haaramiseks. Suhteliselt suurel peal on pardi nokka meenutav suu, millel on tahapoole kaldu olevad hambad. Haugi värvus sõltub keskkonnast, keha on selja pealt tavaliselt rohekas-sinakas, mis muutub allapoole minnes üha heledamaks, kõhualune on valge.
        
        Haugi hambad on suunatud sissepoole, et vältida saagi pagemist suust. Alalõua hambad on eri suurusega ja vahetuvad. Alalõua seesmine külg on kaetud pehme koega, mille all on asendushammaste kõverad read. Igal kihval on 2–4 asendushammast ja kui kihv välja langeb, siis tuleb tema asemele mõni asendushammas. Algul uus hammas logiseb, edaspidi aga kasvab tihedalt alalõua külge kinni. Hambad ei vahetu korraga, vaid kogu aasta vältel pidevalt on haugi suus nii noori kui vanu hambaid.[1]
        
        Haugi tavaline suurus on 50–100 cm, aga ta võib olla üle 150 cm pikk ja üle 35 kg raske. Vangistuses võib haug elada kuni 30 aasta vanuseks.
        
        Haug on suhteliselt paikne kala, kes eelistab aeglase vooluga jõgesid, järvi ja riimveelist rannikumerd, hoidudes enamasti kalda lähedale taimestikku või teistesse varju pakkuvatesse paikadesse. On ka hauge, kes elavad avavees ja jälitavad pisemaid parvekalu. Ta talub hästi happelist keskkonda ja võib elada veekogudes, mille pH on 4,75[1].
        
        Haug on röövkala, kes toitub teistest kaladest, ka oma liigikaaslastest. Suured haugid võivad süüa konni, pardipoegi ja pisiimetajaid. Haugide hulgas on kannibalism väga levinud ja eksisteerib järvi, kus peale haugide teisi kalaliike üldse ei ela. Neis järvedes söövad pisikesed havid vesikirpe, vähikesi ja muud zooplanktonit, aga suuremad liigikaaslasi[1].
        
        Eestis on haug tavaline ja teda püütakse ka töönduslikult. Ta esineb enamikus järvedes ja jõgedes, samuti rannikumeres.
        
        Harrastuspüügil kasutatakse enamasti spinningut ja elussöödaõnge, vähemal määral lendõnge ja põhjaõnge. Enamikus veekogudes on edukaim püügiviis elussöödaõng, mõnes spinning.</p>
    </div>
    <?php echo $imghtml;?>
    <footer>
      <h4>See veebileht on tehtud Mait Jurask'i poolt.</h4>
      <h4><?php echo "Parajasti on " .$partofday ."." ?></h4>
    </footer>
 </div>
</body>
</html>
