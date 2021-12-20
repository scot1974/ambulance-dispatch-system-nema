<?php include_once 'assets/inc/_admin_nav.php'; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div id="carouselId" class="carousel slide" data-ride="carousel" style="height: 300px; border-radius: 5px;">
                <ol class="carousel-indicators">
                    <li data-target="#carouselId" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselId" data-slide-to="1"></li>
                    <li data-target="#carouselId" data-slide-to="2"></li>
                    <li data-target="#carouselId" data-slide-to="3"></li>
                </ol>
                <div class="carousel-inner" role="listbox">
                    <div class="carousel-item active">
                        <img src="assets/images/slides/slide11.jpg" class="img-fluid"  alt="First slide">
                    </div>
                    <div class="carousel-item">
                        <img src="assets/images/slides/slide22.jpg" class="img-fluid" alt="Second slide">
                    </div>
                    <div class="carousel-item">
                        <img src="assets/images/slides/slide33.jpg" class="img-fluid" alt="Third slide">
                    </div>
                    <div class="carousel-item">
                        <img src="assets/images/slides/nema6.png" class="img-fluid" alt="Third slide">
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselId" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselId" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card bg-dark text-white">
                <img class="card-img img-fluid" src="assets/images/EMD-logo.jpg" alt="">
                <div class="card-img-overlay">
                    <p class="card-text text-info">Notice: <em>for emergency only.</em></p>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card border-danger">
                    <img class="card-img-top" src="assets/images/slide5.jfif" alt="">
                    <div class="card-body">
                        <a href="emergency.php" class="btn btn-outline-danger btn-block">Emergencies</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-success">
                    <img class="card-img-top" src="assets/images/slide4.jfif" alt="">
                    <div class="card-body">
                        <a href="dispatch.php" class="btn btn-outline-success btn-block">Dispatchers</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-info">
                    <img class="card-img-top" src="assets/images/report2.jfif" alt="">
                    <div class="card-body">
                        <a href="#" class="btn btn-outline-info btn-block">Reports</a>
                    </div>
                </div>
            </div>
        </div>
    </div>




</div>