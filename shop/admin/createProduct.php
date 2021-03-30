<?php
session_start();
//Выполняем проверку пользователя, если не админ, перенаправляем на главную страницу
if (isset($_SESSION['role']) || !isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'customer' || !isset($_SESSION['role'])) {
        header("Location: http://" . $_SERVER['HTTP_HOST'] . "/shop");
        exit;
    }
}

ob_start();
$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$extra = '../index.php?page=admin';
sleep(1);
header("Location: http://$host$uri/$extra");

//Соединяемся с БД
include("../../engine/dbconnect.php");

//Подключаем файл с функциями
include("../../engine/engine.php");

(isset($_GET["page"])) ? $path = "../" : $path = "";

//Проверяем данные в масиве POST, если данные есть, то удаляем лишнее в $_POST
if (isset($_POST['submit'])) {
    $product_name = strip_tags($_POST["product-name"]);
    $price = strip_tags($_POST["price"]);
} else {
    unset($_POST);
}

(isset($_FILES["userimage"]["tmp_name"])) ? uploadImage($dir, $name, $connect, $sql, $product_name, $price) : "";