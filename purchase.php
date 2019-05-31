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
            <?php
        // if $discount_desc, there was no $discount_err.
        if ($discount_desc) {
            echo "<p><strong>" . $discount_desc . "</strong></p>";
            echo "<p><strong>Discounted price:</strong> Buying Homeschool Day Book for permanent use is <strong>$29</strong>.</p>";
            echo '
            <br>
            <div class="centerize">
                <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
                    <input type="hidden" name="cmd" value="_s-xclick">
                    <input type="hidden" name="hosted_button_id" value="3425842">
                    <input type="image" src="https://www.paypal.com/en_US/i/btn/btn_paynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                    <img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
                </form>
            </div>
            ';
            //either $discount_err, or more likely, no discount code was entered at all.
        } else {
            echo "<p>Buying Homeschool Day Book for permanent use is only <strong>$39</strong>.</p>";
            echo '
            <br>
            <div class="centerize">
                <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
                    <input type="hidden" name="cmd" value="_s-xclick">
                    <input type="hidden" name="hosted_button_id" value="3426006">
                    <input type="image" src="https://www.paypal.com/en_US/i/btn/btn_paynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                    <img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
                </form>
            </div>
            ';
        }
            ?>

            <p>To purchase, just click on the "Pay Now" button above.</p>

            <p>Within 24 hours after your purchase, you will receive an email with a license key to unlock your software.
                Enter the license key using the "Get Licensed" button in the lower left corner of Homeschool Day Book.</p>

            <form action="/purchase.php" method="post">
                <?php
        if ($discount_err) {
            echo "<p><strong>" . $discount_err . "</strong></p>";
        }
                ?>
                <p>If you have a discount or promotion code, enter it now: <input type="text" id="discount_code" name="discount_code" size="12" maxlength="20" />&nbsp;<input type="submit" value="Go"></p>
            </form>

            <p>(If you haven't installed Homeschool Day Book yet, download and install the trial version,
                either now or after purchasing your license.  Entering your license key will automatically convert
                the trial to your own permanent copy of the software.)</p>

            <p class="centerize">
                <a href="javascript:void(0)" onclick="window.open('pop_how_pay_now_works.html','pop_how_pay_now_works','scrollbars=no,resizeable=no,statusbar=no,width=600,height=425')">(How does the Pay Now button work?)</a>
            </p>

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
