<?php require_once 'assets/core/init.php'; ?>
<?php
// $user->logout();
    if (!loggedIn()) {
        redirectTo('login.php');
    }
?>
<?php include_once 'assets/inc/_head.php';  ?>
    <?php if (isAdmin()): ?>
        <?php include_once 'assets/inc/admin.php'; ?>
    <?php else: ?>
        <?php include_once 'assets/inc/dispatcher.php'; ?>
    <?php endif ?>
<?php //include_once 'assets/inc/_footer.php'; ?>
