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
  <title>FIFA - Voetbaltoernooi</title>
  <link rel="icon" type="image/x-icon" href="./pictures/fifalogo.png">
</head>
<body>
<?php if(isset($_SESSION['spelertoevoegenalert'])) :  ?>
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
       <div><?= $_SESSION['spelertoevoegenalert']?></div>
       <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
            <?php 
                unset($_SESSION['spelertoevoegenalert']);
                endif; 
                ?>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Speler toevoegen aan team</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form action="connection.php" method="post">
          <div class="row">
            <div class="col-md-12 topgap">
              <input type="text" class="form-control" placeholder="Voornaam" aria-label="Voornaam" name="voornaam" id="voornaam" maxlength="100" required>
            </div>
            <div class="col-md-12 topgap">
              <input type="text" class="form-control" placeholder="Achternaam" aria-label="Achternaam" name="achternaam" id="achternaam" maxlength="150" required>
            </div>
            <div class="col-md-12 topgap">
              <input type="email" class="form-control" placeholder="E-mail" aria-label="E-Mail" name="email" id="email" maxlength="200" required>
            </div>
            <div class="col-md-12 topgap">
              <input type="text" class="form-control" placeholder="Telefoonnummer" aria-label="Telefoonnummer" name="telefoonnummer" id="telefoonnummer" maxlength="80" required>
            </div>
            <div class="col-md-12 topgap">
            <label for="spelersnummer">
              Spelersnummer
            </label>
            <select class="form-control" name="spelersnummer" id="spelersnummer" required>
          <?php
            for($i = 1; $i < 100; $i++){
                echo "<option value='$i'>$i</option>";
            }
                  ?>
                </select>
            <label for="team_id">
              Team
            </label>
            <select class="form-control" name="team_id" id="team_id">
          <?php
            $team = teamselect($dbh, 'team', 'WHERE team_id = (SELECT team_id FROM speler WHERE account_id = '.$_SESSION['account_id'].')');
            foreach($team as $data){
                echo "<option value='".$data['team_id']."'>".$data['team_naam']."</option>";
            }
                  ?>
                </select>
          </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Sluiten</button>
          <button type="submit" class="btn btn-primary" name="spelertoevoegen">Opslaan</button>
        </div>
      </form>
      </div>
    </div>
  </div>
</div>
<a class="text-dark" href="./logout.php"><button class="btn btn-primary"><i class="fa-solid fa-arrow-right-from-bracket" style="color: #ffffff;"></i> Uitloggen</button></a>
  <div class="container">
    <div class="row">
  <?php
  if($_SESSION['admin'] == 1){
    
    echo '<div class="card col-md-6">
    <div class="card-body">
      <h2 class="card-title">Teams</h2>
      <p class="card-text">Teams bekijken</p>
      <a href="teams.php"><button type="button" class="btn btn-primary">Teams bekijken</button></a>
    </div>
  </div>
  <div class="card col-md-6">
    <div class="card-body">
      <h2 class="card-title">Wedstrijden</h2>
      <p class="card-text">Bekijk hier de wedstrijden</p>
      <a href="wedstrijd.php"><button type="button" class="btn btn-primary">Wedstrijden bekijken/toevoegen</button></a>
    </div>
  </div>
  </div>
  <div class="row">
  <div class="card col-md-6">
    <div class="card-body">
    <h2 class="card-title">Stand</h2>
    <p class="card-text">Bekijk hier de huidige stand in het kampioenschap</p>
    <a href="stand.php"><button type="button" class="btn btn-primary">Kampioenschap bekijken</button></a>
    </div>
    </div>
    </div>';
  }
  else{
    $alert = alert($dbh, '(SELECT team_id FROM speler WHERE account_id = '.$_SESSION['account_id'].')');
    foreach ($alert as $data) {
      $spelercount = $data['spelercount'];
  
      if ($spelercount < 3) {
          echo '<div class="alert alert-danger topgap2" role="alert">
              Je hebt maar ' . $spelercount . ' spelers, je moet er minimaal 5 hebben
          </div>';
      } elseif ($spelercount >= 3 && $spelercount != 5) {
          echo '<div class="alert alert-warning topgap2" role="alert">
              Je hebt ' . $spelercount . ' spelers, je hebt er minimaal 5 nodig.
          </div>';
      } else {
          echo ''; 
      }
  }
    echo '<div class="card col-md-6">
    <div class="card-body">
    <h2 class="card-title">Team</h2>
    <p class="card-text">Voeg hier je spelers toe, telkens 1 speler!</p>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
    Spelers toevoegen
    </button>
    <a href="teams.php"><button type="button" class="btn btn-primary">
    Teams bekijken
    </button></a>
    </div>
    </div>
    <div class="card col-md-6">
    <div class="card-body">
    <h2 class="card-title">Wedstrijden</h2>
    <p class="card-text">Bekijk hier de wedstrijden</p>
    <a href="wedstrijd.php"><button type="button" class="btn btn-primary">Wedstrijden bekijken</button></a>
    </div>
    </div>
    </div>
    <div class="row">
  <div class="card col-md-6">
    <div class="card-body">
    <h2 class="card-title">Stand</h2>
    <p class="card-text">Bekijk hier de huidige stand in het kampioenschap</p>
    <a href="stand.php"><button type="button" class="btn btn-primary">Kampioenschap bekijken</button></a>
    </div>
    </div>
    </div>';
  }
  ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>