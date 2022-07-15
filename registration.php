<?php

    include 'database_access.php';

    $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname)
    or die('Bład połączenia z serwerem: '.mysqli_connect_error());
    
    mysqli_query($conn, 'SET NAMES utf8');

?>

<!DOCTYPE html>
<html>
<head>
	<title>Rejestracja | pracuj kreatywnie!</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8">

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,400;0,700;1,400;1,700&family=Mr+Dafoe&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="css/registration.css?v=<?php echo time(); ?>">
	<link rel="stylesheet" href="css/queries.css?v=<?php echo time(); ?>">

</head>
<body>
	<?php
		if(isset($_POST['login'])) {
			$czyLoginZajety = false;
			$result = mysqli_query($conn, "SELECT login FROM users");
			while($row = mysqli_fetch_array($result)) {
				if($_POST['login'] == $row['login']) $czyLoginZajety = true;                                                             
			}

			if($czyLoginZajety == false) {
				$login = stripslashes($_POST['login']);
				$email = stripslashes($_POST['email']);
				$password = stripslashes($_POST['password']);

				$result = mysqli_query($conn, "INSERT INTO users(login, email, password) VALUES ('$login', '$email', '$password')");

				if ($result) {
					echo "<script>alert('Udało ci się zarejestrować!');window.location.href='logowanie.php';</script>";
				}
				else {
					echo "nie udało się zarejestrować:(";
				}
			} else {
				echo "<script>alert('Login jest już zajęty!');history.go(-1);</script>";
			}	
		}
		else {
		?>

			<div class="navbar">
				<div class="logo">pracuj kreatywnie!</div>
				<div><a href="#register-form" class="form-btn form-link">Zarejestruj się</a></div>
			</div>

			<div class="main-content">
				<div class="main-text">
				<h1>Zacznij pracować kreatywnie już dziś!</h1>
				<p>Jesteśmy serwisem oferującym możliwość znalezienia zatrudnienia w branży kreatywnej. Wystarczy pare kliknięć, żebyś stał się bliższy swojej wymarzonej pracy.</p>
				</div>

			</div>

			<div class="gallery">
				<img src="img/main1.webp" alt="" class="main-img img1">
				<img src="img/main2.webp" alt="" class="main-img img2">
				<img src="img/main3.webp" alt="" class="main-img img3">
			</div>

			<?php

			echo '<div class="posts-container">';
				$result = mysqli_query($conn, "SELECT * FROM offers;");
				while($row = mysqli_fetch_array($result)) {
					echo '<div class="posts-row">';
							echo '<div class="posts-row-element pre-title">'.$row['name'].'</div><div class="posts-row-element pre-content">'.$row['content'].'</div>';
							echo '<div class="posts-row-element"><a class="follow-link "href="login.php"><div class="follow">Obserwuj <ion-icon name="star-outline" class="favourite-icon"></ion-icon></div></a></div>';
					echo '</div>';
				};
			echo '</div>';

			?>

			<div class="bg">
				<div class="form-container" id="register-form">
					<p class="form-heading">Dołącz do nas i rozpocznij szukanie!</p>
					<form class="form" action="" method="post">
						<input type="text" name="login" placeholder="Login" required class="form-field">
						<input type="password" name="password" placeholder="Hasło" required class="form-field pswd-field">
						<input type="text" name="email" placeholder="E-mail" required class="form-field">
						<input type="submit" value="Zarejestruj się" class="form-btn">
					</form>
					<p class="login-option">Posiadasz już konto? <a href="login.php">Zaloguj się</a></p>
				</div>
			</div>

		<?php 
		}
		?>


<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>