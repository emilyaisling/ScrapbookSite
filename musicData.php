<?php
include('dbconnect.php');

if (isset($_POST['submit']))
{
    if ($stmt = $pdo->prepare("INSERT INTO music (user_id, title, artist, year, submitted) VALUES (?,?,?,?,NOW())"))
    {
        $stmt->execute(array($_SESSION['id'], $_POST['title'], $_POST['artist'], $_POST['year']));

        if ($stmt = $pdo->prepare('SELECT title, artist, year FROM music WHERE user_id = ? ORDER BY submitted DESC'))
        {
            $stmt->execute(array($_SESSION['id']));
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($results)
            {
                foreach ($results as $result)
                {
                    array_push($_SESSION['song-titles'], $result['title']);
                    array_push($_SESSION['artists'], $result['artist']);
                    array_push($_SESSION['years'], $result['year']);

                    header('Location: music.php');
                }
            }
        }
    }
}
?>