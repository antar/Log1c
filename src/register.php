<?php
include 'main.php';
// checker for correct inputs
if (!isset($_POST['username'], $_POST['password'], $_POST['cpassword'], $_POST['email'])) {
	exit('Please complete the registration form!');
}
if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email'])) {
	exit('Please complete the registration form!');
}
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
	exit('Email is not valid!');
}
if (!preg_match('/^[a-zA-Z0-9]+$/', $_POST['username'])) {
    exit('Username is not valid!');
}
if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5) {
	exit('Password must be between 5 and 20 characters long!');
}
if ($_POST['cpassword'] != $_POST['password']) {
	exit('Passwords do not match!');
}
// insert data into database
$stmt = $pdo->prepare('SELECT id, password FROM accounts WHERE username = ? OR email = ?');
$stmt->execute([ $_POST['username'], $_POST['email'] ]);
$account = $stmt->fetch(PDO::FETCH_ASSOC);
if ($account) {
	echo 'Username and/or email exists!';
} else {
	$stmt = $pdo->prepare('INSERT INTO accounts (username, password, email, activation_code) VALUES (?, ?, ?, ?)');
	$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
	$uniqid = account_activation ? uniqid() : 'activated';
	$stmt->execute([ $_POST['username'], $password, $_POST['email'], $uniqid ]);
	if (account_activation) {
		send_activation_email($_POST['email'], $uniqid);
		echo 'Please check your email to activate your account!';
	} else {
		echo 'You have successfully registered, you can now login!';
	}
}
?>
