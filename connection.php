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
//Add account
if(isset($_POST['register'])){
      session_start();
      $email = $_POST['email'];
      $username = $_POST['user_name'];
      $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
      
      $insertinlog = $dbh->prepare("INSERT INTO account (email, user_name, password) VALUES (:email, :user_name, :password)");
      
      $querycheck = $insertinlog->execute(array(
            'email' => $email,
            'password' => $password,
            'user_name' => $username,
      ));
      if($querycheck){
            $_SESSION['naam'] = $username;
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

