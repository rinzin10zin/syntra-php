<?php
// $host =  '127.0.0.1';
// $user = 'root';
// $password = 'root';
// $dbname = 'php_watergroep';
// $port = 3305;

$host =  'ID396978_phpFuncProgram.db.webhosting.be';
$user = 'ID396978_phpFuncProgram';
$password = 'rootroot!123';
$dbname = 'ID396978_phpFuncProgram';
$port = 3306;

// Set DSN
$dsn = 'mysql:host=' . $host . ';dbname=' . $dbname . ';port=' . $port;

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
