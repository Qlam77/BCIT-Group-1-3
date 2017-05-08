<?php
session_start();
require_once('config.php');
$check_auth = false;

if ($_POST) {
	$username = $_POST['username'];
	$password = $_POST['password'];

	$conn = get_db_connection();
	$stmt = $conn->prepare("SELECT Password From User WHERE Username=:thisuser");
	$stmt->bindParam(':thisuser', $username);
	$stmt->execute();
	$stmt->setFetchMode(PDO::FETCH_ASSOC); 
	$result = $stmt->fetch();
	$hash = $result['Password'];
	if (password_verify($password, $hash)){
		$_SESSION['username'] = $username;
		$check_auth = true;
		$auth = true;
		header('Location: /main1.php');
	} else {
		$check_auth = true;
		$auth = false;
	}
}

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Login</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="css/login.css"/>
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		
		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
		
		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
		<meta charset="utf-8">
	</head>
	<body>
    <div class="container">
      <form class="form-signin" action="login.php" method="POST">
        <h2 class="form-signin-heading">Please sign in:</h2>
        <label for="inputUsername" class="sr-only">Username</label>
        <input type="text" name="username" id="inputUsername" class="form-control" placeholder="Username" required autofocus>
		<?php
		if ($check_auth && !$auth)
			echo 'Invalid username or password'
		?>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
        <div class="checkbox">
          <label>
            <input type="checkbox" value="remember-me"> Remember me
          </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" value="Login" type="submit">Sign in</button>
      </form>
    </div> <!-- /container -->
    <footer class="navbar-fixed-bottom">Copyright &#9400; 2017 Riolet Corporation</footer>
	</body>
</html>
