<?php
include('dbconnect.php');

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

if (isset($_GET['id']))
{
    $id = $_GET['id'];
    if ($stmt = $pdo->prepare('SELECT title, ingredients, method FROM recipes WHERE id = ?'))
    {
        $stmt->execute(array($id));
        $record = $stmt->fetch(PDO::FETCH_ASSOC);
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
            <h4><?php print $record['title']?></h4>
            <br>
            <h5>Ingredients</h5>
            <ul class="browser-default">
            <?php $ingredients = explode(',', $record['ingredients']);?>
            <?php for ($i=0; $i < count($ingredients); $i++):?>
            <li><?php print $ingredients[$i] ?></li>
            <?php endfor ?>
            </ul>
            <br>
            <h5>Method</h5>
            <ol>
            <?php $steps = explode(',', $record['method']);?>
            <?php for ($i=0; $i < count($steps); $i++):?>
            <li><?php print $steps[$i] ?></li>
            <?php endfor ?>
            </ol>

        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.modal').modal();
            $('#bio').characterCounter();
            $('select').formSelect();
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