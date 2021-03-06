<?php
if(isset($_GET['gender']))
{
	$sql = "SELECT members.*,member_photos.photo             
			FROM members   
			LEFT JOIN member_photos           
			ON members.id=member_photos.member_id
			where is_deleted = 'N' and gender = '".$_GET['gender']."' order by members.id DESC"; 

			

	$res=$obj->select($sql);
}
else if(isset($_GET['religion']))
{
	$sql = "SELECT members.*,member_photos.photo             
			FROM members   
			LEFT JOIN member_photos           
			ON members.id=member_photos.member_id
			where is_deleted = 'N' and religion like '".$_GET['religion']."%' order by members.id DESC";
				

	$res=$obj->select($sql);	
}
else if(isset($_GET['del']))
{
	$sql = "SELECT members.*,member_photos.photo             
			FROM members   
			LEFT JOIN member_photos           
			ON members.id=member_photos.member_id
			where is_deleted = 'N' and is_deleted= '".$_GET['del']."' order by members.id DESC";
		
	$res=$obj->select($sql);
}
else
{
/*	$sql = "SELECT * FROM members ,photo from member_photos
			JOIN member_photos ON members.id = member_photos.member_id 
			where is_deleted = 'N' order by members.id"; */
	$sql = "SELECT members.*,member_photos.photo             
			FROM members   
			LEFT JOIN member_photos           
			ON members.id=member_photos.member_id
			where is_deleted = 'N' order by members.id DESC";		
	$res=$obj->select($sql);	
}
if(isset($_GET['id']))
{
	$sqld="update members set is_deleted = 'Y' where id = '".$_GET['id']."' ";
	$obj->sql_query($sqld);
	echo "<script> window.location.href = 'list_members.php' </script>";	
}
//query to check access permission
$sql3="select * from  admin where id='".$_SESSION['id']."'";
$ans3=$obj->select($sql3);	
$sql2="select * from  role where id='".$ans3[0]['role_id']."'";
$ans2=$obj->select($sql2);	
$mem_permission = explode(",",$ans2[0]['member_access']); 
$story_permission = explode(",",$ans2[0]['member_story_access']); 
$plan_permission = explode(",",$ans2[0]['member_plan_access']); 
//end
?>
<style>
.details { display:none; }
</style>
<div class="page-content">
    <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
    <div id="portlet-config" class="modal hide">
        <div class="modal-header">
            <button data-dismiss="modal" class="close" type="button"></button>
            <h3>portlet Settings</h3>
        </div>
        <div class="modal-body">
            <p>Here will be a configuration form</p>
        </div>
    </div>
    <!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
    <!-- BEGIN PAGE CONTAINER-->        
    <div class="container-fluid">
        <!-- BEGIN PAGE HEADER-->
        <div class="row-fluid">
            <div class="span12">
                <!-- BEGIN STYLE CUSTOMIZER -->
                <div class="color-panel hidden-phone">
                    <div class="color-mode-icons icon-color"></div>
                    <div class="color-mode-icons icon-color-close"></div>
                    <div class="color-mode">
                        <p>THEME COLOR</p>
                        <ul class="inline">
                            <li class="color-black current color-default" data-style="default"></li>
                            <li class="color-blue" data-style="blue"></li>
                            <li class="color-brown" data-style="brown"></li>
                            <li class="color-purple" data-style="purple"></li>
                            <li class="color-grey" data-style="grey"></li>
                            <li class="color-white color-light" data-style="light"></li>
                        </ul>
                        <label>
                            <span>Layout</span>
                            <select class="layout-option m-wrap small">
                                <option value="fluid" selected>Fluid</option>
                                <option value="boxed">Boxed</option>
                            </select>
                        </label>
                        <label>
                            <span>Header</span>
                            <select class="header-option m-wrap small">
                                <option value="fixed" selected>Fixed</option>
                                <option value="default">Default</option>
                            </select>
                        </label>
                        <label>
                            <span>Sidebar</span>
                            <select class="sidebar-option m-wrap small">
                                <option value="fixed">Fixed</option>
                                <option value="default" selected>Default</option>
                            </select>
                        </label>
                        <label>
                            <span>Footer</span>
                            <select class="footer-option m-wrap small">
                                <option value="fixed">Fixed</option>
                                <option value="default" selected>Default</option>
                            </select>
                        </label>
                    </div>
                </div>
                <!-- END BEGIN STYLE CUSTOMIZER -->  
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    List Members
                </h3>
                <ul class="breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="dashboard.php">Home</a> 
                        <i class="icon-angle-right"></i>
                    </li>
                    <li>
                        <a href="list_user.php">List Members</a>                        
                    </li>
                    
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <!-- END PAGE HEADER-->
        <!-- BEGIN PAGE CONTENT-->
        <div class="row-fluid">
            <div class="span12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="" style="margin-bottom:10px; float:right">
                    <a href="add_new_member.php"><button id="sample_editable_1_new" class="btn green">
                    Add New <i class="icon-plus"></i>
                    </button></a>
                    <a href="inactive_members.php"><button id="sample_editable_1_new" class="btn green">
                     Deactivated Members                               
                     </button></a>
                     <a href="search_members.php"><button id="sample_editable_1_new" class="btn green">
                     Search Members                                
                     </button></a>
                </div>
                <div class="portlet box green">
                    <div class="portlet-title">
                        <div class="caption"><i class="icon-globe"></i>List Members</div>
                        
                    </div>
                    
                    <div class="portlet-body">
                    <form  method="post" id="form_sample_2" name="form_sample_3" class="form-horizontal" enctype="multipart/form-data">
                        <table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
                        <?php if(!empty($res)) { ?>
	                        <thead>
                                <tr>
                                	<th style="display:none"></th>
                                	<th width="25px">#</th>
                                    <th>Photo</th>
                                    <th>ID</th> 
                                    <th>Full Name</th>
                                    <th>Membership</th>
                                     <th>Date</th>   
                                    <th>Gender</th>
                                    <th>Status</th>
                                    <th>Manage</th>      
                                </tr>
                            </thead>
                             
                            <tbody>
                             <?php  for($i=0;$i<count($res);$i++){
									$sql = "SELECT members.*,member_plans.plan_id,member_plans.member_id,
											 member_plans.paypal_transec_id,member_plans.purchase_date FROM members,member_plans 
											 where 
											 members.id=member_plans.member_id and
											 members.id = '".$res[$i]['id']."' order by purchase_date DESC";
									$plans=$obj->select($sql);
								 ?>
                                <tr class="odd gradeX">
                                	<td style="display:none"></td>
                                	<td><?php echo ($i+1);?></td>
                                    <td><?php
											if($res[$i]['photo']!='')
											{
												$path =  "../upload/".$res[$i]['photo'];
												
												list($width, $height, $type, $attr) = getimagesize($path);
												if($width > 200)
												{
													
													$height = (($height*200)/$width);
													$width = 200;
												}
												else
												{
													
													$width = (($width*200)/$height);
													$height = 200;
												}
												
												if (file_exists($path)) { 
													//echo '<img class="size" src="'.$path.'"/>';
													echo '<a href="javascript:;" class="popper" data-popbox="pop'.$i.'"><img src="'.$path.'" width="50px" height="50px" /></a>';
													echo '<div id="pop'.$i.'" class="popbox"><img src="'.$path.'" width="'.$width.'"  height="'.$height.'" /></div>';
													}else{
													if($res[$i]['gender']=='M')	
														echo '<img class="size" src="../images/male-user1.png"/>';
													else
														echo '<img class="size" src="../images/female-user1.png"/>';
												}
											}
											else
											{
												if($res[$i]['gender']=='M')	
													echo '<img class="size" src="../images/male-user1.png"/>';
												else
													echo '<img class="size" src="../images/female-user1.png"/>';
											}
										?>
                                    </td>
                                    <td><?php echo $res[$i]['member_id'];?></td>	
	                                <td><?php echo $res[$i]['name'];?></td>	
                                    <td><?php
									if(empty($plans))
									{
										echo '<a href="#" class="btn mini yellow">'."Free".'</a>';
									}
									else
									{
										echo '<a href="#" class="btn mini green">'."Paid".'</a>';
									}
									 ?></td>
                                     <td><?php echo date('d M Y',strtotime($res[$i]['reg_date']));?></td>	
                                    <td><?php if($res[$i]['gender'] == "F") { echo '<a href="#" class="btn mini pink">'."Female".'</a>'; } else { echo '<a href="#"  class="btn mini blue">'."Male".'</a>'; }?></td>	
                                    <td><?php if($res[$i]['status']=="Active"){ echo '<a href="#" class="btn mini green">'.$res[$i]['status'].'</a>';}else { echo '<a href="#" class="btn mini orange">'."Inactive".'</a>';} ?></td>	                                    
                                    <td width="80px"><a href="manage_member.php?id=<?php echo $res[$i]['id']; ?>" class="btn mini purple"><i class="icon-edit"></i>Manage</a></td>                                        
                                </tr>
                                <? }?>                              
                            </tbody>
                            <?php }
							else{
								echo "No Records Found";
								} ?>
                        </table>
                        </form>
                    </div>
                </div>
                
            </div>
        </div>
        <!-- END PAGE CONTENT-->
    </div>
    <!-- END PAGE CONTAINER-->
</div>
<script type="text/javascript">
	function doYouWantTo(id){}
</script>
<style>
.size
{
	width:50px;
	height:50px;
}
</style>