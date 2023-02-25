<?php
session_start();
if (!isset($_SESSION['logged'])) {
    header('Location: login/login.html');
    return;
}
$username = $_SESSION['username'];
$role = $_SESSION['role'];
$img = $_SESSION['img'];

require "back/db_connection.php";
try {
    $query = $db->prepare("SELECT DISTINCT based FROM distro");
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    $base = array_column($result, 'based');
    sort($base);
} catch (PDOException $e) {
    header("Location: index.php");
    return;
}

try {
    $query = $db->prepare("SELECT DISTINCT region FROM distro");
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    $region = array_column($result, 'region');
    sort($region);
} catch (PDOException $e) {
    header("Location: index.php");
    return;
}

?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<?php include 'common/header.html'; ?>
<link rel="stylesheet" href="css/finder.css">
<link rel="stylesheet" href="css/common.css">
<script src="js/finder.js"></script>
</head>

<body class="d-flex flex-column min-vh-100">
    <?php include 'common/navbar.html' ?>
    <div class="container text-center">
        <div class="spacer"></div>
        <div class="col-6 center">
            <div class="card">
                <div class="card-title text-center mb-4">
                    <h3 class="text-center fw-bold mb-5">Search a distro</h3>
                </div>
                <div class="login-form-2 card-body vstack gap-2 mx-auto">
                    <div class="form-group">
                        <input type="text" class="form-control" id="name" placeholder="Distro Name">
                    </div>
                    <div class="spacer"></div>
                    <div class="row">
                        <div class="col form-group">
                            <select class="form-select" id="base" aria-label="base selector">
                                <option selected>Distro Base</option>
                                <?php
                                foreach ($base as $b) {
                                    echo "<option value='$b'>$b</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col form-group">
                            <select class="form-select" id="region" aria-label="region selector">
                                <option selected>Distro Region</option>
                                <?php
                                foreach ($region as $r) {
                                    echo "<option value='$r'>$r</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="spacer"></div>
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-color px-5 mb-5 w-100 bt-text"
                            id="start-search">Search</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="spacer"></div>
        <div class="col center" id="results">
            <h1>Results</h1>
            <div class="row">
                <div class="col-sm" id="res-sx"></div>
                <div class="col-sm" id="res-cx"></div>
                <div class="col-sm" id="res-dx"></div>
            </div>
            <h1 class="remove fw-bold text-white">┐(シ)┌</h1>
        </div>
    </div>
    <div class="spacer"></div>
    <?php include 'common/footer.html' ?>

</body>

</html>