<?php
session_start();
if (!isset($_SESSION['logged'])) {
    header("Location: ../../login.html");
    return;
  }
  

function getDistro($name, $base, $region)
{
    require "db_connection.php";
    try{
    $query = $db->prepare("SELECT name,based,region,arch FROM distro WHERE name LIKE  :name AND based LIKE :base AND region LIKE :region");
    $name = htmlspecialchars($name);
    $base = htmlspecialchars($base);
    $region = htmlspecialchars($region);
    $query->execute([
        'name' => '%' . $name . '%',
        'base' => '%' . $base . '%',
        'region' => '%' . $region . '%'
    ]);
    // edit result to match the json format
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    // order by alphabet
    usort($result, function ($a, $b) {
        return strcmp($a['name'], $b['name']);
    });
    // add fild status to the result
    $result = json_encode($result);
    return $result;
} catch (PDOException $e) {
    return json_encode([]);
    }
}

function addFav($distro){
    require "db_connection.php";
    try {
        // check if distro already exists
        $query = $db->prepare("SELECT * FROM favs WHERE username = ? AND distro = ?");
        $query->execute([$_SESSION['username'], $distro]);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        if (count($result) > 0) {
            return array("status" => "present", "message" => "Distro already in favourites");
        }else{
        $query = $db->prepare("INSERT INTO favs (username, distro) VALUES (?, ?)");
        $query->execute([$_SESSION['username'], $distro]);
        return array("status" => "success", "message" => "Distro added to favourites");
        }
    } catch (PDOException $e) {
        return array("status" => "error", "message" => "Problem with the database connection");
    }
}

// if get or post request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'getDistro':
                echo getDistro($_POST['name'], $_POST['base'], $_POST['region']);
                break;
            case "addFav":
                echo json_encode(addFav($_POST['distro']));
                break;
        }
    }
}
?>