<?php
//  Выводим ошибки в любом случае, для отладки кода
declare(strict_types=1);

ini_set('error_reporting', (string)E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

//Подключаем файл с функциями
include("../engine/engine.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="gallery-body">
        <?php
        // insertImageQuery($connect, $sql, $name, $dir, $size);
        // uploadImage($dir, $name);x
        (isset($_FILES["userimage"]["tmp_name"])) ? uploadImage($dir, $name, $connect, $sql) : "";
        imagesSet($dir, $connect, $sql);
        ?>
        <form enctype="multipart/form-data" method="post" action="" class="form-load-file">
            <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
            <hr>
            <input type="file" name="userimage">
            <hr>
            <input type="submit" name="submit">
            <!-- <input type="reset" value="Сбросить" name="reset"> -->
        </form>
    </div>
</body>

</html>