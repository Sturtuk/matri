<?php
session_start();
include('lib/myclass.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="images/favicon.ico" />
<title>Matrimonial</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/script.js"></script>
<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){
	$("ul.profl-list li:nth-child(3n+1)").addClass("first");
	return false;
});
</script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=1"/>
    <link rel="stylesheet" href="css/bootstrap.css" type="text/css"/>
</head>
		
<body>
<div class="container">
    <div class="row">
<div class="topMain col-md-12 col-sm-12 col-xs-12 nopadding">
    <div class="wrapper col-md-12 col-sm-12 col-xs-12 nopadding">
    	<?php include('include/header.inc.php'); ?>
		<div class="header inn">
            <div class="titlebox col-md-12">
            	Error
            </div>
        </div>
    </div>
</div>
<div class="wrapper col-md-12 col-sm-12 col-xs-12 nopadding">
	 <?php include('include/error.inc.php'); ?>
     <?php include('include/footer.inc.php'); ?>
</div>
</div>
</div>

</body>
</html>
