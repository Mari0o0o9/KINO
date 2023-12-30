<?php 
    $conn = new mysqli("localhost", "root", "", "sakila");

    if (empty($_GET['id']) || empty($_GET['nameId']) || empty($_GET['screening_id'])) {
        header("Location: category.php?id=1");
        exit(1);
    }

    $category_id = $_GET['id'];
    $film_id = $_GET['nameId'];
    $screening_id = $_GET['screening_id'];

    $sql1 = "SELECT 
                title
            FROM 
                film
            WHERE 
                film_id = '$film_id'";
    $result1 = $conn->query($sql1)->fetch_array();

    $wybraneMiejsca = isset($_POST['wybraneMiejsca']) ? $_POST['wybraneMiejsca'] : '';
    var_dump($wybraneMiejsca);

    if (isset($_SERVER['REQUEST_METHOD']) === 'POST') {
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
    
        // Sprawdź poprawność danych
        if (empty($first_name) || empty($last_name) || empty($email) || empty($wybraneMiejsca)) {
            echo "Błąd - brak wymaganych danych.";
            exit;
        }
    
        // Przygotuj zapytanie SQL do dodania informacji o użytkowniku
        $sql3 = "INSERT INTO user (first_name_user, last_name_user, email) VALUES ('$first_name', '$last_name', '$email')";
        $conn->query($sql3);
    
        // Pobierz ID ostatnio wstawionego użytkownika
        $lastUserId = $conn->insert_id;
    
        // Przetwórz informacje o miejscach
        $miejscaArray = explode(',', $wybraneMiejsca);
        foreach ($miejscaArray as $miejsceId) {
            // Przygotuj zapytanie SQL do dodania informacji o zajętym miejscu
            $sql2 = "INSERT INTO screening_reservation  (seat, screening_id, user_id) VALUES ('$miejsceId', '$screening_id', '$lastUserId')";
            $conn->query($sql2);
        }
        echo "Pomyślnie zaktualizowano bazę danych.";
    }
?>



<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/animation.css">
    <link rel="stylesheet" href="./style/style_dane.css">
    <link rel="shortcut icon" href="./zdjecia/favicon.ico" type="image/x-icon">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <title>Cennik | <?=$result1['title']?></title>
</head>
<body>
    <header>
        <a href="./index.php" id="logo">
            <img src="./zdjecia/logo.png" alt="Kino" id="kino">
            <h1>CosmoKino</h1>
        </a>
        <h1>|</h1>
        <h1><?= $result1['title']?></h1>
    </header>
    <main>
        <form action="#" method="post">
            <p>
                <label>
                    <br> <span class="material-symbols-outlined">edit</span> <input type="text" name="first_name" id="" placeholder="Imie" pattern="[a-zA-Z]*" required>
                </label>
            </p>
            <p>
                <label>
                     <br> <span class="material-symbols-outlined">edit</span> <input type="text" name="last_name" id="" placeholder="Nazwisko" pattern="[a-zA-Z]*" required>
                </label>
            </p>
            <p>
                <label>
                     <br> <span class="material-symbols-outlined">contact_mail</span> <input type="email" name="email" id="" placeholder="Email" required>
                </label>
            </p>
            <input type="submit" value="ok" name="wyslji">
        </form>
    </main>
    <div id="wyjscie">
        <a href="./miejsce.php?id=<?=$category_id?>&nameId=<?=$film_id?>&screening_id=<?=$screening_id?>">
            <input type="button" value="Wróć">
        </a>
    </div>
</body>
<script src="./script/glowna.js"></script>
<script src="./script/scroll.js"></script>
</html>
<?php 
    $conn -> close();
?>