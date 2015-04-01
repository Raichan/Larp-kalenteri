<h3>Add new admin</h3>

<?php
switch ($error) {
    case 0: {
            $message = "<div class='alert alert-success'>";
            $message .= "New user successfully added.";
            $message .= "</div>";
            echo $message;
            break;
        }
    case 1: {
            $message = "<div class='alert alert-warning'>";
            $message .= "* All the fields are mandatory.";
            $message .= "</div>";
            echo $message;
            break;
        }
    case 2: {
            $message = "<div class='alert alert-warning'>";
            $message .= "* Username already exists. Please choose another one.";
            $message .= "</div>";
            echo $message;
            break;
        }
    case 3: {
            $message = "<div class='alert alert-warning'>";
            $message .= "* Provided passwords don't match.";
            $message .= "</div>";
            echo $message;
            break;
        }
    case 33: {
            $message = "<div class='alert alert-warning'>";
            $message .= "* Password must be at least 5 characters long.";
            $message .= "</div>";
            echo $message;
            break;
        }
    case 4: {
            $message = "<div class='alert alert-danger'>";
            $message .= "* An error has occured. Please try again later.";
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
        <label for="name">Name</label><input class="form-control" id="name" type="text" name="name" value="<?php
        if (isset($_GET["name"])) {
            echo $_GET["name"];
        }
        ?>" />
        <label for="surname">Surname</label><input class="form-control" id="surname" type="text" name="surname" value="<?php
        if (isset($_GET["surname"])) {
            echo $_GET["surname"];
        }
        ?>" />
        <label for="email">E-mail</label><input class="form-control" id="email" type="email" name="email" value="<?php
        if (isset($_GET["email"])) {
            echo $_GET["email"];
        }
        ?>" />
    </div>
    <div class="form-group">
        <label for="username">Username</label><input class="form-control" id="username" type="username" name="username" value="<?php
        if (isset($_GET["username"])) {
            echo $_GET["username"];
        }
        ?>" />
        <label for="password">Password</label><input class="form-control" id="password" type="password" name="password1" />
        <label for="confirmPassword">Confirm password</label><input class="form-control" id="confirmPassword" type="password" name="password2" />
    </div>

    <button type="submit" class="btn btn-primary">Add</button>
</form>