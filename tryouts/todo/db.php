<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



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

# code... / functions like getDbInfo or insertNewMovie
// $id = 1;

function getAllTodos()
{
    global $pdo;

    $sql = 'SELECT * FROM todos';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $todos = $stmt->fetchAll();
    return $todos;
}

// echo "<pre>";
// foreach ($todos as $key => $todo) {
//     $num = $key + 1;
//     echo "$num. $todo->todo <br>";
// }
// exit;

function insertTodo($todo)
{
    global $pdo;

    $sql = "INSERT INTO `todos` (`id`, `todo`, `created_at`, `completed_at`) 
    VALUES (NULL, :todo, CURRENT_TIMESTAMP, NULL);";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['todo' => $todo]);
}

function deleteTodo($id)
{
    global $pdo;

    $sql = 'DELETE FROM todos WHERE id = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
}
