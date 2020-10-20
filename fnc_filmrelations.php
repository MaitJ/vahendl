<?php

$database = "if20_mait_ju_1";

function readpersonoptionshtml($selected) {
    $result = "<p>Kahjuks ei eksisteeri inimesi andmebaasis.</p>";
    $personoptionhtml = "";
    $result = "";

    $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);	
    $stmt = $conn->prepare("SELECT person_id, first_name, last_name FROM person");
    echo $conn->error;
    $stmt->bind_result($personidfromdb, $firstnamefromdb, $lastnamefromdb);
    $stmt->execute();

    while ($stmt->fetch()) {
        $personoptionhtml .= '<option value="' .$personidfromdb .'"';
        if ($personidfromdb == $selected) {
            $personoptionhtml .= " selected";
        }
        $personoptionhtml .= ">" .$firstnamefromdb . " " . $lastnamefromdb . "</option> \n";
    }

    if (!empty($personoptionhtml)) {
        $result = '<option value="" disabled selected>Vali inimene</option>' . "\n";
        $result .= $personoptionhtml;
    }
    $stmt->close();
    $conn->close();
    return $result;
}

function readfilmoptionshtml($selected) {
    $result = "<p>Kahjuks ei eksisteeri filme andmebaasis.</p>";
    $filmoptionhtml = "";
    $result = "";

    $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);	
    $stmt = $conn->prepare("SELECT movie_id, title FROM movie");
    echo $conn->error;
    $stmt->bind_result($movieidfromdb, $movietitlefromdb);
    $stmt->execute();

    while ($stmt->fetch()) {
        $filmoptionhtml .= '<option value="' .$movieidfromdb .'"';
        if ($movieidfromdb == $selected) {
            $filmoptionhtml .= " selected";
        }
        $filmoptionhtml .= ">" .$movietitlefromdb . "</option> \n";
    }
    
    if (!empty($filmoptionhtml)) {
        $result = '<option value="" disabled selected>Vali film</option>' . "\n";
        $result .= $filmoptionhtml;
    }

    $stmt->close();
    $conn->close();
    return $result;
}

function readpositionoptionshtml($selected) {
    $result = "<p>Kahjuks ei eksisteeri positsioone andmebaasis.</p>";
    $positionhtml = "";
    $result = "";

    $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);	
    $stmt = $conn->prepare("SELECT position_id, position_name FROM position");
    echo $conn->error;
    $stmt->bind_result($positionidfromdb, $positionnamefromdb);
    $stmt->execute();

    while ($stmt->fetch()) {
        $positionhtml .= '<option value="' .$positionidfromdb .'"';
        if ($positionidfromdb == $selected) {
            $positionhtml .= " selected";
        }
        $positionhtml .= ">" .$positionnamefromdb . "</option>\n";
    }

    if (!empty($positionhtml)) {
        $result = '<option value="" disabled selected>Vali positsioon</option>' . "\n";
        $result .= $positionhtml;
    }
    $stmt->close();
    $conn->close();
    return $result;

}

function storenewrelation($personid, $movieid, $positionid, $role) {
    $result = "";
    
    $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);	
    $stmt = $conn->prepare("SELECT person_in_movie_id FROM person_in_movie WHERE person_id = ? AND movie_id = ? AND position_id = ? AND role = ?");
    echo $conn->error;
    $stmt->bind_param("iiis", $personid, $movieid, $positionid, $role);
    $stmt->bind_result($idfromdb);
    $stmt->execute();

    if ($stmt->fetch()) {
        $result = "Kirje on olemas";
    }
    else {
        $stmt->close();
        $stmt = $conn->prepare("INSERT INTO person_in_movie (person_id, movie_id, position_id, role) VALUES (?, ?, ?, ?)");
        echo $stmt->error;
        $stmt->bind_param("iiis", $personid, $movieid, $positionid, $role);
        if ($stmt->execute()) {
            $result = "Kirje edukalt loodud";
        }
        else {
            $result = "Kirjet ei suudetud luua, Error: " . $stmt->error;
        }
    }
    
    $stmt->close();
    $conn->close();
    return $result;
}

function readgenre($selected) {
    $notice = "<p>Kahjuks žanre ei leitud!</p> \n";
    $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
    $stmt = $conn->prepare("SELECT genre_id, genre_name FROM genre");
    $connerror = $conn->error;
    $stmt->bind_result($genreidfromdb, $genrenamefromdb);
    $stmt->execute();
    $genres = "";
    while ($stmt->fetch()) {
        $genres .= '<option value="' .$genreidfromdb .'"';
        if(intval($genreidfromdb) == $selected){
			$genres .=" selected";
        }
        $genres .= ">" .$genrenamefromdb ."</option> \n";
    }
    if (!empty($genres)) {
        $notice = '<select name="moviegenreinput" id="moviegenreinput">' ."\n";
		$notice .= '<option value="" selected disabled>Vali žanr</option>' ."\n";
		$notice .= $genres;
		$notice .= "</select> \n";
    }
    $stmt->close();
    $conn->close();
    return $notice;
}

function readpersoninmovie($sortby, $sortorder) {
    $notice = "<p>Kahjuks ei leidnud filmi tegelasi</p>";
    $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);	
    $sqlphrase = "SELECT first_name, last_name, role, title FROM person JOIN person_in_movie ON person.person_id = person_in_movie.person_id JOIN movie ON movie.movie_id = person_in_movie.movie_id";

    if ($sortby == 0) {
        $stmt = $conn->prepare($sqlphrase);
    }
    if ($sortby == 4) {
        if ($sortorder == 2) {
            $stmt = $conn->prepare($sqlphrase . " ORDER BY title DESC");
        }
        else {
            $stmt = $conn->prepare($sqlphrase . " ORDER BY title");
        }
    }
    echo $conn->error;
    $stmt->bind_result($firstnamefromdb, $lastnamefromdb, $rolefromdb, $titlefromdb);
    $stmt->execute();

    $rows = "";
    while ($stmt->fetch()) {
        $rows .= "\t<tr> \n";
        $rows .= "\t\t<td>" . $firstnamefromdb . " " . $lastnamefromdb . "</td>";
        $rows .= "<td>" . $rolefromdb . "</td>";
        $rows .= "<td>" . $titlefromdb . "</td>\n"; 
        $rows .= "\t</tr> \n";

    }

    if (!empty($rows)) {
        $notice = "<table> \n";
        $notice .= "\t<tr>\n\t\t<th>Isik</th>\n\t\t<th>Roll</th>\n";
        $notice .= "\t\t" . '<th>Film <a href="?sortby=4&sortorder=1">&uarr;</a>&nbsp;<a href="?sortby=4&sortorder=2">&darr;</a></th>' . "\n\t</tr>\n";
        
        $notice .= $rows;
        $notice .= "</table> \n";
    }

    $stmt->close();
    $conn->close();
    return $notice;
}


function old_readpersoninmovie() {
    $notice = "";
    $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);	
    $stmt = $conn->prepare("SELECT first_name, last_name, role, title FROM person JOIN person_in_movie ON person.person_id = person_in_movie.person_id JOIN movie ON movie.movie_id = person_in_movie.movie_id");
    echo $conn->error;
    $stmt->bind_result($firstnamefromdb, $lastnamefromdb, $rolefromdb, $titlefromdb);
    $stmt->execute();

    while ($stmt->fetch()) {
        $notice .= "<p>" . $firstnamefromdb . " " . $lastnamefromdb;
        if (!empty($rolefromdb)) {
            $notice .= " tegelane: " . $rolefromdb;
        }
        $notice .= ' filmis "' .$titlefromdb .'"' . "</p>" . "\n";
    }


    $stmt->close();
    $conn->close();
    return $notice;
}

function readstudiotoselect($selectedstudio) {
    $notice = "<p>Kahjuks stuudioid ei leitud!</p> \n";
    $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
    $stmt = $conn->prepare("SELECT production_company_id, company_name FROM production_company");
    echo $conn->error;
    $stmt->bind_result($idfromdb, $companyfromdb);
    $stmt->execute();
    $studios = "";
    while ($stmt->fetch()){
        //<option value="1" selected>Tallinnfilm</option>
        $studios .= '<option value="' .$idfromdb .'"';
        if ($idfromdb == $selectedstudio) {
            $studios .= " selected";
        }
        $studios .= ">" .$companyfromdb ."</option> \n";
    }
    if(!empty($studios)) {
        $notice = '<select name="filmstudioinput">' ."\n";
        $notice .= '<option value="" selected disabled>Vali stuudio</option>' ."\n";
        $notice .= $studios;
        $notice .= "</select> \n";
    }

    $stmt->close();
	$conn->close();
	return $notice;
}

function storenewgenrerelation($selectedmovie, $selectedgenre){
	$notice = "";
	$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
	$stmt = $conn->prepare("SELECT movie_genre_id FROM movie_genre WHERE movie_id = ? AND genre_id = ?");
	echo $conn->error;
	$stmt->bind_param("ii", $selectedmovie, $selectedgenre);
	$stmt->bind_result($idfromdb);
	$stmt->execute();
	if($stmt->fetch()){
		$notice = "Selline seos on juba olemas!";
	} else {
		$stmt->close();
		$stmt = $conn->prepare("INSERT INTO movie_genre (movie_id, genre_id) VALUES(?,?)");
		echo $conn->error;
		$stmt->bind_param("ii", $selectedmovie, $selectedgenre);
		if($stmt->execute()){
			$notice = "Uus seos edukalt salvestatud!";
		} else {
			$notice = "Seose salvestamisel tekkis tehniline tõrge: " .$stmt->error;
		}
	}
	
	$stmt->close();
	$conn->close();
	return $notice;
}