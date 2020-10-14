<!DOCTYPE html>
<html lang="et">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="style.css">
  <title>Gheto filmibaas</title>
  <style>
    <?php
      echo "body { \n";
      if (isset($_SESSION["userbgcolor"])) {
        echo "\t \t background-color:  " . $_SESSION["userbgcolor"] . "; \n";
      }
      else {
        echo "\t \t background-color: #122932; \n";
      }
      if (isset($_SESSION["usertxtcolor"])) {
        echo "\t \t color: " . $_SESSION["usertxtcolor"] . "; \n";
      }
      else {
        echo "\t \t color: #000000;";
      }
    
    ?> 
  </style>

</head>
<body>
