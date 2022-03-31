<?php
include_once("db.php");

if (isset($_POST['submit'])) {
	$user = $_POST['user'];
	$oldpass = $_POST['oldpass'];
	$newpass = $_POST['newpass'];


	$user = str_replace("'", "", $user);
	$user = str_replace('"', '', $user);

	$oldpass = str_replace("'", "", $oldpass);
	$oldpass = str_replace('"', '', $oldpass);

	$newpass = str_replace("'", "", $newpass);
	$newpass = str_replace('"', '', $newpass);

	$usql = "select count(user_id) as tot,username from users where username='" . $user . "' and password=sha1('" . $oldpass . "') and enabled=1";
	
	
	$ures = mysqli_query($con, $usql);
	$urow = mysqli_fetch_object($ures);

	if ($urow->tot > 0 and strlen($newpass) > 2) {
		mysqli_query($con, "update users set password=sha1('" . $newpass . "') where username='" . $user . "'");

		header("Location: index.php?logout=relog");
	} else if (strlen($newpass) < 3) {
		echo "<div align='center'><font color='#FF0000'><b>New Password Should be at least 3 letter!</b></font></div>";
	} else {
		echo "<div align='center'><font color='#FF0000'><b>Incorrect OLD Password!</b></font></div>";
	}
}

?>

<?php
if (isset($_SESSION['logged'])) {

	$user_details = $_SESSION['user_code'];
?>

	<html lang="en">

	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="icon" href="pic/icon.png" />
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<title>BI</title>
		<link href="script/common.css" rel="stylesheet" type="text/css" />
		<!-- Bootstrap -->
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="script/bootstrap.min.css">
		<link rel="stylesheet" href="script/bootstrap-theme.css">

		<!-- Optional theme -->
		<link rel="stylesheet" href="script/bootstrap-theme.css">

		<!-- Chart JS Library -->
		<script src="script/Chart.min.js" type="text/javascript"></script>

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="script/jquery-1.11.2.min.js"></script>

		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<!-- Latest compiled and minified JavaScript -->
		<script src="script//bootstrap.min.js"></script>
	</head>

	<body>
		<?php
		include_once("sidebar.php");
		?>
		<div class="container">
			<div class="row"><br />
				<div class="col-md-6">
					<img src="pic/business_intelligence.jpg" width="300" />
					<form method='post' class="login-style" action='change_password.php'>
						<ul>
							<li>
								<input type="text" name="user" id="user_id" class="field-style field-full align-none" placeholder="User Name" value="<?php echo $user_details; ?>" readonly />
							</li>
							<li>
								<input type="text" name="oldpass" id="password" class="field-style field-full align-none" placeholder="Old Password" />
							</li>
							<li>
								<input type="text" name="newpass" id="password" class="field-style field-full align-none" placeholder="New Password" />
							</li>
							<li>
								<input type="submit" name="submit" class="submit" value="Change Password" />
							</li>
						</ul>
					</form>
				</div>
			</div>
		</div>
	</body>

	</html>

<?php
	// include_once("footer.php");
} ?>