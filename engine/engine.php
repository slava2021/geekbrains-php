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
    if (isset($_POST['order']) && $_POST['order'] == 'order') {
        header("Location: http://" . $_SERVER['HTTP_HOST'] . "/" . rtrim(dirname($_SERVER['PHP_SELF'])) . "?page=order");
        exit;
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
                echo "<h1 class=\"message-error\">Incorrect password or login</h1>";
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

function cartAdd()
{
}
//Добавляем заказ в БД
function addOrder($connect)
{
    if (isset($_POST['submit'])) {
        $user_name = strip_tags(htmlspecialchars($_POST['user_name']));
        $phone = strip_tags(htmlspecialchars($_POST['phone']));
        $address = strip_tags(htmlspecialchars($_POST['address']));
        $order_status = strip_tags(htmlspecialchars($_POST['order_status']));
        if ($order_status == "created") {
            $order_status = '1';
        }
        $sql = "INSERT INTO `order` (user_name, phone, address, status_id) VALUES ('$user_name', '$phone', '$address', '$order_status')";
        mysqli_query($connect, $sql);
        // echo mysqli_errno($connect) . ": " . mysqli_error($connect) . "\n";

        $sql = "SELECT id FROM `order` ORDER BY id DESC LIMIT 1";
        $result = mysqli_query($connect, $sql);
        foreach ($result as $value) {
            $order_id = $value['id'];
        }
        $sql = "INSERT INTO order_item (order_id, product_id, price, quantity) VALUE ";
        foreach ($_SESSION['cart'] as $prod_id => $value) {
            // $sql .= $id . ",";
            // echo "<br>Product id = " . $prod_id;
            $quantity = $_SESSION['cart'][$prod_id]['quantity'];
            $price = $_SESSION['cart'][$prod_id]['price'];
            $sql .= "('$order_id', '$prod_id', '$price', '$quantity'), ";
        }
        $sql = substr($sql, 0, -2);
        // echo $sql . "<br>";
        mysqli_query($connect, $sql);
        // echo mysqli_errno($connect) . ": " . mysqli_error($connect) . "\n";
    }
}

function listOrder($connect)
{
    $sql = "SELECT 
        `order`.`id`,
        `order`.`user_name`,
        `order`.`created`,
        `status`.`status`
         FROM `order`
        INNER JOIN `status` ON `order`.`status_id` = `status`.`id`;";
    $result = mysqli_query($connect, $sql);
    $order_list = "<table class=\"table\">
    <tr><th>Order id</th><th>User name</th><th>Created date</th><th>Order status</th><th></th></tr>
   ";
    foreach ($result as $value) {
        $order_list .= "<tr><td>{$value['id']}</td>";
        $order_list .= "<td>{$value['user_name']}</td>";
        $order_list .= "<td>{$value['created']}</td>";
        $order_list .= "<td>{$value['status']}</td>";
        $order_list .= "<td><a href=\"?page=order-details&order_id={$value['id']}\">Order details</a></td>";
    }
    $order_list .= "</table>";
    echo $order_list;
}

function orderDetails($connect)
{
    if (isset($_GET['order_id'])) {
        $order_id = $_GET['order_id'];
    }
    $sql = "
    SELECT
    `order`.`id`,
     `order`.`user_name`,
     `order`.`phone`,
     `order`.`address`,
     `order_item`.`price`,
     `order_item`.`quantity`,
     `images`.`product`,
     `order`.`created`,
     `status`.`status`
    FROM `order`
    INNER JOIN `order_item` ON `order`.`id` = `order_item`.`order_id`
    INNER JOIN `images` ON  `images`.`id` = `order_item`.`product_id` 
    INNER JOIN `status` ON `status`.`id` = `order`.`status_id` WHERE `order`.`id` = {$order_id};
";
    $result = mysqli_query($connect, $sql);
    // echo mysqli_errno($connect) . ": " . mysqli_error($connect) . "<br>\n";
    foreach ($result as $value) {
        $count = '0';
        $status_name = $value['status'];
        $select_option = selectOption($connect, $status_name, $order_id);
        echo " Order No.: {$value['id']},
            Name: {$value['user_name']},
            Phone: {$value['phone']},
            Address: {$value['address']}
            <hr width=\"100%\">
            Order status: {$select_option}
            <hr width=\"100%\"> ";
        $count++;
        if ($count == '1') break;
    }
    $order_list = "<table class=\"table\">
    <tr><th>Product</th><th>Quantity</th><th>Price</th><th></th></tr>
   ";
    // var_dump($result);
    $total = 0;
    foreach ($result as $value) {
        $order_id = $value['id'];
        $order_list .= "<tr><td>{$value['product']}</td>";
        $order_list .= "<td>{$value['quantity']}</td>";
        $order_list .= "<td>{$value['price']}</td>";
        $item_sum = $value['price'] * $value['quantity'];
        $order_list .= "<td>{$item_sum}</td>";
        $total += $item_sum;
    }
    $order_list .= "<tr><td colspan=\"4\">Total price: {$total}</td></tr>";
    $order_list .= "</table>";
    echo $order_list;
}

function selectOption($connect, $status_name, $order_id)
{
    if (isset($_POST['submit'])) {
        $status_id = $_POST['status'];
        // echo $status_id;
        $sql = "UPDATE `order` SET `status_id` = $status_id WHERE `order`.`id` = $order_id;";
        // echo $sql;
        mysqli_query($connect, $sql);
        // echo mysqli_errno($connect) . ": " . mysqli_error($connect) . "<br>\n";
        unset($_POST['submit']);
    }
    $sql = "SELECT * FROM `status`";
    $result = mysqli_query($connect, $sql);
    $select = "<form action=\"\" method=\"post\">\n
    <select name=\"status\">";
    foreach ($result as $value) {
        if ($status_name == $value['status']) {
            $select .= "<option value=\"{$value['id']}\" selected>{$value['status']}</option>\n";
        } else {
            $select .= "<option value=\"{$value['id']}\">{$value['status']}</option>\n";
        }
    }
    $select .= "</select>\n
     <input type=\"hidden\" name=\"order_id\" value=\"$order_id\">
     <input type=\"submit\" name=\"submit\" vlaue=\"submit\">\n</form>";
    return $select;
}