<?php
session_start();
if (!isset($_SESSION['logged'])) {
    header('Location: login/login.html');
    return;
}
$username = $_SESSION['username'];
$role = $_SESSION['role'];
$img = $_SESSION['img'];
require 'back/linux_manager.php';

if(isset($_GET['distro'])){
    $distro = getFullDistro($_GET['distro']);
    if(!isset($distro[0]["name"]) ){
        $distro = randomDistro();
    }
}else {
    $distro = randomDistro();
}

?>

<!DOCTYPE html>
    <html lang="en" data-bs-theme="dark">
    <?php include 'common/header.html'; ?>
    <link style="text/css" rel="stylesheet" href="css/common.css">
    <link style="text/css" rel="stylesheet" href="css/linux.css">
    <script src="js/linux.js"></script>
    </head>



    <body class="d-flex flex-column min-vh-100">
        <?php include 'common/navbar.html' ?>
        <!-- show info: title, img on right and all the other on the left-->
        <div class="container">
            <div class="spacer"></div>
            <h1 class="text-center fw-bold mb-5" id="distro-title"><?= $distro[0]["name"];?></h1>
            <div class="center">
                <div class="card">
                    <div role="card-body vstack gap-2 col-md-5 mx-auto">
                        <div class="row">
                            <div class="col img-col">
                                <img src="<?= $distro[0]["img"]; ?>" alt="distro image" class="Distro img">
                            </div>
                            <div class="col">
                                <div class="row">
                                    <div class="col">
                                        <div class="text-center">
                                            <div class="spacer"></div>
                                            <img src="<?= $distro[0]["icon"]; ?>" height="100" alt="distro icon"
                                                class="distro-logo">
                                        </div>
                                        <ul>
                                            <li>Badsed on:
                                                <?= $distro[0]["based"]; ?>
                                            </li>
                                            <li>Origin:
                                                <?= $distro[0]["region"]; ?>
                                            </li>
                                            <li>Version:
                                                <?= $distro[0]["version"]; ?>
                                            </li>
                                            <li>Architecture:
                                                <?= $distro[0]["arch"]; ?>
                                            </li>
                                            <li>Website: <a
                                                    href="<?= $distro[0]["web"]; ?>"><?= $distro[0]["web"]; ?></a>
                                            </li>
                                        </ul>
                                        <div class="text-center desc">
                                            <h3> Description </h3>
                                            <p>
                                                <?= $distro[0]["desc"]; ?>
                                            </p>
                                        </div>
                                        <div class="spacer"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- comment section -->
            <div class="spacer"></div>
            <div class="spacer"></div>
            <div class="spacer"></div>
            <h2 class="text-center fw-bold mb-5"> Comments </h2>
            <div class="row d-flex justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="card shadow-0 border">
                        <div class="card-body p-4">
                            <div class="form-outline mb-4">
                                <input type="text" id="comment" class="form-control" placeholder="Type comment..." />
                                <div class="spacer"></div>
                                <button type="button" id="add" class="btn btn-outline-primary">+ Add comment</button>
                            </div>
                        <div id="comments">
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="spacer"></div>
            <div class="spacer"></div>
        </div>
        <?php include 'common/footer.html' ?>
    </body>

    </html>