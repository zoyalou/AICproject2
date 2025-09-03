<!DOCTYPE html>
  <html lang="en">
  <head>
      <title>New Account</title>
      <link rel="stylesheet" href="login.css">
  </head>
  <body>
    <!-- where a new customer goes to create a new account -->
    <div class="inputbox">
      <h1>Create an Account</h1>
      <form action="acccreated.php" method="post">
              <label for="username">Username: </label> <br>
              <input type="text" id="username" placeholder="Enter Username" name="username" required>
  
              <br><br>
                <label for="pswrd">Password: </label> <br>
                <input type="password" id="password" placeholder="Enter Password" name="password" required>

              <br><br>
              <a href="homepage.php">Back</a>
              <input type='submit' id='create' value='Create'>
            
      </form>
    </div>
  </body>
  </html>