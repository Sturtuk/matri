<?php
session_start();
include('lib/myclass.php');
include('class.paging.php');
if (!empty($_POST) && !isset($_POST['send_msg']) && !isset($_POST['refine_submit_btn']))
{
	//echo"1";
	//setcookie("SearchCookie",json_encode($_POST,true),time()+60*60,'/');
	$_SESSION['SearchCookie']=json_encode($_POST,true);
	$_SESSION['ClearCookie']=json_encode($_POST,true);
	//$test = $_SESSION['SearchCookie'];
	//echo"<pre>";print_r($test)."</br>"; 
	//$test_new = json_decode(stripslashes($test),true);
	//echo"<pre>";print_r($test_new); exit;
	//echo"<pre>";print_r($_SESSION['SearchCookie']);exit;
}
elseif(isset($_POST['refine_submit_btn']) || $_GET['Submit'] == '')
{			
	//echo"2";
	$search_coockie_data = $_SESSION['SearchCookie'];
	//echo"<pre>";print_r($search_coockie_data);
	$search_coockie_data = json_decode(stripslashes($search_coockie_data),true);
	//echo"<pre>";print_r($search_coockie_data);
	if($_POST['chk_with_photo']=='on')
	{
		$search_coockie_data['chk_with_photo']=1;
	}
	
	
	if($_POST['chk_with_horoscope']=='on')
	{
		$search_coockie_data['chk_with_horoscope']=1;
	}
	if($_POST['myself']=='myself')
	{
		$search_coockie_data['myself']=$_POST['myself'];
	}
	
	if($_POST['son']=='son')
	{
		$search_coockie_data['son']=$_POST['son'];
	}
	if($_POST['daughter']=='daughter')
	{
		$search_coockie_data['daughter']=$_POST['daughter'];
	}
	
	if($_POST['brother']=='brother')
	{
		$search_coockie_data['brother']=$_POST['brother'];
	}
	
	if($_POST['sister']=='sister')
	{
		$search_coockie_data['sister']=$_POST['sister'];
	}
	
	if($_POST['who_online']=='who_online')
	{
		$search_coockie_data['who_online']=$_POST['who_online'];
	}
	
	if($_POST['who_offline']=='who_offline')
	{
		$search_coockie_data['who_offline']=$_POST['who_offline'];
	}
	
	
	
	if($_POST['relative']=='relative')
	{
		$search_coockie_data['relative']=$_POST['relative'];
	}
	
	if($_POST['friend']=='friend')
	{
		$search_coockie_data['friend']=$_POST['friend'];
	}
	
	if($_POST['Search_from_age']!='' && $_POST['Search_to_age']!='')
	{
		$search_coockie_data['Search_from_age']=$_POST['Search_from_age'];
		$search_coockie_data['Search_to_age']=$_POST['Search_to_age'];
	}
	
	if(count($_POST['Search_chk_marital_status'])>0)
	{
		$search_coockie_data['Search_chk_marital_status']=$_POST['Search_chk_marital_status'];
	}
	if(count($_POST['Search_drpReligion'])>0)
	{
		$search_coockie_data['Search_drpReligion']=$_POST['Search_drpReligion'];
	}
	
	if(count($_POST['Search_drpMotherTongue'])>0)
	{
		$search_coockie_data['Search_drpMotherTongue']=$_POST['Search_drpMotherTongue'];
	}
	
	if(count($_POST['Search_drpEducation'])>0)
	{
		$search_coockie_data['Search_drpEducation']=$_POST['Search_drpEducation'];
	}
		
	$_SESSION['SearchCookie']=json_encode($search_coockie_data,true);
	
}
else if($_GET['flag']=='interest_sent' || $_GET['flag']=='msg_sent' || isset($_POST['send_msg']))
{
	//echo"3";
}
else
{
	//echo"4";	
	//setcookie('SearchCookie', '', time()-3600,'/');
	$_SESSION['SearchCookie']='';
}
//$search_coockie_data = $_COOKIE['SearchCookie'];
//$search_coockie_data = json_decode(stripslashes($search_coockie_data),true);
$search_coockie_data = $_SESSION['SearchCookie'];
$search_coockie_data = json_decode(stripslashes($search_coockie_data),true);
//print_r($search_coockie_data);
//echo $search_coockie_data['regular_to_age'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="images/favicon.ico" />
<title>Search List</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<!--<link rel="stylesheet" href="assets/css/colorbox.css" />-->
<link rel="stylesheet" href="css/colorbox.css" />
<link rel="stylesheet" href="docsupport/prism.css">
<link rel="stylesheet" href="chosen.css">
</head>
<body>
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
<?php if($_SESSION['UserEmail']=='' || (count($db_member_plan)==0)){ ?>
<script src="assets/plugins/jquery-1.10.1.min.js" type="text/javascript"></script>
<?php } ?>
  <script type="text/javascript" src="assets/js/lightbox.js"></script>
  
  
<script type="text/javascript" src="js/script.js"></script>
<script type="text/javascript" src="js/jquery.accordion.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('.list-toggle').find('h3').click(function(e) {
			if($(this).next('ul').css('display')!='block')
			{
				//$('.searchby').css('display','none');
				//$('.list-toggle').find('ul').slideUp('slow');
	            $(this).next('ul').slideToggle('slow');
				//$('.list-toggle').find('h3').removeClass('selected');
				$(this).addClass('selected');
			}
			else
			{
				$(this).next('ul').slideUp('slow');
				$(this).removeClass('selected');
				//$(this).addClass('selected');
			}
			
        });
		
		$('.morelink .more-view').click(function(e) {
			$( ".close-more-search" ).trigger( "click" );
            $(this).next('div').find('.searchby').fadeIn(150);
        });
		
		$('.close-more-search').click(function(e) {
            $(this).parent('.searchby').fadeOut(150);
        });
		
		/*$("#acc-list").accordion({
			alwaysOpen: false,
			header: '.sidebar-cont > .list-toggle h3'
		});*/
	});
</script>
<script>
		var _gaq=[["_setAccount","UA-XXXXX-X"],["_trackPageview"]];
		(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];g.async=1;
		g.src=("https:"==location.protocol?"//ssl":"//www")+".google-analytics.com/ga.js";
		s.parentNode.insertBefore(g,s)}(document,"script"));
	</script>
   <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
		<script src="assets/js/jquery.colorbox.js"></script>
		<script>
			$(document).ready(function(){
				//Examples of how to assign the Colorbox event to elements
				$(".group1").colorbox({rel:'group1'});
				$(".group2").colorbox({rel:'group2', transition:"fade"});
				$(".group3").colorbox({rel:'group3', transition:"none", width:"75%", height:"75%"});
				$(".group4").colorbox({rel:'group4', slideshow:true});
				$(".ajax").colorbox();
				$(".youtube").colorbox({iframe:true, innerWidth:640, innerHeight:390});
				$(".vimeo").colorbox({iframe:true, innerWidth:500, innerHeight:409});
				$(".iframe").colorbox({iframe:true, width:"80%", height:"80%"});
				$(".inline").colorbox({inline:true, width:"50%"});
				$(".callbacks").colorbox({
					onOpen:function(){ alert('onOpen: colorbox is about to open'); },
					onLoad:function(){ alert('onLoad: colorbox has started to load the targeted content'); },
					onComplete:function(){ alert('onComplete: colorbox has displayed the loaded content'); },
					onCleanup:function(){ alert('onCleanup: colorbox has begun the close process'); },
					onClosed:function(){ alert('onClosed: colorbox has completely closed'); }
				});
				$('.non-retina').colorbox({rel:'group5', transition:'none'})
				$('.retina').colorbox({rel:'group5', transition:'none', retinaImage:true, retinaUrl:true});
				
				//Example of preserving a JavaScript event for inline calls.
				$("#click").click(function(){ 
					$('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
					return false;
				});
			});
		</script>-->
<script type="text/javascript">
$(document).ready(function(){
	$("ul.profl-list li:nth-child(4n+1)").addClass("first");
	return false;
});
</script>
<script src="js/jquery.easytabs.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready( function() {
      $('#tab-container').easytabs();
    });
</script>
<script src="js/jquery.colorbox.js"></script>
<script>
	$(document).ready(function(){
		$(".inline").colorbox({inline:true, maxWidth:"900px;"});
		$(".ajax").colorbox({innerWidth:"500px;", maxWidth:"500px;"});
		$(".ajax1").colorbox({innerWidth:"450px;", maxWidth:"450px;", innerHeight:"200px;"});
		$(".ajax3").colorbox({innerWidth:"450px;", maxWidth:"450px;"});
		$(".user_offline").colorbox({innerWidth:"400px;", maxWidth:"400px;", innerHeight:"100px;", height:"100px;", xhrError: "This user is offline."});
		$(".paid_error").colorbox({innerWidth:"400px;", maxWidth:"400px;", innerHeight:"130px;", height:"130px;", xhrError: "This feature is available for paid member."});
		$(".exid_mobile").colorbox({innerWidth:"500px;", maxWidth:"500px;", innerHeight:"130px;", height:"130px;", xhrError: "Sorry! You exceed maximum number of mobile from your plan."});
		$(".exid_msg").colorbox({innerWidth:"500px;", maxWidth:"500px;", innerHeight:"130px;", height:"130px;", xhrError: "Sorry! You exceed maximum number of message from your plan."});
		$(".same_gender").colorbox({innerWidth:"400px;", maxWidth:"400px;", innerHeight:"130px;", height:"130px;", xhrError: "Interest can not be send to same gender."});
		$(".alredy_sent").colorbox({innerWidth:"400px;", maxWidth:"400px;", innerHeight:"100px;", height:"100px;", xhrError: "Interest is already sent."});
		$(".none_result").colorbox({innerWidth:"500px;", maxWidth:"500px;", innerHeight:"130px;", height:"130px;", xhrError: "Sorry, we couldn't find any results to suit your search criteria. Please resubmit the form."});
	});	
</script> 
<div class="topMain">
	<div class="wrapper">
    	<?php include('include/header.inc.php'); ?>
		<div class="header inn">
        	<div class="titlebox">
            	<h2>Search</h2>
            </div>
        </div>
    </div>
</div>
<div class="wrapper">
	 <?php include('include/search_list.inc.php'); ?>
     <?php include('include/footer.inc.php'); ?>
</div>
<script src="chosen.jquery.js" type="text/javascript"></script>
  <script src="docsupport/prism.js" type="text/javascript" charset="utf-8"></script>
  <script type="text/javascript">
    var config = {
      '.chosen-select'           : {}
    }
    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }
  </script>
<script>
	/*$(function() {
		var moveLeft = 0;
		var moveDown = 0;
		$('img.popper').hover(function(e) {
	   
			var target = '#' + ($(this).attr('data-popbox'));
			 
			$(target).show();
			moveLeft = $(this).outerWidth();
			moveDown = ($(target).outerHeight() / 2);
		}, function() {
			var target = '#' + ($(this).attr('data-popbox'));
			$(target).hide();
		});
	 
		$('img.popper').mousemove(function(e) {
			var target = '#' + ($(this).attr('data-popbox'));
			 
			//leftD = e.pageX + parseInt(moveLeft);
			leftD = e.pageX + 50;
			maxRight = leftD + $(target).outerWidth();
			windowLeft = $(window).width() - 40;
			windowRight = 0;
			//maxLeft = e.pageX - (parseInt(moveLeft) + $(target).outerWidth() + 20);
			maxLeft = e.pageX - ($(target).outerWidth() + 50);
			 
			if(maxRight > windowLeft && maxLeft > windowRight)
			{
				leftD = maxLeft;
			}
		 
			topD = e.pageY - parseInt(moveDown);
			maxBottom = parseInt(e.pageY + parseInt(moveDown) + 20);
			windowBottom = parseInt(parseInt($(document).scrollTop()) + parseInt($(window).height()));
			maxTop = topD;
			windowTop = parseInt($(document).scrollTop());
			if(maxBottom > windowBottom)
			{
				topD = windowBottom - $(target).outerHeight() - 20;
			} else if(maxTop < windowTop){
				topD = windowTop + 20;
			}
		 
			$(target).css('top', topD).css('left', leftD);
		 
		 
		});
	 
	});*/
	
	$(document).ready(function(e) {
        $('.list_view').click(function(e) {
			$('.profl-list').fadeOut('slow','',function(){
				$('.profl-list').addClass('thumb_view');	
				$('.profl-list').fadeIn('slow');
			});
		});
		$('.grid_view').click(function(e) {
			$('.profl-list').fadeOut('slow','',function(){
				$('.profl-list').removeClass('thumb_view');	
				$('.profl-list').fadeIn('slow');
			});
		});
    });
	
	</script>
</body>
</html>