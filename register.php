<?php
session_start();
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
<body class="loginscherm">
<?php if(isset($_SESSION['registratie'])) :  ?>
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
       <div><?= $_SESSION['registratie']." voor ".$_SESSION['naam']." " ?><a href="index.php">Inloggen</a></div>
       <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
            <?php 
                unset($_SESSION['registratie']);
                endif; 
                ?>
<div class="login">
    <h1>Registereren</h1>
    <form action="connection.php" method="POST" autocomplete="off">
    <label for="email">
					<i class="fas fa-envelope"></i>
				</label>
				<input type="email" name="email" placeholder="Email" id="email" required>
                <label for="username">
                    <i class="fas fa-user"></i>
                </label>
                <input type="text" name="user_name" placeholder="Gebruikersnaam" id="user_name" required>
                <label for="password">
                    <i class="fas fa-lock"></i>
                </label>
                <input type="password" name="password" placeholder="Wachtwoord" id="password" required>
        <label for="voor_naam">
            <i class="fas fa-user"></i>
        </label>
        <input type="text" name="voor_naam" placeholder="Voornaam" id="voor_naam" required>
        <label for="achter_naam">
            <i class="fas fa-user"></i>
        </label>
        <input type="text" name="achter_naam" placeholder="Achternaam" id="achter_naam" required>
        <label for="telefoonnummer">
            <i class="fas fa-user"></i>
        </label>
        <input type="text" name="telefoonnummer" placeholder="Telefoonnummer" id="telefoonnummer" required>
        <label for="spelersnummer">
            <i class="fas fa-user"></i>
        </label>
        <select name="spelersnummer" id="spelersnummer" required>
          <?php
            for($i = 1; $i < 100; $i++){
                echo "<option value='$i'>$i</option>";
            }
                  ?>
                </select>          
        <div class="form-label">
            <p>Heb je al een account?</p>
            <a href="login.php">Log hier in</a>
        </div>
        <input type="submit" value="Registeren" name="register">
    </form>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>