<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Account</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h1 style="margin-bottom: 20px;">REGISTER ACCOUNT</h1>
            <form class="reg-form" method="post" action="reg.php" enctype="multipart/form-data">
                <div class="input-group">
                    <label for="username" style="font-weight: bold;">Username:</label>
                    <input type="text" class="input-username" id="username" name="username" placeholder="Enter your username" required>
                </div>

                <div class="input-group">
                    <label for="password" style="font-weight: bold;">Password:</label>
                    <input type="password" class="input-password" id="password" name="password" placeholder="Enter your password" required>
                </div>

                <div class="input-group">
                    <label for="cpassword" style="font-weight: bold;">Confirm Password:</label>
                    <input type="password" class="input-password" id="cpassword" name="cpassword" placeholder="Confirm your password" required>
                </div>

                <div class="input-group">
                    <label for="email" style="font-weight: bold;">Email:</label>
                    <input type="email" class="input-email" id="email" name="email" placeholder="Enter your email" required>
                </div>
                
                <div class="input-group">
                    <label for="profile_pic" style="font-weight: bold;">Profile Picture:</label>
                    <input type="file" class="input-file" id="profile_pic" name="profile_pic" accept="image/*">
                </div>
                
                
                    <button type="submit" name="submit" class="register-btn" style="font-weight: bold;">REGISTER</button>
                
                    <div class="extras">
                    <p>Already have an account? <a href="login.php" style="margin-top: 10px;">Login here</a></p>
                    </div>
                
            </form>
        </div>
    </div>
</body>
</html>
