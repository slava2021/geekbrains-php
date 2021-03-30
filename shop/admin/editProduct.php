<?php
session_start();
//Выполняем проверку пользователя, если не админ, перенаправляем на главную страницу
if (isset($_SESSION['role']) || !isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'customer' || !isset($_SESSION['role'])) {
        header("Location: http://" . $_SERVER['HTTP_HOST'] . "/shop");
        exit;
    }
}
//Соединяемся с БД
include("../../engine/dbconnect.php");
//Подключаем файл с функциями
include("../../engine/engine.php");

if (!empty($_POST['update'])) {
    $host  = $_SERVER['HTTP_HOST'];
    // $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $uri = 'shop';
    $extra = "?page=admin";
    sleep(1);
    header("Location: http://$host/$uri/$extra");
}

$id = (int)$_GET["id"];

dbQueryId($connect, $id);
$dir_img = $link . $get_name;
$dir = $link;
updateRecordDB($connect, $dir, $get_name, $link, $name, $id);

// var_dump($_FILES['userimage']);
// var_dump(isset($_FILES['userimage']));
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
    <div class="container">
        <div class="main">
            <h1 class="header-h1">Edit product</h1>
            <a href="../index.php?page=admin">Back</a>
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
                <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
                <input type="hidden" name="edit" value="edit" />
                <input type="hidden" name="id" value="<?php echo $id; ?>" />
                <input type="submit" name="update" value="Update"> <input type="reset" name="reset">
            </form>
        </div>
    </div>
</body>

</html>