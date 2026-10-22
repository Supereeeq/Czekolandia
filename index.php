<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .niewidoczne
        {
            display:none;
        }
        table, tr, td, th
        {
            border: solid black 2px;
            border-collapse: collapse;
            padding:5px;
            text-align:center;
        }
    </style>
</head>
<body>
    <header>
        <h1>Witaj w <a href="index.php">Czekolandii</a></h1>
    </header>
    <main>
        <?php
            session_start();


            if(!isset($_SESSION['czekolandia']))
            {
                echo("<p><a href='login.php'>Zaloguj się </a>lub <a href='rejestracja.php'>Zarejestruj się</a></p>");
            }
            else
            {
                echo("<form method='POST'><input type='submit' name='wyloguj' value='wyloguj'/></form>");

                $connect = new PDO("mysql:host=localhost;dbname=czekolandia", "root", "");
                $login = $_SESSION['czekolandia'];
                $query = $connect->query("SELECT `admin` FROM `users` WHERE `login` = '$login';");
                $row = $query->fetch();
                if($row['admin'] == 1)
                {
                    include("panel-admina.php");
                }
                
            }
        ?>
    </main>
    <footer>

    </footer>

    <?php
    if(isset($_POST['wyloguj'])) 
    {
        session_destroy();
        header("Location: index.php");
    }

?>
    
</body>
</html>