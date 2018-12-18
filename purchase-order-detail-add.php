<?php
// Include config file
require_once "config.php";
require_once "session.php";

// Define variables and initialize with empty values
$order_id = $product_id = $qty_order = $quoted_price = "";
$order_id_err = $product_id_err = $qty_order_err = $quoted_price_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate first name
    $input_order_id = trim($_POST["order_id"]);
    if(empty($input_order_id)){
        $order_id_err = "Please enter an order ID.";
    } else{
        $order_id = $input_order_id;
    }

    // Validate first name
    $input_product_id = trim($_POST["product_id"]);
    if(empty($input_product_id)){
        $product_id_err = "Please enter a product ID.";
    } else{
        $product_id = $input_product_id;
    }

    // Validate order qty_order
    $input_qty_order = trim($_POST["qty_order"]);
    if(empty($input_qty_order)){
        $qty_order_err = "Please enter a quantity.";
    } else{
        $qty_order = $input_qty_order;
    }

    // Validate contact number
    $input_quoted_price = trim($_POST["quoted_price"]);
    if(empty($input_quoted_price)){
        $quoted_price_err = "Please enter its quoted price.";
    } else{
        $quoted_price = $input_quoted_price;
    }

    // Check input errors before inserting in database
    if(empty($order_id_err) && empty($product_id_err) && empty($qty_order_err) && empty($quoted_price_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO purchase_order_details (order_id, product_id, qty_order, quoted_price) VALUES (?, ?, ?, ?)";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "iiid", $param_order_id, $param_product_id, $param_qty_order, $param_quoted_price);

            // Set parameters
            $param_order_id = $order_id;
            $param_product_id = $product_id;
            $param_qty_order = $qty_order;
            $param_quoted_price = $quoted_price;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: purchase-order-read.php?order_id=$order_id");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add an Item</title>
    <link rel="icon" href="img/rob.png" type="image/ico">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <link href="fontawesome-free-5.5.0-web/css/all.css" rel="stylesheet">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>

  <!-- Navigation Bar (Top) -->
      <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top" >
        <a class="navbar-brand" href="#">
          <img src="img/rob.png" width="30" height="30" class="d-inline-block align-top" alt="">
          Purchasing Department
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

      <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
          <li class="nav-item ">
            <a class="nav-link" href="welcome.php">Home </a>
          </li>
          <li class="nav-item dropdown">
            <li class="nav-item ">
              <a class="nav-link" href="warehouse-purchase-request.php">Purchase Requests</a>
            </li>
            <li class="nav-item dropdown">
              <li class="nav-item">
                <a class="nav-link" href="product.php">Product</a>
            </li>
            <li class="nav-item dropdown active">
            <a class="nav-link dropdown-toggle" href="purchase-orders.php" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Purchase Orders
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
              <a class="dropdown-item" href="purchase-orders.php">List of Purchase Orders</a>
              <!-- <a class="dropdown-item" href="purchase-order-create.php">Add a Purchase Order</a> -->
            </div>
          </li>
          <li class="nav-item dropdown ">
            <a class="nav-link dropdown-toggle" href="suppliers.php" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Suppliers <span class="sr-only">(current)</span>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" href="canvassing.php">Canvassing</a>
              <a class="dropdown-item" href="suppliers.php">List of Suppliers</a>
              <a class="dropdown-item" href="supplier-create.php">Add a Supplier</a>
            </div>
          </li>
          <li class="nav-item">
                <a class="nav-link" href="about.php">About</a>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto">
          <li class="nav-item ">
            <a class="nav-link" href="logout.php"><?php echo htmlspecialchars($_SESSION["username"]); ?> <i class="btn btn-sm fas fa-sign-out-alt" title="Sign out"></i></a>
          </li>
        </ul>
      </div>
      </nav>
  <!-- /Navigation Bar (Top) -->

  <!-- Content -->
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <br><h2>Add an Item Order</h2>
                    </div>
                    <p>Please fill this form and submit to add a supplier-product record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($order_id_err)) ? 'has-error' : ''; ?>">
                          <?php if(isset($_GET["order_id"]) && !empty(trim($_GET["order_id"]))){
                            $oid = $_GET["order_id"];
                          }
                          ?>
                            <!-- <label>Order ID</label> -->
                            <input type="hidden" name="order_id" class="form-control" value="<?php echo $order_id = $oid; ?>" readonly>
                            <span class="help-block"><?php echo $order_id_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($product_id_err)) ? 'has-error' : ''; ?>">
                            <label>Product</label>
                            <select type="text" name="product_id" class="custom-select" value="<?php echo $product_id; ?>" required>
                            <option></option>
                              <?php
                                $sql2 = "SELECT * FROM product";
                                if($result2 = mysqli_query($link, $sql2)){
                                  if(mysqli_num_rows($result2) > 0){
                                    while($row2 = mysqli_fetch_array($result2)){
                                      echo $data2 = $row2['product_id'];
                                      echo "<option value='$data2'>" . $row2['description'] . "</option>";
                                    }
                                  }
                                }
                              ?>
                            </select>
                            <span class="help-block"><?php echo $product_id_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($qty_order_err)) ? 'has-error' : ''; ?>" required>
                            <label>Quantity</label>
                            <input type="number" min="0" name="qty_order" class="form-control" required>
                            <span class="help-block"><?php echo $qty_order_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($quoted_price_err)) ? 'has-error' : ''; ?>">
                            <label>Price</label>
                            <input type="number" min="0" step="0.01" name="quoted_price" class="form-control" value="<?php echo $quoted_price; ?>" required>
                            <span class="help-block"><?php echo $quoted_price_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a class="btn btn-danger" href="purchase-order-read.php?order_id=<?php echo $_GET['order_id'];?>" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
  <!-- End of Content -->

    <!-- JavaScript Frameworks -->
    <script src="jquery/jquery-3.3.1.slim.min.js"></script>
    <script src="jquery/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- JavaScript Frameworks -->

</body>
</html>
