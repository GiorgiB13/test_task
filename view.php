<!DOCTYPE html>
<html>
<head>
    <title>Form Submission</title>
</head>
<body>
<?php
// Display any success message from session
if (isset($_SESSION['message'])) {
    echo '<p>' . $_SESSION['message'] . '</p>';
    unset($_SESSION['message']);
}

// Display the saved data
if (isset($savedContent)) {
    echo '<p>Saved Data:</p>';
    echo '<textarea readonly rows="4" cols="50">' . htmlspecialchars($savedContent) . '</textarea>';
}
?>

<form method="POST" action="">
    <input type="hidden" name="csrf_token" value="<?php echo $this->getCSRFToken(); ?>">
    <textarea name="content" rows="4" cols="50"></textarea><br>
    <input type="submit" value="Submit">
</form>
</body>
</html>
