<!DOCTYPE html>
  <html lang="en">
  <head>
      <title>Admin Login</title>
      <link rel="stylesheet" href="login.css">
  </head>
  <body>
    <!-- this is where admins login -->
    <div class="inputbox">
      <h1>Admin Login</h1>
      <!-- here is the form for admins to enter their username and password -->
      <form action="adminstore.php" method="post">
              <label for="username">Username: </label> <br>
              <input type="text" id="username" placeholder="Enter Username" name="username" required>
  
              <br><br>
                <label for="password">Password: </label> <br>
                <input type="password" id="password" placeholder="Enter Password" name="password" required>

              <br><br>
              <a href="homepage.php">Back</a>
              <input type="submit" value="Log In">
      </form>
      <?php
       if (isset($_SESSION['admin'])) { //if the admin is already in session, then it takes the admin directly to the store
         header("Location: adminstore.php");
       }
      ?>
    </div>

  </body>
  </html>
  