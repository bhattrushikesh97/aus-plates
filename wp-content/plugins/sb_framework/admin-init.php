<?php
/*Load the embedded Redux Framework*/
if (file_exists(dirname(__FILE__) . '/redux-framework/framework.php')) {
    require_once dirname(__FILE__) . '/redux-framework/framework.php';
}

// Load Redux extensions
if (file_exists(dirname(__FILE__) . '/redux-extensions/extensions-init.php')) {
   // require_once dirname(__FILE__) . '/redux-extensions/extensions-init.php';
}