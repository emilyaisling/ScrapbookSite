<?php
include('dbconnect.php');

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