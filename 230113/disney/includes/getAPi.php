<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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

    // if (!$response) {
    //     return array();
    // }

    // if (!isset($response->drinks)) {
    //     return array();
    // }

    // return $response->data;
}
