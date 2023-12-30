<?php
    session_start();        
    $conn = new mysqli("localhost", "root", "", "sakila");
    
    if(!isset($_GET['id']) || !isset($_GET['nameId'])) {
        header("Location: category.php?id=$_GET[id]");
        exit(1);
    }
    $category_id = $_GET['id'];
    $film_id = $_GET['nameId'];
    
    $sql1 = "SELECT 
                title
            FROM 
                film
            WHERE 
                film_id = '$film_id'";
    $result1 = $conn-> query($sql1) -> fetch_array();

    function wpisDanych() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(empty($_POST['first_name'])) {
                echo "Prosze podac imie";
            }
            if(empty($_POST['last_name'])) {
                echo "Prosze podac nazwisko";
            }
            if(empty($_POST['email'])) {
                echo "Prosze podac email";
            }
        }
    }

    function sala() {
    }
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cennik | <?= $result1['title']?></title>
    <link rel="stylesheet" href="./style/animation.css">
    <link rel="stylesheet" href="./style/style_cennik.css">
    <link rel="shortcut icon" href="./zdjecia/favicon.ico" type="image/x-icon">
</head>
<body>
    <main>
        <header>
            <a href="./index.php" id="logo">
                <img src="./zdjecia/logo.png" alt="Kino" id="kino">
                <h1>CosmoKino</h1>
            </a>
            <h1>| <?= $result1['title']?></h1>
        </header>
        <section>
            <article id="kino">
                <div id="sala">
                    <div id="ekran">
                        Ekran
                    </div>
                </div>
                <div id="daneZakup">
                    <input type="button" value="wyjdz" id="wyjdzDaneZakup">

                    <form action="#" method="post">
                    <label>
                        Imie <br> <input type="text" name="first_name">
                    </label> <br>
                    <label>
                        Nazwisko <br> <input type="text" name="last_name">
                    </label> <br>
                    <label>
                        Email <br> <input type="email" name="email">
                    </label> <br>
                    
                    <input type="submit" value="wyślij">
                    </form>
                    <?= wpisDanych();?>
                </div>
            </article>
            <article id="formularz">
                
                <input type="button" value="test" id="przeslijDaneZakup">
                
                <a href="category.php?id=<?=$category_id?>&nameId=<?=$film_id?>">
                    <input type="button" value="Wróć" id="powrotDaneZakup">
                </a>
            </article>
        </section>
    </main>
</body>
<script src="./script/glowna.js"></script>
<script src="./script/scroll.js"></script>
<script src="./script/daneZakup.js"></script>
</html>
<?php
    $conn -> close();
?>