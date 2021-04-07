<?php
addOrder($connect);
?>
<div class="main">
    <h1 class="header-h1">Create order</h1>
    <a href="?page=products">Go back to products page</a>
    <a href="?page=order-list">Order List</a>
    <hr width="100%">
    <?php if (isset($_POST['submit'])) { ?>
    <h1 class="message-succ">Order succesfuly created</h1>
    <?php unset($_POST);
        unset($_SESSION['cart']);
    } else { ?>
    <form method="post" action="?page=order" style="width: 100%;">
        <label>Type your name</label>
        <input type="text" name="user_name" required>
        <label>Type phone</label>
        <input type="tel" name="phone" pattern="+7([0-9]{3})[0-9]{3}-[0-9]{4}" required> <small> Format:
            +7(123)456-7890</small>
        <label>Type address</label>
        <input type="text" name="address" required>
        <input type="hidden" name="order_status" value="created">
        <hr width="100%">
        <button type="submit" name="submit">Send order</button> <button type="reset">Reset</button>
    </form>
    <?php } ?>
</div>