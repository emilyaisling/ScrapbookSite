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
<?php include('header.php'); ?>

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