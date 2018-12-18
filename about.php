<?php
require_once "session.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>About</title>
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
          <li class="nav-item">
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
          <li class="nav-item active">
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
      <br><br>

<br><br>
      <div class="container-fluid">
      <h2>The Team</h2>
      <br>
      <!-- Card -->
      <div class="card-group">
        <div class="card">
          <img class="card-img-top" src="img/carlo_dy.jpg" alt="Card image cap">
          <div class="card-body">
            <h5 class="card-title">Carlo Miguel Dy</h5>
            <p class="card-text">Full Stack Developer, Database Adminstrator, System Administrator</p>
          </div>
        </div>
        <div class="card">
          <img class="card-img-top" src="img/jm_garcia.jpg" alt="Card image cap">
          <div class="card-body">
            <h5 class="card-title">Juan Miguel Garcia</h5>
            <p class="card-text">Project Manager, Database Administrator</p>
          </div>
        </div>
        <div class="card">
          <img class="card-img-top" src="img/jiji_mateo.jpg" alt="Card image cap">
          <div class="card-body">
            <h5 class="card-title">Jiezel Mateo</h5>
            <p class="card-text">Quality Assurance Tester, Information Architect</p>
          </div>
        </div>
        <div class="card">
          <img class="card-img-top" src="img/joni_rasco.jpg" alt="Card image cap">
          <div class="card-body">
            <h5 class="card-title">Joniselury Rasco</h5>
            <p class="card-text">UI / UX Designer, Database Maintenance, Front End Developer</p>
          </div>
        </div>
        <div class="card">
          <img class="card-img-top" src="img/eden_estillore.jpg" alt="Card image cap">
          <div class="card-body">
            <h5 class="card-title">Eden Lou Estillore</h5>
            <p class="card-text">Software Documentation, Data Analyst</p>
          </div>
        </div>
      </div>
      <!-- Card -->

      <!-- Carousel -->
      <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img class="d-block w-100" src="img/a.jpg" alt="First slide">
          </div>
          <div class="carousel-item">
            <img class="d-block w-100" src="img/b.jpg" alt="Second slide">
          </div>
          <div class="carousel-item">
            <img class="d-block w-100" src="img/c.jpg" alt="Third slide">
          </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
      <!-- Carousel -->
  
      
</div>
      <p class="mt-5 mb-3 text-muted" align="center">© 2018-2019</p>
      <br>
  </div>
    <!-- Content -->

    <!-- JavaScript Frameworks -->
    <script src="jquery/jquery-3.3.1.slim.min.js"></script>
    <script src="jquery/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- JavaScript Frameworks -->
</body>
</html>
