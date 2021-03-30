<?php
// unset($_SESSION['registr']);
?>
<div class="container">
    <div class="main">
        <h1 class="header-h1">Login page</h1>
        <a href="?page=products">Go back to products page</a>
        <hr width="100%">
        <form method="post" action="">
            <label>Login</label>
            <input type="text" name="login" required><br>
            <label>Password</label>
            <input type="password" name="password" required><br>
            <input type="submit" name="submit"> <input type="reset" name="reset">
        </form>
    </div>
</div>