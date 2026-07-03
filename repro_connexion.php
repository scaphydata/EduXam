<?php
$_SERVER['REQUEST_METHOD'] = 'POST';
$_POST['username'] = 'admin';
$_POST['password'] = 'admin123';
$_POST['csrf_token'] = 'dummy';
session_start();
$_SESSION['csrf_token'] = 'dummy';

try {
    require_once __DIR__ . '/php/connexion.php';
    echo "\nSuccess!\n";
} catch (Throwable $e) {
    echo "\nERROR: " . $e->getMessage() . " in " . $e->getFile() . " on line " . $e->getLine() . "\n";
}
?>
