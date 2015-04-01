<h3><?php echo $addadmin; ?></h3>

<?php
switch ($error) {
    case 0: {
            $message = "<div class='alert alert-success'>";
            $message .= $admin_msg0;
            $message .= "</div>";
            echo $message;
            break;
        }
    case 1: {
            $message = "<div class='alert alert-warning'>";
            $message .= $admin_msg1;
            $message .= "</div>";
            echo $message;
            break;
        }
    case 2: {
            $message = "<div class='alert alert-warning'>";
            $message .= $admin_msg2;
            $message .= "</div>";
            echo $message;
            break;
        }
    case 3: {
            $message = "<div class='alert alert-warning'>";
            $message .= $admin_msg3;
            $message .= "</div>";
            echo $message;
            break;
        }
    case 33: {
            $message = "<div class='alert alert-warning'>";
            $message .= $admin_msg33;
            $message .= "</div>";
            echo $message;
            break;
        }
    case 4: {
            $message = "<div class='alert alert-danger'>";
            $message .= $admin_msg4;
            $message .= "</div>";
            echo $message;
            break;
        }
    default: {
            $message = "";
            break;
        }
}
?>

<form role="form" action="addAdminValidate.php" method="post">
    <div class="form-group">
        <label for="name"><?php echo $admin_name; ?></label><input class="form-control" id="name" type="text" name="name" value="<?php
        if (isset($_GET["name"])) {
            echo $_GET["name"];
        }
        ?>" />
        <label for="surname"><?php echo $admin_surname; ?></label><input class="form-control" id="surname" type="text" name="surname" value="<?php
        if (isset($_GET["surname"])) {
            echo $_GET["surname"];
        }
        ?>" />
        <label for="email"><?php echo $admin_email; ?></label><input class="form-control" id="email" type="email" name="email" value="<?php
        if (isset($_GET["email"])) {
            echo $_GET["email"];
        }
        ?>" />
    </div>
    <div class="form-group">
        <label for="username"><?php echo $admin_username; ?></label><input class="form-control" id="username" type="username" name="username" value="<?php
        if (isset($_GET["username"])) {
            echo $_GET["username"];
        }
        ?>" />
        <label for="password"><?php echo $admin_pass; ?></label><input class="form-control" id="password" type="password" name="password1" />
        <label for="confirmPassword"><?php echo $admin_confirmpass; ?></label><input class="form-control" id="confirmPassword" type="password" name="password2" />
    </div>

    <button type="submit" class="btn btn-primary"><?php echo $admin_add; ?></button>
</form>