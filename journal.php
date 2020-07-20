<?php
session_start();

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

if (!isset($_SESSION['loggedin']))
{
    header('Location: login.html');
    exit;
}

if ($stmt = $pdo->prepare("SELECT bio, photo FROM users WHERE id = ?"))
{
    $stmt->execute(array($_SESSION['id']));
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result)
    {
        $_SESSION['bio'] = $result['bio'];
        $_SESSION['image'] = $result['photo'];
    }
    else
    {
        $_SESSION['image'] = '';
        $_SESSION['bio'] = 'About me...';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="styles.css">
        <!-- Font Awsome icons stylesheet-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
        <!-- Compiled and minified CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
        <!--Import Google Icon Font-->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>Scrapbook</title>
</head>
<body>   
    <header>
        <nav class="nav-wrapper">
            <div class="container">
                <a href="index.php" class="brand-logo">Scrapbook</a>
                <ul class="right">
                    <li class="hide-on-med-and-down"><a href="index.php" class="valign-wrapper"><?php print htmlspecialchars($_SESSION['username']);?><i class="large material-icons right navcon">account_circle</i><img src="<?php print $_SESSION['image'];?>" class="responsive-img circle"></a></li>
                    <li class="hide-on-med-and-down"><a href="logout.php">Log out <i class="fas fa-sign-out-alt"></i></a></li>
                </ul>
            </div>
        </nav>
    </header>

    <div class="sidebar orange lighten-5">
        <ul>
            <li class="hide-on-large-only"><a href="index.php" class="valign-wrapper brown-text text-lighten-1"><?php print htmlspecialchars($_SESSION['username']);?><i class="material-icons right navcon">account_circle</i><img src="<?php print $_SESSION['image'];?>" class="responsive-img circle"></a></li>
            <li class="hide-on-large-only toplink"><a href="logout.php" class="brown-text text-lighten-1">Log out <i class="fas fa-sign-out-alt"></i></a></li>
            <li><a href="photos.php" class="red-text text-lighten-1">Photos</a></li>
            <li><a href="music.php" class="red-text text-lighten-1">Music</a></li>
            <li><a href="books.php" class="red-text text-lighten-1">Books</a></li>
            <li><a href="tv.php" class="red-text text-lighten-1">TV</a></li>
            <li><a href="films.php" class="red-text text-lighten-1">Films</a></li>
            <li><a href="recipes.php" class="red-text text-lighten-1">Recipes</a></li>
            <li><a href="journal.php" class="red-text text-lighten-1">Journal</a></li>
        </ul>
    </div>

    <div class="main">
        <div class="container">
            <div class="card journal-form">
                <form action="journal.php">
                    <div class="card-content">
                        <span class="card-title">
                            <div class="input-field">
                                <input type="text" class="datepicker" name="date">
                            </div>
                        </span>
                        <div class="input-field">
                            <textarea id="entry" class="materialize-textarea" data-length="2000" name="entry"></textarea>
                        </div>
                    </div>
                    <div class="card-action">
                        <div class="input-field center-align">
                            <button type="submit" class="btn red lighten-1" name="submit">New Entry</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php
        if (isset($_POST['submit']))
        {
            if ($stmt = $pdo->prepare('INSERT INTO journal (user_id, date, entry) VALUES (?,?,?)'))
            {
                $stmt->execute($_SESSION['id'], $_POST['date'], $_POST['entry']);
            }
        }
    ?>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.datepicker').datepicker();
            $('#entry').characterCounter();
        });


        let photoSrc = $('.main img').attr('src');

        if (photoSrc != '')
        {
            $('.main i').css('display', 'none');
            $('.navcon').css('display', 'none');
        }
    </script>
</body>
</html>