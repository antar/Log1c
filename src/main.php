<?php
// main file
include_once 'config.php';
// session
session_start();

try {
	$pdo = new PDO('mysql:host=' . db_host . ';dbname=' . db_name . ';charset=' . db_charset, db_user, db_pass);
} catch (PDOException $exception) {
	// if error
	exit('Failed to connect to database!');
}
// login check
function check_loggedin($pdo, $redirect_file = 'index.php') {
	// cookie
    if (isset($_COOKIE['rememberme']) && !empty($_COOKIE['rememberme']) && !isset($_SESSION['loggedin'])) {
    	// update session variable
    	$stmt = $pdo->prepare('SELECT * FROM accounts WHERE rememberme = ?');
    	$stmt->execute([ $_COOKIE['rememberme'] ]);
    	$account = $stmt->fetch(PDO::FETCH_ASSOC);
    	if ($account) {
    		// match found, update
    		session_regenerate_id();
    		$_SESSION['loggedin'] = TRUE;
    		$_SESSION['name'] = $account['username'];
    		$_SESSION['id'] = $account['id'];
			$_SESSION['role'] = $account['role'];
    	} else {
    		// redirect
    		header('Location: ' . $redirect_file);
    		exit;
    	}
    } else if (!isset($_SESSION['loggedin'])) {
    	// redirect
    	header('Location: ' . $redirect_file);
    	exit;
    }
}
// activation email
function send_activation_email($email, $code) {
	$subject = 'Account Activation Required';
	$headers = 'From: ' . mail_from . "\r\n" . 'Reply-To: ' . mail_from . "\r\n" . 'Return-Path: ' . mail_from . "\r\n" . 'X-Mailer: PHP/' . phpversion() . "\r\n" . 'MIME-Version: 1.0' . "\r\n" . 'Content-Type: text/html; charset=UTF-8' . "\r\n";
	$activate_link = activation_link . '?email=' . $email . '&code=' . $code;
	$email_template = str_replace('%link%', $activate_link, file_get_contents('activation-email-template.html'));
	mail($email, $subject, $email_template, $headers);
}
?>
