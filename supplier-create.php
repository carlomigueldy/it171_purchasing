<?php
// Include config file
require_once "config.php";
require_once "session.php";

// Define variables and initialize with empty values
$fname = $lname = $email = $contact_number = "";
$fname_err = $lname_err = $email_err = $contact_number_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate first name
    $input_fname = trim($_POST["fname"]);
    if(empty($input_fname)){
        $fname_err = "Please enter a first name.";
    } elseif(!filter_var($input_fname, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
       $fname_err = "Please enter a valid ID.";
    } else{
        $fname = $input_fname;
    }

    // Validate order term
    $input_lname = trim($_POST["lname"]);
    if(empty($input_lname)){
        $lname_err = "Please enter a last name.";
    } else{
        $lname = $input_lname;
    }

    // Validate employee ID
    $input_email = trim($_POST["email"]);
    if(empty($input_email)){
        $email_err = "Please enter an e-mail address.";
    } else{
        $email = $input_email;
    }

    // Validate contact number
    $input_contact_number = trim($_POST["contact_number"]);
    if(empty($input_contact_number)){
        $contact_number_err = "Please enter a contact number.";
    } else{
        $contact_number = $input_contact_number;
    }

    // Check input errors before inserting in database
    if(empty($fname_err) && empty($lname_err) && empty($email_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO suppliers (fname, lname, email, contact_number) VALUES (?, ?, ?, ?)";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssss", $param_fname, $param_lname, $param_email, $param_contact_number);

            // Set parameters
            $param_fname = $fname;
            $param_lname = $lname;
            $param_email = $email;
            $param_contact_number = $contact_number;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: suppliers.php");
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
    <title>Add Supplier</title>
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
            <li class="nav-item">
              <a class="nav-link" href="welcome.php">Home </a>
            </li>
            <li class="nav-item ">
              <a class="nav-link" href="warehouse-purchase-request.php">Purchase Requests</a>
            </li>
            <li class="nav-item ">
                <a class="nav-link" href="product.php">Product</a>
            </li>
            <li class="nav-item dropdown ">
            <a class="nav-link dropdown-toggle" href="purchase-orders.php" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Purchase Orders
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
              <a class="dropdown-item" href="purchase-orders.php">List of Purchase Orders</a>
              <!-- <a class="dropdown-item" href="purchase-order-create.php">Add a Purchase Order</a> -->
            </div>
            </li>
            <li class="nav-item dropdown active">
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

  <br>

  <!-- Content -->
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Add a Supplier</h2>
                    </div>
                    <p>Please fill this form and submit to add a supplier record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($fname_err)) ? 'has-error' : ''; ?>">
                            <label>First Name</label>
                            <input type="text" name="fname" class="form-control" value="<?php echo $fname; ?>" required>
                            <span class="is-invalid"><?php echo $fname_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($lname_err)) ? 'has-error' : ''; ?>" required> 
                            <label>Last Name</label>
                            <input name="lname" class="form-control"><?php echo $lname; ?>
                            <span class="help-block"><?php echo $lname_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                            <label>E-mail Address</label>
                            <input type="email" name="email" class="form-control" value="<?php echo $email; ?>" required>
                            <span class="help-block"><?php echo $email_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($contact_number_err)) ? 'has-error' : ''; ?>" required>
                            <label>Contact Number</label>
                            <input type="text" name="contact_number" class="form-control" value="<?php echo $contact_number; ?>">
                            <span class="help-block"><?php echo $contact_number_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="suppliers.php" class="btn btn-danger">Cancel</a>
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
