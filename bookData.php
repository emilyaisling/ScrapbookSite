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
    if ($stmt = $pdo->prepare("INSERT INTO books (user_id, title, author, description, submitted) VALUES (?,?,?,?,NOW())"))
    {
        $stmt->execute(array($_SESSION['id'], $_POST['title'], $_POST['author'], $_POST['description']));

        if ($stmt = $pdo->prepare('SELECT title, author, description FROM books WHERE user_id = ? ORDER BY submitted DESC'))
        {
            $stmt->execute(array($_SESSION['id']));
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($results)
            {
                foreach ($results as $result)
                {
                    array_push($_SESSION['titles'], $result['title']);
                    array_push($_SESSION['authors'], $result['author']);
                    array_push($_SESSION['descriptions'], $result['description']);

                    header('Location: books.php');
                }
            }
        }
    }
}
?>