<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <header>
        <h1>Witaj w <a href="index.php">Czekolandii</a></h1>
    </header>
    <main>
        <form method="POST">
            <h3>Zarejestruj się</h3>
            <input type="text" placeholder="Podaj login" name="login"/>
            <input type="text" placeholder="Podaj maila" name="mail"/><br/><br/>
            <input type="password" placeholder="Podaj hasło" name="haslo"/>
            <input type="password" placeholder="Powtórz hasło" name="haslo_dwa"/><br/><br/>
            <button type="submit">Zapisz</button>
        </form>
        <a href="login.php"><p>Masz konto?</p></a>
    </main>
    <footer>

    </footer>

    <?php
    session_start();
    
    ini_set('display_errors', 1);

    $connect = new PDO("mysql:host=localhost;dbname=czekolandia", "root", "");
    
    if(!isset($_POST["haslo"]) || !isset($_POST["mail"]) || !isset($_POST["login"]) || !isset($_POST["haslo_dwa"]))
    {
        echo("Proszę wypełnić formularz");
        exit();
    }

    if(!isset($_POST["haslo"]) || !isset($_POST["haslo_dwa"]) || $_POST["haslo"] != $_POST["haslo_dwa"])
    {
        echo("Podano różne hasła");
        exit();   
    }

    $szukaj_loginu = $connect->prepare("SELECT `id` FROM `users` WHERE `login` = :login OR `mail` = :mail;");
    $szukaj_loginu->execute([
        "login"=>$_POST["login"],
        "mail"=>$_POST["mail"]
    ]);
    if($szukaj_loginu->fetch())
    {
        echo("Podany login lub mail jest już zajęty");
        exit();
    }

    $query = $connect->prepare("INSERT INTO `users` (`login`,`mail`,`haslo`) VALUES (:login,:mail,:haslo);");
    $query->execute([
        "login" => $_POST["login"],
        "mail" => $_POST["mail"],
        "haslo" => $_POST["haslo"]
    ]);
    // $rows = $query->fetch();
    // var_dump($rows);

    $_SESSION["czekolandia"] = $_POST["login"];
    header("Location:index.php");

?>
    
</body>
</html>