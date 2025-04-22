<?php
    session_start();

    if (!isset($_SESSION['username'])){ 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>EARMARK GSD KENNEL</title>
    
    <!-- core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animate.min.css" rel="stylesheet">
    <link href="css/prettyPhoto.css" rel="stylesheet">  
    <link href="css/main.css" rel="stylesheet">
    <link href="css/responsive.css" rel="stylesheet">

    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        #tour-packages {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100%;
        }
        iframe {
            flex-grow: 1;
            width: 100%;
            border: none;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-inverse" role="banner">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="index.php"><h4 class="wow fadeInDown" style="margin-top:20px; color:#FFF;">EARMARK GSD KENNEL</h4></a>
            </div>

            <div class="collapse navbar-collapse navbar-right wow fadeInDown">
                <ul class="nav navbar-nav">
                    <li><a href="index.php"><i class="fa fa-home"></i>Home</a></li>
                    <li><a href="about-us.php">About Us</a></li>
                    <li class="active"><a href="available.php">Available Products</a></li>
                    <li><a href="contacts.php">Contacts</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <section id="tour-packages" class="wow fadeInDown">
        <h1 style="font-size:30px; font-family:verdana; font-weight:bold; color: #8B8B00; text-align:center;">Product</h1>
        <iframe src="availableframe.php"></iframe>
    </section>

    <!-- Optional Footer and Scripts -->
    <!-- <?php include('includes/footer.php');?>
    <?php include('loginModal.php');?>
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.prettyPhoto.js"></script>
    <script src="js/jquery.isotope.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/wow.min.js"></script> -->
</body>
</html>

<?php 
} else if(isset($_SESSION['username'])) { 
    include('includes/admin.php');
} ?>