<?php
//Принимаем данные методом GET, можно кстати сделать ассоциативный массив.
include("../engine/dbconnect.php");
$id = $_GET['id'];
(dbQueryId($connect, $id));
$link = $link . $name;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    $source = "<img src=\"{$link}\"><br>";
    $source .= "<i>Product name: {$product_name} <br>";
    $source .= "<i>Price: {$price}";
    echo $source;
    ?>
</body>

</html>