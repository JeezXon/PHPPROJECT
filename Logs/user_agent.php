
<!DOCTYPE html>
<html>
<head>
<title>Login</title>
<link rel= "stylesheet" type="text/css" href="login.css">
</head>
<body>
      <form action="Home.php" method="post">
        <h2>AGENT LOGIN</h2>
        <?php if(isset($_GET['error'])) { ?>
          <p class="error"><?php echo $_GET['error']; ?></p>
        <?php }?>
        <label>Username</label>
        <input type="text" name=uname placeholder="Username" required><br>

        <label>Password</label>
        <input type="password" name=password placeholder="Password" required>

        <button type="submit">Login</button>
        <button type="button" onclick="window.location.href='loginSystem.php'">ADMIN</button>
      </form>
</body>
</html>
