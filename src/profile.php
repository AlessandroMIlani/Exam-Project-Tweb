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
<link rel="stylesheet" href="css/profile.css">
<link rel="stylesheet" href="css/common.css">
<script src="js/profile.js"></script>
</head>


<body class="d-flex flex-column min-vh-100">
    <?php include 'common/navbar.html' ?>
    <div class="container mt-3">
        <div class="card p-3 text-center">
            <div class="card-body">
                <div class="flex-column align-items-center text-center">
                    <div class="d-flex flex-column justify-content-center mb-3 center">
                        <div class="d-flex flex-column ms-3 user-details">
                            <h3 class="mb-0">
                                <?= $username ?>
                            </h3>
                            <div class="image center">
                                <img src="<?= $img ?>" class="rounded-circle" height="120" alt="profile picture">
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-column justify-content-center">
                        <h4 class="center">Edit Profile</h4>
                        <div class="spacer"></div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="inputs">
                                    <label>New Password</label>
                                    <input class="form-control" type="text" id="pswd1" placeholder="Password">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="inputs">
                                    <label>Conferm Password</label>
                                    <input class="form-control" type="text" id="pswd2" placeholder="Password">
                                </div>
                            </div>

                            <div class="col-md-6 center">
                                <div class="spacer"></div>
                                <label>New Img</label>
                                <input class="form-control" type="url" id="url" placeholder="<?= $img ?>">
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-3 gap-2 d-flex justify-content-end">
                <button class="px-3 btn btn-sm btn-outline-primary" id="cancel">Cancel</button>
                <button class="px-3 btn btn-sm btn-primary" id="save">Save</button>
            </div>
        </div>
        <div id="error" class="alert text-center text-center center" role="alert"></div>
    </div>
    </div>
    <?php include 'common/footer.html' ?>
</body>

</html>