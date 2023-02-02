<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$db_host = '127.0.0.1';
$db_user = 'root';
$db_password = 'root';
$db_db = 'php_func_program';
$db_port = 8889;

$mysqli = new mysqli(
    $db_host,
    $db_user,
    $db_password,
    $db_db,
    $db_port
);

if ($mysqli->connect_error) {
    echo 'Errno: ' . $mysqli->connect_errno;
    echo '<br>';
    echo 'Error: ' . $mysqli->connect_error;
    exit();
}

$per_page = 10;

// url of niet?
if (isset($_GET["page"])) {
    $page = $_GET["page"];
} else {
    $page = 1;
}

$offset = ($page - 1) * $per_page;

// check if the sort column is set in the URL
// asc or desc
$direction = "ASC";
$directions = [
    "up" => "ASC",
    "down" => "DESC",
    "asc" => "ASC",
    "desc" => "DESC"
];
if (isset($_GET["direction"])) {
    $_GET["direction"] = strtolower($_GET['direction']);
    if (isset($directions[$_GET['direction']])) {
        $direction = $directions[$_GET["direction"]];
    }
} else {
    $direction = "ASC";
}

// sort
$sorts = [
    "id",
    "name",
    "genre",
    "studio",
    "score",
    "rotten_tomatoes_score",
    "year"
];
if (isset($_GET["sort"])) {
    if (in_array($_GET['sort'], $sorts)) {
        $sort = $_GET["sort"];
    }
} else {
    $sort = "id";
}


// filter op studio
// $sql = "SELECT DISTINCT studio FROM movies";
// $result = $mysqli->query($sql);
// $total_row = $result->fetch_all();
// $total_movies = $total_row["num"];

// echo '<pre>';
// var_dump($total_row);
// exit;

$where =  "";
if (isset($_GET["studio"])) {
    $where = "WHERE studio LIKE '" . urldecode($_GET["studio"]) . "' ";
}
// totaal aantal resultaten met studioFilter
function getTotal($where = '')
{
    global $mysqli;
    $sql = "SELECT COUNT(*) as num FROM movies " . $where;
    $result = $mysqli->query($sql);
    $total_row = $result->fetch_assoc();
    return $total_row["num"];
};
$total_movies = getTotal($where);

// gevraagde resultaten
$sql = "SELECT * FROM movies $where ORDER BY $sort $direction LIMIT $offset, $per_page";
$result = $mysqli->query($sql);

$total_pages = ceil($total_movies / $per_page);


$mysqli->close();
?>

<html>

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    <div class="container">
        <h1>Movies</h1>
        <?php

        echo "<p>" . $total_movies . " resultaten gevonden</p>";
        echo "<p>Gesorteerd op '" . ucfirst($sort) . "'</p>";
        echo "<p><a href='./index.php'>HOME</i></a></p>";

        // start table
        echo "<table class='table'>";
        echo "<tr>";
        echo "<th scope='col'><a href='?sort=id&direction=" . ($sort == 'id' && $direction == 'ASC' ? 'down' : 'up') . "'>id</a></th>";
        echo "<th scope='col'><a href='?sort=name&direction=" . ($sort == 'name' && $direction == 'ASC' ? 'down' : 'up') . "'>Name</a></th>";
        echo "<th scope='col'><a href='?sort=genre&direction=" . ($sort == 'genre' && $direction == 'ASC' ? 'down' : 'up') . "'>Genre</a></th>";
        echo "<th scope='col'><a href='?sort=studio&direction=" . ($sort == 'studio' && $direction == 'ASC' ? 'down' : 'up') . "'>Studio</a></th>";
        echo "<th scope='col'><a href='?sort=score&direction=" . ($sort == 'score' && $direction == 'ASC' ? 'down' : 'up') . "'>Score</a></th>";
        echo "<th scope='col'><a href='?sort=rotten_tomatoes_score&direction=" . ($sort == 'rotten_tomatoes_score' && $direction == 'ASC' ? 'down' : 'up') . "'>Rotten Tomatoes Score</a></th>";
        echo "<th scope='col'><a href='?sort=year&direction=" . ($sort == 'year' && $direction == 'ASC' ? 'down' : 'up') . "'>Year</a></th>";
        echo "</tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["id"] . "</td>";
            echo "<td>" . $row["name"] . "</td>";
            echo "<td>" . $row["genre"] . "</td>";
            echo "<td><a href='index.php?studio=" . urlencode($row["studio"]) . "'>" . $row["studio"] . "</a></td>";
            echo "<td>" . $row["score"] . "</td>";
            echo "<td>" . $row["rotten_tomatoes_score"] . "</td>";
            echo "<td>" . $row["year"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "<div class='pageNav'>";
        if ($page > 1) {
            echo '<a href="?page=' . ($page - 1) . '&sort=' . $sort . '">Previous</a>';
        } else {
            echo '<a class="hidden" href="?page=' . ($page - 1) . '&sort=' . $sort . '">Previous</a>';
        }
        echo "<div class=nav>";

        // has to be even
        $show = 7;
        $show = $show > $total_pages ? $total_pages : $show;
        $num = $total_pages - $show;

        if ($page <= 1 + floor($show / 2)) {
            $nav_start = 1;
            $nav_end = $show;
        } else if ($page >= ($total_pages - floor($show / 2))) {
            $nav_start = $num + 1;
            $nav_end = $total_pages;
        } else {
            $nav_start = $page - floor($show / 2);
            $nav_end = $page + floor($show / 2);
        }
        for ($i = $nav_start; $i <= $nav_end; $i++) {
            if ($i == $page) {
                echo "<a class='active' href='?page=$page&sort=$sort'>$page</a> ";
            } else {
                echo "<a href='?page=$i&sort=$sort'>$i</a> ";
            }
        }

        echo "</div>";
        if ($offset + $per_page < $total_movies) {
            echo '<a href="?page=' . ($page + 1) . '&sort=' . $sort . '">Next</a>';
        } else {
            echo '<a class=hidden href="?page=' . ($page + 1) . '&sort=' . $sort . '">Next</a>';
        }
        echo "</div>";

        ?>
    </div>
</body>

</html>