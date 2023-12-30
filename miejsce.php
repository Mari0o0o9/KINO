<?php
    session_start();        
    $conn = new mysqli("localhost", "root", "", "sakila");
    
    if(!isset($_GET['id']) || !isset($_GET['nameId'])) {
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
    $result1 = $conn-> query($sql1) -> fetch_array();


    function takenSeats() {
        global $conn;
        global $screening_id;

        $sql2 = "SELECT 
                    seat 
                FROM 
                    screening_reservation 
                WHERE 
                    screening_id = '$screening_id'";
        $resolut2 = $conn -> query($sql2);
        return $resolut2 -> fetch_all();
    }
    
    $zablokowane_miejsca = [];
    $takenSeats = takenSeats();
    foreach ($takenSeats as $key => $value) {
       $zablokowane_miejsca[] = (int)$value[0];
    }
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sala | <?= $result1['title']?></title>
    <link rel="stylesheet" href="./style/animation.css">
    <link rel="stylesheet" href="./style/style_miejsce.css">
    <link rel="shortcut icon" href="./zdjecia/favicon.ico" type="image/x-icon">
</head>
<body>
    <main>
        <header>
            <a href="./index.php" id="logo">
                <img src="./zdjecia/logo.png" alt="Kino" id="kino">
                <h1>CosmoKino</h1>
            </a>
            <h1>|</h1>
            <h1><?= $result1['title']?></h1>
        </header>
        <section>
            <h1>Wybierz miejsce</h1>
            <article id="kino">
                <div id="sala">
                    <div id="rozklad">
                        <div id="ekran">Ekran</div>
                        <div id="siedzenia">
                            <form action="./dane.php?id=<?=$category_id?>&nameId=<?=$film_id?>&screening_id=<?=$screening_id?>" method="post">
                                <?php
                                    for ($r=1; $r < 6; $r++) { 
                                        echo "<div id='r$r' class='rzad'>$r ----";
                                        for ($i=1; $i < 11; $i++) {
                                            echo "<button type='button' name='test' data-rzad='$r' data-miejsce='$i' data-check='0' class='miejsca " . (in_array(($r-1) * 10 + $i, $zablokowane_miejsca) ? "disabled" : "") . "'></button>";
                                        }   
                                        echo "---- $r</div>"; 
                                    }   
                                ?>
                                <input type="hidden" name="wybraneMiejsca" id="wybraneMiejsca">
                                
                                <div id="dalej"> 
                                    <input type="submit" value="Przejdź dalej &#8658;">
                                </div> 
                            </form>  
                        </div>
                        <div id="legenda">
                            <div>
                                <div id="zajete"></div>zajete <div id="wolne"></div>wolne <div id="wybrane"></div>wybrane
                            </div>
                        </div>  
                    </div>    
                </div>
            </article>
            <article id="wyjscie">
                <a href="category.php?id=<?=$category_id?>&nameId=<?=$film_id?>">
                    <input type="button" value="Wróć">
                </a>
            </article>
        </section>
    </main>
</body>
<script src="./script/glowna.js"></script>
<script src="./script/scroll.js"></script>
<script src="./script/miejsce.js"></script>
</html>
<?php
    $conn -> close();
?>