<?php

include('../lib/myclass.php');

	$insert="INSERT into messages(id, from_mem,to_mem,message)
			 values
			 		(NULL,'".$_POST['from_user']."','".$_POST['to_user']."','".$_POST['message']."')";
	$db_ins=$obj->insert($insert);
	
	echo "<script> window.location.href = '../view_profile.php?id=".$_POST['member_id']."' </script>";
?>