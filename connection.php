<?php
function dbcon(){
//Maakt verbinding met database
      $host = 'localhost';
      $dbname = 'voetbaltoernooi';
      $user = 'root';
      $password = '';
      
      $dbh = new PDO('mysql:host='.$host.';dbname='.$dbname, $user, $password);
  
      return $dbh;
}
$dbh = dbcon();
$data = $_POST;
//Add account
if(isset($data['register'])){
      session_start();
     
      $insertinlog = $dbh->prepare("INSERT INTO account (email, user_name, password) VALUES (:email, :user_name, :password)");

      $insertinlog->execute(array(
            'email' => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'user_name' => $data['user_name'], 
      ));

      $lastid = $dbh->lastInsertId();  
}
if(isset($data['register'])){
      $insertspeler = $dbh->prepare("INSERT INTO speler (voor_naam, achter_naam, email, telefoonnummer, spelersnummer, account_id, team_id) VALUES
(:voor_naam, :achter_naam, :email, :telefoonnummer, :spelersnummer, $lastid, :team_id)");

      $querycheck = $insertspeler->execute(array(
            'voor_naam' => $data['voor_naam'],
            'achter_naam' => $data['achter_naam'],
            'email' => $data['email'],
            'telefoonnummer' => $data['telefoonnummer'],
            'spelersnummer' => $data['spelersnummer'],
            'team_id' => '1'   
      ));

      if($querycheck){
            $_SESSION['naam'] = $data['voor_naam']." ".$data['achternaam'];
            $_SESSION['registratie'] = "Account aangemaakt";
            header('Location: register.php');
            exit(0);
          }
        else{
            $_SESSION['registratie'] = "Account aanmaken mislukt";
            header('Location: register.php');
            exit(0);
          }
}
if(isset($data['spelertoevoegen'])){
      $insertspeler = $dbh->prepare("INSERT INTO speler (voor_naam, achter_naam, email, telefoonnummer, spelersnummer, team_id) VALUES
(:voor_naam, :achter_naam, :email, :telefoonnummer, :spelersnummer, :team_id)");

      $querycheck = $insertspeler->execute(array(
            'voor_naam' => $data['voor_naam'],
            'achter_naam' => $data['achter_naam'],
            'email' => $data['email'],
            'telefoonnummer' => $data['telefoonnummer'],
            'spelersnummer' => $data['spelersnummer'],
            'team_id' => '1'   
      ));

      if($querycheck){
            $_SESSION['naam'] = $data['voor_naam']." ".$data['achternaam'];
            $_SESSION['registratie'] = "Account aangemaakt";
            header('Location: register.php');
            exit(0);
          }
        else{
            $_SESSION['registratie'] = "Account aanmaken mislukt";
            header('Location: register.php');
            exit(0);
          }
}

