<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Error catcher:</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" type="text/css" href="main.css" />
</head>
<body>

<p>
<?php
	$err_msg = $_POST['err_msg'];

	$to = "matt@homeschooldaybook.com,mattley@gmail.com";
	$subject = "Error from Homeschool Day Book (" . date("YmdHis") . "):";
	$body = $err_msg;
	$headers = 'From: matt@homeschooldaybook.com' . "\r\n" .
		'Reply-To: matt@homeschooldaybook.com' . "\r\n" .
		'X-Mailer: PHP/' . phpversion();

	if (mail($to, $subject, $body, $headers)) {
	  echo("success");
	} else {
	  echo("fail");
	}

	try {
		include_once "dbh_init.inc";

		$q = $dbh->prepare("insert into ud_error (error_text, indt) values (:err_msg, now())");
		$q->bindParam(":err_msg", $err_msg);
		$q->execute();

		$dbh=null;
	} catch(PDOException $e) {
		echo $e->getMessage();
		exit();
	}

?>
</p>

<?php
//<form name="frmTest" action="/catch_err.php" method="post">
//	<input type="text" name="err_msg" value="">
//	<input type="submit" name="btnSubmit" value="Test Err Msg">
//</form>
?>

</body>
</html>

