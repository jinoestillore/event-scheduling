<?php
require 'config.php';

session_start();

$conn = mysqli_connect("localhost", "root", "", "user-db");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if(isset($_POST["submit"])){
  $username = $_POST["username"]; 
  $password = $_POST["password"];
  
  $result = mysqli_query($conn, "SELECT * FROM `users` WHERE username = '$username' OR email = '$username'");
  $row = mysqli_fetch_assoc($result);
  
  if(mysqli_num_rows($result) > 0){
    if($password == $row["password"]){
      $_SESSION["login"] = true;
      $_SESSION["username"] = $row['username'];
      $_SESSION['email'] = $row['email'];
      $_SESSION["user_id"] = $row["user_id"];
      $_SESSION['profile_pic'] = $row['profile_pic'];
      echo "<script>
             alert('Login Successful!');
             window.location.href = 'homepage.php';
            </script>";
    }
    else {
        echo "<script>
               alert('Password is incorrect!');
               window.history.back();
              </script>";
    }
  }
  else {
    echo "<script>
           alert('No user exist!');
           window.history.back();
          </script>";
  }
}
?>
