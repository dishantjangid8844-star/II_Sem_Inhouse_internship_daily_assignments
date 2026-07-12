<?php
echo "Page loaded at: " . date("H:i:s");

echo "<br>";

$name = $_POST['name'] ?? "Guest";
echo "Welcome $name";
?>