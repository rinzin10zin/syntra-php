<?php

require("includes/db.inc.php");
require("includes/unsplash.inc.php");

$accKey = "u5EJstKedxSoe56scWifkXAWmGVwHtbVkZp-xE6lgjI";
$secretKey = "W9ReJwnw7CRpXXJzuoqpj51yVk6HcWtLXb_l3wuBUVw";

$keyWord = "flowers";

$dbphotos = getDbPhotos();

// $photos = getPicsByKeyWord($accKey, $keyWord,"5");
// foreach ($photos->results as $photo) {
//     echo '<img src="' . $photo->urls->thumb . '" alt="' . $photo->alt_description . '">';
// }

// $photo = getRandomPic($accKey);
// $imageUrl = $photo->urls->raw;
// echo "<img src='$imageUrl' alt='Unsplash Image'>";

$photos = getUnsplashPhotos($accKey,$keyWord,"1");

echo "<pre>";
var_dump($photos);
var_dump($dbphotos);
exit;
