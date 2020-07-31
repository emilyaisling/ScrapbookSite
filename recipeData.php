<?php
include('dbconnect.php');

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