<?php
require_once "session.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Purchase Orders</title>
    <link rel="icon" href="img/rob.png" type="image/ico">
    <link  href="css/bootstrap.min.css" rel="stylesheet">
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
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header clearfix">
                        <br />
                        <h2 class="float-left"><i class="fas fa-clipboard-list"></i> List of Purchase Orders</h2>
            
                        <form action="" class="form-inline float-right" method="POST">
                            <!-- Split dropright button -->
                            <div class="btn-group dropright">
                            <button type="button" class="btn btn-outline-primary">
                                Filter By
                            </button>
                            <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="sr-only">Toggle Dropright</span>
                            </button>
                            <div class="dropdown-menu">
                                <h6 class="dropdown-header">ASCENDING</h6>
                                <a class="dropdown-item" href="purchase-order-filter-by-asc-approved.php"><small>Approved</small></a>
                                <a class="dropdown-item" href="purchase-order-filter-by-asc-unapproved.php"><small>Unapproved</small></a>
                                <a class="dropdown-item" href="purchase-order-filter-by-asc-datetime.php"><small>Date & Time</small></a>
                                <a class="dropdown-item" href="purchase-order-filter-by-asc-term.php"><small>Term</small></a>
                                <a class="dropdown-item active" href="purchase-order-filter-by-asc-totalamount.php"><small>Total Amount</small></a>
                                <a class="dropdown-item" href="purchase-order-filter-by-asc-supplier.php"><small>Supplier</small></a>
                                <a class="dropdown-item" href="purchase-order-filter-by-asc-preparedby.php"><small>Prepared By</small></a>
                                <div class="dropdown-divider"></div>
                                <h6 class="dropdown-header">DESCENDING</h6>
                                <a class="dropdown-item" href="purchase-order-filter-by-desc-approved.php"><small>Approved</small></a>
                                <a class="dropdown-item" href="purchase-order-filter-by-desc-unapproved.php"><small>Unapproved</small></a>
                                <a class="dropdown-item" href="purchase-order-filter-by-desc-datetime.php"><small>Date & Time</small></a>
                                <a class="dropdown-item" href="purchase-order-filter-by-desc-term.php"><small>Term</small></a>
                                <a class="dropdown-item" href="purchase-order-filter-by-desc-totalamount.php"><small>Total Amount</small></a>
                                <a class="dropdown-item" href="purchase-order-filter-by-desc-supplier.php"><small>Supplier</small></a>
                                <a class="dropdown-item" href="purchase-order-filter-by-desc-preparedby.php"><small>Prepared By</small></a>
                            </div>
                            </div>
                        </form>

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
                            <!-- <div class='btn-group float-right' role='group' aria-label='Basic example'>
                                <a href='welcome.php' class='btn btn-outline-danger' title="Back"><i class="fas fa-arrow-left"></i></a>
                                <a href="purchase-order-create.php" class="btn btn-outline-primary btn-md" title="Create Purchase Order"><i class="fas fa-plus"></i></a>
                            </div> -->
                        </form><br />
                    </div>                        
                    
                   
                    <br>
                    <?php
                    // Include config file
                    require_once "config.php";
                    if (empty($_REQUEST['search'])) {

                        // Attempt select query execution
                        $sql = "SELECT p.order_id AS 'order_id', s.fname AS 's_fname',
                        s.lname AS 's_lname', p.order_date AS 'order_date',
                        p.order_term AS 'order_term', p.total_amount AS 'total_amount',
                        e.fname AS 'e_fname', e.lname AS 'e_lname',
                        p.order_status AS 'order_status'
                        FROM purchase_order p
                        INNER JOIN suppliers s ON p.supplier_id = s.supplier_id
                        INNER JOIN staff e ON p.staff_id = e.staff_id
                        ORDER BY p.total_amount ASC";

                        if($result = mysqli_query($link, $sql)){
                            if(mysqli_num_rows($result) > 0){
                            echo "<div class='table-responsive' style='overflow: auto; height: 500px;'>"; //  
                                echo "<table id='purchaseOrder' class='table table-bordered table-striped table-hover table-sm header-fixed'>";
                                    echo "<thead class='thead-dark'>";
                                        echo "<tr align='center'>";
                                            echo "<th onclick='sortTable(0)'>#</th>";
                                            echo "<th onclick='sortTable(1)'>Supplier<small><i class='fa fa-fw fa-sort'></i></small></th>";
                                            echo "<th onclick='sortTable(2)'>Date & Time<small><i class='fa fa-fw fa-sort'></i></small></th>";
                                            echo "<th onclick='sortTable(3)'>Term<small><i class='fa fa-fw fa-sort'></i></small></th>";
                                            echo "<th onclick='sortTable(4)'>Total Amount<small><i class='fa fa-fw fa-sort'></i></small></th>";
                                            echo "<th onclick='sortTable(5)'>Prepared By<small><i class='fa fa-fw fa-sort'></i></small></th>";
                                            echo "<th onclick='sortTable(6)'>Status<small><i class='fa fa-fw fa-sort'></i></small></th>";
                                            echo "<th>Action</th>";
                                        echo "</tr>";
                                    echo "</thead>";
                                    echo "<tbody>";
                                    while($row = mysqli_fetch_array($result)){
                                        echo "<tr align='center' >";
                                        echo "<td>" . $row['order_id'] . "</td>";
                                        echo "<td align='left'>" . $row['s_fname'] . " " . $row['s_lname'] . "</td>";
                                        echo "<td>" . $row['order_date'] . "</td>";
                                        echo "<td>" . $row['order_term'] . "</td>";
                                        echo "<td align='left'>" . "$" . number_format($row['total_amount'],2) . "</td>";
                                        echo "<td align='left'>" . $row['e_fname'] . " " .$row['e_lname'] . "</td>";
                                        echo "<td>" . $row['order_status'] . "</td>";
                                            echo "<td align='center'>";
                                                echo "<a href='purchase-order-read.php?order_id=". $row['order_id'] ."' title='View Record'><i class='far fa-eye btn btn-sm btn-outline-info'></i></a>";
                                                echo "<a href='purchase-order-update.php?order_id=". $row['order_id'] ."' title='Update Record'><i class='far fa-edit btn btn-sm btn-outline-secondary'></i></a>";
                                                echo "<a href='purchase-order-delete.php?order_id=". $row['order_id'] ."' title='Delete Record'><i class='far fa-trash-alt btn btn-sm btn-outline-danger'></i></a>";
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

                        // Close connection
                        mysqli_close($link);
                    } elseif(!empty($_REQUEST['search'])){
                        // Get search value from forms
                        $search_data = mysqli_real_escape_string($link,$_REQUEST['search']);
                        // Attempt select query execution
                        $search_sql = "SELECT p.order_id AS 'order_id', s.fname AS 's_fname',
                        s.lname AS 's_lname', p.order_date AS 'order_date',
                        p.order_term AS 'order_term', p.total_amount AS 'total_amount',
                        e.fname AS 'e_fname', e.lname AS 'e_lname',
                        p.order_status AS 'order_status'
                        FROM purchase_order p
                        INNER JOIN suppliers s ON p.supplier_id = s.supplier_id
                        INNER JOIN staff e ON p.staff_id = e.staff_id
                        WHERE p.order_id LIKE '%".$search_data."%'
                                        OR s.fname LIKE '%".$search_data."%' 
                                        OR s.lname LIKE '%".$search_data."%'
                                        OR p.order_date LIKE '%".$search_data."%'
                                        OR p.order_term LIKE '%".$search_data."%'
                                        OR p.total_amount LIKE '%".$search_data."%'
                                        OR e.fname LIKE '%".$search_data."%'
                                        OR e.lname LIKE '%".$search_data."%'
                                        OR p.order_status LIKE '%".$search_data."%'
                        ORDER BY p.order_id ASC";

                        if($search_result = mysqli_query($link, $search_sql)){
                            if(mysqli_num_rows($search_result) > 0){
                            echo "<div class='table-responsive' style='overflow: auto; height: 500px;'>"; //  
                                echo "<table id='purchaseOrder' class='table table-bordered table-striped table-hover table-sm header-fixed'>";
                                    echo "<thead class='thead-dark'>";
                                        echo "<tr align='center'>";
                                            echo "<th onclick='sortTable(0)'>#</th>";
                                            echo "<th onclick='sortTable(1)'>Supplier<small><i class='fa fa-fw fa-sort'></i></small></th>";
                                            echo "<th onclick='sortTable(2)'>Date & Time<small><i class='fa fa-fw fa-sort'></i></small></th>";
                                            echo "<th onclick='sortTable(3)'>Term<small><i class='fa fa-fw fa-sort'></i></small></th>";
                                            echo "<th onclick='sortTable(4)'>Total Amount<small><i class='fa fa-fw fa-sort'></i></small></th>";
                                            echo "<th onclick='sortTable(5)'>Prepared By<small><i class='fa fa-fw fa-sort'></i></small></th>";
                                            echo "<th onclick='sortTable(6)'>Status<small><i class='fa fa-fw fa-sort'></i></small></th>";
                                            echo "<th>Action</th>";
                                        echo "</tr>";
                                    echo "</thead>";
                                    echo "<tbody>";
                                    while($search_row = mysqli_fetch_array($search_result)){
                                        echo "<tr align='center' >";
                                        echo "<td>" . $search_row['order_id'] . "</td>";
                                        echo "<td align='left'>" . $search_row['s_fname'] . " " . $search_row['s_lname'] . "</td>";
                                        echo "<td>" . $search_row['order_date'] . "</td>";
                                        echo "<td>" . $search_row['order_term'] . "</td>";
                                        echo "<td align='left'>" . "$" . number_format($search_row['total_amount'],2) . "</td>";
                                        echo "<td align='left'>" . $search_row['e_fname'] . " " .$search_row['e_lname'] . "</td>";
                                        echo "<td>" . $search_row['order_status'] . "</td>";
                                            echo "<td align='center'>";
                                                echo "<a href='purchase-order-read.php?order_id=". $search_row['order_id'] ."' title='View Purchase Order'><i class='far fa-eye btn btn-sm btn-outline-info'></i></a>";
                                                echo "<a href='purchase-order-update.php?order_id=". $search_row['order_id'] ."' title='Update Purchase Order'><i class='far fa-edit btn btn-sm btn-outline-secondary'></i></a>";
                                                echo "<a href='purchase-order-delete.php?order_id=". $search_row['order_id'] ."' title='Delete Purchase Order'><i class='far fa-trash-alt btn btn-sm btn-outline-danger'></i></a>";
                                            echo "</td>";
                                        echo "</tr>";
                                    }
                                    echo "</tbody>";
                                echo "</table>";
                            echo "</div>";
                                // Free result set
                                mysqli_free_result($search_result);
                            } else{
                                echo "<p class='lead'><em>No records were found.</em></p>";
                            }
                        } else{
                            echo "ERROR: Could not able to execute $search_sql. " . mysqli_error($link);
                        }

                        // Close connection
                        mysqli_close($link);
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Footer -->
    <footer class="page-footer font-small"><br>
        <div class="footer-copyright text-center py-3">
        © 2018-2019
        </div>
    </footer><br>
    <!-- Footer -->

    <!-- End of Content -->

    <!-- JavaScript Frameworks -->
    <script src="jquery/jquery-3.3.1.slim.min.js"></script>
    <script src="jquery/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
    function sortTable(n) {
    var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
    table = document.getElementById("purchaseOrder");
    switching = true;
    // Set the sorting direction to ascending:
    dir = "asc"; 
    /* Make a loop that will continue until
    no switching has been done: */
    while (switching) {
        // Start by saying: no switching is done:
        switching = false;
        rows = table.rows;
        /* Loop through all table rows (except the
        first, which contains table headers): */
        for (i = 1; i < (rows.length - 1); i++) {
        // Start by saying there should be no switching:
        shouldSwitch = false;
        /* Get the two elements you want to compare,
        one from current row and one from the next: */
        x = rows[i].getElementsByTagName("TD")[n];
        y = rows[i + 1].getElementsByTagName("TD")[n];
        /* Check if the two rows should switch place,
        based on the direction, asc or desc: */
        if (dir == "asc") {
            if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
            // If so, mark as a switch and break the loop:
            shouldSwitch = true;
            break;
            }
        } else if (dir == "desc") {
            if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
            // If so, mark as a switch and break the loop:
            shouldSwitch = true;
            break;
            }
        }
        }
        if (shouldSwitch) {
        /* If a switch has been marked, make the switch
        and mark that a switch has been done: */
        rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
        switching = true;
        // Each time a switch is done, increase this count by 1:
        switchcount ++; 
        } else {
        /* If no switching has been done AND the direction is "asc",
        set the direction to "desc" and run the while loop again. */
        if (switchcount == 0 && dir == "asc") {
            dir = "desc";
            switching = true;
        }
        }
    }
    }
    </script>
    <!-- JavaScript Frameworks -->
</body>
</html>
