
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$links = [
    'https://stackoverflow.com/',
    'https://www.w3schools.com/',
    
];

function getSnapShot($link)
{
    require './includes/options.env.php'; 

  $params = [
    'access_key' => $access_key,
    'url' => $link,
    'wait_until' => 'page_loaded',
    'response_type' => 'json',
    'no_cookie_banners' => true,
    'no_ads' => true,
    'no_tracking' => true,
    'format' => 'png'
  ];

  //ADD API URL UNDER HERE AND THE QUERY WILL BE BUILT FROM THE PARAMS
  $url = 'https://api.apiflash.com/v1/urltoimage?' . http_build_query($params);
  
  //create function getApi($url){}
  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_SSL_VERIFYPEER => false,
  ));

  $response = curl_exec($curl);
  curl_close($curl);
  $response = json_decode($response);
  return $response->url;
};

$screenshots = [];

foreach ($links as $key => $link) {
    $url = getSnapShot($link);
    $screenshots[] = $url;
 
    $image_data = file_get_contents($url);
    file_put_contents("./screenshots/screenshot-" . $key + 1 . ".jpeg", $image_data);
 }

print '<pre>';
print_r($screenshots);
print '</pre>';

// $picture = getSnapShot();

?>