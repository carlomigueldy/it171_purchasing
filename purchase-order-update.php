<?php
require_once "session.php";
?>

<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$supplier_id = $order_term = $staff_id = $order_status = "";
$supplier_id_err = $order_term_err = $staff_id_err = $order_status_err = "";

// Processing form data when form is submitted
if(isset($_POST["order_id"]) && !empty($_POST["order_id"])){
    // Get hidden input value
    $order_id = $_POST["order_id"];

    // Validate name
    $input_supplier_id = trim($_POST["supplier_id"]);
    if(empty($input_supplier_id)){
        $supplier_id_err = "Please enter a supplier ID.";
    } elseif(!ctype_digit($input_supplier_id)){
        $supplier_id_err = "Please enter a valid ID.";
    }  else{
        $supplier_id = $input_supplier_id;
    }

    // Validate address address
    $input_order_term = trim($_POST["order_term"]);
    if(empty($input_order_term)){
        $order_term_err = "Please enter a term. (e.g. 30 days, 60 days, 90 days)";
    } else{
        $order_term = $input_order_term;
    }

    // Validate salary
    $input_staff_id = trim($_POST["staff_id"]);
    if(empty($input_staff_id)){
        $staff_id_err = "Please enter the staff ID.";
    } elseif(!ctype_digit($input_staff_id)){
        $staff_id_err = "Please enter a valid ID.";
    } else{
        $staff_id = $input_staff_id;
    }

    // Validate salary
    $input_order_status = trim($_POST["order_status"]);
    if(empty($input_order_status)){
        $order_status_err = "Please enter a status. (Approved/Unapproved)";
    } else{
        $order_status = $input_order_status;
    }

    // Check input errors before inserting in database
    if(empty($supplier_id_err) && empty($order_term_err) && empty($staff_id_err) && empty($order_status_err)){
        // Prepare an update statement
        $sql = "UPDATE purchase_order SET supplier_id=?, order_term=?, staff_id=?, order_status=? WHERE order_id=?";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "isisi", $param_supplier_id, $param_order_term, $param_staff_id, $param_order_status, $param_order_id);

            // Set parameters
            $param_supplier_id = $supplier_id;
            $param_order_term = $order_term;
            $param_staff_id = $staff_id;
            $param_order_status= $order_status;
            $param_order_id = $order_id;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: purchase-orders.php");
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
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["order_id"]) && !empty(trim($_GET["order_id"]))){
        // Get URL parameter
        $order_id =  trim($_GET["order_id"]);

        // Prepare a select statement
        $sql = "SELECT * FROM purchase_order WHERE order_id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_order_id);

            // Set parameters
            $param_order_id = $order_id;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);

                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                    // Retrieve individual field value
                    $supplier_id = $row["supplier_id"];
                    $order_term = $row["order_term"];
                    $staff_id = $row["staff_id"];
                    $order_status = $row["order_status"];
                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }

            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);

        // Close connection
        // mysqli_close($link);
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Purchase Order</title>
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
                        <br><h2>Update a Purchase Order</h2>
                    </div>
                    <p>Please edit the input values and submit to update the record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group <?php echo (!empty($order_id_err)) ? 'has-error' : ''; ?>">
                            <label>Order ID</label>
                            <input type="text" name="order_id" class="form-control" value="ID <?php echo $order_id; ?>" readonly>
                        </div>
                        <div class="form-group <?php echo (!empty($supplier_id_err)) ? 'has-error' : ''; ?>">
                            <label>Supplier</label>
                            <select type="text" name="supplier_id" class="custom-select" value="<?php echo $supplier_id; ?>" required>
                                <optgroup label="Current Supplier">
                                    <?php $sql5 = "SELECT * FROM suppliers WHERE supplier_id = $supplier_id"; 
                                            if($result5 = mysqli_query($link,$sql5)){
                                                if(mysqli_num_rows($result5) > 0){
                                                    $row5 = mysqli_fetch_array($result5);
                                                }
                                            }
                                    ?>
                                    <option value="<?php echo $supplier_id; ?>"><?php echo $row5['fname'] . " " . $row5['lname']; ?></option>
                                </optgroup>
                                <optgroup label="Suppliers">
                                    <?php 
                                        $sql4 = "SELECT * FROM suppliers";
                                        if($result4 = mysqli_query($link, $sql4)){
                                        if(mysqli_num_rows($result4) > 0){
                                            while($row4 = mysqli_fetch_array($result4)){
                                            echo $data4 = $row4['supplier_id'];
                                            echo "<option value='$data4'>" . $row4['fname'] . " " . $row4['lname'] . "</option>";
                                            }
                                        }
                                        }
                                    ?>
                                </optgroup>  
                            </select>
                        </div>
                        <div class="form-group <?php echo (!empty($order_term_err)) ? 'has-error' : ''; ?>">
                            <label>Term</label>
                            <select type="text" name="order_term" class="custom-select" value="<?php echo $order_term; ?>" required>
                                <optgroup label="Current Term">
                                    <option><?php echo $order_term; ?></option>
                                </optgroup>
                                <optgroup label="Term">
                                    <option>30 days</option>
                                    <option>60 days</option>
                                    <option>90 days</option>
                                    <option>120 days</option>
                                </optgroup>    
                            </select>
                        </div>
                        <div class="form-group <?php echo (!empty($staff_id_err)) ? 'has-error' : ''; ?>">
                            <label>Staff</label>
                            <select type="text" name="staff_id" class="custom-select" value="<?php echo $staff_id; ?>" required>
                                <optgroup label="Current Staff">  
                                    <?php $sql6 = "SELECT * FROM staff WHERE staff_id = $staff_id"; 
                                            if($result6 = mysqli_query($link,$sql6)){
                                                if(mysqli_num_rows($result6) > 0){
                                                    $row6 = mysqli_fetch_array($result6);
                                                }
                                            }
                                    ?>
                                    <option value="<?php echo $staff_id; ?>"><?php echo $row6['fname'] . " " . $row6['lname']; ?></option>
                                </optgroup>
                                <optgroup label="Staff"> 
                                    <?php 
                                        $sql3 = "SELECT * FROM staff";
                                        if($result3 = mysqli_query($link, $sql3)){
                                        if(mysqli_num_rows($result3) > 0){
                                            while($row3 = mysqli_fetch_array($result3)){
                                            echo $data3 = $row3['staff_id'];
                                            echo "<option value='$data3'>" . $row3['fname'] . " " . $row3['lname'] . "</option>";
                                            }
                                        }
                                        }
                                    ?>
                                </optgroup>
                              </select>
                        </div>
                        <div class="form-group <?php echo (!empty($order_status_err)) ? 'has-error' : ''; ?>">
                            <label>Status</label>
                            <select type="text" name="order_status" class="custom-select" value="<?php echo $order_status; ?>" required>
                                <optgroup label="Current Status">
                                    <option><?php echo $order_status; ?></option>
                                </optgroup>
                                <optgroup label="Status">
                                    <option>Approved</option>
                                    <option>Unapproved</option>
                                </optgroup>
                            </select>
                        </div>

                        <!-- Form Submission -->
                        <input type="hidden" name="order_id" value="<?php echo $order_id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="purchase-orders.php" class="btn btn-danger">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php mysqli_close($link); ?>
    <br><br>
    <!-- End of Content -->

    <!-- JavaScript Frameworks -->
    <script src="jquery/jquery-3.3.1.slim.min.js"></script>
    <script src="jquery/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- JavaScript Frameworks -->    
</body>
</html>
