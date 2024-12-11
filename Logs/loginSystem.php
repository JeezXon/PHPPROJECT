<?php
// Include the Login class
require __DIR__ . '/../Logs/login.php';
require __DIR__ . '/../Admin/Homepage.php';
require __DIR__ . '/../Databases/db_connect.php';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Create Login object with form inputs
    $login = new Login($_POST['uname'], $_POST['password']);

    // Validate login credentials
    if ($login->validate()) {
        // Redirect to a protected page or dashboard if successful
        header("../Admin/Homepage.php");
        exit();
    } else {
        // Pass error message to the URL to display on the form
        $error = $login->getError();
        header("Location: Homepage.php?error=" . urlencode($error));
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="../css/login.css">
</head>
<body>
    <form action="../Admin/Homepage.php" method="post">
        <h2>LOGIN</h2>
        <?php if (isset($_GET['error'])) { ?>
            <p class="error"><?php echo $_GET['error']; ?></p>
        <?php } ?>

        <label>Username</label>
        <input type="text" id="username" name="uname" placeholder="Username" required><br>

        <label>Password</label>
        <input type="password" id="password" name="password" placeholder="Password" required>

        <button type="submit">Login</button>
    </form>
</body>
</html>
