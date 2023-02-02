<?php

include "curl.php";

$char_id = $_GET["c"];
$url = "https://api.disneyapi.dev/characters/$char_id";

$character = getAPI($url);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $character->name ?></title>
</head>

<body>
    <a href="./index.php">HOME</a>
    <div class="card">
        <img src="<?= $character->imageUrl ?>" alt="picture of <?= $character->name ?>">
        <div class="details">
            <h2><?= $character->name ?></h2>
            <?php if ($character->films) : ?>
                <h3>Films (<?= count($character->films) ?>)</h3>
                <?php foreach ($character->films as $key => $item) : ?>
                    <p><?= $key + 1 ?>. <?= $item ?></p>
                <? endforeach ?>
            <? endif ?>
            <?php if ($character->shortFilms) : ?>
                <h3>Short Films (<?= count($character->shortFilms) ?>)</h3>
                <?php foreach ($character->shortFilms as $key => $item) : ?>
                    <p><?= $key + 1 ?>. <?= $item ?></p>
                <? endforeach ?>
            <? endif ?>
            <?php if ($character->tvShows) : ?>
                <h3>TV Shows (<?= count($character->tvShows) ?>)</h3>
                <?php foreach ($character->tvShows as $key => $item) : ?>
                    <p><?= $key + 1 ?>. <?= $item ?></p>
                <? endforeach ?>
            <? endif ?>
            <?php if ($character->videoGames) : ?>
                <h3>Video Games (<?= count($character->videoGames) ?>)</h3>
                <?php foreach ($character->videoGames as $key => $item) : ?>
                    <p><?= $key + 1 ?>. <?= $item ?></p>
                <? endforeach ?>
            <? endif ?>
            <?php if ($character->parkAttractions) : ?>
                <h3>parkAttractions (<?= count($character->parkAttractions) ?>)</h3>
                <?php foreach ($character->parkAttractions as $key => $item) : ?>
                    <p><?= $key + 1 ?>. <?= $item ?></p>
                <? endforeach ?>
            <? endif ?>
            <?php if ($character->allies) : ?>
                <h3>allies (<?= count($character->allies) ?>)</h3>
                <?php foreach ($character->allies as $key => $item) : ?>
                    <p><?= $key + 1 ?>. <?= $item ?></p>
                <? endforeach ?>
            <? endif ?>
            <?php if ($character->enemies) : ?>
                <h3>enemies (<?= count($character->enemies) ?>)</h3>
                <?php foreach ($character->enemies as $key => $item) : ?>
                    <p><?= $key + 1 ?>. <?= $item ?></p>
                <? endforeach ?>
            <? endif ?>
        </div>
    </div>
</body>

</html>