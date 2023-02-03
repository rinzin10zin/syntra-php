<?php
// date_default_timezone_set("Europe/Brussels");

// Truncate table watergroep_inzendingen;
// delete from watergroep_klanten WHERE id > 2;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// als er geen $_get staat of $_get is leeg dan toon html
if (!isset($_GET) || empty($_GET["token"])) {
    echo "<h1>404 - This page doesnt exist</h1>";
    exit;
}

require 'db.php';
require 'functions.php';

$id = getid($_GET["token"]);
if (!getid($_GET["token"])) {
    echo "<h1>404 - This user doesn't exist</h1>";
    exit;
}

// var_dump(getId($_GET["token"]));
// exit;


$klant = getKlantGeg($id);
$aantalInzendingen = countInzendingen($id);
$nextToken = randomToken(30);


// if (!$klant) {
//     echo "<h1>Onbekende klant</h1>";
//     exit;
// }

$naam = "$klant->voornaam $klant->achternaam";
if ($aantalInzendingen !== 0) {
    $latestInzending = getLatests($id)[0];
    $latestTime = date_create($latestInzending->updated_at);
}
// if someone filled in the form
if (isset($_POST["meterstand"]) && !empty($_POST["meterstand"])) {
    if ($aantalInzendingen < 1) {
        insertMeterstand($id, $_POST["meterstand"]);
        while (isKnownToken($nextToken)) {
            $nextToken = randomToken(30);
        }
        updateToken($id, $nextToken);
        $succesMsg = "Bedankt $klant->voornaam! Dit was je eerste inzending!";
    } else {
        if ($_POST["meterstand"] <= $latestInzending->meterstand) {
            $errMsg = "Meterstand kan niet lager of gelijk zijn aan vorige inzending";
        } else {
            insertMeterstand($id, $_POST["meterstand"]);
            while (isKnownToken($nextToken)) {
                $nextToken = randomToken(30);
            }
            updateToken($id, $nextToken);
            $succesMsg = "Bedankt $klant->voornaam!";
        }
    }
}

// echo "<pre>";
// var_dump($_POST);
// echo "</pre>";
// exit;

$pdo = null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>De Watergroep</title>
</head>

<body>
    <h2>Meterstanden van <?= $naam ?> doorgeven</h2>
    <h5><?php
        // als er inzendingen zijn 
        if ($aantalInzendingen !== 0 && !isset($succesMsg)) {
        ?>

            Uw laatste inzending had een meterstand van <span><?= $latestInzending->meterstand ?></span> m3.<br>
            Deze werd laatst geupdate op <span><?= date_format($latestTime, "d/m/Y H:i:s") ?></span>.
        <?php }
        ?>
    </h5>
    <h5><?php
        if (isset($succesMsg)) {
            echo "<span class='succes'>$succesMsg<span>";
            if ($aantalInzendingen > 1) {
                $verschilM = $_POST["meterstand"] - $latestInzending->meterstand;
                $id = intval($_POST["id"]);
                var_dump($id);
                $verschilT = getLatests($id)[0]->created_at - getLatests($id)[1]->created_at;
                var_dump($verschilT);
                exit;
        ?>

                Je hebt <span><?= $verschilM ?></span> m3 verbruikt in een periode van
                <span><?= getTime($verschilT) ?></span>.
            <?php } else { ?>

        <?php
            }
        }
        ?>
    </h5>
    <h5 class="error"><?= isset($errMsg) ? $errMsg : "" ?></h5>

    <?php if (!isset($succesMsg)) : ?>
        <form action="" method="POST">
            <input type="hidden" name="id" value="<?= $id ?>">
            <label for="vnaam">Voornaam: </label><input disabled type="text" name="vnaam" id="vnaam" value="<?= $klant->voornaam ?>">
            <label for="anaam">Achternaam: </label><input disabled type="text" name="anaam" id="anaam" value="<?= $klant->achternaam ?>">
            <label for="straat">Straatnaam: </label><input disabled type="text" name="straat" id="straat" value="<?= $klant->straatnaam ?>">
            <label for="nummer">Huis- en busnummer: </label><input disabled type="text" name="nummer" id="nummer" value="<?= $klant->nummerbus ?>">
            <label for="postcode">Postcode: </label><input disabled type="number" name="postcode" id="postcode" value="<?= $klant->postcode ?>" min="1000" max="9999">
            <label for="locatie">Locatie: </label><input disabled type="text" name="locatie" id="locatie" value="<?= $klant->locatie ?>">
            <label for="meterstand">Huidige meterstand: </label><input type="number" name="meterstand" id="meterstand" min="0" max="999999">
            <br><button type="submit" style="width: 20%;">Verzenden</button>
        </form>
    <?php endif ?>
</body>

</html>