<?php 
session_start();

$con = new mysqli("localhost","root","", "pinchat");

$username = $_SESSION['username'];
$password = $_SESSION['password'];

if(isset($_POST["post_username"])){
$post_username = $_POST["post_username"];
	$curr_username = $_POST["curr_username"];
	$post_id = $_POST["post_id"];

	$check_status = "SELECT * FROM likes WHERE username='$post_username'&& like_by='$curr_username'&&post_id='$post_id'";
	$check_res = mysqli_query($con,$check_status);
	$check_num = mysqli_num_rows($check_res);

	if($check_num==1){
		$show = $check_res->fetch_assoc();
		$status_u = $show["status"];
		if($status_u=='1')
		{
			$u_sql = "UPDATE likes SET status='0' WHERE username='$post_username'&& like_by='$curr_username'&&post_id='$post_id'";
			$u_result = mysqli_query($con,$u_sql);
		}
		else
		{
			$u_sql = "UPDATE likes SET status='1' WHERE username='$post_username'&& like_by='$curr_username'&&post_id='$post_id'";
			$u_result = mysqli_query($con,$u_sql);
		}
	}
	else{
	$sql_l = "INSERT INTO likes(username,like_by,post_id,status)VALUES('$post_username','$curr_username','$post_id','1')";

	$check = mysqli_query($con,$sql_l);


}
$get_likes = "SELECT * FROM likes WHERE post_id='$post_id' && status='1'";
	$likes_count = mysqli_query($con,$get_likes);
	$num_likes = mysqli_num_rows($likes_count);

	$z_sql = "UPDATE posts SET likes='$num_likes' WHERE ID='$post_id'";
	$z_res = mysqli_query($con,$z_sql);

	$y_sql = "SELECT * FROM likes WHERE like_by='$curr_username' && username='$post_username' && status ='1' && post_id='$post_id'";
					$y_res = mysqli_query($con,$y_sql);
					$y_rows = mysqli_num_rows($y_res);
					if($y_rows==0)
					{
						$like_color = "far";
						echo "$like_color";
					}
					else
					{
						$like_color = "fas";
						echo "$like_color";
					}
}

?>