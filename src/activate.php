<?php
include 'main.php';
$msg = '';
// check if mail and code exist
if (isset($_GET['email'], $_GET['code']) && !empty($_GET['code'])) {
	$stmt = $pdo->prepare('SELECT * FROM accounts WHERE email = ? AND activation_code = ?');
	$stmt->execute([ $_GET['email'], $_GET['code'] ]);
	// store result
	$account = $stmt->fetch(PDO::FETCH_ASSOC);
	if ($account) {
		// account exists
		$stmt = $pdo->prepare('UPDATE accounts SET activation_code = ? WHERE email = ? AND activation_code = ?');
		// set code to activated
		$activated = 'activated';
		$stmt->execute([ $activated, $_GET['email'], $_GET['code'] ]);
		$msg = 'Your account is now activated, you can now login!<br><a href="index.php">Login</a>';
	} else {
		$msg = 'The account is already activated or doesn\'t exist!';
	}
} else {
	$msg = 'No code and/or email was specified!';
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,minimum-scale=1">
		<title>Activate Account</title>
		<link href="style.css" rel="stylesheet" type="text/css">
	</head>
	<body class="loggedin">
		<div class="content">
			<p><?=$msg?></p>
		</div>
	</body>
</html>
