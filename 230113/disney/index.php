<?php

// include './includes/getAPI.php';
require('./includes/getAPI.php');

// if (!isset($_GET['c'])) {
//     $parCat = "Ordinary Drink";
// }
// $parCat = $_GET['cat'];

$response = getAPI("https://api.disneyapi.dev/characters");
$characters = $response->data;

// usort($characters, function ($a, $b) {
//     return strcmp($a->strCategory, $b->strCategory);
// });


// $drinks = getCocktailAPI("https://www.thecocktaildb.com/api/json/v1/1/filter.php?c=" . $_GET["c"]);

// print '<pre>';
// var_dump(getAPI("https://www.thecocktaildb.com/api/json/v1/1/list.php?c=list"));
// var_dump($categories);
// var_dump($characters);
// var_dump($characters->data);
// $drinks = $response->drinks;
// var_dump($drinks[0]->strCategory);
// exit;

?>

<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Disney</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="./style.css" rel="stylesheet">
</head>

<body>
    <!-- <div class="container text-center">
        <ul class="nav nav-pills mb-5">
            <?php foreach ($categories as $category): ?>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="><?= $category->strCategory ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div> -->
    <div id="masonry-effect">
        <?php foreach ($characters as $character): ?>
            <div class="item card">
                <img src="<?= $character->imageUrl ?>" class="card-img-top" alt="picture of <?= $character->name ?>">
                <div class="card-body">
                    <h5 class="card-title"><?= $character->name ?></h5>
                    <a href="character.php?c=<?= $character->_id ?>" class="btn btn-primary">Appearances</a>
                </div>
            </div>
        <?php endforeach; ?>

    </div>
    </div>
</body>

<script>
    let mainId = "masonry-effect";
    let itemIdentifier = "#masonry-effect .item";

    document.addEventListener("DOMContentLoaded", function(e) {
        // Programmatically get the column width
        let item = document.querySelector(itemIdentifier);
        let parentWidth = item.parentNode.getBoundingClientRect().width;
        let itemWidth =
            item.getBoundingClientRect().width +
            parseFloat(getComputedStyle(item).marginLeft) +
            parseFloat(getComputedStyle(item).marginRight);
        let columnWidth = Math.round(1 / (itemWidth / parentWidth));

        // We need this line since JS nodes are dumb
        let arrayOfItems = Array.prototype.slice.call(
            document.querySelectorAll(itemIdentifier)
        );
        let trackHeights = {};
        arrayOfItems.forEach(function(item) {
            // Get index of item
            let thisIndex = arrayOfItems.indexOf(item);
            // Get column this and set width
            let thisColumn = thisIndex % columnWidth;
            if (typeof trackHeights[thisColumn] == "undefined") {
                trackHeights[thisColumn] = 0;
            }
            trackHeights[thisColumn] +=
                item.getBoundingClientRect().height +
                parseFloat(getComputedStyle(item).marginBottom);
            // If the item has an item above it, then move it to fill the gap
            if (thisIndex - columnWidth >= 0) {
                let getItemAbove = document.querySelector(
                    `${itemIdentifier}:nth-of-type(${thisIndex - columnWidth + 1})`
                );
                let previousBottom = getItemAbove.getBoundingClientRect().bottom;
                let currentTop =
                    item.getBoundingClientRect().top -
                    parseFloat(getComputedStyle(item).marginBottom);
                item.style.top = `-${currentTop - previousBottom}px`;
            }
        });
        let max = Math.max(...Object.values(trackHeights));
        document.getElementById(mainId).style.height = `${max}px`;
    });
</script>

</html>