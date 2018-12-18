<?php require_once "session.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Purchase Order</title>
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
        <div class="container">
            <div class='page-header clearfix'>
                <br /><h1><i class="fas fa-cart-plus"></i> Creating a Purchase Order</h1>
            </div>
            <div class="row">
                <div class="col-md-5">
                <!-- Purchase Request -->
                <?php
                    if(isset($_GET["request_id"]) && !empty(trim($_GET["request_id"]))){
                        require_once "config.php";
                        $get_request_id = $_GET['request_id'];
                      echo "<div class='page-header clearfix'><br>";
                      echo "<h3 class='float-left'>Purchase Request (#" . $_GET['request_id'] . ")</h3>";
                      echo "<div class='btn-group float-right' role='group' aria-label='Basic example'>";
                      echo "<div class='btn-group float-right' role='group' aria-label='Basic example'>
                            </div>";
                        echo "</div>";
                        echo "</div>";
                        $sql_request = "SELECT pod.id AS 'id', pod.request_id AS 'request_id',p.product_id AS 'product_id', 
                        p.description AS 'description', pod.qty_requested AS 'qty_requested' 
                        FROM purchase_request_details pod 
                        INNER JOIN product p ON pod.product_id = p.product_id WHERE request_id = ?";
                        if($stmt_request = mysqli_prepare($link, $sql_request)){
                            mysqli_stmt_bind_param($stmt_request, "i", $param_request_id);
                            $param_request_id = trim($_GET["request_id"]);
                            if(mysqli_stmt_execute($stmt_request)){
                                $result_request = mysqli_stmt_get_result($stmt_request);
                                if(mysqli_num_rows($result_request) > 0){
                                echo "<div class='table-responsive' style='height:294px;'>";
                                  echo "<table class='table table-bordered table-sm'>";
                                      echo "<thead>";
                                          echo "<tr align='center'>";
                                              echo "<th><b>Product</b></th>";
                                              echo "<th><b>Quantity</b></th>";
                                          echo "</tr>";
                                      echo "</thead>";
                                      echo "<tbody>";
                                      
                                    while($row_request = mysqli_fetch_array($result_request, MYSQLI_ASSOC)){
                                      echo "<tr align='center'>";
                                        //   echo "<td><small>" . $row_request['product_id'] . "</small></td>";
                                          echo "<td align='left'><small>" . $row_request['description'] . "</small></td>";
                                          echo "<td><small>" . $row_request['qty_requested'] . "</small></td>";
                                      echo "</tr>";
                                    } $get_request_id = $row_request['request_id'];
                                    echo "</tbody>";
                                echo "</table>";
                              echo "</div>";
                                mysqli_free_result($result_request);
                                } else{
                                    // URL doesn't contain valid id parameter. Redirect to error page
                                    echo "No records found.";
                                    echo " " . "(Order ID: " . $_GET["request_id"] . ")";
                                    exit();
                                }

                            } else{
                                echo "ERROR: Could not able to execute $sql_request. " . mysqli_error($link);
                            }
                        }

                        mysqli_stmt_close($stmt_request);
                    } else{
                        // URL doesn't contain id parameter. Redirect to error page
                        header("location: error.php");
                        exit();
                    }
                    ?>
                    <!-- Purchase Request -->

                    <div class="card">
                        <div class="card-header">
                            <b>Guidelines on creating a Purchase Order:</b>
                        </div>
                        <div class="card-body">
                            <li>View the Purchase Request and canvass each item.</li> 
                            <li>Should find a cheaper price but good in quality.</li>
                            <li>Should find a good term, most preferrably 30 day term but 60 day term is fine, depending on situation.</li>
                            <li>User must be careful during the creation of a Purchase Order.</li>
                            <li>You can't always find a single supplier containing all the items requested from the Purchase Request.</li>
                            <li>If done, please click on the submit button below the form. And inform the superiors.</li> 
                        </div>
                    </div>

                    </div>
                <div class="col-md-7">
                    <div class="page-header">
                        <br />
                        <h2>Purchase Order</h2>
                    </div>
                    <!-- <p>Please fill this form and submit to add purchase order record to the database.</p> -->
                    <form action="purchase-order-inserting.php" method="post">
                                <div class="card">
                                    <div class="card-header">
                                        <b>Information</b>
                                    </div>
                                    <div class="card-body">
                                    <div class="form-group row"><br />
                                        <label class="col-sm-4 col-form-label">Supplier</label>
                                        <input type="hidden" name="request_id" value="<?php echo $_GET['request_id'];?>">
                                        <select name="supplier_id" class="custom-select col-sm-7 custom-select-sm" title="Please select a supplier in the list." required>
                                            <option></option>
                                            <?php
                                                $sql_suppliers = "SELECT * FROM suppliers";
                                                if($result_suppliers = mysqli_query($link, $sql_suppliers)){
                                                if(mysqli_num_rows($result_suppliers) > 0){
                                                    while($row_suppliers = mysqli_fetch_array($result_suppliers)){
                                                    echo $get_supplier_id = $row_suppliers['supplier_id'];
                                                    echo "<option value='$get_supplier_id'>" . $row_suppliers['fname'] . " " . $row_suppliers['lname'] . "</option>";
                                                    }
                                                }
                                                }
                                            ?>
                                        </select>
                                    </div> 
                                    <div class="form-group row"><br />  
                                        <label class="col-sm-4 col-form-label">Term</label>
                                        <select name="order_term" class="custom-select col-sm-7 custom-select-sm" title="Please select a term in the list." required>
                                            <option></option>
                                            <option>30 days</option>
                                            <option>60 days</option>
                                            <option>90 days</option>
                                            <option>120 days</option>
                                        </select>
                                    </div>
                                    <div class="form-group row"><br />      
                                        <label class="col-sm-4 col-form-label">Prepared By</label>
                                        <select type="text" name="staff_id" class="custom-select col-sm-7 custom-select-sm" title="Please select your name." required>
                                            <option></option>
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
                                        </select>
                                    </div>
                                </div>    
                            </div>   
                                            
                            <br />
                            <div class="card">
                                <div class="card-header">
                                    <b>Order Details</b>
                                </div>
                                <div class="card-body">
                                <div class="form-row align-items-center"> 
                                    <label class="col-sm-2 col-form-label">Item 1</label>
                                    <div class="col-sm-6">
                                    <?php
                                            $get_request_id = $_GET['request_id'];
                                            $sql_product_1 = "SELECT prd.product_id AS 'product_id', p.description AS 'description'
                                            FROM purchase_request_details prd 
                                            INNER JOIN product p ON prd.product_id = p.product_id
                                            WHERE prd.request_id = $get_request_id
                                            LIMIT 0, 1";
                                            $result_product_1 = mysqli_query($link, $sql_product_1);
                                            $row_product_1 = mysqli_fetch_assoc($result_product_1);
                                            echo "<input type='hidden' name='product_id_1' value='" . $row_product_1['product_id'] . "' >";   
                                            echo "<input type='text' placeholder='" . $row_product_1['description'] . "' class='form-control form-control-sm' readonly>";    
                                    ?>
                                    </div>
                                    <div class="col-sm-2">
                                        <input placeholder="Quantity" type="number" min="0" class="form-control form-control-sm" name="qty_order_1">
                                    </div>
                                    <div class="col-sm-2">
                                        <input placeholder="Price" step="0.01" type="number" min="0" class="form-control form-control-sm" name="quoted_price_1">
                                    </div>
                                </div>
                                <div class="form-row align-items-center"><br />  
                                    <label class="col-sm-2 col-form-label">Item 2</label>
                                    <div class="col-sm-6">
                                    <?php
                                            $sql_product_2 = "SELECT prd.product_id AS 'product_id', p.description AS 'description'
                                            FROM purchase_request_details prd 
                                            INNER JOIN product p ON prd.product_id = p.product_id
                                            WHERE prd.request_id = $get_request_id
                                            LIMIT 1, 1";
                                            $result_product_2 = mysqli_query($link, $sql_product_2);
                                            $row_product_2 = mysqli_fetch_assoc($result_product_2);
                                            echo "<input type='hidden' name='product_id_2' value='" . $row_product_2['product_id'] . "' >";   
                                            echo "<input type='text' placeholder='" . $row_product_2['description'] . "' class='form-control form-control-sm' readonly>";    
                                    ?>
                                    </div>
                                    <div class="col-sm-2">
                                        <input placeholder="Quantity" type="number" min="0" class="form-control form-control-sm" name="qty_order_2">
                                    </div>
                                    <div class="col-sm-2">
                                        <input placeholder="Price" step="0.01" type="number" min="0" class="form-control form-control-sm" name="quoted_price_2">
                                    </div>
                                </div>
                                <div class="form-row align-items-center"><br />  
                                    <label class="col-sm-2 col-form-label">Item 3</label>
                                    <div class="col-sm-6">
                                    <?php
                                            $sql_product_3 = "SELECT prd.product_id AS 'product_id', p.description AS 'description'
                                            FROM purchase_request_details prd 
                                            INNER JOIN product p ON prd.product_id = p.product_id
                                            WHERE prd.request_id = $get_request_id
                                            LIMIT 2, 1";
                                            $result_product_3 = mysqli_query($link, $sql_product_3);
                                            $row_product_3 = mysqli_fetch_assoc($result_product_3);
                                            echo "<input type='hidden' name='product_id_3' value='" . $row_product_3['product_id'] . "' >";   
                                            echo "<input type='text' placeholder='" . $row_product_3['description'] . "' class='form-control form-control-sm' readonly>";    
                                    ?>
                                    </div>
                                    <div class="col-sm-2">
                                        <input placeholder="Quantity" type="number" min="0" class="form-control form-control-sm" name="qty_order_3">
                                    </div>
                                    <div class="col-sm-2">
                                        <input placeholder="Price" step="0.01" type="number" min="0" class="form-control form-control-sm" name="quoted_price_3">
                                    </div>
                                </div>
                                <div class="form-row align-items-center"><br />  
                                    <label class="col-sm-2 col-form-label">Item 4</label>
                                    <div class="col-sm-6">
                                    <?php
                                            $sql_product_4 = "SELECT prd.product_id AS 'product_id', p.description AS 'description'
                                            FROM purchase_request_details prd 
                                            INNER JOIN product p ON prd.product_id = p.product_id
                                            WHERE prd.request_id = $get_request_id
                                            LIMIT 3, 1";
                                            $result_product_4 = mysqli_query($link, $sql_product_4);
                                            $row_product_4 = mysqli_fetch_assoc($result_product_4);
                                            echo "<input type='hidden' name='product_id_4' value='" . $row_product_4['product_id'] . "' >";   
                                            echo "<input type='text' placeholder='" . $row_product_4['description'] . "' class='form-control form-control-sm' readonly>";    
                                    ?>
                                    </div>
                                    <div class="col-sm-2">
                                        <input placeholder="Quantity" type="number" min="0" class="form-control form-control-sm" name="qty_order_4">
                                    </div>
                                    <div class="col-sm-2">
                                        <input placeholder="Price" step="0.01" type="number" min="0" class="form-control form-control-sm" name="quoted_price_4">
                                    </div>
                                </div>
                                <div class="form-row align-items-center"><br />  
                                    <label class="col-sm-2 col-form-label">Item 5</label>
                                    <div class="col-sm-6">
                                    <?php
                                            $sql_product_5 = "SELECT prd.product_id AS 'product_id', p.description AS 'description'
                                            FROM purchase_request_details prd 
                                            INNER JOIN product p ON prd.product_id = p.product_id
                                            WHERE prd.request_id = $get_request_id
                                            LIMIT 4, 1";
                                            $result_product_5 = mysqli_query($link, $sql_product_5);
                                            $row_product_5 = mysqli_fetch_assoc($result_product_5);
                                            echo "<input type='hidden' name='product_id_5' value='" . $row_product_5['product_id'] . "' >";   
                                            echo "<input type='text' placeholder='" . $row_product_5['description'] . "' class='form-control form-control-sm' readonly>";    
                                    ?>
                                    </div>
                                    <div class="col-sm-2">
                                        <input placeholder="Quantity" type="number" min="0" class="form-control form-control-sm" name="qty_order_5">
                                    </div>
                                    <div class="col-sm-2">
                                        <input placeholder="Price" step="0.01" type="number" min="0" class="form-control form-control-sm" name="quoted_price_5">
                                    </div>
                                </div>   
                            </div>
                            <div class="card-footer">
                            <div align="right">
                                    <input type="submit" class="btn btn-md btn-outline-primary" value="Submit">
                                    <a href="purchase-orders.php" class="btn btn-md btn-outline-danger">Cancel</a>
                            </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
        </div>
        <?php mysqli_close($link);?>
    <!-- End of Content -->

    <!-- Footer -->
    <footer class="page-footer font-small"><br>
        <div class="footer-copyright text-center py-3">
        © 2018-2019
        </div>
    </footer><br>
    <!-- Footer -->

    <!-- JavaScript Frameworks -->
    <script src="jquery/jquery-3.3.1.slim.min.js"></script>
    <script src="jquery/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- JavaScript Frameworks -->  

</body>
</html>