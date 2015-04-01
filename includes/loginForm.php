<h3>
    <?php echo $login_title; ?>
</h3>

<?php
if (isset($_GET["error"])) {
    $error = $_GET["error"];
} else {
    $error = 0;
}

switch ($error) {
    case 1: {
            $message = "<div class='alert alert-danger'>";
            $message .= $err_login1;
            $message .= "</div>";
            echo $message;
            break;
        }
    case 2: {
            $message = "<div class='alert alert-warning'>";
            $message .= $err_login2;
            $message .= "</div>";
            echo $message;
            break;
        }
    case 3: {
            $message = "<div class='alert alert-warning'>";
            $message .= $err_login3;
            $message .= "</div>";
            echo $message;
            break;
        }
    default: {
            $message = "";
            echo $message;
            break;
        }
}
?>

<form role="form" action="loginValidate.php" method="post">
    <div class="form-group">
        <label for="exampleInputEmail1"><?php echo $label_username; ?></label><input class="form-control" id="exampleInputEmail1" type="username" name="username" />
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1"><?php echo $label_password; ?></label><input class="form-control" id="exampleInputPassword1" type="password" name="password" />
    </div>
    <button type="submit" class="btn btn-default"><?php echo $button_login; ?></button>
</form>