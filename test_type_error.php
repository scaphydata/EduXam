<?php
$password = "test";
$hash = null;
try {
    password_verify($password, $hash);
    echo "No error\n";
} catch (TypeError $e) {
    echo "Caught: " . $e->getMessage() . "\n";
}
?>
