<?php 
session_start();
include('config.php'); 
$username = $_SESSION['username'];
$password = $_SESSION['password'];

$chat_username = $_SESSION['chat_username'];

$sql = "SELECT * FROM users WHERE username='$username' && password='$password'";
$re = mysqli_query($con,$sql);
$number = mysqli_num_rows($re);

if($number!=1)
{
  header('location:index.php');
}
?>
<?php

$sql_tik = "UPDATE chats SET rec_status='true' WHERE send_username='$chat_username'&&rec_username='$username'";
	$tic_res = mysqli_query($con,$sql_tik);
	
						$sql_chat = "SELECT * FROM chats WHERE (send_username='$username' && rec_username='$chat_username')||(send_username='$chat_username' && rec_username='$username') ORDER BY ID DESC" ;
						$row_res = mysqli_query($con,$sql_chat);
						while ($chat= $row_res->fetch_assoc()) 
						{
							$user_send = $chat["send_username"];
							$user_rec = $chat["rec_username"];
							$chat_content = $chat["content"];
							$chat_status = $chat["rec_status"];
							if($username==$user_send)
							{
								if($chat_status=='false')
								{
									echo "<div class='d-flex justify-content-end'>
			          					<p class='chat_right'>$chat_content <i class='fas fa-check' style='color: blue;font-size:12px'></i></p>
			        				  </div>";
			        			}
			        			else
			        			{
			        				echo "<div class='d-flex justify-content-end'>
			          					<p class='chat_right'>$chat_content <i class='fas fa-check-double' style='color: green' font-size:12px'></i></p>
			        				  </div>";
			        			}
							}
							else
							{
								echo "<div class='d-flex justify-content-start'>
			          					<p class='chat_left'>$chat_content</p>
			        				</div>";
							}
						}		

					?>