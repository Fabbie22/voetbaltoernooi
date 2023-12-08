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
  <title>FIFA - Voetbaltoernooi - Plannen</title>
  <link rel="icon" type="image/x-icon" href="./pictures/fifalogo.png">
</head>
<body>
<a class="text-dark" href="./index.php"><button class="btn btn-primary"><i class="fas fa-house" style="color: #ffffff;"></i> Home</button></a>
<?php if(isset($_SESSION['uitslag'])) :  ?>
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
       <div><?= $_SESSION['uitslag'] ?></div>
       <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
            <?php 
                unset($_SESSION['uitslag']);
                endif; 
                ?>
<?php
  if($_SESSION['admin'] == 1){
echo '
<div class="container">
<form action="connection.php" method="post">
          <div class="row">
            <div class="col-md-2">
            <label for="arbitrage">
              Arbitrage
            </label>
            <select class="form-control" name="arbitrage_id" id="arbitrage_id" required>
            <option value="" selected disabled>Selecteer een team</option>';
            
            $team = teamselect($dbh, 'arbitrage');
            foreach($team as $data){
                echo "<option value='".$data['arbitrage_id']."'>".$data['arbitrage_team']."</option>";
            }
                  ?>
                  <?php echo '
                </select>
                </div>
            <div class="col-md-2">
            <label for="teamThuis">
              Team Thuis
            </label>
            <select class="form-control" name="teamThuis" id="teamThuis" required>
            <option value="" selected disabled>Selecteer Thuis Team</option>';
            ?>
          <?php
            $team = teamselect($dbh, 'team');
            foreach($team as $data){
                echo "<option value='".$data['team_id']."'>".$data['team_naam']."</option>";
            }
                  ?>
                  <?php echo '
                </select>
          </div>
          <div class="col-md-2">
            <label for="teamUit">
              Team Uit
            </label>
            <select class="form-control" name="teamUit" id="teamUit" required>
            <option value="" selected disabled>Selecteer Uit Team</option>';
            ?>
          <?php
            $team = teamselect($dbh, 'team');
            foreach($team as $data){
                echo "<option value='".$data['team_id']."'>".$data['team_naam']."</option>";
            }
                  ?>
                  <?php echo '
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
    <div class="container">
    <div class="row topgap2">';    
    ?>
    <?php
    $wedstrijd = wedstrijd($dbh);
    foreach($wedstrijd as $data){
      ?>
    <div class="modal fade" id="exampleModal_<?php echo $data['wedstrijd_id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Score toevoegen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="connection.php" method="post">
                        <input type="hidden" name="wedstrijd_id" value="<?php echo $data['wedstrijd_id']; ?>">
                        <div class="mb-3">
                            <input type="number" class="form-control" id="scoreThuis" name="scoreThuis" placeholder="Score Thuis" maxlength="10" required>
                        </div>
                        <div class="mb-3">
                            <input type="number" class="form-control" id="scoreUit" name="scoreUit" placeholder="Score Uit" maxlength="10" required>
                        </div>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuleren</button>
                        <button type="submit" class="btn btn-primary" name="uitslagopslaan">Opslaan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
    <?php
$wedstrijd = wedstrijd($dbh);

echo '<div class="container"><div class="row">';

$columnCount = 0;

foreach ($wedstrijd as $data) {
    $date = date_create($data['datumentijd']);
    if ($data['is_gespeeld'] == 0) {
        $datump = "<p class='card-text'>" . date_format($date, "d-m-Y H:i") . "</p>";
    } else {
        $datump = "<p class='card-text'>Deze wedstrijd is gespeeld</p>";
    }
    
    if (empty($data['scoreThuis']) && empty($data['scoreUit'])) {
        $score = "<p class='card-text'>Er is nog geen score bekend.</p>";
    } else {
        $score = "<p class='card-text'>" . $data['scoreThuis'] . " - " . $data['scoreUit'] . "</p>";
    }
    
    echo "<div class='col-md-4'>
            <div class='card topgap2'>
                <div class='card-body'>
                    <h5 class='card-title'>".$data['teamThuis_naam']." - ".$data['teamUit_naam']."</h5>
                    <p class='card-text'>$datump</p>
                    <p class='card-text'>$score</p>
                    <p class='card-text'><b>Arbitrage</b>: ".$data['arbitrage_team']."</p>
                    <button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#exampleModal_".$data['wedstrijd_id']."'>
                        Score toevoegen
                    </button>
                </div>
            </div>
          </div>";

    $columnCount++;
    if ($columnCount % 3 == 0) {
        echo '</div><div class="row">';
    }
}

echo '</div></div>';

?>

<?php
  }else{
      echo '<div class="container">
      <div class="row topgap2">';
    $wedstrijd = wedstrijd($dbh);
    foreach($wedstrijd as $data){
      $date = date_create($data['datumentijd']);
      if($data['is_gespeeld'] == 0){
        $datump = "<p class='card-text'>".date_format($date, "d-m-Y H:i")."</p>";
      }
        else{
          $datump = "<p class='card-text'>Deze wedstrijd is gespeeld</p>";
        }
          if(empty($data['scoreThuis'] && $data['scoreUit']) ){
            $score = "<p class='card-text'>Er is nog geen score bekend.</p>";
          }else{
            $score = "<p class='card-text'>".$data['scoreThuis']." - ".$data['scoreUit']."</p>";
          }
      echo "<div class='card col-md-3 topgap2'>
      <div class='card-body'>
        <h5 class='card-title'>".$data['teamThuis_naam']." - ".$data['teamUit_naam']."</h5>
        <p class='card-text'>$datump</p>
        <p class='card-text'>$score</p>
        <p class='card-text'><b>Arbitrage</b>: ".$data['arbitrage_team']."</p>
      </div>
    </div>";
    }
    echo '</div>
</div>';
  }

    ?>
    <script>
$(document).ready(function(){
  $('#teamThuis').change(function(){
    var selectedTeamThuis = $(this).val();
    $('#teamUit option').prop('disabled', false);
    $('#teamUit option[value="'+selectedTeamThuis+'"]').prop('disabled', true);
  });

  $('#teamUit').change(function(){
    var selectedTeamUit = $(this).val();
    $('#teamThuis option').prop('disabled', false);
    $('#teamThuis option[value="'+selectedTeamUit+'"]').prop('disabled', true);
  });
});
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>