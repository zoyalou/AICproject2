<!DOCTYPE html>
  <html lang="en">
  <head>
      <title>Customer Login</title>
      <link rel="stylesheet" href="login.css">
  </head>
  <body>
    <!-- this is where customers login -->
     <?php
    //  if customer is already in session, then it takes the customer directly to the itemsinstore page
        if (isset($_SESSION['customer'])) {
          header("Location: itemsinstore.php");
        }
     ?>
     <div class="inputbox">
      <h1>Customer Login</h1>
      <!-- here is the form for customers to put their username and password -->
      <form  id="myForm" action="itemsinstore.php" method="post">
              <label for="username">Username: </label> <br>
              <input type="text" id="username" placeholder="Enter Username" name="username" required>
  
              <br><br>
                <label for="password">Password: </label> <br>
                <input type="password" id="password" placeholder="Enter Password" name="password" required>

              <br><br>
              <a href="homepage.php">Back</a>
              <input type="submit" value="Log In ">
           
      </form>
     </div>
  </body>
  </html>
  