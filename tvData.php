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
    if ($stmt = $pdo->prepare("INSERT INTO tv (user_id, title, year, description, submitted) VALUES (?,?,?,?,NOW())"))
    {
        $stmt->execute(array($_SESSION['id'], $_POST['title'], $_POST['year'], $_POST['description']));

        if ($stmt = $pdo->prepare('SELECT title, year, description FROM tv WHERE user_id = ? ORDER BY submitted DESC'))
        {
            $stmt->execute(array($_SESSION['id']));
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($results)
            {
                foreach ($results as $result)
                {
                    array_push($_SESSION['tv-titles'], $result['title']);
                    array_push($_SESSION['tv-years'], $result['year']);
                    array_push($_SESSION['tv-descriptions'], $result['description']);

                    header('Location: tv.php');
                }
            }
        }
    }
}
?>