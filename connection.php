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