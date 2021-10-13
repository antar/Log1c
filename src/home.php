<?php
include 'main.php';
check_loggedin($pdo);
$stmt = $pdo->prepare('SELECT * FROM accounts');
$stmt->execute();
$accounts = $stmt->fetchAll(PDO::FETCH_ASSOC);
$ip;
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
	$ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
	$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
	$ip = $_SERVER['REMOTE_ADDR'];
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,minimum-scale=1">
		<title>Log1c</title>
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
	<body class="loggedin">
		<nav class="navtop">
			<div>
				<h1>Log1c</h1>
				<a href="home.php"><i class="fas fa-home"></i>Home</a>
				<a href="profile.php"><i class="fas fa-user-circle"></i>Profile</a>
				<?php if ($_SESSION['role'] == 'Admin'): ?>
				<a href="admin/index.php" target="_blank"><i class="fas fa-user-cog"></i>Admin</a>
				<?php endif; ?>
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
			</div>
		</nav>
		<div class="content">
			<h2><?= $ip ?></h2>
			<p class="block">Welcome back, <?=$_SESSION['name']?>!</p>	
			<h2>News & Updates</h2>
			<p class="block"></p> 
			<h2>Users</h2>
			<p class="block">
			<?php foreach ($accounts as $account): ?>
			<tr class="details" onclick="location.href='account.php?id=<?=$account['id']?>'">
				<td><?=$account['username']?></td>				
			</tr>
			<?php endforeach; ?>
			</p>		
		</div>
	</body>
</html>
