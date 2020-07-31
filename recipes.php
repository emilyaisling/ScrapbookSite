<?php
session_start();

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'scrapbook';

$_SESSION['recipes'] = array();

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

if ($stmt = $pdo->prepare('SELECT id, title, ingredients, method FROM recipes WHERE user_id = ? ORDER BY submitted DESC'))
{
    $stmt->execute(array($_SESSION['id']));
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($results)
    {
        $_SESSION['recipes'] = $results;
    }
}
if (!isset($_SESSION['recipes'][2]))
{
    $lSize = 'l12';
}
else
{
    $lSize = 'l6';
}
if (isset($_SESSION['recipes'][0]))
{
    $recipes = $_SESSION['recipes'];
}
else
{
    $recipes = array();
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
                <form action="recipeData.php" method="POST">
                    <div class="card-content">
                        <span class="card-title">
                            <div class="input-field">
                                <input type="text" name="title" id="title">
                                <label for="title">Title</label>
                            </div>
                        </span>
                        <div class="input-field">
                            <textarea class="materialize-textarea" data-length="1000" type="text" name="ingredients" id="ingredients"></textarea>
                            <label id='smallcomma' for="ingredients">Ingredients (comma separated)</label>
                        </div>
                        <div class="input-field">
                            <textarea class="materialize-textarea" data-length="2000" id="method" type="text" name="method"></textarea>
                            <label for="method">Method (comma separated)</label>
                        </div>
                    </div>
                    <div class="card-action">
                        <div class="input-field center-align">
                            <button type="submit" class="btn red lighten-1" name="submit">Add Recipe</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="row">
                <?php foreach ($recipes as $recipe):?>
                <?php $ingredients = explode(',', $recipe['ingredients']);?>
                    <div class="col s12 m12 <?php print $lSize?>">
                        <div class="card entry-card">
                            <div class="card-content">
                                <div class="card-title center-align">
                                    <span><?php print $recipe['title']?></span>
                                </div>
                                <ul class="entry-text browser-default">
                                    <?php for ($i=0; $i < count($ingredients); $i++):?>
                                    <li><?php print $ingredients[$i]?></li>
                                    <?php endfor ?>
                                </ul>
                                <br>
                            </div>
                            <div class="card-action">
                                <a class="red-text text-lighten-1" href="method.php?id=<?php echo $recipe['id']?>">More Info</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach?>
            </div>

        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script> 
        $(document).ready(function(){
            $('#ingredients').characterCounter();
            $('#method').characterCounter();
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