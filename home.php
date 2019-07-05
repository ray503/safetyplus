<?php 
 
require_once 'connect.php';
session_start();
 
// check if user is not logged in 
if(empty($_SESSION['user_id'])) {
    header('location:index.php');
    exit();
}
 
if(isset($_SESSION['user_id'])) { ?>
 
 
<?php 
$user_id = $_SESSION['user_id'];
 
$sql = "SELECT * FROM employee WHERE id = $user_id";
$query = $connect->query($sql);
$result = $query->fetch_array();
 
// close database connection
$connect->close();
 
?>
 
<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
</head>
<body>
 
<ul>
    <li>Hello, <?php echo $result['username'] ?> </li>
    <li><a href="logout.php">Logout</a></li>
</ul>
 
</body>
</html>
 
<?php
}
?>