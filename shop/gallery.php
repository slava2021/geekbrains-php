<?php
// session_start();
// //Принимаем данные методом GET, можно кстати сделать ассоциативный массив.
// include("../engine/dbconnect.php");
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
}

(dbQueryId($connect, $id));
$link = $link . $name;
if ($id == $id_db) {
    if (isset($_GET['action']) && $_GET['action'] == "add") {
        $id = intval($_GET['id']);
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity']++;
        } else {
            $sql_s = "SELECT * FROM images 
            WHERE id={$id}";
            $query_s = mysqli_query($connect, $sql_s);
            if (mysqli_num_rows($query_s) != 0) {
                $row_s = mysqli_fetch_assoc($query_s);

                $_SESSION['cart'][$row_s['id']] = array(
                    "quantity" => 1,
                    "price" => $row_s['price'],
                    "source" => $link
                );
            } else {
                $message = "This product id it's invalid!";
            }
        }
    }
?>
<div class="main">
    <h1 class="header-h1">Product description</h1>
    <?php
        if (!isset($_SESSION['role']) || $_SESSION['role'] == 'customer') { ?>
    <a href="?page=products">Go back to products page</a>
    <?php } else if ($_SESSION['role'] == 'admin') { ?>
    <a href="?page=admin">Go back to admin page</a>
    <?php } ?>
    <hr width="100%">
    <?php

    $source = "<div class=\"add-cart\"><img src=\"{$link}\"><br>";
    $source .= "<i>Product name: {$product_name} <br>";
    $source .= "<i>Price: {$price}<br>";
    $source .= "&#128722 <a href=\"?page=gallery&action=add&id={$id}\">Add to cart</a></div>";
    echo $source;

    if (isset($message)) {
        echo "<h2>$message</h2>";
    }
} else {
    echo 'Product is out of catalog';
}
    ?>
</div>