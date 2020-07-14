
<?php
session_start();
$_SESSION['image'] = '';

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
    $folder = 'img/';
    $file = $folder . basename($_FILES['photo']['name']);
    $fileTmpName = $_FILES['photo']['tmp_name'];
    $fileSize = $_FILES['photo']['size'];
    $fileType = strtolower(pathinfo($file,PATHINFO_EXTENSION));

    $validExtensions = array('jpg', 'jpeg', 'png', 'gif', 'pdf');

    if (in_array($fileType, $validExtensions))
    {
        if ($fileSize < 1000000)
        {
            if (! file_exists($file))
            {
                $_SESSION['image'] = $file;
                move_uploaded_file($fileTmpName, $file);
                header('Location: index.php');
            }
        }
    }
}

?>