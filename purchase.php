<?php
	$discount_code = $_POST['discount_code'];
	if ($discount_code) {
		try {
			include_once "dbh_init.inc";

			$q1 = $dbh->prepare("insert into ud_discount_used (discount_code, indt) values (:dc, now())");
			$q1->bindParam(":dc", substr($discount_code, 0, 20));
			$q1->execute();
			
			$q2 = $dbh->prepare("select discount_code, discount_desc from uc_discount where discount_code = :dc");
			$q2->bindParam(":dc", $discount_code);
			$q2->execute();

			if ($row = $q2->fetch()) {
				$discount_desc = $row['discount_desc'];
			} else {
				$discount_err = '"' . $discount_code . '" is not a currently active discount code.  <br />Please confirm your discount code and re-enter.';
			}

			$dbh = null;
		} catch(PDOException $dbe) {
			$discount_err = 'Database error: ' . $dbe->getMessage() . '.  Please contact info@homeschooldaybook.com about this problem.';
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Buying our software for permanent use</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="/main2.css" />

    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>
    <script type="text/javascript" src="/bootstrap/js/bootstrap.min.js"></script>
</head>
<body>

<div id="content" class="container">

    <div id="header">
        <h1>Homeschool Day Book</h1>
        <h3>Quick, easy homeschool record keeping and time tracking.</h3>
    </div>

    <div id="menu" class="navbar">
        <div class="navbar-inner">
            <ul class="nav">
                <li><a href="/">Home</a></li>
                <li><a href="/free_trial.html">Free Trial</a></li>
                <li class="active"><a href="/purchase.php">Buy Now</a></li>
                <li><a href="/features.html">Features</a></li>
                <li><a href="/contact.html">Contact Us</a></li>
            </ul>
        </div>
    </div>

    <div class="row">
        <div id="mainbody" class="span8 offset2">
        
            <h2>Update: Homeschool Day Book is now entirely free for personal use, and doesn't require purchasing.</h2>
            <p><strong>You don't actually need to "Buy Now" any more. The version you can download from the Free Trial page is the fully featured version of the software with no restrictions.</strong></p>
            <p><strong>Thanks to all of you who have used Homeschool Day Book over the years.</strong>.</p>

            <p>Homeschool Day Book runs on Windows XP up through Windows 10.</p>

            <p>If you've got any questions about the payment process or how licensing works,
                <a href="mailto:info@homeschooldaybook.com">please contact us</a>.</p>

        </div>
    </div>


</div>

<script type="text/javascript" src="http://www.google-analytics.com/ga.js"></script>
<script type="text/javascript">
    if (typeof(_gat)=='object')
        setTimeout(function(){
            _gat._getTracker("UA-7806722-1")._trackPageview()}, 1000);
</script>

</body>

</html>
