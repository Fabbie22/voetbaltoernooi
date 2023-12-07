<?php

require_once("./connection.php");

$dbh = dbcon();
?>
<?php
session_start();
if(!isset($_SESSION['loggedin'])){
  header("Location: ./login.php");
  exit;
}
require_once("./connection.php");

$dbh = dbcon();
?>
<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./reset.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="./style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://kit.fontawesome.com/382a0b3e8b.js" crossorigin="anonymous"></script>
  <title>FIFA - Voetbaltoernooi - Teams</title>
  <link rel="icon" type="image/x-icon" href="./pictures/fifalogo.png">
</head>
<body>
<a class="text-dark" href="./index.php"><button class="btn btn-primary"><i class="fas fa-house" style="color: #ffffff;"></i> Home</button></a>
<?php
$volledigteam = team($dbh);
echo '<div class="table-responsive">';
echo '<table class="table table-striped">';
echo '<thead><tr><th>Teamnaam</th><th>Spelersnaam</th><th>Spelersnummer</th></tr></thead>';
echo '<tbody>';

$currentTeam = null;

foreach ($volledigteam as $data) {
    // Controleren of de teamnaam verandert, alleen weergeven als deze anders is
    if ($data['team_naam'] !== $currentTeam) {
        echo '<tr><td><strong>' . $data['team_naam'] . '</strong></td><td>' . $data['voor_naam'] . ' ' . $data['achter_naam'] . '</td><td>' . $data['spelersnummer'] . '</td></tr>';
        $currentTeam = $data['team_naam'];
    } else {
        echo '<tr><td></td><td>' . $data['voor_naam'] . ' ' . $data['achter_naam'] . '</td><td>' . $data['spelersnummer'] . '</td></tr>';
    }
}

echo '</tbody>';
echo '</table>';
echo '</div>';
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
