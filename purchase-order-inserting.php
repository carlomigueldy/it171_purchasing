<?php
// Include config file
require_once "config.php";
require_once "session.php";

// Define variables and initialize with empty values
$request_id = $supplier_id = $order_term = $staff_id = "";
$last_order_id = "";

// Processing form data when form is submitted
if(!empty($_POST)){
    
    // Fetching data for Purchase Order
    $request_id = mysqli_real_escape_string($link, $_POST["request_id"]);
    $supplier_id = mysqli_real_escape_string($link, $_POST["supplier_id"]);
    $order_term = mysqli_real_escape_string($link, $_POST["order_term"]);
    $staff_id = mysqli_real_escape_string($link, $_POST["staff_id"]);

    // Fetching data for Purchase Order Details
    $product_id_1 = mysqli_real_escape_string($link, $_POST["product_id_1"]);
    $qty_order_1 = mysqli_real_escape_string($link, $_POST["qty_order_1"]);
    $quoted_price_1 = mysqli_real_escape_string($link, $_POST["quoted_price_1"]);

    $product_id_2 = mysqli_real_escape_string($link, $_POST["product_id_2"]);
    $qty_order_2 = mysqli_real_escape_string($link, $_POST["qty_order_2"]);
    $quoted_price_2 = mysqli_real_escape_string($link, $_POST["quoted_price_2"]);

    $product_id_3 = mysqli_real_escape_string($link, $_POST["product_id_3"]);
    $qty_order_3 = mysqli_real_escape_string($link, $_POST["qty_order_3"]);
    $quoted_price_3 = mysqli_real_escape_string($link, $_POST["quoted_price_3"]);
    
    $product_id_4 = mysqli_real_escape_string($link, $_POST["product_id_4"]);
    $qty_order_4 = mysqli_real_escape_string($link, $_POST["qty_order_4"]);
    $quoted_price_4 = mysqli_real_escape_string($link, $_POST["quoted_price_4"]);

    $product_id_5 = mysqli_real_escape_string($link, $_POST["product_id_5"]);
    $qty_order_5 = mysqli_real_escape_string($link, $_POST["qty_order_5"]);
    $quoted_price_5 = mysqli_real_escape_string($link, $_POST["quoted_price_5"]);

    $sql_insert_purchase_order = "INSERT INTO purchase_order 
    (request_id, supplier_id, order_term, staff_id) 
    VALUES ($request_id, $supplier_id, '$order_term', $staff_id)
    ";
    
    if(mysqli_query($link, $sql_insert_purchase_order)){
        $last_order_id = mysqli_insert_id($link);
        echo "Purchase Order created successfully!";
    }else{
        echo "Some error occured. (" . $sql_insert_purchase_order . ")<br />" . mysqli_error($link) . "<br />";
    }

    // Item A: Check first if input is empty, then don't execute these lines of code
    if(!empty($product_id_1) && !empty($qty_order_1) && !empty($quoted_price_1)){

        $sql_insert_product_1 = "INSERT INTO purchase_order_details 
        (order_id, product_id, qty_order, quoted_price)
        VALUES ($last_order_id,$product_id_1,$qty_order_1,$quoted_price_1)
        ";

        mysqli_query($link, $sql_insert_product_1);
    }

    // Item B: Check first if input is empty, then don't execute these lines of code
    if(!empty($product_id_2) && !empty($qty_order_2) && !empty($quoted_price_2)){

        $sql_insert_product_2 = "INSERT INTO purchase_order_details 
        (order_id, product_id, qty_order, quoted_price)
        VALUES ($last_order_id,$product_id_2,$qty_order_2,$quoted_price_2)
        ";

        mysqli_query($link, $sql_insert_product_2);
    }

    // Item C: Check first if input is empty, then don't execute these lines of code
    if(!empty($product_id_3) && !empty($qty_order_3) && !empty($quoted_price_3)){

        $sql_insert_product_3 = "INSERT INTO purchase_order_details 
        (order_id, product_id, qty_order, quoted_price)
        VALUES ($last_order_id,$product_id_3,$qty_order_3,$quoted_price_3)
        ";

        mysqli_query($link, $sql_insert_product_3);
    }

    // Item D: Check first if input is empty, then don't execute these lines of code
    if(!empty($product_id_4) && !empty($qty_order_4) && !empty($quoted_price_4)){

        $sql_insert_product_4 = "INSERT INTO purchase_order_details 
        (order_id, product_id, qty_order, quoted_price)
        VALUES ($last_order_id,$product_id_4,$qty_order_4,$quoted_price_4)
        ";

        mysqli_query($link, $sql_insert_product_4);
    }

    // Item E: Check first if input is empty, then don't execute these lines of code
    if(!empty($product_id_5) && !empty($qty_order_5) && !empty($quoted_price_5)){

        $sql_insert_product_5 = "INSERT INTO purchase_order_details 
        (order_id, product_id, qty_order, quoted_price)
        VALUES ($last_order_id,$product_id_5,$qty_order_5,$quoted_price_5)
        ";

        mysqli_query($link, $sql_insert_product_5);
    }

    $sql_update_status = "UPDATE purchase_request SET request_status = 'Ordered' WHERE request_id = $request_id";
    mysqli_query($link,$sql_update_status);

    // Close link
    mysqli_close($link);
    header("location: purchase-order-read.php?order_id=$last_order_id");
}
?>