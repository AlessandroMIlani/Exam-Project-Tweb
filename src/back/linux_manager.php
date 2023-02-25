<?php

function getFullDistro($name) {
    //replace underscore with space
    $name = str_replace("_", " ", $name);
    require "db_connection.php";
    try{
    $query = $db->prepare("SELECT * FROM distro WHERE name = ?");
    $query->execute([$name]);
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    // add image path if exist
    $result = distoImgs($result, $name);
    return $result;
    }catch(PDOException $e){
        return json_encode(["status" => "error", "message" => "Problem with the database connection"]);
    }
}

function randomDistro(){
    require "db_connection.php";
    try{
    $query = $db->prepare("SELECT * FROM distro ORDER BY RAND()");
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    //pick a random element from the array
    $result[0] = $result[array_rand($result)];

    $result = distoImgs($result, strtolower(trim($result[0]["name"])));
    return $result;
    }catch(PDOException $e){
        return json_encode(["status" => "error", "message" => "Problem with the database connection"]);
    }
}

function distoImgs($distro, $name){
    if(file_exists("img/distro/".$name."/".$name."-small.png")) {
        $distro[0]["img"] = "img/distro/".$name."/".$name."-small.png";
    } else {
        $distro[0]["img"] = "img/distro/default.png";
    }
    if(file_exists("img/distro/".$name."/".$name.".png")) {
        $distro[0]["icon"] = "img/distro/".$name."/".$name.".png";
    } else {
        $distro[0]["icon"] = "img/extra_logo/generic_logo.png";
    }
    return $distro;
}

?>