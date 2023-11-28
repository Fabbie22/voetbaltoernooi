<?php
session_start();

require_once('./connection.php');

$dbh = dbcon();

if(isset($_POST["login"])) {  
    $query = "SELECT * FROM account WHERE (user_name = :user_name OR email = :email)";  
    $statement = $dbh->prepare($query);  
    $statement->execute(  
        array(  
            'user_name' => $_POST["user_name"],
            'email' => $_POST["user_name"]
        )  
    );

    $row = $statement->fetch(PDO::FETCH_ASSOC);
    if($row) {
        // Vergelijk het ingevoerde wachtwoord met het gehashte wachtwoord uit de database
        if(password_verify($_POST['password'], $row['password'])) {
            $_SESSION["username"] = $row["user_name"];
            $_SESSION['email'] = $row['email'];
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['admin'] = $row['is_admin'];

            
            header("location:./index.php");  
            exit();
        }
    }
    
    header("Location: ./login.php");  
    exit();
}
?>