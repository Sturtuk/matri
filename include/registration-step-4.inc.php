	<?php
	
		if(isset($_POST['submit']))
	
		{
				
			$mem_hobbies = implode(",",$_POST['chkHobbies']);
	
			$final_mem_hobbies["mem_hobbies"] = ($mem_hobbies);
	
			
	
			$mem_int = implode(",",$_POST['chkInterests']);
	
			$final_mem_int["mem_int"] = ($mem_int);
	
			
	
			$mem_music = implode(",",$_POST['chkMusic']);
	
			$final_mem_music["mem_music"] = ($mem_music);
	
			
	
			$mem_read = implode(",",$_POST['chkRead']);
	
			$final_mem_read["mem_read"] = ($mem_read);
	
			
	
			$mem_movies = implode(",",$_POST['chkMovies']);
	
			$final_mem_movies["mem_movies"] = ($mem_movies);
	
			
	
			$mem_sports = implode(",",$_POST['chkSports']);
	
			$final_mem_sports["mem_sports"] = ($mem_sports);
	
			
	
			$mem_couisine = implode(",",$_POST['chkCouisine']);
	
			$final_mem_couisine["mem_couisine"] = ($mem_couisine);
	
			
	
			$mem_dress = implode(",",$_POST['chkDress']);
	
			$final_mem_dress["mem_dress"] = ($mem_dress);
	
			
	
			$mem_lang = implode(",",$_POST['chkLang']);
	
			$fianl_mem_lang["mem_lang"] = ($mem_lang);
	
				
	
			$select_last_id = "SELECT id as last_id,mob_code,mobile_no,email_id from members where id = '".$_SESSION['inserted_id']."'";
	
			$last_id = $obj->select($select_last_id); 	
			
			$insert = "insert into memebr_hobbies_interest
	
							(id,member_id,hobbies,interests,music,read_book,movies,sports,cuisine,dress_style,spoken_lang)
	
						VALUES
	
							(NULL,'".$last_id['0']['last_id']."','".$final_mem_hobbies["mem_hobbies"]."',
	
							 '".$final_mem_int["mem_int"]."','".$final_mem_music["mem_music"]."',
	
							 '".$final_mem_read["mem_read"]."','".$final_mem_movies["mem_movies"]."',
	
							 '".$final_mem_sports["mem_sports"]."','".$final_mem_couisine["mem_couisine"]."',
	
							 '".$final_mem_dress["mem_dress"]."','".$fianl_mem_lang["mem_lang"]."')";
	
			
	
			
	
			$result = $obj->insert($insert);	
	
			
	
			$update_mem_int = "update members 
	
							  set
	
							  Interest = '".$final_mem_int["mem_int"]."'
	
							  where
	
							  id = '".$last_id['0']['last_id']."'";
	
			$update_sql = $obj->edit($update_mem_int);
	
							  
	
                        $db_ins=$_SESSION['inserted_id'];
	
                        $rand=mt_rand(100000,999999); 
	
	///// Sms gateway integration - Krupa ///
	
	$mobileno = $last_id['0']['mob_code'].$last_id['0']['mobile_no'];
	$mobileno = substr($mobileno,1);
	
	$ch = curl_init('http://www.txtguru.in/imobile/api.php?');
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, "username=findmyjoditrans&password=Ganesha@1985&source=senderid&dmobile=$mobileno&message=Thank you for registering with our site. Use Following code for activating your account.  $rand ");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	$data = curl_exec($ch);
        curl_close($ch);
	////////////////////////////////////////////////////
	/*$url = 'http://203.124.105.204/smsapi/pushsms.aspx';
	$fields = array(
						'user' =>'reddymax', //reddymax	14378
						'pwd' =>'reddymax@123', //Reddy123	xu6170DI
						'sid' =>'CATHUB',
						'to' =>$_REQUEST['txtMobNo'],
						'msg' =>'Thank you for registering with our site. Use Following code for activating your account '.$rand,
						'fl' =>0,
						'gwid' =>2
				    );
					
	foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
	rtrim($fields_string, '&');
	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL, $url);
	curl_setopt($ch,CURLOPT_POST, count($fields));
	curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($ch);
	curl_close($ch);*/
	
	$updt="update members set Activation_code='".$rand."' where id='".$db_ins."'";
	$obj->edit($updt);
	
		
		$to=$last_id['0']['email_id'];
		$subject = "Registration with Find My Jodi";
		
		$loginurl = $obj->SITEURL."activation.php?uid=".base64_encode($db_ins);
		$message = '<div style="width:98%;border:1px solid #ccc;padding:10px;border-radius:5px">
			<a href="'.$obj->SITEURL.'"><img src="'.$obj->SITEURL.'images/logo2.png" height="100" width="160" /></a><br /><br />';
		$message .= '<strong>Dear Sir/Madam,</strong><br /><br />';
		
		$message .= "Congrats!..You have successfully registered with our site<br /><br />
					To activate your account <a href='".$obj->SITEURL."activation.php?uid=".base64_encode($db_ins)."' style='font-size:13px; font-weight:bold;'>Click Here</a><br><br>
							 Your registration detail is as follow:<br>
							 Email ID : ". $last_id['3']['email_id']."<br />
							 Password : ".$last_id['4']['password']."<br /><br />";					
		//$message.= "To activate your account. <a href='".$loginurl."'><strong>Click here</strong></a>\n\n";
		
		$message.= "<br /><br /><strong>Thank You,</strong><br />";
		$message.= "<strong>Find My Jodi</strong><br />";
		$message .= '</div>';
					 
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";	
		$headers .= 'From: Find My Jodi <info@findmyjodi.com>';
		if(mail($to,$subject,$message,$headers))
		{
			
			echo "<script> window.location.href='activation.php?uid=".base64_encode($db_ins)."';</script>";
			}
	
	
	
	
			//echo "<script>window.location='packages.php?redirect=account'</script>";	
	
			}
	
	     if($_REQUEST["skip"]==1){
                 $rand=mt_rand(100000,999999);  
                 $select_last_id = "SELECT id as last_id,mob_code,mobile_no,email_id from members where id = '".$_SESSION['inserted_id']."'";
	
			$last_id = $obj->select($select_last_id); 
                 $db_ins=$_SESSION['inserted_id'];
                 $mobileno = $last_id['0']['mob_code'].$last_id['0']['mobile_no'];
	$mobileno = substr($mobileno,1);
	
	$ch = curl_init('http://www.txtguru.in/imobile/api.php?');
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, "username=findmyjoditrans&password=Ganesha@1985&source=senderid&dmobile=$mobileno&message=Thank you for registering with our site. Use Following code for activating your account.  $rand ");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	$data = curl_exec($ch);
        curl_close($ch);
	
	$updt="update members set Activation_code='".$rand."' where id='".$db_ins."'";
	$obj->edit($updt);
	
		
		$to=$last_id['0']['email_id'];
		$subject = "Registration with Find My Jodi";
		
		$loginurl = $obj->SITEURL."activation.php?uid=".base64_encode($db_ins);
		$message = '<div style="width:98%;border:1px solid #ccc;padding:10px;border-radius:5px">
			<a href="'.$obj->SITEURL.'"><img src="'.$obj->SITEURL.'images/logo2.png" height="100" width="160" /></a><br /><br />';
		$message .= '<strong>Dear Sir/Madam,</strong><br /><br />';
		
		$message .= "Congrats!..You have successfully registered with our site<br /><br />
					To activate your account <a href='".$obj->SITEURL."activation.php?uid=".base64_encode($db_ins)."' style='font-size:13px; font-weight:bold;'>Click Here</a><br><br>
							 Your registration detail is as follow:<br>
							 Email ID : ". $last_id['3']['email_id']."<br />
							 Password : ".$last_id['4']['password']."<br /><br />";					
		//$message.= "To activate your account. <a href='".$loginurl."'><strong>Click here</strong></a>\n\n";
		
		$message.= "<br /><br /><strong>Thank You,</strong><br />";
		$message.= "<strong>Find My Jodi</strong><br />";
		$message .= '</div>';
					 
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";	
		$headers .= 'From: Find My Jodi <info@findmyjodi.com>';
		if(mail($to,$subject,$message,$headers))
		{
			
			echo "<script> window.location.href='activation.php?uid=".base64_encode($db_ins)."';</script>";
		}
             }
	
	?>
    <div  class="mid col-md-12 col-sm-12 col-xs-12">
 
 			<div class="cont_left col-md-8">
	        	<?php
		$select_banner = "select * from advertise where adv_position = 'Registration-step-4 Top (622 X 197)' AND status = 'Active'";
		$db_banner = $obj->select($select_banner);
		if(count($db_banner) > 0) 
		{
			if($db_banner[0]['banner_file'] != '') 
				{
					if(file_exists('upload/banners/'.$db_banner[0]['banner_file'])) {
		?>
		<div class="banner_inner"><a href="<?php echo $db_banner[0]['banner_link']; ?>" target="_blank"><img src="upload/banners/<?php echo $db_banner[0]['banner_file']; ?>" /></a></div>
		<?php } } } ?>
     		<h2 class="col-md-12">Enhance your profile with Hobbies & Interests</h2>
            
           <!--    <div class="backtolink col-md-12" style="padding:0px;margin-right:34px;"><a href="packages.php?redirect=account">Proceed to My Home »</a></div> -->
           <div class="backtolink col-md-12" style="padding-top:0px;margin-right:34px;"><a href="registration-step-4.php?skip=1">Skip this page »&nbsp&nbsp&nbsp</a></div>
 <form id="formID" class="form-horizontal col-md-12" method="post" >
    
    <div class="new_acc">     
           <?php $sql = "select * from hobbies";
			  $hobbies = $obj->select($sql);
			?> 
         <div class="hobbieslist-label">
     		 <h3 style="color:#C33">Hobbies</h3><hr />
            
             	<div class="list-chkbox col-md-12 col-xs-12 col-sm-12">
                 <?php   foreach($hobbies as $h) { 						 
				?>
                  		 <label class="col-md-4 col-xs-12 col-sm-6"><input class="form-control" type="checkbox" name="chkHobbies[]"  value="<?php echo $h['id']; ?>"><?php echo $h['name']; ?></label>
                        <?php }  ?>                
                </div>
             </div>
              <?php $sql = "select * from interest";
			  	   $interests = $obj->select($sql);
			?> 
             <div class="hobbieslist-label">
     		 <h3 style="color:#C33">Interests</h3><hr />
            
             	<div class="list-chkbox col-md-12 col-xs-12 col-sm-12">
                 <?php   foreach($interests as $int) { 
						 ?>
                  		 <label class="col-md-4 col-xs-12 col-sm-6"><input class="form-control" type="checkbox" name="chkInterests[]" value="<?php echo $int['id']; ?>"><?php echo $int['name']; ?></label>					
						 <?php }  ?>                
                </div>
             </div>
               <?php $sql = "select * from music";
			  	   $musics = $obj->select($sql);
			?> 
             <div class="hobbieslist-label">
     		 <h3 style="color:#C33">Favourite music</h3><hr />
            
             	<div class="list-chkbox col-md-12 col-xs-12 col-sm-12">
                 <?php   foreach($musics as $m) { 
		  			   	?>
                  		 <label class="col-md-4 col-xs-12 col-sm-6"><input class="form-control" type="checkbox" name="chkMusic[]" value="<?php echo $m['id']; ?>"
                        ><?php echo $m['name']; ?></label>											                 <?php }  ?>                
                </div>
             </div>
              <?php $sql = "select * from tbl_read";
			  	   $reads = $obj->select($sql);
			?> 
             <div class="hobbieslist-label">
     		 <h3 style="color:#C33">Favourite read</h3><hr />
            
             	<div class="list-chkbox col-md-12 col-xs-12 col-sm-12">
                 <?php   foreach($reads as $r) { 
				 		?>
                  		 <label class="col-md-4 col-xs-12 col-sm-6"><input class="form-control" type="checkbox" name="chkRead[]" value="<?php echo $r['id']; ?>"
                         ><?php echo $r['name']; ?></label>											                 <?php }  ?>                
                </div>
             </div>
                <?php $sql = "select * from movies";
			  	   $movies = $obj->select($sql);
			?> 
             <div class="hobbieslist-label">
     		 <h3 style="color:#C33">Favourite movie</h3><hr />
            
             	<div class="list-chkbox col-md-12 col-xs-12 col-sm-12">
                 <?php   foreach($movies as $m) { 
				 		 ?>
                  		 <label class="col-md-4 col-xs-12 col-sm-6"><input class="form-control" type="checkbox" name="chkMovies[]" value="<?php echo $m['id']; ?>"
                        ><?php echo $m['name']; ?></label>											                 <?php }  ?>                
                </div>
             </div>
             
                <?php $sql = "select * from activities";
			  	   $activities = $obj->select($sql);
			?> 
             <div class="hobbieslist-label">
     		 <h3 style="color:#C33">Sports/fitness activities</h3><hr />
            
             	<div class="list-chkbox col-md-12 col-xs-12 col-sm-12">
                 <?php   foreach($activities as $act) {
						 ?>
                  		 <label class="col-md-4 col-xs-12 col-sm-6"><input class="form-control" type="checkbox" name="chkSports[]" value="<?php echo $act['id']; ?>"
                          ><?php echo $act['name']; ?></label>											                 <?php }  ?>                
                </div>
             </div>
               
               
                   <?php $sql = "select * from couisine";
			  	   $couisine = $obj->select($sql);
			?> 
             <div class="hobbieslist-label">
     		 <h3 style="color:#C33">Favourite cuisine</h3><hr />
            
             	<div class="list-chkbox col-md-12 col-xs-12 col-sm-12">
                 <?php   foreach($couisine as $cou) {
						 ?>
                  		 <label class="col-md-4 col-xs-12 col-sm-6"><input class="form-control" type="checkbox" name="chkCouisine[]" value="<?php echo $cou['id']; ?>"
                          ><?php echo $cou['name']; ?></label>											                 <?php }  ?>                
                </div>
             </div>
               
               
                 <?php $sql = "select * from dress_style";
			  	     $couisine = $obj->select($sql);
				?> 
             <div class="hobbieslist-label">
     		 <h3 style="color:#C33">Preferred dressing style</h3><hr />
            
             	<div class="list-chkbox col-md-12 col-xs-12 col-sm-12">
                 <?php   foreach($couisine as $dre) { 
				 		  ?>
                  		 <label class="col-md-4 col-xs-12 col-sm-6"><input class="form-control" type="checkbox" name="chkDress[]" value="<?php echo $dre['id']; ?>"
                         ><?php echo $dre['name']; ?></label>											                 <?php }  ?>                
                </div>
             </div>  
                 <?php $sql = "select * from languages";
			  	   $couisine = $obj->select($sql);
				?> 
             <div class="hobbieslist-label">
     		 <h3 style="color:#C33">Spoken languages</h3><hr />
            
             	<div class="list-chkbox col-md-12 col-xs-12 col-sm-12">
                 <?php   foreach($couisine as $lang) { 
				 		   ?>
                  		 <label class="col-md-4 col-xs-12 col-sm-6"><input class="form-control" type="checkbox" name="chkLang[]" value="<?php echo $lang['id']; ?>"><?php echo $lang['name']; ?></label>											                 <?php }  ?>                
                </div>
             </div>       
             
 
             
         <br class="clear" />
                <div class="terms_line hobbies-submit" style="padding-left:0px;">
                
                <input class="btn btn-danger " class="form-control" type="submit" name="submit" value="Next" />
                </div>
              </div>  
                </form>
    </div>
    
    <div class="sidebarr col-md-4">
        	<div class="box contact">
                <h2>LIVE Support</h2>
                <p>Customer Service Help line:</p>
                <p>+91 9886355564</p>
                <p>Office Hours 8:00 AM to 6:00 PM (IST)<br /><span>[Sunday Holiday]</span></p>
           	</div>    
            <?php
			$select_banner_right = "select * from advertise where adv_position = 'Registration-step-4 Right (280 X 245)' AND status = 'Active'";
			$db_banner_right = $obj->select($select_banner_right);
			if(count($db_banner_right) > 0) 
			{
				if($db_banner_right[0]['banner_file'] != '') 
				{
					if(file_exists('upload/banners/'.$db_banner_right[0]['banner_file'])) {
			?>    
            <div class="box">
            	<a href="<?php echo $db_banner_right[0]['banner_link']; ?>" target="_blank"><img src="upload/banners/<?php echo $db_banner_right[0]['banner_file']; ?>" /></a>
            </div>
            <?php } } } ?>
            <div class="box" class="success_story">
            	<h2>Success Story</h2>
            	<?php 
					$select_success_story="select * from success_member_details where status='Approve' order by id DESC Limit 3"; 
					$db_success_story=$obj->select($select_success_story);
					for($i=0;$i<count($db_success_story);$i++)
					{
				?>
            	<div class="story_box">
                	<div class="story_img"><a href="view_success_story.php?id=<?php echo $db_success_story[$i]['id']; ?>"><img src="upload/<?php echo $db_success_story[$i]['photo']; ?>" /></a></div>
                    <div class="story_text">
                    	<a href="view_success_story.php?id=<?php echo $db_success_story[$i]['id']; ?>"><?php echo ucfirst($db_success_story[$i]['bride_name']); ?></a> | <a href="view_success_story.php?id=<?php echo $db_success_story[$i]['id']; ?>"><?php echo ucfirst($db_success_story[$i]['groom_name']); ?></a>
                        <br />
                        Marriage Date : <?php echo date('d-m-Y',strtotime($db_success_story[$i]['engag_or_marriage_date'])); ?>
                        <br />
                        <?php echo substr($db_success_story[$i]['story'],0,100); ?>
                    </div>
                </div>
                <?php } ?>
            </div>
            <div class="box">
            	<div class="fb-like-box" data-href="https://www.facebook.com/findmyjodi?ref=hl" data-colorscheme="light" data-show-faces="true" data-header="true" data-stream="false" data-show-border="false"></div>
            </div>
        </div>            
	                
</div>
<script>
$('#drpAgeFrom').change( function() {
	var age_from = $('#drpAgeFrom').val();
   
			$.ajax({
				url: 'makeAgeDrp.php',
				dataType: 'html',
				data: { age_from : age_from ,change_style : 'y'},
				success: function(data) {
					$('#age_to').html( data );
				}
			});	
});
</script>      
<style>
.test
{
	border:1px solid red;
	padding-top:20px;
	height:5px;
}
</style>
	