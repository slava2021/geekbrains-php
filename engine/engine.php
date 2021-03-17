<?php
//Соединяемся с БД
include("../engine/dbconnect.php");

$dir = 'img/';
$name = isset($_FILES["userimage"]["name"]) ? basename($_FILES["userimage"]["name"]) : "";
$sql = mysqli_query($connect, "SELECT * FROM images");
$page_gallery = "gallery.php";

//функция загрузки картинок
function uploadImage($dir, $name, $connect, $sql)
{
    if (move_uploaded_file($_FILES["userimage"]["tmp_name"], "$dir/$name")) {
        $size = $_FILES["userimage"]["size"];
        $size = round($size / 1024, 2);
        insertImageQuery($connect, $sql, $name, $dir, $size);
        echo "<h1 class=\"message\" style=\"color:green;\">Картинка успешно загружена.</h1>";
    } else {
        echo "<h1 class=\"message\" style=\"color:blue;\">Нет данных для загрузки</h1>";
    }
    unset($_POST);
}

//функция чтения файлов из директории img и проверки на тип
function imagesSet($dir, $connect, $sql)
{
    $images = scandir($dir);
    // var_dump($images);
    foreach ($images as $value) {
        if ($value == "." || $value == "..") {
            continue;
        }
        $src = $dir . $value;
        $size = filesize($src);
        $size = round($size / 1024, 2);
        if (strpos($value, 'jpg') !== false) { //выполняем проверку mimetype я смтрел, другие функции например explode, filetype
            // echo "<a target=\"_blank\" href=\"" . $src . "\"><img class=\"thumb\" src=\"" . $src . "\"></a>";
            insertImageQuery($connect, $sql, $value, $dir, $size);
        } else {
            $warning = "error \"" . $value . "\" это не картинка";
        }
    }
    outputImageQuery($connect, $sql);
}

//Добавляем картинки в БД
function insertImageQuery($connect, $sql, $name, $dir, $size)
{
    if (!$sql) {
        die(mysqli_connect_error($connect));
    }
    $sql = "SELECT source FROM images WHERE name = '$name'";
    $result = mysqli_query($connect, $sql);
    // var_dump($result);
    if ($result->num_rows == 0) {
        $sql = "INSERT INTO images (name, size, source) VALUES ('$name', '$size', '$dir')";
        // echo "<br>" . $sql . "<br>";
        mysqli_query($connect, $sql);
    }
}
//Выводим изображения
function outputImageQuery($connect, $sql)
{
    if (!$sql) {
        die(mysqli_connect_error($connect));
    }
    while ($row = mysqli_fetch_assoc($sql)) {
        // echo "{$row['id']} | {$row['source']}{$row['name']} | {$row['size']} | {$row['created']} ";
        $link = $row['source'] . $row['name'];
        $img = "<img class=\"thumb\" src=\"{$link}\">";
        echo "<a href=\"gallery.php?id={$row['id']}&link={$link}&size={$row['size']}&date={$row['created']}\" target=\"_blank\">{$img}</a>";
    }
}