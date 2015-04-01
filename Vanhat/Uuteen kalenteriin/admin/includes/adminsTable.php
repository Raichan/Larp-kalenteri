<?php
require_once './../dat/controller.php';
require_once './../dat/cAdmin.php';

switch ($error) {
    case 5: {
            $message = "<div class='alert alert-success'>";
            $message .= $admin_deletesuccess;
            $message .= "</div>";
            echo $message;
            break;
        }
    case 6: {
            $message = "<div class='alert alert-warning'>";
            $message .= $admin_passnomatch;
            $message .= "</div>";
            echo $message;
            break;
        }
    case 66: {
            $message = "<div class='alert alert-warning'>";
            $message .= $admin_shortpass;
            $message .= "</div>";
            echo $message;
            break;
        }
    case 7: {
            $message = "<div class='alert alert-success'>";
            $message .= $admin_passmodsuccess;
            $message .= "</div>";
            echo $message;
            break;
        }
    case 8: {
            $message = "<div class='alert alert-danger'>";
            $message .= $admin_error;
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
                <?php echo $admin_name; ?>
            </th>
            <th>
                <?php echo $admin_surname; ?>
            </th>
            <th>
                <?php echo $admin_email; ?>
            </th>
            <th>
                <?php echo $admin_username; ?>
            </th>
            <th>
                <?php echo $admin_action; ?>
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