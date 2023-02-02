<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require "db.php";


$selectQuery = 'SELECT * FROM movies';
$totalResults = getTotalResults($selectQuery);

// aantal weergaven
$limit = 10;
if (isset($_GET["page"])) {
    $offset = ($_GET["page"] - 1) * 10;
    $page = $_GET["page"];
} else {
    $offset = 0;
    $page = 1;
}

$pages = ceil($totalResults / $limit);

// sorteren
$sorts = [
    "name",
    "genre",
    "year",
    "studio",
    "score"
];
$directions = [
    "ASC",
    "DESC"
];

# default op id en ASC

if (isset($_GET["sort"])) {
    if (in_array($_GET["sort"], $sorts)) {
        $sort = $_GET["sort"];
    } else {
        $sort = "id";
    }
} else {
    $sort = "id";
}

// if (in_array($_GET["direction"], $directions)) {
// $direction = $_GET["direction"];
// } else {
// $direction = "ASC";
// }

// echo "<pre>";
// var_dump("SELECT * FROM movies ORDER BY $sort $direction LIMIT $offset, $limit");
// exit;
$movies = getAllMovies(3, $offset, $limit);
// echo "<pre>";
// var_dump($movies[0]->name);
// exit;

$pdo = null;
?>

<html>

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>

<body>
    <style>
        p a {
            text-decoration: none;
            color: black;
            user-select: none;
        }

        p a.active {
            color: blue;
            font-weight: bolder;
            pointer-events: none;
        }

        .disabled {
            color: grey;
            pointer-events: none;
        }
    </style>
    <div class="container">
        <h1>Movies</h1>
        <p><?= $totalResults; ?> resultaten gevonden.</p>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col"><a href="index.php?sort=name&direction=<?= ($sort == 'name' && $direction == 'ASC' ? 'DESC' : 'ASC') ?>">Name</a></th>
                    <th scope="col"><a href="index.php?sort=genre&direction=<?= ($sort == 'genre' && $direction == 'ASC' ? 'DESC' : 'ASC') ?>">Genre</a></th>
                    <th scope="col"><a href="index.php?sort=studio&direction=<?= ($sort == 'studio' && $direction == 'ASC' ? 'DESC' : 'ASC') ?>">Studio</a></th>
                    <th scope="col"><a href="index.php?sort=score&direction=<?= ($sort == 'score' && $direction == 'ASC' ? 'DESC' : 'ASC') ?>">Score</a></th>
                    <th scope="col"><a href="index.php?sort=year&direction=<?= ($sort == 'year' && $direction == 'ASC' ? 'DESC' : 'ASC') ?>">Year</a></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $counter = 1 + $offset;
                foreach ($movies as $movie) :
                ?>

                    <tr <?php print($counter % 2 == 0 ? 'style="background-color: lightgray;"' : '') ?>>
                        <td><?= $counter ?></td>
                        <td><?= $movie->name ?></td>
                        <td><?= $movie->genre ?></td>
                        <td><a href="index.php?studio=<?= urlencode($movie->studio) ?>"><?= $movie->studio ?></a></td>
                        <td><?= $movie->score ?></td>
                        <td><?= $movie->year ?></td>
                    </tr>

                <?php
                    $counter++;
                endforeach
                ?>



            </tbody>
        </table>
        <p>
            <a href="index.php?page=<?= $page - 1 ?>" class="<?= $page <= 1 ? "disabled" : null ?>">PREV</a>

            <?php for ($i = 1; $i <= $pages; $i++) :
                if ($i == $page) { ?>
                    <a href="index.php?page=<?= $i ?>" class="active"><?= $i ?></a>
                <?php } else { ?>
                    <a href="index.php?page=<?= $i ?>"><?= $i ?></a>
            <?php }
            endfor ?>

            <a href="index.php?page=<?= $page + 1 ?>" class="<?= $page >= $pages ? "disabled" : null ?>">NEXT</a>
        </p>
    </div>
</body>

</html>