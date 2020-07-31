<?php
include('dbconnect.php');

if (!isset($_POST['username'], $_POST['email'], $_POST['password']))
{
    echo 'Please fill in all fields';
}

if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
{
    echo 'Please enter a valid email address';
}
if (!preg_match("/^[a-zA-Z0-9]+$/", $_POST['username']))
{
    echo 'Name must only contain letters and numbers';
}
if (strlen($_POST['password']) < 5 | strlen($_POST['password'] > 20))
{
    echo 'Password must be between 5 and 20 characters';
}

if ($stmt = $pdo->prepare('SELECT id, password WHERE username = ?'))
{
    $stmt->execute(array($_POST['username']));
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$result)
    {
        if ($stmt = $pdo->prepare('INSERT INTO users (username, email, password) VALUES (?,?,?)'))
        {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $stmt->execute(array($_POST['username'], $_POST['email'], $password));
            header('Location: index.php');
        }
        else
        {
            echo 'Statement not prepared';
        }
    }
    else
    {
        echo 'Username already exists, please enter another';
    }
}
else
{
    echo 'Username check not prepared';
}

?>