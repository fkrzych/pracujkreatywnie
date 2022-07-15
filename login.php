<?php

    include 'database_access.php';

    $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname)
    or die('Bład połączenia z serwerem: '.mysqli_connect_error());
    
    mysqli_query($conn, 'SET NAMES utf8');
	
?>

<!DOCTYPE html>
<html>
<head>
	<title>Logowanie | pracuj kreatywnie!</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8">

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,400;0,700;1,400;1,700&family=Mr+Dafoe&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="css/login.css?v=<?php echo time(); ?>">
	<link rel="stylesheet" href="css/registration.css?v=<?php echo time(); ?>">
	<link rel="stylesheet" href="css/queries.css?v=<?php echo time(); ?>">

</head>
<body>
	<?php
		session_start();
		if(isset($_POST['login'])) {
			$login = stripslashes($_POST['login']);
			$password = stripslashes($_POST['password']);

			$result = mysqli_query($conn, "SELECT user_id FROM users WHERE login='$login' AND password='$password'");

			$rows = mysqli_num_rows($result);

			if ($rows == 1) {
				$_SESSION['login'] = $login;
				header("Location: index.php");
			}
			else {
				echo "<script>alert('Niepoprawny login lub hasło!');window.location.href='login.php';</script>";
			}
		}
		else {
		?>
			<div class="navbar">
				<a href="registration.php" class="logo-link"><div class="logo">pracuj kreatywnie!</div></a>
				<div><a href="registration.php#register-form" class="form-btn form-link">Zarejestruj się</a></div>
			</div>


			<div class="login-container">
				<form action="" method="post">
					<h1>Logowanie</h1>
					<input type="text" name="login" placeholder="login" class="login-field" required>
					<input type="password" name="password" placeholder="hasło" class="login-field" required>
					<input type="submit" value="Zaloguj się" class="login-btn">
				</form>
			</div>

		<?php 
		}
		?>

</body>
