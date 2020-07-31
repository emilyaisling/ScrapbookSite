<?php
include('dbconnect.php');


if (isset($_POST['submit']))
{
    if (isset($_POST['photo']))
    {
        $_SESSION['formSet'] = TRUE;
        $file = '';

        $initial = $_POST['photo'];

        switch ($initial) 
        {
            case 'a':
                $file = 'img/a.png';
                break;
            
            case 'b':
                $file = 'img/b.png';
                break;
            
            case 'c':
                $file = 'img/c.png';
                break;
            
            case 'd':
                $file = 'img/d.png';
                break;
            
            case 'e':
                $file = 'img/e.png';
                break;
            
            case 'f':
                $file = 'img/f.png';
                break;
            
            case 'g':
                $file = 'img/g.png';
                break;
            
            case 'h':
                $file = 'img/h.png';
                break;
            
            case 'i':
                $file = 'img/h.png';
                break;
            
            case 'j':
                $file = 'img/h.png';
                break;
            
            case 'k':
                $file = 'img/k.png';
                break;
            
            case 'l':
                $file = 'img/l.png';
                break;
            
            case 'm':
                $file = 'img/m.png';
                break;
            
            case 'n':
                $file = 'img/n.png';
                break;
            
            case 'o':
                $file = 'img/o.png';
                break;
            
            case 'p':
                $file = 'img/p.png';
                break;
            
            case 'q':
                $file = 'img/q.png';
                break;
            
            case 'r':
                $file = 'img/r.png';
                break;
            
            case 's':
                $file = 'img/s.png';
                break;
            
            case 't':
                $file = 'img/t.png';
                break;
            
            case 'u':
                $file = 'img/u.png';
                break;
            
            case 'v':
                $file = 'img/v.png';
                break;
            
            case 'w':
                $file = 'img/w.png';
                break;
            
            case 'x':
                $file = 'img/x.png';
                break;
            
            case 'y':
                $file = 'img/y.png';
                break;
            
            case 'z':
                $file = 'img/z.png';
                break;
            
            default:
                $file = '';
                break;
        }

        $fileType = strtolower(pathinfo($file,PATHINFO_EXTENSION));
        $validExtensions = array('jpg', 'jpeg', 'png', 'gif', 'pdf');

        if (in_array($fileType, $validExtensions))
        {
            if ($stmt = $pdo->prepare("UPDATE users SET bio = ?, photo = ? WHERE id = ?"))
            {
                $stmt->execute(array($_SESSION['bio'], $file, $_SESSION['id']));
            }

        }
    }
    if (isset($_POST['bio']))
    {
        if ($stmt = $pdo->prepare("UPDATE users SET bio = ? WHERE id = ?"))
        {
            $stmt->execute(array($_POST['bio'], $_SESSION['id']));
        }
    }
    if ($stmt = $pdo->prepare("SELECT bio, photo FROM users WHERE id = ?"))
    {
        $stmt->execute(array($_SESSION['id']));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result)
        {
            $_SESSION['bio'] = $result['bio'];
            $_SESSION['image'] = $result['photo'];

            header('Location: index.php');
        }
    }
}

?>