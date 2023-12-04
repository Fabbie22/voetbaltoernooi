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
</body>
<div class="login">
    <h1>Inloggen</h1>
    <form action="authentication.php" method="POST">
        <label for="username">
            <i class="fas fa-user"></i>
        </label>
        <input type="text" name="user_name" placeholder="Gebruikersnaam" id="user_name" required>
        <label for="password">
            <i class="fas fa-lock"></i>
        </label>
        <input type="password" name="password" placeholder="Wachtwoord" id="password" required>
        <div class="form-label">
            <p>Heb je nog geen account?</p>
            <a href="register.php   ">Registreer hier</a>
        </div>
        <input type="submit" value="Login" name="login">
    </form>
</div>
<script src="script.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>