
<div>
    <nav class="navbar navbar-light navbar-expand-md navigation-clean-button" style="height: 63px;">
        <div class="container"><a class="navbar-brand" href="dashboard.php">EqManage System</a><button class="navbar-toggler" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse"
                 id="navcol-1">
                <ul class="nav navbar-nav mr-auto">
<!--                    <li class="nav-item" role="presentation"><a class="nav-link" href="index.php">Status</a></li>-->

                    <li class="dropdown nav-item">
                        <a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#">Administrative Tools</a>
                        <div class="dropdown-menu" role="menu" style="border-radius: 8px; margin-top:15px; margin-left: -10px">
                            <a class="dropdown-item" role="presentation" href="dashboard.php">Dashboard</a>
                            <a class="dropdown-item" role="presentation" href="requests.php">Requests</a>
                            <a class="dropdown-item" role="presentation" href="log.php">Log</a>
                            <a class="dropdown-item" role="presentation" href="overdue.php">Overdue</a>
                            <a class="dropdown-item" role="presentation" href="manageEq.php">Manage Equipments</a>
                            <a class="dropdown-item" role="presentation" href="barcode.php">Barcode</a>
                            <a class="dropdown-item" role="presentation" href="search.php">Search</a>
                        </div>
                    </li>


                    <li class="dropdown nav-item">
                        <a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#">Account</a>
                        <div class="dropdown-menu" role="menu" style="border-radius: 8px; margin-top:15px; margin-left: -80px">
                            <a class="dropdown-item" role="presentation" href="resetPassword.php">Reset Password</a>
                            <a class="dropdown-item" href="logout.php" style="color: salmon;">Logout</a>
                        </div>
                    </li>

                    <li class="dropdown" style="margin-left:10px" id="notif-dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" onclick="load_unseen_notification('read')"><span class="badge" style="position: absolute;left: 13px;top: 2px;color: white;background: red;" id="countBadge">0</span>
                            <span class="material-icons" style="padding-top:20%">notifications</span></a>
                        <ul class="dropdown-menu-notif dropdown-menu" style="padding: 10px; min-width:300px;max-height: 50vh; height: auto;overflow-y: auto; border-radius: 8px; margin-top:15px" id="notif-drop"></ul>
                    </li>
                </ul><span class="navbar-text actions"> <a href="#returnModal" data-toggle="modal" class="login" data-backdrop="false" id="returnModalBtn">Return</a><a class="btn btn-light action-button" data-toggle="modal" role="button" href="#checkoutModal" data-backdrop="false" id="checkoutModalBtn">Scan & Checkout</a></span></div>
        </div>
    </nav>
</div>
