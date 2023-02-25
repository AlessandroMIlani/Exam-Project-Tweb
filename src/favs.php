<?php
session_start();
if (!isset($_SESSION['logged'])) {
    header('Location: login/login.html');
    return;
}
$username = $_SESSION['username'];
$role = $_SESSION['role'];
$img = $_SESSION['img'];

?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<?php include 'common/header.html'; ?>
<link rel="stylesheet" href="css/favs.css">
<link rel="stylesheet" href="css/common.css">
<script src="js/favs.js"></script>

</head>

<body class="d-flex flex-column min-vh-100">
    <?php include 'common/navbar.html' ?>
    <!-- show info: title, img on right and all the other on the left-->
    <div class="container">
        <div class="spacer"></div>
        <h1 class="text-center fw-bold mb-5 " id="title"></h1>
        <!-- Drag zone -->
        <div class="drag-zone card text-center">
            <div class="card-body text-muted ">
                <p id="fav-info" class="center-text"> Drag here for remove form favourites </p>
            </div>
        </div>
        <!-- Card white fav_list -->
        <div class="row">
            <div class="col-sm" id="fav-sx"></div>
            <div class="col-sm" id="fav-cx"></div>
            <div class="col-sm" id="fav-dx"></div>
        </div>
    </div>
    <div class="spacer"></div>
    <?php include 'common/footer.html' ?>

</body>

</html>