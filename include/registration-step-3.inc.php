<?php

	if(isset($_POST['submit']))

	{

		

			$pref_age = $_POST['drpAgeFrom']."to".$_POST['drpAgeTo'];

                $select_last_id = "SELECT id as last_id from members where id = '".$_SESSION['inserted_id']."'";

                $last_ins_id =  $obj->select($select_last_id);

		$insert = "insert into preferred_partner_details

				  	(from_mem,id,preferred_age,marital_status,height,physical_status,religion,mother_tongue,caste,manglik,star,food,is_drinker,is_smoker,country,city,education,occupation,annual_income,partner_description)

				  values

				    ('".$last_ins_id[0]['last_id']."',NULL,'".$pref_age."','".$_POST['drpMaritalStatus']."',

					 '".$_POST['drpHeight']."','".$_POST['drpPhysicalStatus']."','".$_POST['drpReligion']."',

					 '".$_POST['drpMotherlanguage']."','".$_POST['drpCaste']."','".$_POST['drpManglik']."',

					 '".$_POST['drpStar']."','".$_POST['drpFood']."','".$_POST['drpDrinking']."','".$_POST['drpSmoking']."'

					 ,'".$_POST['drpCountry']."','".$_POST['city']."','".$_POST['drpEducation']."','".$_POST['drpOccupation']."'

					 ,'".$_POST['drpAnnualIncome']."','".$_POST['partner_description']."')";



		$db_ins=$obj->insert($insert);

		

		echo "<script>window.location='registration-step-4.php'</script>";



	}



?>



<div  class="mid col-md-12 col-sm-12 col-xs-12">

	<div class="cont_left col-md-8">

      	<?php

		$select_banner = "select * from advertise where adv_position = 'Registration-step-3 Top (622 X 197)' AND status = 'Active'";

		$db_banner = $obj->select($select_banner);

		if(count($db_banner) > 0) 

		{

			if($db_banner[0]['banner_file'] != '') 

				{

					if(file_exists('upload/banners/'.$db_banner[0]['banner_file'])) {

		?>

		<div class="banner_inner"><a href="<?php echo $db_banner[0]['banner_link']; ?>" target="_blank"><img src="upload/banners/<?php echo $db_banner[0]['banner_file']; ?>" /></a></div>

		<?php } } } ?>

  <h2 style="width:622px;">Details about your preferred partner</h2>

  

  <div class="backtolink" style="padding-top:0px;margin-right:34px;"><a href="registration-step-4.php">Skip this page »&nbsp&nbsp&nbsp</a></div>

  <form id="formID" class="form-horizontal" method="post" >

    <div class="new_acc">

      <table width="100%" align="center" border="0" cellpadding="5" cellspacing="0">

        <tr>

            <td width="20%"><label style="margin-top:-18px">Preferred Age</label></td>

            <td>

            <div class="preff-age" style="margin-left:0px;">

                <select class="form-control col-md-4 col-xs-4 col-sm-4" name="drpAgeFrom" id="drpAgeFrom" style="width:70px;" tabindex="0">

                  <?php for($i=19;$i<=50;$i++) { ?>

                  <option value="<?php echo $i; ?>"><?php echo $i; ?></option>

                  <?php } ?>

                </select>

                <span>to</span>

                <div id="age_to">

                  <select class="form-control col-md-4 col-xs-4 col-sm-4" name="drpAgeTo" id="drpAgeTo" style="width:70px;"  tabindex="1">

                    <?php for($i=20;$i<=50;$i++) { ?>

                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>

                    <?php } ?>

                  </select>

                </div>

              </div>
              <span style="clear: both; float: left;">&nbsp;</span>

            </td>

        </tr>

        <tr>

            <td width="20%"><label style="margin-top:-18px">Marital Status</label></td>

            <td><select class="form-control col-md-12 col-xs-12 col-sm-12" id="drpMaritalStatus" name="drpMaritalStatus"  tabindex="2" style="clear:none;">

				<?php $sql = "select * from relationship_status"; 

                              $result = $obj->select($sql); ?>

                <option value="">-Select-</option>

                <?php

                                    foreach($result as $res)

                                    { ?>

                <option value="<?php echo $res['status']; ?>"><?php echo $res['status']; ?></option>

                <?php } ?>

              </select><span>&nbsp;</span></td>

		</tr>    

        <tr>

            <td width="20%"><label style="margin-top:-18px">Height</label></td>

            <td><select class="form-control col-md-12 col-xs-12 col-sm-12" id="drpHeight" name="drpHeight"  tabindex="3" style="clear:none;">

                    <option value="">- Feet/Inches -</option>

                    <?php 

							$select_height="select * from height";

							$db_height=$obj->select($select_height);

							for($i=0;$i<count($db_height);$i++){

							?>

                           <option value="<?php echo $db_height[$i]['Id']; ?>"><?php echo $db_height[$i]['Ft_val'].'ft '.$db_height[$i]['In_val'].'in'; if($db_height[$i]['Cm_val']!=''){ echo ' - '.$db_height[$i]['Cm_val'].'cm'; } ?></option>

                           <?php } ?>

                  </select><span>&nbsp;</span></td>

		</tr> 

        <tr>

            <td width="20%"><label style="margin-top:-18px">Physical status</label></td>

            <td><select class="form-control col-md-12 col-xs-12 col-sm-12" id="drpPhysicalStatus" name="drpPhysicalStatus"  tabindex="4" style="clear:none;">

                    <option value="">-Select-</option>

                    <option value="normal">Normal</option>

                    <option value="physically_challenged">Physically challenged</option>

                  </select><span>&nbsp;</span></td>

		</tr>   

        <tr>

            <td width="20%"><label style="margin-top:-18px">Religion</label></td>

            <td>

            <?php

				$religion_list = "select * from religions";

				$data = $obj->select($religion_list);

			?>

		  <select class="form-control col-md-12 col-xs-12 col-sm-12" name="drpReligion" id="drpReligion" tabindex="5" style="clear:none;">

			<option value=""> -Select- </option>

			<?php foreach($data as $res) { ?>

			<option value="<?php echo $res['religion']; ?>"><?php echo $res['religion']; ?></option>

			<?php } ?>

		  </select><span>&nbsp;</span>

            </td>

		</tr>

         <?php

			$list = "select * from mother_tongues";

			$data = $obj->select($list);

		?>

        <tr>

            <td width="20%"><label style="margin-top:-18px">Mother Tongue</label></td>

            <td><select class="form-control col-md-12 col-xs-12 col-sm-12" name="drpMotherlanguage" id="drpMotherlanguage" tabindex="6" style="clear:none;" />     

                  <option value=""> -Select- </option>

                  <?php foreach($data as $res) { ?>

                  <option value="<?php echo $res['name']; ?>"><?php echo $res['name']; ?></option>

                  <?php } ?>

                  </select><span>&nbsp;</span></td>

		</tr>

        <tr>

            <td width="20%"><label style="margin-top:-18px">Caste</label></td>

            <td><?php

				$caste_list = "select * from caste"; 

				$data = $obj->select($caste_list);

			  ?>

			  <select class="form-control col-md-12 col-xs-12 col-sm-12" name="drpCaste" id="drpCaste" tabindex="7" style="clear:none;">

				<option value=""> -Select- </option>

				<?php foreach($data as $res) { ?>

				<option value="<?php echo $res['caste']; ?>"><?php echo $res['caste']; ?></option>

				<?php } ?>

			  </select><span>&nbsp;</span></td>

        </tr>

        <tr>

            <td width="20%"><label style="margin-top:-18px">Manglik</label></td>

            <td><select class="form-control col-md-12 col-xs-12 col-sm-12" id="drpManglik" name="drpManglik"  tabindex="8" style="clear:none;">

                <option value="">--Select--</option>

                <option value="N">No</option>

                <option value="Y">Yes</option>

                <option value="">Don't know</option>

              </select><span>&nbsp;</span></td>

        </tr>

        <tr>

            <td width="20%"><label style="margin-top:-18px">Star</label></td>

            <td><select class="form-control col-md-12 col-xs-12 col-sm-12" id="drpStar" name="drpStar"  tabindex="9" style="clear:none;">

                <option value="">--Select--</option>

                <?php

                                    $sql = "select * from horoscope_star_master";

                                    $ans = $obj->select($sql);

                                    foreach($ans as $a){?>

                <option value="<?php echo $a['star']; ?>"><?php echo $a['star']; ?></option>

                <?php } ?>

                <option value="N">No</option>

                <option value="Y">Yes</option>

                <option value="">Don't know</option>

              </select><span>&nbsp;</span></td>

        </tr>

        <tr>

            <td width="20%"><label style="margin-top:-18px">Eating Habits</label></td>

            <td><select class="form-control col-md-12 col-xs-12 col-sm-12" id="drpFood" name="drpFood"  tabindex="10" style="clear:none;">

                    <option value="">--Select--</option>

                    <option value="vegetarian">Vegetarian</option>

                    <option value="non-vegetarian">Non-Vegetarian</option>

                    <option value="eggetarian">Eggetarian</option>

                  </select><span>&nbsp;</span></td>

        </tr>

        <tr>

            <td width="20%"><label style="margin-top:-18px">Smoking Habits</label></td>

            <td><select class="form-control col-md-12 col-xs-12 col-sm-12" id="drpSmoking" name="drpSmoking"  tabindex="11" style="clear:none;">

                <option value="">--Select--</option>

                <option value="N">No</option>

                <option value="Y">Yes</option>

                <option value="O">Occasionally</option>

              </select><span>&nbsp;</span></td>

        </tr>

        <tr>

            <td width="20%"><label style="margin-top:-18px">Drinking Habits</label></td>

            <td>

            <select class="form-control col-md-12 col-xs-12 col-sm-12" id="drpDrinking" name="drpDrinking"  tabindex="12" style="clear:none;">

                <option value="">--Select--</option>

                <option value="N">No</option>

                <option value="Y">Yes</option>

                <option value="O">Occasionally</option>

              </select><span>&nbsp;</span>

            </td>

        </tr> 

        <tr>

            <td width="20%"><label style="margin-top:-18px">Country Living In</label></td>

            <td><?php

		$country_list = "select * from mobile_codes";

		$data = $obj->select($country_list);

	?>

      <select class="form-control col-md-12 col-xs-12 col-sm-12" name="drpCountry" id="drpCountry"  tabindex="13" style="clear:none;"/>

      

      <option value="">- Select -</option>

      <?php foreach($data as $res) { ?>

      <option value="<?php echo $res['country']; ?>"><?php echo $res['country']; ?></option>

      <?php } ?>

      </select><span>&nbsp;</span></td>

        </tr>

        <tr>

            <td width="20%"><label style="margin-top:-18px">Residing city</label></td>

            <td><input class="form-control col-md-12 col-xs-12 col-sm-12" type="text" name="city" id="city" tabindex="14" style="clear:none;">
            <span>&nbsp;</span></td>

        </tr>

        <tr>

            <td width="20%"><label style="margin-top:-18px">Education</label></td>

            <td><select class="form-control col-md-12 col-xs-12 col-sm-12" id="drpEducation" name="drpEducation"  tabindex="15" style="clear:none;">

        <option value="">--Select--</option>

					<?php

					$level="SELECT education_details.* FROM `education_details` join education_course on Eid=education_details.id group by education_details.id";

					

				//	SELECT e.*,c.* FROM education_details e JOIN education_course c ON e.id = c.Eid

					$sel=$obj->select($level);

					for($i=0;$i<count($sel);$i++)

					{

					 ?>

                     <optgroup label="--<?php echo $sel[$i]['degree']; ?>--" class="a">

                     

                     <?php	$course="select * from education_course where Eid='".$sel[$i]['id']."'";

					 		$cor=$obj->select($course);

					 		for($j=0;$j<count($cor);$j++)

							{

					 ?>        

                            <option value="<?php echo $cor[$j]['Id'];?>"><?php echo $cor[$j]['Title'];?></option>

                            <?php } ?>

                     </optgroup>

                          <?php } ?> 

      </select><span>&nbsp;</span></td>

        </tr>

        <tr>

            <td width="20%"><label style="margin-top:-18px">Occupation</label></td>

            <td><select class="form-control col-md-12 col-xs-12 col-sm-12" id="drpOccupation" name="drpOccupation"  tabindex="16" style="clear:none;">

                

                <?php

                                $sql = "select * from occupation_master";

                                $ans = $obj->select($sql);

                                foreach($ans as $a)

                                { ?>

                <option value="<?php echo $a['occupation']; ?>"><?php echo $a['occupation']; ?></option>

                <?php }

                               ?>

              </select><span>&nbsp;</span></td>

        </tr>

        <tr>

            <td width="20%"><label style="margin-top:-18px">Annual Income</label></td>

            <td><select class="form-control col-md-12 col-xs-12 col-sm-12" id="drpAnnualIncome" name="drpAnnualIncome"  tabindex="17" style="clear:none;">

        <option value="">--Select--</option>

        <?php

							$sql = "select * from annual_income_master";

							$ans = $obj->select($sql);

							foreach($ans as $a)

							{ 

							if(($a['annual_income']!="Optional") && ($a['annual_income'] != "Any" )){ ?>

        <option value="<?php echo $a['annual_income']; ?>"><?php echo $a['annual_income']; ?></option>

        <?php } } ?>

      </select><span>&nbsp;</span></td>

        </tr>

        <tr>

            <td width="20%"><label style="margin-top:-18px">Partner Description</label></td>

            <td>
            <textarea name="partner_description" id="partner_description" rows="3" cols="42" tabindex="18" style='clear:none;' class="form-control col-md-12 col-sm-12 col-xs-12"></textarea>
            </td>

        </tr>                           

	  </table>        

      <br class="clear" />

      <div class="terms_line">

        <input class="btn btn-danger " type="submit" class="form-control col-md-12 col-xs-12 col-sm-12" value="Next" name="submit" tabindex="19" />

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

			$select_banner_right = "select * from advertise where adv_position = 'Registration-step-3 Right (280 X 245)' AND status = 'Active'";

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

