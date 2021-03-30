<?php
// session_start();
// //Соединяемся с БД
// include("../engine/dbconnect.php");

// //Подключаем файл с функциями
// include("../../engine/engine.php");

(isset($_GET["page"])) ? $path = "../" : $path = "";

//Проверяем данные в масиве POST, если данные есть, то удаляем лишнее в $_POST
if (isset($_POST['add'])) {
    $product_name = strip_tags($_POST["product-name"]);
    $price = strip_tags($_POST["price"]);
    // echo $product_name . $price;
} else {
    unset($_POST);
}
?>

<div class="main">
    <h1 class="header-h1">Admin panel</h1>
    <div class="menu">
        <a href="?page=products">Go back to main page</a>
        <?php echo "<div>User: " . $_SESSION['login'] . " -> <a href=\"?page=products&action=logout\">logout</a></div>"; ?>
    </div>
    <hr width="100%">
    <?php

    outputImageQuery($connect, $sql, $path);
    ?>
    <hr width="100%">
    <details>
        <summary class="test">Add product</summary>
        <form enctype="multipart/form-data" method="post" action="admin/createProduct.php" class="form-load-file">
            <label>Product name</label>
            <input type="text" name="product-name" required><br>
            <label>Price</label>
            <input type="text" name="price" required><br>
            <label>Product image</label>
            <input type="file" name="userimage" required><br>
            <input type="submit" name="submit"> <input type="reset" name="reset">
            <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
            <input type="hidden" name="add" value="add" />
        </form>
    </details>
</div>
</div>
</body>

</html>