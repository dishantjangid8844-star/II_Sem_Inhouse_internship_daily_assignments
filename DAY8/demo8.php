<form method="post">
    <select name="branch">
        <option value="">Select</option>
        <option value="CSE">CSE</option>
        <option value="IT">IT</option>
    </select>
    <button>Submit</button>
</form>

<?php
if (!empty($_POST['branch'])) {
    echo "Branch: " . $_POST['branch'];
}
?>