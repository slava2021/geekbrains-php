<?php
// Создаем переменные
$_title = "Template PHP";
$_h1 = "Lorem, ipsum dolor.";
$_date = date('d M Y:i:s');
$date = date('Y');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title><?php echo $_title; ?></title>
</head>

<body>
    <div class="main-container">
        <header class="top-block">
            <h1>Top block</h1>
        </header>
        <div class="left-block">
            <h1>Left block</h1>
        </div>
        <main class="main-block">
            <h1>Main block</h1>
            <!-- insert php code -->
            <h1><?php echo $_h1; ?></h1>
            <time><?php echo $_date; ?></time>
            <p class="top-block-p">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Minima veniam, unde
                praesentium cum illo iste. Quae ipsa amet architecto ut.</p>
        </main>
        <div class="right-block">
            <h1>Right block</h1>
        </div>
        <footer class="footer-block">
            <h1>Footer block</h1>
            <?php echo "<h2>&#169; " . $date . "</h2>"; ?>
        </footer>
    </div>

</body>

</html>