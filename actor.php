<?php
    $conn = new mysqli("localhost", "root", "", "sakila");
    if(!isset($_GET['categoryId']) || !isset($_GET['filmId']) || !isset($_GET['actorId'])) {
        header("Location: category.php?id=1");
        exit(1);
    }

    $sql1 = "SELECT 
                CONCAT(first_name, ' ', last_name) AS name
            FROM 
                actor
            WHERE 
                actor_id = '$_GET[actorId]'";

    $result1 = $conn -> query($sql1) -> fetch_array();


    function wyswietlFilm() {
        global $conn;
        $sql2 = "SELECT 
                    film.title, film.description, film.length
                FROM 
                    film
                JOIN 
                    film_actor ON film.film_id = film_actor.film_id
                JOIN 
                    actor ON actor.actor_id = film_actor.actor_id
                WHERE 
                    actor.actor_id = '$_GET[actorId]'";

        $wynik1 = $conn -> query($sql2);

        
        while($row = $wynik1 -> fetch_array()) {
            $sql3 = "SELECT 
                    category.category_id, film.film_id
                FROM 
                    film
                JOIN 
                    film_category ON film_category.film_id = film.film_id
                JOIN 
                    category ON category.category_id = film_category.category_id
                WHERE 
                    film.title = '$row[title]'";
            $result3 = $conn -> query($sql3) -> fetch_array();

            echo "<div class='film'>
                    <p class='tytul'>Tytuł: {$row['title']}</p>
                    <p class='opis'>Opis: {$row['description']}</p>
                    <p class='czas'>Czas: {$row['length']} min</p>
                    <a href='category.php?id={$result3['category_id']}&nameId={$result3['film_id']}'>
                        <input type='button' value='Przejdź do filmu &#8658;' class='przyciskFilm'>
                    </a>
                </div>";
                
        }
    }
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CosmoKino | <?= $result1['name']?></title>
    <link rel="stylesheet" href="./style/animation.css">
    <link rel="stylesheet" href="./style/style_actor.css">
    <link rel="shortcut icon" href="./zdjecia/favicon.ico" type="image/x-icon">
</head>
<body>
    <main>
        <header>
            <a href="./index.php" id="logo">
                <img src="./zdjecia/logo.png" alt="Kino" id="kino">
                <h1>CosmoKino</h1>
            </a>
            <h1>| <?= $result1['name']?></h1>
        </header>
        <section>
            <div>
                <?= wyswietlFilm();?>
            </div> 
        </section>
        <section id="button">
            <a href="<?php echo $_SERVER['HTTP_REFERER'];?>">
                <input type="button" value="Wróć">
            </a>
        </section> 
    </main>  
</body>
<script src="./script/glowna.js"></script>
<script src="./script/scroll.js"></script>
</html>
<?php
    $conn ->close();
?>