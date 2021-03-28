<?php
ob_start();
$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$extra = 'admin.php?dir=admin';
sleep(1);
header("Location: http://$host$uri/$extra");

//Соединяемся с БД
include("../../engine/dbconnect.php");

//Подключаем файл с функциями
include("../../engine/engine.php");

(isset($_GET["dir"])) ? $path = "../" : $path = "";

//Проверяем данные в масиве POST, если данные есть, то удаляем лишнее в $_POST
if (isset($_POST['submit'])) {
    $product_name = strip_tags($_POST["product-name"]);
    $price = strip_tags($_POST["price"]);
} else {
    unset($_POST);
}

(isset($_FILES["userimage"]["tmp_name"])) ? uploadImage($dir, $name, $connect, $sql, $product_name, $price) : "";