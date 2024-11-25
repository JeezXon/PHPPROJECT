
<!DOCTYPE html>
<html>
<head>
<title>Login</title>
<link rel= "stylesheet" type="text/css" href="login.css">
</head>
<body>
      <form action="login.php" method="post">
        <h2>LOGIN</h2>
        <?php if(isset($_GET['error'])) { ?>
          <p class="error"><?php echo $_GET['error']; ?></p>
        <?php }?>
        <label>Username</label>
        <input type="text" id="username" name=uname placeholder="Username" required><br>

        <label>Password</label>
        <input type="password" id="password" name=password placeholder="Password" required>

        <button type="submit">Login</button> 
      </form>
</body>
</html>
