<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// function isPalindroom($str){
//     return strtolower($str) == strrev(strtolower($str));
// };

// function isPrime($x){
//     if ($num < 2) {
//         return false;
//     }

//     for ($i = 2; $i <= sqrt($num); $i++) {
//         if ($num % $i == 0) {
//             return false;
//         }
//     }

//     return true;
// }

// function getLengteSchuineZijde($a,$b){
//     return sqrt(abs($a)**2 + abs($b)**2);
// }
// echo "<pre>";
// var_dump();
// exit;


// function showTree($x=5){
//     if ($x <= 0) {return "";}
//     else if ($x == 1) {return "*";}
//     else{
//         for ($i = 1; $i < $x; $i++){
//             echo str_repeat("* ",$i)."<br>";
//         }
//         echo str_repeat("* ",$x-2) . "A " . "*"."<br>";
//         for ($i = $x-1; $i >= 1; $i--){
//             echo str_repeat("* ",$i)."<br>";
//         }
//     }
// }

// echo "<pre>";
// showTree(20);
// exit;

// function showStars($x){
//     if ($x <= 0) {return "";}
//     else if ($x == 1) {return "*";}
//     $str = "";
//     for ($i = 1; $i <= $x-1; $i++) {
//         $str .= str_repeat("* ", $i) . "\n";
//     }
//     $str .= str_repeat("* ", $x - 2) . "A " . "*" . "\n";
//     for ($i = $x - 1; $i >= 1; $i--) {
//         $str .= str_repeat("* ", $i) . "\n";
//     }
//     return $str;
// }

// echo "<pre>";
// print(showStars(5));
// exit;

function daysLeft($date) {
    $datum = strtotime($date);
    $current = time();
    $difference = floor($datum - $current) / (60 * 60 * 24);
    if ($difference < 0){
        return strval(abs($difference)) . " day(s) ago";
    } else if ($difference == 0) {
        return "It's today!";
    }
    else {
        return strval($difference) . " day(s) left";
    }
}

echo "<pre>";
print(daysLeft("2023-01-27"));
exit;

