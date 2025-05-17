<?php
session_start();
include('includes/dbconn.php');

// Initialize cart if not exists
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Get cart items
$cartItems = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
$cartCount = count($cartItems);
$totalAmount = 0;

// Process remove item
if(isset($_GET['remove'])) {
    $removeId = $_GET['remove'];

    foreach($_SESSION['cart'] as $key => $item) {
        if($item['id'] == $removeId) {
            unset($_SESSION['cart'][$key]);
            $_SESSION['cart'] = array_values($_SESSION['cart']); // Reindex array
            break;
        }
    }

    header('Location: cart.php');
    exit;
}

// Process AJAX quantity update
if(isset($_POST['update_quantity'])) {
    $id = $_POST['id'];
    $quantity = (int)$_POST['quantity'];
    $response = array('success' => false);

    if($quantity > 0) {
        foreach($_SESSION['cart'] as $key => $item) {
            if($item['id'] == $id) {
                $_SESSION['cart'][$key]['quantity'] = $quantity;
                $response['success'] = true;
                $response['newTotal'] = number_format($_SESSION['cart'][$key]['price'] * $quantity, 2);

                // Calculate new cart total
                $newTotalAmount = 0;
                foreach($_SESSION['cart'] as $cartItem) {
                    $newTotalAmount += $cartItem['price'] * $cartItem['quantity'];
                }
                $response['cartTotal'] = number_format($newTotalAmount, 2);
                $response['itemCount'] = count($_SESSION['cart']);
                break;
            }
        }
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// Process update cart (legacy support)
if(isset($_POST['update_cart'])) {
    foreach($_POST['quantity'] as $id => $quantity) {
        if($quantity > 0) {
            foreach($_SESSION['cart'] as $key => $item) {
                if($item['id'] == $id) {
                    $_SESSION['cart'][$key]['quantity'] = $quantity;
                    break;
                }
            }
        }
    }

    header('Location: cart.php');
    exit;
}

// Process checkout form submission
if(isset($_POST['place_order'])) {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];
    $orderType = $_POST['order_type'];
    $datePickup = isset($_POST['date_pickup']) ? $_POST['date_pickup'] : '';

    // Validate input
    $errors = array();

    if(empty($name)) {
        $errors[] = "Name is required";
    }

    if(empty($address)) {
        $errors[] = "Address is required";
    }

    if(empty($contact)) {
        $errors[] = "Contact number is required";
    }

    if(empty($orderType)) {
        $errors[] = "Order type is required";
    }

    if($orderType == "Pick-up" && empty($datePickup)) {
        $errors[] = "Pickup date is required for pickup orders";
    }

    // If no errors, process the order
    if(empty($errors)) {
        $orderSuccess = true;

        // Check if user has reached order limit
        $sql = "SELECT * FROM tblorders WHERE cname = '$name'";
        $result = mysqli_query($con, $sql);

        if(mysqli_num_rows($result) >= 5) {
            $errors[] = "You have reached the maximum order limit of 5.";
            $orderSuccess = false;
        } else {
            // Process each cart item as an order
            foreach($cartItems as $item) {
                $productId = $item['id'];
                $quantity = $item['quantity'];

                $sql = "INSERT INTO tblorders VALUES(NULL, '$name', '$address', '$contact', '$productId', '$quantity', 'new', CURRENT_TIMESTAMP, '$orderType', '$datePickup')";
                $result = mysqli_query($con, $sql);

                if(!$result) {
                    $orderSuccess = false;
                    $errors[] = "Error processing order for item: " . $item['name'];
                    break;
                }
            }

            // If all orders processed successfully, clear cart and redirect
            if($orderSuccess) {
                $_SESSION['cart'] = array();
                $_SESSION['order_success'] = true;
                header('Location: cart.php');
                exit;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="images/foods/logo.png" rel="shortcut icon">
    <title>Your Cart - Earmark GSD Kennel</title>

    <!-- Core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animate.min.css" rel="stylesheet">
    <link href="css/prettyPhoto.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <link href="css/responsive.css" rel="stylesheet">

    <style>
        .cart-container {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .cart-header {
            margin-bottom: 30px;
            border-bottom: 2px solid #eee;
            padding-bottom: 10px;
        }

        .cart-item {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }

        .cart-item-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 5px;
            margin-right: 20px;
        }

        .cart-item-details {
            flex-grow: 1;
        }

        .cart-item-price {
            width: 120px;
            text-align: right;
        }

        .cart-item-quantity {
            width: 120px;
            text-align: center;
        }

        .cart-item-total {
            width: 120px;
            text-align: right;
            font-weight: bold;
        }

        .cart-item-actions {
            width: 100px;
            text-align: center;
        }

        .cart-summary {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
            margin-top: 30px;
        }

        .quantity-input {
            width: 60px;
            text-align: center;
        }

        .empty-cart {
            text-align: center;
            padding: 50px 0;
        }

        .empty-cart i {
            font-size: 60px;
            color: #ddd;
            margin-bottom: 20px;
        }

        .continue-shopping {
            margin-top: 20px;
        }

        .alert {
            margin-top: 20px;
        }

        .checkout-form .form-group {
            margin-bottom: 15px;
        }

        .checkout-form label {
            font-weight: bold;
        }

        #date-pickup-row {
            display: none;
        }

        .quantity-container {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .quantity-btn {
            background-color: #f0f0f0;
            border: 1px solid #ddd;
            width: 30px;
            height: 30px;
            font-size: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            user-select: none;
        }

        .quantity-btn:hover {
            background-color: #e0e0e0;
        }

        .quantity-input {
            width: 50px;
            text-align: center;
            margin: 0 5px;
            border: 1px solid #ddd;
            padding: 4px;
            height: 30px;
        }

        .updating-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            visibility: hidden;
            opacity: 0;
            transition: visibility 0s, opacity 0.3s;
        }

        .updating-overlay.show {
            visibility: visible;
            opacity: 1;
        }

        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
<div class="updating-overlay" id="updating-overlay">
    <div class="spinner"></div>
</div>

<div class="cart-container">
    <div class="cart-header">
        <div class="row">
            <div class="col-md-6">
                <h2><i class="glyphicon glyphicon-shopping-cart"></i> Your Cart</h2>
            </div>
            <div class="col-md-6 text-right">
                <a href="availableframe.php" class="btn btn-default">
                    <i class="glyphicon glyphicon-chevron-left"></i> Continue Shopping
                </a>
            </div>
        </div>
    </div>

    <?php if(isset($_SESSION['order_success'])): ?>
        <div class="alert alert-success" role="alert">
            <strong>Success!</strong> Your order has been placed successfully. We will contact you shortly with delivery/pickup details.
        </div>
        <?php unset($_SESSION['order_success']); ?>
    <?php endif; ?>

    <?php if(!empty($errors)): ?>
        <div class="alert alert-danger" role="alert">
            <strong>Error!</strong>
            <ul>
                <?php foreach($errors as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if(empty($cartItems)): ?>
        <div class="empty-cart">
            <i class="glyphicon glyphicon-shopping-cart"></i>
            <h3>Your cart is empty</h3>
            <p>Looks like you haven't added any items to your cart yet.</p>
            <div class="continue-shopping">
                <a href="availableframe.php" class="btn btn-primary">Continue Shopping</a>
            </div>
        </div>
    <?php else: ?>
        <form method="post" action="" id="cart-form">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Product</th>
                        <th class="text-center">Price</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-right">Subtotal</th>
                        <th class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($cartItems as $item):
                        $itemTotal = $item['price'] * $item['quantity'];
                        $totalAmount += $itemTotal;
                        ?>
                        <tr class="cart-item-row" data-item-id="<?php echo $item['id']; ?>" data-price="<?php echo $item['price']; ?>">
                            <td>
                                <div class="media">
                                    <a class="thumbnail pull-left" href="#">
                                        <img class="media-object cart-item-image" src="<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>">
                                    </a>
                                    <div class="media-body">
                                        <h4 class="media-heading"><?php echo $item['name']; ?></h4>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <strong>KSH <?php echo number_format($item['price'], 2); ?></strong>
                            </td>
                            <td class="text-center">
                                <div class="quantity-container">
                                    <div class="quantity-btn decrease-btn">-</div>
                                    <input type="number" name="quantity[<?php echo $item['id']; ?>]" class="form-control quantity-input" value="<?php echo $item['quantity']; ?>" min="1" data-item-id="<?php echo $item['id']; ?>">
                                    <div class="quantity-btn increase-btn">+</div>
                                </div>
                            </td>
                            <td class="text-right">
                                <strong class="item-total">KSH <?php echo number_format($itemTotal, 2); ?></strong>
                            </td>
                            <td class="text-center">
                                <a href="cart.php?remove=<?php echo $item['id']; ?>" class="btn btn-danger btn-sm remove-item">
                                    <i class="glyphicon glyphicon-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="glyphicon glyphicon-user"></i> Customer Information</h3>
                        </div>
                        <div class="panel-body checkout-form">
                            <p>Fields with (*) are required</p>
                            <div class="form-group">
                                <label for="name">Name*</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="address">Address*</label>
                                <textarea class="form-control" id="address" name="address" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="contact">Contact*</label>
                                <input type="text" class="form-control" id="contact" name="contact" required>
                            </div>
                            <div class="form-group">
                                <label for="order_type">Order Type*</label>
                                <select class="form-control" id="order_type" name="order_type" required>
                                    <option value="">Select</option>
                                    <option value="Deliver">Deliver</option>
                                    <option value="Pick-up">Pick-up</option>
                                </select>
                            </div>
                            <div class="form-group" id="date-pickup-row">
                                <label for="date_pickup">Date Pick-up*</label>
                                <input type="date" class="form-control" id="date_pickup" name="date_pickup">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="cart-summary">
                        <h4>Cart Summary</h4>
                        <hr>
                        <div class="row">
                            <div class="col-xs-6">
                                <strong>Items:</strong>
                            </div>
                            <div class="col-xs-6 text-right">
                                <strong id="cart-count"><?php echo $cartCount; ?></strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <strong>Subtotal:</strong>
                            </div>
                            <div class="col-xs-6 text-right">
                                <strong id="subtotal-amount">KSH <?php echo number_format($totalAmount, 2); ?></strong>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-xs-6">
                                <strong>Total:</strong>
                            </div>
                            <div class="col-xs-6 text-right">
                                <strong id="total-amount">KSH <?php echo number_format($totalAmount, 2); ?></strong>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" name="place_order" class="btn btn-primary btn-block">
                                    <i class="glyphicon glyphicon-shopping-cart"></i> Place Order
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    <?php endif; ?>
</div>

<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        // Show/hide date pickup field based on order type selection
        $('#order_type').change(function() {
            if ($(this).val() === 'Pick-up') {
                $('#date-pickup-row').show();
                $('#date_pickup').prop('required', true);
            } else {
                $('#date-pickup-row').hide();
                $('#date_pickup').prop('required', false);
            }
        });

        // Handle quantity change
        function updateQuantity(inputElement, newQuantity) {
            const itemId = inputElement.data('item-id');
            const row = inputElement.closest('.cart-item-row');

            // Don't allow quantities less than 1
            if (newQuantity < 1) {
                newQuantity = 1;
            }

            // Update input value
            inputElement.val(newQuantity);

            // Show loading overlay
            $('#updating-overlay').addClass('show');

            // Send AJAX request to update quantity
            $.ajax({
                url: 'cart.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    update_quantity: true,
                    id: itemId,
                    quantity: newQuantity
                },
                success: function(response) {
                    if (response.success) {
                        // Update item total
                        row.find('.item-total').text('KSH ' + response.newTotal);

                        // Update cart totals
                        $('#subtotal-amount').text('KSH ' + response.cartTotal);
                        $('#total-amount').text('KSH ' + response.cartTotal);
                        $('#cart-count').text(response.itemCount);
                    }

                    // Hide loading overlay with a small delay for better UX
                    setTimeout(function() {
                        $('#updating-overlay').removeClass('show');
                    }, 300);
                },
                error: function() {
                    alert('Error updating cart. Please try again.');
                    $('#updating-overlay').removeClass('show');
                }
            });
        }

        // Handle decrease quantity button
        $('.decrease-btn').click(function() {
            const input = $(this).siblings('.quantity-input');
            const currentValue = parseInt(input.val());
            updateQuantity(input, currentValue - 1);
        });

        // Handle increase quantity button
        $('.increase-btn').click(function() {
            const input = $(this).siblings('.quantity-input');
            const currentValue = parseInt(input.val());
            updateQuantity(input, currentValue + 1);
        });

        // Handle direct input changes
        $('.quantity-input').change(function() {
            updateQuantity($(this), parseInt($(this).val()));
        });

        // Prevent form submission when pressing Enter in quantity fields
        $('.quantity-input').keydown(function(event) {
            if (event.keyCode === 13) {
                event.preventDefault();
                $(this).blur();
                return false;
            }
        });

        // Confirm before removing item
        $('.remove-item').click(function(e) {
            if (!confirm('Are you sure you want to remove this item from your cart?')) {
                e.preventDefault();
            }
        });
    });
</script>
</body>
</html>