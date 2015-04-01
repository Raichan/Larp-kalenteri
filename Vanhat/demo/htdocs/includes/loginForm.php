<h3>
    Login
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
            $message .= "* <b>Bad login.</b>";
            $message .= "</div>";
            echo $message;
            break;
        }
    case 2: {
            $message = "<div class='alert alert-warning'>";
            $message .= "* <b>Please login</b> using username and password.";
            $message .= "</div>";
            echo $message;
            break;
        }
    case 3: {
            $message = "<div class='alert alert-warning'>";
            $message .= "* You forgot something. <b>Please login</b> using username and password.";
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
        <label for="exampleInputEmail1">Username</label><input class="form-control" id="exampleInputEmail1" type="username" name="username" />
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">Password</label><input class="form-control" id="exampleInputPassword1" type="password" name="password" />
    </div>
    <button type="submit" class="btn btn-default">Login</button>
</form>