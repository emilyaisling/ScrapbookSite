<?php
include('dbconnect.php');

$_SESSION['recipes'] = array();

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
<?php include('header.php'); ?>

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
                <div class="col s2 l2">
                    <a class="btn-floating white" id="white"></a>
                </div>
                <div class="col s2 l2">
                    <a class="btn-floating teal lighten-4" id="teal"></a>
                </div>
                <div class="col s2 l2">
                    <a class="btn-floating red lighten-1" id="red"></a>
                </div>
                <div class="col s2 l2">
                    <a class="btn-floating deep-purple lighten-3" id="purple"></a>
                </div>
                <div class="col s2 l2">
                    <a class="btn-floating light-green lighten-3" id="green"></a>
                </div>
                <div class="col s2 l2">
                    <a class="btn-floating yellow lighten-3" id="yellow"></a>
                </div>
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

            $('#white').click(function(){
                $('.entry-card').css("background-color", '#ffffff')
            });
            $('#teal').click(function(){
                $('.entry-card').css("background-color", '#b2dfdb')
            });
            $('#red').click(function(){
                $('.entry-card').css("background-color", '#ef5350')
            });
            $('#purple').click(function(){
                $('.entry-card').css("background-color", '#b39ddb')
            });
            $('#green').click(function(){
                $('.entry-card').css("background-color", '#c5e1a5')
            });
            $('#yellow').click(function(){
                $('.entry-card').css("background-color", '#fff59d')
            });
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