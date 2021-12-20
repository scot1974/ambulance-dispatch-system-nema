<?php require_once 'assets/core/init.php'; ?>
<?php
    if (loggedIn()) {
        if (isAdmin()) {
            if ($user->logout()) {
                redirectTo('login.php');
            }
        }
    }
    redirectTo('login.php');
?>