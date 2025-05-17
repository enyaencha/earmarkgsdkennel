<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Navbar Header -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#right-navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="home" style="display:flex; align-items:center;">
                <img src="images/home/earmark3.png" alt="Logo" style="height:50px; margin-right:10px;">
               
            </a>
        </div>

        <!-- Navbar Links -->
        <div class="collapse navbar-collapse navbar-right" id="right-navbar">
            <ul class="nav navbar-nav">
                <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'home' ? 'active' : ''; ?>">
                    <a href="index"><i class="fa fa-home"></i> Home</a>
                </li>
                <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'ourdog.php' ? 'active' : ''; ?>">
                    <a href="ourdog">Our Dogs</a>
                </li>
                <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'availablestud.php' ? 'active' : ''; ?>">
                    <a href="availablestud">Available Studs</a>
                </li>
                <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'upcoming.php' ? 'active' : ''; ?>">
                    <a href="upcoming">Upcoming Litter</a>
                </li>
                <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'pastlitter.php' ? 'active' : ''; ?>">
                    <a href="pastlitter">Past Litter</a>
                </li>
                <!-- Dropdown for Current Litter -->
                <li class="dropdown <?php echo basename($_SERVER['PHP_SELF']) == 'available.php' ? 'active' : ''; ?>">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Current Litter <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="available">Bred By Us</a></li>
                        <li><a href="#">Bred By Others</a></li>
                    </ul>
                </li>
                <li><a href="#">Other Product</a></li>
            </ul>
        </div>
    </div>
</nav>
