<?php include('includes/dbconn.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Studs</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap & Font Awesome -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding-top: 60px; /* to avoid overlap from fixed navbar */
        }

        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 999;
            background-color: #000;
            border: none;
            border-radius: 0;
            margin-bottom: 0;
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

        .main-content {
            padding: 30px;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }

        .dog-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(1000px, 1fr));
            gap: 5px;
        }

        .dog-card {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(20, 4, 4, 0.1);
            text-align: center;
            padding: 15px;
        }

        .dog-card img {
            width: 900px;
            height: 1100px;
            object-fit: cover;
        }

        .dog-card h3 {
            margin: 10px 0 5px;
        }

        .dog-card p {
            margin: 5px 0;
            font-size: 14px;
            color: #555;
        }

        .dog-card a {
            text-decoration: none;
            color: inherit;
        }
    </style>
</head>
<body>

<!-- Navigation Bar -->
<?php include('includes/navbar.php'); ?>
<!-- Main Content -->
<div class="main-content">
    <h1><span style="font-weight:bold; font-family:verdana;"><i class="glyphicon glyphicon-cog"></i> Studs</span></h1>

    <div class="dog-grid">
        <?php
        $sql = "SELECT * FROM tblcnp WHERE status = 'Homed' AND voided = 0 AND dob < '2022-12-01' AND sex = 'male' ORDER BY id ASC";

        if (!$con) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $result = mysqli_query($con, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $id = $row['id'];
                echo '<div class="dog-card">';
                echo '<a href="includes/full.php?id=' . $id . '"><img src="' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['name']) . '"></a>';
                echo '<h3>' . htmlspecialchars($row['name']) . '</h3>';
                echo '</div>';
            }
        } else {
            echo '<p style="text-align:center;">No dogs found.</p>';
        }
        ?>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

</body>
</html>

<?php mysqli_close($con); ?>
