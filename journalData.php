<?php
include('dbconnect.php');

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