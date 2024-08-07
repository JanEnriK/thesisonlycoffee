<?php require "partials/head.php"; ?>
<?php require "partials/nav.php"; ?>

<!-- Page Header Start -->
<div class="container-fluid page-header mb-3 position-relative overlay-bottom">
    <div class="d-flex flex-column align-items-center justify-content-center pt-0 pt-lg-5" style="min-height: 100px">
        <!-- <h1 class="display-4 mb-3 mt-0 mt-lg-5 text-white text-uppercase">About Us</h1>
        <div class="d-inline-flex mb-lg-5">
            <p class="m-0 text-white"><a class="text-white" href="">Home</a></p>
            <p class="m-0 text-white px-2">/</p>
            <p class="m-0 text-white">About Us</p>
        </div> -->
    </div>
</div>
<!-- Page Header End -->


<!-- About Start -->
<div class="container-fluid py-5">
    <div class="container">
        <div class="text-center">
            <h4 class="text-primary text-uppercase" style="letter-spacing: 5px;">About Us</h4>
            <h1 class="display-4">Serving Since <?= date('Y', strtotime($coffee['date_established'])) ?></h1>
        </div>
        <div class="row">
            <div class="col-lg-4 py-0 py-lg-5">
                <h1 class="mb-3">Our Tagline</h1>
                <p class="mb-3 text-justify" style="text-indent: 2em;"><?= $coffee['tagline'] ?></p>
                <!-- <a href="" class="btn btn-secondary font-weight-bold py-2 px-4 mt-2 ">Learn More</a> -->
            </div>
            <div class="col-lg-4 py-5 py-lg-0" style="min-height: 500px;">
                <div class="position-relative h-100">
                    <img class="position-absolute w-100 h-100" src="img/about.png" style="object-fit: cover;">
                </div>
            </div>
            <div class="col-lg-4 py-0 py-lg-5">
                <h1 class="mb-3">Our Vision</h1>
                <?php foreach (json_decode($coffee['vision']) as $visions) : ?>
                    <h5 class="mb-3"><i class="fa fa-check text-primary mr-3"></i><?= $visions ?></h5>
                <?php endforeach ?>
                <!-- <a href="" class="btn btn-primary font-weight-bold py-2 px-4 mt-2">Learn More</a> -->
            </div>
        </div>
    </div>
</div>
<!-- About End -->

<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
<script src="lib/easing/easing.min.js"></script>
<script src="lib/waypoints/waypoints.min.js"></script>
<script src="lib/owlcarousel/owl.carousel.min.js"></script>
<script src="lib/tempusdominus/js/moment.min.js"></script>
<script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
<script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

<!-- Contact Javascript File -->
<script src="mail/jqBootstrapValidation.min.js"></script>
<script src="mail/contact.js"></script>

<!-- Template Javascript -->
<script src="js/main.js"></script>

<?php require "partials/foot.php"; ?>