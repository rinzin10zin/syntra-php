<?php

// include './includes/getAPI.php';
require('./includes/getCocktailAPI.php');

if (!isset($_GET['c'])) {
    $parCat = "Ordinary Drink";
}
$parCat = $_GET['cat'];

$categories = getCocktailAPI("https://www.thecocktaildb.com/api/json/v1/1/list.php?c=list");
$drinks = getCocktailAPI("https://www.thecocktaildb.com/api/json/v1/1/filter.php?c=" . $_GET["c"]);

usort($categories, function ($a, $b) {
    return strcmp($a->strCategory, $b->strCategory);
});

usort($drinks, function ($a, $b) {
    return strcmp($a->strCategory, $b->strCategory);
});

// $drinks = getCocktailAPI("https://www.thecocktaildb.com/api/json/v1/1/filter.php?c=" . $_GET["c"]);

// print '<pre>';
// var_dump(getAPI("https://www.thecocktaildb.com/api/json/v1/1/list.php?c=list"));
// var_dump($categories);
// var_dump($cocktails);
// $drinks = $response->drinks;
// var_dump($drinks[0]->strCategory);
// exit;

?>

<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cocktails...</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
    <div class="container text-center">
        <ul class="nav nav-pills mb-5">
            <?php foreach ($categories as $category) {  ?>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="index.php?c=<?= $category->strCategory ?>"><?= $category->strCategory ?></a>
                </li>
            <?php } ?>
        </ul>
    </div>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 mx-5">
        <?php foreach ($drinks as $drink) { ?>
            <div class="col mb-3">
                <div class="card">
                    <img src="<?= $drink->strDrinkThumb ?>" class="card-img-top" alt="picture of <?= $drink->strDrink ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= $drink->strDrink ?></h5>
                        <a href="/detail.php?id=<?= $drink->idDrink ?>" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>
        <?php } ?>

    </div>
    </div>
</body>

</html>