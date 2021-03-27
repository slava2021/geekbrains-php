<?php
//Соединяемся с БД
include("../../engine/dbconnect.php");

//Подключаем файл с функциями
include("../../engine/engine.php");

(isset($_GET["dir"])) ? $path = "../" : $path = "";

//Проверяем данные в масиве POST, если данные есть, то удаляем лишнее в $_POST
if (isset($_POST['submit'])) {
    $product_name = strip_tags($_POST["product-name"]);
    $price = strip_tags($_POST["price"]);
    // echo $product_name . $price;
} else {
    unset($_POST);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin panel</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="main">
        <h1 class="header-h1">Административная панель</h1>
        <a href="../index.php?dir=main">На главную</a>
        <hr width="100%">
        <?php
        // (isset($_FILES["userimage"]["tmp_name"])) ? uploadImage($dir, $name, $connect, $sql, $product_name, $price) : "";
        outputImageQuery($connect, $sql, $path);
        ?>
        <hr width="100%">
        <details>
            <summary class="test">Добавить товар</summary>
            <form enctype="multipart/form-data" method="post" action="createProduct.php" class="form-load-file">
                <label>Имя товара</label>
                <input type="text" name="product-name" required><br>
                <label>Цена</label>
                <input type="text" name="price" required><br>
                <label>Изображение</label>
                <input type="file" name="userimage" required><br>
                <input type="submit" name="submit"> <input type="reset" name="reset">
                <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
                <input type="hidden" name="add" value="add" />
            </form>
        </details>
    </div>

</body>

</html>