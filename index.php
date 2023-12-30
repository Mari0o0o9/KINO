<?php 
    $conn = new mysqli("localhost", "root", "", "sakila");
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CosmoKino</title>
    <link rel="stylesheet" href="./style/style_glowna.css">
    <link rel="stylesheet" href="./style/hamburger.css">
    <link rel="shortcut icon" href="./zdjecia/favicon.ico" type="image/x-icon">
</head>
<body>
    <main>
        <nav class="hamburger-menu">
            <input id="menu__toggle" type="checkbox"/>
            <label class="menu__btn" for="menu__toggle">
                <span></span>
            </label>
            
            <ul class="menu__box">
                <?php
                    $sql1 = "SELECT 
                                category.name, category.category_id 
                            FROM 
                                category";
                    $wynik1 = $conn -> query($sql1);
                    
                    while($row = $wynik1 -> fetch_array()) {
                        echo "<li>
                                <a class='menu__item' href='category.php?id={$row['category_id']}'>
                                    {$row['name']}
                                </a>
                            </li>";
                    }
                ?>
            </ul>
        </nav>
        <header>
            <a href="./index.php" id="logo">
                <h1>CosmoKino</h1>
            </a>
        </header>
        <section>
            
        </section>
    </main>
</body>
<script src="./script/glowna.js"></script>
<script src="./script/scroll.js"></script>
</html>
<?php
    $conn -> close();
?>