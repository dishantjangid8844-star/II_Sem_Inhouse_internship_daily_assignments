<form method="post">
    <input type="checkbox" name="agree"> I Agree
    <button>Submit</button>
</form>

<?php
if (isset($_POST['agree'])) {
    echo "Agreed";
} else {
    echo "Not agreed";
}
?>