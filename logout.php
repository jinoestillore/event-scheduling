<?php 
session_start();

echo "<script>
alert('Logout Successful!');
window.location.href = 'login.php';
</script>";

session_destroy();

?>
