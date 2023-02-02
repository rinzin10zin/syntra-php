<?php

require("./includes/getAPI.php");

$character = getAPI("https://api.disneyapi.dev/characters/" . $_GET["c"]);


echo "<pre>";
var_dump($character);
exit;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="container">
        <div class="card">
            <img src="<?= $character->imageUrl ?>" alt="<?= $character->name ?>">
            <div class="card-details">
                <h1><?= $character->name ?></h1>
                <?php if (isset($character->films){ ?>
                    <h2 class="films">Films</h2>
                    <?php foreach ($character->films as $film) { ?>
                        <p><?= $film ?></p>
                    <?php } ?>
                <?php }) ?>
                <?php if (isset($character->shortFilms){ ?>
                    <h2 class="shortFilms">Short Films</h2>
                    <?php foreach ($character->films as $film) { ?>
                        <p><?= $film ?></p>
                    <?php } ?>
                <?php }) ?>
                
                <h2 class="tvShows">TV Shows</h2>
                <h2 class="videoGames">Video Games</h2>
                <h2 class="parkAttractions">Park Attractions</h2>
                <h2 class="allies">Allies</h2>
                <h2 class="enemies">Enemies</h2>

            </div>
        </div>
    </div>
</body>

</html>