<?php
date_default_timezone_set("Europe/Brussels");

function getHello($firstname, $name,$geslacht=""){
    $hour = (int)date("G");
    $firstname = ucfirst(strtolower($firstname));
    $lastname = ucfirst(strtolower($name));

    //Begroeting
    if ($hour < 6) {
        $hello = "Goedenacht";
    } elseif ($hour < 11) {
        $hello = "Goedenmorgen";
    } elseif ($hour < 17) {
        $hello = "Dag";
    } else {
        $hello = "Goedenavond";
    }

    //Title
    // $titel = "";
    // if(ucfirst($geslacht)=="F"){
    //     $titel = "mevrouw";
    // } 
    // if (ucfirst($geslacht)=="M"){
    //     $titel = "meneer";
    // }

    //Title with switch
    switch (ucfirst($geslacht)) {
        case 'F':
            $titel = "mevrouw";
            break;
        
        case 'M':
            $titel = "meneer";
            break;
            
        default:
            $titel = "";
            break;
    }

    //return
    return "$hello $titel $lastname,";
}
