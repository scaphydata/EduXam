<?php
$_SERVER['REQUEST_METHOD'] = 'POST';
$_POST['username'] = 'newuser';
$_POST['email'] = 'newuser@example.com';
$_POST['password'] = 'password123';
$_POST['csrf_token'] = 'dummy';
session_start();
$_SESSION['csrf_token'] = 'dummy';

try {
    require_once __DIR__ . '/php/inscription.php';
    echo "\nSuccess!\n";
} catch (Throwable $e) {
    echo "\nERROR: " . $e->getMessage() . " in " . $e->getFile() . " on line " . $e->getLine() . "\n";
}
?>
