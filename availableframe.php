<?php
session_start();
include('includes/dbconn.php');

// Initialize cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Handle add to cart AJAX request
if (isset($_POST['action']) && $_POST['action'] == 'addToCart') {
    $productId = $_POST['productId'];

    // Get product details
    $sql = "SELECT id, name, prize, image FROM tblcnp WHERE id = $productId";
    $result = mysqli_query($con, $sql);

    if ($row = mysqli_fetch_assoc($result)) {
        // Check if product already in cart
        $found = false;
        foreach ($_SESSION['cart'] as $key => $item) {
            if ($item['id'] == $productId) {
                $_SESSION['cart'][$key]['quantity']++;
                $found = true;
                break;
            }
        }

        // If not found, add it
        if (!$found) {
            $_SESSION['cart'][] = array(
                'id' => $row['id'],
                'name' => $row['name'],
                'price' => $row['prize'],
                'image' => $row['image'],
                'quantity' => 1
            );
        }

        echo count($_SESSION['cart']);
        exit;
    }
}

// Get cart count
$cartCount = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            flex: 1 1 20%;
            max-width: 20%;
            padding: 10px;
            box-sizing: border-box;
        }
        @media (max-width: 768px) {
            .col-md-4 {
                flex: 1 1 33.33%;
                max-width: 33.33%;
            }
        }
        @media (max-width: 576px) {
            .col-md-4 {
                flex: 1 1 50%;
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
        /* New styles for full details modal */
        .dog-details-modal .modal-dialog {
            width: 80%;
            max-width: 900px;
        }
        .dog-details-modal .modal-body {
            padding: 20px;
        }
        .dog-details-modal img {
            max-width: 100%;
            height: auto;
            margin-bottom: 20px;
        }
        .dog-details-modal h3 {
            margin-top: 0;
            color: #333;
        }
        .dog-details-modal .details-section {
            margin-bottom: 20px;
        }

        /* New Floating Cart Styles */
        .floating-cart {
            position: fixed;
            bottom: 20px;
            left: 20px;
            background-color: #2c3e50;
            color: white;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            cursor: pointer;
            z-index: 1000;
            text-decoration: none;
        }

        .floating-cart:hover {
            background-color: #34495e;
            transform: scale(1.05);
            transition: all 0.2s ease;
            color: white;
            text-decoration: none;
        }

        .cart-icon {
            font-size: 24px;
            position: relative;
        }

        .cart-count {
            position: absolute;
            top: -10px;
            right: -10px;
            background-color: #e74c3c;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 12px;
            font-weight: bold;
        }

        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }

        .toast {
            background-color: rgba(40, 167, 69, 0.9);
            color: white;
            padding: 15px 25px;
            border-radius: 5px;
            margin-bottom: 10px;
            opacity: 0;
            transition: opacity 0.3s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .toast.show {
            opacity: 1;
        }
    </style>
</head>
<body>

<!-- Floating Cart Icon -->
<a href="cart.php" class="floating-cart">
    <div class="cart-icon">
        <i class="glyphicon glyphicon-shopping-cart"></i>
        <span class="cart-count"><?php echo $cartCount; ?></span>
    </div>
</a>

<!-- Toast Notifications Container -->
<div class="toast-container"></div>

<div class="container">
    <div class="row">
        <?php
        $sql = "SELECT * FROM tblcnp WHERE voided = 0 ORDER BY id ASC";
        $result = mysqli_query($con, $sql) or die(mysqli_error($con));

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $id = $row['id'];
                ?>
                <div class="col-md-4 col-sm-6">
                    <div class="card" style="margin-bottom: 20px;">
                        <!-- Changed to open modal instead of navigating to a different page -->
                        <a href="#" data-toggle="modal" data-target="#dogDetailsModal<?php echo $id; ?>">
                            <img src="<?php echo $row['image']; ?>" class="card-img-top img-responsive img-rounded" alt="<?php echo $row['name']; ?>" style="width: 100%; height: auto;">
                        </a>

                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row['name']; ?></h5>
                            <p class="card-text"><?php echo $row['sex']; ?></p>
                            <p class="card-text"><strong>KSH:</strong> <?php echo $row['prize']; ?></p>
                            <div class="btn-group btn-group-justified" style="margin-bottom: 10px;">
                                <div class="btn-group">
                                    <!-- Modified to use AJAX to add to cart -->
                                    <button class="btn btn-success add-to-cart-btn" data-id="<?php echo $id; ?>">
                                        <i class="glyphicon glyphicon-shopping-cart"></i> Add to Cart
                                    </button>
                                </div>
                                <div class="btn-group">
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#buyNowModal<?php echo $id; ?>">
                                        <i class="glyphicon glyphicon-flash"></i> Buy Now
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dog Details Modal -->
                <div class="modal fade dog-details-modal" id="dogDetailsModal<?php echo $id; ?>" tabindex="-1" role="dialog" aria-labelledby="dogDetailsModalLabel<?php echo $id; ?>">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                <h4 class="modal-title" id="dogDetailsModalLabel<?php echo $id; ?>"><?php echo $row['name']; ?></h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <img src="<?php echo $row['image']; ?>" class="img-responsive img-rounded" alt="<?php echo $row['name']; ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <div class="details-section">
                                            <h3><?php echo $row['name']; ?></h3>
                                            <p><strong>Sex:</strong> <?php echo $row['sex']; ?></p>
                                            <p><strong>Sire:</strong> <?php echo $row['sire']; ?></p>
                                            <p><strong>Bitch:</strong> <?php echo $row['bitch']; ?></p>
                                            <p><strong>Status:</strong> <?php echo $row['status']; ?></p>
                                            <p><strong>Date of Birth:</strong> <?php echo $row['dob']; ?></p>
                                            <p><strong>Price:</strong> KSH <?php echo $row['prize']; ?></p>
                                        </div>
                                        <div class="details-section">
                                            <h4>Description</h4>
                                            <p><?php echo $row['description']; ?></p>
                                        </div>
                                        <div class="btn-group btn-group-justified">
                                            <div class="btn-group">
                                                <button class="btn btn-success btn-lg add-to-cart-btn" data-id="<?php echo $id; ?>" data-dismiss="modal">
                                                    <i class="glyphicon glyphicon-shopping-cart"></i> Add to Cart
                                                </button>
                                            </div>
                                            <div class="btn-group">
                                                <button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#buyNowModal<?php echo $id; ?>" data-dismiss="modal">
                                                    <i class="glyphicon glyphicon-flash"></i> Buy Now
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Buy Now Modal -->
                <div class="modal fade" id="buyNowModal<?php echo $id; ?>" tabindex="-1" role="dialog" aria-labelledby="buyNowModalLabel<?php echo $id; ?>">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                <h4 class="modal-title"><i class="glyphicon glyphicon-flash"></i> Quick Checkout - <?php echo $row['name']; ?></h4>
                            </div>
                            <form class="form-horizontal" method="post" action="">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <img src="<?php echo $row['image']; ?>" class="img-responsive img-rounded" alt="<?php echo $row['name']; ?>">
                                        </div>
                                        <div class="col-sm-8">
                                            <h4><?php echo $row['name']; ?> - KSH <?php echo $row['prize']; ?></h4>
                                            <hr>
                                            <p>Fields with (*) are required</p>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Name*</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="name" required>
                                                    <input type="hidden" name="foodid" value="<?php echo $id; ?>">
                                                    <input type="hidden" name="buyNow" value="1">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Address*</label>
                                                <div class="col-sm-9">
                                                    <textarea class="form-control" name="address" required></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Contact*</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="contact" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Quantity*</label>
                                                <div class="col-sm-9">
                                                    <input type="number" class="form-control" name="oqty" value="1" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Order Type*</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control" name="otype" required>
                                                        <option value="">Select</option>
                                                        <option value="Deliver">Deliver</option>
                                                        <option value="Pick-up">Pick-up</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group buyNowDatepickup" style="display: none;">
                                                <label class="col-sm-3 control-label">Date Pick-up*</label>
                                                <div class="col-sm-9">
                                                    <input type="date" class="form-control" name="datep">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary btn-lg" name="savechanges"><i class="glyphicon glyphicon-shopping-cart"></i> Purchase Now</button>
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
    $buyNow = isset($_POST['buyNow']) ? $_POST['buyNow'] : 0;

    $sql = "SELECT * FROM tblorders WHERE cname = '$name'";
    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) == 5) {
        echo '<script>alert("You have reached the maximum order limit of 5.");
                    window.location.href="availableframe.php";</script>';
    } else {
        $sql = "INSERT INTO tblorders VALUES(NULL, '$name', '$address', '$contact', '$id', '$qty', 'new', CURRENT_TIMESTAMP, '$otype', '$datep')";
        $result = mysqli_query($con, $sql);

        if ($result) {
            if ($buyNow == 1) {
                echo '<script>alert("Your purchase is complete! We will contact you shortly with delivery/pickup details.");
                          window.location.href="availableframe.php";</script>';
            } else {
                echo '<script>alert("Your order has been placed successfully. We will contact you shortly.");
                          window.location.href="availableframe.php";</script>';
            }
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
        // Order type change for datepicker
        $("select[name='otype']").change(function() {
            if ($(this).val() === "Pick-up") {
                $("#datepickup").show(200);
            } else {
                $("#datepickup").hide();
            }
        });

        // Fix multiple datepickup containers with same ID
        $("select[name='otype']").each(function() {
            var $select = $(this);
            var $datepickup = $select.closest('.modal-body').find('.form-group#datepickup');
            var $buyNowDatepickup = $select.closest('.modal-body').find('.form-group.buyNowDatepickup');

            $select.change(function() {
                if ($(this).val() === "Pick-up") {
                    $datepickup.show(200);
                    $buyNowDatepickup.show(200);
                } else {
                    $datepickup.hide();
                    $buyNowDatepickup.hide();
                }
            });
        });

        // Add to Cart functionality via AJAX
        $(".add-to-cart-btn").click(function() {
            var productId = $(this).data('id');

            $.ajax({
                url: window.location.href,
                type: 'POST',
                data: {
                    action: 'addToCart',
                    productId: productId
                },
                success: function(response) {
                    // Update cart count
                    $(".cart-count").text(response);

                    // Show toast notification
                    showToast("Item added to cart!");
                }
            });
        });

        // Function to show toast notifications
        function showToast(message) {
            var toast = $('<div class="toast">' + message + '</div>');
            $(".toast-container").append(toast);

            setTimeout(function() {
                toast.addClass('show');
            }, 100);

            setTimeout(function() {
                toast.removeClass('show');
                setTimeout(function() {
                    toast.remove();
                }, 300);
            }, 3000);
        }
    });
</script>
</body>
</html>