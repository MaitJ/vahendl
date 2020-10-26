<?php

$database = "if20_mait_ju_1";

function readpersonfromdb($selectorvalue, $sortby, $sortorder) {
    $result = "Andmebaasis pole yhtegi kirjet";
    $result = ""; 

    $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);	
    $sqlphrase = "SELECT first_name, last_name, birth_date FROM person";

    if ($sortby == 0) {
        $stmt = $conn->prepare($sqlphrase);
    }
    else {
        if ($sortorder == 2) {
            $stmt = $conn->prepare($sqlphrase . " ORDER BY first_name DESC");
        }
        else {
            $stmt = $conn->prepare($sqlphrase . " ORDER BY first_name");
        }
    }

    echo $conn->error;
    $stmt->bind_result($firstnamefromdb, $lastnamefromdb, $birthdatefromdb);
    $stmt->execute();

    $rows = "";
    while ($stmt->fetch()) {
        $rows .= "\t<tr> \n";
        $rows .= "\t\t<td>" . $firstnamefromdb . " " . $lastnamefromdb . "</td>";
        $rows .= "<td>" . $birthdatefromdb . "</td>\n";
        $rows .= "\t</tr> \n";
    }

    if (!empty($rows)) {
        $result = "";
        $result .= "<table>";
        $result .= "\t<tr> \n";
        $result .= "\t\t" . '<th>Nimi <a href="?selector='.$selectorvalue .'&sortorder=1&sortby=1&selectorsubmit=Lae+kirje">&uarr;</a>&nbsp<a href="?selector='.$selectorvalue.'&sortorder=2&sortby=1&selectorsubmit=Lae+kirje">&darr;</a></th>' . "\n";
        $result .= "\t\t<th>Synnip2ev</th>\n";
        $result .= $rows;
        $result .= "\t</tr> \n";
        $result .= "</table>";
    }
    
    return $result;
}



function readpositionfromdb($selectorvalue, $sortby, $sortorder) {
    $result = "Andmebaasis pole yhtegi kirjet";
    $result = ""; 

    $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);	
    $sqlphrase = "SELECT position_name, description FROM position";

    if ($sortby == 0) {
        $stmt = $conn->prepare($sqlphrase);
    }
    else {
        if ($sortorder == 2) {
            $stmt = $conn->prepare($sqlphrase . " ORDER BY position_name DESC");
        }
        else {
            $stmt = $conn->prepare($sqlphrase . " ORDER BY position_name");
        }
    }

    echo $conn->error;
    $stmt->bind_result($position_namefromdb, $descriptionfromdb);
    $stmt->execute();

    $rows = "";
    while ($stmt->fetch()) {
        $rows .= "\t<tr> \n";
        $rows .= "\t\t<td>" . $position_namefromdb . "</td>";
        $rows .= "<td>" . $descriptionfromdb . "</td>\n";
        $rows .= "\t</tr> \n";
    }

    if (!empty($rows)) {
        $result = "";
        $result .= "<table>";
        $result .= "\t<tr> \n";
        $result .= "\t\t" . '<th>Positsiooni nimi <a href="?selector='.$selectorvalue .'&sortorder=1&sortby=1&selectorsubmit=Lae+kirje">&uarr;</a>&nbsp<a href="?selector='.$selectorvalue.'&sortorder=2&sortby=1&selectorsubmit=Lae+kirje">&darr;</a></th>' . "\n";
        $result .= "\t\t<th>Positsiooni kirjeldus</th>\n";
        $result .= $rows;
        $result .= "\t</tr> \n";
        $result .= "</table>";
    }
    
    return $result;
}


function readgenrefromdb($selectorvalue, $sortby, $sortorder) {
    $result = "Andmebaasis pole yhtegi kirjet";
    $result = ""; 

    $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);	
    $sqlphrase = "SELECT genre_name, description FROM genre";

    if ($sortby == 0) {
        $stmt = $conn->prepare($sqlphrase);
    }
    else {
        if ($sortorder == 2) {
            $stmt = $conn->prepare($sqlphrase . " ORDER BY genre_name DESC");
        }
        else {
            $stmt = $conn->prepare($sqlphrase . " ORDER BY genre_name");
        }
    }

    echo $conn->error;
    $stmt->bind_result($genrenamefromdb, $descriptionfromdb);
    $stmt->execute();

    $rows = "";
    while ($stmt->fetch()) {
        $rows .= "\t<tr> \n";
        $rows .= "\t\t<td>" . $genrenamefromdb . "</td>";
        $rows .= "<td>" . $descriptionfromdb . "</td>\n";
        $rows .= "\t</tr> \n";
    }

    if (!empty($rows)) {
        $result = "";
        $result .= "<table>";
        $result .= "\t<tr> \n";
        $result .= "\t\t" . '<th>Zanr <a href="?selector='.$selectorvalue .'&sortorder=1&sortby=1&selectorsubmit=Lae+kirje">&uarr;</a>&nbsp<a href="?selector='.$selectorvalue.'&sortorder=2&sortby=1&selectorsubmit=Lae+kirje">&darr;</a></th>' . "\n";
        $result .= "\t\t<th>Zanri kirjeldus</th>\n";
        $result .= $rows;
        $result .= "\t</tr> \n";
        $result .= "</table>";
    }
    
    return $result;
}

function readproductioncompanyfromdb($selectorvalue, $sortby, $sortorder) {
    $result = "Andmebaasis pole yhtegi kirjet";
    $result = ""; 

    $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);	
    $sqlphrase = "SELECT company_name, company_address FROM production_company";

    if ($sortby == 0) {
        $stmt = $conn->prepare($sqlphrase);
    }
    else {
        if ($sortorder == 2) {
            $stmt = $conn->prepare($sqlphrase . " ORDER BY company_name DESC");
        }
        else {
            $stmt = $conn->prepare($sqlphrase . " ORDER BY company_name");
        }
    }

    echo $conn->error;
    $stmt->bind_result($companynamefromdb, $companyaddressfromdb);
    $stmt->execute();

    $rows = "";
    while ($stmt->fetch()) {
        $rows .= "\t<tr> \n";
        $rows .= "\t\t<td>" . $companynamefromdb . "</td>";
        $rows .= "<td>" . $companyaddressfromdb . "</td>\n";
        $rows .= "\t</tr> \n";
    }

    if (!empty($rows)) {
        $result = "";
        $result .= "<table>";
        $result .= "\t<tr> \n";
        $result .= "\t\t" . '<th>Firma nimi <a href="?selector='.$selectorvalue .'&sortorder=1&sortby=1&selectorsubmit=Lae+kirje">&uarr;</a>&nbsp<a href="?selector='.$selectorvalue.'&sortorder=2&sortby=1&selectorsubmit=Lae+kirje">&darr;</a></th>' . "\n";
        $result .= "\t\t<th>Firma aadress</th>\n";
        $result .= $rows;
        $result .= "\t</tr> \n";
        $result .= "</table>";
    }
    
    return $result;
}


function readmoviefromdb($selectorvalue, $sortby, $sortorder) {
    $result = "Andmebaasis pole yhtegi kirjet";
    $result = ""; 

    $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);	
    $sqlphrase = "SELECT title, production_year, duration, description FROM movie";

    if ($sortby == 0) {
        $stmt = $conn->prepare($sqlphrase);
    }
    else if ($sortby == 1) {
        if ($sortorder == 2) {
            $stmt = $conn->prepare($sqlphrase . " ORDER BY title DESC");
        }
        else {
            $stmt = $conn->prepare($sqlphrase . " ORDER BY title");
        }
    }
    else if ($sortby == 2) {
        if ($sortorder == 2) {
            $stmt = $conn->prepare($sqlphrase . " ORDER BY production_year DESC");
        }
        else {
            $stmt = $conn->prepare($sqlphrase . " ORDER BY production_year");
        }
    }
    else if ($sortby == 3) {
        if ($sortorder == 3) {
            $stmt = $conn->prepare($sqlphrase . " ORDER BY duration DESC");
        }
        else {
            $stmt = $conn->prepare($sqlphrase . " ORDER BY duration");
        }
    }

    echo $conn->error;
    $stmt->bind_result($titlefromdb, $productionyearfromdb, $durationfromdb, $descriptionfromdb);
    $stmt->execute();

    $rows = "";
    while ($stmt->fetch()) {
        $rows .= "\t<tr> \n";
        $rows .= "\t\t<td>" . $titlefromdb . "</td>";
        $rows .= "<td>" . $productionyearfromdb . "</td>";
        $rows .= "<td>" . $durationfromdb . "</td>";
        $rows .= "<td>" . $descriptionfromdb . "</td>\n";
        $rows .= "\t</tr> \n";
    }

    if (!empty($rows)) {
        $result = "";
        $result .= "<table>";
        $result .= "\t<tr> \n";
        $result .= "\t\t" . '<th>Filmi nimi <a href="?selector='.$selectorvalue .'&sortorder=1&sortby=1&selectorsubmit=Lae+kirje">&uarr;</a>&nbsp<a href="?selector='.$selectorvalue.'&sortorder=2&sortby=1&selectorsubmit=Lae+kirje">&darr;</a></th>' . "\n";
        $result .= "\t\t" . '<th>Filmi tootmisaasta <a href="?selector='.$selectorvalue .'&sortorder=1&sortby=2&selectorsubmit=Lae+kirje">&uarr;</a>&nbsp <a href="?selector='.$selectorvalue .'&sortorder=2&sortby=2&selectorsubmit=Lae+kirje">&darr;</a></th>' . "\n";
        $result .= "\t\t" . '<th>Filmi kestvus <a href="?selector='.$selectorvalue .'&sortorder=1&sortby=3&selectorsubmit=Lae+kirje">&uarr;</a>&nbsp <a href="?selector='.$selectorvalue .'&sortorder=2&sortby=3&selectorsubmit=Lae+kirje">&darr;</a></th>' . "\n";
        $result .= "\t\t<th>Filmi kirjeldus</th>\n";
        $result .= $rows;
        $result .= "\t</tr> \n";
        $result .= "</table>";
    }
    
    return $result;
}


function readmoviegenrefromdb($selectorvalue, $sortby, $sortorder) {
    $result = "Andmebaasis pole yhtegi kirjet";
    $result = ""; 

    $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);	
    $sqlphrase = "SELECT title, genre_name FROM movie_genre JOIN movie ON movie_genre.movie_id = movie.movie_id JOIN genre ON movie_genre.genre_id = genre.genre_id";

    if ($sortby == 0) {
        $stmt = $conn->prepare($sqlphrase);
    }
    else if ($sortby == 1) {
        if ($sortorder == 2) {
            $stmt = $conn->prepare($sqlphrase . " ORDER BY title DESC");
        }
        else {
            $stmt = $conn->prepare($sqlphrase . " ORDER BY title");
        }
    }
    else if ($sortby == 2) {
        if ($sortorder == 2) {
            $stmt = $conn->prepare($sqlphrase . " ORDER BY genre_name DESC");
        }
        else {
            $stmt = $conn->prepare($sqlphrase . " ORDER BY genre_name");
        }
    }

    echo $conn->error;
    $stmt->bind_result($titlefromdb, $genrenamefromdb);
    $stmt->execute();

    $rows = "";
    while ($stmt->fetch()) {
        $rows .= "\t<tr> \n";
        $rows .= "\t\t<td>" . $titlefromdb . "</td>";
        $rows .= "<td>" . $genrenamefromdb . "</td>\n";
        $rows .= "\t</tr> \n";
    }

    if (!empty($rows)) {
        $result = "";
        $result .= "<table>";
        $result .= "\t<tr> \n";
        $result .= "\t\t" . '<th>Filmi nimi <a href="?selector='.$selectorvalue .'&sortorder=1&sortby=1&selectorsubmit=Lae+kirje">&uarr;</a>&nbsp<a href="?selector='.$selectorvalue.'&sortorder=2&sortby=1&selectorsubmit=Lae+kirje">&darr;</a></th>' . "\n";
        $result .= "\t\t" . '<th>Filmi zanr <a href="?selector='.$selectorvalue .'&sortorder=1&sortby=2&selectorsubmit=Lae+kirje">&uarr;</a>&nbsp<a href="?selector='.$selectorvalue.'&sortorder=2&sortby=2&selectorsubmit=Lae+kirje">&darr;</a></th>' . "\n";
        $result .= $rows;
        $result .= "\t</tr> \n";
        $result .= "</table>";
    }
    
    return $result;
}


function readmoviebyproductionfromdb($selectorvalue, $sortby, $sortorder) {
    $result = "Andmebaasis pole yhtegi kirjet";
    $result = ""; 

    $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);	
    $sqlphrase = "SELECT title, company_name FROM movie_by_production_company JOIN movie ON movie_by_production_company.movie_movie_id = movie.movie_id JOIN production_company ON movie_by_production_company.production_company_id = production_company.production_company_id";

    if ($sortby == 0) {
        $stmt = $conn->prepare($sqlphrase);
    }
    else if ($sortby == 1) {
        if ($sortorder == 2) {
            $stmt = $conn->prepare($sqlphrase . " ORDER BY title DESC");
        }
        else {
            $stmt = $conn->prepare($sqlphrase . " ORDER BY title");
        }
    }
    else if ($sortby == 2) {
        if ($sortorder == 2) {
            $stmt = $conn->prepare($sqlphrase . " ORDER BY company_name DESC");
        }
        else {
            $stmt = $conn->prepare($sqlphrase . " ORDER BY company_name");
        }
    }

    echo $conn->error;
    $stmt->bind_result($titlefromdb, $companynamefromdb);
    $stmt->execute();

    $rows = "";
    while ($stmt->fetch()) {
        $rows .= "\t<tr> \n";
        $rows .= "\t\t<td>" . $titlefromdb . "</td>";
        $rows .= "<td>" . $companynamefromdb . "</td>\n";
        $rows .= "\t</tr> \n";
    }

    if (!empty($rows)) {
        $result = "";
        $result .= "<table>";
        $result .= "\t<tr> \n";
        $result .= "\t\t" . '<th>Filmi nimi <a href="?selector='.$selectorvalue .'&sortorder=1&sortby=1&selectorsubmit=Lae+kirje">&uarr;</a>&nbsp<a href="?selector='.$selectorvalue.'&sortorder=2&sortby=1&selectorsubmit=Lae+kirje">&darr;</a></th>' . "\n";
        $result .= "\t\t" . '<th>Firma nimi <a href="?selector='.$selectorvalue .'&sortorder=1&sortby=2&selectorsubmit=Lae+kirje">&uarr;</a>&nbsp<a href="?selector='.$selectorvalue.'&sortorder=2&sortby=2&selectorsubmit=Lae+kirje">&darr;</a></th>' . "\n";
        $result .= $rows;
        $result .= "\t</tr> \n";
        $result .= "</table>";
    }
    
    return $result;
}


function readquotefromdb($selectorvalue, $sortby, $sortorder) {
    $result = "Andmebaasis pole yhtegi kirjet";
    $result = ""; 

    $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);	
    $sqlphrase = "SELECT first_name, last_name, title, role, quote_text FROM quote JOIN person_in_movie ON quote.person_in_movie_id = person_in_movie.person_in_movie_id JOIN person ON person_in_movie.person_id = person.person_id JOIN movie ON person_in_movie.movie_id = movie.movie_id";

    if ($sortby == 0) {
        $stmt = $conn->prepare($sqlphrase);
    }
    else if ($sortby == 1) {
        if ($sortorder == 2) {
            $stmt = $conn->prepare($sqlphrase . " ORDER BY first_name DESC");
        }
        else {
            $stmt = $conn->prepare($sqlphrase . " ORDER BY first_name");
        }
    }
    else if ($sortby == 2) {
        if ($sortorder == 2) {
            $stmt = $conn->prepare($sqlphrase . " ORDER BY title DESC");
        }
        else {
            $stmt = $conn->prepare($sqlphrase . " ORDER BY title");
        }
    }
    else if ($sortby == 3) {
        if ($sortorder == 2) {
            $stmt = $conn->prepare($sqlphrase . " ORDER BY role DESC");
        }
        else {
            $stmt = $conn->prepare($sqlphrase . " ORDER BY role");
        }
    }

    echo $conn->error;
    $stmt->bind_result($firstnamefromdb, $lastnamefromdb, $titlefromdb, $rolefromdb, $quotefromdb);
    $stmt->execute();

    $rows = "";
    while ($stmt->fetch()) {
        $rows .= "\t<tr> \n";
        $rows .= "\t\t<td>" . $firstnamefromdb . " " . $lastnamefromdb . "</td>";
        $rows .= "<td>" . $titlefromdb . "</td>";
        $rows .= "<td>" . $rolefromdb . "</td>";
        $rows .= "<td>" . $quotefromdb . "</td>\n";
        $rows .= "\t</tr> \n";
    }

    if (!empty($rows)) {
        $result = "";
        $result .= "<table>";
        $result .= "\t<tr> \n";
        $result .= "\t\t" . '<th>Nimi <a href="?selector='.$selectorvalue .'&sortorder=1&sortby=1&selectorsubmit=Lae+kirje">&uarr;</a>&nbsp<a href="?selector='.$selectorvalue.'&sortorder=2&sortby=1&selectorsubmit=Lae+kirje">&darr;</a></th>' . "\n";
        $result .= "\t\t" . '<th>Filmi nimi <a href="?selector='.$selectorvalue .'&sortorder=1&sortby=2&selectorsubmit=Lae+kirje">&uarr;</a>&nbsp<a href="?selector='.$selectorvalue.'&sortorder=2&sortby=2&selectorsubmit=Lae+kirje">&darr;</a></th>' . "\n";
        $result .= "\t\t" . '<th>Roll <a href="?selector='.$selectorvalue .'&sortorder=1&sortby=3&selectorsubmit=Lae+kirje">&uarr;</a>&nbsp<a href="?selector='.$selectorvalue.'&sortorder=2&sortby=3&selectorsubmit=Lae+kirje">&darr;</a></th>' . "\n";
        $result .= "\t\t<th>Tsitaat</th>\n";
        $result .= $rows;
        $result .= "\t</tr> \n";
        $result .= "</table>";
    }
    
    return $result;
}