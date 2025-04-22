<?php include('includes/dbconn.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="images/foods/logo.png" rel="shortcut icon">
    <title>Earmark GSD Kennel</title>

    <!-- Core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animate.min.css" rel="stylesheet">
    <link href="css/prettyPhoto.css" rel="stylesheet">  
    <link href="css/main.css" rel="stylesheet">
    <link href="css/responsive.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 100%;
            padding: 0;
        }
        .thumbnail {
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .row {
            display: flex;
            flex-wrap: wrap;
            margin: 0;
        }
        .col-md-4 {
            flex: 1 1 20%; /* Adjusted to fit 5 items in a row */
            max-width: 20%; /* Adjusted to fit 5 items in a row */
            padding: 10px;
            box-sizing: border-box;
        }
        @media (max-width: 768px) {
            .col-md-4 {
                flex: 1 1 33.33%; /* Adjusted for smaller screens */
                max-width: 33.33%;
            }
        }
        @media (max-width: 576px) {
            .col-md-4 {
                flex: 1 1 50%; /* Adjusted for mobile screens */
                max-width: 50%;
            }
        }
        .modal-body {
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 5px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            font-weight: bold;
        }
        #datepickup {
            display: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <?php
            $sql = "SELECT * FROM tblcnp WHERE  voided = 0 ORDER BY id ASC";
            $result = mysqli_query($con, $sql) or die(mysqli_error($con));

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $id = $row['id'];
                    // echo '<a href="includes/full.php?id=' . $id . '"><img src="' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['name']) . '"></a>';
            ?>
                <div class="col-md-4 col-sm-6">
                    <div class="card" style="margin-bottom: 20px;">
                        <img src="<?php echo $row['image']; ?>" class="card-img-top img-responsive img-rounded" alt="<?php echo $row['name']; ?>" style="width: 100%; height: auto;">
                        
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row['name']; ?></h5>
                            <p class="card-text"> <?php echo $row['sex'];  ?></p>
                            <p class="card-text"><strong>Sire:</strong> <?php echo $row['sire'];  ?></p>
                            <p class="card-text"><strong>Bitch:</strong> <?php echo $row['bitch'];  ?></p>
                             <?php echo $row['status'];  ?></p>
                            <p class="card-text"><strong>DOB:</strong> <?php echo $row['dob'];  ?></p>
                            <p class="card-text"><?php echo $row['description']; ?></p>
                            <p class="card-text"><strong>KSH:</strong> <?php echo $row['prize']; ?></p>
                            <button class="btn btn-success" data-toggle="modal" data-target="#orderModal<?php echo $id; ?>"><i class="glyphicon glyphicon-shopping-cart"></i> Add to Cart</button>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="orderModal<?php echo $id; ?>" tabindex="-1" role="dialog" aria-labelledby="orderModalLabel<?php echo $id; ?>">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="orderModalLabel<?php echo $id; ?>"><i class="glyphicon glyphicon-edit"></i> Customer Information</h4>
                            </div>
                            <form class="form-horizontal" method="post" action="">
                                <div class="modal-body">
                                    <p>Fields with (*) are required</p>
                                    <div class="form-group">
                                        <label for="name" class="col-sm-2 control-label">Name*</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="name" placeholder="Your name" required>
                                            <input type="hidden" name="foodid" value="<?php echo $id; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label">Address*</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" name="address" required></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="contact" class="col-sm-2 control-label">Contact*</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="contact" placeholder="Your number" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="oqty" class="col-sm-2 control-label">Quantity*</label>
                                        <div class="col-sm-10">
                                            <input type="number" class="form-control" name="oqty" placeholder="1" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="otype" class="col-sm-2 control-label">Order Type*</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" name="otype" required>
                                                <option value="">Select</option>
                                                <option value="Deliver">Deliver</option>
                                                <option value="Pick-up">Pick-up</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group" id="datepickup" style="display: none;">
                                        <label for="datep" class="col-sm-2 control-label">Date Pick-up*</label>
                                        <div class="col-sm-10">
                                            <input type="date" class="form-control" name="datep">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary" name="savechanges"><i class="glyphicon glyphicon-thumbs-up"></i> Order</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php
                }
            } else {
                echo '<div class="col-12"><strong style="color:red">No available data in the server</strong></div>';
            }
            ?>
        </div>
    </div>

    <?php
    if (isset($_POST['savechanges'])) {
        $id = $_POST['foodid'];
        $name = $_POST['name'];
        $address = $_POST['address'];
        $contact = $_POST['contact'];
        $qty = $_POST['oqty'];
        $otype = $_POST['otype'];
        $datep = $_POST['datep'];

        $sql = "SELECT * FROM tblorders WHERE cname = '$name'";
        $result = mysqli_query($con, $sql);

        if (mysqli_num_rows($result) == 5) {
            echo '<script>alert("You have reached the maximum order limit of 5.");
                    window.location.href="availableframe.php";</script>';
        } else {
            $sql = "INSERT INTO tblorders VALUES(NULL, '$name', '$address', '$contact', '$id', '$qty', 'new', CURRENT_TIMESTAMP, '$otype', '$datep')";
            $result = mysqli_query($con, $sql);

            if ($result) {
                echo '<script>alert("Your order has been placed successfully. We will contact you shortly.");
                        window.location.href="availableframe.php";</script>';
            } else {
                echo '<script>alert("Unable to process your request. Please try again later.");
                        window.location.href="availableframe.php";</script>';
            }
        }
    }
    ?>

    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $("select[name='otype']").change(function() {
                if ($(this).val() === "Pick-up") {
                    $("#datepickup").show(200);
                } else {
                    $("#datepickup").hide();
                }
            });
        });
    </script>
</body>
</html></div>
