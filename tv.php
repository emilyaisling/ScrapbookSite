<?php
include('dbconnect.php');

$_SESSION['tv-titles'] = array();
$_SESSION['tv-years'] = array();
$_SESSION['tv-descriptions'] = array();

if (!isset($_SESSION['loggedin']))
{
    header('Location: login.html');
    exit;
}

if ($stmt = $pdo->prepare('SELECT title, year, description FROM tv WHERE user_id = ? ORDER BY submitted DESC'))
{
    $stmt->execute(array($_SESSION['id']));
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($results)
    {
        foreach ($results as $result)
        {
            array_push($_SESSION['tv-titles'], $result['title']);
            array_push($_SESSION['tv-years'], $result['year']);
            array_push($_SESSION['tv-descriptions'], $result['description']);
        }
    }
}
if (!isset($_SESSION['tv-titles'][2]))
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
                <form action="tvData.php" method="POST">
                    <div class="card-content">
                        <span class="card-title">
                            <div class="input-field">
                                <input type="text" name="title" id="title">
                                <label for="title">Title</label>
                            </div>
                        </span>
                        <div class="input-field">
                            <input type="text" name="year" id="year">
                            <label for="year">Year(s)</label>
                        </div>
                        <div class="input-field">
                            <textarea id="description" class="materialize-textarea" data-length="500" name="description"></textarea>
                            <label for="description">Description</label>
                        </div>
                    </div>
                    <div class="card-action">
                        <div class="input-field center-align">
                            <button type="submit" class="btn red lighten-1" name="submit">Add TV Series</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="row">
                <?php for($i=0;$i<count($_SESSION['tv-titles']);$i++) :?>
                    <div class="col s12 m12 <?php print $lSize?>">
                        <div class="card entry-card">
                            <div class="card-content">
                                <div class="card-title">
                                    <span><?php print $_SESSION['tv-titles'][$i]?></span>
                                </div>
                                <div class="entry-text">
                                    <span><?php print $_SESSION['tv-years'][$i]?></span>
                                </div>
                                <br>
                                <div class="entry-text">
                                    <span><?php print $_SESSION['tv-descriptions'][$i]?></span>
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