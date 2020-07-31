<?php
include('dbconnect.php');

$_SESSION['dates'] = array();
$_SESSION['entries'] = array();

if (!isset($_SESSION['loggedin']))
{
    header('Location: login.html');
    exit;
}

if ($stmt = $pdo->prepare('SELECT date, entry FROM journal WHERE user_id = ? ORDER BY submitted DESC'))
{
    $stmt->execute(array($_SESSION['id']));
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($results)
    {
        foreach ($results as $result)
        {
            array_push($_SESSION['dates'], $result['date']);
            array_push($_SESSION['entries'], $result['entry']);
        }
    }
}

if (!isset($_SESSION['dates'][2]))
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
                <form action="journalData.php" method="POST">
                    <div class="card-content">
                        <span class="card-title">
                            <div class="input-field">
                                <input type="text" class="datepicker" name="date" id="date">
                                <label for="date">Date</label>
                            </div>
                        </span>
                        <div class="input-field">
                            <textarea id="entry" class="materialize-textarea" data-length="2000" name="entry"></textarea>
                            <label for="entry">Entry</label>
                        </div>
                    </div>
                    <div class="card-action">
                        <div class="input-field center-align">
                            <button type="submit" class="btn red lighten-1" name="submit">Add Entry</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="row">
            <?php for($i=0;$i<count($_SESSION['dates']);$i++) :?>
            <div class="col s12 m12 <?php print $lSize?>">
                <div class="card entry-card">
                    <div class="card-content">
                        <div class="card-title">
                        <span><?php print $_SESSION['dates'][$i]?></span>
                        </div>
                        <div class="entry-text">
                        <span><?php print $_SESSION['entries'][$i]?></span>
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