<?php
require_once 'core/init.php';

$user = Database::getInstance()->update('users', 4, array(
    'name' => 'test name'
));