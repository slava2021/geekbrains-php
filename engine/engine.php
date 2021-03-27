<?php

$dir = 'img/';
$name = isset($_FILES["userimage"]["name"]) ? basename($_FILES["userimage"]["name"]) : "";
$sql = mysqli_query($connect, "SELECT * FROM images");
$page_gallery = "gallery.php";
$path = "";
$product_name = "";
$price = "";

//функция загрузки картинок
function uploadImage($dir, $name, $connect, $sql, $product_name, $price)
{
    if (move_uploaded_file($_FILES["userimage"]["tmp_name"], "../$dir/$name")) {
        $size = $_FILES["userimage"]["size"];
        $size = round($size / 1024, 2);
        $result = insertImageQuery($connect, $sql, $name, $dir, $size, $product_name, $price);
        if ($result == true) {
            echo "<h1 class=\"message\" style=\"color:green;\">Товар успешно добавлен!</h1>";
        } else {
            echo "<h1 class=\"message\" style=\"color:orange;\">Товар уже существует!</h1>";
        }
    } else {
        echo "<h1 class=\"message\" style=\"color:blue;\">Нет данных для загрузки!</h1>";
    }
    unset($_POST);
}

//функция чтения файлов из директории img и проверки на тип
// function imagesSet($dir, $connect, $sql, $path, $product_name, $price)
// {
//     if ($_GET['dir'] == 'admin') {
//         $dir = '../' . $dir;
//     } else {
//         $dir;
//     }
//     $images = scandir($dir);
//     // var_dump($images);
//     foreach ($images as $value) {
//         if ($value == "." || $value == "..") {
//             continue;
//         }
//         $src = $dir . $value;
//         $size = filesize($src);
//         $size = round($size / 1024, 2);
//         if (strpos($value, 'jpg') !== false) { //выполняем проверку mimetype я смтрел, другие функции например explode, filetype
//             // echo "<a target=\"_blank\" href=\"" . $src . "\"><img class=\"thumb\" src=\"" . $src . "\"></a>";
//             insertImageQuery($connect, $sql, $value, $dir, $size, $product_name, $price);
//         } else {
//             $warning = "error \"" . $value . "\" это не картинка";
//         }
//     }

// }

//Добавляем картинки в БД
function insertImageQuery($connect, $sql, $name, $dir, $size, $product_name, $price)
{
    if (!$sql) {
        die(mysqli_connect_error($connect));
    }
    $sql = "SELECT source FROM images WHERE product = '$product_name'";
    $result = mysqli_query($connect, $sql);
    // var_dump($result);
    if ($result->num_rows == false) {
        $sql = "INSERT INTO images (iname, size, source, product, price) VALUES ('$name', '$size', '$dir', '$product_name', '$price')";
        // echo "<br>" . $sql . "<br>";
        mysqli_query($connect, $sql);
        return true;
    }
    return false;
}
//Выводим изображения
function outputImageQuery($connect, $sql, $path)
{
    if (!$sql) {
        die(mysqli_connect_error($connect));
    }
    ($path == true) ? $path = "../" : $path = "";
    while ($row = mysqli_fetch_assoc($sql)) {
        // echo "{$row['id']} | {$row['source']}{$row['name']} | {$row['size']} | {$row['created']} ";
        $link = $row['source'] . $row['iname'];
        $img = "<img class=\"thumb\" src=\"{$path}{$link}\"><br>";
        $href = $path . "gallery.php?id={$row['id']}&link={$link}&size={$row['size']}&date={$row['created']}";
        $html_a = "<a href=\"{$href}\" target=\"_blank\">{$img}</a>";
        $html_a .= "<hr>{$row['product']}<br>Price: <span class=\"price\">{$row['price']}</span>";
        if (isset($_GET['dir'])) {
            if ($_GET['dir'] == "admin") {
                $edit = "<a href=\"editProduct.php?edit=true&id={$row['id']}&price={$row['price']}&product={$row['product']}&name={$row['iname']}&link={$link}\">&#9998;</a>";
                $delite = "<a href=\"deleteProduct.php?delete=true&id={$row['id']}&link={$link}&name={$row['iname']}\">&#10006;</a>";
                $html_a .= "<hr>{$edit} | {$delite}";
            }
        }
        echo "<div class=\"card-product\">" . $html_a . "</div>";
    }
}

// Обновляем запись в БД
function updateRecordDB($connect, $id, $link, $dir, $name, $get_name)
{
    if (!isset($_POST['product-name']) || !isset($_POST['price']) || !isset($name)) {
        // echo "Ошибка! Поля в форме не должны быть пустыми";
        return;
    }
    // Проверяем формат, только, jpg можно загружать
    if (pathinfo($name, PATHINFO_EXTENSION) == "jpg" && isset($_FILES["userimage"])) {
        //Удаляем старый файл JPG
        $link = "../{$link}"; // $link - это путь к файлу + имя файла
        //Проверяем каталог есть ли внем картинка, перед удалением
        $dir = "../{$dir}";
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
        move_uploaded_file($_FILES["userimage"]["tmp_name"], "{$dir}{$name}");
        $name = basename($_FILES["userimage"]["name"]);
        $size = $_FILES["userimage"]["size"];
        $size = round($size / 1024, 2);
    }
    $product_name = strip_tags(htmlspecialchars($_POST['product-name']));
    $price = (float)$_POST['price'];
    $sql = "UPDATE images SET product='$product_name', price='$price', iname = '$name', size = '$size' WHERE id=$id";
    // echo "<br>" . $sql;
    if (isset($_POST['Update'])) {
        if (mysqli_query($connect, $sql)) {
            echo "<h1><font color=\"green\">Запись успешно обновлена в БД</font></h1>";
        } else {
            echo "Ошибка обновления записи в БД: " . mysqli_error($connect);
        }
    }
}