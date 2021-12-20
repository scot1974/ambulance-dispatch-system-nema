<?php
spl_autoload_register(function($classname) {
    // convert string to lowercase
    $classname = strtolower($classname);
    require_once ROOT_DIRECTORY . "assets/core/class/".$classname.".class.php";
});

