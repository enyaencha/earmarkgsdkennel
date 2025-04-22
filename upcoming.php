<?php include('includes/dbconn.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upcoming Litter</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap & Font Awesome -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #fefefe;
            padding-top: 60px;
            text-align: center;
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }


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

        .litter-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin: 10px auto;
            max-width: 1000px;
        }

        .dog-box {
            width: 300px;
            background: #fff;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .dog-box img {
            width: 100%;
            height: 300px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 10px;
        }

        .dog-name {
            font-weight: bold;
            font-size: 18px;
            margin-bottom: 5px;
        }

        .scan-section {
            margin-top: 40px;
        }
    </style>
</head>
<body>


<?php include('includes/navbar.php'); ?>
<h1><i class="fa fa-bone"></i> Upcoming Litter</h1>

<div class="litter-container">
    <?php
    // Sire
    $sireQuery = "SELECT * FROM tblcnp WHERE role = 'stud' AND voided = 0 ORDER BY id DESC LIMIT 1";
    $sireResult = mysqli_query($con, $sireQuery);
    if ($sireResult && mysqli_num_rows($sireResult) > 0) {
        $sire = mysqli_fetch_assoc($sireResult);
        echo '<div class="dog-box">';
        echo '<img src="' . htmlspecialchars($sire['image']) . '" alt="' . htmlspecialchars($sire['name']) . '">';
        echo '<div class="dog-name">Sire: ' . htmlspecialchars($sire['name']) . '</div>';
        echo '<p>DOB: ' . htmlspecialchars($sire['dob']) . '</p>';
        echo '</div>';
    }

    // Bitch
    $bitchQuery = "SELECT * FROM tblcnp WHERE role = 'bitch' AND voided = 0 ORDER BY id DESC LIMIT 1";
    $bitchResult = mysqli_query($con, $bitchQuery);
    if ($bitchResult && mysqli_num_rows($bitchResult) > 0) {
        $bitch = mysqli_fetch_assoc($bitchResult);
        echo '<div class="dog-box">';
        echo '<img src="' . htmlspecialchars($bitch['image']) . '" alt="' . htmlspecialchars($bitch['name']) . '">';
        echo '<div class="dog-name">Bitch: ' . htmlspecialchars($bitch['name']) . '</div>';
        echo '<p>DOB: ' . htmlspecialchars($bitch['dob']) . '</p>';
        echo '</div>';
    }
    ?>
</div>

<div class="scan-section">
    <h2>Expected Litter Scan</h2>
    <p><a href="scan/expected-litter.pdf" target="_blank">Click here to view scan (PDF)</a></p>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

</body>
</html>

<?php mysqli_close($con); ?>


