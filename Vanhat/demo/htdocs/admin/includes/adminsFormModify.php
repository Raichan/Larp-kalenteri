<?php
if (isset($_GET["adminId"])) {
    $adminId = $_GET["adminId"];
} else {
    $adminId = "";
}

if (isset($_GET["action"])) {
    $action = $_GET["action"];
} else {
    $action = "";
}
?>

<h3>Modify password for account: <?php echo getUsernameOfAnAdmin($adminId); ?></h3>

<form role="form" action="editAdminValidate.php" method="post">
    <div class="form-group">
        <label for="password">Current password</label>
        <input class="form-control" id="password" type="password" name="currentPassword" />
        <label for="password">New password</label>
        <input class="form-control" id="password" type="password" name="newPassword1" />
        <label for="password">Re-enter new password</label>
        <input class="form-control" id="password" type="password" name="newPassword2" />
        <input type="hidden" name="adminId" value="<?php echo $adminId; ?>">
        <input type="hidden" name="action" value="<?php echo $action; ?>">
    </div>
    <button type="submit" class="btn btn-warning">Modify</button>
</form>