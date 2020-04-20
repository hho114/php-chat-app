
<?php
//Create a new User page

session_start();

//if user already login go to chat page
if (isset($_SESSION['name'])) {
	header("Location: http://ecs.fullerton.edu/~cs431s42/assignment3/chat.html");
}

$db = mysqli_connect('mariadb', 'cs431s42', '' ,'cs431s42');
// $db = mysqli_connect('localhost', 'root', 'root', 'chat_db');
$message = '';

if (!empty($_POST['name'])) :
    $token_id = session_id();//use session id to make sure no indenticaly account for security 

	// Enter the new user in the database

	$query = "INSERT INTO user (name, token_id) VALUES (?,?)";

	$stmt = $db->prepare($query);

	$stmt->bind_param('ss', $_POST['name'],$token_id);

	if ($stmt->execute()) :
		$name = $_POST['name'];
		$message = 'Successfully created new user';
		$_SESSION['name'] = $_POST['name'];
		$query = "SELECT uid FROM user WHERE name = '$name' AND token_id = '$token_id'";
		$res = mysqli_query($db, $query);
		$res = mysqli_fetch_assoc($res);
		$_SESSION['uid'] = (int) $res['uid'];
		//if user create success then go to chat page
		header("Location: http://ecs.fullerton.edu/~cs431s42/assignment3/chat.html");
	else :
		$message = 'Sorry there must have been an issue creating your account';
	endif;

endif;



?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link href='http://fonts.googleapis.com/css?family=Comfortaa' rel='stylesheet' type='text/css'>
</head>

<body>

	<div class="header">
		<h3>Let's Chat</h3>
	</div>

	<?php if (!empty($message)) : ?>
		<p><?= $message ?></p>
	<?php endif; ?>

	<div class="row">
		<div class="col-md-2 col-md-offset-5">


			<form action="index.php" method="POST">

				<input type="text" placeholder="Enter your name" name="name">
				<br>
				<br>
				<input class="btn btn-primary" type="submit" value="Start">

			</form>

		</div>
	</div>



</body>

</html>