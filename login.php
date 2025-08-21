<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Account</title>
    <link rel="stylesheet" href="login.css">

</head>
<body>
    <div class="login-container">
      <div class="login-box">
        <h1 style="margin-bottom: 20px;">LOGIN ACCOUNT</h1>

       <form class="login-form" method="post" action="log.php">
            <div class="input-group">
             <label for="username" style="font-weight: bold;">Username:</label>
             <input type="text" class="input-username" id="username" name="username" placeholder="Enter your username" required>
            </div>

            <div class="input-group">
             <label for="username" style="font-weight: bold;">Password:</label>
             <input type="password" class="input-password" id="password" name="password" placeholder="Enter your password" required>
            </div>

            <div class="checkPass">
             <input type="checkbox" id="check">
             <label for="check">Show Password</label>
            </div>
            
             <button type="submit" name="submit" class="login-btn">LOGIN</button>
       </form>
             <div class="extras">
              <a href="#" class="forgot-password">Forgot Password?</a><br />
              <p>Don't have an account? <a href="registration.php">Register here</a></p>
             </div>

      </div>

    </div>

    <script type="text/JavaScript">

      const pwd = document.getElementById("password");
      const chk = document.getElementById("check");

      chk.onchange = function (e) {
        pwd.type = chk.checked ? "text" : "password";
      };
      
    </script>
</body>
</html>