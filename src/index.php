<?php
session_start();
if (!isset($_SESSION['logged'])) {
    header('Location: login/login.html');
    return;
}

$username = $_SESSION['username'];
$img = $_SESSION['img'];


// get 3 random images from carousel folder
$images = glob("img/carousel/*.png");
$random_images = array_rand($images, 3);
// create json with full path and filename
$rand = array(
    array(
        "path" => $images[$random_images[0]],
        "filename" =>   basename($images[$random_images[0]], ".png")
    ),
    array(
        "path" => $images[$random_images[1]],
        "filename" =>   basename($images[$random_images[1]], ".png")
    ),
    array(
        "path" => $images[$random_images[2]],
        "filename" =>   basename($images[$random_images[2]], ".png")
    )
);


?>
<!DOCTYPE html>
    <html lang="en" data-bs-theme="dark">
    <?php include 'common/header.html'; ?>
    <link rel="stylesheet" href="css/homepage.css">
    <link rel="stylesheet" href="css/common.css">
    <script src="js/homepage.js"></script>
    <script src="js/logout.js"></script>
    </head>

    <body class="d-flex flex-column min-vh-100">
        <?php include 'common/navbar.html' ?>
<hr>
  <div id="hero-carousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#hero-carousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#hero-carousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
      <button type="button" data-bs-target="#hero-carousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>

    <div class="carousel-inner">
      <div class="carousel-item active c-item">
        <img src="<?= $rand[0]['path'] ?>" class="d-block w-100 c-img" alt="Slide 1">
        <div class="carousel-caption top-0 mt-4">
          <h1 class="display-1 fw-bolder text-capitalize"><?= $rand[0]['filename'] ?></h1>
        </div>
      </div>
      <div class="carousel-item c-item">
        <img src="<?= $rand[1]['path'] ?>" class="d-block w-100 c-img" alt="Slide 2">
        <div class="carousel-caption top-0 mt-4">
          <h1 class="display-1 fw-bolder text-capitalize"><?= $rand[1]['filename'] ?></h1>
        </div>
      </div>
      <div class="carousel-item c-item">
        <img src="<?= $rand[2]['path'] ?>" class="d-block w-100 c-img" alt="Slide 3">
        <div class="carousel-caption top-0 mt-4">
          <h1 class="display-1 fw-bolder text-capitalize"><?= $rand[2]['filename'] ?></h1>
        </div>
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#hero-carousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#hero-carousel" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>
<hr>
        <div class="row pres">
            <div class="col-lg-4">
                <img class="img rounded-circle" src="img/search.png" width="140" height="140" alt="search icon">
                <h2 class="fw-normal">Search</h2>
                <p>Find the best linux distro for your needs</p>
            </div>
            <div class="col-lg-4">
                <img class="img rounded-circle" src="img/save.png" width="140" height="140" alt="save icon">
                <h2 class="fw-normal">Save</h2>
                <p>Create your favorites list</p>
            </div>
            <div class="col-lg-4">
                <img class="img rounded-circle" src="img/comment.png" width="140" height="140" alt="comment icon">
                <h2 class="fw-normal">Comment</h2>
                <p>Leave a comment on the distros that most impressed you</p>
            </div>
        </div>

        <?php include 'common/footer.html' ?>
    </body>

</html>