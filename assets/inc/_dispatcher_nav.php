<nav class="navbar navbar-expand-sm navbar-light text-white bg-light">
    <a class="navbar-brand" href="#">
        <marquee direction="right">National Emergency Management Agency</marquee></a>
    <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId"
            aria-controls="collapsibleNavId"
            aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavId">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <li class="nav-item active">
                <a class="nav-link" href="index.php"><i class="fas fa-home"></i> <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="new_emergency.php">New Emergency</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="active_emergency.php">Active Emergencies</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="">Emergencies Details</a>
            </li>
            <li class="nav-item">
               
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown mr-5">
                <a class="nav-link dropdown-toggle" href="#" id="dropdownId" data-toggle="dropdown" aria-haspopup="true"
                   aria-expanded="false"><i class="fas fa-user-alt"></i> Welcome, <?=$profile->getName($_SESSION['profile'])['name'];?></a>
                <div class="dropdown-menu" aria-labelledby="dropdownId">
                    <a class="dropdown-item" href="#"><i class="fas fa-cogs"></i> Setings</a>
                    <a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </div>
            </li>
        </ul>
    </div>
</nav>
<div class="container">

</div>