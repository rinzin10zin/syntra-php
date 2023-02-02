<!-- get unsplsh photos getUnsplashPhotos() -->

<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require("db.inc.php");

function getAPI($url)
{
    $curl_handle = curl_init();

    // Set the curl URL option
    curl_setopt($curl_handle, CURLOPT_URL, $url);
    // This option will return data as a string instead of direct output
    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
    // Bypass SSL verification (for Windows users)
    curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
    // Execute curl & store data in a variable
    $curl_data = curl_exec($curl_handle);
    curl_close($curl_handle);

    // make the string -> JSON (omgekeerd van json stringigy)
    $response = json_decode($curl_data);

    return $response;
}

function getRandomPic($accKey){
    $url = "https://api.unsplash.com/photos/random?client_id=$accKey";
    $response = getAPI($url);
    return $response;
}

function getPicsByKeyWord($accKey, $keyword, $amount){
    $url = "https://api.unsplash.com/search/photos?query=$keyword&client_id=$accKey&per_page=$amount";
    $response = getAPI($url);
    return $response;
}

function getUnsplashPhotos($accKey, $keyword, $amount){
    $params = [
        'client_id' => $accKey,
        'query' => $keyword,
        'per_page' => $amount,
        'orientation' => 'landscape',
      ];
    
    $url = 'https://api.unsplash.com/search/photos/?' . http_build_query($params);
    $response = getAPI($url);
    return $response;
}