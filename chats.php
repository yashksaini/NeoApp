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
	$rs = $con->query($sql);
  	$row = $rs->fetch_assoc();
  	$full_name = $row["first_name"]." ".$row["last_name"];
  	$f_name_i = $row["first_name"];

  	$sql1 = "SELECT * FROM profile WHERE username='$username' ";
	$re1 = mysqli_query($con,$sql1);
	$rs1 = $con->query($sql1);
	$rows = $rs1->fetch_assoc();
	$imagei = $rows["image"];

?>


<!-- HTML Start -->
<?php echo "$html_start";?>
<style type="text/css">
	.searchbox{
  height: 60px;
  width: 100%;
  background-color: #fff;
  border-radius: 8px;
  padding: 12px;
  margin-bottom: 12px; 
}

.friends{
	  display: flex;
  align-items: center;
  justify-content: center;
  padding: 14px;
  min-height: 100px;
  height: auto;
  background-color: white;
  border-radius: 8px;
}
.searchbar{
	width: 80%;
}

.searchbutton{
	width: 20%;
}

.searchbutton button{
	width: 100%;
	background-color: #2496FF;
	border:none;
}

.searchbutton button:hover{
	border: 1.32px solid #2496FF;
	color: #000;
	background-color: #fff;
}


.friendbox{
  display: flex;
  align-items: center;
  padding: 12px;
  min-height: 80px;
  height: auto;
  background-color: #fff;
  border-radius: 8px;
  width: 450px;
  border: 1px solid #03030336;
  border-radius:8px;
}
.profile_img{
	width: 58px;
	height: 58px;
	border-radius: 200px;
}

.friendbox .profile_name{
	display:flex;
	flex-direction: column;
	justify-content: center;
	margin-left: 18px;
}
.friendbox h4{
	font-size: 22px;
	font-weight: bold;
	margin-bottom: -8px;
}

.friendbox p{
	padding-top: 4px;
	font-size: 16px;
	margin: 0px;
}

.friendbox button{
	margin-left: auto;
	width: 30%;
	margin-top:6px;
	background-color: #2496FF;
	border:none;
}
.friendbox button:hover{
	border: 1.32px solid #2496FF;
	color: #000;
	background-color: #fff;
}
	.chat_left
    {
      border-radius:20px;
      min-width:50px;
      max-width:80%; 
      padding: 20px;
      background-color: #4c68d7;
      color:white;
      border-bottom-left-radius: 0px;
      margin-top: 5px;
      text-align: left;
      display: inline-block;
    }
    .chat_right
    {
      border-radius:20px;
      min-width:50px;
      max-width:80%; 
      padding: 20px;
      background-color: #dfdfdf;
      color:black;
      border-bottom-right-radius: 0px;
      margin-top: 5px;
      text-align: right;
      display: inline-block;
    }
    .i_image
	{
		width: 80px;
		height: 80px;
		border-radius: 100px;
		box-shadow: 0 0 2px;
	}
	#color4
	{
		color:#2496FF;
	}
</style>

<body>
<!-- Menu Bar -->
<?php echo"$menu_bar";?>

	<div class="container-fluid " style="margin-top: 60px;">
  		<div class='row'>
  			
			  	<div class="col-md-6" style="max-height: calc(100vh - (30px + 30px));overflow-y: scroll;">
			  		<h4 class="mt-3" style="text-align: center;"><?php 
			  	$getreq = "SELECT * FROM friends 
			  	WHERE(user_send = '$username' || user_rec='$username' )&&send_status='true'&&rec_status='true' ORDER BY ID DESC";
			  	$req_res = mysqli_query($con,$getreq);

			  	$numb_req = mysqli_num_rows($req_res);
			  	echo"$numb_req";?> Friend </h4>

		<?php 

		$getreq = "SELECT * FROM friends 
					WHERE (user_send = '$username' || user_rec='$username' )&&send_status='true'&&rec_status='true' ORDER BY timestamp DESC";
		  			$req_res = mysqli_query($con,$getreq);

		  			$numb_req = mysqli_num_rows($req_res);
					if($numb_req>0)
					{
		  				while($row_req = $req_res->fetch_assoc()) 
		 			{
					 	$user_send = $row_req["user_send"];
					 	if($user_send==$username){
					 		$user_send = $row_req["user_rec"];
 						}

				 	$get = "SELECT * FROM profile WHERE username='$user_send'";
				 	$req_get = mysqli_query($con,$get);
				 	$show = $req_get->fetch_assoc();

				 	$req_image = $show["image"];
				 	$req_username = $show["username"];
				 	$req_full_name = $show["full_name"];

				 	$sql_chat_count = "SELECT * FROM chats WHERE send_username='$req_username'&& rec_username='$username' && rec_status='false'";
				 	$chat_count_res = mysqli_query($con,$sql_chat_count);
				 	$num_rows_chat = mysqli_num_rows($chat_count_res);


			 	if($num_rows_chat>0)
			 	{
			 		echo "
					<div class='container-fluid mb-1'>
				      <div class='row'>
				        <div class='col-md-12'>
				          <div class='friends'>
				            <form  method='post'action='current_chat.php' class='friendbox'>
				                <img src='images/$req_image' class='profile_img'>
				                <div class='profile_name'>
				                  <h4> $req_full_name</h4>
				                  <p>$req_username</p>
				                </div>
				                
				                  <input type='text' id='chat_user' name='chat_username' value='$req_username' style='display:none'>
				                  <button  type='submit' class='btn btn-primary mb-2'><i class='fas fa-paper-plane'></i> Chat</button>
				                  <span class='badge bg-warning p-1'style='font-size:8px;position:relative;'>$num_rows_chat</span>
				                </form>
				          </div>
				        </div>
				      </div>
					</div>
					";
			 	}

			 	else{
			 		echo "
					<div class='container-fluid mb-1'>
				      <div class='row'>
				        <div class='col-md-12'>
				          <div class='friends'>
				            <form method='post'action='current_chat.php' class='friendbox'>
				                <img src='images/$req_image' class='profile_img'>
				                <div class='profile_name'>
				                  <h4> $req_full_name</h4>
				                  <p>$req_username</p>
				                </div>
				                  <input type='text' id='chat_user' name='chat_username' value='$req_username' style='display:none'>
				                  <button type='submit' class='btn btn-primary mb-2 '><i class='fas fa-paper-plane'></i> Chat</button>
				              </div>
				              </form>
				        </div>
				      </div>
					</div>
					";
			 	}
 }
}
else
{
	echo "<div class='row'>
		<div class='col-sm-3'></div>
		<div class='col-sm-6 d-flex justify-content-center align-items-center mt-3 mb-3 bg-white' style='padding-top: 10px;padding-bottom:10px;box-shadow: 0 0 2px;border-radius: 5px; ' data-aos='fade-down'>
				<h5 style='text-align:center'>No Friends To Chat</h5>
		</div>
		<div class='col-sm-3'></div>
	</div>";
}


  	?>
  </div>
  	<div class="col-md-6 p-0" id='chat_list'>
  		<div style="height: 400px;display: flex;justify-content: center;align-items: center;">
  			<div style="width: 200px;padding: 10px;text-align: center;">
  				<h3> <i class="fas fa-comment"></i> <br>Chats apper here</h3>
  			</div>
  		</div>
  	</div>
 </div>


<p id="result" style="display: none;"></p>
<!-- HTML Footer -->
<script type="text/javascript">
	document.getElementById('chat_count').innerHTML = "<?php 
	$sql_chat_count1 = "SELECT * FROM chats WHERE rec_username='$username' && rec_status='false'";
 	$chat_count_res1 = mysqli_query($con,$sql_chat_count1);
 	$num_rows_chat1 = mysqli_num_rows($chat_count_res1);

 	if($num_rows_chat1>0){
 	 	echo"( $num_rows_chat1 )";}
 	?>";
</script>

<?php echo "$html_end";?>
<?php 
if(!($chat_username==$username)){
	echo "<script>
    $(document).ready(function(){
    		 $(`#chat_list`).load(`chat.php`);
    });
</script>
 ";
}
?>

