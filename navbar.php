<?php ?>
<link rel="stylesheet" href="assets/css/loaderstyle.css"/>
<link rel="stylesheet" href="assets/css/corestyle.css"/>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
<script src="assets/js/scripts.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.js"></script>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>

<div>
    <nav class="navbar navbar-light navbar-expand-md navigation-clean-button" style="height: 63px;">
        <div class="container"><a class="navbar-brand" href="index.php">Media Team System</a><button class="navbar-toggler" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse"
                 id="navcol-1">
                <ul class="nav navbar-nav mr-auto">
                    <li class="nav-item" role="presentation"><a class="nav-link" href="index.php">Status</a></li>

                    <li class="dropdown nav-item"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#">Administrative Tools</a>
                        <div class="dropdown-menu" role="menu"><a class="dropdown-item" role="presentation" href="allrequest.php">All Requests</a><a class="dropdown-item" role="presentation" href="log.php">Log</a><a class="dropdown-item" role="presentation" href="equipmentfullstatus.php">Full Status</a></div>
                    </li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="logout.php" style="color: salmon;">Logout</a></li>
                </ul><span class="navbar-text actions"> <a href="check-in.php" class="login">Return</a><a class="btn btn-light action-button" role="button" href="check-out.php">Check Out</a></span></div>
        </div>
    </nav>
</div>
