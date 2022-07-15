<?php 

    include 'database_access.php';

    $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname)
    or die('Bład połączenia z serwerem: '.mysqli_connect_error());
    
    mysqli_query($conn, 'SET NAMES utf8');

    include 'login_authorization.php';

?>


<!DOCTYPE html>
<html>
<head>
	<title>pracuj kreatywnie!</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8">

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,400;0,700;1,400;1,700&family=Mr+Dafoe&display=swap" rel="stylesheet">

	
	<link rel="stylesheet" href="css/registration.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="css/style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="css/queries.css?v=<?php echo time(); ?>">

</head>
<body>
<?php
        $result = mysqli_query($conn, "SELECT user_id FROM users WHERE login='".$_SESSION['login']."'");
        while($row = mysqli_fetch_array($result)) {
            $user_id = $row['user_id'];
        }
    ?>

    <div class="navbar">
		<div class="logo">pracuj kreatywnie!</div>

        <div class="nav-btns">
		    <button class="add-post form-btn">Dodaj ofertę</button>
            <div class="favourites-btn"><span>Obserwowane</span><ion-icon name="star-outline" class="favourite-icon"></ion-icon></div>
            <div class="user-info">
                <ion-icon name="person-outline"></ion-icon>
                <p class="user-info-text"><?php echo $_SESSION['login'].", id: ".$user_id ?></p>
            </div>
            <p><a href="logout.php" class="form-btn logout-btn">Wyloguj się</a></p>
        </div>
	</div>

    <div class="form-container hidden">
        <form action="" method="POST" class="post-form hidden">
            <div class="close-adding-btn">&times;</div>
            Podaj tytuł: <input type="text" name="name" class="form-field" required> <br>
            Podaj treść: <input type="text" name="content" class="form-field" required> <br>
            <input type="hidden" name="offer_id"> <br>
            <input type="submit" value="Dodaj" class="form-btn add-post-btn"> <br>
        </form>
    </div>

    <?php
        if(isset($_POST['content'])) mysqli_query($conn, "INSERT INTO offers (name, content, author) VALUES ('".$_POST['name']."', '".$_POST['content']."', $user_id);");

        $isFollowed = false;
        if(isset($_GET['follow'])) {
            $result3 = mysqli_query($conn, "SELECT * FROM followed_offers;");
            while($row = mysqli_fetch_array($result3)) {
                if($_GET['follow'] == $row['offer_id'] && $row['user_id'] == $user_id) $isFollowed = true;
            }
            if($isFollowed == false) mysqli_query($conn, "INSERT INTO followed_offers(offer_id, user_id) VALUES (".$_GET['follow'].", $user_id);");
        }

        if(isset($_GET['delete_offer'])) {
            mysqli_query($conn, "DELETE FROM followed_offers WHERE offer_id=".$_GET['delete_offer'].";");
            mysqli_query($conn, "DELETE FROM offers WHERE offer_id=".$_GET['delete_offer'].";");
        }

        if(isset($_GET['unfollow'])) mysqli_query($conn, "DELETE FROM followed_offers WHERE offer_id=".$_GET['unfollow'].";");
        echo '<div class="posts-container favourite-posts-container hidden">';
            $result2 = mysqli_query($conn, "SELECT * FROM offers JOIN followed_offers ON followed_offers.offer_id=offers.offer_id WHERE user_id=".$user_id);
            while($row = mysqli_fetch_array($result2)) {
                echo '<div class="posts-row favourites-posts-row">';
                    echo '<div class="posts-row-element pre-title">'.$row['name'].'</div><div class="posts-row-element pre-content">'.$row['content'].'</div>';
                    echo '<div class="posts-row-element pre-title"><a class="follow-link unfollow-link" href="index.php?unfollow='.$row['offer_id'].'">Nie obserwuj <ion-icon name="close-circle-outline" class="favourite-icon"></ion-icon></a></div>';
                echo '</div>';
            };
        echo '</div>';

        echo '<div class="posts-container">';
            $result = mysqli_query($conn, "SELECT * FROM offers;");
            while($row = mysqli_fetch_array($result)) {
                echo '<div class="posts-row">';
                        echo '<div class="posts-row-element pre-title">'.$row['name'].'</div><div class="posts-row-element pre-content">'.$row['content'].'</div>';
                        echo '<div class="posts-row-element"><a class="follow-link "href="index.php?follow='.$row['offer_id'].'"><div class="follow">Obserwuj <ion-icon name="star-outline" class="favourite-icon"></ion-icon></div></a></div>';
                        if($row['author']==$user_id) {
                            echo '<div class="posts-row-delete"><a class="delete-link" href="index.php?delete_offer='.$row['offer_id'].'">&times;</a></div>';
                        }
                echo '</div>';
            };
        echo '</div>';

	?>

<script src="js/script.js"></script>
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>