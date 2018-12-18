<?php require_once "session.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Purchase Order Details</title>
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
  <div class="container-fluid">
    <div class="container">
      <div class="page-header clearfix"><br />
        <h2 class="float-left"><i class="fas fa-list-ol"></i> Purchase Order Details</h2>
        <div class="btn-group float-right" role="group" aria-label="Basic example">
          <div class="btn-group float-right" role="group" aria-label="Basic example">
            <a href="purchase-orders.php" class="btn btn-outline-danger" title="Back"><i class="fas fa-arrow-left"></i></a>
            <a href="purchase-order-detail-add.php?order_id=<?php echo $_GET['order_id'];?>" class="btn btn-outline-primary btn-md" title="Add an Item"><i class="fas fa-plus"></i></a>
          </div>
        </div>
      </div>
      <br />
    </div>
    <div class="row">
      <div class="col-md-3">
      <?php
      require_once "config.php";

      $sql_info = "SELECT p.order_id AS 'order_id', s.fname AS 's_fname',
      s.lname AS 's_lname', p.order_date AS 'order_date',
      p.order_term AS 'order_term', p.total_amount AS 'total_amount',
      e.fname AS 'e_fname', e.lname AS 'e_lname', s.email AS 's_email',
      p.order_status AS 'order_status', s.contact_number AS 'contact_number'
      FROM purchase_order p
      INNER JOIN suppliers s ON p.supplier_id = s.supplier_id
      INNER JOIN staff e ON p.staff_id = e.staff_id
      WHERE p.order_id = {$_GET['order_id']}
      ORDER BY p.order_id ASC";

      if($result_info = mysqli_query($link, $sql_info)){
        if(mysqli_num_rows($result_info) > 0){
          while($row_info = mysqli_fetch_array($result_info)){
            echo "<ul class='list-group'>";
              echo "<li class='list-group-item'><b>Purchase Order ID# </b>" . $row_info['order_id'] . "</li>";
              echo "<li class='list-group-item'><b>Prepared By:</b> "  . $row_info['e_fname'] . " " . $row_info['e_lname'] .  "</li>";
              echo "<li class='list-group-item'><b>Date & Time: </b>" . $row_info['order_date'] . "</li>";
              echo "<li class='list-group-item'><b>Supplier: </b>" . $row_info['s_fname'] . " " . $row_info['s_lname'] . "</li>";
              echo "<li class='list-group-item'><b>Email: </b>" . $row_info['s_email'] . "</li>";
              echo "<li class='list-group-item'><b>Contact: </b>" . $row_info['contact_number'] . "</li>";
              echo "<li class='list-group-item'><b>Status: </b>" . $row_info['order_status'] . "</li>";
              echo "<li class='list-group-item'><b>Total Amount: </b>Php " . number_format($row_info['total_amount'],2) . "</li>";
            echo "</ul>";
          }
        }
      }
      ?>
      </div>
      <div class="col-md-9">
        <?php

        $sql = "SELECT * FROM purchase_order_details pod INNER JOIN product p ON pod.product_id = p.product_id WHERE order_id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
        mysqli_stmt_bind_param($stmt, "i", $param_order_id);
        $param_order_id = trim($_GET["order_id"]);
            if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
                if(mysqli_num_rows($result) > 0){
                    echo "<div class='table-responsive'>";
                        echo "<table class='table table-bordered table-striped table-hover table-sm'>";
                            echo "<thead>";
                                echo "<tr align='center'>";
                                    echo "<th><b>ID</b></th>";
                                    echo "<th><b>Product</b></th>";
                                    echo "<th><b>Quantity</b></th>";
                                    echo "<th><b>Quoted Price</b></th>";
                                    echo "<th><b>Action</b></th>";
                                echo "</tr>";
                            echo "</thead>";
                        echo "<tbody>";
                  while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                  $order_id2 = $row['order_id'];
                      echo "<tr align='center'>";
                          echo "<td>" . $row['product_id'] . "</td>";
                          echo "<td>" . $row['description'] . "</td>";
                          echo "<td>" . $row['qty_order'] . "</td>";
                          echo "<td>Php " . number_format($row['quoted_price'],2) . "</td>";
                          echo "<td>";
                              echo "<a href='purchase-order-detail-update.php?id=". $row['id'] ."' title='Update Record'><i class='far fa-edit btn btn-sm btn-outline-secondary'></i></a>";
                              echo "<a href='purchase-order-detail-delete.php?id=". $row['id'] ."' title='Delete Record'><i class='far fa-trash-alt btn btn-sm btn-outline-danger'></i></a>";
                          echo "</small></td>";
                      echo "</tr>";
                      $sum = $row['qty_order'] * $row['quoted_price'];
                  }
                }else{
                  echo "<p class='lead'><em>No records were found.</em></p>";
                }
                        echo "</tbody>";
                    echo "</table>";
                echo "</div>";
                mysqli_free_result($result);
            }
          }
        ?>
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
