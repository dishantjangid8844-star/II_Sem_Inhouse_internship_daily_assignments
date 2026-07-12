<form method="post">
    <input type="radio" name="gender" value="Male"> Male
    <input type="radio" name="gender" value="Female"> Female
    <button>Submit</button>
</form>

<?php
echo $_POST['gender'] ?? "Not selected";
?>