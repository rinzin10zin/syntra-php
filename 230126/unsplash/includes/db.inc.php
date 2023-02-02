<!-- connectie met error msg_send -->

<!-- functie get photos -->

<?php

$db_host = '127.0.0.1';
$db_user = 'root';
$db_password = 'root';
$db_db = 'php_func_program';
$db_port = 8888;

$dsn = 'mysql:host=' . $db_host . '; port=' . $db_port . '; dbname=' . $db_db;

try {
  $pdo = new PDO($dsn, $db_user, $db_password);
} catch (PDOException $e) {
  echo "Error!: " . $e->getMessage() . "<br/>";
  die();
}

function getDbPhotos()
{
  global $pdo;

  $stmt = $pdo->prepare("SELECT * FROM `230126_photos` ORDER BY ID DESC");
  $stmt->execute();
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function insertPhoto($unsplash_id, $url)
{
  global $pdo;

  $sql = "INSERT INTO 230126_photos (unsplash_id, url) VALUES (:unsplash_id, :url)";
  $stmt = $pdo->prepare($sql);

  $data = [
    'unsplash_id' => $unsplash_id,
    'url' => $url
  ];

  $stmt->execute($data);
}
