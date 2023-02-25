<?php
session_start();
if (!isset($_SESSION['logged'])) {
    echo json_encode([
            'status' => 'error'
        ]);
    return;
    if($_SESSION['username'] != 'admin'){
        echo json_encode([
            'status' => 'error'
        ]);
        return;
    }
}

function loadDistroData($distro){
    require "db_connection.php";
    try{
        $query = $db->prepare("SELECT * FROM distro WHERE name = ?");
        $query->execute([$distro]);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $result = json_encode($result);
        // add field status to the json
        $result = str_replace("}", ",\"status\":\"success\"}", $result);
        return $result;
    }catch(PDOException $e){
        return json_encode(["status" => "error", "message" => "Problem with the database connection"]);
    }
}

function saveDistroData($data){
    require "db_connection.php";
    try{
        $query = $db->prepare("UPDATE distro SET based = :based, region = :region, `desc` = :desc, arch = :arch, web = :web, version = :version WHERE name = :name");
        if(!isset($data['desc']) || $data['desc'] == ""){
            $data['desc'] = null;
        }
        $query->execute([
            'based' =>  htmlspecialchars($data['based']),
            'region' =>  htmlspecialchars($data['region']),
            'arch' =>  htmlspecialchars($data['arch']),
            'desc' => htmlspecialchars($data['desc']) ?? 'NULL',
            'web' =>  htmlspecialchars($data['web']),
            'version' =>  htmlspecialchars($data['version']),
            'name' =>  htmlspecialchars($data['name'])
        ]);
        return json_encode(["status" => "success", "message" => "Distro data saved"]);
    }catch(PDOException $e){
        //print error message for debug
        return json_encode(["status" => "error", "message" => "Problem with the database connection"]);
    }
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['action'])) {
        switch($_POST['action']) {
            case 'loadDistroData':
                echo loadDistroData($_POST['distro']);
                break;
            case 'saveDistroData':
                echo saveDistroData($_POST['data']);
                break;
            }
        }
    }

?>