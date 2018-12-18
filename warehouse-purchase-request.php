<?php
require_once "session.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Purchase Requests</title>
    <link rel="icon" href="img/rob.png" type="image/ico">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <link href="fontawesome-free-5.5.0-web/css/all.css" rel="stylesheet">
    <style type="text/css">
        table tr td:last-child a{
            margin-right: 15px;
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
            <li class="nav-item active">
              <a class="nav-link" href="warehouse-purchase-request.php">Purchase Requests</a>
            </li>
            <li class="nav-item dropdown">
              <li class="nav-item">
                <a class="nav-link" href="product.php">Product</a>
            </li>
            <li class="nav-item dropdown">
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
        <div class="container"><br />
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header clearfix">
                        <h2 class="float-left"><i class='fas fa-clipboard'></i> List of Purchase Requests</h2>
                        <form action="" class="form-inline float-right" method="POST">
                            <div class="form-group mx-sm-3">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="Search">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-outline-dark" title="Search Purchase Order">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                                <div class='btn-group float-right' role='group' aria-label='Basic example'>
                                <a href='welcome.php' class='btn btn-outline-danger' title="Back"><i class="fas fa-arrow-left"></i></a>
                                    </div>
                        </form>
                        </div>
                    <br>
                    <?php
                    // Include config file
                    require_once "config.php";

                    if (empty($_REQUEST['search'])) {
                        // Attempt select query execution
                        $sql = "SELECT pr.request_id AS 'request_id', s.fname AS 's_fname', s.lname AS 's_lname',
                        pr.request_date AS 'request_date', pr.request_status AS 'request_status'
                        FROM purchase_request pr
                        INNER JOIN warehouse_staff s ON s.staff_id = pr.staff_id
                        ORDER BY pr.request_status ASC
                        ";

                        if($result = mysqli_query($link, $sql)){
                            if(mysqli_num_rows($result) > 0){
                            echo "<div class='table-responsive' style='overflow: auto; height: 500px;'>";
                                echo "<table class='table table-bordered table-striped table-hover table-sm'>";
                                    echo "<thead class='thead-dark'>";
                                        echo "<tr align='center'>";
                                            echo "<th>#</th>";
                                            echo "<th>Staff</th>";
                                            echo "<th>Date</th>";
                                            echo "<th>Status</th>";
                                            echo "<th>Action</th>";
                                        echo "</tr>";
                                    echo "</thead>";
                                    echo "<tbody>";
                                    while($row = mysqli_fetch_array($result)){
                                        echo "<tr align='center'>";
                                            echo "<td>" . $row['request_id'] . "</td>";
                                            echo "<td>" . $row['s_fname'] . " " . $row['s_lname'] . "</td>";
                                            echo "<td>" . $row['request_date'] . "</td>";
                                            echo "<td>" . $row['request_status'] . "</td>";
                                            echo "<td>";
                                                echo "<a href='warehouse-purchase-request-read.php?request_id=". $row['request_id'] ."' title='View Purchase Request'><i class='far fa-eye btn btn-sm btn-outline-info'></i></a>";
                                                echo "</td>";
                                        echo "</tr>";
                                    }
                                    echo "</tbody>";
                                echo "</table>";
                            echo "</div>";
                                // Free result set
                                mysqli_free_result($result);
                            } else{
                                echo "<p class='lead'><em>No records were found.</em></p>";
                            }
                        } else{
                            echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                        }
                    } elseif (!empty($_REQUEST['search'])){
                        // Get search value from forms
                        $search_data = mysqli_real_escape_string($link,$_REQUEST['search']);
                        // Attempt select query execution
                        $sql_search = "SELECT pr.request_id AS 'request_id', 
                        s.fname AS 's_fname', s.lname AS 's_lname',
                        pr.request_date AS 'request_date', 
                        pr.request_status AS 'request_status'
                        FROM purchase_request pr
                        INNER JOIN staff s ON s.staff_id = pr.staff_id
                        WHERE pr.request_id LIKE '%".$search_data."%'
                            OR s.fname LIKE '%".$search_data."%'
                            OR s.lname LIKE '%".$search_data."%'
                            OR pr.request_date LIKE '%".$search_data."%'
                            OR pr.request_status LIKE '%".$search_data."%'
                        ";

                        if($result_search = mysqli_query($link, $sql_search)){
                            if(mysqli_num_rows($result_search) > 0){
                            echo "<div class='table-responsive' style='overflow: auto; height: 500px;'>";
                                echo "<table class='table table-bordered table-striped table-hover table-sm'>";
                                    echo "<thead class='thead-dark'>";
                                        echo "<tr align='center'>";
                                            echo "<th>#</th>";
                                            echo "<th>Staff</th>";
                                            echo "<th>Date</th>";
                                            echo "<th>Status</th>";
                                            echo "<th>Action</th>";
                                        echo "</tr>";
                                    echo "</thead>";
                                    echo "<tbody>";
                                    while($row_search = mysqli_fetch_array($result_search)){
                                        echo "<tr align='center'>";
                                            echo "<td>" . $row_search['request_id'] . "</td>";
                                            echo "<td align='left'>" . $row_search['s_fname'] . " " . $row_search['s_lname'] . "</td>";
                                            echo "<td>" . $row_search['request_date'] . "</td>";
                                            echo "<td>" . $row_search['request_status'] . "</td>";
                                            echo "<td>";
                                                echo "<a href='warehouse-purchase-request-read.php?request_id=". $row_search['request_id'] ."' title='View Purchase Request'><i class='far fa-eye btn btn-sm btn-outline-info'></i></a>";
                                                echo "</td>";
                                        echo "</tr>";
                                    }
                                    echo "</tbody>";
                                echo "</table>";
                            echo "</div>";
                                // Free result set
                                mysqli_free_result($result_search);
                            } else{
                                echo "<p class='lead'><em>No records were found.</em></p>";
                            }
                        } else{
                            echo "ERROR: Could not able to execute $sql_search. " . mysqli_error($link);
                        }
                    }
                        // Close connection
                        mysqli_close($link);
                    ?>
                </div>
            </div>
        </div>
    </div>
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
