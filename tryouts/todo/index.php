<?php
// $data = [
//     'foo' => null,
//     'baz' => 'boom',
//     'cow' => true,
//     'null' => null,
//     'php' => 'hypertext processor'
// ];

// echo "<pre>";
// var_dump(http_build_query($data));
// exit;

include $_SERVER["DOCUMENT_ROOT"] . "/todo/db.php";

if (isset($_GET["id"])) {
    deleteTodo($_GET["id"]);
    // echo $_GET["id"];
}

if (!empty($_POST["todo"])) {
    insertTodo($_POST["todo"]);
}
$todos = getAllTodos();
// echo "<pre>";
// // var_dump($todos);
// foreach ($todos as $key => $todo) {
//     $num = $key + 1;
//     echo "$num. $todo->todo <br>";
// }
// exit;


$pdo = null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TO DO List</title>
</head>

<body>
    <a href="./db.php">DB</a>

    <form action="<?= $_SERVER["PHP_SELF"] ?>" method="post">
        <input type="text" name="todo">
        <input type="submit" value="ADD" name="ADD">
    </form>

    <table>
        <tr>
            <th>#</th>
            <th>Todo</th>
            <th>Created at</th>
            <th>DELETE</th>
        </tr>
        <?php foreach ($todos as $key => $todo) : ?>
            <tr>
                <td><?= $key + 1 ?></td>
                <td><?= $todo->todo ?></td>
                <td><?= $todo->created_at ?></td>
                <td><a href="?id=<?= $todo->id ?>">DEL</a></td>
            </tr>
        <?php endforeach ?>
    </table>
</body>

</html>