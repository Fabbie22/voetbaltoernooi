<?php
session_start();
if(!isset($_SESSION['loggedin'])){
  header("Location: ./login.php");
  exit;
}elseif($_SESSION['admin'] == 0){
    header("Location: ./index.php");
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
  <title>FIFA - Voetbaltoernooi - Plannen</title>
  <link rel="icon" type="image/x-icon" href="./pictures/fifalogo.png">
</head>
<body>
<a class="text-dark" href="./logout.php"><button class="btn btn-primary"><i class="fa-solid fa-arrow-right-from-bracket" style="color: #ffffff;"></i> Uitloggen</button></a>
<div class="container">
<form action="connection.php" method="post">
          <div class="row">
            <div class="col-md-2">
            <label for="arbitrage">
              Arbitrage
            </label>
            <select class="form-control" name="arbitrage_id" id="arbitrage_id" required>
          <?php
            $team = teamselect($dbh, 'arbitrage');
            foreach($team as $data){
                echo "<option value='".$data['arbitrage_id']."'>".$data['arbitrage_team']."</option>";
            }
                  ?>
                </select>
                </div>
            <div class="col-md-2">
            <label for="teamThuis">
              Team Thuis
            </label>
            <select class="form-control" name="teamThuis" id="teamThuis" required>
          <?php
            $team = teamselect($dbh, 'team');
            foreach($team as $data){
                echo "<option value='".$data['team_id']."'>".$data['team_naam']."</option>";
            }
                  ?>
                </select>
          </div>
          <div class="col-md-2">
            <label for="teamUit">
              Team Uit
            </label>
            <select class="form-control" name="teamUit" id="teamUit" required>
          <?php
            $team = teamselect($dbh, 'team');
            foreach($team as $data){
                echo "<option value='".$data['team_id']."'>".$data['team_naam']."</option>";
            }
                  ?>
                </select>
          </div>
          <div class="col-md-2">
          <label for="datumentijd">
              Datum en tijd
        </label>
          <input class="formcontrol" type="datetime-local" name="datumentijd" id="datumentijd">
        </div>
        <div class="col-md-2">
          <button type="submit" class="btn btn-primary" name="wedstrijdplannen">Opslaan</button>
        </div>
        </form>
    </div>
    <?php
    $team = teamselect($dbh, 'wedstrijd');
    foreach($team as $data){
        echo "<div class='card' style='width: 18rem;'>
        <div class='card-body'>
          <h5 class='card-title'>".$data['team_naam']. " - ". $data['team_naam']."</h5>
          <p class='card-text'>Some quick example text to build on the card title and make up the bulk of the cards content.</p>
        </div>
      </div>";
    }
    ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>