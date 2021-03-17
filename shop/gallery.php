<?php
include("../engine/engine.php");

//Принимаем данные методом GET, можно кстати сделать ассоциативный массив.
$link = $_GET['link'];
$id = $_GET['id'];
$size = $_GET['size'];
$date = $_GET['date'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    $source = "<img src=\"{$link}\"><br>";
    $source .= "<i>Id: {$id}, <br>";
    $source .= "Size: {$size}Kb,<br> Uploaded: {$date}</i>";
    echo $source;
    ?>
</body>

</html>