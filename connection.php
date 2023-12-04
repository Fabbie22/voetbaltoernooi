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
            'team_id' => $data['team_id']   
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
            'voor_naam' => $data['voornaam'],
            'achter_naam' => $data['achternaam'],
            'email' => $data['email'],
            'telefoonnummer' => $data['telefoonnummer'],
            'spelersnummer' => $data['spelersnummer'],
            'team_id' => $data['team_id']   
      ));

      if($querycheck){
            $_SESSION['naam'] = $data['voor_naam']." ".$data['achternaam'];
            $_SESSION['spelertoevoegenalert'] = "Speler toegevoegd";
            header('Location: index.php');
            exit(0);
          }
        else{
            $_SESSION['spelertoevoegenalert'] = "Speler toegevoegd mislukt";
            header('Location: index.php');
            exit(0);
          }
}
if(isset($data['wedstrijdplannen'])){
      $insertwedstrijd = $dbh->prepare("INSERT INTO wedstrijd (arbitrage_id, teamThuis, teamUit, datumentijd) VALUES (:arbitrage_id, :teamThuis, :teamUit, :datumentijd)");

      $querycheck = $insertwedstrijd->execute(array(
            'arbitrage_id' => $data['arbitrage_id'],
            'teamThuis' => $data['teamThuis'],
            'teamUit' => $data['teamUit'],
            'datumentijd' => $data['datumentijd']
      ));

      if($querycheck){
            $_SESSION['wedstrijdtoevoegenalert'] = "Speler toegevoegd";
            header('Location: wedstrijdplannen.php');
            exit(0);
          }
        else{
            $_SESSION['wedstrijdtoevoegenalert'] = "Speler toegevoegd mislukt";
            header('Location: wedstrijdplannen.php');
            exit(0);
          }
}
function teamselect($dbh, $tabelnaam){
      $team = array();

      $teamquery = $dbh->prepare("SELECT * FROM $tabelnaam");

      $teamquery->execute();

      while($row = $teamquery->fetch(PDO::FETCH_ASSOC)){
            $team[] = $row;
      }

      return $team;
}
function wedstrijd($dbh){
      $wedstrijd = array();

      $wedstrijdquery = $dbh->prepare("SELECT * FROM wedstrijd 
      INNER JOIN arbitrage ON wedstrijd.arbitrage_id = arbitrage.arbitrage_id
      INNER JOIN team ON team.teamThuis = wedstrijd.team");

      $wedstrijdquery->execute();

      while($row = $wedstrijdquery->fetch(PDO::FETCH_ASSOC)){
            $wedstrijd[] = $row;
      }

      return $wedstrijd;
}

