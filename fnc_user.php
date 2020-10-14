<?php

$database = "if20_mait_ju_1";

function signup($firstname, $lastname, $email, $gender, $birthdate, $password) {
    $result = 0;
    $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);	
    $stmt = $conn->prepare("INSERT INTO vpusers (firstname, lastname, birthdate, gender, email, password) VALUES (?, ?, ?, ?, ?, ?)");
    echo $conn->error;

    //Krypteerime parooli
    $options = ["cost" => 12, "salt" => substr(sha1(rand()), 0, 22)];
    $pwdhash = password_hash($password, PASSWORD_BCRYPT, $options);

    $stmt->bind_param("sssiss", $firstname, $lastname, $birthdate, $gender, $email, $pwdhash);
    
    if ($stmt->execute()) {
        $result = "ok";
    }
    else {
        $result = $stmt->error;
    }
    $stmt->close();
    $conn->close();

    return $result;

}

function signin($email, $password) {
    $result = 0;
    $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);	
    $stmt = $conn->prepare("SELECT password FROM vpusers WHERE email = ?");
    echo $conn->error;
    $stmt -> bind_param("s", $email);
    $stmt -> bind_result($passwordfromdb);

    //Testi, kas execute k2sk t88tab
    if ($stmt->execute()) {
        if ($stmt->fetch()) {
            //Kui tuli vaste, kasutjaa on olemas
            if (password_verify($password, $passwordfromdb)) {
                //Parool 6ige, sisselogimine
                $stmt->close();
                //Loen sisseloginud kasutaja nime ja id
                $stmt = $conn->prepare("SELECT vpusers_id, firstname, lastname FROM vpusers WHERE email = ?");
                echo $conn->error;
                $stmt->bind_param("s", $email);
                $stmt->bind_result($idfromdb, $firstnamefromdb, $lastnamefromdb);
                $stmt->execute();
                $stmt->fetch();

                $_SESSION["userid"] = $idfromdb;
                $_SESSION["userfirstname"] = $firstnamefromdb;
                $_SESSION["userlastname"] = $lastnamefromdb;
                $stmt->close();

                //kasutajaprofiil, tausta ja tekstiv2rv
                //Lugeda andmebaasist kasutajaprofiili, kui sab tfetch k2suga v2rvid, siis need, muidumust (#000000) ja valge(#FFFFFF)
                $stmt = $conn->prepare("SELECT bgcolor, txtcolor FROM vpuserprofiles WHERE userid = ?");
                $stmt->bind_param("i", $_SESSION["userid"]);
                $stmt->bind_result($bgcolorfromdb, $txtcolorfromdb);

                if ($stmt->execute()) {
                    if($stmt->fetch()) {
                        $_SESSION["userbgcolor"] = $bgcolorfromdb;
                        $_SESSION["usertxtcolor"] = $txtcolorfromdb;

                    }
                    else {
                        $_SESSION["userbgcolor"] = "#CCCCCC";
                        $_SESSION["usertxtcolor"] = "#000066"; 
                    }
                }

                $stmt->close();
                $conn->close();

                header("Location: home.php");
                exit();
            }
            else {
                $result = "Kahjuks vale parool";
            }
        }
        else {
            $result = "Kasutajat (" .$email .") pole olemas!";
        }
    }
    else {
        $result = $stmt -> error;
    }
    
    $stmt->close();
    $conn->close();

    return $result;
}

function storeuserprofile($description, $bgcolor, $txtcolor) {
    $result = 0;
    $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);	
    $stmt = $conn->prepare("SELECT vpuserprofiles_id FROM vpuserprofiles WHERE userid = ?");
    $stmt->bind_param("i", $_SESSION["userid"]);
    $stmt->bind_result($userid);

    if ($stmt->execute()) {
        if ($stmt->fetch()) {
            $stmt->close();
            $stmt = $conn->prepare("UPDATE vpuserprofiles SET description = ?, bgcolor = ?, txtcolor = ? WHERE userid = ?");
            echo $conn->error;
            $stmt->bind_param("sssi", $description, $bgcolor, $txtcolor, $_SESSION["userid"]);

            if ($stmt->execute()) {
                $result = "ok";
                $stmt->close();
                $conn->close();
            }
            else {
                $result = $stmt->error;
            }

        }
        else {
            $stmt->close();
            $stmt = $conn->prepare("INSERT INTO vpuserprofiles (userid, description, bgcolor, txtcolor) VALUES (?, ?, ?, ?)");
            echo $conn->error;
            $stmt->bind_param("isss", $_SESSION["userid"], $description, $bgcolor, $txtcolor);
            
            if ($stmt->execute()) {
                $result = "ok";
                $stmt->close();
                $conn->close();
            }
            else {
                $result = $stmt->error;
            }
        }

    }
    else {
        $result = $stmt->error;
    }

    return $result;

}

function readuserdescription() {
    $result = "";
    $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);	
    $stmt = $conn->prepare("SELECT description FROM vpuserprofiles WHERE userid = ?");
    $stmt->bind_param("i", $_SESSION["userid"]);
    $stmt->bind_result($descriptionfromdb);

    if ($stmt->execute()) {
        if ($stmt->fetch()) {
            $result = $descriptionfromdb;
            $stmt->close();
            $conn->close();

        }
    }
    else {
        $result = $stmt->error;
    }

    return $result;
}