<?php
    require "db_connection.php";
    $username = htmlspecialchars($_POST['username']);
    $password = $_POST['password'];

    try{
        $smtm = $db->prepare("SELECT username,password,salt,img,role FROM user WHERE username = ?");
        $smtm->execute([$username]);
        $data = $smtm->fetch(PDO::FETCH_ASSOC);
        $row = $smtm->rowCount();
        }catch(PDOException $e){
            echo json_encode(["status" => "error", "message" => "Problem with the database connection"]);
            return;
        }

    
    if($row == 1){
        $password = hash('sha512', $password . $data["salt"]);
        if($password == $data["password"]){
            session_start();
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $data["role"];
            $_SESSION['logged'] = true;
            $_SESSION['img'] = $data["img"];
            echo json_encode(["status" => "success", "message" => "Logged in"]);
        }
        else{
        echo json_encode(["status" => "error", "message" => "Wrong password"]);
        }
    }else if ($row == 0){
        echo json_encode(["status" => "error", "message" => "User not found"]);
    }else{
        echo json_encode(["status" => "error", "message" => "Problem with the database connection"]);
    }
