<?php
$database = "if20_mait_ju_1";

//Andmebaasist filmide lugemise funktsioon

function readfilms($choice) {
	$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);	
	//$stmt = $conn->prepare("SELECT pealkiri, aasta, kestus, zanr, tootja, lavastaja FROM film");
	if ($choice == 0) {
		$stmt = $conn->prepare("SELECT * FROM film");
	} else {
		$stmt = $conn->prepare("SELECT * FROM film ");
	}

	$stmt->bind_result($titlefromdb, $yearfromdb, $durationfromdb, $genrefromdb, $studiofromdb, $directorfromdb);
	$stmt->execute();
	$filmhtml = "<ol> \n";
	while ($stmt->fetch()) {
	$filmhtml .= "\t\t<li>" . $titlefromdb . "\n";
	$filmhtml .= "\t\t\t<ul> \n";
	$filmhtml .= "\t\t\t\t<li>" . $yearfromdb . "</li> \n";
	$filmhtml .= "\t\t\t\t<li>" . $genrefromdb. "</li> \n";
	$filmhtml .= "\t\t\t\t<li>" . $studiofromdb. "</li> \n";
	$filmhtml .= "\t\t\t\t<li>" . $directorfromdb. "</li> \n";
	$filmhtml .= "\t\t\t</ul> \n";
	$filmhtml .= "\t\t</li> \n";
	}
	$filmhtml .= "\t </ol> \n";
	$stmt->close();
	$conn->close();
	return $filmhtml;
}

//Salvestan filmi info andmebaasi

function storefilminfo($title, $year, $duration, $genre, $studio, $director) {
	$success = 0; 
	$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
	$stmt = $conn->prepare("INSERT INTO film (pealkiri, aasta, kestus, zanr, tootja, lavastaja) VALUES (?, ?, ?, ?, ?, ?)");
	echo $ocnn->error;
	$stmt->bind_param("siisss", $title, $year, $duration, $genre, $studio, $director);
	if ($stmt->execute()) {
		$success = 1;
	}
	$stmt->close();
	$conn->close();
	return success;
}
