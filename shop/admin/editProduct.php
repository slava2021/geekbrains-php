<?php
//Соединяемся с БД
include("../../engine/dbconnect.php");

//Подключаем файл с функциями
include("../../engine/engine.php");

if (!empty($_POST['Update'])) {
    ob_start();
    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $extra = 'admin.php?dir=admin';
    sleep(1);
    header("Location: http://$host$uri/$extra");
}

$id = (int)$_GET["id"];

(dbQueryId($connect, $id));

$dir_img = $link . $get_name;
$dir = $link;

updateRecordDB($connect, $id, $link, $dir, $name, $get_name, $size);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit product</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="main">
        <?php

        ?>
        <h1 class="header-h1">Редактирование продукта</h1>
        <a href="admin.php?dir=admin">Назад</a>
        <hr width="100%">
        <img src="../<?php echo $dir_img; ?>">
        <hr width="100%">
        <form enctype="multipart/form-data" method="post" action="" class="form-load-file">
            <label>Имя товара</label>
            <input type="text" name="product-name" value="<?php echo $product_name; ?>"><br>
            <label>Цена</label>
            <input type="text" name="price" value="<?php echo $price; ?>"><br>
            <label>Загрузить изображение</label>
            <input type="file" name="userimage"><br>
            <input type="submit" name="Update"> <input type="reset" name="reset">
            <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
            <input type="hidden" name="edit" value="edit" />
            <input type="hidden" name="id" value="<?php echo $id; ?>" />
        </form>

    </div>
</body>

</html>