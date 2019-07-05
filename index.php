<?php 
 
// check connection
require_once 'connect.php';
 
session_start();
 
// check if users already logged in 
if(isset($_SESSION['user_id'])) {
    header('location:home.php');
    exit();
}
 
if( !empty($_POST) ) {
    $errors = array();
 
    $username = $_POST['username'];
    $password = $_POST['password'];
 
    if( empty($username) == true OR empty($password) == true ) {
        $errors[] = '* Username/Password field is required';
    } 
    else {
        // if username exists
        $sql = "SELECT * FROM employee WHERE username = '$username'";
        $query = $connect->query($sql);
        if( $query->num_rows > 0 ) {
            // check username and password
            $password = md5($password);
 
            $sql = "SELECT * FROM employee WHERE username = '$username' AND password = '$password'";
            $query = $connect->query($sql);
            $result = $query->fetch_array();
 
            $connect->close();
 
            if($query->num_rows == 1) {              
                $_SESSION['logged_in'] = true;
                $_SESSION['user_id'] = $result['id'];
 
                header('location:home.php');
                exit();
            }   
            else {
                $errors[] = ' * Username/Password combination is incorrect';
            }
        }   
        else {
            $errors[] = ' * Username doesn\'t exists';
        }
    }
 
}
 
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Safetyplus Consulting - Procedural PHP</title>
		<link rel="stylesheet" type="text/css" href="style.css"/>


	</head>	
	<body>

		<fieldset>
    <legend>Sign In</legend>
    <?php if(!empty($errors)) {?>
        <div class="error">
            <?php foreach ($errors as $key => $value) {
                echo $value;
            } ?>
        </div>
    <?php } ?>

		<!-- we are sending form data using post method 
				action represents where to send that data-->

		<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" >
	<div class="loginBox">

		<img src="user.png" class="user">
	
		<h2>SafetyPlus Consulting</h2>
		<form>
			<p>Username</p>
			<input type="text" name="username" id="username" placeholder="username" autocomplete="off"> 

			<p>Password</p>
			<input type="password" name ="password" id="password" placeholder="Enter Password" autocomplete="off">
			 <button type="submit">Sign In</button>
			


		</form>

	</fieldset>

	</body>	




</html>