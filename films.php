<?php
include('dbconnect.php');

$_SESSION['film-titles'] = array();
$_SESSION['film-years'] = array();
$_SESSION['film-descriptions'] = array();

if (!isset($_SESSION['loggedin']))
{
    header('Location: login.html');
    exit;
}

if ($stmt = $pdo->prepare('SELECT title, year, description FROM films WHERE user_id = ? ORDER BY submitted DESC'))
{
    $stmt->execute(array($_SESSION['id']));
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($results)
    {
        foreach ($results as $result)
        {
            array_push($_SESSION['film-titles'], $result['title']);
            array_push($_SESSION['film-years'], $result['year']);
            array_push($_SESSION['film-descriptions'], $result['description']);
        }
    }
}
if (!isset($_SESSION['film-titles'][2]))
{
    $lSize = 'l12';
}
else
{
    $lSize = 'l6';
}

?>
<?php include('header.php'); ?>

    <div class="main">
        <div class="container">

            <div class="card journal-form">
                <form action="filmData.php" method="POST">
                    <div class="card-content">
                        <span class="card-title">
                            <div class="input-field">
                                <input type="text" name="title" id="title">
                                <label for="title">Title</label>
                            </div>
                        </span>
                        <div class="input-field">
                            <input type="text" name="year" id="year">
                            <label for="year">Year</label>
                        </div>
                        <div class="input-field">
                            <textarea id="description" class="materialize-textarea" data-length="500" name="description"></textarea>
                            <label for="description">Description</label>
                        </div>
                    </div>
                    <div class="card-action">
                        <div class="input-field center-align">
                            <button type="submit" class="btn red lighten-1" name="submit">Add Film</button>
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
                <?php for($i=0;$i<count($_SESSION['film-titles']);$i++) :?>
                    <div class="col s12 m12 <?php print $lSize?>">
                        <div class="card entry-card">
                            <div class="card-content">
                                <div class="card-title">
                                    <span><?php print $_SESSION['film-titles'][$i]?></span>
                                </div>
                                <div class="entry-text">
                                    <span><?php print $_SESSION['film-years'][$i]?></span>
                                </div>
                                <br>
                                <div class="entry-text">
                                    <span><?php print $_SESSION['film-descriptions'][$i]?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endfor?>
            </div>

        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#description').characterCounter();

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