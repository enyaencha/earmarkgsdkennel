<?php include('dbconn.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dog Details</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap & Font Awesome -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            padding-top: 70px; /* Adjusted to accommodate fixed navbar */
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
            background-color: #FFA500 !important;
            color: #000 !important;
        }

        .navbar .navbar-nav > li > a:hover {
            background-color: #222 !important;
            color: #FFA500 !important;
        }

        .navbar-toggle .icon-bar {
            background-color: #fff;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            background-color: white;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-radius: 10px;
        }

        .dog-img {
            width: 100%;
            max-height: 600px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        video {
            width: 100%;
            max-height: 600px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            margin-bottom: 20px;
        }

        .dog-details p {
            font-size: 18px;
            margin: 10px 0;
        }

        .no-media {
            text-align: center;
            font-style: italic;
            color: #777;
        }
    </style>
</head>
<body>

<!-- Include Reusable Navbar -->
<?php //include('navbar.php'); ?>

<div class="container">
    <?php
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id = intval($_GET['id']);
        $sql = "SELECT * FROM tblcnp WHERE id = ? AND voided = 0";

        if ($stmt = mysqli_prepare($con, $sql)) {
            mysqli_stmt_bind_param($stmt, 'i', $id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);

                $name = htmlspecialchars($row['name']);
                $sex = htmlspecialchars($row['sex']);
                $dob = htmlspecialchars($row['dob']);
                $status = htmlspecialchars($row['status']);
                $description = nl2br(htmlspecialchars($row['description']));

                $image_db_path = $row['image'];
                $video_db_path = $row['video'];

                $image = "../" . $image_db_path;
                $video = "../" . $video_db_path;

                if (!empty($image_db_path)) {
                    echo "<img src=\"$image\" alt=\"$name\" class=\"dog-img\">";
                } else {
                    echo "<p class='no-media'>No image available.</p>";
                }

                echo "<h1>$name</h1>";
                echo "<div class='dog-details'>
                    <p><strong>Sex:</strong> $sex</p>
                    <p><strong>DOB:</strong> $dob</p>
                    <p><strong>Status:</strong> $status</p>
                    <p><strong>Description:</strong> $description</p>
                  </div>";

                if (!empty($video_db_path)) {
                    echo "<video controls>
                        <source src=\"$video\" type=\"video/mp4\">
                        Your browser does not support the video tag.
                      </video>";
                } else {
                    echo "<p class='no-media'></p>";
                }
            } else {
                echo "<p class='no-media'>No details found for the specified ID.</p>";
            }

            mysqli_stmt_close($stmt);
        } else {
            echo "<p class='no-media'>Query preparation failed.</p>";
        }
    } else {
        echo "<p class='no-media'>Invalid or missing ID parameter.</p>";
    }

    mysqli_close($con);
    ?>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

</body>
</html>
