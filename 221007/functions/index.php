<?php 
data_default_timezone_set("Europe/Brussels");
function berekenSom($a,$b){
    return ($a + $b);
}

$seconden = $_GET["s"];
function doeIets($a){
    $a = strtoupper($a);
    $a = $a . " - ik heb iets gedaan...";
    return $a;
}

function addOne($teller){
    $teller += 1;
    $extra = 'dit is een tekst die gemaakt wordt in functie addOne';
    return;
}

function showFutureTime(){
    $current_time = time() + (6*60*60);
    $str = date("d/m/Y - H\ui\ms\s",$current_time);
    return $str;
}
function showFutureTimes($extra_time){
    $current_time = time() + $extra_time;
    $str = date("d/m/Y - H\ui\ms\s",$current_time);
    return $str;
}

function

echo "som van 5+3 is " . berekenSom(5,3) . "<br />";
echo berekenSom(10,1) . "<br />";
echo doeIets("dit is mijn tekst") . "<br />";
echo showFutureTime($seconden) . "<br />";
echo showFutureTimes() . "<br />";

?>

