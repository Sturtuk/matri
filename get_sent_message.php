<?php
session_start();
include('lib/myclass.php');
$from=$_REQUEST['From'];
$to=$_REQUEST['To'];
$select_new_msgs = "select * from messages where to_mem = '".$from."' and from_mem='".$to."' order by id desc";
$messages = $obj->select($select_new_msgs);
//$read="update messages set is_read=1 where from_mem='".$to."' and to_mem='".$from."'";
//$obj->edit($read);
if(!empty($messages))
{ 
		for($lpcntrl=0;$lpcntrl<count($messages); $lpcntrl++){
			
			$muser="SELECT members.*,member_photos.photo FROM members 
				LEFT JOIN member_photos ON members.id = member_photos.member_id
				WHERE
			 	members.member_id = '".$messages[$lpcntrl]['from_mem']."'";	
				$dbmuser=$obj->select($muser);
				if($dbmuser[0]['gender']=='M' && $dbmuser[0]['photo']!='')
				{
					$pic="<img src='upload/".$dbmuser[0]['photo']."' height='25' width='25' class='ol-prfl-img' />";
				}
				else
				{
					$pic="<img src='images/male-user1.png' height='25' width='25' class='ol-prfl-img' />";
				}
				if($dbmuser[0]['gender']=='F' && $dbmuser[0]['photo']!='')
				{
					$pic1="<img src='upload/".$dbmuser[0]['photo']."' height='25' width='25' class='ol-prfl-img' />";
				}
				else
				{
					$pic1="<img src='images/female-user1.png' height='25' width='25' class='ol-prfl-img' />";
				}
				?>
                <li>
      <div class="msgChatIn">
          <a href="#">
           <?php if($dbmuser[0]['gender']=='F')
			{
				echo $pic1;
			}
			else
			{
				echo $pic;
			}
			?>
         </a>
          <div class="chatMsgCont">
              <a href="#"><span class="chatMsgName"><?php echo  ucfirst($dbmuser[0]['name']); ?></span></a>
<span class="chatMsgText"><?php echo $messages[$lpcntrl]['message']; ?></span>
              <span class="chatMsgDate"><?php echo date('d M Y', strtotime($messages[$lpcntrl]['send_date'])); ?></span>
          </div>
      </div>
  </li>
                <?php
		}
}?>
