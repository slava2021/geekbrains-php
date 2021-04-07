<?php
session_start();

//Соединяемся с БД
require_once("../engine/dbconnect.php");

//Подключаем файл с функциями
require_once("../engine/engine.php");

//Функция аутентификации и авторизации
authUser($connect);

if (isset($_GET['page'])) {
    $pages = array(
        "products",
        "gallery",
        "cart",
        "login",
        "addUser",
        "admin",
        "order",
        "order-list",
        "order-details",
    );
    if (in_array($_GET['page'], $pages)) {
        $_page = $_GET['page'];
    } else {
        $_page = "products"; //если в массиве нет такого имя страниц, устанавливаем по умполчанию страницу products
    }
} else {
    $_page = "products"; //если GET пустой устанавливаем поумолчанию страницу products
}

if (isset($_GET['page']) == 'gallery') {
    redirectPage();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Shop - <?php echo $_page ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="container">
        <?php
        if ($_page == 'admin') {
            $_page = 'admin/admin';
        }
        if ($_page == 'order-list') {
            $_page = 'admin/order-list';
        }
        if ($_page == 'order-details') {
            $_page = 'admin/order-details';
        }
        // echo $_page . $_GET['page'];
        require($_page . ".php"); ?>
    </div>
</body>

</html>