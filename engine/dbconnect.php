<?php

$connect = mysqli_connect("localhost:3306", "root", "root", "gallery");
if (!$connect) {
    die(mysqli_connect_error($connect));
}
