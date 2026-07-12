<?php
$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $fullName    = trim($_POST['fullName'] ?? '');
    $emailAddress = trim($_POST['emailAddress'] ?? '');
    $phoneNumber = trim($_POST['phoneNumber'] ?? '');
    $gender      = $_POST['gender'] ?? '';
    $course      = $_POST['course'] ?? '';
    $address     = trim($_POST['address'] ?? '');

    // ---------------- VALIDATION ----------------

    // Name: required, and must not contain digits
    if ($fullName === '') {
        $errors[] = "Full name is required.";
    } elseif (preg_match('/[0-9]/', $fullName)) {
        $errors[] = "Full name should not contain numbers.";
    }

    // Email: required and must be a valid format
    if (!filter_var($emailAddress, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
    }

    // Phone: must be exactly 10 digits
    if (!ctype_digit($phoneNumber) || strlen($phoneNumber) !== 10) {
        $errors[] = "Phone number must be exactly 10 digits.";
    }

    // Gender: required
    if ($gender === '') {
        $errors[] = "Please select a gender.";
    }

    // Course: required
    if ($course === '') {
        $errors[] = "Please select a course.";
    }

    // Address: required, minimum length
    if (strlen($address) < 10) {
        $errors[] = "Address must be at least 10 characters long.";
    }

    if (empty($errors)) {
        $success = true;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrollment Result</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f2f5f9;
        }
        .result-card {
            max-width: 600px;
            margin: 50px auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.08);
            padding: 30px;
        }
    </style>
</head>
<body>

<div class="result-card">

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <h5>Please fix the following before we can enroll you:</h5>
            <ul class="mb-0">
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <a href="register.html" class="btn btn-outline-primary">Back to Form</a>
    <?php elseif ($success): ?>
        <div class="alert alert-success">
            <h5>Welcome, <?= htmlspecialchars($fullName) ?>! Your enrollment was received.</h5>
        </div>

        <table class="table">
            <tr><th>Full Name</th><td><?= htmlspecialchars($fullName) ?></td></tr>
            <tr><th>Email</th><td><?= htmlspecialchars($emailAddress) ?></td></tr>
            <tr><th>Phone</th><td><?= htmlspecialchars($phoneNumber) ?></td></tr>
            <tr><th>Gender</th><td><?= htmlspecialchars($gender) ?></td></tr>
            <tr><th>Course</th><td><?= htmlspecialchars($course) ?></td></tr>
            <tr><th>Address</th><td><?= htmlspecialchars($address) ?></td></tr>
        </table>

        <a href="register.html" class="btn btn-outline-primary">Enroll Another Student</a>
    <?php else: ?>
        <div class="alert alert-warning">
            This page only responds to a form submission. <a href="register.html">Go to the enrollment form</a>.
        </div>
    <?php endif; ?>

</div>

</body>
</html>
