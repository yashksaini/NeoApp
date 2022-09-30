<?php 
	session_start();
 	include('config.php'); 

	$username = $_SESSION['username'];
	$password = $_SESSION['password'];
	$chat_username = $_SESSION['chat_username'] ;

	$sql = "SELECT * FROM users WHERE username='$username' && password='$password'";
	$re = mysqli_query($con,$sql);
	$number = mysqli_num_rows($re);

	if($number!=1)
	{
  		header('location:index.php');
	}
	$sql1 = "SELECT * FROM profile WHERE username='$chat_username' ";
	$re1 = mysqli_query($con,$sql1);
	$rs1 = $con->query($sql1);
	$rows = $rs1->fetch_assoc();
	$chat_imagei = $rows["image"];
	$chat_full_name = $rows["full_name"];

	$sql_tik = "UPDATE chats SET rec_status='true' WHERE send_username='$chat_username'&&rec_username='$username'";
	$tic_res = mysqli_query($con,$sql_tik);
	if(isset($_POST['chat_text']))
	{
		$chat_text = $_POST['chat_text'];
		$sql_l = "INSERT INTO chats(send_username,rec_username,content)VALUES('$username','$chat_username','$chat_text')";
		$check = mysqli_query($con,$sql_l);

		$sql_friend = "UPDATE friends SET timestamp=now()  WHERE (user_send='$username'&&user_rec='$chat_username')||(user_send='$chat_username'&&user_rec='$username')";
		$u_friend = mysqli_query($con,$sql_friend);
	}

?>