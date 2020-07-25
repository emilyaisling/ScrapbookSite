<?php
session_start();
date_default_timezone_set('GMT');

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

if (isset($_POST['submit']))
{
    if ($stmt = $pdo->prepare("INSERT INTO recipes (user_id, title, ingredients, method, submitted) VALUES (?,?,?,?,NOW())"))
    {
        $stmt->execute(array($_SESSION['id'], $_POST['title'], $_POST['ingredients'], $_POST['method']));
        echo 'executed';

        if ($stmt = $pdo->prepare('SELECT id, title, ingredients, method FROM recipes WHERE user_id = ? ORDER BY submitted DESC'))
        {
            $stmt->execute(array($_SESSION['id']));
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($results)
            {
                $_SESSION['recipes'] = $results;
                header('Location: recipes.php');
            }
            else
            {
                echo 'no results';
            }
        }
    }
}
?>