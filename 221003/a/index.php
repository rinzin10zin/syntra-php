<?php
//comments
    $voornaam = "rinzin";
    $achternaam = "tenzin";
    $getal1 = 5;
    $getal2 = 3;
    $getal3 = $getal1 + $getal2;

?>

<!DOCTYPE html>
<head>
    <title>Document</title>
</head>
<body>
    <?php
    echo "<h1>Hallo, " . ucfirst($voornaam) . " " . $achternaam . "</h1>";
    echo "<h1>$som</h1>";
    echo "$voornaam";
    echo "<h3>" .$getal3 . "</h3>";
    ?>
</body>
</html>