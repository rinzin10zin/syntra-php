<?php
$host =  '127.0.0.1';
$user = 'root';
$password = 'root';
$dbname = 'php_func_program'; // Update only this !

// Set DSN
$dsn = 'mysql:host=' . $host . ';dbname=' . $dbname;

try {
  // Create a PDO instance
  $pdo = new PDO($dsn, $user, $password);
  /* makes all fetch by default FETCH_OBJ so u can use: fetch()
      but u can easily over write*/
  $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
  /* to use LIMIT in prepared statements */
  $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch (PDOException $e) {
  echo "Error!: " . $e->getMessage() . "<br/>";
  die();
}


function getAllMovies($sort, $offset, $limit)
{
  global $pdo;

  $sql = "SELECT * FROM movies ORDER BY studio ASC LIMIT :offset, :limit";
  $stmt = $pdo->prepare($sql);
  $data = [
    "sort" => $sort,
    "offset" => $offset,
    "limit" => $limit
  ];
  $stmt->execute($data);
  return $stmt->fetchAll();
}


function getTotalResults($sql)
{
  global $pdo;

  $stmt = $pdo->prepare($sql);
  $stmt->execute();
  return $stmt->rowCount();
}
