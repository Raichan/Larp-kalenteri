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

<h3>Delete account: <?php echo getUsernameOfAnAdmin($adminId); ?></h3>

<form role="form" action="editAdminValidate.php" method="post">
    <div class="form-group">
        <label for="password">Password</label>
        <input class="form-control" id="password" type="password" name="password" />
        <input type="hidden" name="adminId" value="<?php echo $adminId; ?>">
        <input type="hidden" name="action" value="<?php echo $action; ?>">
    </div>
    <button type="submit" class="btn btn-danger">Delete</button>
</form>