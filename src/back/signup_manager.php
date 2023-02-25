<?php
    require "db_connection.php";
    $username = htmlspecialchars($_POST['username']);
    $password = $_POST['password'];
    $confPassword = $_POST['confPassword'];

    if($password != $confPassword || strlen($password) < 8){
        echo json_encode(["status" => "error", "message" => "Password not valid"]);
        return;
    }

    //check if the user exists
    try{
    $smtm = $db->prepare("SELECT username FROM user WHERE username = ?");
    $smtm->execute([$username]);
    $result = $smtm->fetch(PDO::FETCH_ASSOC);
    }catch(PDOException $e){
        echo json_encode(["status" => "error", "message" => "Problem with the database connection"]);
        return;
    }

    if($smtm->rowCount() == 1){        
        echo json_encode(["status" => "error", "message" => "User already exists"]);
        return;
    }
    $salt = bin2hex(random_bytes(8));
    $role = 'user';
    //calculate the hash of the password with the salt
    $password = hash('sha512', $password . $salt);

    //insert the user in the database
    try{
        $img = "https://i.imgur.com/mCHMpLT.png";
        $smtm = $db->prepare("INSERT INTO user(username, password, salt, role, img) values (?, ?, ?, ?, ?)");
        $smtm->execute([$username, $password, $salt, $role, $img]);
    }catch(PDOException $e){
        echo json_encode(["status" => "error", "message" => "Problem with the database insert"]);
        return;
    }

    session_start();
    $_SESSION['username'] = $username;
    $_SESSION['role'] = $role;
    $_SESSION['logged'] = true;
    $_SESSION['img']=$img;
    echo json_encode(array("status" => "success", "message" => "Logged in"));
?>