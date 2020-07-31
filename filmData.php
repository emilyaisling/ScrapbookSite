<?php
include('dbconnect.php');

if (isset($_POST['submit']))
{
    if ($stmt = $pdo->prepare("INSERT INTO films (user_id, title, year, description, submitted) VALUES (?,?,?,?,NOW())"))
    {
        $stmt->execute(array($_SESSION['id'], $_POST['title'], $_POST['year'], $_POST['description']));

        if ($stmt = $pdo->prepare('SELECT title, year, description FROM films WHERE user_id = ? ORDER BY submitted DESC'))
        {
            $stmt->execute(array($_SESSION['id']));
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($results)
            {
                foreach ($results as $result)
                {
                    array_push($_SESSION['film-titles'], $result['title']);
                    array_push($_SESSION['film-years'], $result['year']);
                    array_push($_SESSION['film-descriptions'], $result['description']);

                    header('Location: films.php');
                }
            }
        }
    }
}
?>