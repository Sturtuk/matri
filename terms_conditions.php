<?php
session_start();
include('lib/myclass.php');
$select_content = "select * from tbl_seo_content where Id = '8'";
$db_content = $obj->select($select_content);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="images/favicon.ico" />
<title><?php echo $db_content[0]['SeoTitle']; ?></title>
<meta name="description" content="<?php echo $db_content[0]['SeoMeta']; ?>" />
<meta name="keywords" content="<?php echo $db_content[0]['SeoKeywords']; ?>" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script src="assets/plugins/jquery-1.10.1.min.js" type="text/javascript"></script>
<script type="text/javascript" src="js/script.js"></script>
<script type="text/javascript" src="js/jquery.accordion.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$("#acc-list").accordion({
			alwaysOpen: false,
			header: '.sidebar h3'
		});
	});
</script>

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
<?php
include("common_user_fetch.php"); 
/*if($_SESSION['UserEmail']!='')
{
	$select_member_plan="select member_plans.* from member_plans, members where member_plans.member_id='".$_SESSION['logged_user'][0]['id']."' AND members.id=member_plans.member_id";
	$db_member_plan=$obj->select($select_member_plan);
	
	$exp_date=date('Y-m-d');
	
	if(count($db_member_plan)>0)
	{
		$select_plan="select * from new_membership_plans where id='".$db_member_plan[0]['plan_id']."'";
		$db_plan=$obj->select($select_plan);
		
		$exp_date=date('Y-m-d',strtotime('+'.$db_plan[0]['plan_duration'].' days '.$db_date[0]['reg_date']));
	}

	if(count($db_member_plan)>0 && date('Y-m-d',strtotime($exp_date))>=date('Y-m-d'))
	{
		include('include/chat.php'); 
	}
}*/
?>
<div class="topMain col-md-12 col-sm-12 col-xs-12 nopadding">
    	<?php include('include/header.inc.php'); ?>
		<div class="header inn">
        	<div class="titlebox col-md-12">
            	Terms And Conditions
            </div>
        </div>
</div>
<div class="col-md-12 nopadding">
	 <?php include('include/terms_conditions.inc.php'); ?>
     <?php include('include/footer.inc.php'); ?>
</div>
    </div>
</div>
</body>
</html>
