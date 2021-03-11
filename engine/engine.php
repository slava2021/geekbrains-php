<?php
$dir = 'img/';
$name = basename($_FILES["userimage"]["name"]);

//функция загрузки картинок
function uploadImage($dir, $name)
{
    if (move_uploaded_file($_FILES["userimage"]["tmp_name"], "$dir/$name")) {
        echo "<h1 class=\"message\" style=\"color:green;\">Файл был успешно загружен.</h1>";
    } else {
        echo "<h1 class=\"message\" style=\"color:blue;\">Нет данных для загрузки</h1>";
    }
    unset($_POST);
}

//функция чтения файлов из директории img и проверки на тип
function imagesSet($dir)
{
    $images = scandir($dir);
    foreach ($images as $value) {
        $src = $dir . $value;
        if (strpos($value, 'jpg') !== false) { //выполняем проверку mimetype я смтрел, другие функции например explode, filetype
            echo "<a target=\"_blank\" href=\"" . $src . "\"><img class=\"thumb\" src=\"" . $src . "\"></a>";
        } else {
            $warning = "error \"" . $value . "\" это не картинка";
        }
    }
}