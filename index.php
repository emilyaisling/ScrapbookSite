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
?>
<?php include('header.php'); ?>

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
                        <blockquote><?php print $_SESSION['bio'];?></blockquote>
                    </div>
                </div>
            </div>
            <br>
            <a href="#edit-form" class="btn red lighten-1 modal-trigger">Edit Profile</a>
            <div class="modal" id="edit-form">
                <div class="modal-content row">
                    <form action="editProfile.php" method="POST" enctype="multipart/form-data">
                        <div class="input-field col s12">
                            <textarea id="bio" class="materialize-textarea" data-length="250" name="bio"></textarea>
                            <label for="bio">About you...</label>
                        </div>
                        <div class="input-field col s12 selector">
                            <select class="icons" id="photo" name="photo">
                            <option value="" disabled selected>Choose your initial</option>
                            <option value="a" data-icon="img/a.png" class="left">A</option>
                            <option value="b" data-icon="img/b.png" class="left">B</option>
                            <option value="c" data-icon="img/c.png" class="left">C</option>
                            <option value="d" data-icon="img/d.png" class="left">D</option>
                            <option value="e" data-icon="img/e.png" class="left">E</option>
                            <option value="f" data-icon="img/f.png" class="left">F</option>
                            <option value="g" data-icon="img/g.png" class="left">G</option>
                            <option value="h" data-icon="img/h.png" class="left">H</option>
                            <option value="i" data-icon="img/i.png" class="left">I</option>
                            <option value="j" data-icon="img/j.png" class="left">J</option>
                            <option value="k" data-icon="img/k.png" class="left">K</option>
                            <option value="l" data-icon="img/l.png" class="left">L</option>
                            <option value="m" data-icon="img/m.png" class="left">M</option>
                            <option value="n" data-icon="img/n.png" class="left">N</option>
                            <option value="o" data-icon="img/o.png" class="left">O</option>
                            <option value="p" data-icon="img/p.png" class="left">P</option>
                            <option value="q" data-icon="img/q.png" class="left">Q</option>
                            <option value="r" data-icon="img/r.png" class="left">R</option>
                            <option value="s" data-icon="img/s.png" class="left">S</option>
                            <option value="t" data-icon="img/t.png" class="left">T</option>
                            <option value="u" data-icon="img/u.png" class="left">U</option>
                            <option value="v" data-icon="img/v.png" class="left">V</option>
                            <option value="w" data-icon="img/w.png" class="left">W</option>
                            <option value="x" data-icon="img/x.png" class="left">X</option>
                            <option value="y" data-icon="img/y.png" class="left">Y</option>
                            <option value="z" data-icon="img/z.png" class="left">Z</option>
                            </select>
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