<?php
session_start();
if (!isset($_SESSION['logged'])) {
    echo json_encode([
        'status' => 'error'
    ]);
    return;
}

function getFavs()
{
    require "db_connection.php";
    try{
    $query = $db->prepare("SELECT * FROM distro WHERE name IN (SELECT distro FROM favs WHERE username = ?)");
    $query->execute([$_SESSION['username']]);
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    // if no favs
    if (count($result) == 0) {
        return json_encode(["status" => "empty", "message" => "No favourites"]);
    }
    return json_encode(["status" => "success", "favs" => $result]);
    }catch(PDOException $e){
        return json_encode(["status" => "error", "message" => "Problem with the database connection"]);
    }
}

function removeFav($distro)
{
    require "db_connection.php";
    try {
        $query = $db->prepare("DELETE FROM favs WHERE username = ? AND distro = ?");
        $query->execute([$_SESSION['username'], $distro]);

        // count remaining favs for this user
        $query = $db->prepare("SELECT * FROM favs WHERE username = ?");
        $query->execute([$_SESSION['username']]);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
        if (count($result) == 0) {
            return array("status" => "success", "empty" => "true");
        }
        return array("status" => "success", "empty" => "false");
    } catch (PDOException $e) {
        return array("status" => "error", "message" => "Problem with the database connection", "empty" => "false");
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'remove':
                echo json_encode(removeFav($_POST['distro']));
                break;
            case 'getFavs':
                echo getFavs();
                break;
        }
    }
}
?>