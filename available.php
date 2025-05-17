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
            height: 110%;
            margin: 0;
            padding: 0;
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 2px;
        }

        /* Navbar overrides */
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 999;
            background-color: #000;
            border: none;
            border-radius: 0;
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
            width: 70%;
            border: none;
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        /* Navbar overrides */
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 999;
            background-color: #000;
            border: none;
            border-radius: 0;
        }

        .navbar .navbar-brand {
            color: #fff !important;
        }

        .navbar .navbar-brand:hover {
            color: #ccc !important;
        }

        .navbar .navbar-nav > li > a {
            color: #fff !important;
        }

        .navbar .navbar-nav > li.active > a {
            background-color: #FFA500 !important; /* Light orange */
            color: #000 !important;
        }

        .navbar .navbar-nav > li > a:hover {
            background-color: #222 !important;
            color: #FFA500 !important;
        }

        .navbar-toggle .icon-bar {
            background-color: #fff;
        }
    </style>
</head>
<body>
<!-- Include Reusable Navbar -->
<?php //include('includes/navbar.php'); ?>

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