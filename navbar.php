<?php
?>

<div>
    <nav class="navbar navbar-light navbar-expand-md navigation-clean-button" style="height: 63px;">
        <div class="container"><a class="navbar-brand" href="new_index.php">Media Team System</a><button class="navbar-toggler" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse"
                 id="navcol-1">
                <ul class="nav navbar-nav mr-auto">
                    <li class="nav-item" role="presentation"><a class="nav-link" href="new_index.php">Availability Status</a></li>

<!--                    <li class="dropdown nav-item" style="display: none" >-->
<!--                        <a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#">Administrative Tools</a>-->
<!--                        <div class="dropdown-menu" role="menu">-->
<!--                            <a class="dropdown-item" role="presentation" href="requests.php">Requests</a>-->
<!--                            <a class="dropdown-item" role="presentation" href="manageEq.php">Manage Equipments</a>-->
<!--                            <a class="dropdown-item" role="presentation" href="dashboard.php">Dashboard</a>-->
<!--                            <a class="dropdown-item" role="presentation" href="log.php">Log</a>-->
<!--                        </div>-->
<!--                    </li>-->

                    <li class="nav-item" role="presentation"><a class="nav-link" href="logout.php" style="color: salmon;">Logout</a></li>
                        <li class="dropdown" style="margin-left:10px" id="notif-dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" onclick="load_unseen_notification('read')"><span class="badge" style="position: absolute;left: 13px;top: 2px;color: white;background: red;" id="countBadge">0</span>
                                <span class="material-icons" style="padding-top:20%">notifications</span></a>
                            <ul class="dropdown-menu-notif dropdown-menu" style="padding: 10px; min-width:300px;max-height: 50vh; height: auto;overflow-y: auto; border-radius: 8px; margin-top:15px" id="notif-drop"></ul>
                        </li>
                </ul><span class="navbar-text actions"><a class="btn btn-light action-button" role="button" href="checkout.php">Check Out</a></span></div>



        </div>


<div>
        <div class="dropdown" id="cart-dropdown">
            <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" id="cartBtn" onclick="openModal()">
                <i class="fa fa-shopping-cart" aria-hidden="true"></i> Cart
            </button>
            <div class="dropdown-menu" id="cart-dropdown-menu" role="menu" aria-labelledby="dLabel" >

<!--                <div class="row cart-detail">-->
<!--                                        <div class="col-lg-4 col-sm-4 col-4 cart-detail-img">-->
<!--                                            <img src="https://images-na.ssl-images-amazon.com/images/I/811OyrCd5hL._SX425_.jpg">-->
<!--                                        </div>-->
<!--                    <div class="col-lg-8 col-sm-8 col-8 cart-detail-product">-->
<!--                        <p>Sony DSC-RX100M..</p>-->
<!--                        <span class="price text-info"> $250.22</span> <span class="count"> Quantity:01</span>-->
<!--                    </div>-->
<!--                </div>-->
                <div id="cartDiv" class="cartDiv"><?php include('navbarCart.php') ?></div>

<!--                <div class="row cart-detail">-->
<!--                    <div class="col-lg-4 col-sm-4 col-4 cart-detail-img">-->
<!--                        <img src="https://static.toiimg.com/thumb/msid-55980052,width-640,resizemode-4/55980052.jpg">-->
<!--                    </div>-->
<!--                    <div class="col-lg-8 col-sm-8 col-8 cart-detail-product">-->
<!--                        <p>Lenovo DSC-RX100M..</p>-->
<!--                        <span class="price text-info"> $445.78</span> <span class="count"> Quantity:01</span>-->
<!--                    </div>-->
<!--                </div>-->
                <div class="row">
                    <div class="col-lg-12 col-sm-12 col-12 text-center checkout" align="center">
                        <button class="btn btn-primary btn-block" style="width: 60%; display: inline-block; margin: 0" onclick="location.href = 'checkout.php'">Checkout</button>
                        <button class="btn btn-danger btn-block" style="width: 30%; margin: 0 ;display: inline-block; height: 50px" onclick="clearCart()">Reset Cart</button>
                    </div>
                </div>
            </div>


        </div>
</div>


    </nav>
</div>
<!--style for cart-->
<style>
    #cart-dropdown{
        float:right;
        padding-right: 30px;
        position: sticky;
        top: 10px;
        border-radius: 8px;
    }
    /*.btn{*/
    /*    margin:10px;*/
    /*    box-shadow:none !important;*/
    /*}*/
    #cart-dropdown #cart-dropdown-menu{
        padding:20px;
        top:140% !important;
        width:450px !important;
        left:-350% !important;
        box-shadow:0 10px 20px rgba(0,0,0,0.19), 0 6px 6px rgba(0,0,0,0.23);
        overflow-y: scroll;
        max-height: 70vh;
        height: auto;
        border-radius:8px;
    }
    .total-header-section{
        border-bottom:2px solid #d2d2d2;
    }
    .total-section p{
        margin-bottom:20px;
    }
    .cart-detail{
        padding:15px 0px;
    }
    .cart-detail-img img{
        width:100%;
        height:100%;
        padding-left:15px;
    }
    .cart-detail-product p{
        color:#000;
        font-weight:500;
    }
    .cart-detail .price{
        font-size:12px;
        margin-right:10px;
        font-weight:500;
    }
    .cart-detail .count{
        color:#C2C2DC;
    }
    .checkout{
        border-top:1px solid #d2d2d2;
        padding-top: 15px;
    }
    .checkout .btn-primary{
        /*border-radius:50px;*/
        height:50px;
    }
    #cart-dropdown-menu:before{
        content: " ";
        position:absolute;
        top:-20px;
        right:50px;
        border:10px solid transparent;
        border-bottom-color:#fff;
    }
    img {
        height: 100%;
        width: 100%;
    }
    #imgContainer{
        height: 100%;
        margin: 0 auto;
    };
</style>

