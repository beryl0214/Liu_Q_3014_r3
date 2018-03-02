<?php
    require('./includes/connect.php');
    session_start();

    // if session last login date is not set, exit the admin welcome page
    if(!isset($_SESSION['lastLogin'])){
        header("Location: /");
        exit();
    }

    if(isset($_POST['new_password']) && isset($_POST['confirm_password'])) {
        $hashed_new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
        $sql_edit_user = "update users set password = '{$hashed_new_password}', status = 'active' where username = '{$_SESSION['username']}'";

        $result = $connection->query($sql_edit_user);

        if ($result) {
            echo $result;
            header("Location: /welcome.php");
            exit();
        } else {
            echo $sql_edit_user;
        }
    }
?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Beryl's admin page - Edit User</title>
</head>
<body>
<h1>Hello <?php echo $_SESSION['username']?>, please change your password</h1>
<h3>Edit User</h3>
<form method="post">
    <label for="new_password">New password</label>
    <input type="password" name="new_password" id="new_password" placeholder="New password">
    <br>
    <label for="confirm_password">Confirm password</label>
    <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm password">
    <br>
    <button type="submit">Submit</button>
</form>
<a href="/logout.php">Logout</a>
</body>
</html>