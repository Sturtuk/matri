<?php
session_start();
include('lib/myclass.php');
$url=explode('/',$_SERVER['REQUEST_URI']);
?>
<script type="text/javascript" src="js/jquery.cycle.all.js"></script>
<script type="text/javascript">
$(function() {
    $('.pics').each(function() {
    	var cycle = $(this), 
         controls = cycle.parent().find('.controls');
         
    	cycle.cycle({
			timeout:   0,
			speed:     200,
			fx:        'scrollHorz',
			next:      controls.find('.next'),
			prev:      controls.find('.prev'),
			caption:   cycle.parent().find('span.caption'),
			before:    function(curr, next, opts) {
				opts.caption.html( $(next).attr('title') );
			}
	    });
	});//
//	function onAfter(curr,next,opts) {
//	var caption = '' + (opts.currSlide + 1) + ' of ' + opts.slideCount;
//	$('.caption').html(caption);
//}
});


</script>

<?php
if(isset($_POST['reply']))
{
	$insert = "insert into replies(id,from_mem,to_mem,message,to_msg_id)
			   values
			   (NULL,'".$_SESSION['logged_user'][0]['member_id']."',
			   	 	 '".$_POST['to_mem']."',
					 '".$_POST['txtMsg']."',
					 '".$_POST['msg_id']."')";
	$save_rpl = $obj->insert($insert);				 
	
	$update_msg_status = "update messages 
							  set 
							  	is_replied = 'Y' 
							  where 
							  	from_mem = '".$_SESSION['logged_user'][0]['member_id']."'and
								to_mem = '".$_POST['to_mem']."'";
							//and id='".$_POST['msg_id']."'	
	
		$update = $obj->edit($update_msg_status);
}
if(isset($_GET['delete_msg_id']))
{
	$sqld="delete from messages where id = '".$_GET['delete_msg_id']."' ";
	$obj->sql_query($sqld);
	
	$sqld2="delete from not_interested_members where msg_id = '".$_GET['delete_msg_id']."' ";
	$obj->sql_query($sqld2);
	
	$sqld3="delete from need_more_info_detail where msg_id = '".$_GET['delete_msg_id']."' ";
	$obj->sql_query($sqld3);
	
	$sqld4="delete from need_more_time_detail where msg_id = '".$_GET['delete_msg_id']."' ";
	$obj->sql_query($sqld4);
	
	echo "<script> window.location.href = 'my_account.php' </script>";	
}
if(isset($_GET['id']))
{
	if($_GET['flag'] == 'y')
	{
		$sqld="delete from messages where id = '".$_GET['id']."' ";
		$obj->sql_query($sqld);
		
		$del_from_notint_mem = "delete from not_interested_members where msg_id = '".$_GET['id']."'";
		$obj->sql_query($del_from_notint_mem);
	}
	else
	{
		$sqld="delete from messages where id = '".$_GET['id']."'";
		$obj->sql_query($sqld);
	}
	echo "<script> window.location.href = 'my_account.php' </script>";	
}
if(isset($_GET['reply_msg_id']))
{
	$sqld="delete from replies where id = '".$_GET['reply_msg_id']."' ";
	$obj->sql_query($sqld);
	echo "<script> window.location.href = 'my_account.php' </script>";	
}
if(isset($_POST['send_reply']))
	{
		$update_msg_status = "update messages 
							  set 
							  	is_replied = 'Y' 
							  where 
							  	from_mem = '".$_POST['to_mem_id']."'and
								to_mem = '".$_POST['from_mem_id']."'";
							//and id='".$_POST['msg_id']."'	
	
		$update = $obj->edit($update_msg_status);
		$insert_reply = "insert into replies (id,to_mem,from_mem,message,to_msg_id)
						 values
						 (NULL,'".$_POST['to_mem_id']."','".$_POST['from_mem_id']."','".$_POST['message']."','".$_POST['msg_id']."')";
		$insert = $obj->insert($insert_reply);		
		echo "<script>window.location='my_account.php'</script>";
		 
						 
	}	
//TO ACTIVATE PROFILE
if($_GET['flag'] == 'activate_profile')
{
	$update="UPDATE members 
				  SET 
				  		is_profile_active = 'Y'				  		
				 where 
				 		id = '".$_SESSION['logged_user'][0]['id']."'";
		
						$db_updatepage=$obj->edit($update);	
						echo "<script>window.location='edit_profile.php'</script>";
	
}
//to deactivte account
if($_GET['flag'] == 'deactivate_prof')
{
	$update="UPDATE members 
				  SET 
				  	is_profile_active = 'N'				  		
				 where 
				 	id = '".$_SESSION['logged_user'][0]['id']."'";
	$db_updatepage=$obj->edit($update);	
   echo "<script>window.location='edit_profile.php'</script>";
}
//to delete account
if($_GET['flag'] == 'del_prof')
{
	$delete_acc="delete from members 
				 where 
				 id = '".$_SESSION['logged_user'][0]['id']."'";
	$obj->sql_query($delete_acc);
	session_unset();
	session_destroy();
	echo "<script>window.location='logout.php'</script>";
}
//LOGGED-IN USER'S DETAIL //
	$sql_login = "SELECT members.*,member_photos.photo FROM members 
				LEFT JOIN member_photos ON members.id = member_photos.member_id
				WHERE
			 	members.id = '".$_SESSION['logged_user'][0]['id']."'";	
	$logged_in_member=$obj->select($sql_login);
	
		
?>
<?php		
		$select_new_msgs = "select express_interest.*, express_interest.id as exp_int_id from express_interest,members where express_interest.from_mem = '".$_SESSION['logged_user'][0]['member_id']."' AND members.member_id=express_interest.to_mem AND members.is_profile_active='Y' AND express_interest.is_accepted='N' AND is_more_time=0 AND is_more_info=0";
		
		//$PAGING=new PAGING($select_new_msgs,10);
		//$sql=$PAGING->sql;
		$messages = $obj->select($select_new_msgs);
		
		//$select_new_msgs = "select *, express_interest.id as exp_int_id from express_interest where to_mem = '".$_SESSION['logged_user'][0]['member_id']."'";								
		//$messages = $obj->select($select_new_msgs);
		if(!empty($messages)) { ?>

<div class="content col-md-9 col-sm-12 col-xs-12">
  <?php //$PAGING->show_paging("sent_reply_panding.php");?>
  <div class=""> <!-- title_select_all -->
    <div class="floatr">
      <?php
		 for($i=0;$i<count($messages);$i++)
									  {
										  
										  	$sql2 = "SELECT members.*,members.id as mem_id,member_photos.photo,messages.id as 
													msg_id,messages.* FROM messages,members 
								  					 LEFT JOIN member_photos ON members.id = member_photos.member_id
								                     where
													 members.member_id = '".$messages[$i]['to_mem']."'"; 
													 
										
										$each_msg = $obj->select($sql2); 
										$msg_id = $each_msg[0]['msg_id'];
										$chk_eaccepted = "select * from express_interest
														  where from_mem = '".$each_msg[0]['member_id']."'
														  and to_mem = '".$_SESSION['logged_user'][0]['member_id']."'
														  and is_accepted = 'Y'";
										
										$result = $obj->select($chk_eaccepted);
										?>
    </div>
    <div class="" id="accept_div_<?php echo $each_msg[0]['member_id']."_".$messages[$i]['exp_int_id']; ?>"> <!-- basicview -->
      <div class="showbasiccontent col-md-12 col-sm-12 col-xs-12">
        <div class="prfl-pic">
          <div id="slideshow" class="pics">
          <?php
		$select_profile_photo="select * from member_photos where member_id='".$each_msg[0]['mem_id']."' AND Approve=1";
		$db_profile_photo=$obj->select($select_profile_photo);

		$select_gallery_photo="select * from member_photo_gallery where member_id='".$each_msg[0]['mem_id']."' AND Approve=1";
		$db_gallery_photo=$obj->select($select_gallery_photo);
		
		if(count($db_profile_photo)>0 || count($db_gallery_photo)>0)
		{
			if(count($db_profile_photo)>0)
			{
			?>
        	<img src="upload/<?php echo $db_profile_photo[0]['photo'] ?>" width="70" />
            <?php
			}
			
			for($p=0;$p<count($db_gallery_photo);$p++)
			{
			?>
            <img src="upload/<?php echo $db_gallery_photo[$p]['photo'] ?>" width="70" />
            <?php
			}
		?>
        <?php }else{ ?>
        <img src="images/usericon.png" width="70" />
        <?php } ?>
          </div>
          <div class="img-count controls"><a href="#" class="prev"><img src="images/blue-arrow2.png" /></a><span class="caption">&nbsp;</span><a href="#" class="next"><img src="images/blue-arrow1.png" /></a></div>
        </div>
        <div class="prfl-details">
          <div class="row-top"><a href="#" class="floatl"><?php echo $each_msg[0]['name']; ?> (<?php echo $each_msg[0]['member_id']; ?>)</a> <a href="#"><span class="icon phoneicon "></span></a>
            <div class="smalltxt floatr">Received : 20 hours ago </div>
          </div>
          <br />
          <span class="smalltxt">Last Login : 2 hours ago</span><br />
          <p><?php echo $each_msg[0]['age']; ?> Yrs, <?php echo $each_msg[0]['height']." Inch" ?> | <?php echo $each_msg[0]['religion']; ?>: <?php echo $each_msg[0]['caste']; ?> | Location : <?php echo $each_msg[0]['city']; ?>, <?php echo $each_msg[0]['country']; ?> | Education : 
		  <?php
			$select_education="select * from education_course where Id='".$each_msg[0]['education']."'";
			$db_education=$obj->select($select_education);
			echo $db_education[0]['Title'];
			?>
		  <?php if($each_msg[0]['occupation'] != "") { ?> | Occupation : <?php echo $each_msg[0]['occupation'];  } ?></p>
          <a href="view_profile.php?id=<?php echo $each_msg[0]['mem_id']; ?>">View Full Profile</a>
          <div class="lightbox" style="display:none;">
            <div id="request_content1<?php echo $each_msg[0]['id']; ?>">
              <div class="lightbox_cont full">
                <h2>All Communication with this member</h2>
                <div class="showbasiccontent col-md-12 col-sm-12 col-xs-12">
                  <div class="prfl-pic">
                    <div id="slideshow" class="pics"> <img src="images/usericon.png" width="70" height="70" /> <img src="http://malsup.github.com/images/beach1.jpg" width="70" height="70" /> <img src="http://malsup.github.com/images/beach2.jpg" width="70" height="70" /> <img src="http://malsup.github.com/images/beach3.jpg" width="70" height="70" /> </div>
                    <div class="img-count controls"><a href="#" class="prev"><img src="images/blue-arrow2.png" /></a><span class="caption">&nbsp;</span><a href="#" class="next"><img src="images/blue-arrow1.png" /></a></div>
                  </div>
                  <div class="prfl-details">
                    <div class="row-top"><a href="#" class="floatl"><?php echo $each_msg[0]['name']; ?> (<?php echo $each_msg[0]['member_id']; ?>)</a> <a href="#"><span class="icon phoneicon "></span></a>
                      <div class="smalltxt floatr">Received : 20 hours ago </div>
                    </div>
                    <br />
                    <span class="smalltxt">Last Login : <?php echo $each_msg[0]['last_login']; ?></span><br />
                    <p><?php echo $each_msg[0]['age']; ?> Yrs, Height <?php echo $each_msg[0]['height']; ?> | <?php echo $each_msg[0]['religion']; ?>: <?php echo $each_msg[0]['caste']; ?> | Location : <?php echo $each_msg[0]['city']; ?>, <?php echo $each_msg[0]['country']; ?> | Education : 
					<?php
			$select_education="select * from education_course where Id='".$each_msg[0]['education']."'";
			$db_education=$obj->select($select_education);
			echo $db_education[0]['Title'];
			?>
					<?php if($each_msg[0]['occupation'] != "Any" ) { ?>| Occupation : <?php echo $each_msg[0]['occupation']; } ?></p>
                    <a href="view_profile.php?id=<?php echo $each_msg[0]['mem_id']; ?>">View Full Profile</a> </div>
                </div>
                <?php 
											$chk_not_int = "select * from not_interested_members
															where from_mem = '".$_SESSION['logged_user'][0]['member_id']."' and
															to_mem = '".$messages[$i]['from_mem']."'";
															
											$select_data = $obj->select($chk_not_int);
											if(empty($select_data)) { ?>
                <div class="cb-msgs">
                  <h2>Interests</h2>
                  <a  href="#" class="not_int_msg_class" id="not_int_<?php echo $each_msg[0]['member_id']."_".$msg_id; ?>" > Not Interested</a>
                  <?php
											$select_new_msgs2 = "select * from messages
																where
																from_mem = '".$_SESSION['logged_user'][0]['member_id']."' and
																interested = 'Y' and
																to_mem = '".$messages[$i]['to_mem']."' order by id desc";
											
											$messages2 = $obj->select($select_new_msgs2);
											
											
										
										
										foreach($messages2 as $msg) { 
										
										
											$datestr2 = $msg['send_date'];
											$date2=strtotime($datestr2);
											$diff2=$date2-time();
											$days2=abs(floor($diff2/(60*60*24)));
										if($days2 == "1")
										{
											$final_days2 = "day";
										}
										else
										{
											$final_days2 = "days";
										}
										$hours2=abs(round(($diff2-$days2*60*60*24)/(60*60)));?>
                  <div class="cb-msgbox">
                    <div class="left-msgbox">
                      <p><?php echo "Me: ".$msg['message']; ?></p>
                    </div>
                    <div class="smalltxt floatr">Received : <?php echo $days2.$final_days2." ago"; ?></div>
                    <?php $replies_to_mem = "select * from replies 
															  where to_msg_id = '".$msg['id']."'";
												  $sel_replies = $obj->select($replies_to_mem);
												  if(!empty($sel_replies))
												  {
													  foreach($sel_replies as $rel) { ?>
                    <div class="left-msgbox">
                      <p><?php echo"<br>".$each_msg[0]['name'].": ".$rel['message']; ?></p>
                    </div>
                    <?php  } 
												  }
												  else { ?>
                    <form name="reply_form" method="post" class="form-horizontal">
                      <div class="msg-interest">
                        <div class="floatr">
                          <textarea name="txtMsg" id="txtMsg"></textarea>
                          <input type="hidden" value="<?php echo $msg['id']; ?>" name="msg_id" id="msg_id" />
                          <input type="hidden" value="<?php echo $msg['from_mem']; ?>" name="to_mem" id="to_mem" />
                          <input type="submit" value="Reply" name="reply"/>
                        </div>
                      </div>
                    </form>
                    <?php }?>
                  </div>
                  <?php } ?>
                </div>
                <?php } else {
									  echo "<h2 style='color:green'>You have sent not interested notification to this member</h2>"; } ?>
              </div>
            </div>
          </div>
        </div>
        <?php /*?><div class="msg-interest">
        	
        
          <div class="left-msg int" style="display:none">Interested in your profile. Kindly respond at the earliest.</div>
          <div class="floatr" style="display:none"><a href="#" class="btn-pink btn"><span>Accept</span></a><a href="#" class="btn-blue1 btn"><span>Need More Info</span></a><a href="#" class="btn-blue1 btn"><span>Need More Time</span></a><a href="#" class="btn-blue1 btn"><span>Not Interested</span></a></div>
        </div><?php */?>
      </div>
      <?php } ?>


<div class=""> <!-- title_select_all --> 
  <!--<input type="checkbox" onclick="selallcheck()" name="selall" class="chkBox">
                                    Select All-->
  <div class="floatr" style="display:none;"><a href="#">Accept</a> | <a href="#">Need more Time</a> | <a href="#">Need more Info</a> | <a href="#">Not Interested</a> | <a href="#">Delete</a> </div>
</div>
   </div>
<?php } 
								else 
								{
									echo "Currently You have no any interest notification by anyone.";
								} ?>
</div>

<?php //$PAGING->show_paging("sent_reply_panding.php");?>


</div>
<style>
.upload_pic
{
	float: left;
    margin-right: 20px;
    padding: 24px 13px;
}
.size
{
	height:181px;
	width:171px;
}
.back_btn
{
	text-align:right;
	padding-right:5px;	
}
.back_btn_size
{
	height:15px;
	padding-top:5px;
}
.profile_pic{
	/*height:150px;*/
	width:75px;
}
</style>
<script>
//accepe interest click
$('.accept_interest').click(function() {
		 var ids = this.id;
		 var exploded = ids.split('_');
		 
		
				jQuery.post("include/accept_interest.php", {
				to_mem:exploded[1],
				},
				function(data, to_mem)
				{
					if(data == "1")
					{
						$('#accept_div_'+exploded[1]+"_"+exploded[2]).html("Congratulations! YOu have successfully accepted interest.");
						$('#accept_div_'+exploded[1]+"_"+exploded[2]).css('color','green');						
					}
					
			});
		 
	});
//on not-interest msg click
$('.not_int_msg_class').click(function() {
		 var ids = this.id;
		 var exploded = ids.split('_');
		 
		 jQuery.post("include/save_not_int.php", {
				to_member_id:exploded[2],
				msg_id:exploded[3]				
				},
				function(data, to_member_id,msg_id)
				{
					if(data == "1")
					{
						$('.cb-msgs').html("Member has been notified that you're not interested.");
						$('.cb-msgs').css('color','green');						
					}					
			});
		 
	});
	function doYouWantTo(id,data){
	 doIt=confirm('Are you sure you want to delete this message?');
	  if(doIt){
		  if(data == "del_frm_notint_mem")
		  {
			//window.location.href = 'my_account.php?id='+id+&flag=y';		
		  }
		  else
		  {
			  window.location.href = 'my_account.php?id='+id;		
		  }
	  }
	  else{ 
		  return false;
	  }
	  return true;
	}
	$('.need_more_time').click(function() {
		 var ids = this.id;
		 var exploded = ids.split('_');
		 var name = exploded[3];
		 
				jQuery.post("include/need_more_time_detail.php", {
				to_mem:exploded[2],
				},
				function(data, to_mem)
				{
					if(data == "1")
					{
						$('#accept_div_'+exploded[1]+"_"+exploded[2]).html("Your request for more time to respond has been conveyed to "+name+"("+exploded[1]+")");
						$('#accept_div_'+exploded[1]+"_"+exploded[2]).css('color','green');						
					}
					
			});
		 
	});
	$('.need_more_info').click(function() {
		 var ids = this.id;
		 var exploded = ids.split('_');
		 var name = exploded[3];
		 
				jQuery.post("include/need_more_info_detail.php", {
				to_mem:exploded[2],
				},
				function(data, to_mem)
				{
					if(data == "1")
					{
						$('#accept_div_'+exploded[1]+"_"+exploded[2]).html("Your request for more information to respond has been conveyed to "+name+"("+exploded[1]+")");
						$('#accept_div_'+exploded[1]+"_"+exploded[2]).css('color','green');						
					}
					
			});
		 
	});
</script> 
