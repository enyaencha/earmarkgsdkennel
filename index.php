<?php
    session_start();

    if (!isset($_SESSION['username'])){ 
        include('includes/dbconn.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
<!--    <link href="images/logo.jpg" rel="shortcut icon"> -->
    <title>EARMARK</title>
  
  <!-- core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animate.min.css" rel="stylesheet">
    <link href="css/prettyPhoto.css" rel="stylesheet">  
    <link href="css/main.css" rel="stylesheet">
    <link href="css/responsive.css" rel="stylesheet">

</head><!--/head-->
        
<!--*********************************************START OF NAVIGATION BAR****************************************--> 
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
    <a class="navbar-brand" href="index.php" style="display:flex; align-items:center;">
        <img src="images/home/earmark3.png" alt="Logo" style="height:50px; margin-right:10px;">
        <span style="color:#FFF; font-size:18px; font-weight:bold;">EARMARK GSD KENNEL</span>
    </a>
</div>

    
                <div class="collapse navbar-collapse navbar-right wow fadeInDown">
                    <ul class="nav navbar-nav">
                         <li class="active"><a href="index.php"><i class="fa fa-home"></i>Home</a></li>
                        <li ><a href="about-us.php">About Us</a></li>
                        <li ><a href="available.php">Available Products</a></li>
                        <li><a href="contacts.php">Contacts</a></li>
                                                               
                    </ul>
                </div>
            </div><!--/.container-->
        </nav><!--/nav-->

<!--*********************************************START SLIDER************************************************-->

<div class="container-fluid">
    <br>
        <div class="col-md-9 wow fadeInDown">
        <?php include('includes/dbconn.php'); ?>

<div id="carousel-example-generic" class="carousel slide" data-ride="carousel" data-interval="3000" style="height: 100%; width: 100%; margin-top: 8px; overflow:hidden;">
    
    <?php
    $sql = "SELECT * FROM tblcnp WHERE status = 'available' AND voided = 0 ORDER BY id DESC";
    $result = mysqli_query($con, $sql) or die(mysqli_error($con));
    
    if (mysqli_num_rows($result) > 0):
        $slides = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $slides[] = $row; // store all rows
        }
    ?>

    <!-- Indicators -->
    <ol class="carousel-indicators">
        <?php foreach ($slides as $index => $row): ?>
            <li data-target="#carousel-example-generic" data-slide-to="<?= $index ?>" class="<?= $index == 0 ? 'active' : '' ?>"></li>
        <?php endforeach; ?>
    </ol>

    <!-- Slides -->
    <div class="carousel-inner">
        <?php foreach ($slides as $index => $row): ?>
            <div class="item <?= $index == 0 ? 'active' : '' ?>">
                <img src="<?= $row['image'] ?>" class="img-responsive" alt="<?= $row['name'] ?>" style="width: 600px; height: 100%; object-fit: cover;">
            </div>
        <?php endforeach; ?>
    </div>
    <!-- <div class="carousel-caption">
        <h3 style="color:#8B8B00; font-weight:bold;">EARMARK GSD KENNEL</h3>
        <p style="color:#8B8B00; font-weight:bold;">Welcome to EARMARK GSD KENNEL</p>
        <p style="color:#8B8B00; font-weight:bold;">We have the best puppies for you</p> -->

    <!-- Controls -->
    <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left"></span>
    </a>
    <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right"></span>
    </a>

    <?php else: ?>
        <p style="color: red;">No available images found in the database.</p>
    <?php endif; ?>
</div>
    

                
 

<!--*********************************************OFFER PACKAGES************************************************-->
 
            
               
            </div>

        <div class="col-md-3" >
            <div class="panel panel-default wow fadeInDown">
              <!-- Default panel contents -->
            
              <div class="panel-heading wow fadeInDown" style="font-weight:bold; font-size:16px; color:#36648B;">Welcome To EARMARK <i class="glyphicon glyphicon-calendar"></i> <?php echo date('M d, Y');?></div>
            
            </div>
         
        
            <div class="panel panel-default wow fadeInDown">
            <div class="panel panel-default wow fadeInDown">
    <!-- <div class="panel-heading wow fadeInDown" style="font-weight:bold; font-size:16px; color:#36648B;">Earmark Page</div> -->
    <ul class="list-group">
        <li class="list-group-item wow fadeInDown" style="font-weight:bold;">
            <a href="about-us.php" style="display:block; color:#000; text-decoration:none;" 
               onmouseover="this.style.color='#36648B'; this.parentElement.style.backgroundColor='#f0f8ff';" 
               onmouseout="this.style.color='#000'; this.parentElement.style.backgroundColor='white';">
               About Us 
               <!-- <span style="color:#EE5C42;" class="glyphicon glyphicon-ok pull-right"></span> -->
            </a>
        </li>
        <li class="list-group-item wow fadeInDown" style="font-weight:bold;">
            <a href="ourdog.php" style="display:block; color:#000; text-decoration:none;" 
               onmouseover="this.style.color='#36648B'; this.parentElement.style.backgroundColor='#f0f8ff';" 
               onmouseout="this.style.color='#000'; this.parentElement.style.backgroundColor='white';">
               Our Dogs
               
            </a>
        </li>
        <li class="list-group-item wow fadeInDown" style="font-weight:bold;">
            <a href="contacts.php" style="display:block; color:#000; text-decoration:none;" 
               onmouseover="this.style.color='#36648B'; this.parentElement.style.backgroundColor='#f0f8ff';" 
               onmouseout="this.style.color='#000'; this.parentElement.style.backgroundColor='white';">
               Contacts
            </a>
        </li>
        <li class="list-group-item wow fadeInDown" style="font-weight:bold;">
            <a href="availablestud.php" style="display:block; color:#000; text-decoration:none;" 
               onmouseover="this.style.color='#36648B'; this.parentElement.style.backgroundColor='#f0f8ff';" 
               onmouseout="this.style.color='#000'; this.parentElement.style.backgroundColor='white';">
               Available Studs
               
            </a>
        </li>
        <li class="list-group-item wow fadeInDown" style="font-weight:bold;">
            <a href="upcoming.php" style="display:block; color:#000; text-decoration:none;" 
               onmouseover="this.style.color='#36648B'; this.parentElement.style.backgroundColor='#f0f8ff';" 
               onmouseout="this.style.color='#000'; this.parentElement.style.backgroundColor='white';">
               Upcoming Litter
               
            </a>
        </li>
        <li class="list-group-item wow fadeInDown" style="font-weight:bold;">
            <a href="available.php" style="display:block; color:#000; text-decoration:none;" 
               onmouseover="this.style.color='#36648B'; this.parentElement.style.backgroundColor='#f0f8ff';" 
               onmouseout="this.style.color='#000'; this.parentElement.style.backgroundColor='white';">
               Current Litter
               
            </a>
        </li>
        <li class="list-group-item wow fadeInDown" style="font-weight:bold;">
            <a href="pastlitter.php" style="display:block; color:#000; text-decoration:none;" 
               onmouseover="this.style.color='#36648B'; this.parentElement.style.backgroundColor='#f0f8ff';" 
               onmouseout="this.style.color='#000'; this.parentElement.style.backgroundColor='white';">
               Past Litter
               
            </a>
        </li>
        <li class="list-group-item wow fadeInDown" style="font-weight:bold;">
            <a href="available.php" style="display:block; color:#000; text-decoration:none;" 
               onmouseover="this.style.color='#36648B'; this.parentElement.style.backgroundColor='#f0f8ff';" 
               onmouseout="this.style.color='#000'; this.parentElement.style.backgroundColor='white';">
               Other product
               
            </a>
    </ul>
</div>
<br>
<div class="panel panel-default wow fadeInDown">
              <!-- Default panel contents -->
              <div class="panel-heading wow fadeInDown" style="font-weight:bold; font-size:16px; color:#36648B;">Puppies On Special Offer </div>
              <ul class="list-group">
               
                <li class="list-group-item wow fadeInDown">GSD 2 Months - <span style="color:#8B8B00; font-weight:bold;">KSH 20,000 to 25,000 </span> <span style="color:#EE5C42;" class="glyphicon glyphicon-ok pull-right"></span></li>
                 <li class="list-group-item wow fadeInDown">GSD 4 Months   - <span style="color:#8B8B00; font-weight:bold;">KSH 28,000 to 30,000 </span> <span style="color:#EE5C42;" class="glyphicon glyphicon-ok pull-right"></span></li>
                  <li class="list-group-item wow fadeInDown">GSD 6 Months   - <span style="color:#8B8B00; font-weight:bold;">KSH 35k to 42k </span> <span style="color:#EE5C42;" class="glyphicon glyphicon-ok pull-right"></span></li>
                  
                   <li class="list-group-item wow fadeInDown">GSD 12 Months - <span style="color:#8B8B00; font-weight:bold;">KSK 45k Above </span> <span style="color:#EE5C42;" class="glyphicon glyphicon-ok pull-right"></span></li>
                 -->

            
              </ul>
              <a href="available.php" class="btn btn-success btn-sm pull-right wow fadeInDown">Click here to View More</a>
            </div>
            


                    <div class="recent-work-wrap class="wow fadeInDown"">
                        <img class="img-responsive wow fadeInDown" src="images/map.jpg" alt="">
                       
                            <!-- <div class="recent-work-inner">
                                <a class="preview wow fadeInDown" href="images/map1.jpg" rel="prettyPhoto"><br><span class="btn btn-success btm-sm pull-right">Preview Map</span></a>
                            </div>  -->
                    </div>
                </div>  
        </div>

        
</div><!--/.container-->
<br><br>

<!--*************************************************** FOOTERS **********************************************-->
<footer id="footer" class="midnight-blue wow fadeInDown">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 wow fadeInDown">
               &copy; 2025 <a target="_blank" href="#" title="#">EARMARK </a>. All Rights Reserved.
                </div>
                <div class="col-sm-6">
                    <ul class="pull-right wow fadeInDown">
                        <li class="wow fadeInDown"><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
                        
                        <li class="wow fadeInDown"><a href="contacts.php"><i class="fa fa-phone"></i> Contacts</a></li>
                        <li class="wow fadeInDown"><a href="#loginModal" data-toggle="modal" data-target="#loginModal"><i class="fa fa-lock"></i> Admin</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer><!--/#footer-->
 <!----loginModal----->
<?php include('loginModal.php');?>      
                     
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.prettyPhoto.js"></script>
    <script src="js/jquery.isotope.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/wow.min.js"></script>
</body>
</html>

<?php 

} else if(isset($_SESSION['username'])) { 

    include('includes/admin.php');

} ?>