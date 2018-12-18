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

    <div>
        <input type="input" class="form-control form-control-sm qty" />
        <input type="input" class="form-control form-control-sm price" />
    </div>
    <div>
        <input type="input" class="form-control form-control-sm qty" />
        <input type="input" class="form-control form-control-sm price" />
    </div>
    <div>
        <input type="input" class="form-control form-control-sm qty" />
        <input type="input" class="form-control form-control-sm price" />
    </div>
    Total: <span id="total"></span>


    <!-- JavaScript Frameworks -->
    <script src="jquery/jquery-3.3.1.slim.min.js"></script>
    <script src="jquery/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
        jQuery(function($) {

    $(".qty, .price").change(function() {
        var total = 0;
        $(".qty").each(function() {
            var self = $(this),
                price = self.next(".price"),
                subtotal = parseInt(self.val(), 10) * parseFloat(price.val(), 10);
            total += (subtotal || 0);
        });
        $("#total").text(total);
    });

    });
    </script>
    <!-- JavaScript Frameworks -->  

</body>
</html>