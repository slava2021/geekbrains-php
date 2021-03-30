<?php
if (isset($_POST['submit'])) {
    $login = strip_tags(htmlspecialchars($_POST['login']));
    $pass = strip_tags(htmlspecialchars($_POST["password"]));
    $pass = password_hash($pass, PASSWORD_BCRYPT);
    $role = 'customer';
    $sql = "SELECT user_name FROM users WHERE user_name = '$login'";
    $result = mysqli_query($connect, $sql);

    // var_dump($result);
    if ($result->num_rows == false) {
        $sql = "INSERT INTO users (user_name, pass, role) 
        VALUES ('$login', '$pass', '$role')";
        // echo $sql;
        if (mysqli_query($connect, $sql)) {
            echo "<h1 class=\"message-succ\">Вы успешно зарегестрированы</h1>";
            $_SESSION['registr'] = "ok";
        } else {
            echo "<h1 class=\"message-warning\">Warning: Что-то пошло не так";
            echo "<br>" . mysqli_error($connect) . "</h1>";
        }
    } else {
        echo "<h1 class=\"message-warning\">Warning: Пользователь {$login} уже существует </h1>";
    }
}
?>
<div class="main">
    <h1 class="header-h1">Create account page</h1>
    <a href="?page=products">Go back to products page</a>
    <hr width="100%">
    <?php if (!isset($_SESSION['registr'])) { ?>
    <form method="post" action="">
        <label>Login</label>
        <input type="text" name="login" required><br>
        <label>Password</label>
        <input type="password" name="password" required><br>
        <input type="submit" name="submit"> <input type="reset" name="reset">
        <input type="hidden" name="add_user" value="login" />
    </form>
    <?php } ?>
</div>