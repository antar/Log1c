<?php
include 'main.php';
// check data after submit
if (!isset($_POST['username'], $_POST['password'])) {
	// no enough data
	exit('Please fill both the username and password field!');
}
// prepare = no sql injection
$stmt = $pdo->prepare('SELECT * FROM accounts WHERE username = ?');
// params
$stmt->execute([ $_POST['username'] ]);
$account = $stmt->fetch(PDO::FETCH_ASSOC);

if ($account) {
	// verify password	
	if (password_verify($_POST['password'], $account['password'])) {
		
		if (account_activation && $account['activation_code'] != 'activated') {
			// not activated
			echo 'Please activate your account to login, click <a href="resendactivation.php">here</a> to resend the activation email!';
		} else {
			// success
			session_regenerate_id();
			$_SESSION['loggedin'] = TRUE;
			$_SESSION['name'] = $account['username'];
			$_SESSION['id'] = $account['id'];
			$_SESSION['role'] = $account['role'];
			// remember me checkbox
			if (isset($_POST['rememberme'])) {
				// hash
				$cookiehash = !empty($account['rememberme']) ? $account['rememberme'] : password_hash($account['id'] . $account['username'] . 'yoursecretkey', PASSWORD_DEFAULT);
				$days = 30;
				setcookie('rememberme', $cookiehash, (int)(time()+60*60*24*$days));
				$stmt = $pdo->prepare('UPDATE accounts SET rememberme = ? WHERE id = ?');
				$stmt->execute([ $cookiehash, $account['id'] ]);
			}
			echo 'Success';
		}
	} else {
		// incorrect password
		echo 'Incorrect username and/or password!';
	}
} else {
	// incorrect username
	echo 'Incorrect username and/or password!';
}
?>
