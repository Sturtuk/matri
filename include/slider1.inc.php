<?php
$sql_login = "SELECT members.*,member_photos.photo,member_photos.Approve FROM members LEFT JOIN member_photos ON members.id = member_photos.member_id WHERE members.id = '".$_SESSION['logged_user'][0]['id']."'";	
$logged_in_member=$obj->select($sql_login);
$select_cover_img = "SELECT * FROM member_photo_gallery WHERE member_id = '".$_SESSION['logged_user'][0]['id']."'";	
$db_cover_img=$obj->select($select_cover_img);
$cover_img='';
for($i=0;$i<count($db_cover_img);$i++)
{
	if($db_cover_img[$i]['Cover_photo']==1)
	{
		$cover_img=$db_cover_img[$i]['photo'];
	}
}
?>
<div class="header">
	<?php 
	if($cover_img!=''){ 
		
		//$img_path=str_replace('crop_','',$cover_img);
	list($width, $height, $type, $attr) = getimagesize("upload/".$cover_img);
	if($width>999 || $height >431)
	{ ?>
	<img src="timthumb.php?src=upload/<?php echo $cover_img; ?>&amp;w=999&amp;h=431"/>
 	<?php }else{ ?>
	 <img src="upload/<?php echo $cover_img; ?>" width="999px" height="431px"  />
	<?php	 
 	}
	?>
		
    <?php }else{ ?>
	<img src="images/header_img1.jpg"  />
    <?php } ?>
     <div class="searchbox profilebox col-md-12 col-sm-12 col-xs-12">
		<!--<a href="#" class="header-pname">Hitesh Solanki</a>-->
		<div class="timeline-thumb"><a href="#">
	
        <?php
			if(!empty($logged_in_member[0]['photo']) AND $logged_in_member[0]['Approve'] == 1)
			{
				$path = "upload/".$logged_in_member[0]['photo'];
				if (file_exists($path)) {
					
					list($width, $height, $type, $attr) = getimagesize($path);
					$newwidth = 130;
					$newheight = ($height * 130)/$width;
					list($width1, $height1, $type1, $attr1) = getimagesize(str_replace('crop_','',$path));
					if($width1 > 200)
					{						
						$height1 = (($height1*200)/$width1);
						$width1 = 200;
					}
					else
					{						
						$width1 = (($width1*200)/$height1);
						$height1 = 200;
					}
echo '<a href="javascript:;" class="popper_profile" data-popbox="pop_profile"><img class="size" src="'.$path.'"  width="'.$newwidth.'" height="'.$newheight.'" style="width:130px;height:130px;" />';
	echo '<div id="pop_profile" class="popbox"><img src="'.$path.'" width="'.$width1.'"  height="'.$height1.'" /></div></a>';
				}
				else{
					if($_SESSION['logged_user'][0]['gender']=='M')
						echo '<img class="" src="'."images/male-user1.png".' width="130" height="130""/>';
					else
						echo '<img class="" width="130" height="130" src="'."images/female-user1.png".'"/>';
				}
			}
			else{
					if($_SESSION['logged_user'][0]['gender']=='M')
						echo '<img  class="" width="130" height="130" src="'."images/male-user1.png".'"/>';
					else
						echo '<img class="" width="130" height="130" src="'."images/female-user1.png".'"/>';
				}?>
        <!--<img src="images/timeline-thumb.jpg" />--></a></div>
        <ul class="list-prfl">
        	<li><a href="timeline.php">Timeline</a></li>
            <li><a href="my_account.php">Profile</a></li>
<?php
$select_member_id = "select * from members where email_id = '".$_SESSION['UserEmail']."'";
$db_select_member_id = $obj->select($select_member_id);
$select_followers = "select tbl_user_followers.* from tbl_user_followers right join members on members.id=tbl_user_followers.UserId where tbl_user_followers.FollowerId = '".$db_select_member_id[0]['id']."'";
$db_followers = $obj->select($select_followers);
$select_following = "select tbl_user_followers.* from tbl_user_followers right join members on members.id=tbl_user_followers.FollowerId where tbl_user_followers.UserId = '".$db_select_member_id[0]['id']."'";
$db_following = $obj->select($select_following);
?>
            <li><a href="<?php if(count($db_followers)>0){ ?>followers.php <?php } else {?> javascript:void(0); <?php } ?>">Followers</a><span><?php echo count($db_followers); ?></span></li>
            <li><a href="<?php if(count($db_following)>0){ ?>following.php<?php } else {?> javascript:void(0); <?php } ?>">Following</a><span><?php echo count($db_following); ?></span></li>
            
            <li><a href="gallery.php">Album</a></li>
            
            <?php
$new_msg = "select M.*,U.*,U.id as uid from messages M left join members U on M.from_mem=U.member_id  where M.to_mem = '".$_SESSION['logged_user'][0]['member_id']."'";	
			$total_msg = $obj->select($new_msg);	
$new_msg1= "select M.*,U.*,U.id as uid from messages M left join members U on M.from_mem=U.member_id  where M.to_mem = '".$_SESSION['logged_user'][0]['member_id']."' AND is_read=0 ";	
			$total_msg1 = $obj->select($new_msg1);	
			
			?>
            <input type="hidden" id="ids" name="ids" value="<?php echo $_SESSION['logged_user'][0]['member_id']; ?>"/>
          <li style="position:relative;">
          <a href="javascript:void(0);" id="msg_notifctn">
          <img src="images/icon-notify-msg.png" style="border: solid 1px rgb(224, 238, 244);border-radius: 3px;" title="Messages" />
          <?php if(count($total_msg1) > 0) { ?>
          <span class="total-noti cnt"><?php echo count($total_msg1); ?></span>
          <?php } ?>
           
          </a>
          <div class="message_notification1" id="chatNoti1">
          	<div class="chatNotiHeader">
            	<a href="#" class="link_1">Inbox 
                <?php if(count($total_msg1) > 0) { ?>
                <span class="cnt">(<?php echo count($total_msg1); ?>)</span>
                <?php } ?>
                </a><!--<a href="#" class="link_2">Other <span>(12)</span></a><a href="#" class="link_3"><span>Send a New Message</span></a>-->
              
            </div>
            <div class="chatNotiList">
            	<ul>
                 <?php
		if(count($total_msg)>0)
	    {
			if(count($total_msg)>5)
			{
				$cnt=5;
			}
			else
			{
				$cnt=count($total_msg);
			}
			for($lpcntrl=0;$lpcntrl<$cnt;$lpcntrl++)
			{
				$pic="select * from member_photos where member_id='".$total_msg[$lpcntrl]['uid']."' and Approve=1";
				$dbpic=$obj->select($pic);
				
				if($total_msg[$lpcntrl]['gender']=='M' && $dbpic[0]['photo']!='')
				{
					$pic="<img src='upload/".$dbpic[0]['photo']."' height='50' width='50' />";
				}
				else
				{
					$pic="<img src='images/male-user1.png' height='50' width='50' />";
				}
				if($total_msg[$lpcntrl]['gender']=='F' && $dbpic[0]['photo']!='')
				{
					$pic1="<img src='upload/".$dbpic[0]['photo']."' height='50' width='50' />";
				}
				else
				{
					$pic1="<img src='images/female-user1.png' height='50' width='50' />";
				}
			 ?>
                	<li>
                    	<a href="received_msgs.php#msgtab-2">
<?php
                 if($total_msg[$lpcntrl]['gender']=='F' && $dbpic[0]['photo']!='')
				{
					echo $pic1;
				}
				else
				{
					echo $pic;
				}
				
			 ?>
                <div class="chatMsgCont clearfix">
                    <span class="chatMsgName"><?php echo ucfirst($total_msg[$lpcntrl]['name']); ?></span>
                    <span class="chatMsgText"><?php echo $total_msg[$lpcntrl]['message']; ?></span>
                    <span class="chatMsgDate"><?php echo date('d M Y',strtotime($total_msg[$lpcntrl]['send_date'])); ?></span>
                </div>
                        </a>
                    </li>
                     <?php
			}
				}
				else
				{
					?>
                    <h3>No New Message!</h3>
                    <?php
				}?>
                </ul>
            </div>
			<div class="chatNotiFooter clear">
            	<a href="received_msgs.php#msgtab-2">See All</a>
            </div></div>
           <?php
			$sql="select notification_info.* from notification_info,members where notification_info.to_id = '".$_SESSION['logged_user'][0]['member_id']."' AND members.member_id=notification_info.to_id AND members.is_profile_active='Y' AND notification_info.status=0";
			//echo $sql;
			$new_int=$obj->select($sql); ?>
			<?php //echo"<pre>";print_r($new_int); ?>
		
            <li style="position:relative;"><a href="javascript:void(0)" id="notification2">
            <img src="images/icon-notify.png" style="border: solid 1px rgb(224, 238, 244);border-radius: 3px;"  title="Notification" />
            <?php if(count($new_int) > 0) { ?>
            <span class="total-noti cnt1"><?php echo count($new_int); ?></span>
            <?php } ?>
            </a>
            
             <div class="message_notification1" id="chatNoti2">
            <div class="chatNotiHeader">
          <a href="#" class="link_1">Notifications 
          <?php if(count($new_int) > 0) { ?>
          <span class="cnt1">(<?php echo count($new_int); ?>)</span>
          <?php } ?>
          </a><!--<a href="#" class="link_2">Other <span>(12)</span></a><a href="#" class="link_3"><span>Send a New Message</span></a>-->
            </div>
            <div class="chatNotiList">
            	<ul>
            <?php
			if(count($new_int)>0)
					  {
			if(count($new_int)>5)
			{
				$cnt=5;
			}
			else
			{
				$cnt=count($new_int);
			}
			for($lpcntrl=0;$lpcntrl<$cnt;$lpcntrl++)
			{
				$select="select * from members where member_id='".$new_int[$lpcntrl]['from_id']."'";
				$dbselect=$obj->select($select);
				//echo"<pre>";print_r($dbselect);
				
				
				$pic="select * from member_photos where member_id='".$dbselect[0]['id']."' AND APPROVE = '1'";
				$dbpic=$obj->select($pic);
				
				//echo"<pre>";print_r($dbpic); 
				if($dbselect[0]['gender']=='M' && $dbpic[0]['photo']!='')
				{
					$pic="<img src='upload/".$dbpic[0]['photo']."' height='50' width='50' />";
				}
				else
				{
					$pic="<img src='images/male-user1.png' height='50' width='50' />";
				}
				if($dbselect[0]['gender']=='F' && $dbpic[0]['photo']!='')
				{
					$pic1="<img src='upload/".$dbpic[0]['photo']."' height='50' width='50' />";
				}
				else
				{
					$pic1="<img src='images/female-user1.png' height='50' width='50' />";
				}
			 ?>
            <li>
                    	<a href="javascript:;" style="cursor:default;">
            	<?php
				if($dbselect[0]['gender']=='M')
				{
					echo $pic;
				}
				else
				{
					echo $pic1;
				}
				?>
                
                <?php if($new_int[$lpcntrl]['type'] == '1'){?>
                	<?php $str = "Have you interested"; ?>
                <?php } ?>
                <?php if($new_int[$lpcntrl]['type'] == '2'){
					$str = "Request Accepted";
				}?>
                 <?php if($new_int[$lpcntrl]['type'] == '3'){
					$str = "Need More Time";
				}?>
                <?php if($new_int[$lpcntrl]['type'] == '4'){
					$str = "Need More Info";
				}?>
	 	     
          <?php
$date1 = $new_int[$lpcntrl]['cdate'];
$date2 = date('Y-m-d H:i');
$diff = abs(strtotime($date2) - strtotime($date1));
$years = floor($diff / (365*60*60*24));
$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
$hours = abs(floor(($diff-($years * 31536000)-($days * 86400))/3600));
$mins = abs(floor(($diff-($years * 31536000)-($days * 86400)-($hours * 3600))/60));
$str1='';
if($years>0)
{
$str1=$years .' Year';
}
else if($days>0)
{
$str1=$days.' Days';
}
else if($hours>0)
{
$str1=$hours.' Hours';
}
else if($mins>0)
{
$str1=$mins .' Minute';
}
else
{
$str1="1 m";
}
?>
				<div class="chatMsgCont clearfix">
                  <span class="chatMsgName"><?php echo ucfirst($dbselect[0]['name']); ?>   (<?php echo ucfirst($dbselect[0]['member_id']); ?>)</span>
                  <span class="chatMsgahc"><?php echo $dbselect[0]['age']."Yrs- ".$dbselect[0]['height']."Ft- ".$dbselect[0]['city']; ?></span></br>
                     <span class="chatMsgahc"><?php echo $str; ?></span></br>
                  <span class="chatMsgText"><?php echo "";//$total_msg[$lpcntrl]['message']; ?></span>
					
                  <span class="chatMsgDate"><?php echo $str1; ?></span>
              </div>
                        </a>
                    </li>
                     <?php
			}
				}
				else
				{
					?>
                    <h3>No New Notification!</h3>
                    <?php
				}?>
                </ul>
            </div>
			<div class="chatNotiFooter clear">
            	<a href="new_interest.php#msgtab-2">See All</a>
            </div></div>
            
           <!-- <li><a href="#"><img src="images/notifi-icon.png" /><span class="total-noti">0</span></a></li>-->
            
            <!--<li><a href="#" class="following-btn"></a></li>
            <li><a href="#" class="follow-btn"></a></li>-->
        	</li>
        </ul>
        <?php /*?><form method="post" name="search_form" action="search_list.php">
            <div class="rdGender" style="font-size:15px;float:left;">
                <input type="radio" name="drpLookingFor" id="drpLookingFor" value="M" style="padding-left:15px" /><label>&nbsp;Groom&nbsp;&nbsp;</label>
                <input type="radio" name="drpLookingFor" id="drpLookingFor" value="F" checked="checked" /><label>&nbsp;Bride&nbsp;&nbsp;</label>
            </div>
            <span style="float:left; margin:0;font-size:15px;">Age</span>
            <div class="select-age" id="age_from" style="margin:-5px 0 0 10px">
                <select name="drpAgeFrom" id="drpAgeFrom">
					<?php for($i=18;$i<=50;$i++) { ?>
                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                    <?php } ?>                    
                </select>
            </div>
            <span style="margin:0 10px;font-size:15px;">to</span>
            <div class="select-age" id="age_to" style="margin:-5px 0 0 0px">
			 <select name="drpAgeTo" id="drpAgeTo">
             	<?php for($i=19;$i<=50;$i++) { ?>
            	   <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php } ?>   
             </select>     
            </div>
               <?php
			$caste_list = "select * from caste";
			$data = $obj->select($caste_list);
		    ?>
            <div class="select-gender select-country" style="margin:-5px 10px">
                <select name="drpCaste" id="drpCaste">
                	<option value="">Caste</option>
                	<?php foreach($data as $res) { ?>
                    <option value="<?php echo $res['caste']; ?>"><?php echo $res['caste']; ?></option>
                    <?php } ?>
                </select>
            </div>
          
            <?php
				$lang_list = "select * from mother_tongues";
				$data = $obj->select($lang_list);
			?>
            <div class="select-gender select-country" style="margin:-5px 0px">
                <select name="drpLang" id="drpLang">
                <option value=""> Mother Tongue</option>
                    <?php foreach($data as $res) { ?>
                    		<option value="<?php echo $res['name']; ?>"><?php echo $res['name']; ?></option>
                    <?php } ?>
                    
                </select>
            </div>
            
            <input type="submit" class="searchnow-btn" name="submit" style="margin:-8px -4px 0 0" />
        </form><?php */?>
    </div>
</div>
<script>
$('#drpGender').change( function() {
			var val = $('#drpGender').val();
			if(val == 'M')
			{
				$("#drpLookingFor").val("F");
			}else
			{
				$("#drpLookingFor").val("M");
			}
		});	
$('#drpLookingFor').change( function() {
			var val = $('#drpLookingFor').val();
			if(val == 'M')
			{
				$("#drpGender").val("F");
			}else
			{
				$("#drpGender").val("M");
			}
		});	
$('.rdGender').change( function() {
	
	var gender = $('input[name=drpLookingFor]:checked').val();	
	if(gender == 'M')
	{
		var age_from = "20"; 
	}
	else
	{
		var age_from = "17";
	}
	$.ajax({
				url: 'makeAgeDrp.php',
				dataType: 'html',
				data: { drpFor :"age_from",age_from : age_from },
				success: function(data) {
					$('#age_from').html( data );
					var from = $('#drpAgeFrom').val();
						$.ajax({
	
						url: 'makeAgeDrp.php',
		
						dataType: 'html',
		
						data: {age_from : from},
		
						success: function(data) {
							$('#age_to').html( data );
		
						}
	
				});	
				}
			});	
});
$('#drpAgeFrom').change( function() {
	
	var age_from = $('#drpAgeFrom').val();
			$.ajax({
				url: 'makeAgeDrp.php',
				dataType: 'html',
				data: { age_from : age_from },
				success: function(data) {
					$('#age_to').html( data );
				}
			});	
});
</script>
<script>
	$(function() {
		var moveLeft = 0;
		var moveDown = 0;
		$('a.popper_profile').hover(function(e) {
	   
			var target = '#' + ($(this).attr('data-popbox'));
			 
			$(target).show();
			moveLeft = $(this).outerWidth();
			moveDown = ($(target).outerHeight() / 2);
		}, function() {
			var target = '#' + ($(this).attr('data-popbox'));
			$(target).hide();
		});
	 
		$('a.popper_profile').mousemove(function(e) {
			var target = '#' + ($(this).attr('data-popbox'));
			 
			//leftD = e.pageX + parseInt(moveLeft);
			leftD = 136;
			maxRight = leftD + $(target).outerWidth();
			windowLeft = $(window).width() - 40;
			windowRight = 0;
			maxLeft = e.pageX - (parseInt(moveLeft) + $(target).outerWidth() + 20);
			 
			if(maxRight > windowLeft && maxLeft > windowRight)
			{
				leftD = maxLeft;
			}
			topD = -37;
			maxBottom = parseInt(e.pageY + parseInt(moveDown) + 20);
			windowBottom = parseInt(parseInt($(document).scrollTop()) + parseInt($(window).height()));
			maxTop = topD;
			windowTop = parseInt($(document).scrollTop());
			/*if(maxBottom > windowBottom)
			{
				topD = windowBottom - $(target).outerHeight() - 20;
			} else if(maxTop < windowTop){
				topD = windowTop + 20;
			}*/
		 
			$(target).css('top', topD).css('left', leftD);
		 
		 
		});
	 
	});
	</script>
<script>
	$('#msg_notifctn').click(function(){
		if($('#chatNoti1').css('display')=='block')
		{
			
			$('#chatNoti1').css('display','none');
		}
		else
		{
			$('#chatNoti1').css('display','block');
			$('#chatNoti2').css('display','none');
		}
		var to=$('#ids').val();
		$.ajax({
			 type: "GET",		
			 url: 'make_read.php',
			 data :{To:to
				   } ,      
			 success: function(data) {
				 $('.cnt').html(0);
			 }
		});
		
	});
	$('#notification2').click(function(){
		if($('#chatNoti2').css('display')=='block')
		{
			
			$('#chatNoti2').css('display','none');
		}
		else
		{
			$('#chatNoti2').css('display','block');
			$('#chatNoti1').css('display','none');
		}
		var to='<?php echo $_SESSION['logged_user'][0]['member_id']; ?>';
		$.ajax({
			 type: "GET",		
			 url: 'make_show.php',
			 data :{To:to
				   },      
			 success: function(data) {
				 $('.cnt1').html(0);
			 }
		});
		
	});
</script>
<style>
.chatNotiList h3{ text-align:center; font-size:15px; color:#000; padding-top:5px;}
.chatMsgahc{color:#828282 !important;font-size:10px;font-weight:bold;}
</style>
