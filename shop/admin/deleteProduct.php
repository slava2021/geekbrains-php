<?php
session_start();
//Выполняем проверку пользователя, если не админ, перенаправляем на главную страницу
if (isset($_SESSION['role']) || !isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'customer' || !isset($_SESSION['role'])) {
        header("Location: http://" . $_SERVER['HTTP_HOST'] . "/shop");
        exit;
    }
}

$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$extra = '../index.php?page=admin';
sleep(1);
header("Location: http://$host$uri/$extra");
//Соединяемся с БД
include("../../engine/dbconnect.php");

if (isset($_GET['delete'])) {
    $id = (int)$_GET["id"];

    dbQueryId($connect, $id);

    $sql = "DELETE FROM images WHERE id = '$id'";

    if (mysqli_query($connect, $sql)) {
        deleteImage($link, $get_name);
        echo "<h1><font color=\"green\">Запись успешно удалена</font></h1>";
    } else {
        echo "Ошибка удаления: " . mysqli_error($connect);
    }
}
function deleteImage($link, $get_name)
{
    $dir = "../img";
    $link = "../{$link}";
    $images = scandir($dir);
    // var_dump($images);
    foreach ($images as $value) {
        if ($value == "." || $value == "..") {
            continue;
        }
        if ($value == $get_name) {
            unlink($link);
        }
    }
}