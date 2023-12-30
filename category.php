<?php 
    $conn = new mysqli("localhost", "root", "", "sakila");
    if(!isset($_GET['id'])) {
        header("Location: category.php?id=1");
    }
    $category_id = $_GET['id'];

    function nazwaKategori() {
        global $conn;
        $category_id = $_GET['id'];
        $sql1 = "SELECT 
                    category.name
                FROM 
                    category
                WHERE
                    category.category_id = '$category_id'";
        $result = $conn -> query($sql1) -> fetch_array();

        echo "$result[name]";
    }
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CosmoKino | <?= nazwaKategori();?></title>
    <link rel="stylesheet" href="./style/animation.css">
    <link rel="stylesheet" href="./style/style_category.css">
    <link rel="stylesheet" href="./style/hamburger.css">
    <link rel="shortcut icon" href="./zdjecia/favicon.ico" type="image/x-icon">
</head>
<body>
    <nav class="hamburger-menu">
        <input id="menu__toggle" type="checkbox"/>
        <label class="menu__btn" for="menu__toggle">
            <span></span>
        </label>

        <div class="menu__box">
            <?php
                $sql1 = "SELECT 
                            category.name, category.category_id 
                        FROM 
                            category";
                $wynik1 = $conn -> query($sql1);
                
                while($row = $wynik1 -> fetch_array()) {
                    echo "<div>
                            <a class='menu__item' href='category.php?id={$row['category_id']}'>
                                {$row['name']}
                            </a>
                        </div>";
                }
            ?>
        </div>
    </nav>
    <main>
        <header>
            <a href="./index.php" id="logo">
                <img src="./zdjecia/logo.png" alt="Kino" id="kino">
                <h1>CosmoKino</h1>
            </a>
            <h1>|</h1>
            <h1> <?= nazwaKategori();?></h1>
        </header>
        <section>
            <article id="left">
                <?php
                    $sql2 = "SELECT 
                                film.title, film.description, film.length, film.film_id 
                            FROM 
                                film 
                            JOIN 
                                film_category ON film.film_id = film_category.film_id
                            WHERE 
                                film_category.category_id = '$category_id'";
                    $wynik = $conn -> query($sql2);

                    while($row = $wynik -> fetch_array()) {
                        echo "<form action='category.php?id=$category_id&nameId={$row['film_id']}' method='post'>";
                        echo "<div class='film'>
                                <p class='tytul'>Tytuł: {$row['title']}</p>
                                <p class='opis'>Opis: {$row['description']}</p>
                                <p class='czas'>Czas: {$row['length']} min</p>
                                <p class='przyciskFilm'><input type='submit' value='Przejdź do filmu &#8658;'></p>
                            </div>";
                        echo "</form>";
                    }
                    
                ?>
            </article>
            <article id="right" >
                <div>
                    <?php
                        if(isset($_GET['nameId'])) {
                            $film_id = $_GET['nameId'];

                            $sql3 = "SELECT 
                                        film.title, film.replacement_cost, film.special_features, film.release_year, language.name
                                    FROM 
                                        film
                                    JOIN 
                                        language USING(language_id)
                                    WHERE 
                                        film_id = '$film_id'";
                            $result1 = $conn -> query($sql3) -> fetch_array();

                            $sql3 = "SELECT 
                                        actor.actor_id, actor.first_name, actor.last_name
                                    FROM 
                                        actor
                                    JOIN film_actor ON actor.actor_id = film_actor.actor_id
                                    JOIN film ON film_actor.film_id = film.film_id
                                    WHERE 
                                        film.title = '$result1[title]'";
                            $result2 = $conn->query($sql3);

                            $sql4 = "SELECT 
                                        screening_datetime, screening_id
                                    FROM 
                                        screening
                                    WHERE 
                                        film_id = '$film_id'";
                            $result3 = $conn -> query($sql4);

                            echo "<div class='filmInfo'>
                                    <h1>Informacje o Filmie: \"$result1[title]\"</h1>
                                </div>";
                            echo "<div class='info'>
                                    <h2>Data Wydania: 
                                        <p>$result1[release_year]</p>
                                    </h2>
                                </div>";
                            echo "<div class='info'>
                                    <h2>Język:
                                        <p>$result1[name]</p>
                                    </h2>
                                </div>";
                                
                            echo "<div class='info'>
                                    <h2>Aktorzy grający w filmie:</h2>
                                </div>";

                            echo "<ul>";
                            while ($row = $result2->fetch_array()) {
                                echo "<a href='./actor.php?categoryId=$category_id&filmId=$film_id&actorId={$row['actor_id']}'><li>{$row['first_name']} {$row['last_name']}</li></a>";
                            }
                            echo "</ul>";

                            echo "<div class='info'>
                                    <h2>Dodatki:</h2> 
                                    <p>$result1[special_features]</p> 
                                </div>";

                            // napisac aby przechodziło do panelu kupowania biletów i wyboru miejsc
                            while($row = $result3 ->fetch_array()) {
                                echo "<div class='bilet'>
                                    <a href='miejsce.php?id=$category_id&nameId=$film_id&screening_id=$row[screening_id]'>
                                        <h1 class='data'>Data seansu: $row[screening_datetime]</h1>
                                    </a>
                                </div>";
                            }
                            
                        }
                    ?> 
                </div>
            </article>
        </section>
    </main>
</body>
<script src="./script/glowna.js"></script>
<script src="./script/scroll.js"></script>
</html>
<?php
    $conn -> close();
?>