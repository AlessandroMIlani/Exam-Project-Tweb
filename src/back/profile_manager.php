<?php
session_start();
if (!isset($_SESSION['logged'])) {
    echo json_encode([
            'status' => 'error'
        ]);
    return;
}


function changePswd($pswd1,$pswd2){
    require "db_connection.php";
    if($pswd1 != $pswd2 || strlen($pswd1) < 8){
        return json_encode([
            'status' => 'error',
            'message' => 'Passwords are not the same'
        ]);
    }
    try{
        //get user salt
        $query = $db->prepare("SELECT salt FROM user WHERE username = ?");
        $query->execute([$_SESSION['username']]);
        $salt = $query->fetch(PDO::FETCH_ASSOC)['salt'];
        //hash password
        $pswd = hash('sha512', $pswd1.$salt);

        $query = $db->prepare("UPDATE user SET password = ? WHERE username = ?");
        $query->execute([$pswd, $_SESSION['username']]);

        return json_encode([
            'status' => 'success',
            'message' => 'Password changed'
        ]);
    }catch(PDOException $e){
        return json_encode([
            'status' => 'error',
            'message' => 'Problem with the database'
        ]);
    }
}

function changeUrl($url){
    require "db_connection.php";
    try{
        $query = $db->prepare("UPDATE user SET img = ? WHERE username = ?");
        $query->execute([$url, $_SESSION['username']]);

        return json_encode([
            'status' => 'success',
            'message' => 'Image changed, log out and log in again to see the changes'
        ]);
    }catch(PDOException $e){
        return json_encode([
            'status' => 'error',
            'message' => 'Problem with the database'
        ]);
    }
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['action'])) {
        switch($_POST['action']) {
            case "changePswd":
                echo changePswd($_POST['pswd1'],$_POST['pswd2']);
                return;
            case "changeUrl":
                echo changeUrl($_POST['url']);
                return;
            }
        }
    }


?>