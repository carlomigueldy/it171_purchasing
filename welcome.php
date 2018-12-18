<?php
require_once "session.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link rel="icon" href="img/rob.png" type="image/ico">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <link href="fontawesome-free-5.5.0-web/css/all.css" rel="stylesheet">
</head>
<body>

  <!-- Navigation Bar (Top) -->
      <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top" >
        <a class="navbar-brand" href="#">
          <img src="img/rob.png" width="30" height="30" class="d-inline-block align-top" alt="">
          Purchasing Department
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

      <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
          <li class="nav-item active">
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
    <div class="container">
      <br /><br /><br />
      <!-- Welcome -->
        <img src="img/welcome-a.jpg" class="img-fluid" alt="Responsive image">
        <div class="jumbotron jumbotron-fluid">
          <div class="container">
            <h1 class="display-4">Welcome <?php echo htmlspecialchars($_SESSION["username"]); ?>!</h1>
            <p class="lead">You now have authorized access in the Robinson's Purchasing Department System.</p>
            <ul>
              <li class="">Create, confirm and send Purchase Orders</li>
              <li class="">Manage List of Suppliers</li>
              <li class="">Update Purchasing logs</li>
            </ul>
            <blockquote class="blockquote text-center">
              <p class="mb-0">"Everything you have is bought by the currency of time."</p>
              <footer class="blockquote-footer">Sunday Adelaja, <cite title="Source Title">The Mountain of Ignorance</cite></footer>
            </blockquote>
          </div>
        </div>
      <!-- Welcome -->
    </div>
    <!-- Content -->

    <!-- Footer -->
    <footer class="page-footer font-small">
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
