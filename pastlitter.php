<?php include('includes/dbconn.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Past Litter</title>

   <!-- Bootstrap & Font Awesome -->
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #fefefe;
            padding-top: 70px; /* Adjusted for fixed navbar */
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

        /* Grid and Card styles */
        .dog-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            padding: 0 20px 40px;
        }

        .dog-card {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(20, 4, 4, 0.1);
            text-align: center;
            padding: 15px;
            transition: 0.3s ease-in-out;
        }

        .dog-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        }

        .dog-card img {
            width: 100%;
            height: 300px;
            object-fit: cover;
            border-bottom: 1px solid #eee;
        }

        .dog-card h3 {
            margin: 10px 0 5px;
            font-weight: bold;
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

<!-- Include Reusable Navbar -->
<?php include('includes/navbar.php'); ?>

<h1><i class="fa-solid fa-bone"></i> Past Litter</h1>

<div class="dog-grid">
    <?php
    $sql = "SELECT * FROM tblcnp WHERE status = 'Homed' AND voided = 0 ORDER BY id ASC";
    $result = mysqli_query($con, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            $image = !empty($row['image']) ? htmlspecialchars($row['image']) : 'images/default.png';
            echo '<div class="dog-card">';
            echo '<a href="includes/full.php?id=' . $id . '"><img src="' . $image . '" alt="' . htmlspecialchars($row['name']) . '"></a>';
//            echo '<a href="/full-details/' . $id . '"><img src="' . $image . '" alt="' . htmlspecialchars($row['name']) . '"></a>';

            echo '<h3>' . htmlspecialchars($row['name']) . '</h3>';
            // Uncomment below if needed:
            // echo '<p>Sex: ' . htmlspecialchars($row['sex']) . '</p>';
            // echo '<p>DOB: ' . htmlspecialchars($row['dob']) . '</p>';
            // echo '<p>' . htmlspecialchars($row['description']) . '</p>';
            echo '</div>';
        }
    } else {
        echo '<p style="text-align:center;">No dogs found.</p>';
    }
    ?>
</div>

</body>
</html>

<?php mysqli_close($con); ?>
