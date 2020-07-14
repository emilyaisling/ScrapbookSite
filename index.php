<?php
session_start();

if (!isset($_SESSION['loggedin']))
{
    header('Location: login.html');
    exit;
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
                <a href="index.php" class="right valign-wrapper"><?php print htmlspecialchars($_SESSION['username']);?><i class="large material-icons right">account_circle</i><img src="<?php print $_SESSION['image'];?>" class="responsive-img circle"></a>
                <a href="logout.php"><i class="fas fa-sign-out-alt right"></i>Logout</a>
            </div>
        </nav>
    </header>

    <div class="sidebar orange lighten-5">
        <ul>
            <li><a href="#" class="red-text text-lighten-1">Photos</a></li>
            <li><a href="#" class="red-text text-lighten-1">Music</a></li>
            <li><a href="#" class="red-text text-lighten-1">Books</a></li>
            <li><a href="#" class="red-text text-lighten-1">TV</a></li>
            <li><a href="#" class="red-text text-lighten-1">Films</a></li>
            <li><a href="#" class="red-text text-lighten-1">Recipes</a></li>
            <li><a href="#" class="red-text text-lighten-1">Journal</a></li>
        </ul>
    </div>

    <div class="main">
        <div class="container">
        <h4 class="red-text text-lighten-1">Hello,<?php print htmlspecialchars($_SESSION['username']);?></h4>
            <div class="row">
                <div class="col s12 l4">
                    <br>
                    <br>
                    <i class="material-icons red-text text-lighten-1">account_circle</i>
                    <img src="<?php print $_SESSION['image'];?>" class="responsive-img" id="profileImg">
                    <br>
                </div>
                <div class="col s12 l6 offset-l2">
                    <div class="bio">
                        <br>
                        <br>
                        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Minima, eos reiciendis. 
                            Temporibus deleniti repellat ipsam culpa placeat earum doloribus quod, ut recusandae 
                            vitae sequi? Repudiandae aliquam esse quo autem vel?</p>
                    </div>
                </div>
            </div>
            <br>
            <a href="#edit-form" class="btn red lighten-1 modal-trigger">Edit Profile</a>
            <div class="modal" id="edit-form">
                <div class="modal-content">
                    <form action="editProfile.php" method="POST" enctype="multipart/form-data">
                        <div class="input-field">
                            <textarea id="bio" class="materialize-textarea" data-length="120"></textarea>
                            <label for="bio">About you...</label>
                        </div>
                        <div class="file-field input-field">
                            <div class="btn red lighten-1">
                                <span>Change Photo</span>
                                <input type="file" name="photo">
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" type="text">
                            </div>
                        </div>
                        <div class="input-field right">
                            <button type="submit" class="modal-close btn red lighten-1" name="submit">Save changes</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.modal').modal();
            $('#bio').characterCounter();

        });
        let photoSrc = $('.main img').attr('src');

        if (photoSrc != '')
        {
            $('.main i').css('display', 'none');
            $('nav a i').css('display', 'none');
        }


    </script>
</body>
</html>