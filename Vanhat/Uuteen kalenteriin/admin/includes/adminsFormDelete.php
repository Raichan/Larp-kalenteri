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

<h3><?php echo $admin_deletetitle . " " . getUsernameOfAnAdmin($adminId); ?></h3>

<form role="form" action="editAdminValidate.php" method="post">
    <div class="form-group">
        <label for="password"><?php echo $admin_pass; ?></label>
        <input class="form-control" id="password" type="password" name="password" />
        <input type="hidden" name="adminId" value="<?php echo $adminId; ?>">
        <input type="hidden" name="action" value="<?php echo $action; ?>">
    </div>
    <button type="submit" class="btn btn-danger"><?php echo $admin_delete; ?></button>
</form>