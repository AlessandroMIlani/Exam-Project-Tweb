<?php
session_start();
if (!isset($_SESSION['logged'])) {
    header('Location: login/login.html');
    return;
}
if ($_SESSION['role'] != 'admin') {
    header('Location: index.php');
    return;
}

$username = $_SESSION['username'];
$role = $_SESSION['role'];
$img = $_SESSION['img'];

require('back/db_connection.php');

//get all distro name
$query = $db->prepare('SELECT name FROM distro');
$query->execute();
$distro = $query->fetchAll(PDO::FETCH_ASSOC);
$distro = array_column($distro, 'name'); 

?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<?php include 'common/header.html'; ?>
<link rel="stylesheet" href="css/admin.css">
<link rel="stylesheet" href="css/common.css">
<script src="js/admin.js"></script>
</head>

<body class="d-flex flex-column min-vh-100">
    <?php include 'common/navbar.html' ?>
    <!-- permetti di visualizzare i dati di una distro e modificarli -->
    <div class="container col-4 center">
        <div class="spacer"></div>
        <h1 class="text-center fw-bold mb-5">Admin Page</h1>
        <!-- form select distro -->
        <div class="card center">
            <div class="card-body">
                <div class="login-form-2 card-body gap-2 mx-auto">
                    <div class="row">
                        <div class="form-group">
                            <select class="form-select" id="distros" aria-label="distro selector">
                                <option selected>Distro to Edit</option>
                                <?php
                                foreach ($distro as $d) {
                                    echo "<option value='$d'>$d</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="spacer"></div>
                        <div class="form-group">
                            <button type="button" class="btn btn-outline-primary px-2 mb-2 w-100"
                                id="load-distro-data">Load</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="spacer"></div>
        <!-- empty div to fill with the distro info to edit-->
        <div id="distro-info" class="card">
            <div class="card-body">
                <div class="login-form-2" id="data-form">
                </div>
            </div>
        </div>
        <div id="error" class="alert alert-danger text-center text-center" role="alert"></div>
    </div>
    <?php include 'common/footer.html' ?>
</body>
          