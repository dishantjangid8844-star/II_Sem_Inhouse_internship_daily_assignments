<form method="post">
    <input type="checkbox" name="skills[]" value="HTML"> HTML
    <input type="checkbox" name="skills[]" value="CSS"> CSS
    <input type="checkbox" name="skills[]" value="PHP"> PHP
    <button>Submit</button>
</form>

<?php
if (!empty($_POST['skills'])) {
    foreach ($_POST['skills'] as $skill) {
        echo $skill . "<br>";
    }
}
?>