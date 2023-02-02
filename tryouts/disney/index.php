<?php

include "curl.php";

$characters = getAPI('https://api.disneyapi.dev/characters')->data;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Disney API</title>
</head>

<body>
    <div id="masonry-effect">
        <?php foreach ($characters as $character) : ?>
            <div class="item card">
                <img src="<?= $character->imageUrl ?>" class="card-img-top" alt="picture of <?= $character->name ?>">
                <div class="card-body">
                    <h1 class="card-title"><?= $character->name ?></h1>
                    <a href="details.php?c=<?= $character->_id ?>" class="btn btn-primary">Details</a>
                </div>
            </div>
        <?php endforeach ?>

    </div>

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
</body>

</html>