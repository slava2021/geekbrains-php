<?php
// session_start();
// //Соединяемся с БД
// include("../engine/dbconnect.php");

if (isset($_POST['submit'])) {
    foreach ($_POST['quantity'] as $key => $val) {
        if ($val == 0) {
            unset($_SESSION['cart'][$key]);
        } else {
            $_SESSION['cart'][$key]['quantity'] = $val;
        }
    }
}

?>
<div class="main">
    <h1 class="header-h1">View cart</h1>
    <a href="?page=products">Go back to products page</a>
    <hr width="100%">
    <form method="post" action="?page=cart">
        <table class="table">
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Items Price</th>
            </tr>
            <?php

            $sql = "SELECT * FROM images WHERE id IN (";

            foreach ($_SESSION['cart'] as $id => $value) {
                $sql .= $id . ",";
            }
            $sql = substr($sql, 0, -1) . ") ORDER BY product ASC";
            // echo $sql;
            $query = mysqli_query($connect, $sql);
            $totalprice = 0;
            if ($query) {
                while ($row = mysqli_fetch_assoc($query)) {
                    $subtotal = $_SESSION['cart'][$row['id']]['quantity'] * $row['price'];
                    $totalprice += $subtotal;
            ?>
            <tr>
                <td><img height="60px" src="<?php echo $_SESSION['cart'][$row['id']]['source'] ?>"></td>
                <td><?php echo $row['product'] ?></td>
                <td><input type="text" name="quantity[<?php echo $row['id'] ?>]" size="5"
                        value="<?php echo $_SESSION['cart'][$row['id']]['quantity'] ?>" /></td>
                <td><?php echo $row['price'] ?>$</td>
                <td><?php echo $_SESSION['cart'][$row['id']]['quantity'] * $row['price'] ?>$</td>
            </tr>
            <?php
                }
                ?>
            <tr>
                <td colspan="5">Total Price: <?php echo $totalprice ?></td>
            </tr>
        </table>
        <button type="submit" name="submit">Update Cart</button>
        <button type="submit" name="order" value="order">Create order</button>
        <p>To remove an item, set it's quantity to 0. </p>
    </form>

</div>
<?php
            } else {
                echo "You cart is epmty";
            }

?>