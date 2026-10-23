<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Czekolandia</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Witaj w <a href="index.php">Czekolandii</a></h1>
    </header>
    <main>
        <form method="POST"  class="form-logowania">
            <h3>Zaloguj się</h3>
            <input type="text" placeholder="Podaj login" name="login"/>
            <input type="password" placeholder="Podaj hasło" name="haslo"/>
            <button type="submit">Zapisz</button>
        </form>
        <a href="rejestracja.php"><p>Nie masz konta?</p></a>
    </main>
    <footer>

    </footer>

<?php
    session_start();
    if(isset($_SESSION['czekolandia']))
    {
        header("Location:index.php");
        exit();
    }

    // ini_set('display_errors', 1);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $connect = new PDO("mysql:host=localhost;dbname=czekolandia", "root", "");

    $login = $_POST['login'];
    $haslo = $_POST['haslo'];

    // var_dump($login);

    $query = $connect->prepare("SELECT * FROM `users` WHERE `login` = :login AND `haslo` = :haslo;");
    $query->execute(['login' => $login, 'haslo' => $haslo]);
    $rows = $query->fetch();
    // var_dump($rows);
    // var_dump($rows);
    if($rows)
    {
        $_SESSION['czekolandia'] = $login;
        header("Location:index.php");
        exit();
    }
    else if(!isset($login) || !isset($haslo))
    {
        echo("Złe podane hasło lub login");
    }

    $connect = null;
}
?>
    
</body>
</html>