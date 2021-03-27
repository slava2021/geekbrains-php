<?php
//  Выводим ошибки в любом случае, для отладки кода
declare(strict_types=1);

ini_set('error_reporting', (string)E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

$connect = mysqli_connect("localhost:3306", "root", "root", "gallery");

if (!$connect) {
    die(mysqli_connect_error($connect));
}