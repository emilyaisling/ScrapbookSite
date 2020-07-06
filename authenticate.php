<?php
session_start();

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'scrapbook';

try 
{
    $pdo = new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
} 
catch (PDOexception $exception) 
{
    exit('Failed to connect to database!');
}

if (!isset($_POST['username'], $_POST['password'])) 
{
    exit('Please fill in both fields');
}

if($stmt = $pdo->prepare('SELECT id, email, password FROM users WHERE username = ?'))
{
    $stmt->execute(array($_POST['username']));
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result)
    {
       $id = $result['id'];
       $email = $result['email'];
       $password = $result['password'];

       if (password_verify($_POST['password'], $password))
       {
           session_regenerate_id();
           $_SESSION['loggedin'] = TRUE;
           $_SESSION['username'] = $_POST['username'];
           $_SESSION['id'] = $id;
           $_SESSION['email'] = $email;

           header('Location: index.php');
        }
        else
        {
            echo 'Incorrect password';
        }
    }
    else
    {
        echo 'Query returned no results';
    }
}
else
{
    echo 'Failed to execute statement';
}



?>