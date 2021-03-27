<?php
$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$extra = 'admin.php?dir=admin';
sleep(1);
header("Location: http://$host$uri/$extra");
//Соединяемся с БД
include("../../engine/dbconnect.php");

if (isset($_GET['delete'])) {
    $id = (int)$_GET["id"];
    $get_name = strip_tags(htmlspecialchars($_GET["name"]));
    $link = strip_tags(htmlspecialchars($_GET["link"]));
    // echo "<br>{$link}";
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