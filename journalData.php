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
            if ($stmt = $pdo->prepare("INSERT INTO journal (user_id, date, entry, submitted) VALUES (?,?,?, NOW())"))
            {
                $stmt->execute(array($_SESSION['id'], $_POST['date'], $_POST['entry']));

                if ($stmt = $pdo->prepare('SELECT date, entry FROM journal WHERE user_id = ? ORDER BY submitted DESC'))
                {
                    $stmt->execute(array($_SESSION['id']));
                    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if ($results)
                    {
                        foreach ($results as $result)
                        {
                            array_push($_SESSION['dates'], $result['date']);
                            array_push($_SESSION['entries'], $result['entry']);

                            header('Location: journal.php');
                        }
                    }
                }
            }
        }
    ?>