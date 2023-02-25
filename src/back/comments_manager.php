<?php
session_start();
if (!isset($_SESSION['logged'])) {
    echo json_encode([
            'status' => 'error'
        ]);
    return;
}

function loadComments($distro){
    require "db_connection.php";
    try{
    $query = $db->prepare("SELECT comments.*, user.img FROM comments JOIN user on (user.username=comments.username) WHERE distro = ?");
    $query->execute([$distro]);
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    return json_encode(["status" => "success", "comments" => $result]);
    }catch(PDOException $e){
        return json_encode(["status" => "error", "message" => "Problem with the database connection"]);
    }
}

function addComments($distro,$comment){
    require "db_connection.php";
    try{
        $data = date("Y-m-d H:i:s");
        $comment = htmlspecialchars($comment);
        $query = $db->prepare("INSERT INTO comments(distro, comment, username, date) values (?, ?, ?, ?)");
        $query->execute([$distro, $comment, $_SESSION['username'], $data]);
        $query2 = $db->prepare("SELECT img FROM user WHERE username = ?");
        $query2->execute([$_SESSION['username']]);
        $user = $query2->fetch(PDO::FETCH_ASSOC);
        $user['username'] = $_SESSION['username'];
        $user['date'] = $data;
        $user['comment'] = $comment;
        $user['status'] = "success";
        return json_encode($user);

    }catch(PDOException $e){
        return json_encode(["status" => "error", "message" => "Problem with the database connection"]);
    }
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['action'])) {
        switch($_POST['action']) {
            case 'loadComments':
                echo loadComments($_POST['distro']);
                break;
            case 'addComment':
                echo addComments($_POST['distro'],$_POST['comment']);
                return;
            }
        }
    }

?>
