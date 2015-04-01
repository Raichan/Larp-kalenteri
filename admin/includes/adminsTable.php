<?php
require_once './../dat/controller.php';
require_once './../dat/cAdmin.php';

switch ($error) {
    case 5: {
            $message = "<div class='alert alert-success'>";
            $message .= "Admin account was deleted successfully.";
            $message .= "</div>";
            echo $message;
            break;
        }
    case 6: {
            $message = "<div class='alert alert-warning'>";
            $message .= "* Provided password doesn't match. Please try again.";
            $message .= "</div>";
            echo $message;
            break;
        }
    case 66: {
            $message = "<div class='alert alert-warning'>";
            $message .= "* Password must be at least 5 characters long.";
            $message .= "</div>";
            echo $message;
            break;
        }
    case 7: {
            $message = "<div class='alert alert-success'>";
            $message .= "Password modified successfully.";
            $message .= "</div>";
            echo $message;
            break;
        }
    case 8: {
            $message = "<div class='alert alert-danger'>";
            $message .= "* An error has occured. Please, check the provided passwords and try again.";
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

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>
                Name
            </th>
            <th>
                Surname
            </th>
            <th>
                E-mail
            </th>
            <th>
                Username
            </th>
            <th>
                Action
            </th>
        </tr>
    </thead>
    <tbody>

        <?php
        /* Get list of admin usernames in the database. */
        $listOfAdmins = getListOfAdmins();
        /* For each username get new cAdmin object with the data. */
        $admins = null;
        if ($listOfAdmins != null) {
            foreach ($listOfAdmins as $username) {
                $a = getCadminObject($username);
                if ($a != null) {
                    $admins[] = $a;
                }
            }
        }
        /* For each cAdmin object generate a table row. */
        if ($admins != null) {
            foreach ($admins as $admin) {
                echo $admin->getAdminTableRow();
            }
        }
        ?>

    </tbody>
</table>