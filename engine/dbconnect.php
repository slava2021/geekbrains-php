<?php
//  Выводим ошибки в любом случае, для отладки кода
declare(strict_types=1);

ini_set('error_reporting', (string)E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

$connect = mysqli_connect("localhost:3306", "root", "root", "gallery");

if (!$connect) {
    die(mysqli_connect_error($connect));
}

function dbQueryId($connect, $id)
{
    $query = mysqli_query($connect, "SELECT * FROM images WHERE id = '$id'");
    while ($row = mysqli_fetch_assoc($query)) {
        global $price;
        global $product_name;
        global $link;
        global $name;
        global $size;
        global $get_name;
        $price = $row['price'];
        $product_name = $row['product'];
        $link = $row['source'];
        $name = $row['iname'];
        $size = $row['size'];
        $get_name = $row['iname'];
    }
}