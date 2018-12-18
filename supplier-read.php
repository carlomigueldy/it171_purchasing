<?php
require_once "session.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Supplier Details</title>
    <link rel="icon" href="img/rob.png" type="image/ico">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <link href="fontawesome-free-5.5.0-web/css/all.css" rel="stylesheet">
    <style type="text/css">
        table tr td:last-child a{
            margin-right: 5px;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
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
              <!-- <a class="dropdown-item" href="create-purchase-order.php">Add a Purchase Order</a> -->
            </div>
            </li>
            <li class="nav-item dropdown active">
              <a class="nav-link dropdown-toggle" href="suppliers.php" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Suppliers <span class="sr-only">(current)</span>
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" href="canvassing.php">Canvassing</a>
                <a class="dropdown-item" href="suppliers.php">List of Suppliers</a>
                <a class="dropdown-item" href="create-supplier.php">Add a Supplier</a>
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
        <div class="container"><br />
            <div class="row">
                <div class="col-md-12">
                  <?php
                    if(isset($_GET["supplier_id"]) && !empty(trim($_GET["supplier_id"]))){
                        require_once "config.php";
                        $sid = $_GET["supplier_id"];
                      echo "<div class='page-header clearfix'>";
                        echo "<br><h2 class='float-left'><i class='fas fa-list-ol'></i> Supplier Details</h2>";
                        echo "<div class='btn-group float-right' role='group' aria-label='Basic example'>";
                        echo "<a href='suppliers.php?supplier_id=$sid' class='btn btn-outline-danger' title='Back'><i class='fas fa-arrow-left'></i></a>";
                          echo "<a href='supplier-detail-add.php?supplier_id=$sid' class='btn btn-outline-primary btn-md' title='Add an Item'><i class='fas fa-plus'></i></a>";
                        echo "</div>";
                          echo "</div><br>";
                        $sql = "SELECT * FROM supplier_product sp INNER JOIN product p ON sp.product_id = p.product_id WHERE supplier_id = ?";                      
                        if($stmt = mysqli_prepare($link, $sql)){
                            mysqli_stmt_bind_param($stmt, "i", $param_supplier_id);
                            $param_supplier_id = trim($_GET["supplier_id"]);
                            if(mysqli_stmt_execute($stmt)){
                                $result = mysqli_stmt_get_result($stmt);
                                $supplier_id = $param_supplier_id;
                                if(mysqli_num_rows($result) > 0){
                                echo "<div class='table-responsive'>";
                                  echo "<table class='table table-bordered table-striped table-hover table-sm'>";
                                      echo "<thead class='thead-dark'>";
                                          echo "<tr align='center'>";
                                              echo "<th>ID</th>";
                                              echo "<th>Product<small>(s)</small> Available</th>";
                                              echo "<th>Term</th>";
                                              echo "<th>Available Quantity</th>";
                                              echo "<th>Price</th>";
                                              echo "<th>Action</th>";
                                          echo "</tr>";
                                      echo "</thead>";
                                      echo "<tbody>";
                                    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                                      $supplier_id2 = $row['supplier_id'];
                                      echo "<tr align='center'>";
                                          echo "<td>" . $row['product_id'] . "</td>";
                                          echo "<td align='left'>" . $row['description'] . "</td>";
                                          echo "<td>" . $row['term'] . "</td>";
                                          echo "<td>" . $row['qty_available'] . "</td>";
                                          echo "<td>" . "Php " . number_format($row['supplier_price'],2) . "</td>";
                                          echo "<td>";
                                              echo "<a href='supplier-detail-update.php?id=". $row['id'] ."' title='Update Record'><i class='far fa-edit btn btn-sm btn-outline-secondary'></i></a>";
                                              echo "<a href='supplier-detail-delete.php?id=". $row['id'] ."' title='Delete Record'><i class='far fa-trash-alt btn btn-sm btn-outline-danger'></i></a>";
                                          echo "</td>";
                                      echo "</tr>";
                                    }
                                    echo "</tbody>";
                                echo "</table>";
                              echo "</div>";
                                mysqli_free_result($result);
                                } else{
                                    // URL doesn't contain valid id parameter. Redirect to error page
                                    echo "No records found.";
                                    echo " " . "(Supplier ID: " . $_GET["supplier_id"] . ")";
                                    exit();
                                }

                            } else{
                                echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                            }
                        }

                        mysqli_stmt_close($stmt);
                    } else{
                        // URL doesn't contain id parameter. Redirect to error page
                        header("location: error.php");
                        exit();
                    }
                    ?>
                </div>
                <?php
                  $sql_info = "SELECT * FROM suppliers WHERE supplier_id = $supplier_id2";
                  if($result_info = mysqli_query($link, $sql_info)){
                    if(mysqli_num_rows($result_info) > 0){
                      while($row_info = mysqli_fetch_array($result_info)){
                        echo "<div class='container'>"; 
                            echo "<p><u>Supplier ID</u> (#" . $row_info['supplier_id'] . ")<br>";
                            echo "<small>Name: " . $row_info['fname'] . " " . $row_info['lname'] . "</small><br>";
                            echo "<small>Email Address: " . $row_info['email'] . "</small><br>";
                            echo "<small>Contact Number: " . $row_info['contact_number'] . "</small><br>";
                            echo "</p>";
                        echo "</div>";
                      }
                    }
                  }
                  
                mysqli_close($link);
                ?>
            </div>
        </div>
    </div>
    <br><br>
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
