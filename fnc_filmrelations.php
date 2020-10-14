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

function readfilmgenrehtml($selected) {
    $result = "";
    $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);	

    $conn->close();
    return $result;
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