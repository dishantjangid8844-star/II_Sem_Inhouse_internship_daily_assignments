<?php
$students = ["Amit", "Neha", "Ravi"];
?>

<ul>
<?php foreach ($students as $s) { ?>
    <li><?= $s ?></li>
<?php } ?>
</ul>