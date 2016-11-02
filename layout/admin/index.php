<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Admin</title>
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0-rc1/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
	<div class="row logo" id="header">
		<?
		echo '<div class="col-lg-8 col-sm-6">
				<a href="'.'"><img src="http://www.halloauftrag.de/images/logo.png" border=0 alt="%%TITEL%%" class="img-responsive"></a>
			</div>'
		?>
	</div>
	<div class="wr-form">
		<div class="wr-form__text-l"><span class="form__text-l">Login</span></div>
		<form action="index.php" method="post" class="form-inline" accept-charset="UTF-8">
			<div class="wr-inp">
				<label class="form__label" for="">Your Email:</label>
				<input type="text" name="usermail" class="form-control form-control-w">
			</div>
			<div class="wr-inp">
				<label class="form__label" for="">Password:</label>
				<input type="password" name="pass" class="form-control form-control-w">
			</div>

			<input type="submit" value="Login" class="btn btn-default form-control-w form__text-l form__text-l-white">
		</form>
		<a href="index.php?d=passwort">Passwort vergessen?</a>
	</div>
</body>
</html>