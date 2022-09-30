<?php 
session_start();
include('config.php'); 

$username = $_SESSION['username'];
$password = $_SESSION['password'];
if(isset($_POST['f_username']))
{
	$_SESSION['f_username'] = $_POST['f_username'];
}
$f_username = $_SESSION['f_username'];

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

	$sql1 = "SELECT * FROM profile WHERE username='$f_username'";
	$rs = $con->query($sql1);
  	$row1 = $rs->fetch_assoc();
  	$first_name = $row1["first_name"];
  	$last_name = $row1["last_name"];
  	$full_name = $row1["first_name"]." ".$row1["last_name"];
  	$bio = $row1["bio"];
  	$image = $row1["image"];


?>
<?php

if(isset($_POST["friend_username"]))
{
	$friend_username = $_POST["friend_username"];

	$reg = "UPDATE  friends SET send_status='false',rec_status='false' WHERE (user_send='$username'&&user_rec='$friend_username')||(user_send='$friend_username'&&user_rec='$username')";
	mysqli_query($con,$reg);

	header("location:friend.php");
}
?>


<!-- HTML Start -->
<?php echo "$html_start";?>
<link rel="stylesheet" type="text/css" href="styles/profile.css">

<link rel="stylesheet" type="text/css" href="styles/friend.css">
</head>
</head>
<body>
<!-- Menu Bar -->
<?php echo"$menu_bar";?>
<style type="text/css">
	#color2
	{
		color:#2496FF;
	}
</style>

<style type="text/css">
		
	.delete_user {
    position: absolute;
    top: 280px;
    left: 120px;
    width: 150px;
    border-radius: 100px;
    color: white;
    background-color: #DB4437;
}
.friendbox{
  display: flex;
  align-items: center;
  padding: 12px;
  min-height: 80px;
  height: auto;
  background-color: #fff;
  border-radius: 8px;
  width: 100%;
  border: 1px solid #03030336;
  border-radius:8px;
}
.profile_img1{
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

.delete_user:hover {
    background-color: white;
    border-style: solid;
    border-color: #DB4437;
}
.view_friends:hover{
	cursor: pointer;
	color: #2496FF;
}
@media screen and (max-width:992px) {
	.delete_user {
        top: 170px;
        left: 15px;
        width: 100px;
        font-size: 12px;
    }
}
</style>
<div class="container-fluid" style="margin-top: 70px; margin-bottom: 20px;">
	<div class="row">
		<div class="col-md-1"></div>
		<div class="col-md-10">
			<div class="profile_box">
				<img src="images/profile_background.jpg" class="back_img">
				<img src="images/<?php echo"$image"?>" class="profile_img">
				<button class="btn delete_user" data-toggle="modal" data-target="#remove_friend"> <i class="fas fa-trash"></i> Remove</button>
				<h1 class="head_text">Friend Profile</h1>
				<div class="username_display">
					<h3><?php echo"$f_username"?></h3>
				</div>
			</div>
			<div class="row ">
				<div class="col-md-5">
					<div class="box_left">
						<div class="profile_name">
							<h3><b><?php echo"$full_name"?></b> <i class="fas fa-check-circle" style="color: #2496FF"></i></h3>
						</div>
						<div class="det_box">
							<div class="total_friend">
								<div data-toggle="modal" data-target="#f_friends" class="view_friends">
									<h2>
										<?php 
									  	$getreq = "SELECT * FROM friends 
									  	WHERE(user_send = '$f_username' || user_rec='$f_username' )&&send_status='true'&&rec_status='true'";
									  	$req_res = mysqli_query($con,$getreq);
									  	$numb_req = mysqli_num_rows($req_res);
									  	echo"$numb_req";?>
									</h2>
									<h4><i class="fas fa-user-friends"></i> Friends</h4>
								</div>
							</div>
							<div class="total_friend">
								<div>
									<h2><?php 
										$swl = "SELECT * FROM posts WHERE username='$f_username'";
										$swl_res = mysqli_query($con,$swl);
										$swl_count = mysqli_num_rows($swl_res);
										echo "  $swl_count ";?>
									</h2>
									<h4><i class="fas fa-mail-bulk"></i> Posts</h4>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-7">
					<div class="box_right">
						<h4>
							<b>About</b>
						</h4>
						<p class="mt-3 about_text">
							<?php echo"$bio"?>
						</p>
						
					</div>
				</div>
			</div>

		</div>
	</div>
</div>

<!-- Modal for removing the friend -->
<div class="modal fade" id="remove_friend" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Remove Friend</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Do you really want to remove <?php echo"$full_name"?> ?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <form method="post">
        	<input type="text" name="friend_username" value="<?php echo"$f_username";?>" style="display: none;">
        <button type="submit" class="btn btn-success">Yes</button>
    	</form>
      </div>
    </div>
  </div>
</div>
<!-- Model for displaying friends of friend -->

<div class="modal fade" id="f_friends" tabindex="-1" role="dialog" aria-labelledby="id2" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="id2">Friends</h5>
        <button  class="close btn btn-white" data-dismiss="modal" aria-label="Close">
          <h1 aria-hidden="true">&times;</h1>
        </button>
      </div>
        <?php 
		$get_friends = "SELECT * FROM friends WHERE (user_send='$f_username'||user_rec='$f_username')&&send_status='true'&&rec_status='true'";
		$get_result = mysqli_query($con,$get_friends);
		$getrows = mysqli_num_rows($get_result);
		if($getrows>0){
		while($row=$get_result->fetch_assoc())
		{
			$user_send = $row["user_send"];
 				if($user_send==$f_username)
 				{
 					$user_send = $row["user_rec"];
 				}
 				$get_each_detail = "SELECT *  FROM profile WHERE username='$user_send'";
 				$get_each_result = mysqli_query($con,$get_each_detail);
 				$show = $get_each_result->fetch_assoc();

 				$ffimage = $show["image"];
 				$ffull_name = $show["full_name"];
 				$fusername = $show["username"];

			 	echo "
		<div class='container-fluid mt-2 mb-2'>
			<div class='row'>
				<div class='col-md-12'>
				    <div class='friends'>
				    	<div class='friendbox'>
				            <img src='images/$ffimage' class='profile_img1'>
				            <div class='profile_name'>
				                <h4> $ffull_name</h4>
				                 <p>$fusername</p>
				            </div>
				        </div>
				    </div>
				 </div>
			</div>
		</div>";
		}
	}
		else
		{
			echo "<div class='container-fluid'>
			<div class='row'>
				<div class='col-md-12'>
				    <div class='friends'>
				    	<div class='friendbox'>
				           
				            <div class='profile_name'>
				                <h4>No Friends</h4>
				            </div>
				        </div>
				    </div>
				 </div>
			</div>
		</div>";
		}

	?>
      
    </div>
  </div>
</div>




<p id="result" style="display: none"></p>
<hr>
	<div class="container-fluid mt-4 mb-5">
		<h2 style="text-align: center;" class="mt-2 mb-3"> Posts <?php 

		$swl = "SELECT * FROM posts WHERE username='$f_username'";
		$swl_res = mysqli_query($con,$swl);
		$swl_count = mysqli_num_rows($swl_res);
		echo " ( $swl_count ) ";?> </h2>
		<?php
			$sql4 = "SELECT * FROM posts WHERE username='$f_username' ORDER BY ID DESC ";
			$rest2 = mysqli_query($con,$sql4);
			$numb = mysqli_num_rows($rest2);

			if($numb>0)
			{
			 while($row = $rest2->fetch_assoc()) 
 				{
 					$p_content = $row["content"];
 					$post_date = $row["date_of_post"];

 					$pieces = explode(" ", $post_date);
 					$piece1 =  explode("-", $pieces[0]);

 					$date1 = $piece1[2];
 					$month1 = $piece1[1];
 					$year1 = $piece1[0];

 					$p_username = $row["username"];
 					$p_id = $row["ID"];
 					$p_likes = $row["likes"];

 					$sql5 = "SELECT * FROM profile WHERE username='$f_username'";
					$rest1 = mysqli_query($con,$sql5);

					$show = $rest1->fetch_assoc();
					$p_image = $show["image"];
					$p_username = $show["username"];

					$y_sql = "SELECT * FROM likes WHERE like_by='$username' && username='$f_username' && status ='1' && post_id='$p_id'";
					$y_res = mysqli_query($con,$y_sql);
					$y_rows = mysqli_num_rows($y_res);
					
					$sqlc = "SELECT * FROM comments WHERE post_id='$p_id'";
					$resc = mysqli_query($con,$sqlc);
					$numc = mysqli_num_rows($resc);
					if($y_rows==0)
					{
						$like_color = "far";
					}
					else
					{
						$like_color = "fas";
					}
					{

 					echo "<div class='container-fluid mt-2 post'>
        <div class='row'>
            <div class='col-md-3'></div>
            <div class='col-md-6'>
                <div class='post_content'>
                    <div class='head1_post'>
                        <img  src='images/$p_image' class='profile_img2 mx-3'>
                        <h4>$p_username</h4>
                    </div>
                    <div class='body_post'>
                        <p>
                            $p_content
                        </p>
                    </div>
                    <div class='footer_post'>
                        <p class='pt-4'>
                            $date1-$month1-$year1
                        </p>
                        <p class='pt-4 icon'>
                            <form method='post' id='form_likes'>
								<input type='number' id='post_id$p_id' value='$p_id' name='post_id$p_id' style='display:none'>
								<input type='text' id='post_username$p_id' value='$f_username' name='post_username$p_id' style='display:none'>
								<input type='text' id='curr_username$p_id' value='$username' name='curr_username$p_id' style='display:none'>
								<p type='submit' class='btn like_btn mt-3' id='$p_id' style='font-size:20px;'> <i class='$like_color fa-heart' style='color:red'></i><span id='like$p_id'>$p_likes</span></p>
							</form>
                            <form action='comments.php' method='post'>
								<input type='number' value='$p_id' name='co_pid' style='display:none'>
								<button type='submit' class='btn p-0 '><i class='far fa-comment'></i> $numc</button>
							</form>
                        </p>
                    </div>
                </div>
            </div>
            <div class='col-md-3'></div>
        </div>
    </div>
";
	}
}
}
		?>
		</div>
		<div id="result1"></div>
		<span id="result2"></span>

<!-- HTML Footer -->
<script src="https://cdn.tiny.cloud/1/pj6e88figarznx3v7nvzj9yzcu4kn09m85lgliqe4cgsbixa/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

  <script>
    tinymce.init({
      selector: 'textarea',
      menubar:false,
      height:300,
      tinycomments_mode: 'embedded',
      tinycomments_author: 'Author name',
   });
  </script>
<script type="text/javascript">
	document.getElementById('chat_count').innerHTML = "<?php 
	$sql_chat_count1 = "SELECT * FROM chats WHERE rec_username='$username' && rec_status='false'";
 	$chat_count_res1 = mysqli_query($con,$sql_chat_count1);
 	$num_rows_chat1 = mysqli_num_rows($chat_count_res1);

 	if($num_rows_chat1>0){
 	 	echo"$num_rows_chat1";}
 	?>";
</script>
<?php echo "$html_end";?>
<script>
  $(document).ready(function () {
    $('.like_btn').click(function (e) {

      e.preventDefault();
    	var id = $(this).attr('id');
    	var p="post_id"+id;
    	var q="post_username"+id;
    	var r="curr_username"+id;
      var post_id = document.getElementById(p).value;
      var post_username =document.getElementById(q).value;
      var curr_username = document.getElementById(r).value;

      $.ajax
        ({
          type: "POST",
          url: "like.php",
          data: { "post_id": post_id, "post_username": post_username, "curr_username": curr_username },
          success: function (data) {
          	 $('#result').html(data);
          	 var t = document.getElementById('result').innerHTML ;
          	 var i = "like"+id;
          	 var c = document.getElementById(i).innerHTML;
          	
          	 if(t=="far")
          	 {
          	    c--;
          	 }
          	 else
          	 {
          	 	c++;
          	 }
          	 document.getElementById(post_id).innerHTML = "<i class='"+t+" fa-heart' style='color:red'></i> <span id='like"+id+"'>"+c+"</span>";

          }
        });
    });
  });
</script>