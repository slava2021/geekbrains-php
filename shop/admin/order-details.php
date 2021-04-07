<div class="main">
    <h1 class="header-h1">Order details</h1>
    <div class="menu">
        <a href="?page=admin">Go back to admin panel</a>
        <a href="?page=order-list">Go back to order list</a>
        <?php echo "<div>User: " . $_SESSION['login'] . " -> <a href=\"?page=products&action=logout\">logout</a></div>"; ?>
    </div>
    <hr width="100%">

    <?php
    orderDetails($connect);
    ?>