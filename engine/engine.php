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
function outputImageQuery($connect, $sql)
{
    if (!$sql) {
        die(mysqli_connect_error($connect));
    }
    while ($row = mysqli_fetch_assoc($sql)) {
        $link = $row['source'] . $row['iname'];
        $img = "<img class=\"thumb\" src=\"{$link}\"><br>";
        $href = "?page=gallery&id={$row['id']}";
        $html_a = "<a href=\"{$href}\" >{$img}</a>";
        $html_a .= "<hr>{$row['product']}<br>Price: <span class=\"price\">{$row['price']}</span>";
        if (isset($_GET['page'])) {
            if ($_GET['page'] == "admin") {
                // $edit = "<a href=\"editProduct.php?edit=true&id={$row['id']}&price={$row['price']}&product={$row['product']}&name={$row['iname']}&link={$link}\">&#9998;</a>";
                $edit = "<a href=\"admin/editProduct.php?edit=true&id={$row['id']}\">&#9998;</a>";
                $delite = "<a href=\"admin/deleteProduct.php?delete=true&id={$row['id']}\">&#10006;</a>";
                $html_a .= "<hr>{$edit} | {$delite}";
            }
        }
        echo "<div class=\"card-product\">" . $html_a . "</div>";
    }
}

// Обновляем запись в БД
function updateRecordDB($connect, $dir, $get_name, $link, $name, $id)
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
                $link = $link . $get_name;
                echo "<br> del " . $link;
                unlink($link);
            }
        }
        move_uploaded_file($_FILES["userimage"]["tmp_name"], "{$dir}{$name}");
        $name = basename($_FILES["userimage"]["name"]);
        $size = $_FILES["userimage"]["size"];
        $size = round($size / 1024, 2);
        unset($_FILES["userimage"]);
    }

    $product_name = strip_tags(htmlspecialchars($_POST['product-name']));
    $price = (float)$_POST['price'];
    if (empty($name)) {
        $name = $get_name;
    }
    $sql = "UPDATE images SET product='$product_name', price='$price', iname = '$name', size = '$size' WHERE id=$id";
    echo "<br>" . $sql;
    if (isset($_POST['update'])) {
        if (mysqli_query($connect, $sql)) {
            echo "<h1><font color=\"green\">Запись успешно обновлена в БД</font></h1>";
        } else {
            echo "Ошибка обновления записи в БД: " . mysqli_error($connect);
        }
    }
}

function redirectPage()
{
    if (!empty($_GET['action'])) {
        ob_start();
        $host  = $_SERVER['HTTP_HOST'];
        $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        $extra = '?page=products';
        sleep(1);
        header("Location: http://$host$uri/$extra");
    }
}

function authUser($connect)
{
    if (isset($_GET['page']) && $_GET['page'] == 'login') {
        if (isset($_POST['submit'])) {
            $login = strip_tags(htmlspecialchars($_POST['login']));
            $pass = strip_tags(htmlspecialchars($_POST["password"]));
            $sql = "SELECT * FROM users WHERE user_name = '$login'";
            $result = mysqli_query($connect, $sql);
            // var_dump($result);
            while ($row = mysqli_fetch_array($result)) {
                $pass_hash = $row['pass'];
                $role = $row['role'];
            }
            if (password_verify($pass, $pass_hash)) {
                $_SESSION['login'] = $login;
                $_SESSION['role'] = $role;
                $_SESSION['succ'] = "ok";
            } else {
                echo "<br>Incorrect password or login";
            }
            unset($_POST['submit']);
        }
        if (isset($_SESSION['succ']) && $_SESSION['succ'] == "ok") {
            if ($_SESSION['role'] == 'admin') {
                $host  = $_SERVER['HTTP_HOST'];
                $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
                $succ = $_SESSION['succ'];
                $extra = "?page=admin&action={$succ}";
                sleep(1);
                header("Location: http://$host$uri/$extra");
                exit;
            } else if ($_SESSION['role'] == 'customer') {
                $host  = $_SERVER['HTTP_HOST'];
                $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
                $succ = $_SESSION['succ'];
                $extra = "?page=products&action={$succ}";
                sleep(1);
                header("Location: http://$host$uri/$extra");
            }
        }
    }
    if (isset($_GET['page']) && $_GET['page'] == 'admin') {
        if (isset($_SESSION['login']) && $_SESSION['role'] == 'customer') {
            header("Location: http://" . $_SERVER['HTTP_HOST'] . "/" . rtrim(dirname($_SERVER['PHP_SELF'])));
            exit;
        }
    }
    if (isset($_GET['action']) && $_GET['action'] == "logout") {
        session_destroy();
        header("Location: http://" . $_SERVER['HTTP_HOST'] . "/" . rtrim(dirname($_SERVER['PHP_SELF'])));
        exit;
    }
    if (isset($_GET['page']) && $_GET['page'] == "addUser") {
        if (isset($_SESSION['registr']) && $_SESSION['registr'] == 'ok') {
            header("Location: http://" . $_SERVER['HTTP_HOST'] . "/" . rtrim(dirname($_SERVER['PHP_SELF'])) . "/?page=login");
            exit;
        }
    }
}