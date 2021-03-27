<?php
//Соединяемся с БД
include("../engine/dbconnect.php");

//Подключаем файл с функциями
include("../engine/engine.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Shop</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="main">
        <h1 class="header-h1">Shop Online</h1>
        <a href="admin/admin.php?dir=admin">Административная панель</a>
        <hr width="100%">
        <?php
        // insertImageQuery($connect, $sql, $name, $dir, $size);
        // uploadImage($dir, $name);x
        // (isset($_FILES["userimage"]["tmp_name"])) ? uploadImage($dir, $name, $connect, $sql) : "";
        // imagesSet($dir, $connect, $sql, $path, $product_name, $price);
        outputImageQuery($connect, $sql, $path);
        ?>
    </div>
</body>

</html>