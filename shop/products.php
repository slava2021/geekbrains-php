<div class="main">
    <h1 class="header-h1">Shop Online</h1>
    <div class="menu">
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') { ?>
        <a href="?page=admin">Admin panel</a>
        <?php } ?>
        <div>
            <?php if (!isset($_SESSION['succ'])) { ?>
            <a href="?page=login">Login</a> or
            <a href="?page=addUser">Sign up</a>
            <?php } else {
                echo "User: " . $_SESSION['login'] . " -> <a href=\"?page=products&action=logout\">logout</a>";
            } ?>
        </div>
    </div>
    <hr width="100%">
    <?php
    outputImageQuery($connect, $sql);
    ?>
</div>
<div class="cart">
    <h1>Cart</h1>
    <?php
    if (isset($_SESSION['cart'])) {
        $sql = "SELECT * FROM images WHERE id IN (";
        foreach ($_SESSION['cart'] as $id => $value) {
            $sql .= $id . ",";
        }
        $sql = substr($sql, 0, -1) . ") ORDER BY product ASC";
        $query = mysqli_query($connect, $sql);
        // var_dump($query);
        $totalprice = 0;
        if ($query) {
            while ($row = mysqli_fetch_assoc($query)) {
                $subtotal = $_SESSION['cart'][$row['id']]['quantity'] * $row['price'];
                $totalprice += $subtotal;
    ?>
    <p><?php echo $row['product'] ?> x
        <?php echo $_SESSION['cart'][$row['id']]['quantity'] ?> =
        <?php echo $_SESSION['cart'][$row['id']]['price'] * $_SESSION['cart'][$row['id']]['quantity'] ?>
    </p>
    <?php
            }
        } else {
            echo "You cart is empty";
        }
        ?>
    <hr />
    <p>Total: <?php echo $totalprice ?> </p>
    <a href="?page=cart">Go to cart</a>
    <?php
    } else {
        echo "<p>Your Cart is empty.</p>";
    }
    ?>
</div>