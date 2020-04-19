<?php

session_start();

require 'database.php';


if (isset($_SESSION['name'])) {

	$records = $conn->prepare('SELECT id,name FROM user WHERE name = :name');
	$records->bindParam(':name', $_SESSION['name']);
	$records->execute();
	$results = $records->fetch(PDO::FETCH_ASSOC);

	$user = NULL;

	if (count($results) > 0) {
		$user = $results;
		$_SESSION['id'] = $results['id'];
	}
}

?>

<!DOCTYPE html>
<html>

<head>
	<title>Welcome to Let's Chat App</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link href='http://fonts.googleapis.com/css?family=Comfortaa' rel='stylesheet' type='text/css'>
</head>

<body>

	<div class="header">
		<a href="/">Your App Name</a>
	</div>

	<?php if (!empty($user)) : ?>

		<br />Welcome <?= $user['name']; ?>
		<br /><br />You are successfully logged in!
		<br /><br />
		<a href="logout.php">Logout?</a>
		

	<?php else : ?>

		<h1>Please Login or Register</h1>


	<?php endif; ?>

</body>

</html>